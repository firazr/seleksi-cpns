<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\TestSession;
use Illuminate\Http\Request;

class TestCpnsController extends Controller
{
    /**
     * List of available domisili for placement
     */
    protected $domisiliList = [
        'Jakarta',
        'Bandung',
        'Surabaya',
        'Yogyakarta',
        'Semarang',
        'Medan',
        'Makassar',
        'Palembang',
        'Denpasar',
        'Pontianak',
    ];

    /**
     * Display the test CPNS page with user info and test options
     */
    public function index()
    {
        $user = auth()->user();
        $domisiliList = $this->domisiliList;
        
        // Check if user has already completed the test
        $completedSessions = TestSession::where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->get();

        if ($completedSessions->count() > 0) {
            // User already completed, show the index with completed info
            return view('test-cpns.index', compact('user', 'domisiliList', 'completedSessions'));
        }
        
        // Check if user has an active (unfinished) session
        $activeSession = TestSession::where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if ($activeSession && $activeSession->isActive()) {
            return redirect()->route('quiz.show', $activeSession);
        }
        
        // If active session expired, mark it as finished
        if ($activeSession && !$activeSession->isActive()) {
            $this->calculateAndFinishSession($activeSession);
            $completedSessions = TestSession::where('user_id', $user->id)
                ->whereNotNull('finished_at')
                ->get();
            return view('test-cpns.index', compact('user', 'domisiliList', 'completedSessions'));
        }

        $completedSessions = collect(); // Empty collection
        return view('test-cpns.index', compact('user', 'domisiliList', 'completedSessions'));
    }

    /**
     * Start a new test session (Paket Lengkap only)
     */
    public function start(Request $request)
    {
        $validated = $request->validate([
            'domisili_penempatan' => 'required|string|in:' . implode(',', $this->domisiliList),
        ]);

        $user = auth()->user();

        // Check if user has already completed a test
        $completedSession = TestSession::where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->first();

        if ($completedSession) {
            return redirect()->route('test-cpns.index')
                ->with('error', 'Anda sudah pernah mengikuti ujian dan tidak dapat mengerjakan lagi.');
        }

        // Check if user has an active session
        $activeSession = TestSession::where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if ($activeSession) {
            if (!$activeSession->isActive()) {
                $this->calculateAndFinishSession($activeSession);
                return redirect()->route('test-cpns.index');
            } else {
                return redirect()->route('quiz.show', $activeSession);
            }
        }

        // Generate shuffled questions with shuffled options
        $shuffledData = $this->generateShuffledQuestions();
        
        if (empty($shuffledData)) {
            return redirect()->route('test-cpns.index')
                ->with('error', 'Belum ada soal yang tersedia.');
        }

        // Create new session with shuffled data
        $session = TestSession::create([
            'user_id' => $user->id,
            'domisili_penempatan' => $validated['domisili_penempatan'],
            'category' => 'FULL', // Always full package
            'started_at' => now(),
            'answers' => [],
            'shuffled_questions' => $shuffledData,
        ]);

        return redirect()->route('quiz.show', $session);
    }

    /**
     * Generate shuffled questions with shuffled options
     * Returns array of question data with shuffled option order
     */
    protected function generateShuffledQuestions(): array
    {
        $categories = ['TWK', 'TIU', 'TKP'];
        $shuffledData = [];
        
        foreach ($categories as $category) {
            // Get questions for this category and shuffle them
            $questions = Question::where('category', $category)->get()->shuffle();
            
            foreach ($questions as $question) {
                // Create shuffled options
                $options = [
                    ['key' => 'a', 'text' => $question->option_a],
                    ['key' => 'b', 'text' => $question->option_b],
                    ['key' => 'c', 'text' => $question->option_c],
                    ['key' => 'd', 'text' => $question->option_d],
                ];
                
                // Shuffle the options
                shuffle($options);
                
                // Create mapping: display position => original key
                $optionMapping = [];
                $displayOptions = [];
                $displayLabels = ['a', 'b', 'c', 'd'];
                
                foreach ($options as $idx => $opt) {
                    $displayLabel = $displayLabels[$idx];
                    $optionMapping[$displayLabel] = $opt['key']; // display 'a' maps to original 'c', etc.
                    $displayOptions[$displayLabel] = $opt['text'];
                }
                
                $shuffledData[] = [
                    'question_id' => $question->id,
                    'category' => $question->category,
                    'question_text' => $question->question_text,
                    'image_path' => $question->image_path,
                    'is_math' => $question->is_math,
                    'math_latex' => $question->math_latex,
                    'options' => $displayOptions, // Shuffled options with a,b,c,d keys
                    'option_mapping' => $optionMapping, // Maps display key to original key
                    'correct_display' => array_search($question->correct_option, $optionMapping), // Which display option is correct
                ];
            }
        }
        
        return $shuffledData;
    }

    /**
     * Calculate score and finish session
     */
    protected function calculateAndFinishSession(TestSession $session): void
    {
        $shuffledData = $session->shuffled_questions ?? [];
        $answers = $session->answers ?? [];
        
        $scores = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0];
        $counts = ['TWK' => 0, 'TIU' => 0, 'TKP' => 0];
        
        foreach ($shuffledData as $idx => $qData) {
            $category = $qData['category'];
            $counts[$category]++;
            
            $userAnswer = $answers[$idx] ?? null;
            if ($userAnswer && isset($qData['correct_display']) && $userAnswer === $qData['correct_display']) {
                $scores[$category]++;
            }
        }
        
        // Calculate percentage per category
        $twkScore = $counts['TWK'] > 0 ? round(($scores['TWK'] / $counts['TWK']) * 100, 1) : 0;
        $tiuScore = $counts['TIU'] > 0 ? round(($scores['TIU'] / $counts['TIU']) * 100, 1) : 0;
        $tkpScore = $counts['TKP'] > 0 ? round(($scores['TKP'] / $counts['TKP']) * 100, 1) : 0;
        
        // Total score is average of all categories
        $totalScore = round(($twkScore + $tiuScore + $tkpScore) / 3, 1);
        
        $session->update([
            'finished_at' => now(),
            'score' => $totalScore,
            'score_twk' => $twkScore,
            'score_tiu' => $tiuScore,
            'score_tkp' => $tkpScore,
        ]);
    }
}

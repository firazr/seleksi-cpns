<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\TestSession;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Show the quiz page
     */
    public function show(TestSession $session)
    {
        // Ensure session belongs to current user
        if ($session->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if session is already completed
        if ($session->isCompleted()) {
            return redirect()->route('quiz.result', $session);
        }

        // Check if time has expired
        if (!$session->isActive()) {
            $this->autoSubmit($session);
            return redirect()->route('quiz.result', $session);
        }

        // Get shuffled questions from session
        $shuffledQuestions = $session->shuffled_questions ?? [];

        if (empty($shuffledQuestions)) {
            return redirect()->route('test-cpns.index')
                ->with('error', 'Terjadi kesalahan pada sesi ujian.');
        }

        $answers = $session->answers ?? [];
        
        // Group questions by category for display
        $questionsByCategory = [];
        foreach ($shuffledQuestions as $idx => $q) {
            $cat = $q['category'];
            if (!isset($questionsByCategory[$cat])) {
                $questionsByCategory[$cat] = [];
            }
            $questionsByCategory[$cat][] = array_merge($q, ['index' => $idx]);
        }

        return view('quiz.show', compact('session', 'shuffledQuestions', 'answers', 'questionsByCategory'));
    }

    /**
     * Save answer for a question (AJAX)
     */
    public function saveAnswer(Request $request, TestSession $session)
    {
        if ($session->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($session->isCompleted() || !$session->isActive()) {
            return response()->json(['success' => false, 'message' => 'Session has ended'], 400);
        }

        $validated = $request->validate([
            'question_index' => 'required|integer|min:0',
            'answer' => 'required|in:a,b,c,d',
        ]);

        $answers = $session->answers ?? [];
        $answers[$validated['question_index']] = $validated['answer'];
        
        $session->update(['answers' => $answers]);

        return response()->json(['success' => true, 'message' => 'Answer saved']);
    }

    /**
     * Submit the quiz
     */
    public function submit(Request $request, TestSession $session)
    {
        if ($session->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($session->isCompleted()) {
            return redirect()->route('quiz.result', $session);
        }

        // Save answers from form
        $formAnswers = $request->input('answers', []);
        $session->update(['answers' => $formAnswers]);

        // Calculate score
        $this->calculateAndFinishSession($session);

        return redirect()->route('quiz.result', $session);
    }

    /**
     * Show quiz result
     */
    public function result(TestSession $session)
    {
        if ($session->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if (!$session->isCompleted()) {
            return redirect()->route('quiz.show', $session);
        }

        $shuffledQuestions = $session->shuffled_questions ?? [];
        $answers = $session->answers ?? [];
        
        // Build detailed results
        $questionResults = [];
        $categoryStats = [
            'TWK' => ['correct' => 0, 'total' => 0],
            'TIU' => ['correct' => 0, 'total' => 0],
            'TKP' => ['correct' => 0, 'total' => 0],
        ];
        
        foreach ($shuffledQuestions as $idx => $qData) {
            $category = $qData['category'];
            $categoryStats[$category]['total']++;
            
            $userAnswer = $answers[$idx] ?? null;
            $isCorrect = $userAnswer && $userAnswer === $qData['correct_display'];
            
            if ($isCorrect) {
                $categoryStats[$category]['correct']++;
            }
            
            // Get original answer text for display
            $originalKey = $userAnswer ? ($qData['option_mapping'][$userAnswer] ?? null) : null;
            
            $questionResults[] = [
                'index' => $idx,
                'category' => $category,
                'question_text' => $qData['question_text'],
                'image_path' => $qData['image_path'] ?? null,
                'is_math' => $qData['is_math'] ?? false,
                'math_latex' => $qData['math_latex'] ?? null,
                'options' => $qData['options'],
                'user_answer' => $userAnswer,
                'correct_answer' => $qData['correct_display'],
                'is_correct' => $isCorrect,
            ];
        }
        
        $total = count($shuffledQuestions);
        $correct = array_sum(array_column($categoryStats, 'correct'));
        $wrong = $total - $correct;

        return view('quiz.result', compact(
            'session', 
            'questionResults', 
            'categoryStats',
            'total', 
            'correct', 
            'wrong'
        ));
    }

    /**
     * Auto submit when time expires
     */
    protected function autoSubmit(TestSession $session)
    {
        if (!$session->isCompleted()) {
            $this->calculateAndFinishSession($session);
        }
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

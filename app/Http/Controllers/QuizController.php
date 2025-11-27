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

        // Get questions based on category
        $questions = Question::byCategory($session->category)
            ->inRandomOrder()
            ->get();

        if ($questions->isEmpty()) {
            return redirect()->route('test-cpns.index')
                ->with('error', 'Belum ada soal untuk kategori ini.');
        }

        $answers = $session->answers ?? [];

        return view('quiz.show', compact('session', 'questions', 'answers'));
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
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|in:a,b,c,d',
        ]);

        $answers = $session->answers ?? [];
        $answers[$validated['question_id']] = $validated['answer'];
        
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
        $score = $this->calculateScore($session);

        $session->update([
            'finished_at' => now(),
            'score' => $score,
        ]);

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

        $questions = Question::byCategory($session->category)->get();
        $answers = $session->answers ?? [];
        
        $total = $questions->count();
        $correct = 0;
        
        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            if ($userAnswer && strtoupper($userAnswer) === strtoupper($question->correct_option)) {
                $correct++;
            }
        }
        
        $wrong = $total - $correct;
        $score = $session->score ?? ($total > 0 ? round(($correct / $total) * 100, 1) : 0);

        return view('quiz.result', compact('session', 'score', 'correct', 'wrong', 'total'));
    }

    /**
     * Auto submit when time expires
     */
    protected function autoSubmit(TestSession $session)
    {
        if (!$session->isCompleted()) {
            $score = $this->calculateScore($session);
            $session->update([
                'finished_at' => now(),
                'score' => $score,
            ]);
        }
    }

    /**
     * Calculate score
     */
    protected function calculateScore(TestSession $session): int
    {
        $questions = Question::byCategory($session->category)->get();
        $answers = $session->answers ?? [];
        
        $score = 0;
        $pointsPerQuestion = 100 / max(1, $questions->count());

        foreach ($questions as $question) {
            if (isset($answers[$question->id]) && $question->isCorrect($answers[$question->id])) {
                $score += $pointsPerQuestion;
            }
        }

        return round($score);
    }
}

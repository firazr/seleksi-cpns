<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of questions
     */
    public function index(Request $request)
    {
        $query = Question::query()->latest();
        
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }
        
        $questions = $query->paginate(10);
        
        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Store a new question
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:TWK,TIU,TKP',
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:500',
            'option_b' => 'required|string|max:500',
            'option_c' => 'required|string|max:500',
            'option_d' => 'required|string|max:500',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        Question::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Soal berhasil ditambahkan']);
        }

        return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil ditambahkan');
    }

    /**
     * Update a question
     */
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'category' => 'required|in:TWK,TIU,TKP',
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:500',
            'option_b' => 'required|string|max:500',
            'option_c' => 'required|string|max:500',
            'option_d' => 'required|string|max:500',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $question->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Soal berhasil diupdate']);
        }

        return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil diupdate');
    }

    /**
     * Delete a question
     */
    public function destroy(Question $question)
    {
        $question->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Soal berhasil dihapus']);
        }

        return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        
        if ($request->has('search') && $request->search) {
            $query->where('question_text', 'like', '%' . $request->search . '%');
        }
        
        $questions = $query->paginate(10);
        
        // Get counts for statistics
        $twkCount = Question::where('category', 'TWK')->count();
        $tiuCount = Question::where('category', 'TIU')->count();
        $tkpCount = Question::where('category', 'TKP')->count();
        
        return view('admin.questions.index', compact('questions', 'twkCount', 'tiuCount', 'tkpCount'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_math' => 'nullable|boolean',
            'math_latex' => 'nullable|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('questions', 'public');
        }
        
        $validated['is_math'] = $request->has('is_math');

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_math' => 'nullable|boolean',
            'math_latex' => 'nullable|string',
            'remove_image' => 'nullable|boolean',
        ]);

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($question->image_path) {
                Storage::disk('public')->delete($question->image_path);
            }
            $validated['image_path'] = null;
        }
        
        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($question->image_path) {
                Storage::disk('public')->delete($question->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('questions', 'public');
        }
        
        $validated['is_math'] = $request->has('is_math');

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
        // Delete image if exists
        if ($question->image_path) {
            Storage::disk('public')->delete($question->image_path);
        }
        
        $question->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Soal berhasil dihapus']);
        }

        return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of news
     */
    public function index(Request $request)
    {
        $query = News::query()->latest();
        
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }
        
        if ($request->has('domisili') && $request->domisili) {
            $query->byDomisili($request->domisili);
        }
        
        $news = $query->paginate(9);
        
        return view('berita.index', compact('news'));
    }

    /**
     * Get single news item (for AJAX)
     */
    public function show(News $news)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $news
            ]);
        }
        
        return view('berita.show', compact('news'));
    }

    /**
     * Store a new news item (Admin only)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:tahapan,tata_cara,pengumuman',
            'content' => 'required|string',
            'domisili' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

        News::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Berita berhasil ditambahkan']);
        }

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    /**
     * Update a news item (Admin only)
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:tahapan,tata_cara,pengumuman',
            'content' => 'required|string',
            'domisili' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Berita berhasil diupdate']);
        }

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate');
    }

    /**
     * Delete a news item (Admin only)
     */
    public function destroy(News $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }
        
        $news->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Berita berhasil dihapus']);
        }

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * List of available domisili
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
        $domisiliList = $this->domisiliList;
        
        // Get test results if domisili_hasil is selected
        $hasilTest = collect();
        $selectedDomisili = $request->get('domisili_hasil');
        
        if ($selectedDomisili) {
            $hasilTest = TestSession::with('user')
                ->where('domisili_penempatan', $selectedDomisili)
                ->whereNotNull('finished_at')
                ->orderByDesc('score')
                ->orderBy('finished_at')
                ->get();
        }
        
        return view('berita.index', compact('news', 'domisiliList', 'hasilTest', 'selectedDomisili'));
    }

    /**
     * Get test results by domisili (AJAX)
     */
    public function getHasilTest(Request $request)
    {
        $domisili = $request->get('domisili');
        
        if (!$domisili) {
            return response()->json(['success' => false, 'message' => 'Domisili tidak dipilih']);
        }
        
        $hasilTest = TestSession::with('user')
            ->where('domisili_penempatan', $domisili)
            ->whereNotNull('finished_at')
            ->orderByDesc('score')
            ->orderBy('finished_at')
            ->get()
            ->map(function ($session, $index) {
                return [
                    'rank' => $index + 1,
                    'participant_number' => $session->user->participant_number ?? '-',
                    'name' => $session->user->name,
                    'category' => $session->category,
                    'domisili_penempatan' => $session->domisili_penempatan,
                    'score' => $session->score,
                    'finished_at' => $session->finished_at->format('d M Y H:i'),
                ];
            });
        
        return response()->json([
            'success' => true,
            'data' => $hasilTest,
            'count' => $hasilTest->count()
        ]);
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

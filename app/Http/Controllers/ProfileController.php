<?php

namespace App\Http\Controllers;

use App\Models\TestSession;
use Illuminate\Http\Request;

class ProfileController extends Controller
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
     * Display the profile/kementrian information page
     */
    public function index(Request $request)
    {
        $domisiliList = $this->domisiliList;
        $selectedDomisili = $request->get('domisili');
        $results = null;

        if ($selectedDomisili) {
            $results = TestSession::with('user')
                ->byDomisiliPenempatan($selectedDomisili)
                ->completed()
                ->orderBy('score', 'desc')
                ->get();
        }

        return view('profil.index', compact('domisiliList', 'selectedDomisili', 'results'));
    }

    /**
     * Get results by domisili (AJAX)
     */
    public function getResults(Request $request)
    {
        $domisili = $request->get('domisili');
        
        if (!$domisili) {
            return response()->json(['success' => false, 'message' => 'Domisili diperlukan']);
        }

        $results = TestSession::with('user')
            ->byDomisiliPenempatan($domisili)
            ->completed()
            ->orderBy('score', 'desc')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'participant_number' => $session->user->participant_number,
                    'name' => $session->user->name,
                    'category' => $session->category_label,
                    'score' => $session->score,
                    'finished_at' => $session->finished_at->format('d M Y H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $results,
            'domisili' => $domisili,
        ]);
    }
}

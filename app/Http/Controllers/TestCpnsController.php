<?php

namespace App\Http\Controllers;

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
        
        // Check if user has an active (unfinished) session
        $activeSession = TestSession::where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if ($activeSession && $activeSession->isActive()) {
            return redirect()->route('quiz.show', $activeSession);
        }

        return view('test-cpns.index', compact('user', 'domisiliList'));
    }

    /**
     * Start a new test session
     */
    public function start(Request $request)
    {
        $validated = $request->validate([
            'domisili_penempatan' => 'required|string|in:' . implode(',', $this->domisiliList),
            'category' => 'required|string|in:TWK,TIU,TKP,full',
        ]);

        $user = auth()->user();

        // Check if user has an active session
        $activeSession = TestSession::where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if ($activeSession) {
            // If time has expired, mark it as finished with score 0
            if (!$activeSession->isActive()) {
                $activeSession->update([
                    'finished_at' => now(),
                    'score' => 0,
                ]);
            } else {
                // Continue existing session
                return redirect()->route('quiz.show', $activeSession);
            }
        }

        // Create new session
        $session = TestSession::create([
            'user_id' => $user->id,
            'domisili_penempatan' => $validated['domisili_penempatan'],
            'category' => $validated['category'],
            'started_at' => now(),
            'answers' => [],
        ]);

        return redirect()->route('quiz.show', $session);
    }
}

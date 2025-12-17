<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestSession;
use App\Models\Question;
use App\Models\News;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with monitoring data
     */
    public function index(): View
    {
        $totalUsers = User::where('role', 'peserta')->count();
        $activeUsers = User::where('role', 'peserta')
            ->whereHas('testSessions', function ($query) {
                $query->whereNull('finished_at');
            })
            ->count();
        $completedTests = TestSession::whereNotNull('finished_at')->count();
        $totalQuestions = Question::count();
        $totalNews = News::count();

        // Peserta yang sudah mengerjakan test
        $pesertaResults = TestSession::with('user')
            ->whereNotNull('finished_at')
            ->orderByDesc('finished_at')
            ->paginate(10);

        // Semua peserta dengan status test mereka
        $allPeserta = User::where('role', 'peserta')
            ->with('testSessions')
            ->orderByDesc('created_at')
            ->paginate(15);

        // Soal berdasarkan kategori
        $questionsByCategory = Question::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->get();

        // Stats untuk chart
        $testStats = TestSession::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereNotNull('finished_at')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'completedTests' => $completedTests,
            'totalQuestions' => $totalQuestions,
            'totalNews' => $totalNews,
            'pesertaResults' => $pesertaResults,
            'allPeserta' => $allPeserta,
            'questionsByCategory' => $questionsByCategory,
            'testStats' => $testStats,
        ]);
    }

    /**
     * Create new admin account
     */
    public function storeAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin baru berhasil dibuat!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GROQ_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Key belum dikonfigurasi'
            ], 500);
        }

        try {
            // Menggunakan Groq API (gratis) dengan model Llama 3
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Kamu adalah asisten virtual Portal Seleksi CPNS Indonesia. Kamu membantu pengguna menggunakan website ini.

TENTANG WEBSITE INI:
Website ini adalah platform resmi untuk seleksi CPNS (Calon Pegawai Negeri Sipil) yang menyediakan:
1. Tes CAT (Computer Assisted Test) online dengan 3 jenis soal: TWK, TIU, dan TKP
2. Sistem penilaian otomatis
3. Pengumuman hasil tes berdasarkan domisili

CARA MENDAFTAR:
1. Klik tombol "Daftar Sekarang" di halaman utama atau menu "Register"
2. Isi data diri: Nama lengkap, NIK, Email, Password, Tanggal lahir, dan Domisili (provinsi)
3. Klik "Daftar" untuk membuat akun
4. Setelah berhasil, login dengan email dan password yang didaftarkan

CARA MENGIKUTI TES:
1. Login ke akun Anda
2. Klik menu "Tes CPNS" atau tombol "Mulai Tes" di halaman utama
3. Pilih jenis tes yang ingin dikerjakan (TWK/TIU/TKP)
4. Klik "Mulai Tes" - timer akan berjalan otomatis
5. Jawab semua soal dengan memilih salah satu opsi
6. Klik "Submit" setelah selesai atau waktu habis akan otomatis submit
7. Lihat hasil dan skor di halaman hasil

TENTANG TES:
- TWK (Tes Wawasan Kebangsaan): Soal tentang Pancasila, UUD 1945, NKRI, Bhinneka Tunggal Ika
- TIU (Tes Intelegensia Umum): Soal logika, numerik, verbal, analitis
- TKP (Tes Karakteristik Pribadi): Soal tentang kepribadian dan sikap kerja

FITUR LAINNYA:
- Menu "Berita": Lihat pengumuman dan hasil tes berdasarkan domisili
- Menu "Profil": Lihat riwayat tes dan skor Anda

Jawab dengan bahasa Indonesia yang ramah dan jelas. Jika ditanya di luar konteks website/CPNS, arahkan kembali dengan sopan.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $botReply = $data['choices'][0]['message']['content'] ?? 'Maaf, saya tidak bisa memproses permintaan Anda saat ini.';

                return response()->json([
                    'success' => true,
                    'message' => $botReply
                ]);
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? 'Terjadi kesalahan pada API';
                
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $errorMessage
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}

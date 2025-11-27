<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Pengumuman Pendaftaran CPNS 2025 Resmi Dibuka',
                'category' => 'pengumuman',
                'content' => 'Badan Kepegawaian Negara (BKN) resmi membuka pendaftaran Calon Pegawai Negeri Sipil (CPNS) tahun 2025. Pendaftaran dapat dilakukan melalui portal resmi SSCASN mulai tanggal 1 Desember 2025. Pastikan Anda mempersiapkan dokumen yang diperlukan seperti KTP, Ijazah, dan dokumen pendukung lainnya. Formasi yang tersedia meliputi berbagai instansi pemerintah pusat dan daerah.',
                'domisili' => 'Semua',
            ],
            [
                'title' => 'Tahapan Seleksi CPNS 2025 yang Perlu Diketahui',
                'category' => 'tahapan',
                'content' => 'Seleksi CPNS 2025 terdiri dari beberapa tahapan: 1) Seleksi Administrasi - verifikasi dokumen dan persyaratan, 2) Seleksi Kompetensi Dasar (SKD) - meliputi TWK, TIU, dan TKP dengan sistem CAT, 3) Seleksi Kompetensi Bidang (SKB) - sesuai dengan formasi yang dipilih, 4) Pemberkasan - pengumpulan dokumen asli bagi yang lolos. Setiap tahapan memiliki passing grade yang harus dipenuhi.',
                'domisili' => 'Semua',
            ],
            [
                'title' => 'Panduan Lengkap Tata Cara Pendaftaran CPNS Online',
                'category' => 'tata_cara',
                'content' => 'Berikut tata cara pendaftaran CPNS secara online: 1) Buat akun di portal SSCASN, 2) Login dan lengkapi data diri, 3) Unggah dokumen persyaratan (foto, KTP, ijazah, transkrip), 4) Pilih formasi yang diminati, 5) Cetak kartu pendaftaran. Pastikan data yang diinput benar dan sesuai dengan dokumen asli. Kesalahan data dapat mengakibatkan diskualifikasi.',
                'domisili' => 'Semua',
            ],
            [
                'title' => 'Tips Sukses Menghadapi Tes CAT CPNS',
                'category' => 'tata_cara',
                'content' => 'Untuk sukses menghadapi tes CAT CPNS, perhatikan tips berikut: 1) Pelajari materi TWK, TIU, dan TKP secara menyeluruh, 2) Latihan soal-soal tahun sebelumnya, 3) Manajemen waktu sangat penting - jangan terlalu lama di satu soal, 4) Istirahat cukup sebelum hari H, 5) Datang lebih awal ke lokasi tes, 6) Baca soal dengan teliti sebelum menjawab.',
                'domisili' => 'Semua',
            ],
            [
                'title' => 'Formasi CPNS 2025 untuk Wilayah DKI Jakarta',
                'category' => 'pengumuman',
                'content' => 'Pemerintah Provinsi DKI Jakarta membuka formasi CPNS 2025 untuk berbagai jabatan. Formasi meliputi tenaga kesehatan, tenaga pendidikan, dan tenaga teknis lainnya. Pelamar harus memiliki domisili di DKI Jakarta atau bersedia ditempatkan di wilayah DKI Jakarta. Informasi lengkap formasi dapat dilihat di portal resmi SSCASN.',
                'domisili' => 'Jakarta',
            ],
            [
                'title' => 'Jadwal Pelaksanaan SKD CPNS 2025',
                'category' => 'tahapan',
                'content' => 'Seleksi Kompetensi Dasar (SKD) CPNS 2025 dijadwalkan akan dilaksanakan mulai bulan Januari 2026. Peserta yang lolos seleksi administrasi akan menerima kartu peserta ujian dan informasi lokasi tes melalui email. Pastikan untuk memeriksa jadwal secara berkala di portal SSCASN.',
                'domisili' => 'Semua',
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            // TWK - Tes Wawasan Kebangsaan
            [
                'category' => 'TWK',
                'question_text' => 'Pancasila sebagai dasar negara Indonesia tercantum dalam pembukaan UUD 1945 alinea ke...?',
                'option_a' => 'Pertama',
                'option_b' => 'Kedua',
                'option_c' => 'Ketiga',
                'option_d' => 'Keempat',
                'correct_option' => 'd',
            ],
            [
                'category' => 'TWK',
                'question_text' => 'Lambang negara Indonesia adalah...?',
                'option_a' => 'Bhinneka Tunggal Ika',
                'option_b' => 'Garuda Pancasila',
                'option_c' => 'Burung Cendrawasih',
                'option_d' => 'Burung Elang',
                'correct_option' => 'b',
            ],
            [
                'category' => 'TWK',
                'question_text' => 'Proklamasi Kemerdekaan Indonesia dibacakan pada tanggal...?',
                'option_a' => '17 Agustus 1945',
                'option_b' => '18 Agustus 1945',
                'option_c' => '20 Mei 1945',
                'option_d' => '1 Juni 1945',
                'correct_option' => 'a',
            ],
            [
                'category' => 'TWK',
                'question_text' => 'Sila ke-3 Pancasila berbunyi...?',
                'option_a' => 'Kemanusiaan yang adil dan beradab',
                'option_b' => 'Persatuan Indonesia',
                'option_c' => 'Keadilan sosial bagi seluruh rakyat Indonesia',
                'option_d' => 'Kerakyatan yang dipimpin oleh hikmat kebijaksanaan',
                'correct_option' => 'b',
            ],
            [
                'category' => 'TWK',
                'question_text' => 'Hari lahir Pancasila diperingati setiap tanggal...?',
                'option_a' => '17 Agustus',
                'option_b' => '1 Juni',
                'option_c' => '20 Mei',
                'option_d' => '28 Oktober',
                'correct_option' => 'b',
            ],

            // TIU - Tes Intelegensi Umum
            [
                'category' => 'TIU',
                'question_text' => 'Jika 2x + 5 = 15, maka nilai x adalah...?',
                'option_a' => '3',
                'option_b' => '4',
                'option_c' => '5',
                'option_d' => '6',
                'correct_option' => 'c',
            ],
            [
                'category' => 'TIU',
                'question_text' => 'Sinonim dari kata "ANOMALI" adalah...?',
                'option_a' => 'Normal',
                'option_b' => 'Penyimpangan',
                'option_c' => 'Kesamaan',
                'option_d' => 'Keteraturan',
                'correct_option' => 'b',
            ],
            [
                'category' => 'TIU',
                'question_text' => 'Antonim dari kata "OPTIMIS" adalah...?',
                'option_a' => 'Realistis',
                'option_b' => 'Idealis',
                'option_c' => 'Pesimis',
                'option_d' => 'Materialis',
                'correct_option' => 'c',
            ],
            [
                'category' => 'TIU',
                'question_text' => '25% dari 200 adalah...?',
                'option_a' => '25',
                'option_b' => '40',
                'option_c' => '50',
                'option_d' => '75',
                'correct_option' => 'c',
            ],
            [
                'category' => 'TIU',
                'question_text' => 'Deret angka: 2, 6, 18, 54, ... Angka selanjutnya adalah...?',
                'option_a' => '108',
                'option_b' => '162',
                'option_c' => '216',
                'option_d' => '324',
                'correct_option' => 'b',
            ],

            // TKP - Tes Karakteristik Pribadi
            [
                'category' => 'TKP',
                'question_text' => 'Ketika mendapat kritik dari atasan, sikap Anda adalah...?',
                'option_a' => 'Marah dan tidak terima',
                'option_b' => 'Diam saja dan mengabaikan',
                'option_c' => 'Menerima dengan lapang dada dan memperbaiki diri',
                'option_d' => 'Membalas kritik tersebut',
                'correct_option' => 'c',
            ],
            [
                'category' => 'TKP',
                'question_text' => 'Jika ada rekan kerja yang kesulitan menyelesaikan tugas, Anda akan...?',
                'option_a' => 'Membiarkan saja karena bukan tanggung jawab Anda',
                'option_b' => 'Menawarkan bantuan jika diperlukan',
                'option_c' => 'Mengerjakan tugas Anda sendiri saja',
                'option_d' => 'Melaporkan ke atasan',
                'correct_option' => 'b',
            ],
            [
                'category' => 'TKP',
                'question_text' => 'Dalam bekerja dalam tim, sikap Anda adalah...?',
                'option_a' => 'Mengerjakan bagian sendiri tanpa koordinasi',
                'option_b' => 'Mendominasi semua keputusan',
                'option_c' => 'Berkolaborasi dan menghargai pendapat anggota tim lain',
                'option_d' => 'Mengikuti saja tanpa memberikan kontribusi',
                'correct_option' => 'c',
            ],
            [
                'category' => 'TKP',
                'question_text' => 'Jika ada deadline pekerjaan yang ketat, Anda akan...?',
                'option_a' => 'Mengeluh dan mencari alasan',
                'option_b' => 'Menunda pekerjaan',
                'option_c' => 'Mengatur prioritas dan bekerja lebih giat',
                'option_d' => 'Meminta orang lain mengerjakan',
                'correct_option' => 'c',
            ],
            [
                'category' => 'TKP',
                'question_text' => 'Ketika menghadapi konflik dengan rekan kerja, Anda akan...?',
                'option_a' => 'Menghindari dan tidak berbicara lagi',
                'option_b' => 'Mencari solusi bersama melalui dialog',
                'option_c' => 'Melaporkan ke atasan tanpa mencoba menyelesaikan',
                'option_d' => 'Membalas dengan perlakuan yang sama',
                'correct_option' => 'b',
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}

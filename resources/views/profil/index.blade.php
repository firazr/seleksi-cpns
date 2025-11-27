@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="py-12">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <span class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-full text-sm font-medium mb-4">
                <i class="bi bi-building me-2"></i> Tentang Kami
            </span>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">Profil Kementerian</h1>
            <p class="text-white/80 max-w-2xl mx-auto">Mengenal lebih dekat instansi penyelenggara seleksi CPNS</p>
        </div>
        
        <!-- About Section -->
        <div class="glass-section rounded-3xl p-8 lg:p-12 mb-8" data-aos="fade-up">
            <div class="flex flex-col lg:flex-row gap-12 items-center">
                <div class="flex-1">
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-4">
                        <i class="bi bi-info-circle me-2"></i> Tentang
                    </span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Tentang Kelompok</h2>
                    <p class="text-gray-600 mb-4">
                        Portal CPNS 2025 adalah platform resmi yang dikembangkan untuk memfasilitasi proses pendaftaran dan seleksi Calon Pegawai Negeri Sipil. Kami berkomitmen untuk memberikan layanan terbaik dan transparan kepada seluruh peserta.
                    </p>
                    <p class="text-gray-600">
                        Tim kami terdiri dari para profesional yang berpengalaman dalam bidang teknologi informasi dan manajemen sumber daya manusia, yang bekerja sama untuk menciptakan sistem seleksi yang adil dan efisien.
                    </p>
                </div>
                <div class="flex-1">
                    <img src="{{ asset('images/team.jpg') }}" alt="Tim Kelompok" class="w-full rounded-2xl shadow-2xl">
                </div>
            </div>
        </div>
        
        <!-- Visi Misi Section -->
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <div class="glass-section rounded-3xl p-8" data-aos="fade-right">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-xl">
                    <i class="bi bi-eye text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi</h3>
                <p class="text-gray-600">
                    Menjadi portal seleksi CPNS terpercaya dan terintegrasi yang mampu menjaring talenta terbaik bangsa untuk membangun Indonesia yang lebih maju dan berdaya saing global.
                </p>
            </div>
            
            <div class="glass-section rounded-3xl p-8" data-aos="fade-left">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-xl">
                    <i class="bi bi-bullseye text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi</h3>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1"></i>
                        <span>Menyediakan platform seleksi yang transparan dan akuntabel</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1"></i>
                        <span>Mengembangkan sistem berbasis teknologi yang user-friendly</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1"></i>
                        <span>Memberikan informasi yang akurat dan tepat waktu</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1"></i>
                        <span>Mendukung terciptanya ASN yang berkualitas</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Sejarah Section -->
        <div class="glass-section rounded-3xl p-8 lg:p-12 mb-8" data-aos="fade-up">
            <div class="text-center mb-8">
                <span class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-medium mb-4">
                    <i class="bi bi-clock-history me-2"></i> Sejarah
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Sejarah Singkat</h2>
            </div>
            <div class="max-w-3xl mx-auto">
                <div class="relative border-l-4 border-blue-500 pl-8 space-y-8">
                    <div class="relative">
                        <div class="absolute -left-10 w-6 h-6 bg-blue-500 rounded-full border-4 border-white"></div>
                        <h4 class="text-lg font-bold text-gray-900">2020 - Awal Mula</h4>
                        <p class="text-gray-600">Konsep portal CPNS digital pertama kali diinisiasi sebagai respons terhadap kebutuhan modernisasi sistem rekrutmen ASN.</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-10 w-6 h-6 bg-blue-500 rounded-full border-4 border-white"></div>
                        <h4 class="text-lg font-bold text-gray-900">2022 - Pengembangan</h4>
                        <p class="text-gray-600">Tim pengembang dibentuk dan mulai membangun infrastruktur teknologi yang diperlukan.</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-10 w-6 h-6 bg-blue-500 rounded-full border-4 border-white"></div>
                        <h4 class="text-lg font-bold text-gray-900">2024 - Peluncuran Beta</h4>
                        <p class="text-gray-600">Versi beta portal diluncurkan untuk uji coba terbatas dengan beberapa instansi pemerintah.</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-10 w-6 h-6 bg-green-500 rounded-full border-4 border-white"></div>
                        <h4 class="text-lg font-bold text-gray-900">2025 - Peluncuran Resmi</h4>
                        <p class="text-gray-600">Portal CPNS 2025 diluncurkan secara resmi untuk melayani seluruh peserta seleksi CPNS nasional.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hasil Test Per Domisili -->
        <div class="glass-section rounded-3xl p-8 lg:p-12" data-aos="fade-up">
            <div class="text-center mb-8">
                <span class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-700 rounded-full text-sm font-medium mb-4">
                    <i class="bi bi-bar-chart me-2"></i> Hasil Test
                </span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Hasil Test Per Domisili</h2>
                <p class="text-gray-600">Pilih domisili untuk melihat hasil test peserta</p>
            </div>
            
            <!-- Domisili Buttons -->
            <div class="flex flex-wrap justify-center gap-3 mb-8">
                @foreach($domisiliList as $dom)
                <button onclick="loadResults('{{ $dom }}')" class="domisili-btn px-4 py-2 rounded-lg font-medium transition-all {{ $selectedDomisili == $dom ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}" data-domisili="{{ $dom }}">
                    {{ $dom }}
                </button>
                @endforeach
            </div>
            
            <!-- Results Table -->
            <div id="results-container">
                @if($selectedDomisili && $results)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                        <h3 class="text-lg font-semibold text-white">Hasil Test - {{ $selectedDomisili }}</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Peserta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($results as $index => $result)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $result->user->participant_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $result->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $result->category_label }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $result->score >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $result->score }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $result->finished_at->format('d M Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada hasil test untuk domisili ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="text-center py-12 text-gray-500">
                    <i class="bi bi-map text-5xl mb-4 block"></i>
                    <p>Pilih domisili untuk melihat hasil test</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function loadResults(domisili) {
    // Update button states
    $('.domisili-btn').removeClass('bg-blue-600 text-white').addClass('bg-gray-100 text-gray-700');
    $(`.domisili-btn[data-domisili="${domisili}"]`).removeClass('bg-gray-100 text-gray-700').addClass('bg-blue-600 text-white');
    
    // Load results via AJAX
    $.get('{{ route("profil.results") }}', { domisili: domisili }, function(response) {
        if (response.success) {
            let html = `
                <div class="bg-white rounded-xl overflow-hidden shadow-lg">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600">
                        <h3 class="text-lg font-semibold text-white">Hasil Test - ${response.domisili}</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Peserta</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
            `;
            
            if (response.data.length === 0) {
                html += `<tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada hasil test untuk domisili ini</td></tr>`;
            } else {
                response.data.forEach((result, index) => {
                    const scoreClass = result.score >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                    html += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${index + 1}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${result.participant_number}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${result.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${result.category}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-sm font-medium ${scoreClass}">${result.score}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${result.finished_at}</td>
                        </tr>
                    `;
                });
            }
            
            html += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            
            $('#results-container').html(html);
        }
    });
}
</script>
@endpush
@endsection

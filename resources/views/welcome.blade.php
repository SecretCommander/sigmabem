<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGMA BEM | Sistem Manajemen RAB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .purple-gradient {
            background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 100%);
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans">

    <!-- Navbar -->
    <nav class="sticky top-0 bg-white z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logosigmabem.png') }}" alt="Logo" class="h-8">
                <span class="font-bold text-xl tracking-tight">SIGMA BEM</span>
            </div>

            <div class="hidden md:flex items-center gap-8 font-medium text-sm text-gray-600">
                <a href="#" class="hover:text-purple-700">HOME</a>
                <a href="#" class="hover:text-purple-700">PROPOSAL</a>
                <a href="#" class="hover:text-purple-700">LPJ</a>
                <a href="#" class="hover:text-purple-700">ABOUT</a>
            </div>

            <div class="flex items-center gap-4">
                @guest
                    <a href="/login"
                        class="bg-purple-900 text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-purple-800 transition">MASUK</a>
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center border border-purple-200 text-purple-700 font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="py-16 px-6 bg-gray-50">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1">
                <span class="text-purple-600 font-semibold text-sm">#Solusi Cepat RAB Himpunan</span>
                <h1 class="text-5xl font-bold text-gray-900 mt-2 mb-6">SIGMA BEM</h1>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Solusi Digital Penyusunan RAB Organisasi Mahasiswa. SIGMA BEM merupakan program kerja digital yang
                    dilandasi dari kebutuhan kegiatan mahasiswa dan memberikan kemudahan untuk pengurus...
                </p>
                <div class="flex gap-4">
                    <button class="bg-purple-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-purple-700">Ayo
                        Buat RAB Sekarang &rarr;</button>
                    <button class="px-8 py-3 rounded-xl font-semibold border border-gray-200 hover:bg-gray-100">Pelajari
                        lebih lanjut</button>
                </div>
            </div>
            <div class="flex-1 bg-white p-4 rounded-3xl shadow-xl">
                <img src="{{ asset('img/mockup.png') }}" alt="Dashboard Preview" class="rounded-2xl">
            </div>
        </div>
    </header>

    <!-- Tentang Platform Section -->
    <section class="py-12 px-6 max-w-7xl mx-auto">
        <div class="bg-purple-50 rounded-[2.5rem] p-8 md:p-14 flex flex-col md:flex-row items-center gap-10 md:gap-16">

            <!-- Left Side: Image -->
            <div class="md:w-1/2 w-full">
                <!-- Pastikan gambar mockup laptopnya sudah dimasukkan ke folder public/img -->
                <img src="{{ asset('img/Illustration.png') }}" alt="Preview SIGMA BEM"
                    class="w-full rounded-2xl shadow-xl border-[6px] md:border-[8px] border-white transform transition hover:scale-105 duration-300">
            </div>

            <!-- Right Side: Text Content -->
            <div class="md:w-1/2 w-full">
                <!-- Subtitle dengan garis -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-[2px] bg-purple-700"></div>
                    <span class="text-purple-700 font-bold text-xs tracking-wider uppercase">Tentang Platform</span>
                </div>

                <!-- Judul -->
                <h2 class="text-3xl md:text-4xl font-bold text-purple-900 mb-6">Apa itu SIGMA BEM?</h2>

                <!-- Paragraf 1 -->
                <p class="text-gray-600 mb-5 leading-relaxed text-[15px]">
                    SIGMA BEM adalah platform digital yang dirancang khusus untuk membantu bendahara HMPS dan UKM dalam
                    menyusun Rencana Anggaran Biaya (RAB) secara lebih <span class="font-bold text-purple-700">mudah,
                        cepat, dan sistematis.</span>
                </p>

                <!-- Paragraf 2 -->
                <p class="text-gray-600 leading-relaxed text-[15px]">
                    Melalui website ini, proses penyusunan anggaran diharapkan tidak lagi dilakukan secara manual,
                    sehingga dapat meminimalkan kesalahan perhitungan, meningkatkan efisiensi kerja, dan mempermudah
                    pengarsipan data keuangan organisasi.
                </p>
            </div>

        </div>
    </section>

    <!-- Problem Section -->
    <section class="py-20 max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Berangkat dari Permasalahan Nyata</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 bg-purple-50 rounded-lg mb-6">
                    <img src="{{ asset('img/bg_shadow.png') }}" alt="" class="rounded-2xl">
                </div>
                <h3 class="font-bold text-lg mb-2">Penyusunan Masih Manual</h3>
                <p class="text-gray-500 text-sm">Penyusunan anggaran masih diproses secara manual, sehingga memakan
                    waktu dan rentan salah.</p>
            </div>
            <!-- Card 2 -->
            <div class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 bg-yellow-50 rounded-lg mb-6">
                    <img src="{{ asset('img/warning.png') }}" alt="" class="rounded-2xl">
                </div>
                <h3 class="font-bold text-lg mb-2">Rumit Keahlian/Hitung</h3>
                <p class="text-gray-500 text-sm">Proses hitung yang manual menyulitkan pengurus saat penyusunan anggaran
                    kegiatan.</p>
            </div>
            <!-- Card 3 -->
            <div class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 bg-red-50 rounded-lg mb-6">
                    <img src="{{ asset('img/bg_shadow2.png') }}" alt="" class="rounded-2xl">
                </div>
                <h3 class="font-bold text-lg mb-2">Pengarsipan Kurang Efisien</h3>
                <p class="text-gray-500 text-sm">Dokumen sering tercecer dan hilang, menyulitkan proses
                    pertanggungjawaban.</p>
            </div>
        </div>
    </section>

    <!-- Alert Solusi -->
    <div class="max-w-5xl mx-auto px-6 mb-20 mt-10">
        <div
            class="bg-[#f3f0f9] rounded-xl py-4 px-6 text-center text-sm md:text-base text-gray-700 shadow-sm border border-purple-50">
            <span class="mr-2">💡</span> Solusi: Melalui SIGMA BEM, penyusunan RAB menjadi praktis, terstruktur, dan
            <span class="font-bold">terdigitalisasi</span>.
        </div>
    </div>

    <!-- Kementerian Card Section -->
    <section class="max-w-6xl mx-auto px-6 mb-24">
        <div
            class="bg-[#562c95] rounded-[2rem] overflow-hidden flex flex-col md:flex-row relative shadow-2xl shadow-purple-900/20">
            <!-- Text Content -->
            <div class="md:w-3/5 p-10 md:p-14 z-10 relative">
                <span
                    class="inline-block bg-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6 backdrop-blur-sm">Tentang
                    Inisiator</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 leading-tight">Kementerian Keuangan
                    dan<br>Kewirausahaan</h2>
                <p class="text-purple-100 text-sm md:text-base mb-5 leading-relaxed">
                    Kementerian Keuangan dan Kewirausahaan merupakan pilar strategis BEM Politeknik Negeri Medan yang
                    berperan dalam mengelola keuangan organisasi secara <span class="font-bold text-white">transparan,
                        tertata, dan terpercaya</span>, sekaligus mendorong tumbuhnya semangat kewirausahaan.
                </p>
                <p class="text-purple-100 text-sm md:text-base leading-relaxed">
                    Melalui pengelolaan anggaran yang sistematis, optimalisasi pendanaan, serta pengembangan inovasi
                    berbasis ide dan karya, kementerian ini hadir untuk menjaga stabilitas organisasi sekaligus
                    menciptakan ruang eksplorasi yang produktif bagi mahasiswa serta Kabinet Karsa Abhinaya.
                </p>
            </div>

            <!-- Background Image & Logo -->
            <div class="md:w-2/5 relative min-h-[250px] md:min-h-full">
                <!-- Overlay gradient untuk efek transisi yang halus ke gambar -->
                <div
                    class="absolute inset-0 bg-gradient-to-t from-[#562c95] via-[#562c95]/80 to-transparent z-10 md:hidden">
                </div>

                <!-- Ganti src ini dengan gambar gedung Politeknik Negeri Medan Anda -->
                <img src="{{ asset('img/Image.png') }}" class="absolute inset-0" alt="Gedung Polmed">

                <!-- Ganti src ini dengan Logo Kementerian -->
                <img src="{{ asset('img/logokabinet.png') }}"
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20 w-32 md:w-48 drop-shadow-xl"
                    alt="Logo Kementerian">
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section class="max-w-6xl mx-auto px-6 mb-28">
        <div class="text-center mb-16">
            <h3 class="text-purple-500 font-bold text-xs tracking-[0.2em] uppercase mb-3">Keunggulan SIGMA BEM</h3>
            <h2 class="text-3xl font-bold text-[#441c7a] inline-block relative">
                Mengelola Anggaran Jadi Lebih Mudah
                <!-- Garis bawah kecil ungu -->
                <div
                    class="absolute w-16 h-1 bg-purple-500 left-1/2 transform -translate-x-1/2 -bottom-5 rounded-full">
                </div>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div
                class="bg-white rounded-3xl p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 hover:-translate-y-1 transition duration-300">
                <div
                    class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <h4 class="font-bold text-[#441c7a] mb-3">Praktis & Efisien</h4>
                <p class="text-gray-500 text-xs leading-relaxed px-2">Penyusunan RAB lebih cepat dan mudah dalam satu
                    platform digital.</p>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white rounded-3xl p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 hover:-translate-y-1 transition duration-300">
                <div
                    class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <h4 class="font-bold text-[#441c7a] mb-3">Minim Kesalahan</h4>
                <p class="text-gray-500 text-xs leading-relaxed px-2">Sistem hitung otomatis mengurangi risiko
                    kesalahan perhitungan manual.</p>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white rounded-3xl p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 hover:-translate-y-1 transition duration-300">
                <div
                    class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h4 class="font-bold text-[#441c7a] mb-3">Dokumentasi Terstruktur</h4>
                <p class="text-gray-500 text-xs leading-relaxed px-2">Arsip RAB tersimpan rapi dan mudah diakses kapan
                    saja.</p>
            </div>

            <!-- Card 4 -->
            <div
                class="bg-white rounded-3xl p-8 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 hover:-translate-y-1 transition duration-300">
                <div
                    class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <h4 class="font-bold text-[#441c7a] mb-3">Kolaborasi Mudah</h4>
                <p class="text-gray-500 text-xs leading-relaxed px-2">Menjadi solusi digital terpusat bagi bendahara
                    HMPS dan UKM.</p>
            </div>
        </div>
    </section>

    <!-- Alur Penggunaan Section -->
    <section class="max-w-5xl mx-auto px-6 mb-28">
        <div class="text-center mb-20">
            <h3 class="text-purple-500 font-bold text-xs tracking-[0.2em] uppercase mb-3">Alur Penggunaan</h3>
            <h2 class="text-3xl font-bold text-[#441c7a]">4 Langkah Mudah</h2>
        </div>

        <div class="relative">
            <!-- Garis Putus-putus Penghubung (Hanya muncul di desktop) -->
            <div
                class="hidden md:block absolute top-[30px] left-[12%] right-[12%] border-t-2 border-dashed border-purple-200 z-0">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-4 relative z-10">
                <!-- Step 1 -->
                <div class="text-center">
                    <div
                        class="w-[60px] h-[60px] bg-white border-[3px] border-[#441c7a] rounded-full flex items-center justify-center mx-auto mb-5 text-[#441c7a] font-bold text-xl shadow-sm">
                        1</div>
                    <h4 class="font-bold text-gray-900 mb-3 text-sm">Registrasi / Login</h4>
                    <p class="text-gray-500 text-[11px] leading-relaxed px-4">Daftarkan akun organisasi atau masuk jika
                        sudah punya.</p>
                </div>
                <!-- Step 2 -->
                <div class="text-center">
                    <div
                        class="w-[60px] h-[60px] bg-white border-[3px] border-[#441c7a] rounded-full flex items-center justify-center mx-auto mb-5 text-[#441c7a] font-bold text-xl shadow-sm">
                        2</div>
                    <h4 class="font-bold text-gray-900 mb-3 text-sm">Buat RAB Baru</h4>
                    <p class="text-gray-500 text-[11px] leading-relaxed px-4">Isi detail kegiatan dan rincian item
                        anggaran kebutuhan.</p>
                </div>
                <!-- Step 3 -->
                <div class="text-center">
                    <div
                        class="w-[60px] h-[60px] bg-white border-[3px] border-[#441c7a] rounded-full flex items-center justify-center mx-auto mb-5 text-[#441c7a] font-bold text-xl shadow-sm">
                        3</div>
                    <h4 class="font-bold text-gray-900 mb-3 text-sm">Sistem Hitung</h4>
                    <p class="text-gray-500 text-[11px] leading-relaxed px-4">Sistem otomatis menghitung subtotal dan
                        grand total.</p>
                </div>
                <!-- Step 4 -->
                <div class="text-center">
                    <div
                        class="w-[60px] h-[60px] bg-white border-[3px] border-[#441c7a] rounded-full flex items-center justify-center mx-auto mb-5 text-[#441c7a] font-bold text-xl shadow-sm">
                        4</div>
                    <h4 class="font-bold text-gray-900 mb-3 text-sm">Export Dokumen</h4>
                    <p class="text-gray-500 text-[11px] leading-relaxed px-4">Unduh hasil RAB dalam format PDF, Excel,
                        atau Word.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-20 px-6">
        <div class="max-w-5xl mx-auto purple-gradient rounded-3xl p-12 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Siap Menyusun RAB dengan Lebih Mudah?</h2>
            <p class="text-purple-200 mb-8">Mulai atur RAB organisasi kamu dengan lebih rapi, terstruktur, dan efisien
                bersama SIGMA BEM.</p>
            <button class="bg-white text-purple-900 px-8 py-3 rounded-xl font-bold hover:bg-gray-100">Daftar/Masuk
                Sekarang</button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-purple-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-8">
            <div class="col-span-2">
                <h3 class="font-bold text-xl mb-4">SIGMA BEM</h3>
                <p class="text-purple-300 text-sm">Sistem pengatur anggaran kegiatan organisasi secara digital.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Menu</h4>
                <ul class="text-sm text-purple-300 space-y-2">
                    <li>Dashboard</li>
                    <li>Proposal</li>
                    <li>LPJ</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Kontak</h4>
                <p class="text-sm text-purple-300">Hubungi kami untuk dukungan lebih lanjut.</p>
            </div>
        </div>
    </footer>

</body>

</html>

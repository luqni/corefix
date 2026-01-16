<div class="space-y-12">
    <!-- Custom Animations -->
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-900 to-indigo-900 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
             <div class="absolute inset-0 bg-indigo-900 opacity-50"></div>
             <!-- Decorative Shape -->
             <svg class="absolute bottom-0 left-0 transform translate-y-10" width="100%" height="200" fill="none" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,197.3C1248,171,1344,149,1392,138.7L1440,128V320H1392C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320H0V224Z"></path>
             </svg>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center animate-fade-in-up">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl mb-6">
                    <span class="block">Professional Gadget Repair</span>
                    <span class="block text-indigo-300 mt-2">Tanpa Keluar Rumah</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-200 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl delay-100 opacity-0 bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/10 animate-fade-in-up">
                    Layanan service HP panggilan #1. Teknisi ahli kami datang ke tempat Anda. Cepat, Aman, dan Bergaransi.
                </p>
                <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center delay-200 opacity-0 animate-fade-in-up">
                    <div class="space-y-4 sm:space-y-0 sm:mx-auto sm:inline-grid sm:grid-cols-2 sm:gap-5">
                        <a href="#booking" class="flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-full text-indigo-700 bg-white hover:bg-indigo-50 hover:shadow-lg hover:scale-105 transition transform duration-300 md:text-lg md:px-10">
                            Booking Sekarang
                        </a>
                        <a href="{{ route('tracking') }}" class="flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-full text-white bg-indigo-600/50 hover:bg-indigo-700/50 backdrop-blur-md border-indigo-400 hover:shadow-lg transition md:text-lg md:px-10">
                             Lacak Status
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Floating Stats/Icons -->
            <div class="absolute top-10 left-10 hidden md:block animate-float">
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-xl">
                    <span class="text-3xl">📱</span>
                    <span class="text-white font-bold ml-2">LCD Expert</span>
                </div>
            </div>
            <div class="absolute bottom-40 right-10 hidden md:block animate-float delay-300">
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-xl">
                    <span class="text-3xl">🔋</span>
                    <span class="text-white font-bold ml-2">Battery Fix</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Features / Why Us -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Kenapa Corefix?</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Solusi Terbaik untuk Gadget Anda</p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="flex items-center space-x-4 p-6 bg-white rounded-lg shadow-sm">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Pengerjaan Cepat</h3>
                            <p class="mt-2 text-sm text-gray-500">Bisa ditunggu untuk kerusakan ringan seperti ganti LCD & Baterai.</p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex items-center space-x-4 p-6 bg-white rounded-lg shadow-sm">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Bergaransi</h3>
                            <p class="mt-2 text-sm text-gray-500">Garansi servis hingga 90 hari untuk kenyamanan Anda.</p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex items-center space-x-4 p-6 bg-white rounded-lg shadow-sm">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Home Service</h3>
                            <p class="mt-2 text-sm text-gray-500">Kami datang ke tempat Anda. Hemat waktu, tidak perlu macet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-8">Layanan Kami</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl shadow border text-center hover:border-indigo-500 transition cursor-pointer">
                <span class="text-4xl">📱</span>
                <h3 class="font-bold mt-2">Ganti LCD</h3>
            </div>
            <div class="bg-white p-4 rounded-xl shadow border text-center hover:border-indigo-500 transition cursor-pointer">
                <span class="text-4xl">🔋</span>
                <h3 class="font-bold mt-2">Ganti Baterai</h3>
            </div>
            <div class="bg-white p-4 rounded-xl shadow border text-center hover:border-indigo-500 transition cursor-pointer">
                <span class="text-4xl">💧</span>
                <h3 class="font-bold mt-2">Kemasukan Air</h3>
            </div>
            <div class="bg-white p-4 rounded-xl shadow border text-center hover:border-indigo-500 transition cursor-pointer">
                <span class="text-4xl">🔌</span>
                <h3 class="font-bold mt-2">Konektor Cas</h3>
            </div>
        </div>
    </div>

    <!-- Process / How it Works -->
    <div class="py-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Cara Kerja</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Service HP Semudah 1-2-3</p>
            </div>
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-between">
                    <div class="bg-white px-4 text-center">
                        <span class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold mx-auto mb-2">1</span>
                        <h3 class="text-lg font-medium text-gray-900">Booking Online</h3>
                        <p class="text-sm text-gray-500 max-w-xs mx-auto">Isi formulir keluhan dan jadwal service di website ini.</p>
                    </div>
                    <div class="bg-white px-4 text-center">
                        <span class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold mx-auto mb-2">2</span>
                        <h3 class="text-lg font-medium text-gray-900">Teknisi Datang</h3>
                        <p class="text-sm text-gray-500 max-w-xs mx-auto">Teknisi kami datang ke rumah/kantor Anda untuk perbaikan.</p>
                    </div>
                    <div class="bg-white px-4 text-center">
                        <span class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold mx-auto mb-2">3</span>
                        <h3 class="text-lg font-medium text-gray-900">Selesai & Bergaransi</h3>
                        <p class="text-sm text-gray-500 max-w-xs mx-auto">Bayar setelah selesai. Garansi 90 hari untuk ketenangan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <section class="py-12 bg-indigo-800 text-white overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Apa Kata Mereka?</h2>
                <p class="mt-4 text-lg text-indigo-200">Ribuan pelanggan puas dengan layanan Corefix.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-indigo-900 rounded-xl p-6 shadow-xl border border-indigo-700">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">★★★★★</div>
                    </div>
                    <p class="text-indigo-100 italic mb-4">"Awalnya ragu service panggilan, tapi ternyata teknisinya profesional banget. Ganti LCD iPhone 11 cuma 20 menit kelar di depan mata. Rekomen!"</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-bold">AD</div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-white">Andi Darmawan</h3>
                            <p class="text-xs text-indigo-300">Jakarta Selatan</p>
                        </div>
                    </div>
                </div>
                 <!-- Testimonial 2 -->
                <div class="bg-indigo-900 rounded-xl p-6 shadow-xl border border-indigo-700">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">★★★★★</div>
                    </div>
                    <p class="text-indigo-100 italic mb-4">"Service center resmi antriannya panjang. Di Corefix sat set sat set, harga transparan, teknisi ramah. HP saya hidup lagi!"</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-bold">SP</div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-white">Siti Putri</h3>
                            <p class="text-xs text-indigo-300">Tangerang</p>
                        </div>
                    </div>
                </div>
                 <!-- Testimonial 3 -->
                <div class="bg-indigo-900 rounded-xl p-6 shadow-xl border border-indigo-700">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">★★★★★</div>
                    </div>
                    <p class="text-indigo-100 italic mb-4">"Solusi banget buat yang sibuk kerja. Orang kantor saya sekarang kalau ada gadget rusak pasti panggil Corefix. Mantap!"</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-bold">RZ</div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-white">Reza Zulkarnain</h3>
                            <p class="text-xs text-indigo-300">Jakarta Pusat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location & Contact -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Hubungi Kami</h2>
                    <div class="space-y-4 text-lg text-gray-600">
                        <p class="flex items-center">
                            <span class="mr-4 text-2xl">📍</span>
                            <span>Jl Akasia Raya, Desa Pamutih, Kecamatan Ulujami, Kabupaten Pemalang, jawa Tengah</span>
                        </p>
                        <p class="flex items-center">
                            <span class="mr-4 text-2xl">⏰</span>
                            <span>Senin - Minggu: 09:00 - 21:00 WIB</span>
                        </p>
                        <p class="flex items-center">
                            <span class="mr-4 text-2xl">📞</span>
                            <span>+62 812-3456-7890 (WhatsApp Available)</span>
                        </p>
                        <p class="flex items-center">
                            <span class="mr-4 text-2xl">✉️</span>
                            <span>support@corefix.id</span>
                        </p>
                    </div>
                    <div class="mt-8">
                         <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            Chat via WhatsApp
                         </a>
                    </div>
                </div>
                <div class="bg-white p-2 rounded-lg shadow-lg">
                    <!-- Placeholder Map -->
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg flex items-center justify-center h-64">
                         <span class="text-gray-400 font-bold">Google Maps Embed Placeholder</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Section -->
    <div id="booking" class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Mulai Perbaikan</h2>
                <p class="mt-4 text-lg text-gray-500">Isi formulir di bawah, teknisi kami akan segera menghubungi Anda.</p>
            </div>
            
            <livewire:booking-wizard />
        </div>
    </div>
</div>

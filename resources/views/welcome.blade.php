<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
</head>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoreFix - Jasa Service HP Panggilan Pemalang & Pekalongan</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Jasa service HP panggilan terbaik di Pemalang, Pekalongan, dan sekitarnya. Ganti LCD, Baterai, Software, dan perbaikan lainnya. Teknisi profesional datang ke tempat Anda. Bergaransi!">
    <meta name="keywords" content="service hp pemalang, service hp panggilan, ganti lcd, ganti baterai, service iphone pemalang, service android, teknisi hp, corefix">
    <meta name="author" content="CoreFix.id">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    <meta name="geo.region" content="ID-JT" />
    <meta name="geo.placename" content="Pemalang" />
    <meta name="geo.position" content="-6.8921;109.3805" />
    <meta name="ICBM" content="-6.8921, 109.3805" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="business.business">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="CoreFix - Jasa Service HP Panggilan Bergaransi">
    <meta property="og:description" content="HP Rusak? Jangan panik! Teknisi CoreFix siap datang ke lokasi Anda. Cepat, Transparan, dan Bergaransi 90 Hari.">
    <meta property="og:image" content="{{ asset('logo.png?v=3') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="CoreFix - Jasa Service HP Panggilan Bergaransi">
    <meta property="twitter:description" content="HP Rusak? Jangan panik! Teknisi CoreFix siap datang ke lokasi Anda. Cepat, Transparan, dan Bergaransi 90 Hari.">
    <meta property="twitter:image" content="{{ asset('logo.png?v=3') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JSON-LD Structured Data for Local Business -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MobilePhoneRepair",
      "name": "CoreFix.id",
      "image": "{{ asset('logo.png?v=3') }}",
      "@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "telephone": "+6289509045088",
      "priceRange": "$$",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Dusun keong No.67, RT.01/RW.07, Siwelut, Pamutih",
        "addressLocality": "Ulujami",
        "addressRegion": "Pemalang",
        "postalCode": "52371",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.8530966,
        "longitude": 109.5427463
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
          "Sunday"
        ],
        "opens": "08:00",
        "closes": "21:00"
      },
      "sameAs": [
        "https://instagram.com/corefix.id",
        "https://facebook.com/corefix.id"
      ]
    }
    </script>
<body class="font-sans text-gray-900 antialiased bg-gray-50 overflow-x-hidden">
    <div class="relative w-full overflow-x-hidden">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between py-4 md:py-6 items-center">
                <div class="w-full md:w-auto flex justify-center md:justify-start">
                    <img src="{{ asset('logo.png?v=3') }}" alt="CoreFix" class="h-28 md:h-36 w-auto">
                </div>
                
                <div class="hidden md:flex space-x-8 items-center md:ml-auto whitespace-nowrap">
                    <a href="#services" class="text-gray-600 hover:text-primary font-medium transition">Layanan</a>
                    <a href="#pricing" class="text-gray-600 hover:text-primary font-medium transition">Harga</a>
                    <a href="#about" class="text-gray-600 hover:text-primary font-medium transition">Tentang Kami</a>
                    <div class="relative group">
                        <button class="flex items-center text-gray-600 hover:text-primary font-medium transition">
                            Promo <span class="ml-1 bg-orange-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">HOT</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-primary focus:outline focus:outline-2 focus:rounded-sm focus:outline-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-primary transition">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-primary hover:bg-green-600 text-white px-6 py-2.5 rounded-full font-semibold transition shadow-lg shadow-primary/30">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative bg-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 md:pt-32 md:pb-32 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-100 text-primary font-semibold text-sm mb-6">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        Service HP Bergaransi & Terpercaya
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                        Solusi Masalah <br/>
                        <span class="text-primary">Smartphone</span> Kamu
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg mx-auto md:mx-0">
                        Layanan perbaikan smartphone profesional dengan teknisi tersertifikasi. Cepat, transparan, dan bergaransi. Cek diagnosa gratis sekarang!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="#consultation" class="inline-flex justify-center items-center px-8 py-4 bg-primary text-white font-bold rounded-xl shadow-xl shadow-primary/20 hover:bg-green-600 hover:-translate-y-1 transition transform">
                            Konsultasi Sekarang
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="#services" class="inline-flex justify-center items-center px-8 py-4 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:border-primary hover:text-primary transition">
                            Lihat Layanan
                        </a>
                    </div>
                    <div class="mt-8 flex items-center justify-center md:justify-start gap-6 text-sm text-gray-500 font-medium">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Sparepart Original
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pengerjaan Cepat
                        </div>
                    </div>
                </div>
                <div class="relative hidden md:block">
                     <!-- Illustration/Image Placeholder -->
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-900 border-4 border-white aspect-[4/3]">
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-800 text-gray-500">
                             <!-- Generate an image here later if needed, focusing on structure for now -->
                             <img src="https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?q=80&w=1000&auto=format&fit=crop" alt="Technician repairing phone" class="object-cover w-full h-full opacity-90 hover:scale-105 transition duration-700">
                             <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                             <div class="absolute bottom-6 left-6 text-white text-left">
                                <div class="font-bold text-xl">Teknisi Profesional</div>
                                <div class="text-sm opacity-80">Siap membantu masalah gadgetmu</div>
                             </div>
                        </div>
                    </div>
                    <!-- Decorative Elements -->
                    <div class="absolute -z-10 top-10 -right-10 w-24 h-24 bg-primary/20 rounded-full blur-2xl"></div>
                    <div class="absolute -z-10 -bottom-6 -left-6 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats / Trust -->
    <section class="border-y border-gray-100 bg-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
                <div class="p-4">
                    <p class="text-3xl font-extrabold text-gray-900">5.000+</p>
                    <p class="text-sm text-gray-500 mt-1">Gadget Diperbaiki</p>
                </div>
                <div class="p-4">
                    <p class="text-3xl font-extrabold text-gray-900">100%</p>
                    <p class="text-sm text-gray-500 mt-1">Data Aman</p>
                </div>
                <div class="p-4">
                    <p class="text-3xl font-extrabold text-gray-900">30 Hari</p>
                    <p class="text-sm text-gray-500 mt-1">Garansi Service</p>
                </div>
                <div class="p-4">
                    <p class="text-3xl font-extrabold text-gray-900">24/7</p>
                    <p class="text-sm text-gray-500 mt-1">Support Layanan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section id="services" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-primary font-bold tracking-wide uppercase text-sm mb-3">Layanan Kami</h2>
                <h3 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Apa masalah handphone kamu?</h3>
                <p class="text-gray-600">Kami menangani berbagai kerusakan hardware dan software dengan peralatan lengkap.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 hover:-translate-y-1 hover:shadow-xl transition border border-gray-100 group">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Ganti LCD / Layar</h4>
                    <p class="text-gray-500 mb-6">!Layar pecah, retak, atau touchscreen tidak responsif? Kami ganti dengan sparepart berkualitas.</p>
                    <a href="#" class="text-primary font-semibold hover:text-green-700 flex items-center">
                        Selengkapnya <svg class="w-4 h-4 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 hover:-translate-y-1 hover:shadow-xl transition border border-gray-100 group">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Ganti Baterai</h4>
                    <p class="text-gray-500 mb-6">Baterai cepat habis, kembung, atau hp sering mati sendiri? Saatnya ganti baterai baru.</p>
                    <a href="#" class="text-primary font-semibold hover:text-green-700 flex items-center">
                        Selengkapnya <svg class="w-4 h-4 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 hover:-translate-y-1 hover:shadow-xl transition border border-gray-100 group">
                   <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Software & Unlock</h4>
                    <p class="text-gray-500 mb-6">Lupa pola/sandi, bootloop, hang logo, atau ingin upgrade OS? Kami bisa bantu.</p>
                    <a href="#" class="text-primary font-semibold hover:text-green-700 flex items-center">
                        Selengkapnya <svg class="w-4 h-4 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>

                 <!-- Card 4 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 hover:-translate-y-1 hover:shadow-xl transition border border-gray-100 group">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                     </div>
                     <h4 class="text-xl font-bold text-gray-900 mb-3">Konektor Charge</h4>
                     <p class="text-gray-500 mb-6">Hp tidak bisa dicas atau harus digoyang-goyang dulu? Perbaiki konektor charge di sini.</p>
                     <a href="#" class="text-primary font-semibold hover:text-green-700 flex items-center">
                         Selengkapnya <svg class="w-4 h-4 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                     </a>
                 </div>

                 <!-- Card 5 -->
                 <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 hover:-translate-y-1 hover:shadow-xl transition border border-gray-100 group">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                     </div>
                     <h4 class="text-xl font-bold text-gray-900 mb-3">Service Kamera</h4>
                     <p class="text-gray-500 mb-6">Kamera blur, getar, atau blackout? Kembalikan kejernihan foto kamu.</p>
                     <a href="#" class="text-primary font-semibold hover:text-green-700 flex items-center">
                         Selengkapnya <svg class="w-4 h-4 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                     </a>
                 </div>

                 <!-- Card 6 -->
                 <div class="bg-white rounded-2xl p-8 shadow-lg shadow-gray-200/50 hover:-translate-y-1 hover:shadow-xl transition border border-gray-100 group">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-white transition">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                     </div>
                     <h4 class="text-xl font-bold text-gray-900 mb-3">Lainnya</h4>
                     <p class="text-gray-500 mb-6">Tombol rusak, speaker mati, sinyal hilang, ganti casing, dan kerusakan lainnya.</p>
                     <a href="#" class="text-primary font-semibold hover:text-green-700 flex items-center">
                         Selengkapnya <svg class="w-4 h-4 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                     </a>
                 </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1581092921461-eab62e97a783?q=80&w=1000&auto=format&fit=crop" alt="Quality Service" class="rounded-2xl shadow-2xl relative z-10 w-full object-cover aspect-square">
                    <div class="absolute -bottom-6 -right-6 w-2/3 h-2/3 bg-gray-100 rounded-2xl -z-0"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-primary/10 rounded-full blur-3xl -z-10"></div>
                </div>
                <div>
                     <h2 class="text-primary font-bold tracking-wide uppercase text-sm mb-3">Kenapa Memilih Kami?</h2>
                     <h3 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">Standar Kualitas Tertinggi untuk Gadget Kesayanganmu</h3>
                     <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Teknisi Tersertifikasi</h4>
                                <p class="text-gray-600 mt-1">Ditangani oleh ahli yang berpengalaman menangani berbagai tipe smartphone.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Pengerjaan Cepat</h4>
                                <p class="text-gray-600 mt-1">Bisa ditunggu untuk kerusakan ringan. Kami menghargai waktumu.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-primary">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Harga Transparan</h4>
                                <p class="text-gray-600 mt-1">Tidak ada biaya tersembunyi. Cek gratis, bayar setelah selesai.</p>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gray-900 text-white relative overflow-hidden">
         <div class="absolute inset-0 bg-primary/10 mix-blend-overlay"></div>
         <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
         <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>

         <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold mb-6">Siap Membuat HP-mu Seperti Baru?</h2>
            <p class="text-gray-300 text-lg mb-10 max-w-2xl mx-auto">Jangan biarkan kerusakan menghambat produktivitasmu. Konsultasikan masalah handphone kamu dengan tim ahli kami sekarang juga.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                 <a href="#wa" class="inline-flex justify-center items-center px-8 py-4 bg-green-500 text-white font-bold rounded-xl shadow-lg hover:bg-green-600 transition hover:scale-105 transform">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Chat WhatsApp
                 </a>
                 <a href="#location" class="inline-flex justify-center items-center px-8 py-4 bg-white/10 text-white font-bold rounded-xl backdrop-blur-sm border border-white/20 hover:bg-white/20 transition">
                    Lokasi Kami
                 </a>
            </div>
         </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 pt-16 pb-32 md:pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-6">
                        <img src="{{ asset('logo.png?v=3') }}" alt="CoreFix" class="h-24 md:h-28 w-auto">
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Penyedia jasa service handphone terpercaya dengan standar kualitas tinggi dan garansi kepuasan pelanggan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary transition"><span class="sr-only">Instagram</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772 4.902 4.902 0 011.772-1.153c.636-.247 1.363-.416 2.427-.465C9.673 2.013 10.03 2 12.484 2h.058zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 100 6 3 3 0 000-6zm5.337-3.209a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5z" clip-rule="evenodd" /></svg></a>
                        <a href="#" class="text-gray-400 hover:text-primary transition"><span class="sr-only">Facebook</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-gray-900 font-bold mb-4">Layanan</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-primary transition">Ganti LCD</a></li>
                        <li><a href="#" class="hover:text-primary transition">Ganti Baterai</a></li>
                        <li><a href="#" class="hover:text-primary transition">Service Hardmat</a></li>
                        <li><a href="#" class="hover:text-primary transition">Unlock Jaringan</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gray-900 font-bold mb-4">Perusahaan</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-primary transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary transition">Lokasi</a></li>
                        <li><a href="#" class="hover:text-primary transition">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-primary transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gray-900 font-bold mb-4">Kontak</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-primary mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Jl. Contoh No. 123, Jakarta Selatan
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 812-3456-7890
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} CoreFix. All rights reserved.
                </p>
                <div class="flex space-x-6 text-sm text-gray-400">
                    <a href="#" class="hover:text-primary transition">Privacy Policy</a>
                    <a href="#" class="hover:text-primary transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    </div> <!-- End Main Wrapper -->
    
    <!-- Floating WA Button (Mobile) -->
    <a href="https://wa.me/6289509045088" class="fixed bottom-24 right-6 md:bottom-6 md:right-6 z-40 bg-green-500 text-white p-3 rounded-full shadow-lg hover:bg-green-600 transition shadow-green-500/30">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
    </a>
    <!-- Mobile Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around items-center h-auto z-50 md:hidden py-2 pb-safe">
        <!-- Home -->
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full py-1 text-xs {{ request()->routeIs('home') ? 'text-secondary font-bold' : 'text-gray-500 hover:text-primary' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Home
        </a>

        <!-- Track -->
        <a href="{{ route('tracking') }}" class="flex flex-col items-center justify-center w-full py-1 text-xs {{ request()->routeIs('tracking') ? 'text-secondary font-bold' : 'text-gray-500 hover:text-primary' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            Lacak
        </a>

        <!-- Order -->
        <a href="{{ route('home') }}#booking" class="flex flex-col items-center justify-center w-full py-1 text-xs text-gray-500 hover:text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Order
        </a>
    </div>
</body>
</html>

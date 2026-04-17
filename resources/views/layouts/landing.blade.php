<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CoreFix - Apple & Gadget Repair' }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $metaDescription ?? 'Jasa service HP panggilan terbaik di Weleri, Kendal, Pemalang, dan sekitarnya. Ganti LCD, Baterai, Software, dan perbaikan lainnya. Teknisi profesional datang ke tempat Anda. Bergaransi!' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'service hp weleri, service hp kendal, service hp pemalang, service hp panggilan, ganti lcd, ganti baterai, service iphone, service android, teknisi hp, corefix' }}">
    <meta name="author" content="CoreFix.id">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Geo Tags (Weleri, Kendal) -->
    <meta name="geo.region" content="ID-JT" />
    <meta name="geo.placename" content="Kendal" />
    <meta name="geo.position" content="-6.9723;110.0682" />
    <meta name="ICBM" content="-6.9723, 110.0682" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'CoreFix - Jasa Service HP Panggilan Bergaransi' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'HP Rusak? Jangan panik! Teknisi CoreFix siap datang ke lokasi Anda. Cepat, Transparan, dan Bergaransi 90 Hari.' }}">
    <meta property="og:image" content="{{ asset('logo.png?v=5') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? 'CoreFix - Jasa Service HP Panggilan Bergaransi' }}">
    <meta property="twitter:description" content="{{ $metaDescription ?? 'HP Rusak? Jangan panik! Teknisi CoreFix siap datang ke lokasi Anda. Cepat, Transparan, dan Bergaransi 90 Hari.' }}">
    <meta property="twitter:image" content="{{ asset('logo.png?v=5') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Preload LCP Images -->
    <link rel="preload" href="{{ asset('logo.png?v=5') }}" as="image" />
    <link rel="preload" href="{{ asset('mesin iphone.png?v=4') }}" as="image" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- JSON-LD Structured Data for Local Business -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MobilePhoneRepair",
      "name": "CoreFix.id",
      "image": "{{ asset('logo.png?v=5') }}",
      "@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "telephone": "+6289509045088",
      "priceRange": "$$",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Toko Perumahan Taman Sari (Paling Utara), Jl. Sri Agung, Debong Kidul, Botomulyo, Kec. Cepiring",
        "addressLocality": "Kabupaten Kendal",
        "addressRegion": "Jawa Tengah",
        "postalCode": "51352",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.9723,
        "longitude": 110.0682
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
<body class="font-sans text-gray-900 antialiased bg-gray-50">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex py-4 md:py-6 items-center">
                <!-- Logo -->
                <div class="w-full md:w-auto flex justify-center md:justify-start">
                    <img src="{{ asset('logo.png?v=5') }}" alt="Logo CoreFix Jasa Service HP" class="h-28 md:h-36 w-auto">
                </div>
                
                <!-- Nav Links -->
                <div class="hidden md:flex space-x-8 items-center md:ml-auto whitespace-nowrap">
                    <a href="#services" class="text-gray-600 hover:text-primary font-medium transition">Layanan</a>
                    <!-- <a href="#pricing" class="text-gray-600 hover:text-primary font-medium transition">Harga</a> -->
                    <a href="#about" class="text-gray-600 hover:text-primary font-medium transition">Tentang Kami</a>
                    <a href="#promo">
                        <div class="relative group">
                            <button class="flex items-center text-gray-600 hover:text-primary font-medium transition">
                                Promo <span class="ml-1 bg-orange-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">HOT</span>
                            </button>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 pt-16 pb-32 md:pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12 text-center md:text-left">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-6">
                        <img src="{{ asset('logo.png?v=5') }}" alt="Logo CoreFix Jasa Service HP" class="h-24 md:h-28 w-auto" loading="lazy">
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        Penyedia jasa service handphone terpercaya dengan standar kualitas tinggi dan garansi kepuasan pelanggan.
                    </p>
                    <div class="flex justify-center md:justify-start space-x-4">
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
                        <li><a href="/#lokasi" class="hover:text-primary transition">Lokasi</a></li>
                        <li><a href="#" class="hover:text-primary transition">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-primary transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-gray-900 font-bold mb-4">Kontak</h3>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li class="flex flex-col md:flex-row items-center md:items-start">
                             <svg class="h-5 w-5 text-primary md:mr-2 mb-2 md:mb-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                             <span class="text-center md:text-left">Toko Perumahan Taman Sari (Paling Utara), Jl. Sri Agung, Debong Kidul, Botomulyo, Kec. Cepiring, Kabupaten Kendal, Jawa Tengah 51357, Debong Kidul, Botomulyo, Kec. Cepiring, Kabupaten Kendal, Jawa Tengah 51352</span>
                        </li>
                        <li class="flex flex-col md:flex-row items-center md:items-start mt-3">
                             <svg class="h-5 w-5 text-primary md:mr-2 mb-2 md:mb-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                             089509045088
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
    
    <!-- Floating WA Button (Mobile) -->
    <a href="https://wa.me/6289509045088" class="fixed bottom-20 right-6 md:bottom-6 md:right-6 z-50 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition shadow-green-500/30">
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

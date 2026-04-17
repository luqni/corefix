<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // Hero Section
            ['key' => 'hero_title_1', 'value' => 'Solusi Masalah'],
            ['key' => 'hero_title_2', 'value' => 'Smartphone'],
            ['key' => 'hero_title_3', 'value' => 'Kamu'],
            ['key' => 'hero_subtitle', 'value' => 'Layanan perbaikan smartphone profesional dengan teknisi tersertifikasi. Cepat, transparan, dan bergaransi. Layanan service HP panggilan #1 Cek Segera!'],
            ['key' => 'hero_cta_text', 'value' => 'Order Sekarang'],
            ['key' => 'hero_cta_link', 'value' => '#booking'],

            // Promo Section
            ['key' => 'promo_title', 'value' => 'PROMO SPESIAL! 🎉'],
            ['key' => 'promo_text', 'value' => 'Dapatkan potongan harga <span class="font-bold text-red-500">20%</span> untuk service LCD & Baterai.'],
            ['key' => 'promo_code', 'value' => 'COREFIX20'],
            ['key' => 'promo_note', 'value' => '*Syarat & ketentuan berlaku. Terbatas untuk 50 orang pertama.'],
            ['key' => 'promo_cta_text', 'value' => 'Klaim Promo Sekarang'],
            ['key' => 'promo_cta_link', 'value' => '?promo=COREFIX20#booking'],

            // About Section
            ['key' => 'about_title', 'value' => 'Tentang Kami'],
            ['key' => 'about_subtitle', 'value' => 'Mitra Terpercaya untuk Perbaikan Gadget Anda'],
            ['key' => 'about_content_1', 'value' => 'CoreFix hadir sebagai solusi untuk segala masalah smartphone Anda. Kami mengerti betapa pentingnya gadget dalam produktivitas sehari-hari. Oleh karena itu, kami berkomitmen memberikan layanan perbaikan yang cepat, transparan, dan berkualitas tinggi.'],
            ['key' => 'about_content_2', 'value' => 'Didukung oleh tim teknisi yang berpengalaman dan tersertifikasi, serta penggunaan sparepart original, kami menjamin kepuasan setiap pelanggan. Mulai dari ganti LCD, baterai, hingga perbaikan mesin, kami siap membantu.'],
            ['key' => 'about_exp_years', 'value' => '5+'],
            ['key' => 'about_exp_label', 'value' => 'Tahun Pengalaman'],
            ['key' => 'about_devices_count', 'value' => '10k+'],
            ['key' => 'about_devices_label', 'value' => 'Device Diperbaiki'],
            ['key' => 'about_satisfaction_percent', 'value' => '99%'],
            ['key' => 'about_satisfaction_label', 'value' => 'Pelanggan Puas'],

            // Why Choose Us Section
            ['key' => 'why_title', 'value' => 'Kenapa Memilih Kami?'],
            ['key' => 'why_subtitle', 'value' => 'Standar Kualitas Tertinggi untuk Gadget Kesayanganmu'],

            // CTA Section
            ['key' => 'cta_title', 'value' => 'Siap Membuat HP-mu Seperti Baru?'],
            ['key' => 'cta_subtitle', 'value' => 'Jangan biarkan kerusakan menghambat produktivitasmu. Konsultasikan masalah handphone kamu dengan tim ahli kami sekarang juga.'],
            ['key' => 'cta_button_text', 'value' => 'Konsultasi Sekarang'],

            // Footer Section
            ['key' => 'footer_description', 'value' => 'Penyedia jasa service handphone terpercaya dengan standar kualitas tinggi dan garansi kepuasan pelanggan.'],
            ['key' => 'footer_address', 'value' => 'Toko Perumahan Taman Sari (Paling Utara), Jl. Sri Agung, Debong Kidul, Botomulyo, Kec. Cepiring, Kabupaten Kendal, Jawa Tengah 51357, Debong Kidul, Botomulyo, Kec. Cepiring, Kabupaten Kendal, Jawa Tengah 51352'],
            ['key' => 'footer_telephone', 'value' => '089509045088'],
            ['key' => 'footer_instagram', 'value' => 'https://instagram.com/corefix.id'],
            ['key' => 'footer_facebook', 'value' => 'https://facebook.com/corefix.id'],
        ];

        foreach ($contents as $content) {
            \App\Models\LandingPage::updateOrCreate(['key' => $content['key']], ['value' => $content['value']]);
        }
    }
}

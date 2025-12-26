<?php

/**
 * Script untuk memperbaiki link storage di cPanel.
 * Simpan file ini di folder 'public' (atau root public_html) lalu panggil lewat browser.
 * Contoh: https://krupukruzzz.com/fix-links.php
 */

$storagePath = __DIR__ . '/../storage/app/public';
$linkPath = __DIR__ . '/storage';

echo "<h3>Laravel Storage Link Fixer</h3>";

// 1. Cek folder asal
if (!is_dir($storagePath)) {
    // Jika path di atas tidak ketemu, coba path alternatif (tergantung struktur folder cPanel)
    $storagePath = __DIR__ . '/../repositories/krupukruzzz/storage/app/public';
}

if (!is_dir($storagePath)) {
    echo "❌ Error: Folder sumber tidak ditemukan. <br>";
} else {
    echo "✅ Folder sumber ditemukan: $storagePath <br>";
}

// 2. Hapus link lama jika ada (mungkin rusak)
if (is_link($linkPath) || is_dir($linkPath)) {
    echo "⚠️ Link/Folder lama ditemukan, mencoba menghapus... ";
    if (PHP_OS === 'WINNT') {
        @rmdir($linkPath);
    } else {
        @unlink($linkPath);
    }
    echo "Done.<br>";
}

// 3. Buat symbolic link baru
try {
    if (symlink($storagePath, $linkPath)) {
        echo "🚀 <b>BERHASIL!</b> Symbolic link baru telah dibuat.<br>";
        echo "Sekarang folder 'public_html/storage' sudah terhubung ke 'storage/app/public'.<br>";
    } else {
        echo "❌ Gagal membuat symbolic link secara otomatis.<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<br><p><i>Jangan lupa hapus file 'fix-links.php' ini nanti bung.</i></p>";

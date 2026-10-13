<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting test...\n";

// Test script untuk mengecek apakah presenter bekerja tanpa error
require_once __DIR__ . '/vendor/autoload.php';

echo "Autoload loaded...\n";

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
echo "App loaded...\n";

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
echo "Kernel loaded...\n";

$kernel->bootstrap();
echo "Kernel bootstrapped...\n";

try {
    // Test instantiate presenter
    $presenter = new App\Http\AdminlteCustomPresenter();
    echo "✅ AdminlteCustomPresenter berhasil diinisialisasi\n";
    
    // Test method groupMenuByCategory exists
    $reflection = new ReflectionClass($presenter);
    $method = $reflection->getMethod('groupMenuByCategory');
    $method->setAccessible(true);
    
    // Test dengan sample menu
    $sampleMenus = [
        (object)['title' => 'Beranda', 'url' => '/home'],
        (object)['title' => 'Produk', 'url' => '/products'],
        (object)['title' => 'Laporan', 'url' => '/reports']
    ];
    
    $result = $method->invoke($presenter, $sampleMenus);
    echo "✅ Method groupMenuByCategory bekerja\n";
    echo "✅ Kategori yang terdeteksi: " . implode(', ', array_keys($result)) . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} catch (Throwable $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";

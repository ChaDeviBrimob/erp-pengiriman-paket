<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Final Route Test for inventorymanagement.index...\n";

if (Route::has('inventorymanagement.index')) {
    echo "✅ SUCCESS: Route 'inventorymanagement.index' exists!\n";
    echo "URL: " . route('inventorymanagement.index') . "\n";
} else {
    echo "❌ FAILED: Route still not found!\n";
}

echo "\nDone.\n";

<?php

// Simple test script to check if InventoryManagement routes are working
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing InventoryManagement Module Routes...\n\n";

// Check if the route exists
if (Route::has('inventorymanagement.index')) {
    echo "✅ Route 'inventorymanagement.index' exists!\n";
    echo "URL: " . route('inventorymanagement.index') . "\n";
} else {
    echo "❌ Route 'inventorymanagement.index' does not exist!\n";
}

// Check if some other key routes exist
$routes_to_check = [
    'inventorymanagement.showInventoryList',
    'inventorymanagement.create_new_inventory',
    'inventorymanagement.install.index'
];

foreach ($routes_to_check as $route) {
    if (Route::has($route)) {
        echo "✅ Route '$route' exists!\n";
    } else {
        echo "❌ Route '$route' does not exist!\n";
    }
}

// Check if the controller exists
if (class_exists('Modules\InventoryManagement\Http\Controllers\InventoryManagementController')) {
    echo "✅ InventoryManagementController exists!\n";
} else {
    echo "❌ InventoryManagementController does not exist!\n";
}

echo "\nTest completed.\n";

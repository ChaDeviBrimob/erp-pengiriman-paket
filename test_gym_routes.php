<?php

// Simple test script to check if Gym routes are working
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing Gym Module Routes...\n\n";

// Check if the route exists
if (Route::has('member_scanner')) {
    echo "✅ Route 'member_scanner' exists!\n";
    echo "URL: " . route('member_scanner') . "\n";
} else {
    echo "❌ Route 'member_scanner' does not exist!\n";
}

// Check if gym.index exists
if (Route::has('gym.index')) {
    echo "✅ Route 'gym.index' exists!\n";
    echo "URL: " . route('gym.index') . "\n";
} else {
    echo "❌ Route 'gym.index' does not exist!\n";
}

// Check if gym.member_scanner exists
if (Route::has('gym.member_scanner')) {
    echo "✅ Route 'gym.member_scanner' exists!\n";
    echo "URL: " . route('gym.member_scanner') . "\n";
} else {
    echo "❌ Route 'gym.member_scanner' does not exist!\n";
}

// Check if the controller exists
if (class_exists('Modules\Gym\Http\Controllers\MemberController')) {
    echo "✅ MemberController exists!\n";
} else {
    echo "❌ MemberController does not exist!\n";
}

echo "\nTest completed.\n";

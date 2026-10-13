<?php

// Simple test script to check if ZatcaIntegrationKsa routes are working
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing ZatcaIntegrationKsa Module Routes...\n\n";

// Check if the route exists
if (Route::has('zatcaintegrationksa.index')) {
    echo "✅ Route 'zatcaintegrationksa.index' exists!\n";
    echo "URL: " . route('zatcaintegrationksa.index') . "\n";
} else {
    echo "❌ Route 'zatcaintegrationksa.index' does not exist!\n";
}

// Check if the controller exists
if (class_exists('Modules\ZatcaIntegrationKsa\Http\Controllers\ZatcaIntegrationKsaController')) {
    echo "✅ ZatcaIntegrationKsaController exists!\n";
} else {
    echo "❌ ZatcaIntegrationKsaController does not exist!\n";
}

// Check if the invoice controller exists
if (class_exists('Modules\ZatcaIntegrationKsa\Http\Controllers\ZatcaInvoiceController')) {
    echo "✅ ZatcaInvoiceController exists!\n";
} else {
    echo "❌ ZatcaInvoiceController does not exist!\n";
}

echo "\nTest completed.\n";

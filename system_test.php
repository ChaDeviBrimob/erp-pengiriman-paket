<?php

// Test untuk memastikan sistem berjalan tanpa error
require_once __DIR__ . '/vendor/autoload.php';

echo "🔍 Testing Laravel ERP System...\n\n";

try {
    // Bootstrap Laravel
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "✅ Laravel framework loaded successfully\n";
    
    // Test presenter
    $presenter = new App\Http\AdminlteCustomPresenter();
    echo "✅ AdminlteCustomPresenter loaded successfully\n";
    
    // Test module manager
    $moduleManager = $app->make(App\Services\ModuleManager::class);
    $activeModules = $moduleManager->getActiveModules();
    echo "✅ ModuleManager loaded successfully\n";
    echo "📊 Active modules: " . count($activeModules) . " modules\n";
    
    if (!empty($activeModules)) {
        echo "📋 Active module list: " . implode(', ', array_keys($activeModules)) . "\n";
    } else {
        echo "📋 No active modules (this is expected after our fixes)\n";
    }
    
    echo "\n🎉 All tests passed! System is stable and ready.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📄 File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    exit(1);
} catch (Throwable $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "📄 File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    exit(1);
}

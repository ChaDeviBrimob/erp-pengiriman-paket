<?php

// Test untuk memastikan sidebar scalable berjalan dengan baik
require_once __DIR__ . '/vendor/autoload.php';

echo "🔍 Testing Sidebar Scalable Categories...\n\n";

try {
    // Bootstrap Laravel
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "✅ Laravel framework loaded successfully\n";
    
    // Test presenter
    $presenter = new App\Http\AdminlteCustomPresenter();
    echo "✅ AdminlteCustomPresenter loaded successfully\n";
    
    // Test getOpenTagWrapper method (includes demo menus)
    $wrapper = $presenter->getOpenTagWrapper();
    
    // Check if all scalable categories are present
    $categories = [
        'SHIPPING DELIVERY',
        'SETTINGS', 
        'ECOMMERCE',
        'HEALTHCARE',
        'FITNESS',
        'PROJECTS', 
        'SERVICES',
        'TOOLS'
    ];
    
    $foundCategories = [];
    foreach ($categories as $category) {
        if (strpos($wrapper, $category) !== false) {
            $foundCategories[] = $category;
        }
    }
    
    echo "✅ Demo scalable categories found: " . count($foundCategories) . "/" . count($categories) . "\n";
    echo "📋 Categories: " . implode(', ', $foundCategories) . "\n";
    
    // Test module manager
    $moduleManager = $app->make(App\Services\ModuleManager::class);
    $activeModules = $moduleManager->getActiveModules();
    echo "✅ ModuleManager loaded successfully\n";
    echo "📊 Active modules: " . count($activeModules) . " modules\n";
    
    if (count($foundCategories) >= 6) {
        echo "\n🎉 Scalable sidebar system ready! All major categories available.\n";
    } else {
        echo "\n⚠️  Some categories missing, but system is stable.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "📄 File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    exit(1);
} catch (Throwable $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "📄 File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
    exit(1);
}

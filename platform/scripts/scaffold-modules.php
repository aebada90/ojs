<?php

/**
 * Scaffolds modular architecture for EventOS / TourismOS platform.
 */
$basePath = dirname(__DIR__);

$modules = [
    'Core', 'Auth', 'Marketplace', 'Rental', 'Hotel', 'Property', 'Restaurant',
    'Vendor', 'Events', 'Payments', 'AI', 'Admin', 'CMS', 'Analytics',
    'Notifications', 'DigitalTwin', 'Jobs', 'Experience', 'Services',
    'Search', 'Review', 'Messaging', 'Ecommerce',
];

$moduleDescriptions = [
    'Core' => 'Platform core utilities and shared services',
    'Auth' => 'Authentication, social login, 2FA, and role management',
    'Marketplace' => 'Multi-vendor marketplace and storefronts',
    'Rental' => 'Rent anything — vehicles, equipment, properties',
    'Hotel' => 'Hotels, hostels, apartments, and accommodation booking',
    'Property' => 'Buy, sell, and rent real estate listings',
    'Restaurant' => 'Restaurant reservations, menus, and delivery',
    'Vendor' => 'Vendor dashboards, payouts, and store management',
    'Events' => 'Event ticketing and festival management',
    'Payments' => 'Stripe, PayPal, wallet, and vendor payouts',
    'AI' => 'AI assistant, recommendations, and content generation',
    'Admin' => 'Super admin panel and platform configuration',
    'CMS' => 'Pages, blogs, news, and media library',
    'Analytics' => 'Reports, metrics, and business intelligence',
    'Notifications' => 'Email, push, SMS-ready, and in-app alerts',
    'DigitalTwin' => 'Interactive live map with layered data',
    'Jobs' => 'Job board, applications, and employer tools',
    'Experience' => 'Tours, activities, and guided experiences',
    'Services' => 'Service marketplace — guides, drivers, stylists',
    'Search' => 'Universal search across all platform content',
    'Review' => 'Reviews, ratings, and verified purchase feedback',
    'Messaging' => 'Customer-vendor messaging with attachments',
    'Ecommerce' => 'Cart, checkout, orders, and fulfillment',
];

foreach ($modules as $module) {
    $slug = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $module));
    $namespace = "Modules\\{$module}";
    $modulePath = "{$basePath}/modules/{$module}";

    $dirs = [
        "{$modulePath}/Providers",
        "{$modulePath}/Http/Controllers/Web",
        "{$modulePath}/Http/Controllers/Api",
        "{$modulePath}/Http/Requests",
        "{$modulePath}/Http/Middleware",
        "{$modulePath}/Models",
        "{$modulePath}/Repositories/Contracts",
        "{$modulePath}/Repositories/Eloquent",
        "{$modulePath}/Services",
        "{$modulePath}/Policies",
        "{$modulePath}/Database/Migrations",
        "{$modulePath}/Database/Seeders",
        "{$modulePath}/Database/Factories",
        "{$modulePath}/Resources/views",
        "{$modulePath}/Livewire",
        "{$modulePath}/routes",
        "{$modulePath}/config",
    ];

    foreach ($dirs as $dir) {
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    $enabled = $module !== 'Core' ? 'true' : 'true';
    $description = $moduleDescriptions[$module] ?? "{$module} module";

    file_put_contents("{$modulePath}/config/module.php", <<<PHP
<?php

return [
    'name' => '{$module}',
    'slug' => '{$slug}',
    'description' => '{$description}',
    'version' => '1.0.0',
    'enabled' => {$enabled},
    'dependencies' => [],
];
PHP);

    file_put_contents("{$modulePath}/routes/web.php", <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('{$slug}')->name('{$slug}.')->group(function (): void {
    // {$module} web routes
});
PHP);

    file_put_contents("{$modulePath}/routes/api.php", <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1/{$slug}')->name('api.{$slug}.')->group(function (): void {
    // {$module} API routes
});
PHP);

    file_put_contents("{$modulePath}/Providers/{$module}ServiceProvider.php", <<<PHP
<?php

namespace {$namespace}\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class {$module}ServiceProvider extends BaseModuleServiceProvider
{
    protected string \$module = '{$module}';

    public function registerModule(): void
    {
        // Register {$module} bindings
    }

    public function bootModule(): void
    {
        // Boot {$module} services
    }
}
PHP);
}

echo "Scaffolded ".count($modules)." modules.\n";

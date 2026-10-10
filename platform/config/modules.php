<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Platform Modules
    |--------------------------------------------------------------------------
    | Each module can be enabled or disabled independently.
    | Disabled modules will not load routes, views, or service providers.
    */
    'modules' => [
        'Core' => ['enabled' => true, 'dependencies' => []],
        'Auth' => ['enabled' => true, 'dependencies' => ['Core']],
        'Search' => ['enabled' => true, 'dependencies' => ['Core']],
        'CMS' => ['enabled' => true, 'dependencies' => ['Core']],
        'Vendor' => ['enabled' => true, 'dependencies' => ['Core', 'Auth']],
        'Marketplace' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor']],
        'Ecommerce' => ['enabled' => true, 'dependencies' => ['Marketplace', 'Payments']],
        'Rental' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor', 'Payments']],
        'Hotel' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor', 'Payments']],
        'Property' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor']],
        'Restaurant' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor', 'Payments']],
        'Experience' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor', 'Payments']],
        'Services' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor']],
        'Events' => ['enabled' => true, 'dependencies' => ['Core', 'Vendor', 'Payments']],
        'Jobs' => ['enabled' => true, 'dependencies' => ['Core', 'Auth']],
        'Payments' => ['enabled' => true, 'dependencies' => ['Core']],
        'Review' => ['enabled' => true, 'dependencies' => ['Core']],
        'Messaging' => ['enabled' => true, 'dependencies' => ['Core', 'Auth']],
        'Notifications' => ['enabled' => true, 'dependencies' => ['Core']],
        'AI' => ['enabled' => true, 'dependencies' => ['Core']],
        'DigitalTwin' => ['enabled' => true, 'dependencies' => ['Core', 'Search']],
        'Analytics' => ['enabled' => true, 'dependencies' => ['Core']],
        'Admin' => ['enabled' => true, 'dependencies' => ['Core', 'Auth']],
    ],

    'module_path' => base_path('modules'),
];

# Database Switch
Laravel library to switching database connection using middleware

### Requirement
- PHP >= 7.2
- Laravel >= 5.6

### Installation
- Install with composer
```bash
composer require dxtrasia/database-switch
```

### Database configuration
- Add database configuration
```php
// config/database.php

/**
 * Database connection by country
 *
 * This configuration will replace the connection configuration On The Fly
 *
 * @see \App\Http\Middleware\DatabaseManagerMiddleware
 */
'country' => [
    'ID' => [ // country code
        'mysql' => [ // connection name
            'read' => [
                'host' => env('DB_ID_HOST_READ', 'localhostID'),
            ],
            'write' => [
                'host' => env('DB_ID_HOST_WRITE', 'localhostID'),
            ],
            'sticky' => true,
            'driver' => 'mysql',
            'port' => env('DB_ID_PORT', '3306'),
            'database' => env('DB_ID_DATABASE', 'forge'),
            'username' => env('DB_ID_USERNAME', 'forge'),
            'password' => env('DB_ID_PASSWORD', ''),
            'unix_socket' => env('DB_ID_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]
    ]
],
```


### How to Use
- Register middleware to the kernel
```php
// app/Http/Kernel.php

// Register to Global middleware
protected $middleware = [
    // ...
    \Dxtrasia\DatabaseSwitch\DatabaseSwitchMiddleware::class
];

// or register to route middleware
protected $routeMiddleware = [
    // ...
    'db.switch' => \Dxtrasia\DatabaseSwitch\DatabaseSwitchMiddleware::class
];
```
- Lumen registration
```php
// bootstrap/app.php

// Register to Global middleware
$app->middleware([
    // ...
    \Dxtrasia\DatabaseSwitch\DatabaseSwitchMiddleware::class
]);

// or register to route middleware
$app->routeMiddleware([
    // ...
    'db.switch' => \Dxtrasia\DatabaseSwitch\DatabaseSwitchMiddleware::class
]);
```
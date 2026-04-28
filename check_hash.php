<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = new \App\Models\User();
$user->password = 'password';
echo "Plain set: " . $user->password . "\n";

$user->password = Hash::make('password');
echo "Hashed set: " . $user->password . "\n";

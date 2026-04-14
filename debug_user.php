<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('username', 'admin')->first();
if (! $user) {
    echo 'Admin user not found' . PHP_EOL;
    exit(1);
}

echo 'User: ' . $user->name . PHP_EOL;
echo 'Photo field: ' . ($user->photo ?? 'null') . PHP_EOL;
if ($user->photo) {
    echo 'Public URL: ' . asset('storage/' . $user->photo) . PHP_EOL;
    echo 'Storage exists: ' . (Storage::disk('public')->exists($user->photo) ? 'yes' : 'no') . PHP_EOL;
}

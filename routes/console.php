<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('logs:clear', function () {
    $logPath = storage_path('logs');
    foreach (glob($logPath.'/*.log') as $file) {
        file_put_contents($file, ''); // truncate instead of delete
    }
    $this->comment('All Laravel log files have been cleared!');
})->describe('Clear all Laravel log files (safe truncate)');

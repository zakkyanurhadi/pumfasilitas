<?php
// Test file untuk debug email

// Load CodeIgniter
require_once __DIR__ . '/vendor/codeigniter4/framework/system/bootstrap.php';

// Load the .env
$dotenv = new \CodeIgniter\Config\DotEnv(ROOTPATH);
$dotenv->load();

echo "=== Email Configuration Test ===\n\n";

// Tampilkan konfigurasi yang terbaca
echo "From Email: " . env('email.fromEmail', 'NOT SET') . "\n";
echo "From Name: " . env('email.fromName', 'NOT SET') . "\n";
echo "SMTP Host: " . env('email.SMTPHost', 'NOT SET') . "\n";
echo "SMTP User: " . env('email.SMTPUser', 'NOT SET') . "\n";
echo "SMTP Pass: " . (env('email.SMTPPass') ? 'SET (' . strlen(env('email.SMTPPass')) . ' chars)' : 'NOT SET') . "\n";
echo "SMTP Port: " . env('email.SMTPPort', 'NOT SET') . "\n";
echo "SMTP Crypto: " . env('email.SMTPCrypto', 'NOT SET') . "\n";

echo "\n=== End Test ===\n";

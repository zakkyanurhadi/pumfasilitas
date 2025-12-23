<?php

namespace App\Controllers;

class TestEmail extends BaseController
{
    public function index()
    {
        // Tampilkan konfigurasi email
        $config = new \Config\Email();
        
        $output = "<h2>Email Configuration Debug</h2>";
        $output .= "<pre>";
        $output .= "From Email: " . $config->fromEmail . "\n";
        $output .= "From Name: " . $config->fromName . "\n";
        $output .= "SMTP Host: " . $config->SMTPHost . "\n";
        $output .= "SMTP User: " . $config->SMTPUser . "\n";
        $output .= "SMTP Pass: " . (strlen($config->SMTPPass) > 0 ? 'SET (' . strlen($config->SMTPPass) . ' chars)' : 'NOT SET') . "\n";
        $output .= "SMTP Port: " . $config->SMTPPort . "\n";
        $output .= "SMTP Crypto: " . $config->SMTPCrypto . "\n";
        $output .= "Protocol: " . $config->protocol . "\n";
        $output .= "Mail Type: " . $config->mailType . "\n";
        $output .= "</pre>";
        
        return $output;
    }
    
    public function send()
    {
        $email = \Config\Services::email();
        
        // Set email tujuan (ganti dengan email test Anda)
        $testEmail = $this->request->getGet('to') ?? 'test@example.com';
        
        $email->setTo($testEmail);
        $email->setSubject('Test Email dari E-Fasilitas');
        $email->setMessage('<h1>Test Email</h1><p>Ini adalah email test dari sistem E-Fasilitas.</p>');
        
        if ($email->send()) {
            return "✅ Email berhasil dikirim ke: " . $testEmail;
        } else {
            $debugger = $email->printDebugger(['headers', 'subject', 'body']);
            return "<h2>❌ Gagal mengirim email</h2><pre>" . $debugger . "</pre>";
        }
    }
}

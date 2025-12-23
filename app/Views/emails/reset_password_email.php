<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - E-Fasilitas Polinela</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7fa;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 40px 30px; text-align: center; border-radius: 16px 16px 0 0;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700;">
                                🏛️ E-Fasilitas Polinela
                            </h1>
                            <p style="color: rgba(255, 255, 255, 0.9); margin: 10px 0 0 0; font-size: 14px;">
                                Sistem Pengaduan Fasilitas Kampus
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #1e3a8a; margin: 0 0 20px 0; font-size: 24px;">
                                🔐 Permintaan Reset Password
                            </h2>
                            
                            <p style="color: #64748b; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                Halo <strong style="color: #1e293b;"><?= esc($nama) ?></strong>,
                            </p>
                            
                            <p style="color: #64748b; font-size: 16px; line-height: 1.6; margin: 0 0 30px 0;">
                                Kami menerima permintaan untuk mereset password akun E-Fasilitas Anda. 
                                Klik tombol di bawah ini untuk membuat password baru:
                            </p>
                            
                            <!-- CTA Button -->
                            <table role="presentation" style="margin: 0 auto 30px auto;">
                                <tr>
                                    <td style="border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);">
                                        <a href="<?= esc($resetLink) ?>" target="_blank" style="display: inline-block; padding: 16px 40px; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600;">
                                            ✨ Reset Password Sekarang
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Warning Box -->
                            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px;">
                                <p style="color: #92400e; font-size: 14px; margin: 0;">
                                    ⚠️ <strong>Penting:</strong> Link ini hanya berlaku selama <strong>1 jam</strong>. 
                                    Jika kadaluarsa, silakan request ulang.
                                </p>
                            </div>
                            
                            <!-- Alternative Link -->
                            <p style="color: #94a3b8; font-size: 13px; line-height: 1.6; margin: 0 0 10px 0;">
                                Jika tombol di atas tidak berfungsi, copy dan paste link berikut ke browser Anda:
                            </p>
                            <p style="background-color: #f1f5f9; padding: 12px 15px; border-radius: 8px; word-break: break-all; font-size: 12px; color: #3b82f6; margin: 0 0 30px 0;">
                                <?= esc($resetLink) ?>
                            </p>
                            
                            <!-- Security Note -->
                            <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 15px 20px; border-radius: 8px;">
                                <p style="color: #991b1b; font-size: 14px; margin: 0;">
                                    🚫 Jika Anda <strong>tidak</strong> meminta reset password ini, 
                                    abaikan email ini. Keamanan akun Anda tetap terjaga.
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 30px; text-align: center; border-radius: 0 0 16px 16px; border-top: 1px solid #e2e8f0;">
                            <p style="color: #94a3b8; font-size: 13px; margin: 0 0 10px 0;">
                                Email ini dikirim secara otomatis oleh sistem E-Fasilitas Polinela.
                            </p>
                            <p style="color: #94a3b8; font-size: 13px; margin: 0;">
                                © <?= date('Y') ?> Politeknik Negeri Lampung. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
                
                <!-- Bottom Text -->
                <p style="color: #94a3b8; font-size: 12px; margin: 20px 0 0 0;">
                    Butuh bantuan? Hubungi tim support kami.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

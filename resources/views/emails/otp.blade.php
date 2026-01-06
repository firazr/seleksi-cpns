<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kode Verifikasi Email</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7fa; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 50%, #581c87 100%); padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">CPNS 2025</h1>
            <p style="color: rgba(255, 255, 255, 0.8); margin: 10px 0 0 0;">Portal Persiapan CPNS</p>
        </div>
        
        <!-- Content -->
        <div style="padding: 40px 30px;">
            <h2 style="color: #1f2937; margin: 0 0 20px 0; font-size: 24px;">Verifikasi Email Anda</h2>
            
            <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                Halo <strong>{{ $name }}</strong>,
            </p>
            
            <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 30px 0;">
                Terima kasih telah mendaftar di CPNS 2025. Gunakan kode OTP berikut untuk memverifikasi email Anda:
            </p>
            
            <!-- OTP Code -->
            <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%); border-radius: 12px; padding: 30px; text-align: center; margin: 0 0 30px 0;">
                <p style="color: rgba(255, 255, 255, 0.8); margin: 0 0 10px 0; font-size: 14px;">Kode OTP Anda:</p>
                <h1 style="color: #ffffff; margin: 0; font-size: 48px; letter-spacing: 10px; font-weight: bold;">{{ $otp }}</h1>
            </div>
            
            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 8px; margin: 0 0 30px 0;">
                <p style="color: #92400e; margin: 0; font-size: 14px;">
                    <strong>⚠️ Perhatian:</strong> Kode ini akan kadaluarsa dalam <strong>10 menit</strong>. Jangan bagikan kode ini kepada siapapun.
                </p>
            </div>
            
            <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin: 0;">
                Jika Anda tidak merasa mendaftar di CPNS 2025, abaikan email ini.
            </p>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                © {{ date('Y') }} CPNS 2025. Semua hak dilindungi.
            </p>
        </div>
    </div>
</body>
</html>

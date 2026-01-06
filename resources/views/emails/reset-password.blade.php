<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
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
            <h2 style="color: #1f2937; margin: 0 0 20px 0; font-size: 24px;">Reset Password</h2>
            
            <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                Halo <strong>{{ $name }}</strong>,
            </p>
            
            <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 30px 0;">
                Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah ini untuk membuat password baru:
            </p>
            
            <!-- Reset Button -->
            <div style="text-align: center; margin: 0 0 30px 0;">
                <a href="{{ $resetLink }}" style="display: inline-block; background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 12px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);">
                    Reset Password
                </a>
            </div>
            
            <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;">
                Atau salin dan tempel link berikut di browser Anda:
            </p>
            
            <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 0 0 30px 0; word-break: break-all;">
                <a href="{{ $resetLink }}" style="color: #2563eb; font-size: 14px; text-decoration: none;">{{ $resetLink }}</a>
            </div>
            
            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 8px; margin: 0 0 30px 0;">
                <p style="color: #92400e; margin: 0; font-size: 14px;">
                    <strong>⚠️ Perhatian:</strong> Link ini akan kadaluarsa dalam <strong>60 menit</strong>. Jika Anda tidak meminta reset password, abaikan email ini.
                </p>
            </div>
            
            <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin: 0;">
                Untuk keamanan, link reset password hanya dapat digunakan satu kali.
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

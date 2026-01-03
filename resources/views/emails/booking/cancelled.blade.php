<!DOCTYPE html>
<html lang="vi" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hủy Đặt Chỗ</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f7fa;color:#333;">
    <!-- Container -->
    <div style="max-width:600px;margin:40px auto;background:#fff;border-radius:24px;
                box-shadow:0 10px 30px rgba(0,0,0,0.08);border:1px solid #eaeaea;">
        
        <!-- Header -->
        <div style="background:linear-gradient(135deg,#7a1f1f,#000);
                    padding:40px 30px;text-align:center;color:white;">
            <h1 style="margin:0;font-size:24px;font-weight:600;">
                Đặt Chỗ Đã Bị Hủy ❌
            </h1>
        </div>

        <!-- Body -->
        <div style="padding:40px 30px 50px;">
            <h2 style="font-size:20px;font-weight:600;color:#111;margin-bottom:16px;">
                Xin chào {{ $data['name'] ?? 'Quý khách' }},
            </h2>

            <p style="font-size:15px;line-height:1.8;color:#444;">
                Đặt chỗ của bạn vào ngày 
                <strong>{{ \Carbon\Carbon::parse($data['booking_date'])->format('d/m/Y') }}</strong> 
                lúc <strong>{{ $data['booking_time'] }}</strong> 
                đã được <strong>hủy thành công</strong>.
            </p>

            <p style="font-size:15px;color:#555;">
                Nếu bạn không thực hiện yêu cầu này, vui lòng liên hệ ngay với đội ngũ hỗ trợ của chúng tôi để được trợ giúp.
            </p>

            <!-- Button -->
            <div style="text-align:center;margin-top:40px;">
                <a href="{{ url('/') }}" 
                   style="display:inline-block;padding:14px 30px;
                          background:linear-gradient(135deg,#111,#444);
                          color:white;font-size:15px;font-weight:500;
                          border-radius:50px;text-decoration:none;
                          box-shadow:0 4px 12px rgba(0,0,0,0.15);
                          transition:all 0.3s ease;"
                   onmouseover="this.style.opacity='0.85'"
                   onmouseout="this.style.opacity='1'">
                    Đặt Chỗ Mới
                </a>
            </div>

            <!-- Footer -->
            <div style="margin-top:50px;text-align:center;font-size:13px;color:#888;">
                <p style="margin-bottom:6px;">Chúng tôi hy vọng sẽ được phục vụ bạn trong thời gian tới 💫</p>
                <p style="margin:0;">— Đội ngũ Web Wizard 🪄</p>
            </div>
        </div>
    </div>

    <!-- Global Footer -->
    <div style="text-align:center;font-size:12px;color:#aaa;margin:20px 0;">
        <p style="margin:0;">© {{ date('Y') }} Web Wizard. Mọi quyền được bảo lưu.</p>
    </div>
</body>
</html>

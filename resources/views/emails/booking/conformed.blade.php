<!DOCTYPE html>
<html lang="vi" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Chỗ</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f7fa;color:#333;">
    <div style="max-width:600px;margin:40px auto;background:linear-gradient(145deg,#ffffff,#f9f9f9);border-radius:24px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.08);border:1px solid #eaeaea;">
        
        <!-- Header -->
        <div style="background:linear-gradient(135deg,#000000,#2b2b2b);padding:40px 30px;text-align:center;color:white;">
            <h1 style="margin:0;font-size:24px;font-weight:600;">Đặt Chỗ Của Bạn Đã Được Xác Nhận ✅</h1>
        </div>

        <!-- Body -->
        <div style="padding:40px 30px 50px;">
            <h2 style="font-size:20px;font-weight:600;color:#111;margin-bottom:16px;">
                Xin chào {{ $data['name'] ?? 'Quý khách' }},
            </h2>

            <p style="font-size:15px;line-height:1.8;color:#444;">
                Chúng tôi rất vui được thông báo rằng đặt chỗ của bạn đã được 
                <strong>xác nhận thành công</strong>.
            </p>

            <!-- Booking Details -->
            <div style="background:#f9fafc;border:1px solid #e0e0e0;border-radius:16px;padding:20px 24px;margin-top:24px;">
                <table style="width:100%;border-collapse:collapse;">
                    <tr>
                        <td style="padding:8px 0;font-weight:600;color:#111;">Ngày:</td>
                        <td style="padding:8px 0;color:#444;">
                            {{ \Carbon\Carbon::parse($data['booking_date'])->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-weight:600;color:#111;">Thời gian:</td>
                        <td style="padding:8px 0;color:#444;">{{ $data['booking_time'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-weight:600;color:#111;">Loại dịch vụ:</td>
                        <td style="padding:8px 0;color:#444;">{{ $data['type'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-weight:600;color:#111;">Số người:</td>
                        <td style="padding:8px 0;color:#444;">{{ $data['people_count'] }}</td>
                    </tr>
                    @if(!empty($data['note']))
                    <tr>
                        <td style="padding:8px 0;font-weight:600;color:#111;">Ghi chú:</td>
                        <td style="padding:8px 0;color:#444;">{{ $data['note'] }}</td>
                    </tr>
                    @endif
                </table>
            </div>

            <!-- Button -->
            <div style="text-align:center;margin-top:40px;">
                <a href="{{ url('/') }}" 
                   style="display:inline-block;padding:14px 30px;background:linear-gradient(135deg,#000000,#444444);
                          color:white;font-size:15px;font-weight:500;border-radius:50px;text-decoration:none;
                          box-shadow:0 4px 12px rgba(0,0,0,0.15);transition:all 0.3s ease;"
                   onmouseover="this.style.opacity='0.85'"
                   onmouseout="this.style.opacity='1'">
                    Xem Chi Tiết Đặt Chỗ
                </a>
            </div>

            <!-- Footer -->
            <div style="margin-top:50px;text-align:center;font-size:13px;color:#888;">
                <p style="margin-bottom:6px;">Chúng tôi rất mong được chào đón bạn trong thời gian sắp tới 🌟</p>
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

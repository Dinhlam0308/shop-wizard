<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Hoàn Tất Đơn Hàng</title>
<style>
    body {
        margin: 0;
        padding: 0;
        background: #f5f5f7;
        color: #1d1d1f;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        line-height: 1.6;
    }
    .container {
        max-width: 620px;
        margin: 40px auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .header {
        background: linear-gradient(135deg, #000, #1f1f1f);
        color: white;
        text-align: center;
        padding: 30px 20px;
    }
    .header h1 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
    }
    .content {
        padding: 30px 25px;
    }
    .content h2 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #1d1d1f;
    }
    .content p {
        margin: 10px 0;
        color: #333;
        font-size: 15px;
    }
    .summary {
        margin-top: 25px;
        padding: 15px;
        background: #f9f9fa;
        border-radius: 12px;
        border: 1px solid #e0e0e0;
    }
    .summary p {
        margin: 6px 0;
        font-size: 14.5px;
    }
    .footer {
        background: #f9f9fa;
        text-align: center;
        padding: 20px;
        color: #6e6e73;
        font-size: 13px;
    }
    @media (prefers-color-scheme: dark) {
        body { background: #1d1d1f; color: #f5f5f7; }
        .container { background: #2c2c2e; }
        .summary { background: #1c1c1e; border-color: #3a3a3c; }
        .footer { background: #1c1c1e; color: #9a9aa1; }
    }
</style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Đơn Hàng Của Bạn Đã Hoàn Tất 🎉</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Xin chào {{ $order->user->name ?? 'Quý khách' }},</h2>
            <p>Chúng tôi vui mừng thông báo rằng đơn hàng <strong>#{{ $order->id }}</strong> của bạn đã được xử lý và <strong>hoàn tất thành công</strong>.</p>

            <div class="summary">
                <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Tổng giá trị:</strong> {{ number_format($order->total, 0, ',', '.') }}₫</p>
                <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method ?? 'Chưa xác định' }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
            </div>

            <p style="margin-top: 24px;">
                Cảm ơn bạn đã tin tưởng và lựa chọn dịch vụ của chúng tôi.  
                Rất mong được phục vụ bạn trong những lần tiếp theo!
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Wizard Inc. Mọi quyền được bảo lưu.</p>
            <p>Đây là email tự động, vui lòng không trả lời.</p>
        </div>
    </div>
</body>
</html>

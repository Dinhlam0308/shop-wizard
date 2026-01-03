<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đơn Hàng Của Bạn</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f6f8fa;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 680px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(120deg, #000000, #333333);
            color: white;
            text-align: center;
            padding: 36px 24px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 32px;
        }
        .content h2 {
            font-size: 18px;
            margin-top: 0;
            color: #111;
        }
        .order-summary {
            border-collapse: collapse;
            width: 100%;
            margin-top: 16px;
        }
        .order-summary th, .order-summary td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .order-summary th {
            font-weight: 600;
            color: #555;
            background-color: #fafafa;
        }
        .order-summary td {
            color: #333;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: 600;
            margin-top: 20px;
            color: #000;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            padding: 24px;
            border-top: 1px solid #eee;
            background-color: #fafafa;
        }
        .btn {
            display: inline-block;
            padding: 12px 28px;
            background-color: #000;
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-radius: 10px;
            margin-top: 24px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #333;
        }
        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }
            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Cảm Ơn Bạn Đã Đặt Hàng 🎉</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Xin chào <strong>{{ $order['user_name'] ?? 'Quý khách' }}</strong>,</p>
            <p>Chúng tôi rất vui thông báo rằng đơn hàng của bạn đã được đặt thành công.  
               Dưới đây là thông tin chi tiết đơn hàng:</p>

            <h2>Chi Tiết Đơn Hàng</h2>
            <table class="order-summary">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá (₫)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items['items'] as $item)
                        <tr>
                            <td>{{ $item['product_id'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="total">Tổng cộng: <strong>{{ number_format($order['total'], 0, ',', '.') }}₫</strong></p>

            <a href="{{ url('/') }}" class="btn">Xem Đơn Hàng Của Bạn</a>

            <p style="margin-top: 30px; color: #666;">
                Chúng tôi sẽ gửi thêm email khi đơn hàng được giao đến bạn.  
                <br>Cảm ơn bạn đã tin tưởng và lựa chọn Always Café!
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Thiết kế với ❤️ — Cảm hứng từ Always Café.
        </div>
    </div>
</body>
</html>

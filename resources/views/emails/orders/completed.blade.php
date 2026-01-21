<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Completed</title>
<style>
  body{
    margin:0;padding:0;background:#f5f5f7;color:#1d1d1f;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
    line-height:1.6;
  }
  .wrap{padding:28px 16px;}
  .container{
    max-width:680px;margin:0 auto;background:#fff;border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
    overflow:hidden;border:1px solid #e9ebef;
  }
  .header{
    background:linear-gradient(135deg,#0b0b0f,#1c1c22);
    color:#fff;text-align:center;padding:28px 22px;
  }
  .brand{font-size:12px;opacity:.9;letter-spacing:.5px;}
  .title{margin:6px 0 0;font-size:22px;font-weight:900;letter-spacing:.2px;}
  .subtitle{margin:8px 0 0;font-size:13px;opacity:.9;}
  .content{padding:22px;}
  .muted{color:#667085;font-size:13px;}
  .h2{font-size:14px;letter-spacing:.5px;color:#667085;font-weight:900;margin:18px 0 10px;}
  .card{
    background:#fafbfc;border:1px solid #eef0f4;border-radius:14px;
    padding:14px;
  }
  .row{display:flex;gap:12px;flex-wrap:wrap;}
  .col{flex:1;min-width:240px;}
  .kv{margin:6px 0;font-size:13px;}
  .kv b{color:#111;}
  .total{
    font-size:22px;font-weight:900;letter-spacing:.2px;margin-top:6px;color:#111;
  }
  .divider{height:1px;background:#eef0f4;margin:16px 0;}
  .btn{
    display:block;text-align:center;text-decoration:none;
    padding:14px 18px;border-radius:14px;
    background:linear-gradient(135deg,#111,#2b2b2f);
    color:#fff;font-weight:900;
  }
  .footer{
    background:#fbfcfe;border-top:1px solid #eef0f4;
    text-align:center;padding:18px;color:#98a2b3;font-size:12px;
  }
  @media (prefers-color-scheme: dark){
    body{background:#121214;color:#f5f5f7;}
    .container{background:#1c1c1e;border-color:#2b2b2f;}
    .card{background:#121214;border-color:#2b2b2f;}
    .muted,.h2,.footer{color:#b7bcc7;}
    .divider{background:#2b2b2f;}
  }
</style>
</head>

<body>
  <div class="wrap">
    <div class="container">

      <!-- Header -->
      <div class="header">
        <div class="brand">ALWAYS CAFÉ</div>
        <div class="title">Order Completed ✅</div>
        <div class="subtitle">Your order has been completed successfully. Thank you for choosing us!</div>
      </div>

      <!-- Content -->
      <div class="content">
        <div class="muted">
          Hello <b style="color:#111;">{{ $order->user->name ?? 'Customer' }}</b>,
        </div>
        <div class="muted" style="margin-top:6px;">
          Order ID: <b style="color:#111;">#{{ $order->id }}</b>
          &nbsp;&nbsp;•&nbsp;&nbsp;
          Order date: <b style="color:#111;">{{ optional($order->created_at)->format('d/m/Y') }}</b>
        </div>

        <div class="divider"></div>

        <!-- Summary -->
        <div class="h2">SUMMARY</div>
        <div class="card">
          <div class="kv"><b>Status:</b> {{ ucfirst($order->status) }}</div>
          <div class="kv"><b>Payment method:</b> {{ strtoupper($order->payment_method ?? 'N/A') }}</div>
          <div class="kv" style="margin-top:10px;">
            <div class="muted" style="margin-bottom:4px;">Total</div>
            <div class="total">{{ number_format($order->total ?? 0, 0, ',', '.') }}₫</div>
          </div>
        </div>

        <!-- Delivery + Payment -->
        <div class="h2">DELIVERY & PAYMENT</div>
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="muted" style="font-weight:900;letter-spacing:.4px;">DELIVERY TO</div>
              <div class="kv" style="margin-top:10px;">
                <b>{{ $order->receiver_name ?? ($order->user->name ?? 'Customer') }}</b>
              </div>
              <div class="kv">{{ $order->receiver_phone ?? '—' }}</div>
              <div class="kv" style="color:#667085;">
                {{ $order->shipping_address ?? '—' }}
              </div>
            </div>
          </div>

          <div class="col">
            <div class="card">
              <div class="muted" style="font-weight:900;letter-spacing:.4px;">PAYMENT</div>
              <div class="kv" style="margin-top:10px;"><b>Method:</b> {{ strtoupper($order->payment_method ?? 'N/A') }}</div>
              <div class="kv"><b>Status:</b> {{ $order->payment_status ?? 'Paid' }}</div>

              @if (!empty($order->is_rental))
                <div style="margin-top:10px;display:inline-block;padding:6px 10px;border-radius:999px;
                  background:#111;color:#fff;font-size:12px;font-weight:800;">
                  Rental Order
                </div>
              @endif
            </div>
          </div>
        </div>

        <div style="margin-top:16px;">
          <a class="btn" href="{{ $viewUrl ?? url('/') }}">View Your Order</a>
          <div class="muted" style="text-align:center;margin-top:10px;">
            This is an automated email — please do not reply.
          </div>
        </div>

        <div class="divider"></div>

        <div class="muted">
          Thank you again for your purchase. We hope to see you soon at Always Café ✨
        </div>
      </div>

      <!-- Footer -->
      <div class="footer">
        © {{ date('Y') }} Always Café • All rights reserved.
      </div>

    </div>
  </div>
</body>
</html>

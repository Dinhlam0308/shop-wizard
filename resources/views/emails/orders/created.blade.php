<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Confirmed</title>
</head>

<body style="margin:0;padding:0;background:#f5f6f8;color:#111;
  font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;
  line-height:1.55;">

  <div style="max-width:720px;margin:0 auto;padding:28px 16px;">

    <div style="background:#ffffff;border:1px solid #e9ebef;border-radius:20px;overflow:hidden;
      box-shadow:0 10px 30px rgba(0,0,0,.06);">

      <!-- Header -->
      <div style="padding:22px 22px 16px;background:linear-gradient(135deg,#0b0b0f,#1c1c22);color:#fff;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
          <tr>
            <td style="vertical-align:middle;">
              <div style="font-size:12px;opacity:.9;letter-spacing:.5px;">ALWAYS CAFÉ</div>
              <div style="font-size:22px;font-weight:800;letter-spacing:.2px;margin-top:4px;">
                Order Confirmed ✅
              </div>
              <div style="font-size:13px;opacity:.9;margin-top:6px;">
                Your order has been placed successfully. We’re preparing it now.
              </div>
            </td>
            <td style="text-align:right;vertical-align:middle;">
              <div style="display:inline-block;padding:8px 12px;border-radius:999px;
                background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.18);
                font-size:12px;">
                {{ strtoupper($order['payment_method'] ?? 'PAYMENT') }}
              </div>
            </td>
          </tr>
        </table>
      </div>

      <!-- Buyer Meta -->
      <div style="padding:18px 22px 0;">
        <div style="font-size:13px;color:#667085;">
          Hello <span style="font-weight:800;color:#111;">{{ $order['user_name'] ?? 'Customer' }}</span>,
        </div>

        <div style="font-size:13px;color:#667085;margin-top:6px;">
          Order ID: <span style="font-weight:800;color:#111;">#{{ $order->id ?? '—' }}</span>
          &nbsp;&nbsp;•&nbsp;&nbsp;
          Order date: <span style="font-weight:800;color:#111;">{{ $order['created_at'] ?? date('d/m/Y') }}</span>
        </div>

        @if (!empty($order['user_email']))
          <div style="font-size:13px;color:#667085;margin-top:6px;">
            Buyer email: <span style="font-weight:700;color:#111;">{{ $order['user_email'] }}</span>
          </div>
        @endif
      </div>

      <!-- Divider -->
      <div style="height:1px;background:#eef0f4;margin:14px 22px;"></div>

      <!-- ORDER INFORMATION -->
      <div style="padding:0 22px 6px;">
        <div style="font-size:12px;letter-spacing:.5px;color:#667085;font-weight:800;">
          ORDER INFORMATION
        </div>
      </div>

      <div style="padding:0 22px 0;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
          <thead>
            <tr>
              <th align="left" style="padding:10px 0;border-bottom:1px dashed #d7dbe3;
                font-size:12px;color:#667085;font-weight:800;">
                Item
              </th>
              <th align="center" style="padding:10px 0;border-bottom:1px dashed #d7dbe3;
                font-size:12px;color:#667085;font-weight:800;">
                Qty
              </th>
              <th align="right" style="padding:10px 0;border-bottom:1px dashed #d7dbe3;
                font-size:12px;color:#667085;font-weight:800;">
                Price
              </th>
            </tr>
          </thead>

          <tbody>
            @foreach ($items['items'] as $item)
              <tr>
                <td style="padding:12px 0;border-bottom:1px dashed #e3e6ee;">
                  <div style="font-weight:900;color:#111;">
                    {{ $item['product_name'] ?? ('Product #' . $item['product_id']) }}
                  </div>

                  @if (!empty($item['variant_id']))
                    <div style="margin-top:6px;font-size:12px;color:#667085;">
                      Variant
                      @if (!empty($item['variant']['color']))
                        — Color: <span style="font-weight:800;color:#111;">{{ $item['variant']['color'] }}</span>
                      @endif
                      @if (!empty($item['variant']['size']))
                        — Size: <span style="font-weight:800;color:#111;">{{ $item['variant']['size'] }}</span>
                      @endif
                    </div>
                  @endif

                  @if (!empty($item['rental_start_at']) && !empty($item['rental_end_at']))
                    <div style="margin-top:6px;font-size:12px;color:#667085;">
                      Rental: <span style="font-weight:800;color:#111;">{{ $item['rental_start_at'] }}</span>
                      → <span style="font-weight:800;color:#111;">{{ $item['rental_end_at'] }}</span>
                    </div>
                  @endif
                </td>

                <td align="center" style="padding:12px 0;border-bottom:1px dashed #e3e6ee;
                  color:#111;font-weight:800;">
                  {{ (int)($item['quantity'] ?? 1) }}
                </td>

                <td align="right" style="padding:12px 0;border-bottom:1px dashed #e3e6ee;
                  color:#111;font-weight:900;">
                  {{ number_format((float)($item['price'] ?? 0), 0, ',', '.') }}₫
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div style="padding:14px 0 0;text-align:right;">
          <div style="font-size:12px;color:#667085;">Total</div>
          <div style="font-size:22px;font-weight:900;letter-spacing:.2px;">
            {{ number_format((float)($order['total'] ?? 0), 0, ',', '.') }}₫
          </div>
        </div>
      </div>

      <!-- Divider -->
      <div style="height:1px;background:#eef0f4;margin:18px 22px;"></div>

      <!-- DELIVERY + PAYMENT -->
      <div style="padding:0 22px 18px;">
        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
          <tr>
            <!-- DELIVERY -->
            <td style="width:50%;vertical-align:top;padding-right:10px;">
              <div style="font-size:12px;letter-spacing:.5px;color:#667085;font-weight:900;margin-bottom:8px;">
                DELIVERY TO
              </div>

              <div style="background:#fafbfc;border:1px solid #eef0f4;border-radius:14px;padding:12px;">
                <div style="font-weight:900;color:#111;">
                  {{ $order['receiver_name'] ?? ($order['user_name'] ?? 'Customer') }}
                </div>

                <div style="margin-top:6px;font-size:13px;color:#111;">
                  {{ $order['receiver_phone'] ?? '—' }}
                </div>

                <div style="margin-top:6px;font-size:13px;color:#667085;">
                  {{ $order['shipping_address'] ?? '—' }}
                </div>
              </div>
            </td>

            <!-- PAYMENT -->
            <td style="width:50%;vertical-align:top;padding-left:10px;">
              <div style="font-size:12px;letter-spacing:.5px;color:#667085;font-weight:900;margin-bottom:8px;">
                PAYMENT
              </div>

              <div style="background:#fafbfc;border:1px solid #eef0f4;border-radius:14px;padding:12px;">
                <div style="font-size:13px;color:#667085;">Method</div>
                <div style="font-weight:900;color:#111;margin-top:2px;">
                  {{ strtoupper($order['payment_method'] ?? 'COD') }}
                </div>

                <div style="height:10px;"></div>

                <div style="font-size:13px;color:#667085;">Status</div>
                <div style="font-weight:900;color:#111;margin-top:2px;">
                  {{ $order['payment_status'] ?? 'Cash on Delivery (COD)' }}
                </div>

                @if (!empty($order['is_rental']))
                  <div style="margin-top:10px;display:inline-block;padding:6px 10px;border-radius:999px;
                    background:#111;color:#fff;font-size:12px;font-weight:800;">
                    Rental Order
                  </div>
                @endif
              </div>
            </td>
          </tr>
        </table>
      </div>

      <!-- CTA -->
      <div style="padding:0 22px 22px;">
        <a href="{{ $order['view_url'] ?? url('/') }}"
           style="display:block;text-align:center;text-decoration:none;
            padding:14px 18px;border-radius:14px;
            background:linear-gradient(135deg,#111,#2b2b2f);
            color:#fff;font-weight:900;">
          View Your Order
        </a>

        <div style="font-size:12px;color:#667085;text-align:center;margin-top:10px;">
          If you didn’t place this order, you can safely ignore this email.
        </div>
      </div>

      <!-- Return Policy -->
      <div style="background:#fbfcfe;border-top:1px solid #eef0f4;padding:18px 22px;">
        <div style="font-size:12px;letter-spacing:.5px;color:#667085;font-weight:900;margin-bottom:10px;">
          RETURN POLICY
        </div>

        <div style="font-size:13px;color:#111;">
          • Returns within 2 days if the product is still sealed and undamaged<br/>
          • Returns for defective or damaged products
        </div>

        <div style="margin-top:14px;font-size:13px;color:#667085;">
          Thank you for your order. Always Café is preparing your order now!
        </div>
      </div>

    </div>

    <!-- Footer -->
    <div style="text-align:center;font-size:12px;color:#98a2b3;margin-top:16px;">
      © {{ date('Y') }} Always Café • This is an automated message.
    </div>

  </div>
</body>
</html>

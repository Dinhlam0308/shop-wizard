<!DOCTYPE html>
<html lang="en" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservation Confirmed</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f7;color:#1d1d1f;line-height:1.6;">
  <div style="padding:28px 16px;">
    <div style="
      max-width:680px;margin:0 auto;background:#ffffff;border-radius:20px;
      box-shadow:0 10px 30px rgba(0,0,0,.06);
      overflow:hidden;border:1px solid #e9ebef;
    ">

      <!-- Header -->
      <div style="
        background:linear-gradient(135deg,#0b0b0f,#1c1c22);
        color:#fff;text-align:center;padding:28px 22px;
      ">
        <div style="font-size:12px;opacity:.9;letter-spacing:.6px;font-weight:700;">
          ALWAYS CAFÉ
        </div>

        <div style="margin-top:8px;font-size:22px;font-weight:900;letter-spacing:.2px;">
          Reservation Confirmed ✅
        </div>

        <div style="margin-top:8px;font-size:13px;opacity:.9;">
          Your reservation has been confirmed. See the details below.
        </div>
      </div>

      <!-- Content -->
      <div style="padding:22px;">
        @php
          $customerName  = $data['customer_name'] ?? $data['name'] ?? 'Customer';
          $customerEmail = $data['customer_email'] ?? $data['email'] ?? '—';

          $type   = $data['type'] ?? 'Reservation';
          $date   = !empty($data['booking_date']) ? \Carbon\Carbon::parse($data['booking_date'])->format('d/m/Y') : '—';
          $time   = $data['booking_time'] ?? '—';
          $people = $data['people_count'] ?? '—';
          $note   = $data['note'] ?? null;

          $reservationId = $data['booking_id'] ?? $data['reservation_id'] ?? null;
          $viewUrl = $data['view_url'] ?? url('/');
        @endphp

        <div style="color:#667085;font-size:13px;">
          Hello <b style="color:#111;">{{ $customerName }}</b>,
        </div>

        <div style="margin-top:6px;color:#667085;font-size:13px;">
          @if($reservationId)
            Reservation ID: <b style="color:#111;">#{{ $reservationId }}</b> &nbsp;&nbsp;•&nbsp;&nbsp;
          @endif
          Reservation date: <b style="color:#111;">{{ $date }}</b>
        </div>

        <div style="height:1px;background:#eef0f4;margin:16px 0;"></div>

        <!-- Details card -->
        <div style="font-size:14px;letter-spacing:.5px;color:#667085;font-weight:900;margin:0 0 10px;">
          BOOKING DETAILS
        </div>

        <div style="
          background:#fafbfc;border:1px solid #eef0f4;border-radius:14px;
          padding:14px;
        ">
          <table style="width:100%;border-collapse:collapse;">
            <!-- Name -->
            <tr>
              <td style="padding:8px 0;color:#667085;font-size:13px;width:42%;">Customer name</td>
              <td style="padding:8px 0;color:#111;font-size:13px;font-weight:700;">{{ $customerName }}</td>
            </tr>

            <!-- Email -->
            <tr>
              <td style="padding:8px 0;color:#667085;font-size:13px;">Customer email</td>
              <td style="padding:8px 0;color:#111;font-size:13px;font-weight:700;">{{ $customerEmail }}</td>
            </tr>

            <!-- Type -->
            <tr>
              <td style="padding:8px 0;color:#667085;font-size:13px;">Service type</td>
              <td style="padding:8px 0;color:#111;font-size:13px;font-weight:700;">{{ $type }}</td>
            </tr>

            <!-- Date -->
            <tr>
              <td style="padding:8px 0;color:#667085;font-size:13px;">Date</td>
              <td style="padding:8px 0;color:#111;font-size:13px;font-weight:700;">{{ $date }}</td>
            </tr>

            <!-- Time -->
            <tr>
              <td style="padding:8px 0;color:#667085;font-size:13px;">Time</td>
              <td style="padding:8px 0;color:#111;font-size:13px;font-weight:700;">{{ $time }}</td>
            </tr>

            <!-- Guests -->
            <tr>
              <td style="padding:8px 0;color:#667085;font-size:13px;">Number of guests</td>
              <td style="padding:8px 0;color:#111;font-size:13px;font-weight:700;">{{ $people }}</td>
            </tr>

            <!-- Notes -->
            @if(!empty($note))
              <tr>
                <td style="padding:8px 0;color:#667085;font-size:13px;vertical-align:top;">Notes</td>
                <td style="padding:8px 0;color:#111;font-size:13px;">
                  {{ $note }}
                </td>
              </tr>
            @endif
          </table>
        </div>

        <!-- Notice -->
        <div style="margin-top:14px;color:#667085;font-size:13px;">
          Need to make changes or cancel? Please contact us in advance so we can assist you.
        </div>

        <!-- CTA -->
        <div style="margin-top:18px;">
          <a href="{{ $viewUrl }}"
             style="
              display:block;text-align:center;text-decoration:none;
              padding:14px 18px;border-radius:14px;
              background:linear-gradient(135deg,#111,#2b2b2f);
              color:#fff;font-weight:900;
             ">
            View Your Reservation
          </a>

          <div style="text-align:center;margin-top:10px;color:#98a2b3;font-size:12px;">
            This is an automated email — please do not reply.
          </div>
        </div>

        <div style="height:1px;background:#eef0f4;margin:16px 0;"></div>

        <div style="color:#667085;font-size:13px;">
          We look forward to seeing you at Always Café ✨
        </div>
      </div>

      <!-- Footer -->
      <div style="
        background:#fbfcfe;border-top:1px solid #eef0f4;
        text-align:center;padding:18px;color:#98a2b3;font-size:12px;
      ">
        © {{ date('Y') }} Always Café • All rights reserved.
      </div>

    </div>
  </div>
</body>
</html>

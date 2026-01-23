<!DOCTYPE html>
<html lang="en" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thanks for contacting Always Café</title>
</head>

<body style="margin:0; padding:0; background:#f5f7fa; color:#111;">
  <!-- Preheader (hidden text for inbox preview) -->
  <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">
    We’ve received your message and will get back to you soon.
  </div>

  <div style="max-width:600px; margin:40px auto; padding:0 14px;">
    <!-- Card -->
    <div style="
      background: linear-gradient(145deg, #ffffff, #fbfbfb);
      border: 1px solid #eaeaea;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    ">
      <!-- Header -->
      <div style="
        background: linear-gradient(135deg, #0b0b0b, #3a3a3a);
        padding: 34px 28px;
        text-align:center;
        color:#fff;
      ">
        <div style="font-size:14px; letter-spacing:0.6px; opacity:0.9;">
          WEB WIZARD ✨
        </div>
        <h1 style="margin:10px 0 0; font-size:22px; font-weight:700; letter-spacing:0.2px;">
          Thanks for reaching out
        </h1>
        <p style="margin:10px 0 0; font-size:14px; line-height:1.6; opacity:0.9;">
          Your message has been received. We’ll reply as soon as possible.
        </p>
      </div>

      <!-- Body -->
      <div style="padding: 34px 28px 10px;">
        <h2 style="margin:0 0 10px; font-size:18px; font-weight:700; color:#111;">
          Hi {{ $data['name'] }},
        </h2>

        <p style="margin:0; font-size:15px; line-height:1.8; color:#333;">
          Thank you for contacting <strong>Web Wizard</strong>.  
          Below is a copy of the details we received so you can easily review them.
        </p>

        <div style="margin:26px 0; border-top:1px solid #ececec;"></div>

        <!-- Details -->
        <div style="
          background:#f7f8fb;
          border:1px solid #e6e6e6;
          border-radius: 18px;
          padding: 18px 18px;
        ">
          <div style="font-size:13px; color:#666; margin-bottom:10px; font-weight:600;">
            Contact Details
          </div>

          <!-- row: name -->
          <div style="padding:10px 0; border-top:1px solid #ededed;">
            <div style="font-size:12px; color:#7a7a7a; margin-bottom:4px;">Name</div>
            <div style="font-size:14px; color:#111; font-weight:600;">
              {{ $data['name'] }}
            </div>
          </div>

          <!-- row: email -->
          <div style="padding:10px 0; border-top:1px solid #ededed;">
            <div style="font-size:12px; color:#7a7a7a; margin-bottom:4px;">Email</div>
            <div style="font-size:14px; color:#111; font-weight:600;">
              {{ $data['email'] }}
            </div>
          </div>

          <!-- row: phone -->
          <div style="padding:10px 0; border-top:1px solid #ededed;">
            <div style="font-size:12px; color:#7a7a7a; margin-bottom:4px;">Phone</div>
            <div style="font-size:14px; color:#111; font-weight:600;">
              {{ $data['phone'] ?? '—' }}
            </div>
          </div>

          <!-- message -->
          <div style="padding:12px 0 0; border-top:1px solid #ededed;">
            <div style="font-size:12px; color:#7a7a7a; margin-bottom:8px;">Message</div>
            <div style="
              background:#fff;
              border:1px solid #e7e7e7;
              border-radius: 14px;
              padding: 14px 14px;
              color:#222;
              font-size:14px;
              line-height:1.7;
              white-space: pre-wrap;
            ">
              {{ $data['message'] }}
            </div>
          </div>
        </div>

        <!-- CTA -->
        <div style="text-align:center; margin: 28px 0 18px;">
          <a href="{{ url('https://alwayscafe.vn/') }}"
             style="
               display:inline-block;
               padding: 12px 22px;
               background: linear-gradient(135deg, #0b0b0b, #4a4a4a);
               color:#fff;
               text-decoration:none;
               font-size:14px;
               font-weight:600;
               border-radius: 999px;
               box-shadow: 0 6px 16px rgba(0,0,0,0.18);
             ">
            Back to Web Wizard
          </a>
        </div>

        <p style="margin:0 0 18px; font-size:13px; color:#666; line-height:1.7; text-align:center;">
          Need to update something? Just reply to this email.
        </p>
      </div>

      <!-- Footer inside card -->
      <div style="
        padding: 16px 18px;
        background:#fafafa;
        border-top:1px solid #ededed;
        text-align:center;
        font-size:12px;
        color:#8a8a8a;
      ">
        — Always Café Team
      </div>
    </div>

    <!-- Global footer -->
    <div style="text-align:center; margin:16px 0 0; font-size:12px; color:#a0a0a0;">
      © {{ date('Y') }} Always Café. All rights reserved.
    </div>
  </div>
</body>
</html>

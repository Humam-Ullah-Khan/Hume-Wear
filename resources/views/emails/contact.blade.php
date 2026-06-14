<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f5; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #1c1917; padding: 30px 40px; }
        .header h1 { color: #ffffff; font-size: 20px; margin: 0; letter-spacing: 0.1em; }
        .body { padding: 35px 40px; }
        .label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px; }
        .value { font-size: 15px; color: #1c1917; margin-bottom: 20px; line-height: 1.5; }
        .divider { border: none; border-top: 1px solid #e5e7eb; margin: 25px 0; }
        .message-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px; }
        .footer { padding: 20px 40px; background: #f9fafb; border-top: 1px solid #e5e7eb; }
        .footer p { font-size: 12px; color: #9ca3af; margin: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>HUME WEAR</h1>
        </div>
        <div class="body">
            <p style="font-size: 16px; color: #374151; margin: 0 0 25px 0;">You received a new message from the contact form:</p>

            <div class="label">Name</div>
            <div class="value">{{ $data['name'] }}</div>

            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></div>

            @if(!empty($data['phone']))
            <div class="label">Phone</div>
            <div class="value"><a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a></div>
            @endif

            <hr class="divider">

            <div class="label">Message</div>
            <div class="message-box">
                {!! nl2br(e($data['message'])) !!}
            </div>
        </div>
        <div class="footer">
            <p>This message was sent via the Hume Wear contact form.</p>
        </div>
    </div>
</body>
</html>

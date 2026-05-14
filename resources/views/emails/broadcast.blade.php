<!DOCTYPE html>
<html>
<head>
    <title>{{ $broadcastSubject }}</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8f4f9; padding: 20px; margin: 0;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 0; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(74, 14, 78, 0.1);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #4A0E4E 0%, #6B1A70 100%); padding: 30px; text-align: center;">
            <img src="{{ url('images/uniben-logo.png') }}" alt="UBAA Logo" style="width: 50px; height: 50px; border-radius: 10px; background: white; padding: 4px; margin-bottom: 12px;">
            <h2 style="color: #D4AF37; font-size: 20px; margin: 0;">UBAA Lagos Branch</h2>
            <p style="color: rgba(255,255,255,0.7); font-size: 12px; margin: 4px 0 0;">Official Communication</p>
        </div>

        <!-- Body -->
        <div style="padding: 40px 30px;">
            <p style="color: #333; font-size: 16px; line-height: 1.6;">Dear <strong>{{ $recipientName }}</strong>,</p>
            
            <div style="color: #555; font-size: 15px; line-height: 1.8; margin: 20px 0;">
                {!! nl2br(e($broadcastMessage)) !!}
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f8f4f9; padding: 20px 30px; text-align: center; border-top: 1px solid #f0e6f3;">
            <p style="color: #999; font-size: 12px; margin: 0;">
                This email was sent from UBAA Lagos Branch.<br>
                <a href="{{ url('/') }}" style="color: #4A0E4E; font-weight: bold; text-decoration: none;">Visit Portal</a>
            </p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>New Login Alert</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8f4f9; padding: 20px; margin: 0;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 0; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(74, 14, 78, 0.1);">
        <!-- Header Banner -->
        <div style="background: linear-gradient(135deg, #4A0E4E 0%, #6B1A70 50%, #4A0E4E 100%); padding: 35px 30px; text-align: center;">
            <div style="margin-bottom: 15px;">
                <img src="{{ $message->embed(public_path('images/uniben-logo.png')) }}" alt="UBAA Logo" style="width: 55px; height: 55px; border-radius: 12px; background: #000; padding: 4px; display: inline-block;">
            </div>
            <h1 style="color: #D4AF37; font-size: 24px; margin: 0 0 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">New Login Detected</h1>
            <p style="color: rgba(255,255,255,0.85); font-size: 13px; margin: 0; font-weight: 500; letter-spacing: 1px;">UNIBEN ALUMNI ASSOCIATION, LAGOS BRANCH</p>
        </div>

        <!-- Body -->
        <div style="padding: 40px 30px; background: #ffffff;">
            <p style="color: #333333; font-size: 16px; line-height: 1.8; margin-top: 0;">Dear <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
            
            <p style="color: #555555; font-size: 15px; line-height: 1.8; margin-bottom: 25px;">
                This is a security notification to inform you that your UNIBEN Alumni Lagos account was successfully logged into. If this was you, no action is needed.
            </p>

            <!-- Login Details Table -->
            <div style="background: #fbfbfb; border: 1px solid #f0e6f3; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #4A0E4E; font-weight: 800; font-size: 13px; text-transform: uppercase; width: 35%;">Time / Date</td>
                        <td style="padding: 8px 0; color: #333333; font-size: 14px; font-weight: 600;">{{ $time }}</td>
                    </tr>
                    <tr style="border-top: 1px solid #f0e6f3;">
                        <td style="padding: 8px 0; color: #4A0E4E; font-weight: 800; font-size: 13px; text-transform: uppercase;">IP Address</td>
                        <td style="padding: 8px 0; color: #333333; font-size: 14px; font-weight: 600; font-family: monospace;">{{ $ipAddress }}</td>
                    </tr>
                    <tr style="border-top: 1px solid #f0e6f3;">
                        <td style="padding: 8px 0; color: #4A0E4E; font-weight: 800; font-size: 13px; text-transform: uppercase;">Device/Browser</td>
                        <td style="padding: 8px 0; color: #333333; font-size: 14px; line-height: 1.5; font-weight: 600;">{{ $userAgent }}</td>
                    </tr>
                </table>
            </div>

            <!-- Caution Message -->
            <div style="border-left: 4px solid #D4AF37; background: #fffcf4; padding: 15px 20px; border-radius: 0 8px 8px 0; margin-bottom: 30px;">
                <p style="color: #7a5f00; font-size: 13.5px; line-height: 1.6; margin: 0; font-weight: 600;">
                    If you did not authorize this login, please change your password immediately to secure your account and prevent unauthorized access.
                </p>
            </div>

            <!-- Action Button -->
            <div style="text-align: center; margin: 30px 0 10px;">
                <a href="{{ url('/profile') }}" style="display: inline-block; background: #4A0E4E; color: #ffffff; padding: 14px 32px; border-radius: 10px; font-weight: bold; text-decoration: none; font-size: 14px; box-shadow: 0 4px 15px rgba(74, 14, 78, 0.2); transition: all 0.3s ease;">
                    Secure Your Account
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f8f4f9; padding: 25px 30px; text-align: center; border-top: 1px solid #f0e6f3;">
            <p style="color: #888888; font-size: 12px; margin: 0 0 6px; line-height: 1.5;">
                This email was sent to {{ $user->email }} as part of your account security notifications.
            </p>
            <p style="color: #6b7280; font-size: 12px; margin: 0; font-weight: bold;">
                &copy; {{ date('Y') }} UNIBEN Alumni Lagos Branch. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

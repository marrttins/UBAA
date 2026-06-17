<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Verification Code</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8f4f9; padding: 20px; margin: 0;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 0; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(74, 14, 78, 0.1);">
        <!-- Header Banner -->
        <div style="background: linear-gradient(135deg, #4A0E4E 0%, #6B1A70 50%, #4A0E4E 100%); padding: 35px 30px; text-align: center;">
            <div style="margin-bottom: 15px;">
                <img src="{{ $message->embed(public_path('images/uniben-logo.png')) }}" alt="UBAA Logo" style="width: 55px; height: 55px; border-radius: 12px; background: #000; padding: 4px; display: inline-block;">
            </div>
            <h1 style="color: #D4AF37; font-size: 24px; margin: 0 0 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Reset Your Password</h1>
            <p style="color: rgba(255,255,255,0.85); font-size: 13px; margin: 0; font-weight: 500; letter-spacing: 1px;">UNIBEN ALUMNI ASSOCIATION, LAGOS BRANCH</p>
        </div>

        <!-- Body -->
        <div style="padding: 40px 30px; background: #ffffff; text-align: center;">
            <p style="color: #333333; font-size: 16px; line-height: 1.8; text-align: left; margin-top: 0;">Dear <strong>{{ $firstName }}</strong>,</p>
            
            <p style="color: #555555; font-size: 15px; line-height: 1.8; text-align: left; margin-bottom: 30px;">
                We received a request to reset the password for your UNIBEN Alumni Association Lagos Branch Portal account. Please use the verification code below to complete your password reset:
            </p>

            <!-- OTP Code Display -->
            <div style="display: inline-block; background: #fdf6ff; border: 2px dashed #4A0E4E; border-radius: 12px; padding: 18px 40px; margin-bottom: 30px;">
                <span style="font-size: 32px; font-weight: 800; color: #4A0E4E; letter-spacing: 6px; font-family: monospace;">{{ $otp }}</span>
            </div>

            <p style="color: #666666; font-size: 13.5px; line-height: 1.6; margin-bottom: 30px;">
                This code is valid for <strong>{{ $expiresInMinutes }} minutes</strong>. If you did not request a password reset, you can safely ignore this email; your password will remain unchanged.
            </p>
        </div>

        <!-- Footer -->
        <div style="background: #f8f4f9; padding: 25px 30px; text-align: center; border-top: 1px solid #f0e6f3;">
            <p style="color: #888888; font-size: 12px; margin: 0 0 6px; line-height: 1.5;">
                This email was sent to assist with your password reset request on the UBAA Lagos alumni portal.
            </p>
            <p style="color: #6b7280; font-size: 12px; margin: 0; font-weight: bold;">
                &copy; {{ date('Y') }} UNIBEN Alumni Lagos Branch. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

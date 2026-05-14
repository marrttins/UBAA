<!DOCTYPE html>
<html>
<head>
    <title>Birthday Celebration</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8f4f9; padding: 20px; margin: 0;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 0; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(74, 14, 78, 0.1);">
        <!-- Header Banner -->
        <div style="background: linear-gradient(135deg, #4A0E4E 0%, #6B1A70 50%, #4A0E4E 100%); padding: 40px 30px; text-align: center;">
            <div style="font-size: 60px; margin-bottom: 10px;">🎂🎉</div>
            <h1 style="color: #D4AF37; font-size: 28px; margin: 0 0 8px;">Happy Birthday!</h1>
            <p style="color: rgba(255,255,255,0.8); font-size: 14px; margin: 0;">UBAA Lagos Branch Celebrates With You</p>
        </div>

        <!-- Body -->
        <div style="padding: 40px 30px;">
            <p style="color: #333; font-size: 16px; line-height: 1.8;">Dear <strong>{{ $celebrant->first_name }} {{ $celebrant->last_name }}</strong>,</p>
            
            <p style="color: #555; font-size: 15px; line-height: 1.8;">
                On behalf of the entire <strong>University of Benin Alumni Association, Lagos Branch</strong>, we wish you a wonderful and joyous birthday! 🎈
            </p>

            <div style="background: linear-gradient(135deg, #f8f4f9, #f0e6f3); padding: 25px; border-radius: 12px; margin: 25px 0; border-left: 4px solid #D4AF37;">
                <p style="color: #4A0E4E; font-size: 15px; font-style: italic; margin: 0; line-height: 1.6;">
                    "May this new year of your life bring you abundant blessings, good health, and continued success in all your endeavours. Your contributions to our alumni community are deeply valued."
                </p>
            </div>

            <p style="color: #555; font-size: 15px; line-height: 1.8;">
                We celebrate you today and always. Enjoy your special day to the fullest! 🥂
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/') }}" style="display: inline-block; background: #4A0E4E; color: white; padding: 14px 32px; border-radius: 10px; font-weight: bold; text-decoration: none; font-size: 14px;">Visit Alumni Portal</a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f8f4f9; padding: 20px 30px; text-align: center; border-top: 1px solid #f0e6f3;">
            <p style="color: #999; font-size: 12px; margin: 0;">
                With warm regards,<br>
                <strong style="color: #4A0E4E;">UNIBEN Alumni Lagos Branch</strong>
            </p>
        </div>
    </div>
</body>
</html>

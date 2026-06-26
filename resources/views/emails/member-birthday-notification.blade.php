<!DOCTYPE html>
<html>
<head>
    <title>Birthday Celebration</title>
</head>
<body style="font-family: 'Inter', Arial, sans-serif; background-color: #f8f4f9; padding: 20px; margin: 0;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 0; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(74, 14, 78, 0.1);">
        <!-- Header Banner -->
        <div style="background: linear-gradient(135deg, #4A0E4E 0%, #6B1A70 50%, #4A0E4E 100%); padding: 40px 30px; text-align: center;">
            <div style="font-size: 60px; margin-bottom: 10px;">🎉🎂</div>
            <h1 style="color: #D4AF37; font-size: 24px; margin: 0 0 8px;">It's Celebration Time!</h1>
            <p style="color: rgba(255,255,255,0.8); font-size: 14px; margin: 0;">UBAA Lagos Branch Birthday Announcement</p>
        </div>

        <!-- Body -->
        <div style="padding: 40px 30px;">
            <p style="color: #333; font-size: 16px; line-height: 1.8;">Dear <strong>{{ $recipient->first_name ?? $recipient->name }}</strong>,</p>
            
            <p style="color: #555; font-size: 15px; line-height: 1.8;">
                Today, we have the pleasure of celebrating the birthday of one of our esteemed members, 
                <strong>{{ $celebrant->name }}</strong>! 🎈
            </p>

            <div style="background: linear-gradient(135deg, #f8f4f9, #f0e6f3); padding: 25px; border-radius: 12px; margin: 25px 0; border-left: 4px solid #D4AF37; text-align: center;">
                @if($celebrant->avatar_url)
                    <img src="{{ url($celebrant->avatar_url) }}" alt="{{ $celebrant->name }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #D4AF37; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                @else
                    <div style="width: 100px; height: 100px; border-radius: 50%; background: #4A0E4E; color: white; line-height: 100px; font-size: 36px; font-weight: bold; margin: 0 auto 15px; border: 3px solid #D4AF37; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        {{ strtoupper(substr($celebrant->first_name ?? $celebrant->name, 0, 1)) }}
                    </div>
                @endif
                <h3 style="color: #4A0E4E; margin: 0 0 5px; font-size: 18px;">{{ $celebrant->name }}</h3>
                @if($celebrant->job_title)
                    <p style="color: #666; margin: 0; font-size: 14px;">{{ $celebrant->job_title }}@if($celebrant->company) at {{ $celebrant->company }}@endif</p>
                @endif
                @if($celebrant->graduation_year)
                    <p style="color: #888; margin: 5px 0 0; font-size: 12px; font-weight: bold;">Class of {{ $celebrant->graduation_year }}</p>
                @endif
            </div>

            <p style="color: #555; font-size: 15px; line-height: 1.8;">
                Let's join hands as a community to wish them a fantastic birthday. Reach out, send a connection request, or drop a warm message to celebrate them on their special day!
            </p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('profile.show', $celebrant->id) }}" style="display: inline-block; background: #4A0E4E; color: white; padding: 14px 32px; border-radius: 10px; font-weight: bold; text-decoration: none; font-size: 14px; box-shadow: 0 4px 10px rgba(74, 14, 78, 0.2);">View Profile & Wish Them Well</a>
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

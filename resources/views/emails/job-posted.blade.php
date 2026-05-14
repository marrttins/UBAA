<!DOCTYPE html>
<html>
<head>
    <title>New Job Opportunity Available</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 30px; margin: 0 auto; border-radius: 8px; border-top: 5px solid #4A0E4E;">
        <h2 style="color: #4A0E4E;">New Job Opportunity Alert</h2>
        <p>A new job opportunity has just been posted on the UNIBEN Alumni Job Board!</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #D4AF37; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #333;">{{ $job->title }}</h3>
            <p style="margin: 5px 0;"><strong>Company:</strong> {{ $job->company }}</p>
            <p style="margin: 5px 0;"><strong>Location:</strong> {{ $job->location ?? 'Not specified' }}</p>
            <p style="margin: 5px 0;"><strong>Type:</strong> {{ $job->environment ?? 'Full-time' }}</p>
        </div>

        <p>If you're interested and looking for new opportunities, please click below to view the full details and apply.</p>
        
        <a href="{{ url('/jobs') }}" style="display: inline-block; padding: 10px 20px; background-color: #4A0E4E; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px;">View on Job Board</a>
        
        <p style="margin-top: 30px;">Best regards,<br><strong>UNIBEN Alumni Lagos Branch</strong></p>
    </div>
</body>
</html>

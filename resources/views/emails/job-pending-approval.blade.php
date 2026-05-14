<!DOCTYPE html>
<html>
<head>
    <title>New Job Pending Approval</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 30px; margin: 0 auto; border-radius: 8px; border-top: 5px solid #D4AF37;">
        <h2 style="color: #4A0E4E;">Action Required: New Job Posted</h2>
        <p>A new job has been posted by a user and is currently waiting for your approval.</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #D4AF37; margin: 20px 0;">
            <p><strong>Job Title:</strong> {{ $job->title }}</p>
            <p><strong>Company:</strong> {{ $job->company }}</p>
            <p><strong>Posted By:</strong> {{ $job->user->name ?? 'Unknown User' }}</p>
            <p><strong>Status:</strong> Pending Approval</p>
        </div>

        <p>Please log in to the admin dashboard to review, approve, or reject this job posting.</p>
        
        <a href="{{ url('/admin/jobs') }}" style="display: inline-block; padding: 10px 20px; background-color: #4A0E4E; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 15px;">Go to Job Board Admin</a>
        
        <p style="margin-top: 30px;">Best regards,<br><strong>UNIBEN Alumni System</strong></p>
    </div>
</body>
</html>

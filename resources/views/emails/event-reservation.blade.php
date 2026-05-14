<!DOCTYPE html>
<html>
<head>
    <title>Event Reservation Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 30px; margin: 0 auto; border-radius: 8px; border-top: 5px solid #4A0E4E;">
        <h2 style="color: #4A0E4E;">Seat Reservation Confirmed</h2>
        <p>Dear {{ $reservation->name }},</p>
        <p>Your seat reservation for the upcoming event has been confirmed successfully!</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #D4AF37; margin: 20px 0;">
            <p><strong>Event:</strong> {{ $event->title }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('l, F j, Y \a\t h:i A') }}</p>
            <p><strong>Location:</strong> {{ $event->location_name }} ({{ $event->location_type }})</p>
            @if($reservation->amount > 0)
                <p><strong>Amount Paid:</strong> ₦{{ number_format($reservation->amount, 2) }} via {{ ucfirst($reservation->payment_method) }}</p>
            @else
                <p><strong>Access:</strong> Free Registration</p>
            @endif
        </div>

        <p>Please present this email at the venue for quick access.</p>
        
        <p style="margin-top: 30px;">Best regards,<br><strong>UNIBEN Alumni Lagos Branch</strong></p>
    </div>
</body>
</html>

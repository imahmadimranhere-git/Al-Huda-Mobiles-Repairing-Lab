<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background: #F3F6FA; padding: 30px;">
    <div style="max-width: 480px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 30px; border: 1px solid #DCE3EC;">
        <h2 style="color: #1B2027; margin-top: 0;">Al Huda Mobiles Repairing Lab</h2>
        <p>A repair request has been created for your device at our lab.</p>

        <p><strong>Tracking ID:</strong> {{ $repair->tracking_id }}</p>
        <p><strong>Device:</strong> {{ $repair->device_brand }} {{ $repair->device_model }}</p>

        <p>Please use the code below to confirm and approve this repair request:</p>

        <div style="font-size: 28px; font-weight: bold; letter-spacing: 4px; background: #EAF0F6; padding: 15px; text-align: center; border-radius: 8px; margin: 20px 0;">
            {{ $repair->otp_code }}
        </div>

        <p style="color: #6B7280; font-size: 13px;">This code expires in 15 minutes. If you did not request this repair, please contact us immediately.</p>
    </div>
</body>
</html>
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

        <p>Click the button below, then enter the code to confirm and approve this repair:</p>

        <!-- Terms & Conditions Section -->
        <div style="background: #FFF7ED; border: 1px solid #F3D9BC; border-radius: 8px; padding: 18px; margin: 20px 0;">
            <p style="margin-top: 0; font-weight: bold; color: #1B2027;">Repair Terms & Conditions</p>
            <p style="font-size: 13px; color: #4B5563; margin-bottom: 8px;">
                By approving this repair, you agree to the following:
            </p>
            <ul style="font-size: 13px; color: #4B5563; padding-left: 18px; margin: 0;">
                <li style="margin-bottom: 6px;">Al Huda Mobiles Repairing Lab is not responsible for any pre-existing damage found during the repair process.</li>
                <li style="margin-bottom: 6px;">We are not liable for any data loss. Please ensure your data is backed up before submitting your device.</li>
                <li style="margin-bottom: 6px;">In case of accidental device damage or malfunction (including complete device failure) arising during the repair process due to the device's existing condition, Al Huda Mobiles Repairing Lab shall not be held responsible.</li>
                <li style="margin-bottom: 6px;">Additional issues discovered during repair may affect repair time and cost, and will be communicated to you separately.</li>
                <li style="margin-bottom: 6px;">Devices not collected within 30 days after repair completion may be subject to disposal as per lab policy.</li>
                <li>This approval and the code below confirm your consent to proceed with the repair under these terms.</li>
            </ul>
        </div>

        <p style="text-align: center; margin: 25px 0;">
            <a href="{{ route('repairs.approve', $repair->tracking_id) }}"
               style="background: #E8722F; color: #fff; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-block;">
                Approve My Repair
            </a>
        </p>

        <p>Your approval code:</p>

        <div style="font-size: 28px; font-weight: bold; letter-spacing: 4px; background: #EAF0F6; padding: 15px; text-align: center; border-radius: 8px; margin: 20px 0;">
            {{ $repair->otp_code }}
        </div>

        <p style="color: #6B7280; font-size: 13px;">This code expires in 15 minutes. If you did not request this repair, please contact us immediately.</p>
    </div>
</body>
</html>
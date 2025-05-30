<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Ad Has Been Reviewed</title>
</head>
<body>
<h2>Hello {{ $user->name }},</h2>

<p>Your ad titled "<strong>{{ $ad->title }}</strong>" has been reviewed by our moderation team.</p>

<p>You can now view your ad's status in your dashboard.</p>

<p>If your ad was approved, it will be visible to other users immediately.</p>

<br>
<p>Thank you for using our platform!</p>

<p>Best regards,<br>The Support Team</p>
</body>
</html>

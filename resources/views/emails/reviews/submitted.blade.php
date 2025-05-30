<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Review Notification</title>
</head>
<body>
<h2>Hello {{ $user->name }},</h2>

<p>Someone has submitted a new review on your ad.</p>

<p><strong>Ad Title:</strong> {{ $ad->title }}</p>

<p>Visit your ad to see the review and respond if necessary.</p>

<br>
<p>Best regards,<br>The Support Team</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ad Submission Confirmation</title>
</head>
<body>
<h2>Hello {{ $user->name }},</h2>

<p>Thank you for submitting your ad on our platform.</p>

<p><strong>Ad Title:</strong> {{ $ad->title }}</p>
<p><strong>Description:</strong> {{ $ad->description }}</p>
<p><strong>Price:</strong> ${{ $ad->price }}</p>

<p>Your ad is currently under review. We will notify you once it has been approved.</p>

<br>
<p>Best regards,<br>The Support Team</p>
</body>
</html>

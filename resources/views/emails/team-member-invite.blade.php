<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Team Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height:1.6;">
    <h2>Hello {{ $user->name }},</h2>
    <p>You’ve been invited to join the team on <strong>Minbird</strong>.</p>

    <p>Click the button below to set up your account and get started:</p>

    <p style="text-align:center;">
        <a href="{{ $inviteLink }}" 
           style="background-color:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">
           Accept Invitation
        </a>
    </p>

    <p>If the button doesn’t work, copy and paste this link into your browser:</p>
    <p><a href="{{ $inviteLink }}">{{ $inviteLink }}</a></p>

    <p>Best,<br>The Minbird Team</p>
</body>
</html>

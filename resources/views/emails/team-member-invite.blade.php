<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Team Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height:1.6;">
    <h2>Hello {{ $user->name }},</h2>

    <p>You’ve been invited to join the team on <strong>Minbird</strong>.</p>

    <p>Here are your login credentials:</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Temporary Password:</strong> {{ $plainPassword }}</li>
    </ul>

    <p>Click below to set up your account and start collaborating:</p>

    <p style="text-align:center;">
        <a href="{{ $inviteLink }}" 
           style="background-color:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">
           Accept Invitation
        </a>
    </p>

    <p>If the button doesn’t work, copy this link into your browser:</p>
    <p><a href="{{ $inviteLink }}">{{ $inviteLink }}</a></p>

    <p>Best regards,<br>The Minbird Team</p>
</body>
</html>

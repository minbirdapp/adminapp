@component('mail::message')
# Welcome to Minbird

<p>Hello,</p>

<p>Your Minbird activation code is: <strong>{{ $activationCode }}</strong></p>

<p>This code expires in 15 minutes.</p>

<p>Enter it on the activation page to verify your account.</p>

<p>Thanks,<br>The Minbird Team</p>
@endcomponent

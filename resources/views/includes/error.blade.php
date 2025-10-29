@if(session('error'))
<!-- <div class="error-message">
    <span></span> Error Message
</div> -->
<div class="error-message">
    <span></span> {{ session('error') }}
</div>
@endif
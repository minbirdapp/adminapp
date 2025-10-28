    @if(session('success'))
    <div class="success-message">
        <span></span> Success Message
    </div>
    <div class="success-message">
        <span>🎉</span> {{ session('success') }}
    </div>
    @endif
  <div class="header text-center mb-4">
                <p class="text-secondary mb-1">🌤️ {{ now()->format('l, M j H:i') }}</p>
                <h4>Good morning, {{ auth()->user()->name }}</h4>
            </div>
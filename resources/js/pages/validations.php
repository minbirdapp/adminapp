<script>
    //  JavaScript Validations for Login Forms
    document.addEventListener('DOMContentLoaded', function() {
    const toggleLink = document.getElementById('toggleLoginType');
    const magicForm = document.getElementById('magicForm');
    const passwordForm = document.getElementById('passwordForm');
    const emailInput = document.getElementById('emailInput');
    const magicEmail = document.getElementById('magicEmail');
    const passwordEmail = document.getElementById('passwordEmail');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const passwordInput = document.getElementById('passwordInput');

    //  Toggle between Magic Link and Password Login
    toggleLink.addEventListener('click', function(e) {
        e.preventDefault();
        emailError.textContent = '';
        passwordError.textContent = '';

        if (magicForm.style.display !== 'none') {
            magicForm.style.display = 'none';
            passwordForm.style.display = 'block';
            toggleLink.textContent = 'Use Magic Link';
        } else {
            magicForm.style.display = 'block';
            passwordForm.style.display = 'none';
            toggleLink.textContent = 'Use Password';
        }
    });

    // 🔄 Keep email synced between both forms
    emailInput.addEventListener('input', function() {
        const value = emailInput.value.trim();
        magicEmail.value = value;
        passwordEmail.value = value;
    });

    // 🛡️ Validate before submitting Magic Link Form
    magicForm.addEventListener('submit', function(e) {
        const email = emailInput.value.trim();
        emailError.textContent = '';

        if (email === '') {
            e.preventDefault();
            emailError.textContent = 'Email is required.';
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            e.preventDefault();
            emailError.textContent = 'Please enter a valid email address.';
        }
    });

    // 🧠 Validate before submitting Password Login Form
    passwordForm.addEventListener('submit', function(e) {
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();
        emailError.textContent = '';
        passwordError.textContent = '';

        let valid = true;

        // Validate email
        if (email === '') {
            emailError.textContent = 'Email is required.';
            valid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            emailError.textContent = 'Please enter a valid email address.';
            valid = false;
        }

        // Validate password
        if (password === '') {
            passwordError.textContent = 'Password is required.';
            valid = false;
        } else if (password.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters.';
            valid = false;
        }

        if (!valid) {
            e.preventDefault(); // 🚫 Stop form submit if invalid
        }
    });
});
</script>

<script>
  const instagramModal = document.getElementById('instagramModal');
  instagramModal.addEventListener('show.bs.modal', () => {
    const connectModal = bootstrap.Modal.getInstance(document.getElementById('connectModal'));
    connectModal.hide();
  });
</script>
<script>
  document.getElementById('addBrandForm').addEventListener('submit', function(e) {
    let valid = true;
    document.getElementById('brandError').textContent = '';
    document.getElementById('industryError').textContent = '';

    const brandName = document.getElementById('brandName').value.trim();
    const industry = document.getElementById('industrySelect').value;

    if (brandName === '') {
      document.getElementById('brandError').textContent = 'Brand name is required.';
      valid = false;
    }
    if (industry === '') {
      document.getElementById('industryError').textContent = 'Please select an industry.';
      valid = false;
    }

    if (!valid) e.preventDefault();
  });
</script>

<script>
document.getElementById('setupAccountForm').addEventListener('submit', function(e) {
    let valid = true;

    // Reset errors
    ['firstNameError','passwordError','brandNameError','industryError','roleError'].forEach(id => {
        document.getElementById(id).textContent = '';
    });

    // Collect values
    const firstName = document.getElementById('first_name').value.trim();
    const password  = document.getElementById('password').value.trim();
    const brandName = document.getElementById('brand_name').value.trim();
    const industry  = document.getElementById('industry_id').value;
    const role      = document.getElementById('brand_role_id').value;

    if (firstName === '') {
        document.getElementById('firstNameError').textContent = 'First name is required.';
        valid = false;
    }

    if (password.length < 8) {
        document.getElementById('passwordError').textContent = 'Password must be at least 8 characters.';
        valid = false;
    }

    if (brandName === '') {
        document.getElementById('brandNameError').textContent = 'Brand name is required.';
        valid = false;
    }

    if (industry === '') {
        document.getElementById('industryError').textContent = 'Please select an industry.';
        valid = false;
    }

    if (role === '') {
        document.getElementById('roleError').textContent = 'Please select a role.';
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>
<script>
document.getElementById('createAccountForm').addEventListener('submit', function(e) {
    let valid = true;

    // Reset any previous error messages
    document.getElementById('emailError').textContent = '';

    // Get the email value
    const email = document.getElementById('email').value.trim();

    // Check if empty
    if (email === '') {
        document.getElementById('emailError').textContent = 'Email address is required.';
        valid = false;
    } 
    // Check for valid email format
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email address.';
        valid = false;
    }

    // Stop form submission if invalid
    if (!valid) {
        e.preventDefault();
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('.alert-auto-hide');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500); // remove after fade
        }, 2000); // 2 seconds
    });
});
</script>

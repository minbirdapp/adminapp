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

        //  Keep email synced between both forms
        emailInput.addEventListener('input', function() {
            const value = emailInput.value.trim();
            magicEmail.value = value;
            passwordEmail.value = value;
        });

        //  Validate before submitting Magic Link Form
        magicForm.addEventListener('submit', function(e) {
            let valid = true;
            const email = emailInput.value.trim();
            const captcha = document.getElementById('g-recaptcha-response').value.trim();

            // Reset errors
            emailError.textContent = '';
            document.getElementById('captchaError').textContent = '';

            //  Validate email
            if (email === '') {
                emailError.textContent = 'Email is required.';
                valid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                emailError.textContent = 'Please enter a valid email address.';
                valid = false;
            }

            //  Validate captcha
            if (captcha === '') {
                document.getElementById('captchaError').textContent = 'Captcha field is required.';
                valid = false;
            }

            // Stop form submission if invalid
            if (!valid) {
                e.preventDefault();
            }
        });


        //  Validate before submitting Password Login Form
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
                e.preventDefault(); //  Stop form submit if invalid
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
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('setupAccountForm');
    const passwordInput = document.getElementById('password');

    const rules = {
        length: document.getElementById("rule-length"),
        letter: document.getElementById("rule-letter"),
        number: document.getElementById("rule-number"),
        special: document.getElementById("rule-special")
    };

    function toggleRule(element, valid) {
        if (valid) {
            element.classList.add("text-success");
            element.classList.remove("text-danger");
        } else {
            element.classList.add("text-danger");
            element.classList.remove("text-success");
        }
    }

    // 🟢 Real-time password validation
    passwordInput.addEventListener("input", function() {
        const value = passwordInput.value;

        const hasLength = value.length >= 8;
        const hasLetter = /[a-zA-Z]/.test(value);
        const hasNumber = /\d/.test(value);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(value);

        toggleRule(rules.length, hasLength);
        toggleRule(rules.letter, hasLetter);
        toggleRule(rules.number, hasNumber);
        toggleRule(rules.special, hasSpecial);
    });

    // 🚫 Prevent submission if password invalid
    form.addEventListener('submit', function(e) {
        let valid = true;

        // Reset errors
        ['firstNameError', 'passwordError', 'brandNameError', 'industryError', 'roleError'].forEach(id => {
            document.getElementById(id).textContent = '';
        });

        const firstName = document.getElementById('first_name').value.trim();
        const brandName = document.getElementById('brand_name').value.trim();
        const industry = document.getElementById('industry_id').value;
        const role = document.getElementById('brand_role_id').value;
        const password = passwordInput.value.trim();

        // ✅ First name
        if (firstName === '') {
            document.getElementById('firstNameError').textContent = 'First name is required.';
            valid = false;
        }

        // ✅ Password
        const hasLength = password.length >= 8;
        const hasLetter = /[a-zA-Z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        if (password === '') {
            document.getElementById('passwordError').textContent = 'Password is required.';
            valid = false;
        } else if (!(hasLength && hasLetter && hasNumber && hasSpecial)) {
            document.getElementById('passwordError').textContent = 'Password must meet all rules.';
            valid = false;
        }

        // ✅ Brand Name
        if (brandName === '') {
            document.getElementById('brandNameError').textContent = 'Brand name is required.';
            valid = false;
        }

        // ✅ Industry
        if (industry === '') {
            document.getElementById('industryError').textContent = 'Please select an industry.';
            valid = false;
        }

        // ✅ Role
        if (role === '') {
            document.getElementById('roleError').textContent = 'Please select a role.';
            valid = false;
        }

        // ❌ Stop submission
        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>


<script>
    document.getElementById('createAccountForm').addEventListener('submit', function(e) {
        let valid = true;

        // Reset any previous error messages
        document.getElementById('emailError').textContent = '';
        document.getElementById('captchaError').textContent = '';

        // Get the email value
        const email = document.getElementById('email').value.trim();
        const captcha = document.getElementById('g-recaptcha-response').value.trim();
        document.getElementById('captchaError').textContent = '';

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

        if (captcha === '') {
            document.getElementById('captchaError').textContent = 'Captcha field is required.';
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
            }, 4000); // 2 seconds
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const msg = document.getElementById('magic-message');
        if (msg) {
            setTimeout(() => {
                msg.style.display = 'none';
            }, 4000); // Hide after 2 seconds
        }
    });
</script>
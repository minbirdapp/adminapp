<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* -------------------- Login Validations -------------------- */
        const toggleLink = document.getElementById('toggleLoginType');
        const magicForm = document.getElementById('magicForm');
        const passwordForm = document.getElementById('passwordForm');
        const emailInput = document.getElementById('emailInput');
        const magicEmail = document.getElementById('magicEmail');
        const passwordEmail = document.getElementById('passwordEmail');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const passwordInput = document.getElementById('passwordInput');

        if (toggleLink && magicForm && passwordForm) {
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
        }

        if (emailInput && magicEmail && passwordEmail) {
            emailInput.addEventListener('input', function() {
                const value = emailInput.value.trim();
                magicEmail.value = value;
                passwordEmail.value = value;
            });
        }

        if (magicForm && emailInput) {
            magicForm.addEventListener('submit', function(e) {
                let valid = true;
                const email = emailInput.value.trim();
                const captcha = document.getElementById('g-recaptcha-response')?.value.trim() || '';
                if (email === '') {
                    emailError.textContent = 'Email is required.';
                    valid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    emailError.textContent = 'Please enter a valid email address.';
                    valid = false;
                }
                if (captcha === '') {
                    const capErr = document.getElementById('captchaError');
                    if (capErr) capErr.textContent = 'Captcha field is required.';
                    valid = false;
                }
                if (!valid) e.preventDefault();
            });
        }

        if (passwordForm && emailInput && passwordInput) {
            passwordForm.addEventListener('submit', function(e) {
                let valid = true;
                emailError.textContent = '';
                passwordError.textContent = '';
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                if (email === '') {
                    emailError.textContent = 'Email is required.';
                    valid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    emailError.textContent = 'Please enter a valid email address.';
                    valid = false;
                }
                if (password === '') {
                    passwordError.textContent = 'Password is required.';
                    valid = false;
                } else if (password.length < 6) {
                    passwordError.textContent = 'Password must be at least 6 characters.';
                    valid = false;
                }
                if (!valid) e.preventDefault();
            });
        }

        /* -------------------- Instagram Modal -------------------- */
        const instagramModal = document.getElementById('instagramModal');
        if (instagramModal) {
            instagramModal.addEventListener('show.bs.modal', () => {
                const connectModal = bootstrap.Modal.getInstance(document.getElementById('connectModal'));
                if (connectModal) connectModal.hide();
            });
        }

        /* -------------------- Add Brand Form -------------------- */
        const addBrandForm = document.getElementById('addBrandForm');
        if (addBrandForm) {
            addBrandForm.addEventListener('submit', function(e) {
                let valid = true;
                const brandName = document.getElementById('brandName')?.value.trim() || '';
                const industry = document.getElementById('industrySelect')?.value || '';
                const brandError = document.getElementById('brandError');
                const industryError = document.getElementById('industryError');
                if (brandError) brandError.textContent = '';
                if (industryError) industryError.textContent = '';
                if (brandName === '') {
                    if (brandError) brandError.textContent = 'Brand name is required.';
                    valid = false;
                }
                if (industry === '') {
                    if (industryError) industryError.textContent = 'Please select an industry.';
                    valid = false;
                }
                if (!valid) e.preventDefault();
            });
        }

        /* -------------------- Setup Account Form -------------------- */
        const setupForm = document.getElementById('setupAccountForm');
        const passwordField = document.getElementById('password');
        if (setupForm && passwordField) {
            setupForm.addEventListener('submit', function(e) {
                let valid = true;
                const password = passwordField.value.trim();
                const firstName = document.getElementById('first_name')?.value.trim() || '';
                const passwordError = document.getElementById('passwordError');
                const firstNameError = document.getElementById('firstNameError');
                if (firstNameError) firstNameError.textContent = '';
                if (passwordError) passwordError.textContent = '';
                if (firstName === '') {
                    if (firstNameError) firstNameError.textContent = 'First name is required.';
                    valid = false;
                }
                if (password === '' || password.length < 8) {
                    if (passwordError) passwordError.textContent = 'Password must be at least 8 characters.';
                    valid = false;
                }
                if (!valid) e.preventDefault();
            });
        }

        /* -------------------- Create Account Form -------------------- */
        const createForm = document.getElementById('createAccountForm');
        if (createForm) {
            createForm.addEventListener('submit', function(e) {
                let valid = true;
                const email = document.getElementById('email')?.value.trim() || '';
                const captcha = document.getElementById('g-recaptcha-response')?.value.trim() || '';
                const emailError = document.getElementById('emailError');
                const captchaError = document.getElementById('captchaError');
                if (emailError) emailError.textContent = '';
                if (captchaError) captchaError.textContent = '';
                if (email === '') {
                    if (emailError) emailError.textContent = 'Email address is required.';
                    valid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    if (emailError) emailError.textContent = 'Please enter a valid email address.';
                    valid = false;
                }
                if (captcha === '') {
                    if (captchaError) captchaError.textContent = 'Captcha field is required.';
                    valid = false;
                }
                if (!valid) e.preventDefault();
            });
        }

        /* -------------------- Profile Image & Form -------------------- */
        const profileForm = document.getElementById('profileForm');
        const imageInput = document.getElementById('fileInput');
        const profileImage = document.getElementById('profileImage');
        const imageError = document.getElementById('imageError');
        const dummyImage = "{{ asset('assets/img/dummy.png') }}";

        if (profileForm) {
            if (imageInput) {
                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                        if (!validTypes.includes(file.type)) {
                            if (imageError) imageError.textContent = 'Only JPG, PNG, or JPEG images allowed.';
                            this.value = '';
                            if (profileImage) profileImage.src = dummyImage;
                            return;
                        }
                        if (file.size > 2 * 1024 * 1024) {
                            if (imageError) imageError.textContent = 'Image must be smaller than 2MB.';
                            this.value = '';
                            if (profileImage) profileImage.src = dummyImage;
                            return;
                        }
                        if (imageError) imageError.textContent = '';
                        const reader = new FileReader();
                        reader.onload = e => {
                            if (profileImage) profileImage.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            profileForm.addEventListener('submit', e => {
                let valid = true;
                profileForm.querySelectorAll('.client-error').forEach(err => err.textContent = '');
                const firstName = profileForm.querySelector('[name="first_name"]');
                const lastName = profileForm.querySelector('[name="last_name"]');
                const timezone = profileForm.querySelector('[name="timezone_id"]');
                const setError = (input, msg) => {
                    const err = input.closest('.mb-3')?.querySelector('.client-error');
                    if (err) err.textContent = msg;
                };
                if (!firstName.value.trim()) {
                    valid = false;
                    setError(firstName, 'First name is required.');
                }
                if (!lastName.value.trim()) {
                    valid = false;
                    setError(lastName, 'Last name is required.');
                }
                if (!timezone.value.trim()) {
                    valid = false;
                    setError(timezone, 'Please select a timezone.');
                }
                if (!valid) e.preventDefault();
            });
        }

        /* -------------------- Invite Team Form -------------------- */
        const inviteForm = document.getElementById('inviteTeamForm');
        if (inviteForm) {
            inviteForm.addEventListener('submit', e => {
                let valid = true;
                inviteForm.querySelectorAll('.client-error').forEach(err => err.textContent = '');
                const firstName = inviteForm.querySelector('[name="first_name"]');
                const lastName = inviteForm.querySelector('[name="last_name"]');
                const role = inviteForm.querySelector('[name="role_id"]');
                const email = inviteForm.querySelector('[name="email"]');
                const status = inviteForm.querySelector('[name="status"]');
                const setError = (input, msg) => {
                    const err = input.closest('.mb-3')?.querySelector('.client-error');
                    if (err) err.textContent = msg;
                };
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!firstName.value.trim()) {
                    valid = false;
                    setError(firstName, 'First name is required.');
                }
                if (!lastName.value.trim()) {
                    valid = false;
                    setError(lastName, 'Last name is required.');
                }
                if (!role.value.trim()) {
                    valid = false;
                    setError(role, 'Please select a role.');
                }
                if (!email.value.trim()) {
                    valid = false;
                    setError(email, 'Email is required.');
                } else if (!emailPattern.test(email.value.trim())) {
                    valid = false;
                    setError(email, 'Enter a valid email.');
                }
                if (status.value === '') {
                    valid = false;
                    setError(status, 'Please select a status.');
                }
                if (!valid) e.preventDefault();
            });
        }

        /* -------------------- Auto-hide alerts -------------------- */
        document.querySelectorAll('.alert-auto-hide').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 4000);
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.editMember').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const id = btn.dataset.id;

                fetch(`/team-members/${id}/view`)
                    .then(res => res.json())
                    .then(data => {
                        // Fill the form fields
                        document.querySelector('[name="first_name"]').value = data.first_name;
                        document.querySelector('[name="last_name"]').value = data.last_name;
                        document.querySelector('[name="email"]').value = data.email;
                        document.querySelector('[name="role_id"]').value = data.role_id;
                        document.querySelector('[name="status"]').value = data.status;
                        document.getElementById('member_id').value = data.id;

                        // Change button text
                        document.querySelector('#inviteTeamForm button[type="submit"]').textContent = 'Update Member';
                    })
                    .catch(() => alert('Failed to load team member details.'));
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Toggle 3-dot quick menu
        document.querySelectorAll('.menu-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.stopPropagation();
                document.querySelectorAll('.quick-menu').forEach(menu => {
                    if (menu !== btn.nextElementSibling) menu.classList.remove('active');
                });
                btn.nextElementSibling.classList.toggle('active');
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('.quick-menu').forEach(menu => menu.classList.remove('active'));
        });

        // View Modal (AJAX load)
        document.querySelectorAll('.viewMember').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const id = btn.dataset.id;
                jQuery('.editTMember').attr('href', baseUrl + 'app-settings-teams/' + '' + id);
                jQuery('.deleteTMember').attr('href', baseUrl + 'app-settings-teams-delete/' + '' + id);
                const modalBody = document.getElementById('viewMemberContent');
                modalBody.innerHTML = `
      <div class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>`;

                fetch(`/team-members/${id}/view`)
                    .then(res => res.json())
                    .then(data => {
                        modalBody.innerHTML = `
    
            <img src="${data.profile_image ?? 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.name)}"
                 alt="Profile" class="profile-img mb-3 rounded-circle" width="100" height="100">
   

          <div class="container text-start">
            <div class="row g-3 mb-3">
              <div class="col-md-12">
                <div class="info-box d-flex">
                  <label class="form-label">Full Name</label>
                  <p>${data.name}</p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="info-box d-flex">
                  <label class="form-label">Email Address</label>
                  <p>${data.email}</p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="info-box d-flex">
                  <label class="form-label">Status</label>
                  <p>
                    ${data.status === 'Active' 
                      ? '<span class="badge bg-success">Active Member</span>' 
                      : '<span class="badge bg-secondary">Inactive Member</span>'}
                  </p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="info-box d-flex">
                  <label class="form-label">Role</label>
                  <p>${data.role}</p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="info-box d-flex">
                  <label class="form-label">Phone Number</label>
                  <p>${data.phone ?? 'N/A'}</p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="info-box d-flex">
                  <label class="form-label">Register Date</label>
                  <p>${data.created_at}</p>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <div class="info-box d-flex">
                <label class="form-label">About User</label>
                <p>${data.about ?? 'No details provided.'}</p>
              </div>
            </div>
          </div>
        `;
                    })
                    .catch(() => modalBody.innerHTML = '<p class="text-danger">Failed to load member info.</p>');
            });
        });


        // Confirm delete
        document.querySelectorAll('.deleteForm').forEach(form => {
            form.addEventListener('submit', e => {
                if (!confirm('Are you sure you want to delete this team member?')) e.preventDefault();
            });
        });

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('teamSearch');
        const teamItems = document.querySelectorAll('.team-item');

        if (searchInput) {
            searchInput.addEventListener('input', () => {
                const query = searchInput.value.trim().toLowerCase();

                teamItems.forEach(item => {
                    const name = item.querySelector('.team-info p')?.textContent.toLowerCase() || '';
                    const email = item.querySelector('.team-info')?.textContent.toLowerCase() || '';

                    // Show/hide if query matches name or email
                    if (name.includes(query) || email.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
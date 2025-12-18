// Password Change Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const changePasswordForm = document.getElementById('changePasswordForm');
    
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const form = e.target;
            const formData = new FormData(form);
            const messageDiv = document.getElementById('passwordMessage');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Disable button and show loader
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline';
            messageDiv.style.display = 'none';
            
            try {
                const response = await fetch('change-password.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    messageDiv.textContent = '✅ ' + result.message + ' Redirecting to login...';
                    messageDiv.className = 'success';
                    messageDiv.style.display = 'block';
                    
                    // Reset form
                    form.reset();
                    
                    // Redirect to login after 2 seconds
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 2000);
                } else {
                    messageDiv.textContent = '❌ ' + result.error;
                    messageDiv.className = 'error';
                    messageDiv.style.display = 'block';
                    
                    // Re-enable button
                    submitBtn.disabled = false;
                    btnText.style.display = 'inline';
                    btnLoader.style.display = 'none';
                }
            } catch (error) {
                messageDiv.textContent = '❌ Network error. Please try again.';
                messageDiv.className = 'error';
                messageDiv.style.display = 'block';
                
                // Re-enable button
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoader.style.display = 'none';
            }
        });

        // Password confirmation validation
        const confirmPassword = document.getElementById('confirm_password');
        if (confirmPassword) {
            confirmPassword.addEventListener('input', (e) => {
                const newPassword = document.getElementById('new_password').value;
                const confirmPasswordValue = e.target.value;
                
                if (confirmPasswordValue && newPassword !== confirmPasswordValue) {
                    e.target.setCustomValidity('Passwords do not match');
                } else {
                    e.target.setCustomValidity('');
                }
            });
        }
    }
});

// Add more JavaScript functions here as needed
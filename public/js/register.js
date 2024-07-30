
// Check exist email or phone number 
document.addEventListener('DOMContentLoaded', function() {
    const emailPhoneInput = document.getElementById('emailPhone');
    const feedbackMsg = document.getElementById('emailPhoneFeedback');

    emailPhoneInput.addEventListener('input', function() {
        const value = emailPhoneInput.value;
        if (value) {
            checkEmailPhone(value);
        } else {
            feedbackMsg.textContent = '';
        }
    });

    async function checkEmailPhone(value) {
        console.log('Checking email/phone:', value);
        try {
            const response = await fetch('?route=user&subroute=checkEmailPhone', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ emailPhone: value })
            });
            console.log('Server response:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const responseText = await response.text();
            const jsonStart = responseText.indexOf('{');
            const jsonEnd = responseText.lastIndexOf('}') + 1;
            const jsonString = responseText.slice(jsonStart, jsonEnd);
            console.log('JSON string:', jsonString);

            const data = JSON.parse(jsonString);
            console.log('Server data:', data);

            if (data.check === true) {
                feedbackMsg.textContent = 'Email/Phone already exists';
                feedbackMsg.style.color = 'red';
            } else {
                feedbackMsg.textContent = '';
            }
        } catch (error) {
            console.log('Error checking email/phone:', error);
            feedbackMsg.textContent = 'Error checking email/phone';
            feedbackMsg.style.color = 'red';
        }
    }
});

// View password toggle button register page
document.addEventListener('DOMContentLoaded', () => {
    const togglePasswordVisibility = (toggleButton, passwordField) => {
        const eyeIcon = toggleButton.querySelector('.fa-eye');
        const eyeSlashIcon = toggleButton.querySelector('.fa-eye-slash');

        toggleButton.addEventListener('click', () => {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'block';
            } else {
                passwordField.type = 'password';
                eyeIcon.style.display = 'block';
                eyeSlashIcon.style.display = 'none';
            }
        });
    };

    // Toggle password visibility for register page
    const registerPasswordFields = [
        { field: document.getElementById('password'), toggleButton: document.querySelectorAll('.toggle-password')[0] },
        { field: document.getElementById('re_password'), toggleButton: document.querySelectorAll('.toggle-password')[1] }
    ];

    registerPasswordFields.forEach(({ field, toggleButton }) => {
        if (field && toggleButton) {
            togglePasswordVisibility(toggleButton, field);
        }
    });

    // Toggle password visibility for change password page
    const changePasswordFields = [
        { field: document.getElementById('user_old_pass'), toggleButton: document.querySelector('.toggle-password.toggle-password-1') },
        { field: document.getElementById('user_new_pass'), toggleButton: document.querySelector('.toggle-password.toggle-password-2') },
        { field: document.getElementById('user_confirm_pass'), toggleButton: document.querySelector('.toggle-password.toggle-password-3') }
    ];

    changePasswordFields.forEach(({ field, toggleButton }) => {
        if (field && toggleButton) {
            togglePasswordVisibility(toggleButton, field);
        }
    });
});


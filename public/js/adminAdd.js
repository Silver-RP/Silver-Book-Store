
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
            const response = await fetch('?act=user&action=checkEmailPhone', {
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

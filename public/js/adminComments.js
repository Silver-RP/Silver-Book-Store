document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-primary.action-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 
            const url = this.getAttribute('href');
            const button = this;
            const reviewId = new URLSearchParams(url.split('?')[1]).get('id');
            const statusCell = document.querySelector(`.review-status[data-review-id="${reviewId}"]`);

            fetch(url)
                .then(response => response.text()) 
                .then(responseText => {
                    const jsonString = extractJson(responseText);
                    const data = JSON.parse(jsonString);
                    if (data.status === 'success') {
                        if (data.action === 'show') {
                            button.textContent = 'Hide';
                            button.setAttribute('href', url.replace('show', 'hide'));
                            statusCell.textContent = '1'; 
                        } else if (data.action === 'hide') {
                            button.textContent = 'Show';
                            button.setAttribute('href', url.replace('hide', 'show'));
                            statusCell.textContent = '0'; 
                        }
                    } else {
                        alert('Error performing the action.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error performing the action.');
                });
        });
    });
});

function extractJson(responseText) {
    if (typeof responseText !== 'string') {
        console.error("Invalid response format");
        return '{}';
    }
    try {
        const jsonMatch = responseText.match(/({.*})/);
        if (!jsonMatch) {
            console.error("No valid JSON object found in response");
            return '{}';
        }
        let jsonString = jsonMatch[0];
        const jsonEnd = jsonString.lastIndexOf('}') + 1;
        jsonString = jsonString.slice(0, jsonEnd).trim();

        console.log("Extracted JSON String:", jsonString);

        JSON.parse(jsonString); // Validate JSON string
        return jsonString;
    } catch (e) {
        console.error("Failed to parse JSON:", e);
        return '{}';
    }
}

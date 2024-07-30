document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('category-button').textContent = this.textContent;
            document.getElementById('category-button').dataset.category = this.dataset.category;
        });
    });

    document.getElementById('search-button').addEventListener('click', function() {
        const keyword = document.getElementById('search-input').value;
        const category = document.getElementById('category-button').dataset.category || 'all';

        const url = new URL('/SilverBook/index.php', window.location.origin);
        url.searchParams.append('route', 'search');
        url.searchParams.append('subroute', 'search');
        url.searchParams.append('keyword', keyword);
        url.searchParams.append('category', category);

        fetch(url.href)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.text();
            })
            .then(responseText => {
                try {
                    const jsonString = extractJson(responseText);
                    console.log('JSON-1111111111:', jsonString);
                    const data = JSON.parse(jsonString);

                    const resultsDiv = document.getElementById('search-results');
                    resultsDiv.innerHTML = ''; // Clear previous results

                    if (data.length > 0) {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.textContent = item.book_title; // Adjust according to your data structure
                            resultsDiv.appendChild(div);
                        });
                    } else {
                        resultsDiv.textContent = 'No results found.';
                    }
                } catch (error) {
                    console.error('Failed to parse JSON:', error);
                }
            })
            .catch(error => console.error('Error:', error));
    });
});

function extractJson(responseText) {
    // Match JSON object
    const jsonMatch = responseText.match(/({.*})/);
    return jsonMatch ? jsonMatch[0] : '{}';
}
function extractJson(responseText) {
    if (typeof responseText !== 'string') {
        console.error("Invalid response format");
        return '{}';
    }
    console.log("Response:", responseText);
    try {
        // Remove any extraneous text outside of JSON objects
        const jsonMatch = responseText.match(/{[\s\S]*}/);
        if (!jsonMatch) {
            console.error("No valid JSON object found in response");
            return '{}';
        }
        
        const jsonString = jsonMatch[0];
        console.log("JSON:", jsonString);
        // Validate JSON
        JSON.parse(jsonString);
        return jsonString;
    } catch (e) {
        console.error("Failed to parse JSON:", e);
        return '{}';
    }
}


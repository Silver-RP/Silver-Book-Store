class CommentFormHandle {
    constructor(formId, responseDivId) {
        this.form = document.getElementById(formId);
        this.responseDiv = document.getElementById(responseDivId);
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.setupStarRating();
    }

    async handleSubmit(e) {
        e.preventDefault();

        const bookId = this.form.querySelector('input[name="book_id"]').value;
        const comment = this.form.querySelector('textarea[name="comment"]').value;
        const rating = this.form.querySelector('input[name="rating"]:checked')?.value;

        if (!rating) {
            this.responseDiv.innerText = "Please select a rating";
            return;
        }

        const data = { book_id: bookId, comment, rating };
        try {
            const response = await fetch('index.php?route=books&subroute=review', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const responseText = await response.text();
            console.log('Server response:', responseText);  

            const jsonString = this.extractJson(responseText);
            console.log('Extracted JSON string:', jsonString);

            try {
                const result = JSON.parse(jsonString);
                this.responseDiv.innerText = result.message;

                if (result.success) {
                    this.form.reset();
                    fetchAndDisplayReviews(bookId);
                }
            } catch (jsonError) {
                console.error('Error parsing JSON:', jsonError);
                this.responseDiv.innerText = 'Error parsing server response. Please try again.';
            }
        } catch (error) {
            console.error('Error submitting review:', error);
            this.responseDiv.innerText = 'Error submitting review. Please try again.';
        }
    }

    extractJson(responseText) {
        // Match JSON object
        const jsonMatch = responseText.match(/({.*})/);
        return jsonMatch ? jsonMatch[0] : '{}';
    }

    setupStarRating() {
        const starLabels = document.querySelectorAll('.star-rating label');

        starLabels.forEach(label => {
            label.addEventListener('mouseover', () => {
                const index = Array.from(starLabels).indexOf(label);
                updateStarRating(index, 'fa-solid', 'hovered');
            });

            label.addEventListener('mouseout', () => {
                const checkedIndex = Array.from(starLabels).findIndex(l => l.previousElementSibling.checked);
                updateStarRating(checkedIndex, 'fa-solid', '');
            });
        });

        function updateStarRating(index, iconClass, hoverClass) {
            starLabels.forEach((label, i) => {
                label.classList.remove('fa-solid', 'fa-regular', 'hovered');
                if (i <= index) {
                    label.classList.add(iconClass);
                    label.classList.add(hoverClass);
                } else {
                    label.classList.add('fa-regular');
                }
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new CommentFormHandle('commentForm', 'responseDiv');
});

function fetchAndDisplayReviews(bookId) {
    fetch(`index.php?route=books&subroute=reviews&book_id=${bookId}`)
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Network error:', text);
                    throw new Error('Network response was not ok.');
                });
            }
            return response.text(); 
        })
        .then(responseText => {
            console.log('Full response text:', responseText);
            const jsonString = extractJson(responseText);
            return JSON.parse(jsonString); 
        })
        .then(data => {
            if (!data.success) {
                console.error('Server error:', data.message);
                return;
            }
            renderComments(data.data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

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

        JSON.parse(jsonString); 
        return jsonString;
    } catch (e) {
        console.error("Failed to parse JSON:", e);
        return '{}';
    }
}

function renderComments(comments) {
    const commentsContainer = document.getElementById('commentsContainer');
    if (!commentsContainer) {
        console.error('Comments container not found');
        return;
    }
    commentsContainer.innerHTML = '';

    const displayCount = 5;
    const commentsToShow = comments.slice(0, displayCount);
    const hasMoreComments = comments.length > displayCount;

    commentsToShow.forEach(comment => {
        const commentDiv = document.createElement('div');
        commentDiv.classList.add('col-md-12', 'review-card');

        const reviewHeader = document.createElement('div');
        reviewHeader.classList.add('review-title');
        reviewHeader.textContent = comment.user_name || 'Anonymous';

        const reviewDate = document.createElement('div');
        reviewDate.classList.add('review-date');
        reviewDate.textContent = comment.review_date;
        reviewHeader.appendChild(reviewDate);

        const reviewRating = document.createElement('div');
        reviewRating.classList.add('review-rating');
        reviewRating.textContent = '★'.repeat(comment.review_rating) + '☆'.repeat(5 - comment.review_rating);

        const reviewText = document.createElement('div');
        reviewText.classList.add('review-text');
        reviewText.textContent = comment.review_content;

        commentDiv.appendChild(reviewHeader);
        commentDiv.appendChild(reviewRating);
        commentDiv.appendChild(reviewText);

        commentsContainer.appendChild(commentDiv);
    });

    if (hasMoreComments) {
        const viewMoreButton = document.createElement('button');
        viewMoreButton.classList.add('btn', 'btn-warning', 'view-more-btn');
        viewMoreButton.textContent = 'View More';
        viewMoreButton.addEventListener('click', () => {
            renderMoreComments(comments, displayCount);
        });
        commentsContainer.appendChild(viewMoreButton);
    }
}

function renderMoreComments(comments, startIndex) {
    const commentsContainer = document.getElementById('commentsContainer');
    if (!commentsContainer) {
        console.error('Comments container not found');
        return;
    }

    const commentsToShow = comments.slice(startIndex, startIndex + 10);
    commentsToShow.forEach(comment => {
        const commentDiv = document.createElement('div');
        commentDiv.classList.add('col-md-12', 'review-card');

        const reviewHeader = document.createElement('div');
        reviewHeader.classList.add('review-title');
        reviewHeader.textContent = comment.user_name || 'Anonymous';

        const reviewDate = document.createElement('div');
        reviewDate.classList.add('review-date');
        reviewDate.textContent = comment.review_date;
        reviewHeader.appendChild(reviewDate);

        const reviewRating = document.createElement('div');
        reviewRating.classList.add('review-rating');
        reviewRating.textContent = '★'.repeat(comment.review_rating) + '☆'.repeat(5 - comment.review_rating);

        const reviewText = document.createElement('div');
        reviewText.classList.add('review-text');
        reviewText.textContent = comment.review_content;

        commentDiv.appendChild(reviewHeader);
        commentDiv.appendChild(reviewRating);
        commentDiv.appendChild(reviewText);

        commentsContainer.appendChild(commentDiv);
    });

    if (startIndex + 10 < comments.length) {
        const viewMoreButton = document.createElement('button');
        viewMoreButton.classList.add('btn', 'btn-warning', 'view-more-btn');
        viewMoreButton.textContent = 'View More';
        viewMoreButton.addEventListener('click', () => {
            renderMoreComments(comments, startIndex + 10);
        });
        commentsContainer.appendChild(viewMoreButton);
    } else {
        const viewMoreButton = document.querySelector('.view-more-btn');
        if (viewMoreButton) {
            viewMoreButton.remove();
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const bookId = document.getElementById('book_id').value;
    fetchAndDisplayReviews(bookId);
});
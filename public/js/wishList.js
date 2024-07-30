
// function toggleWishlist(button) {
//     var bookId = button.getAttribute('data-book-id');
//     var xhr = new XMLHttpRequest();

//     xhr.open('POST', 'index.php?route=wish&subroute=add', true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             if (xhr.status === 200) {
//                 try {
//                     var jsonStart = xhr.responseText.indexOf('{');
//                     var jsonEnd = xhr.responseText.lastIndexOf('}') + 1;
//                     var jsonString = xhr.responseText.slice(jsonStart, jsonEnd);
                    
//                     var response = JSON.parse(jsonString);
//                     if (response.success) {
//                         button.classList.toggle('added');
//                         var icon = button.querySelector('i');
//                         if (button.classList.contains('added')) {
//                             icon.classList.remove('fa-regular', 'fa-heart');
//                             icon.classList.add('fa-heart');
//                         } else {
//                             icon.classList.remove('fa-heart');
//                             icon.classList.add('fa-regular', 'fa-heart');
//                         }
//                     } else {
//                         alert (response.message);
//                         console.error('Error:', response.message);
//                     }
//                 } catch (e) {
//                     console.error('Error parsing JSON response:', e);
//                 }
//             } else {
//                 console.error('AJAX error:', xhr.statusText);
//             }
//         }
//     };
//     xhr.send('book_id=' + encodeURIComponent(bookId));
// }

// handle when user click on the wish button
function toggleWishlist(button) {
    var bookId = button.getAttribute('data-book-id');
    var xhr = new XMLHttpRequest();
    var isAdding = !button.classList.contains('added');

    xhr.open('POST', 'index.php?route=wish&subroute=' + (isAdding ? 'add' : 'remove'), true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                try {
                    var jsonStart = xhr.responseText.indexOf('{');
                    var jsonEnd = xhr.responseText.lastIndexOf('}') + 1;
                    var jsonString = xhr.responseText.slice(jsonStart, jsonEnd);
                    var response = JSON.parse(jsonString);
                    if (response.success) {
                        button.classList.toggle('added');
                        var icon = button.querySelector('i');
                        icon.className = isAdding ? 'fa fa-heart' : 'fa-regular fa-heart';
                    } else {
                        console.error('Error:', response.message);
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            } else {
                console.error('AJAX error:', xhr.statusText);
            }
        }
    };

    xhr.send('book_id=' + encodeURIComponent(bookId));
}

// handle when user remove book from wish list from the wish list page
document.addEventListener('DOMContentLoaded', function() {
    const removeWishButtons = document.querySelectorAll('.remove-wish-btn');
    removeWishButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 
            const bookId = this.getAttribute('data-book-id'); 
            const row = document.getElementById(`book-${bookId}`); 

            fetch('index.php?route=wish&subroute=removepage', {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify({ book_id: bookId }) 
            })
            .then(response => response.text()) 
            .then(text => {
                let data;
                try {
                    const jsonStart = text.indexOf('{');
                    const jsonEnd = text.lastIndexOf('}') + 1;
                    const jsonString = text.slice(jsonStart, jsonEnd);
                    data = JSON.parse(jsonString);
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('Error parsing server response. Please try again.');
                    return;
                }
                if (data.success) {
                    row.remove();
                } else {
                    alert(data.message); 
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.'); 
            });
        });
    });
});

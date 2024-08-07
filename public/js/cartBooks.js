
function addToCart(button) {
    const bookId = button.dataset.bookId;
    const quantityInput = document.getElementById('quantityInput');
    const quantity = quantityInput ? quantityInput.value : 1;

    fetch('index.php?route=cart&subroute=add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ book_id: bookId, quantity: quantity })
    })
    .then(response => response.text()) 
    .then(text => {
        console.log('Server response:', text); 
        let data;
        try {
            const jsonStart = text.indexOf('{');
            const jsonEnd = text.lastIndexOf('}') + 1;
            const jsonString = text.slice(jsonStart, jsonEnd);
            // console.log('JSON string:', jsonString);
            data = JSON.parse(jsonString);

        } catch (error) {
            console.error('Error parsing JSON:', error);
            alert('Error parsing server response. Please try again.');
            return;
        }
        if (data.status === 'success') {
            const successMsg = document.getElementById('success-message');
            successMsg.textContent = data.message;
            successMsg.style.display = 'block';
            setTimeout(()=>{
                successMsg.style.display.opacity = 0;
                setTimeout(()=>{
                    successMsg.style.display = 'none';
                    // successMsg.style.opacity = 0.7;
                }, 500);
            }, 800);
            // alert(data.message);
            console.log(data.message);
            document.querySelector('.cart-count').textContent = data.cart;
        } else {
            alert(data.message);
            console.error('Error adding book to cart:', data.message);
        }
    })
    .catch(error => {
        console.error('Error adding book to cart: ', error);
    });
}

function updateQuantity(bookId, newQuantity) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?route=cart&subroute=update', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            let response;
            try {
                const jsonStart = xhr.responseText.indexOf('{');
                const jsonEnd = xhr.responseText.lastIndexOf('}') + 1;  
                const jsonString = xhr.responseText.slice(jsonStart, jsonEnd);
                response = JSON.parse(jsonString);
                console.log('JSON response:', response);
            } catch (error) {
                console.error('Error parsing JSON when update quantity:', error);
                return;
            }
            if(response.status === 'success'){
                let totalElement = document.getElementById('total-price-'+ bookId);
                totalElement.innerHTML =  '<p class="mb-0">$' + (response.newPrice).toFixed(2) + '</p>';

                var subtotalElement = document.getElementById('subtotal');
                subtotalElement.textContent = '$' + (response.subtotal).toFixed(2);

                var totalBooksElement = document.getElementById('total-books');
                totalBooksElement.textContent = response.totalBooks;

                var totalPriceElement = document.getElementById('total-price');
                totalPriceElement.textContent = '$' + (response.subtotal).toFixed(2);
            }
        }
    };
    xhr.send('book_id=' + encodeURIComponent(bookId) + '&newquantity='+ encodeURIComponent(newQuantity));
    
}

function removeFromCart(bookId) {
    // if (confirm('Are you sure you want to remove this book from your cart?')) {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php?route=cart&subroute=remove', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response;
                try {
                    const jsonStart = xhr.responseText.indexOf('{');
                    const jsonEnd = xhr.responseText.lastIndexOf('}') + 1;
                    const jsonString = xhr.responseText.slice(jsonStart, jsonEnd);
                    response = JSON.parse(jsonString);
                } catch (error) {
                    console.error('Error parsing JSON when removing book:', error);
                    return;
                }
                if (response.status === 'success') {
                    let bookElement = document.getElementById('book-' + bookId);
                    if (bookElement) {
                        bookElement.remove();
                    }
                    let subtotalElement = document.getElementById('subtotal');
                    subtotalElement.textContent = '$' + (response.subtotal).toFixed(2);

                    let totalBooksElement = document.getElementById('total-books');
                    totalBooksElement.textContent = response.totalBooks;

                    let totalPriceElement = document.getElementById('total-price');
                    totalPriceElement.textContent = '$' + (response.subtotal).toFixed(2);

                    document.querySelector('.cart-count').textContent = response.cart;
                }
                window.location.reload();
            }
        };
        xhr.send('book_id=' + encodeURIComponent(bookId));
    // }
}

function removeAllFromCart(){
    if (confirm('Are you sure you want to remove all books from your cart?')) {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php?route=cart&subroute=removeAll', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let response;
                try {
                    const jsonString = extractJson(xhr.responseText);
                    response = JSON.parse(jsonString);
                } catch (error) {
                    console.error('Error parsing JSON when removing all books:', error);
                    return;
                }
                if (response.success === true) {
                    let booksElement = document.getElementById('books');
                    if (booksElement) {
                        booksElement.innerHTML = '';
                    }
                    let subtotalElement = document.getElementById('subtotal');
                    subtotalElement.textContent = '$0.00';

                    let totalBooksElement = document.getElementById('total-books');
                    totalBooksElement.textContent = '0';

                    let totalPriceElement = document.getElementById('total-price');
                    totalPriceElement.textContent = '$0.00';

                    document.querySelector('.cart-count').textContent = '0';
                }
                window.location.reload();
            }
        };
        xhr.send();
    }    

}
// Check box for editing cart items
let isOptionsVisible = false;
function toggleOptions() {
    const optionsDiv = document.getElementById('options');
    isOptionsVisible = !isOptionsVisible;
    optionsDiv.style.display = isOptionsVisible ? 'block' : 'none';
}

// Save all items in the cart to the user's wishlist
function saveToWishlist() {
    const userId = document.getElementById('user-id').value;

    // Fetch cart items
    fetch("?route=cart&subroute=getAllItems", {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.text())
    .then(cartItemsData => {
        const jsonStringItems = extractJson(cartItemsData);
        let items;
        try {
            items = JSON.parse(jsonStringItems);
        } catch (e) {
            throw new Error("Failed to parse cart items JSON: " + e.message);
        }
        
        console.log("Parsed cart items:", items);

        // Check the structure of the items
        if (!items || !Array.isArray(items.books)) {
            throw new Error("Expected items.books to be an array, but got: " + (items ? typeof items.books : 'undefined'));
        }

        const formattedBooks = items.books.map(item => ({ book_id: item.book_id }));
        const requestData = {
            userId: userId,
            books: formattedBooks
        };

        // Post data to wishlist
        return fetch("?route=wish&subroute=addAll", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(requestData)
        });
    })
    .then(response => response.text())
    .then(text => {
        const jsonStringAdded = extractJson(text);
        let result;
        try {
            result = JSON.parse(jsonStringAdded);
        } catch (e) {
            throw new Error("Failed to parse wishlist response JSON: " + e.message);
        }
        
        console.log("Parsed server response:", result);

        if (result.success === true) {
            alert("All items have been saved to your wishlist!");
        } else {
            alert("Failed to save items to wishlist: " + result.message);
        }
    })
    .catch(error => {
        console.error("Error saving items to wishlist:", error);
        alert("An error occurred while saving items to your wishlist.");
    });
}

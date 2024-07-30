
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
    if (confirm('Are you sure you want to remove this book from your cart?')) {
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
            }
        };
        xhr.send('book_id=' + encodeURIComponent(bookId));
    }
}

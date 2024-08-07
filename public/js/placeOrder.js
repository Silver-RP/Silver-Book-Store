
//  Update quantity by js, not save to database
function updateQuantityBuyNow(bookId, quantity) {
    var bookElement = document.querySelector(`[data-book-id="${bookId}"]`);
    if (!bookElement) {
        console.error('Book element not found');
        return;
    }
    var bookPrice = parseFloat(bookElement.getAttribute('data-book-price'));
    var totalPrice = (bookPrice * quantity).toFixed(2);

    document.getElementById('total-price-' + bookId).innerHTML = '$' + totalPrice;
    document.getElementById('subtotal').innerHTML = '$' + totalPrice;
    document.getElementById('total-price').innerHTML = '$' + totalPrice;
    document.getElementById('total-books').innerHTML = quantity;
}

// Remove book by js, not save to database
function removeFromBuyNow(bookId) {
    if(!confirm('Are you sure you want to remove this book from the cart?')) {
        return;
    }
    window.location.href = 'index.php?route=home';
    console.log('Remove book with ID:', bookId);
}

// Show-shipping-info
document.getElementById('show-shipping-info').addEventListener('click', function() {
    document.getElementById('shipping-info').classList.toggle('d-none');
});

// Show-payment-method
document.addEventListener("DOMContentLoaded", function () {
    const toggleIcon = document.getElementById("show-payment-method");
    const paymentMethodSection = document.getElementById("payment-method");
    const cardInfoSection = document.getElementById("card-info");
    const paypalInfoSection = document.getElementById("paypal-info");
    const paymentMethodInputs = document.getElementsByName("payment-method");

    toggleIcon.addEventListener("click", function () {
        paymentMethodSection.classList.toggle("d-none");
    });

    paymentMethodInputs.forEach(function (input) {
        input.addEventListener("change", function () {
            if (input.id === "credit-card") {
                cardInfoSection.classList.remove("d-none");
                paypalInfoSection.classList.add("d-none");
            } else if (input.id === "paypal") {
                cardInfoSection.classList.add("d-none");
                paypalInfoSection.classList.remove("d-none");
            } else {
                cardInfoSection.classList.add("d-none");
                paypalInfoSection.classList.add("d-none");
            }
        });
    });
});

// Handle form proceed to checkout
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("proceed-checkout").addEventListener("click", function () {
        // Get user ID
        const userId = document.getElementById("user-id").value;

        // Gather shipping information
        const fullName = document.getElementById("full-name").value.trim();
        const address = document.getElementById("address").value.trim();
        const city = document.getElementById("city").value.trim();
        const state = document.getElementById("state").value.trim();
        const zipCode = document.getElementById("zip-code").value.trim();
        const phoneNumber = document.getElementById("phone-number").value.trim();

        if (!fullName || !address || !city || !state || !zipCode || !phoneNumber) {
            alert("Please fill in all shipping details.");
            return;
        }

        // Gather payment information
        const paymentMethod = document.querySelector('input[name="payment-method"]:checked').value;
        let cardNumber, cardHolderName, expirationDate, cvv, paypalEmail;

        if (paymentMethod === "credit_card") {
            cardNumber = document.getElementById("card-number") ? document.getElementById("card-number").value.trim() : '';
            cardHolderName = document.getElementById("card-holder-name") ? document.getElementById("card-holder-name").value.trim() : '';
            expirationDate = document.getElementById("expiration-date") ? document.getElementById("expiration-date").value.trim() : '';
            cvv = document.getElementById("cvv") ? document.getElementById("cvv").value.trim() : '';

            // if (!validateCardNumber(cardNumber) || !validateExpirationDate(expirationDate) || !validateCVV(cvv)) {
            //     alert("Please fill in valid credit card details.");
            //     return;
            // }
        } else if (paymentMethod === "paypal") {
            paypalEmail = document.getElementById("paypal-email") ? document.getElementById("paypal-email").value.trim() : '';

            if (!validateEmail(paypalEmail)) {
                alert("Please fill in a valid PayPal email.");
                return;
            }
        }

        // Gather order information
        // const bookId = document.getElementById('book-id') ? document.getElementById('book-id').value : null;
        // const quantity = document.getElementById(`quantity-${bookId}`) ? document.getElementById(`quantity-${bookId}`).value : null;
        // const bookItemPrice = parseFloat(document.getElementById(`total-price-${bookId}`) ? document.getElementById(`total-price-${bookId}`).textContent.replace('$', '') : '0');
        // const totalPrice = parseFloat(document.getElementById('total-price') ? document.getElementById('total-price').textContent.replace('$', '') : '0');
        // const totalBooks = parseInt(document.getElementById('total-books') ? document.getElementById('total-books').textContent : '0');


        // Garther order information for all books in cart
        const bookIds = document.querySelectorAll('.book-id');
        const totalPrice = parseFloat(document.getElementById('total-price').textContent.replace('$', ''));
        const totalBooks = parseInt(document.getElementById('total-books').textContent);

        const AllbookId =[];

        bookIds.forEach(input =>{
            const bookId = input.value;
            AllbookId.push(bookId);
            console.log("Book ID:", bookId);
        })

        const books = [];
        for (let i = 0; i < AllbookId.length; i++) {
            const bookId = AllbookId[i];
            const quantity = document.getElementById(`quantity-${bookId}`) ? document.getElementById(`quantity-${bookId}`).value : null;
            const bookItemPrice = parseFloat(document.getElementById(`total-price-${bookId}`) ? document.getElementById(`total-price-${bookId}`).textContent.replace('$', '') : '0');
            books.push({
                book_id: bookId,
                quantity: quantity,
                price: bookItemPrice
            });

            if (!bookId || !quantity || !bookItemPrice) {
                alert("Invalid book information found.");
                return;
            }
        }
        console.log("Books:", books);
        const data = {
            user_id: userId,
            shipping: {
                full_name: fullName,
                address: address,
                city: city,
                state: state,
                zip_code: zipCode,
                phone_number: phoneNumber
            },
            payment: {
                payment_method: paymentMethod,
                card_number: cardNumber,
                card_holder_name: cardHolderName,
                expiration_date: expirationDate,
                cvv: cvv,
                paypal_email: paypalEmail
            },
            order: {
                total_price: totalPrice,
                total_books: totalBooks,
                books: books
            }
        };

        console.log("Checkout data:", data);

        // Send checkout request to server
        fetch("?route=order&subroute=checkout", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(response => response.text())
        .then(responseText => {
            try {
                const jsonString = extractJson(responseText);
                console.log("Server response:", jsonString);
                const result = JSON.parse(jsonString);

                if (result.success === true) {
                    alert("Order placed successfully!");
                    clearCartInDatabase();
                    // window.location.href = "index.php?route=order&subroute=success";
                } else {
                    alert("Failed to place order: " + result.message);
                }
            } catch (e) {
                console.error("Error parsing server response:", e);
                alert("An error occurred while processing your order.");
            }
        })
        .catch(error => {
            console.error("Error during checkout:", error);
            alert("An error occurred while processing your order.");
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


        JSON.parse(jsonString); 
        console.log("JSON string:", jsonString);
        return jsonString;
    } catch (e) {
        console.error("Failed to parse JSON:", e);
        return '{}';
    }
}

function validateCardNumber(cardNumber) {
    return cardNumber.length === 16 && !isNaN(cardNumber);
}

function validateExpirationDate(expirationDate) {
    const parts = expirationDate.split('/');
    if (parts.length !== 2) return false;
    const month = parseInt(parts[0], 10);
    const year = parseInt(parts[1], 10);
    return month >= 1 && month <= 12 && year >= new Date().getFullYear();
}

function validateCVV(cvv) {
    return cvv.length === 3 && !isNaN(cvv);
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

//  Hanlding clear cart in database after order placed
function clearCartInDatabase() {
    fetch("?route=cart&subroute=clear", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify()
    })
    .then(response => response.text()) // Get response as text
    .then(responseText => {
        const jsonString = extractJson(responseText);
        const result = JSON.parse(jsonString);
        console.log("Server response:", result);

        if (result.success === true) {
            window.location.href = "index.php?route=order&subroute=success";
        } else {
            alert("Failed to clear cart: " + result.message);
        }
    })
    .catch(error => {
        console.error("Error clearing cart:", error);
        alert("An error occurred while clearing your cart.");
    });
}





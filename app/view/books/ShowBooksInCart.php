<section class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-5 fw-bold bg-warning-subtle py-2">YOUR CART</h2>
        </div>
    </div>
    <?php
    if (isset($_SESSION['user'])) {
        if (empty($books)) {
            echo '<div class="row">
                        <div class="col-md-12 ps-4">
                            <p class="">No books in Your cart</p>
                        </div>
                        <div class="col-md-12 ">
                        <a href="?route=home" class="btn btn-warning"><i class="fas fa-shopping-cart"></i> Continue Shopping</a>
                        </div>
                    </div>';
        } else {
    ?>
    <!-- Check box edit -->
    <div class="container ">
        <div class="d-flex justify-content-between">
            <div class="editCheckBox">
                <input type="checkbox" id="editRadio" name="optionsRadios" onclick="toggleOptions()">
                <label for="editRadio">Edit</label>
            </div>
        </div>

        <div id="options" class="optionsEditCheckBox mt-1">
            <button class="btn btn-later" onclick="saveForLater()">Save all for later</button>
            <button class="btn btn-wishlist" onclick="saveToWishlist()">Save all to wishlist</button>
            <button class="btn btn-remove" onclick="removeAllFromCart()">Remove All</button>
        </div>
    </div>

    <!-- Books card and orders Summary -->
    <div class="container d-flex bookcard-ordersummary">
        <!-- User id -->
        <input type="hidden" name="user-id" id="user-id" value="<?php echo htmlspecialchars($_SESSION['user']['user_id']) ?>">
        <div class="row">
            <div class="row">
                <!-- Book detail -->
                <div class="col-md-8 bookcard">
                    <?php foreach ($books as $book) : ?>
                        <!-- Book id -->
                        <input type="hidden" name="book-id" class="book-id" id="book-id" value="<?php echo htmlspecialchars($book['book_id']) ?>">
                        <div class="col-12 ">
                            <div class="row align-items-center border-bottom py-3">
                                <!-- Book Image -->
                                <div class="col-md-2">
                                    <img src="public/images/book_name/<?php echo htmlspecialchars($book['book_image']); ?>" alt="<?php echo htmlspecialchars($book['book_name']); ?>" class="img-fluid" style="max-width:100px; max-height: 150px; min-width: 90px;"><br>
                                    <a href="#" class="text-black text-opacity-50 fw-light">Save for later</a>
                                </div>
                                <!-- Book Information -->
                                <div class="col-md-3">
                                    <h5 class=" mb-2 mb-1"><?php echo htmlspecialchars($book['book_name']); ?></h5>
                                    <p class="mb-0">
                                        <span class="fw-semibold">Author:</span>
                                        <?php foreach ($authors as $author) {
                                            if ($author['author_id'] == $book['author_id']) {
                                                echo htmlspecialchars($author['author_name']);
                                            }
                                        }

                                        ?>
                                    </p>
                                    <p class="mb-0"><span class="fw-semibold">Category:</span>
                                        <?php foreach ($categories as $category) {
                                            if ($category['cate_id'] == $book['cate_id']) {
                                                echo htmlspecialchars($category['cate_name']);
                                            }
                                        }
                                        ?>
                                    <p class="mb-0 bg-warning-subtle">
                                        <span class="fw-semibold">Price:</span>
                                        <span class="text-danger fw-bold" id="book-price-<?php echo htmlspecialchars($book['book_id']); ?>">$<?php echo htmlspecialchars($book['book_price']); ?></span>
                                        <del style="font-size: 14px;">$<?php echo htmlspecialchars($book['book_old_price']); ?></del>
                                    </p>
                                </div>
                                <!-- Quantity Input -->
                                <div class="col-md-2  ps-5">
                                    <input type="number" class="form-control " id="quantity-<?php echo htmlspecialchars($book['book_id']); ?>" min="1" value="<?php echo htmlspecialchars($book['quantity']); ?>" onchange="updateQuantity(<?php echo htmlspecialchars($book['book_id']); ?>, this.value)">
                                </div>
                                <!-- Total Price of Book Item-->
                                <div class="col-md-2  ps-5" id="total-price-<?php echo htmlspecialchars($book['book_id']); ?>">
                                    <p class="mb-0">$<?php echo htmlspecialchars($book['book_price'] * $book['quantity']); ?></p>
                                </div>
                                <!-- Remove Button -->
                                <div class="col-md-2 ps-5 ">
                                    <button class="btn btn-danger opacity-75" onclick="removeFromCart(<?php echo htmlspecialchars($book['book_id']); ?>)">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Order Summary -->
                <div class="col-md-4 px-5 pt-3 bg-light order-summary" id="order-summary">
                    <div class="col-md-12">
                        <h4>Order Summary</h4>
                        <div class="d-flex justify-content-between summary-item">
                            <span>Subtotal:</span>
                            <span id="subtotal">
                                <?php
                                $total = 0;
                                foreach ($books as $book) {
                                    $total += $book['book_price'] * $book['quantity'];
                                }
                                echo '$' . number_format($total, 2);
                                ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between summary-item">
                            <span>Estimated Tax:</span>
                            <span>$0</span>
                        </div>
                        <div class="d-flex justify-content-between summary-item">
                            <span>Estimated Shipping:</span>
                            <span>$0</span>
                        </div>
                        <div class="d-flex justify-content-between summary-item">
                            <span>Total Number of Books:</span>
                            <span id="total-books">
                                <?php
                                $totalBooks = 0;
                                foreach ($books as $book) {
                                    $totalBooks += $book['quantity'];
                                }
                                echo $totalBooks;
                                ?>
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between summary-item">
                        <h5>Total: </h5>
                        <span id="total-price" class="fw-bold fs-5"><?php echo '$' . number_format($total, 2); ?></span>
                    </div>
                    <hr>
                    <!-- Shipping Information -->
                    <div id="shipping-info-container" class="section-container">
                        <div class="section-header">
                            <h5>Shipping Information:</h5>
                            <i class="fa-solid fa-forward toggle-icon" id="show-shipping-info"></i>
                        </div>
                        <div id="shipping-info" class="section-content d-none">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Full Name" id="full-name" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Address" id="address" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="input-group mb-3 me-2">
                                    <input type="text" class="form-control" placeholder="City" id="city" required>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="State" id="state" required>
                                </div>
                            </div>
                            <div class="">
                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" placeholder="Phone Number" id="phone-number" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" placeholder="Zip Code" id="zip-code" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- Payment Method -->
                    <div id="payment-method-container" class="section-container">
                        <div class="section-header ">
                            <h5>Payment Method:</h5>
                            <i class="fa-solid fa-forward toggle-icon" id="show-payment-method"></i>
                        </div>
                        <div id="payment-method" class="section-content d-none">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment-method" id="credit-card" value="credit_card" checked>
                                <label class="form-check-label" for="credit-card">
                                    Credit Card <i class="fa-brands fa-cc-visa"></i> <i class="fa-brands fa-cc-mastercard"></i> <i class="fa-brands fa-cc-amex"></i> <i class="fa-brands fa-cc-discover"></i>
                                </label>
                                <!-- Card Information -->
                                <div id="card-info" class="section-content">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Card Number" id="card-number">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Card Holder Name" id="card-holder-name">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="input-group mb-3 me-2" style="flex: 2;">
                                            <input type="text" class="form-control" placeholder="Expiration Date (MM/YY)" id="expiration-date">
                                        </div>
                                        <div class="input-group mb-3" style="flex: 1;">
                                            <input type="text" class="form-control" placeholder="CVV" id="cvv">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment-method" id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    PayPal <i class="fa-brands fa-paypal"></i>
                                </label>
                                <!-- PayPal Information -->
                                <div id="paypal-info" class="section-content d-none">
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" placeholder="PayPal Email" id="paypal-email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment-method" id="cash" value="cash">
                                <label class="form-check-label" for="cash">
                                    Cash on Delivery
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- Promo Code -->
                    <div>
                        <label for="promo-code">Apply Promo Code</label>
                        <div class="input-group mb-3 mt-2">
                            <input type="text" id="promo-code" class="form-control" placeholder="Enter the Promotion Code" aria-label="Promo Code">
                            <button class="btn btn-dark" type="button" id="button-addon2">Apply</button>
                        </div>
                        <button class="btn btn-warning mt-2 proceed" id="proceed-checkout">Place Order</button>
                        <pre>Need Help? Call us at: 1-000-000-9213</pre>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    }
    ?>
</section>
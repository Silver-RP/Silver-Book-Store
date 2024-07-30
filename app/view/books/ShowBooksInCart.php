<section class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-5 fw-bold bg-warning-subtle py-2">YOUR CART</h2>
        </div>
    </div>
    <?php 
        if(isset($_SESSION['user'])){
            if(empty($books)){
                echo '<div class="row">
                        <div class="col-md-12 ">
                            <p class="">No books in Your cart</p>
                        </div>
                    </div>';
            } else {
    ?>
    <div class="container d-flex bookcard-ordersummary">
        <div class="row">
            <div class="row">
                <div class="col-md-8 bookcard">
                    <?php foreach ($books as $book): ?>
                        <div class="col-12 ">
                            <div class="row align-items-center border-bottom py-3">
                                <!-- Book Image -->
                                <div class="col-md-2">
                                    <img src="public/images/book_name/<?php echo htmlspecialchars($book['book_image']); ?>" 
                                        alt="<?php echo htmlspecialchars($book['book_name']); ?>" class="img-fluid" 
                                        style="max-width:100px; max-height: 150px; min-width: 90px;"><br>
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
                                    <p class="mb-0 bg-warning-subtle"><span class="fw-semibold">Price:</span> 
                                            <span class="text-danger fw-bold ">$<?php echo htmlspecialchars($book['book_price']); ?></span>
                                            <del style="font-size: 14px;">$<?php echo htmlspecialchars($book['book_old_price']); ?></del>
                                    </p>
                                </div>
                                <!-- Quantity Input -->
                                <div class="col-md-2  ps-5">
                                    <input type="number" class="form-control " min="1" 
                                        value="<?php echo htmlspecialchars($book['quantity']); ?>" 
                                        onchange="updateQuantity(<?php echo htmlspecialchars($book['book_id']); ?>, this.value)">
                                </div>
                                <!-- Total Price of Book Item-->
                                <div class="col-md-2  ps-5" id="total-price-<?php echo htmlspecialchars($book['book_id']); ?>">
                                    <p class="mb-0">$<?php echo htmlspecialchars($book['book_price'] * $book['quantity']); ?></p>
                                </div>
                                <!-- Remove Button -->
                                <div class="col-md-2 ps-5 ">
                                    <button class="btn btn-danger opacity-75" 
                                            onclick="removeFromCart(<?php echo htmlspecialchars($book['book_id']); ?>)">
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
                                    foreach($books as $book){
                                        $totalBooks += $book['quantity'];
                                    }
                                    echo $totalBooks;
                                ?>
                             </span>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <h5>Total: <span id="total-price"><?php echo '$' . number_format($total, 2); ?></span></h5>
                    </div>
                    <hr>
                    <div>
                        <label for="promo-code">Apply Promo Code</label>
                        <div class="input-group mb-3 mt-2">
                            <input type="text" id="promo-code" class="form-control" placeholder="Enter the Promotion Code " aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-dark" type="button" id="button-addon2">Apply</button>
                        </div>
                        <button class="btn btn-warning mt-2 proceed">Proceed to Checkout</button>
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



<section>
    <div>
        <div class="row my-5">
            <div class="col-md-12">
                <h2 class="text-center mb-5 fw-bold bg-warning-subtle py-2">YOUR CART</h2>
            </div>
        </div>
        <?php
        if (empty($orders)) {
            echo "<div class='container text-left fs-4 mb-5'>You have never made a purchase</div>";
        }
        ?>
        <?php foreach ($orders as $order) : ?>
            <div class="container my-5 order-detail bg-warning-subtle">
                <!-- Order header -->
                <div class="d-flex justify-content-between">
                    <h4>Order placed: <?php echo htmlspecialchars($order['order_date']); ?></h4>
                    <button>Track Order</button>
                </div>
                <hr>
                <!-- Book details  -->
                <?php if (isset($orderDetails[$order['order_id']])) : ?>
                    <?php foreach ($orderDetails[$order['order_id']] as $book) : ?>
                        <?php if (isset($booksById[$book['book_id']])) : ?>
                            <?php $bookDetails = $booksById[$book['book_id']]; ?>
                            <div class="col-md-12 bookcard">
                                <div class="col-12">
                                    <div class="row align-items-center border-bottom py-3 px-3">
                                        <!-- Book Image -->
                                        <div class="col-md-2">
                                            <img src="public/images/book_name/<?php echo htmlspecialchars($bookDetails['book_image']); ?>" alt="<?php echo htmlspecialchars($bookDetails['book_name']); ?>" class="img-fluid" style="max-width:100px; max-height: 150px; min-width: 90px;"><br>
                                        </div>
                                        <!-- Book Information -->
                                        <div class="col-md-3 pe-4">
                                            <h5 class="mb-2 mb-1"><?php echo htmlspecialchars($bookDetails['book_name']); ?></h5>
                                            <p class="mb-0">
                                                <span class="fw-semibold">Author:</span>
                                                <?php
                                                foreach ($authors as $author) {
                                                    if ($author['author_id'] == $bookDetails['author_id']) {
                                                        echo htmlspecialchars($author['author_name']);
                                                    }
                                                }
                                                ?>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-semibold">Category:</span>
                                                <?php
                                                foreach ($categories as $category) {
                                                    if ($category['cate_id'] == $bookDetails['cate_id']) {
                                                        echo htmlspecialchars($category['cate_name']);
                                                    }
                                                }
                                                ?>
                                            </p>
                                            <p class="mb-0 bg-warning-subtle w-75">
                                                <span class="fw-semibold">Price:</span>
                                                <span class="text-danger fw-bold">$<?php echo htmlspecialchars($bookDetails['book_price']); ?></span>
                                                <del style="font-size: 14px;">$<?php echo htmlspecialchars($bookDetails['book_old_price']); ?></del>
                                            </p>
                                        </div>
                                        <!-- Quantity Input -->
                                        <div class="col-md-1 ps-4 text-center ">
                                            <label for="quantity-<?php echo htmlspecialchars($bookDetails['book_id']); ?>" class="form-label">Quantity</label>
                                            <input type="number" readonly class="form-control w-100" min="1" value="<?php echo htmlspecialchars($book['quantity']); ?>">
                                        </div>
                                        <!-- Total Price of Book Item -->
                                        <div class="col-md-2 ps-5 text-center">
                                        <nav class="fs-6 opacity-50">Total Price</nav>
                                            <p class="mb-0">$<?php echo htmlspecialchars($bookDetails['book_price'] * $book['quantity']); ?></p>
                                        </div>
                                        <!-- Status -->
                                        <div class="col-md-2 ps-5">
                                           <nav class="fs-6 opacity-50">Status</nav>
                                            <p class="mb-0 fw-bold"><?php echo ucfirst(htmlspecialchars($order['status'])); ?></p>
                                        </div>
                                        <!-- Delivery Expected by -->
                                        <!-- Calculate the expected delivery date (7 days after the order date) -->
                                        <?php
                                            $orderDate = new DateTime($order['order_date']);
                                            $expectedDeliveryDate = $orderDate->modify('+7 days');
                                            $expectedDeliveryDateFormatted = $expectedDeliveryDate->format('Y-m-d');
                                        ?>
                                        <div class="col-md-2 ps-5 text-right">
                                            Delivery Expected by
                                            <p class="mb-0"><?php echo htmlspecialchars($expectedDeliveryDateFormatted); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <hr>
                <!-- Order footer -->
                <div class="container d-flex justify-content-between">
                    <button>Cancel Order</button>
                    <nav>Payment by
                        <?php
                        foreach ($payments as $payment) {
                            if ($payment['id'] == $order['payment_id']) {
                                echo htmlspecialchars($payment['payment_method']);
                            }
                        }
                        ?>
                    </nav>
                    <nav>Books Total: <?php echo htmlspecialchars($order['total_books']); ?></nav>
                    <nav class="fs-5 fw-bold">Total: $<?php echo htmlspecialchars($order['total_price']); ?></nav>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
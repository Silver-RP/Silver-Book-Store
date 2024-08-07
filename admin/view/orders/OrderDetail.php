<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-5 bg-warning-subtle border border-3 border-bottom">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>Order Detail</h2>
    </div>
    <div class=" mt-3  row">
        <!-- Order Information -->
        <div class="col-4">
            <h4>Order Information</h4>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($orderDetails['order_id']); ?></p>
            <p><strong>User Name:</strong> <?php echo htmlspecialchars($orderDetails['user_name']); ?></p>
            <p><strong>Total Price:</strong> $<?php echo htmlspecialchars($orderDetails['total_price']); ?></p>
            <p><strong>Total Books:</strong> <?php echo htmlspecialchars($orderDetails['total_books']); ?></p>
            <p><strong>Order Date:</strong> <?php echo htmlspecialchars($orderDetails['order_date']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($orderDetails['status']); ?></p>
        </div>

        <!-- Shipping Information -->
        <div class="col-4">
            <h4>Shipping Information</h4>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($orderDetails['full_name']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($orderDetails['address']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($orderDetails['city']); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($orderDetails['state']); ?></p>
            <p><strong>Zip Code:</strong> <?php echo htmlspecialchars($orderDetails['zip_code']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($orderDetails['phone_number']); ?></p>
        </div>

        <!-- Payment Information -->
        <div class="col-4">
            <h4>Payment Information</h4>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($orderDetails['payment_method']); ?></p>
            <?php if ($orderDetails['payment_method'] === 'credit_card') : ?>
                <p><strong>Card Number:</strong> <?php echo htmlspecialchars($orderDetails['card_number']); ?></p>
                <p><strong>Card Holder Name:</strong> <?php echo htmlspecialchars($orderDetails['card_holder_name']); ?></p>
                <p><strong>Expiration Date:</strong> <?php echo htmlspecialchars($orderDetails['expiration_date']); ?></p>
                <p><strong>CVV:</strong> <?php echo htmlspecialchars($orderDetails['cvv']); ?></p>
            <?php elseif ($orderDetails['payment_method'] === 'paypal') : ?>
                <p><strong>PayPal Email:</strong> <?php echo htmlspecialchars($orderDetails['paypal_email']); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Status Update -->
    <div class="mb-4">
        <h4 class="mb-3">Update Order Status</h4>
        <form action="?act=orders&action=update_status&id=<?php echo htmlspecialchars($orderDetails['order_id']); ?>" method="post">
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($orderDetails['order_id']); ?>">
            <div class="mb-3 w-25">
                <select id="status" name="status" class="form-select">
                    <option value="unpaid" <?php echo ($orderDetails['status'] == 'unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                    <option value="paid" <?php echo ($orderDetails['status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                    <option value="pending" <?php echo ($orderDetails['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="confirmed" <?php echo ($orderDetails['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="in delivery" <?php echo ($orderDetails['status'] == 'in delivery') ? 'selected' : ''; ?>>In Delivery</option>
                    <option value="received" <?php echo ($orderDetails['status'] == 'received') ? 'selected' : ''; ?>>Received</option>
                    <option value="cancelled" <?php echo ($orderDetails['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
            <a href="?act=orders&action=index" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <!-- Order Items -->
    <div class="row">
        <h3 class="bg-warning">Order Books</h3>
        <?php if (!empty($orderItems)) : ?>
            <?php foreach ($orderItems as $item) : ?>
                <div class="col-md-12 bookcard">
                    <div class="col-12">
                        <div class="row align-items-center border-bottom py-3 px-3">
                            <!-- Book Image -->
                            <div class="col-md-2">
                                <img src="/SilverBook/public/images/book_name/<?php echo htmlspecialchars($item['book_image']); ?>" alt="<?php echo htmlspecialchars($item['book_name']); ?>" class="img-fluid" style="max-width:100px; max-height: 150px; min-width: 90px;"><br>
                            </div>
                            <!-- Book Information -->
                            <div class="col-md-3 pe-4">
                                <h5 class="mb-2 mb-1"><?php echo htmlspecialchars($item['book_name']); ?></h5>
                                <p class="mb-0">
                                    <span class="fw-semibold">Author:</span>
                                    <?php echo htmlspecialchars($item['author_name']); ?>
                                </p>
                                <p class="mb-0">
                                    <span class="fw-semibold">Category:</span>
                                    <?php echo htmlspecialchars($item['cate_name']) ?>
                                </p>
                                <p class="mb-0 bg-warning-subtle w-75">
                                    <span class="fw-semibold">Price:</span>
                                    <span class="text-danger fw-bold">$<?php echo htmlspecialchars($item['book_price']); ?></span>
                                    <del style="font-size: 14px;">$<?php echo htmlspecialchars($item['book_old_price']); ?></del>
                                </p>
                            </div>
                            <!-- Quantity Input -->
                            <div class="col-md-1 ps-4 text-center">
                                <label for="quantity-<?php echo htmlspecialchars($item['book_id']); ?>" class="form-label">Quantity</label>
                                <input type="number" readonly class="form-control w-100" min="1" value="<?php echo htmlspecialchars($item['quantity']); ?>">
                            </div>
                            <!-- Total Price of Book Item -->
                            <div class="col-md-2 ps-5 text-center">
                                <nav class="fs-6 opacity-50">Total Price</nav>
                                <p class="mb-0">$<?php echo htmlspecialchars($item['book_price'] * $item['quantity']); ?></p>
                            </div>
                            <!-- Status -->
                            <div class="col-md-2 ps-5">
                                <nav class="fs-6 opacity-50">Status</nav>
                                <p class="mb-0 fw-bold"><?php echo ucfirst(htmlspecialchars($orderDetails['status'])); ?></p>
                            </div>
                            <!-- Delivery Expected by -->
                            <?php
                                $orderDate = new DateTime($orderDetails['order_date']);
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
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-md-12">
                <p>No items found.</p>
            </div>
        <?php endif; ?>
    </div>
    
</main>

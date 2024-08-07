<section>
    <div class="container my-5">

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center mb-5 fw-bold bg-warning-subtle py-2">
                        <i class="fas fa-check-circle text-success"></i> Order Successfully
                    </h2>
                </div>
            </div>
        </div>
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-thumbs-up"></i> Well done!</h4>
                            <p class="mt-4">Your order has been successfully placed. Your order number is <strong><?php echo $orderNumber; ?></strong>. You will receive an email confirmation shortly.</p>
                            <hr>
                            <p class="mb-0">Thank you for shopping with us.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="?route=order&subroute=viewOrder" class="btn border border-dark-subtle me-2"><i class="fas fa-eye"></i> View Order</a>
                        <a href="?route=home" class="btn btn-warning"><i class="fas fa-shopping-cart"></i> Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


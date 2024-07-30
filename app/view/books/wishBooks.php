<section class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-5 fw-bold bg-warning-subtle py-2">Wish Books</h2>
        </div>
    </div>
    <?php 
        if(isset($_SESSION['user'])){
            if(empty($wishList)){
                echo '<div class="row">
                        <div class="col-md-12 ">
                            <p class="">No books in Wish List</p>
                        </div>
                    </div>';
            } else {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="text-center align-middle fs-5">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Book Image</th>
                            <th scope="col">Book Name</th>
                            <th scope="col">Author</th>
                            <th scope="col">Sale Price</th>
                            <th scope="col">Origin Price</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="text-center align-middle fs-6">
                        <?php foreach($wishList as $wishBook): ?>
                            <tr id="book-<?php echo htmlspecialchars($wishBook['book_id']); ?>">
                                <td>
                                    <button class="btn btn-danger remove-wish-btn" data-book-id="<?php echo htmlspecialchars($wishBook['book_id']); ?>">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                                <td>
                                    <img src="public/images/book_name/<?php echo htmlspecialchars($wishBook['book_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($wishBook['book_image']); ?>"
                                         width="100px" height="150px">
                                </td>
                                <td><?php echo htmlspecialchars($wishBook['book_name']); ?></td>
                                <td><?php echo htmlspecialchars($wishBook['author_name']); ?></td>
                                <td><?php echo htmlspecialchars($wishBook['book_price']); ?></td>
                                <td><del><?php echo htmlspecialchars($wishBook['book_old_price']); ?></del></td>
                                <td>
                                    <button class="btn btn-warning btn-add"
                                                    data-book-id="<?php echo htmlspecialchars($wishBook['book_id']); ?>"
                                                    onclick="addToCart(this)">
                                                Add to Cart
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php 
            }
        } else {
            echo '<div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Please login to view Wish list</h3>
                    </div>
                </div>';
        }

        if($wishList = []){
            echo '<div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Wish list is Empty.</h3>
                    </div>
                </div>';
        }
    ?>
</section>

<section class="container m-5">
    <div class="container">
        <h1 class="mb-5">Search Results</h1>
        <?php if (!empty($results)) : ?>
            <div class="row ms-5 row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                <?php foreach ($results as $book) : ?>
                    <div class="col my-3" style="max-width:20%">
                        <div class="container book-item book-card">
                            <?php
                            $isWished = isset($wishDict[$book['book_id']]) ? $wishDict[$book['book_id']]['is_wished'] : 0;
                            ?>
                            <button class="favorite-btn <?php echo $isWished ? 'added' : ''; ?>" data-book-id="<?php echo htmlspecialchars($book['book_id']); ?>" onclick="toggleWishlist(this)">
                                <i class="fa <?php echo $isWished ? 'fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                            </button>
                            <a href="?route=books&subroute=detail&id=<?php echo htmlspecialchars($book['book_id']); ?>">
                                <div class="image-container px-3">
                                    <img src="public/images/book_name/<?php echo htmlspecialchars($book['book_image']); ?>" alt="<?php echo htmlspecialchars($book['book_name']) ?>">
                                </div>
                            </a>
                            <div class="content">
                                <h6 class="fw-bold book-title"><?php echo htmlspecialchars($book['book_name']) ?></h6>
                                <h6 class="mb-1 author-name">
                                    <?php echo htmlspecialchars($book['author_name']); ?>
                                </h6>
                                <div class="my-2 justify-content-center price-container">
                                    <div class="text-danger fw-bolder">Sale: $<?php echo htmlspecialchars($book['book_price']) ?></div>
                                    <del style="margin-left: 10px;">$<?php echo htmlspecialchars($book['book_old_price']) ?></del>
                                </div>
                                <a class="btn btn-de btn-buy-now btn-buy" href="?route=order&subroute=buynow&id=<?php echo htmlspecialchars($book['book_id']) ?>">
                                    Buy Now
                                </a>
                                <!-- <button class="btn btn-primary btn-buy">Buy Now</button> -->
                                <button class="btn btn-secondary btn-add" data-book-id="<?php echo htmlspecialchars($book['book_id']); ?>" onclick="addToCart(this)">
                                    Add to Cart
                                </button>
                                <p class="mt-2 mb-1">Rating: ★★★★☆</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No results found for "<?php echo htmlspecialchars($_GET['keyword']); ?>"</p>
        <?php endif; ?>
    </div>
</section>
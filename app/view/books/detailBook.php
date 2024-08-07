<section class="m-5">
    <div class="container">

        <!-- Book Detail -->
        <div class="row">
            <!-- Book Image -->
            <div class="col-sm-4 ps-5">
                <img src="public/images/book_name/<?php echo htmlspecialchars($book['book_image']); ?>" alt="<?php echo htmlspecialchars($book['book_name']); ?>" class="book-image">
            </div>
            <!-- Book Information -->
            <div class="col-sm-8">
                <div class="book-info">
                    <input type="hidden" value="<?php echo htmlspecialchars($book['book_id']); ?>">
                    <h1 class="book-title-detail "><?php echo htmlspecialchars($book['book_name']); ?></h1>
                    <div class="rating">
                        Rating: ★★★★☆
                    </div>
                    <p class="author-name">
                        <span class="fw-semibold">Author</span>: <?php echo htmlspecialchars($bookAuthor['author_name']); ?>
                    </p>
                    <hr>
                    <p class="book-types"><span class="fw-semibold">Category</span>: <?php echo htmlspecialchars($bookCate['cate_name']); ?></p>
                    <p class="book-types"><span class="fw-semibold">Types</span>:
                        <button type="button" class="btn" disabled data-bs-toggle="button" style=" --bs-btn-font-size: .75rem;">
                            Hard Cover
                        </button>
                        <button type="button" class="btn" disabled data-bs-toggle="button" style=" --bs-btn-font-size: .75rem;">
                            Audio Book
                        </button>
                        <button type="button" class="btn" disabled data-bs-toggle="button" style=" --bs-btn-font-size: .75rem;">
                            EBook
                        </button>
                        <button type="button" class="btn" disabled data-bs-toggle="button" style=" --bs-btn-font-size: .75rem;">
                            Audio CD
                        </button>
                        <button type="button" class="btn" disabled data-bs-toggle="button" style=" --bs-btn-font-size: .75rem;">
                            Paper Book
                        </button>
                    </p>
                    <p class="book-price">
                        $<?php echo htmlspecialchars($book['book_price']); ?>
                        <del class="text-secondary fs-6">$<?php echo htmlspecialchars($book['book_old_price']); ?></del>
                    </p>
                    <div class="book-quantity">
                        <span class="fw-semibold">Quantity</span>:
                        <input type="number" id="quantityInput" value="1" min="1">
                    </div>
                    <div class="buttons">
                        <button class="btn btn-de btn-secondary " data-book-id=<?php echo htmlspecialchars($book['book_id']); ?> onclick="addToCart(this)">
                            Add to Cart
                        </button>
                        <a class="btn btn-de btn-buy-now" href="?route=order&subroute=buynow&id=<?php echo htmlspecialchars($book['book_id']) ?>">
                            Buy Now
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Summary -->
        <div class="row row2 my-5 px-5">
            <h4>Summary</h4>
            <div class="container border border-warning">
                <div class="book-summary-wrapper">
                    <p class="book-summary">
                        <?php echo htmlspecialchars($book['book_description']); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- You May Also Like -->
        <div>
            <div class="you-may-also-like">
                <span class="text">YOU MAY ALSO LIKE</span>
            </div>
            <div class="container text-center">
                <div class="row">
                    <?php
                    $i = 0;
                    foreach ($booksSameCategory as $bookc) :
                    ?>
                        <?php if ($bookc['book_id'] === $book['book_id']) continue; ?>
                        <div class="col my-3" style="max-width:300px;">
                            <div class="container book-item book-card">
                                <?php
                                $isWished = isset($wishDict[$book['book_id']]) ? $wishDict[$book['book_id']]['is_wished'] : 0;
                                ?>
                                <button class="favorite-btn <?php echo $isWished ? 'added' : ''; ?>" data-book-id="<?php echo htmlspecialchars($book['book_id']); ?>" onclick="toggleWishlist(this)">
                                    <i class="fa <?php echo $isWished ? 'fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                                </button>
                                <a href="?route=books&subroute=detail&id=<?php echo htmlspecialchars($bookc['book_id']); ?>">
                                    <div class="image-container px-3">
                                        <img src="public/images/book_name/<?php echo htmlspecialchars($bookc['book_image']); ?>" alt="<?php echo htmlspecialchars($bookc['book_name']); ?>">
                                    </div>
                                </a>
                                <div class="content">
                                    <h6 class="fw-bold book-title"><?php echo htmlspecialchars($bookc['book_name']); ?></h6>
                                    <h6 class="mb-1 author-name">
                                        <?php
                                        foreach ($bookAuthors as $author) {
                                            if ($author['author_id'] == $bookc['author_id']) {
                                                echo htmlspecialchars($author['author_name']);
                                                break;
                                            }
                                        }
                                        ?>
                                    </h6>
                                    <div class="my-2 justify-content-center price-container">
                                        <div class="text-danger fw-bolder">Sale: $<?php echo htmlspecialchars($bookc['book_price']); ?></div>
                                        <del style="margin-left: 10px;">$<?php echo htmlspecialchars($bookc['book_old_price']); ?></del>
                                    </div>
                                    <button class="btn btn-primary btn-buy">Buy Now</button>
                                    <button class="btn btn-secondary btn-add" data-book-id=<?php echo htmlspecialchars($bookc['book_id']); ?> onclick="addToCart(this)">
                                        Add to Cart
                                    </button>
                                    <p class="mt-2 mb-1">Rating: ★★★★☆</p>
                                </div>
                            </div>
                        </div>
                        <?php $i++;
                        if ($i > 5) break; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <hr class="border border-2 border-dark-subtle">
        </div>
        <!-- Product details, about the Author-->
        <div class="container mt-5 d-lex justify-content-center">
            <div class="container">
                <h4>Product Details</h4>
                <div class="container border border-warning">
                    <div class="book-summary-wrapper">
                        <p class="book-summary">
                            <span class="fw-semibold">Publisher</span>: <?php echo htmlspecialchars($bookPublisher['publisher_name']); ?>
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">Language</span>: English
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">Reading Age</span>: Teen, Adult
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">Publication date</span>: 01/19/2024
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">Pages</span>: 345
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">ISBN-10</span>: 9090213487
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">ISBN-13</span>: 90908087265311
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">Product Dimensions</span>: 6.44 x 0.61 x 6.63 inches
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">Shipping Weight</span>: 9.2 ounces
                        </p>
                        <p class="book-summary">
                            <span class="fw-semibold">Customer Reviews</span>: 4.5 out of 5 stars
                        </p>
                    </div>
                </div>
            </div>
            <!-- About the Author -->
            <div class="container mt-5">
                <h4>About the Author</h4>
                <div class="container border border-warning p-3 ">
                    <div class="card mb-3 ms-3" style="max-width: 1040px; border:none !important;">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img src="https://via.placeholder.com/200" class="img-fluid rounded-center" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $bookAuthor['author_name'] ?></h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="m-5">
        </div>
        <!-- Customer reviews, Customers say -->
        <div class="container review-container">
            <h2>Customer Reviews</h2>
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <!-- Review Form -->
                        <div class="container">
                            <form action="" id="commentForm">
                                <input type="hidden" name="book_id" id="book_id" value="<?php echo htmlspecialchars($book['book_id']) ?>">
                                <textarea id="comment" name="comment" required></textarea>
                                <div class="star-rating">
                                    <input type="radio" id="5-stars" name="rating" value="1" />
                                    <label for="5-stars" class="fa-regular fa-star"></label>
                                    <input type="radio" id="4-stars" name="rating" value="2" />
                                    <label for="4-stars" class="fa-regular fa-star"></label>
                                    <input type="radio" id="3-stars" name="rating" value="3" />
                                    <label for="3-stars" class="fa-regular fa-star"></label>
                                    <input type="radio" id="2-stars" name="rating" value="4" />
                                    <label for="2-stars" class="fa-regular fa-star"></label>
                                    <input type="radio" id="1-stars" name="rating" value="5" />
                                    <label for="1-stars" class="fa-regular fa-star"></label>
                                </div>
                                <button type="submit" class="btn btn-warning">Submit Comment and Rating</button>
                            </form>
                            <div id="responseDiv"></div>
                        </div>
                    </div>
                    <!-- Render Reviews -->
                    <div class="col mx-5" id="commentsContainer">
                    </div>
                </div>
            </div>
        </div>

        <!-- PreFooter -->
        <div class="prefooter">
            <h3>You go to the end</h3>
            <p>Don't miss out on our amazing products. Buy now and enjoy the best quality and service!</p>
            <a href="#" class="btn btn-primary">Buy Now</a>
        </div>

    </div>
</section>
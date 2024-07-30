<!-- Recommend and render books -->
<?php include('app/view/layout/MainNav.php'); ?>
<!-- New Release -->
<div class="col-md-8 col-lg-9 right-left right-book-bar">
    <!-- Books for you -->
    <div class="container mb-5">
        <div>
            <!-- title -->
            <div class="cate-title mt-3">
                <h4>
                    <span class="icons-s p-3">
                        <i class="fa-solid fa-ellipsis fa-sm"></i>
                        <i class="fa-solid fa-ellipsis fa-sm"></i>
                        <i class="fa-solid fa-diamond fa-sm fs-6"></i>
                        <i class="fa-solid fa-seedling fa-sm"></i>
                    </span>
                    <span class="fw-semibold"> BOOK FOR YOU </span>
                    <span class="icons-s p-3">
                        <i class="fa-solid fa-seedling fa-sm"></i>
                        <i class="fa-solid fa-diamond fa-sm fs-6"></i>
                        <i class="fa-solid fa-ellipsis fa-sm"></i>
                        <i class="fa-solid fa-ellipsis fa-sm"></i>
                    </span>
                </h4>
            </div>
            <!-- Books -->
            <div class="container text-center pt-3 mt-4">
                <div class="row ms-5 row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                    <?php foreach ($booksForPage as $book) : ?>
                        <div class="col my-3">
                            <div class="container book-item book-card">
                                <?php
                                $isWished = isset($wishDict[$book['book_id']]) ? $wishDict[$book['book_id']]['is_wished'] : 0;
                                ?>
                                <button class="favorite-btn <?php echo $isWished ? 'added' : ''; ?>" 
                                        data-book-id="<?php echo htmlspecialchars($book['book_id']); ?>" 
                                        onclick="toggleWishlist(this)">
                                    <i class="fa <?php echo $isWished ? 'fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                                </button>
                                <a href="?route=books&subroute=detail&id=<?php echo htmlspecialchars($book['book_id']) ?>">
                                    <div class="image-container px-3">
                                        <img src="public/images/book_name/<?php echo htmlspecialchars($book['book_image']) ?>" 
                                                alt="<?php echo htmlspecialchars($book['book_name']) ?>">
                                    </div>
                                </a>
                                <div class="content">
                                    <h6 class="fw-bold book-title"><?php echo htmlspecialchars($book['book_name']) ?></h6>
                                    <h6 class="mb-1 author-name">
                                        <?php
                                        foreach ($bookAuthor as $author) {
                                            if ($author['author_id'] == $book['author_id']) {
                                                echo htmlspecialchars($author['author_name']);
                                            }
                                        }
                                        ?>
                                    </h6>
                                    <div class="my-2 justify-content-center price-container">
                                        <div class="text-danger fw-bolder">Sale: $<?php echo htmlspecialchars($book['book_price']) ?></div>
                                        <del style="margin-left: 10px;">$<?php echo htmlspecialchars($book['book_old_price']) ?></del>
                                    </div>
                                    <button class="btn btn-primary btn-buy">Buy Now</button>
                                    <button class="btn btn-secondary btn-add"
                                            data-book-id="<?php echo htmlspecialchars($book['book_id']); ?>"
                                            onclick="addToCart(this)">
                                        Add to Cart
                                    </button>
                                    <p class="mt-2 mb-1">Rating: ★★★★☆</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
<!-- 4. Banner 1.1 -->
<section class="container-fluid mb-3" style="max-height: 250px !important;">
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="public/images/banner/book-for-banner.jpg" class="d-block w-100" alt="..." style="max-height: 250px;">
            </div>
            <div class="carousel-item">
                <img src="public/images/banner/b1.jpg" class="d-block w-100" alt="..." style="max-height: 250px;">
            </div>
            <div class="carousel-item">
                <img src="public/images/banner/book-for-banner3.avif" class="d-block w-100" alt="..." style="max-height: 250px;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<!--5. ALL BOOKS LIST -->
<section class="mt-5" id="all-books-list">
    <div class="container">
        <div>
            <div class="container mb-5">
                <div>
                    <!-- title -->
                    <div class="cate-title mt-3">
                        <h4>
                            <span class="icons-s p-3">
                                <i class="fa-solid fa-ellipsis fa-sm"></i>
                                <i class="fa-solid fa-ellipsis fa-sm"></i>
                                <i class="fa-solid fa-diamond fa-sm fs-6"></i>
                                <i class="fa-solid fa-seedling fa-sm"></i>
                            </span>
                            <span class="fw-semibold"> ALL BOOKS </span>
                            <span class="icons-s p-3">
                                <i class="fa-solid fa-seedling fa-sm"></i>
                                <i class="fa-solid fa-diamond fa-sm fs-6"></i>
                                <i class="fa-solid fa-ellipsis fa-sm"></i>
                                <i class="fa-solid fa-ellipsis fa-sm"></i>
                            </span>
                        </h4>
                    </div>
                    <div class="d-flex justify-content-center opacity-25">( Page <?php echo $page; ?> of <?php echo $totalPages; ?>) </div>
                    <div class="container text-center pt-3 mt-4">
                        <div class="row ms-5 row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                            <?php foreach ($books as $book) : ?>
                                <div class="col my-3" style="max-width:20%">
                                    <div class="container book-item book-card">
                                        <?php
                                            $isWished = isset($wishDict[$book['book_id']]) ? $wishDict[$book['book_id']]['is_wished'] : 0;
                                        ?>
                                        <button class="favorite-btn <?php echo $isWished ? 'added' : ''; ?>" 
                                                data-book-id="<?php echo htmlspecialchars($book['book_id']); ?>" 
                                                onclick="toggleWishlist(this)">
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
                                                <?php
                                                foreach ($bookAuthor as $author) {
                                                    if ($author['author_id'] == $book['author_id']) {
                                                        echo htmlspecialchars($author['author_name']);
                                                    }
                                                }
                                                ?>
                                            </h6>
                                            <div class="my-2 justify-content-center price-container">
                                                <div class="text-danger fw-bolder">Sale: $<?php echo htmlspecialchars($book['book_price']) ?></div>
                                                <del style="margin-left: 10px;">$<?php echo htmlspecialchars($book['book_old_price']) ?></del>
                                            </div>
                                            <button class="btn btn-primary btn-buy">Buy Now</button>
                                            <button class="btn btn-secondary btn-add"
                                                    data-book-id="<?php echo htmlspecialchars($book['book_id']); ?>"
                                                    onclick="addToCart(this)">
                                                Add to Cart
                                            </button>
                                            <p class="mt-2 mb-1">Rating: ★★★★☆</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- <div class="text-center mt-4">
                        <a href="#" class="viewmore"> VIEW MORE </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <nav aria-label="Page navigation example" class="d-flex justify-content-center ">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?route=books&subroute=show&subroute&page=<?php echo $page - 1; ?>#all-books-list" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?route=books&subroute=show&subroute&page=<?php echo $i; ?>#all-books-list"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?route=books&subroute=show&subroute&page=<?php echo $page + 1; ?>#all-books-list" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash === "#all-books-list") {
            document.getElementById('all-books-list').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
    // Handle page navigation with smooth scrolling
    document.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const href = this.getAttribute('href');
            window.location.href = href;

            document.getElementById('all-books-list').scrollIntoView({
                behavior: 'smooth'
            });
            setTimeout(() => {
                document.getElementById('all-books-list').scrollIntoView({
                    behavior: 'smooth'
                });
            }, 2000);
        });
    });
</script>
<!-- Banner 2 -->
<section class="container-fluid mb-3">
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="public/images/banner/banner.jpg" class="d-block w-100" alt="..." style="max-height: 350px;">
            </div>
            <div class="carousel-item">
                <img src="public/images/banner/b1.jpg" class="d-block w-100" alt="..." style="max-height: 350px;">
            </div>
            <div class="carousel-item">
                <img src="public/images/banner/b2.jpg" class="d-block w-100" alt="..." style="max-height: 350px;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
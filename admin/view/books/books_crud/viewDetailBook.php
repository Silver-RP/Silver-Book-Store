

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>Book Detail </h2>
        <div>
            <a href="?act=books&action=edit&page=1&id=<?php echo htmlspecialchars($book['book_id']); ?>" class="btn btn-warning opacity-75 btn-hover">Edit</a>
            <a href="?act=books&action=delete&page=1&id=<?php echo htmlspecialchars($book['book_id']); ?>" class="btn btn-danger opacity-75 btn-hover" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
        </div>
    </div>
    <div class="container pt-3">
        <div class="row">
            <div class="col-md-3">
                <img src="/SilverBook/public/images/book_name/<?php echo htmlspecialchars($book['book_image']); ?>" alt="book_image" class="img-fluid" width="300px" height="300px">
            </div>
            <div class="col-md-9">
                <h4>Book Name: <?php echo htmlspecialchars($book['book_name']); ?></h4>   
                <h4>Book Title: <?php echo htmlspecialchars($book['book_title']); ?></h4>
                <p class="fw-semibold">Year of Publication: <?php echo htmlspecialchars($book['book_year_of_publication']); ?></p>
                <p class="fw-semibold">Price: <?php echo htmlspecialchars($book['book_price']); ?></p>
                <p class="fw-semibold">Old Price: <?php echo htmlspecialchars($book['book_old_price']); ?></p>
                <p class="fw-semibold">Date of Storage: <?php echo htmlspecialchars($book['book_date_of_storage']); ?></p>
                <p class="fw-semibold">Stock Quantity: <?php echo htmlspecialchars($book['book_stock_quantity']); ?></p>
                <p class="fw-semibold">Category: <?php echo htmlspecialchars($cate['cate_name']); ?></p>
                <p class="fw-semibold">Author: <?php echo htmlspecialchars($author['author_name']); ?></p>
                <p class="fw-semibold">Publisher: <?php echo htmlspecialchars($publisher['publisher_name']); ?></p>
            </div>
        </div>
        <div>
            <p class="fw-semibold pt-3" >Book Description:</p>
            <p class="ps-3">  <?php echo htmlspecialchars($book['book_description']); ?></p>
        </div>
    </div>
</main>

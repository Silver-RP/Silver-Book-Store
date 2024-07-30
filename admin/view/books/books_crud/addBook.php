



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div s="d-flex justify-content-between py-3 border-bottom">
        <h2>Add Book</h2>
    </div>
    <div class="container pt-3">
        <form action="?act=books&action=store" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 pe-5">
                    <div class="mb-3 ">
                        <label for="book_name" class="form-label">Book Name</label>
                        <input type="text" class="form-control" id="book_name" name="book_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="book_title" class="form-label">Book Title</label>
                        <input type="text" class="form-control" id="book_title" name="book_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="book_image" class="form-label">Book Image</label>
                        <input type="file" class="form-control" id="book_image" name="book_image" required>
                    </div>
                    <div class="mb-3">
                        <label for="book_description" class="form-label">Book Description</label>
                        <textarea class="form-control" id="book_description" name="book_description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="book_year_of_publication" class="form-label">Year of Publication</label>
                        <input type="number" class="form-control" id="book_year_of_publication" name="book_year_of_publication" min="1900" max="2024" required>
                    </div>
                </div>
                <div class="col-md-6 pe-5">
                    <div class="mb-3">
                        <label for="book_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="book_price" name="book_price" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="book_old_price" class="form-label">Old Price</label>
                        <input type="number" class="form-control" id="book_old_price" name="book_old_price" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="book_date_of_storage" class="form-label">Date of Storage</label>
                        <input type="date" class="form-control" id="book_date_of_storage" name="book_date_of_storage" required>
                    </div>
                    <div class="mb-3">
                        <label for="book_stock_quantity" class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control" id="book_stock_quantity" name="book_stock_quantity" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="cate_id" class="form-label">Category</label>
                        <select class="form-select" id="cate_id" name="cate_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($cates as $cate) : ?>
                                <option value="<?php echo $cate['cate_id']; ?>"><?php echo $cate['cate_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="author_id" class="form-label">Author</label>
                        <select class="form-select" id="author_id" name="author_id" required>
                            <option value="">Select Author</option>
                            <?php foreach ($authors as $author) : ?>
                                <option value="<?php echo $author['author_id']; ?>"><?php echo $author['author_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="publisher_id" class="form-label">Publisher</label>
                        <select class="form-select" id="publisher_id" name="publisher_id" required>
                            <option value="">Select Publisher</option>
                            <?php foreach ($publishers as $publisher) : ?>
                                <option value="<?php echo $publisher['publisher_id']; ?>"><?php echo $publisher['publisher_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Add Book</button>
            <a href="?act=books" class="btn btn-secondary mb-2">Cancel</a>
        </form>
    </div>
</main>






<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>Edit Book</h2>
    </div>
    <div class="container">
        <form action="index.php?act=books&page=<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>&action=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['book_id']); ?>">
            
            <div class="row">
                <!-- First Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="book_name" class="form-label">Book Name</label>
                        <input type="text" class="form-control" id="book_name" name="book_name" value="<?php echo htmlspecialchars($book['book_name']); ?>">
                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($book['book_image']); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="book_title" class="form-label">Book Title</label>
                        <input type="text" class="form-control" id="book_title" name="book_title" value="<?php echo htmlspecialchars($book['book_title']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="book_year_of_publication" class="form-label">Year of Publication</label>
                        <input type="number" class="form-control" id="book_year_of_publication" name="book_year_of_publication" min="1900" max="2024" value="<?php echo htmlspecialchars($book['book_year_of_publication']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="book_image" class="form-label">Book Image</label>
                        <input type="file" class="form-control" id="book_image" name="book_image">
                        <img src="/SilverBook/public/images/book_name/<?php echo htmlspecialchars($book['book_image']); ?>" alt="<?php echo htmlspecialchars($book['book_image']); ?>" style="max-width: 80px; max-height: 100px; margin-top:3px">
                    </div>
                    
                    <div class="mb-3">
                        <label for="book_description" class="form-label">Book Description</label>
                        <textarea class="form-control" id="book_description" name="book_description" rows="5"><?php echo htmlspecialchars($book['book_description']); ?></textarea>
                    </div>
                </div>
                
                <!-- Second Column -->
                <div class="col-md-6">
                    
                    
                    <div class="mb-3">
                        <label for="book_price" class="form-label">Book Price</label>
                        <input type="number" class="form-control" id="book_price" name="book_price" value="<?php echo htmlspecialchars($book['book_price']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="book_old_price" class="form-label">Book Old Price</label>
                        <input type="number" class="form-control" id="book_old_price" name="book_old_price" value="<?php echo htmlspecialchars($book['book_old_price']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="book_date_of_storage" class="form-label">Date of Storage</label>
                        <input type="date" class="form-control" id="book_date_of_storage" name="book_date_of_storage" value="<?php echo htmlspecialchars($book['book_date_of_storage']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="book_stock_quantity" class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control" id="book_stock_quantity" name="book_stock_quantity" value="<?php echo htmlspecialchars($book['book_stock_quantity']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="cate_id" class="form-label">Category</label>
                        <select class="form-select" id="cate_id" name="cate_id">
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category['cate_id']; ?>" <?php echo ($category['cate_id'] == $book['cate_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['cate_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="author_id" class="form-label">Author</label>
                        <select class="form-select" id="author_id" name="author_id">
                            <?php foreach ($authors as $author) : ?>
                                <option value="<?php echo $author['author_id']; ?>" <?php echo ($author['author_id'] == $book['author_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($author['author_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="publisher_id" class="form-label">Publisher</label>
                        <select class="form-select" id="publisher_id" name="publisher_id">
                            <?php foreach ($publishers as $publisher) : ?>
                                <option value="<?php echo $publisher['publisher_id']; ?>" <?php echo ($publisher['publisher_id'] == $book['publisher_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($publisher['publisher_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary mb-3">Update</button>
            <a href="?act=books" class="btn btn-secondary mb-3">Cancel</a>
        </form>
    </div>
</main>


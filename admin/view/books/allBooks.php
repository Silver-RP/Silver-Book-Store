<!-- allBooks.php -->

<!-- <?php require_once("/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/layout/header.php"); ?> -->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>All Books</h2>
        <a href="?act=books&action=add" class="btn btn-primary btn-warning fs-18 fw-semibold pt-2">Add Book</a>
    </div>
    <!-- Pagination Links -->
    <nav aria-label="Page navigation example" class="d-flex justify-content-end pt-2">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=books&action=index&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=books&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=books&action=index&page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Display Books -->
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Book Name</th>
                    <th>Book Image</th>
                    <th>Book Price</th>
                    <th>Book Date of Storage</th>
                    <th>Book Stock Quantity</th>
                    <th>Category</th>
                    <th class="ps-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($books)) : ?>
                    <?php foreach ($books as $index => $book) : ?>
                            <td class="align-middle"><?php echo $index + 1; ?></td>
                            <td class="align-middle">
                                <a href="?act=books&action=detail&id=<?php echo htmlspecialchars($book['book_id']); ?>" class="text-dark nav-link a-tabel-hover">
                                    <?php echo htmlspecialchars($book['book_name']); ?>
                                </a>
                            </td>
                            <td class="align-middle">
                                <img src="/SilverBook/public/images/book_name/<?php echo htmlspecialchars($book['book_image']); ?>" alt="<?php echo htmlspecialchars($book['book_image']); ?>" style="max-width: 80px; max-height: 100px;">
                            </td>
                            <td class="align-middle"><?php echo htmlspecialchars($book['book_price']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($book['book_date_of_storage']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($book['book_stock_quantity']); ?></td>
                            <td class="align-middle">
                                <?php
                                $foundCate = false;
                                foreach ($bookCate as $cate) {
                                    if ($book['cate_id'] == $cate['cate_id']) {
                                        echo htmlspecialchars($cate['cate_name']);
                                        $foundCate = true;
                                        break;
                                    }
                                }
                                if (!$foundCate) {
                                    echo "Unknown";
                                }
                                ?>
                            </td>
                            <td class="align-middle">
                            <div class="btn-group">
                                <a href="?act=books&action=edit&page=<?php echo $page; ?>&id=<?php echo htmlspecialchars($book['book_id']); ?>" class="btn btn-primary btn-sm me-1">Edit</a>
                                <a href="?act=books&action=delete&page=<?php echo $page; ?>&id=<?php echo htmlspecialchars($book['book_id']); ?>" class="btn btn-danger btn-sm me-2">Delete</a>
                            </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No books found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <nav aria-label="Page navigation example" class="d-flex justify-content-center pt-2">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=books&action=index&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=books&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=books&action=index&page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</main>

<?php require_once("/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/layout/footer.php"); ?>
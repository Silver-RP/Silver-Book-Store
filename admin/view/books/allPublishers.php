<!-- allBooks.php -->

<!-- <?php require_once("/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/layout/header.php"); ?> -->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>All Publishers</h2>
        <a href="?act=publishers&action=add" class="btn btn-primary btn-warning fs-18 fw-semibold pt-2">Add Publishers</a>
    </div>
    <nav aria-label="Page navigation example" class="d-flex justify-content-end pt-2">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=publishers&action=index&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=publishers&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=publishers&action=index&page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Display Books -->
    <div class="table-responsive">
        <table class="table table-striped table-sm custom-line-height ">
            <thead >
                <tr>
                    <th>No.</th>
                    <th>Publisher Name</th>
                    <th>Publisher Address</th>
                    <th>Publisher Phone</th>
                    <th>Publisher Email</th>
                    <th>Publisher Ulr</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody >
                <?php if (!empty($publishers)) : ?>
                    <?php foreach ($publishers as $index => $publisher) : ?>
                        <tr>
                            <td class="align-middle"><?php echo $index + 1; ?></td>
                            <td class="align-middle">
                                <a href="#" class="text-dark nav-link a-tabel-hover">
                                    <?php echo htmlspecialchars($publisher['publisher_name']); ?>
                                </a>
                            </td>
                            <td class="align-middle"><?php echo htmlspecialchars($publisher['publisher_address']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($publisher['publisher_phone']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($publisher['publisher_email']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($publisher['publisher_url']); ?></td>
                            <td class="align-middle">
                                <div class="btn-group">
                                    <a href="?act=publishers&action=edit&id=<?php echo htmlspecialchars($publisher['publisher_id']); ?>" class="btn btn-primary btn-sm me-1">Edit</a>
                                    <a href="?act=publishers&action=delete&id=<?php echo htmlspecialchars($publisher['publisher_id']); ?>" class="btn btn-danger btn-sm me-2">Delete</a>
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
                    <a class="page-link" href="?act=publishers&action=index&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=publishers&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=publishers&action=index&page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</main>

<?php require_once("/Applications/XAMPP/xamppfiles/htdocs/Lap_trinh_PHP/SilverBook/admin/view/layout/footer.php"); ?>

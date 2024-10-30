
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>All Users</h2>
        <a href="?act=user&action=add" class="btn btn-primary btn-warning fs-18 fw-semibold pt-2">Add user</a>
    </div>
    <!-- Pagination Links -->
    <nav aria-label="Page navigation example" class="d-flex justify-content-end pt-2">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=user&action=index&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=user&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=user&action=index&page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Display Users -->
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>User Name</th>
                    <th>User Birthday</th>
                    <th>User Gender</th>
                    <th>User Email/Phone</th>
                    <th>User Role</th>
                    <th class="ps-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $index => $user) : ?>
                            <td class="align-middle"><?php echo $index + 1; ?></td>
                            <td class="align-middle">
                                <a href="?act=users&action=detail&id=<?php echo htmlspecialchars($user['user_id']); ?>" class="text-dark nav-link a-tabel-hover">
                                    <?php echo htmlspecialchars($user['user_name']); ?>
                                </a>
                            </td>
                            <td class="align-middle"><?php echo htmlspecialchars($user['user_birthday']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($user['user_gender']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($user['user_email_phone']); ?></td>
                            <td class="align-middle ps-4"><?php echo htmlspecialchars($user['user_role']); ?></td>
                            <td class="align-middle">
                                <div class="btn-group">
                                    <a href="?act=user&action=edit&page=<?php echo $page; ?>&id=<?php echo htmlspecialchars($user['user_id']); ?>" class="btn btn-primary btn-sm me-1">Edit</a>
                                    <a href="?act=user&action=delete&page=<?php echo $page; ?>&id=<?php echo htmlspecialchars($user['user_id']); ?>" class="btn btn-danger btn-sm me-2">Delete</a>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No users found.</td>
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
                    <a class="page-link" href="?act=user&action=index&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=user&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=user&action=index&page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</main>

<?php require_once(BASE_PATH."admin/view/layout/footer.php"); ?>
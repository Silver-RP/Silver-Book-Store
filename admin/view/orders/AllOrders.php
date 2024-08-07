
<!--  -->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>All Orders</h2>
    </div>

    <!-- Pagination Links (Top) -->
    <nav aria-label="Page navigation example" class="d-flex justify-content-end pt-2">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=orders&action=index&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=orders&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=orders&action=index&page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Display Orders -->
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>Total Price</th>
                    <th>Total Books</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th class="ps-4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)) : ?>
                    <?php foreach ($orders as $index => $order) : ?>
                        <tr>
                            <td class="align-middle"><?php echo $index + 1; ?></td>
                            <td class="align-middle">
                                <a href="?act=orders&action=detail&id=<?php echo htmlspecialchars($order['order_id']); ?>" class="text-dark nav-link a-tabel-hover">
                                    <?php echo htmlspecialchars($order['order_id']); ?>
                                </a>
                            </td>
                            <td class="align-middle"><?php echo htmlspecialchars($order['user_name']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($order['total_price']); ?></td>
                            <td class="align-middle ps-4"><?php echo htmlspecialchars($order['total_books']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td class="align-middle"><?php echo htmlspecialchars($order['status']); ?></td>
                            <td class="align-middle">
                                <div class="btn-group">
                                    <a href="?act=orders&action=detail&id=<?php echo htmlspecialchars($order['order_id']); ?>" class="btn btn-primary btn-sm me-1">Detail</a>
                                    <a href="?act=orders&action=delete&page=<?php echo $page; ?>&id=<?php echo htmlspecialchars($order['order_id']); ?>" class="btn btn-danger btn-sm me-2">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Links (Bottom) -->
    <nav aria-label="Page navigation example" class="d-flex justify-content-center pt-2">
        <ul class="pagination">
            <?php if ($page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=orders&action=index&page=<?php echo $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=orders&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?act=orders&action=index&page=<?php echo $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</main>

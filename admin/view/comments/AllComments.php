<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom ">
        <h2>All Reviews</h2>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end me-3">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=reviews&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <div class="table-container table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr class="table-heade ">
                    <th>No.</th>
                    <th>Review ID</th>
                    <th>Book ID</th>
                    <th>User ID</th>
                    <th>Review Content</th>
                    <th>Review Rating</th>
                    <th>Review Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $i =1;  foreach ($reviews as $review) : ?>
                    <tr class="table-row">
                        <td class="table-cell"><?php echo $i; ?></td>
                        <td class="table-cell"><?php echo $review['review_id']; ?></td>
                        <td class="table-cell"><?php echo $review['book_id']; ?></td>
                        <td class="table-cell"><?php echo $review['user_id']; ?></td>
                        <td class="table-cell limited-content"><?php echo $review['review_content']; ?></td>
                        <td class="table-cell"><?php echo $review['review_rating']; ?></td>
                        <td class="table-cell"><?php echo $review['review_date']; ?></td>
                        <td class="table-cell review-status" data-review-id="<?php echo $review['review_id']; ?>"><?php echo $review['review_status']; ?></td>
                        <td class="table-cell">
                            <?php if ($review['review_status'] == '0') : ?>
                                <a href="?act=reviews&action=show&id=<?php echo htmlspecialchars($review['review_id']); ?>" class="btn btn-sm btn-primary action-button">Show</a>
                            <?php else : ?>
                                <a href="?act=reviews&action=hide&id=<?php echo htmlspecialchars($review['review_id']); ?>" class="btn btn-sm btn-primary action-button">Hide</a>
                            <?php endif; ?>
                            <a href="?act=reviews&action=delete&id=<?php echo htmlspecialchars($review['review_id']); ?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>


                    </tr>
                <?php $i ++; endforeach; ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                    <a class="page-link" href="?act=reviews&action=index&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</main>
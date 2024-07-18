

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom ">
        <h2>Edit Author</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-10">
                <div class="container px-5 ">
                    <form action="?act=authors&action=update" method="POST">
                        <input type="hidden" name="author_id" value="<?php echo $author['author_id'] ?>">
                        <div class="mb-3">
                            <label for="author_name" class="form-label">Author Name</label>
                            <input type="text" class="form-control" id="author_name" name="author_name" value="<?php echo $author['author_name'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="author_phone" class="form-label">Author Phone</label>
                            <input type="text" class="form-control" id="author_phone" name="author_phone" value="<?php echo $author['author_phone'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="author_email" class="form-label">Author Email</label>
                            <input type="email" class="form-control" id="author_email" name="author_email" value="<?php echo $author['author_email'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="author_address" class="form-label">Author Address</label>
                            <input type="text" class="form-control" id="author_address" name="author_address" value="<?php echo $author['author_address'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="author_note" class="form-label">Author Note</label>
                            <input type="text" class="form-control" id="author_note" name="author_note" value="<?php echo $author['author_note'] ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Author</button>
                        <a href="?act=authors&action=index" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </div>

</main>

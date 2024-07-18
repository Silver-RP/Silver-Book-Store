<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom ">
        <h2>Add Publisher</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="container">
                    <form action="index.php?act=publishers&action=store" method="POST">
                        <div class="mb-3">
                            <label for="publisher_name" class="form-label">Publisher Name</label>
                            <input type="text" class="form-control" id="publisher_name" name="publisher_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="publisher_address" class="form-label">Publisher Address</label>
                            <input type="text" class="form-control" id="publisher_address" name="publisher_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="publisher_phone" class="form-label">Publisher Phone</label>
                            <input type="text" class="form-control" id="publisher_phone" name="publisher_phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="publisher_email" class="form-label">Publisher Email</label>
                            <input type="email" class="form-control" id="publisher_email" name="publisher_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="publisher_url" class="form-label">Publisher URL</label>
                            <input type="text" class="form-control" id="publisher_url" name="publisher_url" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Publisher</button>
                        <a href="?act=publishers&action=index" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </div>


</main>
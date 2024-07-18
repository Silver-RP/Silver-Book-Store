


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom ">
        <h2>Edit Publisher</h2>
    </div>
    <div class="contaier">
        <div class="row">
            <div class="col-md-10">
               <div class="container px-5">
                <form action="?act=publishers&action=update" method="post">
                    <input type="hidden" name="publisher_id" value="<?php echo $publisher['publisher_id']; ?>">
                    <div class="mb-3">
                        <label for="publisher_name" class="form-label
                        ">Publisher Name</label>
                        <input type="text" class="form-control" id="publisher_name" name="publisher_name" value="<?php echo $publisher['publisher_name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="publisher_address" class="form-label
                        ">Publisher Address</label>
                        <input type="text" class="form-control" id="publisher_address" name="publisher_address" value="<?php echo $publisher['publisher_address']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="publisher_phone" class="form-label
                        ">Publisher Phone</label>
                        <input type="text" class="form-control" id="publisher_phone" name="publisher_phone" value="<?php echo $publisher['publisher_phone']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="publisher_email" class="form-label
                        ">Publisher Email</label>
                        <input type="email" class="form-control" id="publisher_email" name="publisher_email" value="<?php echo $publisher['publisher_email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="publisher_url" class="form-label
                        ">Publisher URL</label>
                        <input type="text" class="form-control" id="publisher_url" name="publisher_url" value="<?php echo $publisher['publisher_url']; ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="?act=publishers&action=index" class="btn btn-secondary">Cancel</a>

                </form>
               </div>

            </div>
        </div>
    </div>
</main>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom">
        <h2>Add Category</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="container pt-3">
                    <form action="?act=categories&action=store" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="cate_name">
                        </div>
                        <div class="mb-3">
                            <label for="category_image" class="form-label">Category Image</label>
                            <input type="file" class="form-control" id="category_image" name="category_image">
                        </div>
                        <div class="mb-3">
                            <label for="category_description" class="form-label">Category Description</label>
                            <textarea class="form-control" id="category_description" name="cate_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="category_note" class="form-label">Category Note</label>
                            <input type="text" class="form-control" id="category_note" name="cate_note">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Add Category</button>
                        <a href="?act=categories" class="btn btn-secondary mb-2">Cancel</a>
                    </form>
                </div>
            </div>

        </div>

</main>
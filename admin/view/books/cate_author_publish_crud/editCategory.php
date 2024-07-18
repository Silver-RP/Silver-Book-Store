<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-warning-subtle">
    <div class="d-flex justify-content-between py-3 border-bottom ">
        <h2>Edit Category</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="container">
                    <form action="?act=categories&action=update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="cate_id" value="<?php echo $category['cate_id']; ?>">
                        <div class="mb-3">
                            <label for="cate_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="cate_name" name="cate_name" value="<?php echo $category['cate_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="cate_description" class="form-label">Category Description</label>
                            <input type="text" class="form-control" id="cate_description" name="cate_description" value="<?php echo $category['cate_description']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="cate_note" class="form-label">Category Note</label>
                            <input type="text" class="form-control" id="cate_note" name="cate_note" value="<?php echo $category['cate_note']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="cate_image" class="form-label">Category Image</label>
                            <input type="file" class="form-control" id="cate_image" name="cate_image">
                            <img src="/SilverBook/public/images/categories/<?php echo htmlspecialchars($category['cate_image']); ?>" alt="<?php echo htmlspecialchars($category['cate_image']); ?>" style="max-width: 80px; max-height: 100px;">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="?act=categories&action=index" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>

    </div>

</main>
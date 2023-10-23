<div class="container py-5 my-5">
    <div class="d-flex align-items-center justify-content-center">
        <div class="col-md-10 rounded border border-secondary">
            <div class="bg-body-tertiary ps-3 py-3 rounded">
                <p class="fs-5 m-0"><i class="bi bi-pencil me-2"></i>Editing blog</p>
            </div>
            <hr class="m-0">
            <form class="create-blog-form p-3" method="POST" autocomplete="off" enctype="multipart/form-data">
                <p class="fs-4 fw-normal"><?php echo ($blogData['slug']) ?></p>
                <div class="form-group d-flex justify-content-center align-items-center">
                    <img id="imagePreview" class="img-fluid" src="<?php echo ($blogData['featured_image']) ?>">
                </div>
                <div class="form-group mb-3">
                    <label for="blogFeaturedImage" class="form-label">Change Featured Image</label>
                    <input class="form-control" type="file" id="blogFeaturedImage" name="featured-image">
                    <div class="form-text">The image added here will be shown at the start of the blog. This field is optional.</div>
                    <div class="d-flex justify-content-end align-items-end">
                        <button class="btn btn-danger btn-sm btn-remove-image d-none"><i class="bi bi-trash me-1"></i>Remove Featured Image</button>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="blogTitle" class="form-label">Title<span class="text-danger ms-1">*</span></label>
                    <input type="text" class="form-control" id="blogTitle" placeholder="Blog title" name="title" value="<?php echo ($blogData['title']) ?>" required>
                </div>
                <div class="form-group mb-3">
                    <label for="blogSlug" class="form-label">Slug</label>
                    <div class="input-group">
                        <span class="input-group-text" id="blogUrl"><?= $app_host . '/blog/' ?></span>
                        <input type="text" class="form-control text-lowercase" id="blogSlug" placeholder="create-new-blog" aria-describedby="blogUrl" name="slug" value="<?php echo ($blogData['slug']) ?>" required>
                    </div>
                    <div class="form-text">Requires a unique value. If empty, a unique slug will be generated.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="selectTitle" class="form-label">Category<span class="text-danger ms-1">*</span></label>
                    <select id="selectTitle" class="form-select" aria-label="Select Title" name="category" required>
                        <option>None</option>
                        <option <?php if ($blogData['category'] == 'Design') echo 'selected'; ?>>Design</option>
                        <option <?php if ($blogData['category'] == 'Food') echo 'selected'; ?>>Food</option>
                        <option <?php if ($blogData['category'] == 'Health') echo 'selected'; ?>>Health</option>
                        <option <?php if ($blogData['category'] == 'Science') echo 'selected'; ?>>Science</option>
                        <option <?php if ($blogData['category'] == 'Style') echo 'selected'; ?>>Style</option>
                        <option <?php if ($blogData['category'] == 'Technology') echo 'selected'; ?>>Technology</option>
                        <option <?php if ($blogData['category'] == 'Travel') echo 'selected'; ?>>Travel</option>
                        <option <?php if ($blogData['category'] == 'World') echo 'selected'; ?>>World</option>
                    </select>
                    <div class="form-text">Select the category for the blog to publish.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="blogExcerpt" class="form-label">Excerpt<span class="text-danger ms-1">*</span></label>
                    <textarea class="form-control" id="blogExcerpt" rows="3" name="excerpt" required><?php echo($blogData['excerpt']) ?></textarea>
                    <div class="form-text">A short extract from content.</div>
                </div>
                <div class="form-group mb-3">
                    <label for="blogContent" class="form-label">Content<span class="text-danger ms-1">*</span></label>
                    <textarea class="form-control" id="blogContent" rows="6" name="content" required><?php echo($blogData['content']) ?></textarea>
                    <div class="form-text">Write your blog content here.</div>
                </div>
                <button class="btn btn-prime btn-publish-post" type="submit">Update Blog</button>
            </form>
        </div>
    </div>
</div>
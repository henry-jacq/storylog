<div class="container py-5 my-5">
    <div class="d-flex align-items-center justify-content-center">
        <div class="col-md-10 rounded border border-secondary">
            <div class="bg-body-tertiary ps-3 py-3 rounded">
                <p class="fs-5 m-0"><i class="bi bi-pencil me-2"></i>Create a blog</p>
            </div>
            <hr class="m-0">
            <form class="create-blog-form p-3" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="blogFeaturedImage" class="form-label">Add Featured Image</label>
                    <input class="form-control" type="file" id="blogFeaturedImage" name="blog-featured-image">
                    <div class="form-text">This image will shown in the start of the blog.</div>
                    <div class="d-flex justify-content-end align-items-end">
                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Remove Featured Image</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="blogTitle" name="blog-title">
                </div>
                <div class="mb-3">
                    <label for="blogSlug" class="form-label">Slug</label>
                    <div class="input-group">
                        <span class="input-group-text" id="blogUrl"><?= $app_host . '/blog/' ?></span>
                        <input type="text" class="form-control" id="blogSlug" aria-describedby="blogUrl" name="blog-slug">
                    </div>
                    <div class="form-text">Field must contain an unique value</div>
                </div>
                <div class="mb-3">
                    <label for="selectTitle" class="form-label">Category</label>
                    <select id="selectTitle" class="form-select" aria-label="Select Title" name="blog-category">
                        <option selected>None</option>
                        <option value="1">Design</option>
                        <option value="2">Food</option>
                        <option value="3">Health</option>
                        <option value="4">Science</option>
                        <option value="5">Style</option>
                        <option value="6">Technology</option>
                        <option value="7">Travel</option>
                        <option value="8">World</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="blogExcerpt" class="form-label">Excerpt</label>
                    <textarea class="form-control" id="blogExcerpt" rows="3" name="blog-excerpt"></textarea>
                    <div class="form-text">A short extract from writing.</div>
                </div>
                <button class="btn btn-prime btn-publish-post" type="submit">Publish</button>
            </form>
        </div>
    </div>
</div>
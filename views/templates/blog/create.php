<div class="container pt-5 mt-4">
    <div class="d-flex align-items-center justify-content-center">
        <div class="col-md-10 bg-body-tertiary rounded">
            <p class="fs-5 my-3 ms-3"><i class="bi bi-pencil me-2"></i>Create a blog</p>
            <hr class="m-0">
            <div class="p-3">
                <div class="mb-3">
                    <label for="blogTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="blogTitle">
                </div>
                <div class="mb-3">
                    <label for="blogSlug" class="form-label">Slug</label>
                    <div class="input-group">
                        <span class="input-group-text" id="blogUrl"><?= $request_proto . '://'.$app_host . '/blog/'?></span>
                        <input type="text" class="form-control" id="blogSlug" aria-describedby="blogUrl">
                    </div>
                    <div class="form-text">Field must contain an unique value</div>
                </div>
                <div class="mb-3">
                    <label for="selectTitle" class="form-label">Category</label>
                    <select id="selectTitle" class="form-select" aria-label="Select Title">
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
                    <textarea class="form-control" id="blogExcerpt" rows="3"></textarea>
                    <div class="form-text">A short extract from writing.</div>
                </div>
                <button class="btn btn-prime">Publish</button>
            </div>
        </div>
    </div>
</div>
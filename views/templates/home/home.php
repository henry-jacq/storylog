<main class="container px-0 py-5 my-4">
    <div class="nav-scroller py-1 mb-4 border-bottom">
        <nav class="nav nav-underline justify-content-between px-5">
            <a class="nav-item nav-link fw-normal text-uppercase" role="button">categories</a>
            <a class="nav-item nav-link link-body-emphasis" href="/category/world">World</a>
            <a class="nav-item nav-link link-body-emphasis" href="/category/food">Food</a>
            <a class="nav-item nav-link link-body-emphasis" href="/category/technology">Technology</a>
            <a class="nav-item nav-link link-body-emphasis" href="/category/design">Design</a>
            <a class="nav-item nav-link link-body-emphasis" href="/category/science">Science</a>
            <a class="nav-item nav-link link-body-emphasis" href="/category/health">Health</a>
            <a class="nav-item nav-link link-body-emphasis" href="/category/style">Style</a>
            <a class="nav-item nav-link link-body-emphasis" href="/category/travel">Travel</a>
        </nav>
    </div>
    <div class="p-4 p-md-5 rounded text-body-emphasis bg-body-secondary">
        <div class="col-lg-6 px-0">
            <h1 class="display-5 fst-italic">Title of a longer featured blog post</h1>
            <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what's most interesting in this post's contents.</p>
            <p class="lead mb-0"><a href="#" class="text-body-emphasis fw-semibold">Continue reading<i class="bi bi-chevron-right ms-1 small"></i></a></p>
        </div>
    </div>
</main>


<div class="row mb-2">
    <div class="mt-3">
        <h3>Featured posts</h3>
        <hr class="mt-2 mb-4">
    </div>
    <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">World</strong>
                <h3 class="mb-0">Featured post</h3>
                <div class="mb-1 text-body-secondary">Nov 12</div>
                <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="icon-link icon-link-hover stretched-link">
                    Continue reading<i class="bi bi-chevron-double-right small mb-2"></i>
                </a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                </svg>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-success-emphasis">Design</strong>
                <h3 class="mb-0">Post title</h3>
                <div class="mb-1 text-body-secondary">Nov 11</div>
                <p class="mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="icon-link icon-link-hover stretched-link">
                    Continue reading<i class="bi bi-chevron-double-right small mb-2"></i>
                </a>
            </div>
            <div class="col-auto d-none d-lg-block">
                <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Placeholder</title>
                    <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="mt-3">
        <h3>Articles</h3>
        <hr class="mt-2 mb-4">
    </div>
    <div class="col-lg-8 col-md-12 mb-5">
        <?php foreach ($blogs as $article) : ?>
            <article class="blog-post">
                <a href="/blog/<?= $article['slug']?>" class="d-block display-6 link-body-emphasis mb-1 text-truncate" role="button"><?= $article['title']?></a>
                <p class="blog-post-meta">Published <?= $article['published_at']?> by <a href="/profile/<?= $article['user_data']['username']?>"><?= $article['user_data']['fullname']?></a></p>

                <p><?= $article['excerpt']?></p>
            </article>
            <hr class="my-4">
        <?php endforeach; ?>

        <nav class="blog-pagination mt-5 d-flex justify-content-between" aria-label="Pagination">
            <a class="btn btn-outline-primary rounded-pill" href="#"><i class="bi bi-arrow-left me-2"></i>Previous</a>
            <a class="btn btn-outline-secondary rounded-pill disabled" aria-disabled="true">Newer<i class="bi bi-arrow-right ms-2"></i></a>
        </nav>

    </div>

    <div class="col-lg-4">
        <div class="position-sticky" style="top: 5rem;">
            <div class="p-4 mb-3 bg-body-tertiary rounded">
                <h4 class="fst-normal">About</h4>
                <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
            </div>

            <div class="list-group list-group-flush border-0 p-2 rounded-0 mb-5">
                <h4 class="fw-semibold">Follow suggestions</h4>
                <hr class="mt-0 mb-3">
                <a class="list-group-item d-flex align-items-center justify-content-between mb-2 gap-2">
                    <img src="https://photogram.selfmade.social/files/avatars/5055d53d114eb855590c28ef0ffcc1cc.jpeg" alt="Profile 1" class="rounded-circle" width="40" height="40">
                    <div class="my-1 w-50">
                        <h6 class="link-body-emphasis text-truncate small mb-1" role="button">@being_henry</h6>
                        <p class="text-truncate small m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary ms-auto"><i class="bi bi-person-add me-1"></i>Follow</button>
                </a>
                <a class="list-group-item d-flex align-items-center justify-content-between mb-2 gap-2">
                    <img src="https://photogram.selfmade.social/files/avatars/5055d53d114eb855590c28ef0ffcc1cc.jpeg" alt="Profile 1" class="rounded-circle" width="40" height="40">
                    <div class="my-1 w-50">
                        <h6 class="link-body-emphasis text-truncate small mb-1" role="button">@elon_musk</h6>
                        <p class="text-truncate small m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary ms-auto"><i class="bi bi-person-add me-1"></i>Follow</button>
                </a>
                <a class="list-group-item d-flex align-items-center justify-content-between mb-2 gap-2">
                    <img src="https://photogram.selfmade.social/files/avatars/5055d53d114eb855590c28ef0ffcc1cc.jpeg" alt="Profile 1" class="rounded-circle" width="40" height="40">
                    <div class="my-1 w-50">
                        <h6 class="link-body-emphasis text-truncate small mb-1" role="button">@timcook</h6>
                        <p class="text-truncate small m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary ms-auto"><i class="bi bi-person-add me-1"></i>Follow</button>
                </a>
            </div>

            <div class="p-2">
                <h4 class="fst-normal">Social Links</h4>
                <ol class="list-unstyled">
                    <li><a href="#"><i class="bi bi-github me-2"></i>GitHub</a></li>
                    <li><a href="#"><i class="bi bi-twitter me-2"></i>Twitter</a></li>
                    <li><a href="#"><i class="bi bi-facebook me-2"></i>Facebook</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
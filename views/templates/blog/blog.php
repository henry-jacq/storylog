<div class="container py-5 mt-5">
    <div class="d-flex">
        <div class="row gap-4 justify-content-center">
            <div class="col-lg-8 col-sm-12 p-3 bg-body-secondary rounded">
                <article>
                    <a href="/blog/<?= $blogData['slug'] ?>" class="display-6 link-body-emphasis"><?= ucfirst(str_replace('-', ' ', $blogData['title'])) ?></a>
                    <p class="mt-2">Published <?= $blogData['published_at'] ?> by <a href="/profile/<?= $blogData['blog_owner_data']['username'] ?>"><?= $blogData['blog_owner_data']['fullname'] ?></a> </p>

                    <?php
                    if ($sessionUser['id'] == $blogData['uid']) : ?>
                        <a class="btn btn-sm btn-outline-secondary btn-edit-blog mb-4" href="/blog/edit/<?= $blogData['slug'] ?>" role="button"><i class="bi bi-pencil me-2"></i>Edit Post</a>
                    <?php endif; ?>

                    <? if ($blogData['featured_image'] != 0) : ?>
                        <img class="img-fluid mb-3" src="<?= $blogData['featured_image'] ?>" alt="">
                    <? endif; ?>

                    <p><?= nl2br($blogData['excerpt']) ?></p>
                    <p><?= nl2br($blogData['content']) ?></p>
                </article>
            </div>
            <div class="col-lg-3 p-3 bg-body-secondary rounded">
                <p class="small">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae in, suscipit quibusdam voluptatum sapiente porro ex aperiam, dolore fuga labore alias ab optio repellendus ipsam mollitia reiciendis atque, quis sint? Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam maiores harum totam quasi, ipsa quisquam consequatur eos nulla recusandae assumenda reiciendis explicabo praesentium possimus delectus esse nihil est officiis ipsam? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae nisi vero aliquid pariatur ipsam assumenda minus! Animi accusantium ex modi suscipit doloremque delectus fuga. Corporis aperiam sequi alias aspernatur distinctio!</p>
            </div>
        </div>
    </div>
</div>
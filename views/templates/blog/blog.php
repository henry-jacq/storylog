<div class="container py-5 mt-5">
    <div class="d-flex">
        <div class="row gap-4 justify-content-center">
            <div class="col-lg-8 col-sm-12 p-3 bg-body-secondary rounded">
                <article>
                    <a href="/blog/<?= $data['slug']?>" class="display-6 link-body-emphasis"><?= ucfirst(str_replace('-', ' ', $data['title']))?></a>
                    <p class="m-0">Published <?= $data['published_at']?> by <a href="/profile/<?= $data['uid']?>"><?= $data['uid']?></a> </p>

                    <? if ($data['featured_image'] != 0): ?>
                        <img class="img-fluid mt-3" src="<?= $data['featured_image']?>" alt="">
                    <? endif; ?>

                    <p class="mt-3"><?= nl2br($data['excerpt'])?></p>
                    <p><?= nl2br($data['content'])?></p>
                </article>
            </div>
            <div class="col-lg-3 p-3 bg-body-secondary rounded">
                <p class="small">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Molestiae in, suscipit quibusdam voluptatum sapiente porro ex aperiam, dolore fuga labore alias ab optio repellendus ipsam mollitia reiciendis atque, quis sint? Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam maiores harum totam quasi, ipsa quisquam consequatur eos nulla recusandae assumenda reiciendis explicabo praesentium possimus delectus esse nihil est officiis ipsam? Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae nisi vero aliquid pariatur ipsam assumenda minus! Animi accusantium ex modi suscipit doloremque delectus fuga. Corporis aperiam sequi alias aspernatur distinctio!</p>
            </div>
        </div>
    </div>
</div>
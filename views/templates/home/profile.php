<?php

use App\Core\Session;
use App\Core\User;
use App\Core\View;
use App\Model\Like;
use App\Model\Post;
use App\Model\Follow;
use App\Model\UserData;

$username = $_GET['user'];
$ud = new UserData($username);
$profile_id = $ud->getUserId($username);
$sess_user_id = Session::getUser()->getId();
$sess_username = Session::getUser()->getUsername();
$fullname = User::getFullnameByUsername($username);
?>

<div class="container">
	<div class="profile-page-cover bg-body-secondary position-relative mt-3 rounded">
		<div class="position-absolute top-0 end-0 p-3">
			<?php if (!empty($ud->getWebsite())) : ?>
				<a class="small text-secondary me-2" href="<?= $ud->getWebsite() ?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Website"><i class="bi bi-globe fs-5"></i></a>
			<?php endif;
			if (!empty($ud->getInstagram())) : ?>
				<a class="small me-2 text-danger" href="https://instagram.com/<?= $ud->getInstagram() ?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Instagram"><i class="bi bi-instagram text-danger fs-5"></i></a>
			<?php endif;
			if (!empty($ud->getTwitter())) : ?>
				<a class="small text-primary" href="https://twitter.com/<?= $ud->getTwitter() ?>" target="_blank" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Twitter"><i class="bi bi-twitter text-primary fs-5"></i></a>
			<?php endif; ?>
		</div>
		<div class="profile-page-avatar bg-body-secondary">
			<img class="img-fluid rounded-circle" src="<?= $ud->getUserAvatar() ?>" alt="">
		</div>
		<div class="position-absolute bottom-0 end-0 p-2">
			<?php if ($username == $sess_username) : ?>
				<a href="/edit-profile" class="btn btn-prime btn-sm"><i class="bi bi-pencil me-1"></i>Edit Profile</a>
			<?php else : ?>
				<?php
				if (Follow::isUserFollowing($sess_user_id, $profile_id)) :
				?>
					<button class="btn btn-sm btn-primary btn-follow" data-id="<?= $profile_id ?>"><i class="bi-person-check me-1"></i>Following</button>
				<?php else : ?>
					<button class="btn btn-sm btn-primary btn-follow" data-id="<?= $profile_id ?>"><i class="bi-person-add me-1"></i>Follow</button>
				<?php endif; ?>
				<button class="btn btn-sm btn-secondary" onclick="dialog('Not Implemented!',' This feature is not implemented');"><i class="bi bi-chat-left-text-fill me-1"></i>Message</button>
			<?php endif; ?>
		</div>
	</div>
	<div class="container mt-5">
		<div class="row mx-2 mb-2">
			<div class="col-md-7">
				<h5 class="m-0"><?= ucfirst($fullname) ?>
				</h5>
				<p class="mb-2">@<?= $username ?>
					<?php if (!empty($ud->getJob()) && $ud->getJob() != 'None') :
						echo ('<span class="small mb-2"> • ' . $ud->getJob() . '</span>');
					endif; ?></p>
				<?php if (!empty($ud->getLocation())) : ?>
					<p class="text-secondary small"><i class="bi bi-geo-alt me-1"></i><?= $ud->getLocation() ?></p>
				<?php endif;
				if (!empty($ud->getBio())) : ?>
					<p><?= nl2br($ud->getBio()) ?></p>
				<?php endif; ?>
			</div>
			<div class="col-md-5 mb-2 px-1">
				<div class="hstack gap-3 gap-xl-3 float-md-end">
					<div class="text-center px-2">
						<h6 class="mb-0"><?= User::formatNumbers(Post::countUserPosts($username)[0]['count']) ?></h6>
						<small>Posts</small>
					</div>
					<div class="vr"></div>
					<div class="text-center px-2">
						<h6 class="mb-0"><?= User::formatNumbers(Like::countLikes($profile_id)[0]['count']) ?></h6>
						<small>Likes</small>
					</div>
					<div class="vr"></div>
					<div class="text-center">
						<h6 class="mb-0"><?php echo (User::formatNumbers(Follow::getFollowersCount($profile_id))) ?></h6>
						<small>Followers</small>
					</div>
					<div class="vr"></div>
					<div class="text-center">
						<h6 class="mb-0"><?php echo (User::formatNumbers(Follow::getFollowingCount($profile_id))) ?></h6>
						<small>Following</small>
					</div>
				</div>
			</div>
		</div>
		<div class="ms-3 mt-4">
			<h4 class="fw-normal">Posts</h4>
		</div>
		<hr class="mt-2 mb-3">
		<?= View::renderTemplate('templates/home/show_posts') ?>
	</div>
</div>
<?php

use App\Core\Session;

$sess_user = Session::getUser()->getUsername();
$username = isset($_GET['user']) ? $_GET['user'] : $sess_user;
$user_profile = "/profile/" . $username;
?>
<div class="container mt-3 user-select-none">
	<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
		<ol class="breadcrumb border rounded p-3">
			<li class="breadcrumb-item">
				<a href="/" class="text-decoration-none text-secondary-emphasis">Home</a>
			</li>
			<?php
			if ($_SERVER['REQUEST_URI'] == '/settings') { ?>
				<li class="breadcrumb-item">
					<a href="/settings" class="text-decoration-none text-secondary-emphasis">Settings</a>
				</li>
				<li class="breadcrumb-item active">
					<a href="/settings" class="text-decoration-none text-secondary-emphasis"><?= ucfirst($sess_user) ?></a>
				</li>
			<?php } elseif ($_SERVER['REQUEST_URI'] == $user_profile) { ?>
				<li class="breadcrumb-item">
					<a href="<?= $user_profile ?>" class="text-decoration-none text-secondary-emphasis">Profile</a>
				</li>
				<li class="breadcrumb-item active">
					<a href="<?= $user_profile ?>" class="text-decoration-none text-secondary-emphasis"><?= ucfirst($username) ?></a>
				</li>
			<?php } elseif ($_SERVER['REQUEST_URI'] == '/edit-profile') { ?>
				<li class="breadcrumb-item">
					<a href="/edit-profile" class="text-decoration-none text-secondary-emphasis">Edit Profile</a>
				</li>
				<li class="breadcrumb-item active">
					<a href="/edit-profile" class="text-decoration-none text-secondary-emphasis"><?= ucfirst($sess_user) ?></a>
				</li>
			<?php } ?>
		</ol>
	</nav>
</div>
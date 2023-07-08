<section class="container user-select-none">
	<div class="h-100 d-flex align-items-center justify-content-center row min-vh-100">
		<div class="py-3 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
			<form class="change-password-form needs-validation" method="POST" autocomplete="off">
				<div class="form-control p-4 bg-black bg-opacity-25">
					<div class="d-flex align-items-center justify-content-center mb-2">
						<i class="bi bi-key-fill fs-1"></i>
					</div>
					<h5 class="fw-normal mb-2 text-center mb-4">Change Password</h5>
					<label for="newPassword" class="form-label">New Password</label>
					<input type="password" id="newPassword" name="newPassword" class="form-control bg-transparent" required>
					<div class="invalid-feedback">Password not matches.</div>
					<label for="confirmNewPassword" class="form-label mt-3">Confirm Password</label>
					<input type="password" id="confirmNewPassword" name="confirmNewPassword" class="form-control bg-transparent" required>
					<div class="invalid-feedback">Password not matches.</div>
					<div class="form-text mb-4">Make sure the password is the same in both fields.</div>
					<div class="d-grid mb-2">
						<button type="submit" class="btn btn-prime btn-change-password" disabled>Change password</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
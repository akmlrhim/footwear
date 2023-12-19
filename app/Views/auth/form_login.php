<!DOCTYPE html>
<html>

<head>
	<title>Login | Footwear</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/login.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>fontawesome-free/css/all.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<img class="wave" src="<?= base_url(); ?>img/wave.png">
	<div class="container">
		<div class="img">
			<img src="<?= base_url(); ?>img/pngegg.png">
		</div>
		<div class="login-content">
			<form action="<?= base_url('auth/login'); ?>" method="POST">
				<?= csrf_field(); ?>
				<img src="<?= base_url(); ?>img/avatar.svg">
				<h2 class="title">Welcome</h2>

				<?php if (!empty(session()->getFlashdata('pesan'))) : ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?= session()->getFlashdata('pesan'); ?>
					</div>
				<?php endif; ?>

				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" class="input" name="username" autocomplete="off" value="<?= old('username'); ?>">
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" class="input" name="password" autocomplete="off" value="<?= old('password'); ?>">
					</div>
				</div>
				<div class="g-recaptcha" style="margin-top:10px;" data-sitekey="6LespSApAAAAAI4DecpPRIbb2sLesI6-gq5Ul0qb"></div>
				<button type="sumbit" class="btn">Login</button>
			</form>
		</div>
	</div>
	<script>
		const inputs = document.querySelectorAll(".input");

		function addcl() {
			let parent = this.parentNode.parentNode;
			parent.classList.add("focus");
		}

		function remcl() {
			let parent = this.parentNode.parentNode;
			if (this.value == "") {
				parent.classList.remove("focus");
			}
		}

		inputs.forEach(input => {
			input.addEventListener("focus", addcl);
			input.addEventListener("blur", remcl);
		});
	</script>

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>
<?php include 'inc/header.php'; ?>

</head>

<body class="container">
	<?php displayMessage() ?>
		<div class="bg-color">
			<h2 class="center">Sign Up to ChatApp</h2>
			<div class="row">
				<form class="col s10 margin-top-1" action="signup.php" method="post">
					<div class="row">
							<div class="input-field col s5 offset-s2">
								<input id="first_name" name="firstname" type="text" class="validate">
								<label for="first_name">First Name</label>
							</div>
							<div class="input-field col s5">
								<input id="last_name" name="lastname" type="text" class="validate">
								<label for="last_name">Last Name</label>
							</div>
					</div>
					<div class="row">
							<div class="input-field col s10 offset-s2">
								<input id="email" name="email" type="text" class="validate">
								<label for="email">Email</label>
							</div>
					</div>
					<div class="row">
							<div class="input-field col s10 offset-s2">
								<input id="username" name="username" type="text" class="validate">
								<label for="username">Username</label>
							</div>
					</div>
					<div class="row">
							<div class="input-field col s5 offset-s2">
								<input id="password" name="password" type="password" class="validate">
								<label for="password">Password</label>
							</div>
							<div class="input-field col s5">
								<input id="c_password" name="confirm_password" type="password" class="validate">
								<label for="c_password">Confirm Password</label>
							</div>
					</div>
					<div class="row">
							<button class="btn col s10 margin-top-1 offset-s2" type="submit" name="submit" value="submit">Sign Up</button>
					</div>
					<div class="row">
						<div class="col s5 offset-s5">
							<div style="margin:25px;">
								Already have an Account?<a href="login.php">Click Here</a>
							</div>
						</div>
					</div>
				</form>
			</div>

		</div>
		<script type="text/javascript" src="javascript/signup.js"></script>

<?php include 'inc/footer.php'; ?>

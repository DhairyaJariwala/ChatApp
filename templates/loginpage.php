<?php include 'inc/header.php'; ?>

</head>

<body class="container">
    <?php displayMessage() ?>
    <h2 class="center"> Sign in to ChatApp </h2>
    <div class="row">
        <form class="col s10 margin-top-1" action="login.php" method="post">
            <div class="row">
                <div class="input-field col s6 offset-s4">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="username" name="username" type="text" class="validate">
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s4">
                    <i class="material-icons prefix">lock_outline</i>
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <button class="btn col s6 offset-s4 margin-top-1" type="submit" name="submit" value="submit">Sign in</button>
            </div>
            <div class="row">
              <div class="col s5 offset-s5">
                <div style="margin:25px;">
                  Don't Have an Account?<a href="signup.php">Click Here</a>
                </div>
              </div>
  					</div>
        </form>
    </div>
    <script type="text/javascript" src="javascript/signup.js"></script>

</body>
<?php include 'inc/footer.php'; ?>

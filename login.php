<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SignIn&SignUp</title>
    <link rel="stylesheet" type="text/css" href="assets/css/log.css" />
    <!-- <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script> -->
    <script src="assets/js/log.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form
            action="<?php echo $_SERVER['PHP_SELF']; ?>"
            id="sub"
            onsubmit="return validform()"
            class="sign-in-form"
            method="post"
          >
            <h2 class="title">Log In</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" id="user" name="username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" id="pass" name="password" />
            </div>
            <input type="submit" value="Login" class="btn solid" />

            <p class="social-text">Or Sign in with social platforms</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>
      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here?</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio
              minus natus est.
            </p>
            <a href="sign.php"
              ><button class="btn transparent" id="sign-up-btn">
                Sign Up
              </button></a
            >
          </div>
          <img src="./assets/img/log.svg" class="image" alt="" />
        </div>

        <div class="panel right-panel"></div>
      </div>
    </div>

    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // TO DO: Validate the username and password
        // For demonstration purposes, we'll just echo the input
        echo "Username: $username, Password: $password";
      }
    ?>

    <script src="app.js"></script>
  </body>
</html>
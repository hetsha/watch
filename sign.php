<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ragister</title>
  <link rel="stylesheet" type="text/css" href="assets/css/log.css" />
  <link rel="icon" href="assets/img/favicon.png" sizes="192x192" />
  <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"></script>
</head>
<body>
  <div class="container sign-up-mode">
    <div class="forms-container">
      <div class="signin-signup">
        <form
          action="index.php"
          onsubmit="return validateForm()"
          id="log"
          class="sign-up-form">
          <h2 class="title">Sign Up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Username" id="user" />
            <span id="usererr"></span>
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="text" placeholder="Email" id="email" />
          </div>
          <div class="input-field">
            <i class="fas fa-phone"></i>
            <input type="text" placeholder="number" id="num" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" id="pass" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input
              type="password"
              placeholder="confirm Password"
              id="copass" />
          </div>
          <input type="submit" value="Sign Up" class="btn solid" />
          <p class="social-text">Or Sign up with social platforms</p>
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
      <div class="panel left-panel"></div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us?</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio
            minus natus est.
          </p>
          <a href="login.php">
            <button class="btn transparent" id="sign-in-btn">Sign In</button>
          </a>
        </div>
        <img src="./assets/img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>
  <script src="app.js"></script>
</body>
</html>
<!DOCTYPE html>
<html>
  <head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <img class="wave" src="img/wave.png">
    <div class="container">
      <div class="img">
        <img src="img/bg.svg">
      </div>
      <div class="login-content">
        <form action="user.php" method="post">
          <img src="img/avatar.svg">
          <h2 class="title">Contorl Panel</h2>
          <div class="input-div one">
            <div class="i">
              <i class="fas fa-user"></i>
            </div>
            <div class="div">
              <h5>User Name</h5>
              <input type="text"  id="username" name="username" class="input"  required>
            </div>
          </div>
          <div class="input-div pass">
            <div class="i">
              <i class="fas fa-key"></i>
            </div>
            <div class="div">
              <h5>Password</h5>
              <input type="password" id="password" name="password" class="input" required>
            </div>
          </div>
          <input type="submit" class="btn" value="Login">
        </form>
      </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
  </body>
</html>

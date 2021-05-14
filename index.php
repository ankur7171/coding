<?php
header("Content-Type: text/html; charset=ISO-8859-1");
session_start();
if(isset($_SESSION["id"])){
    header('Location: index1');
    exit;
}
$conn = mysqli_connect('localhost','gemc2020_webinar','4?HJ1wb+TkR3','gemc2020_webinar');
$success = 0;
if(isset($_POST["submit"])){
    $email =  mysqli_real_escape_string($conn, $_POST["email"]);
    $password =  mysqli_real_escape_string($conn, $_POST["password"]);
    $encpass = sha1($password);
    $sql = "SELECT * FROM mail_admin WHERE email = '$email' AND password = '$encpass' ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $_SESSION["id"] = $row["id"];
            $success = 1;
        }
    } 
    else {
        $success = 0;
    }
    if($success){
        header('Location: index1.php');
        exit;
    }
    else{
        $msg = "Invalid credentials";
    }
    mysqli_close($conn);    
}
?>
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center" style="color:red;">
          <?php if(isset($msg)){echo $msg;} ?>
      </div>
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Login</h5>
            <form method="POST" action="index" class="form-signin">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
                <label for="inputEmail">Email address</label>
              </div>
              <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
                <label for="inputPassword">Password</label>
              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" name="submit" type="submit">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
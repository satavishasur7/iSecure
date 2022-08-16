<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>iSecure_login</title>
  </head>
  <body>
    <?php
       include 'nav.php';
    ?>
    <?php
    $loggedin= false;
    $logError= false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conn.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sqlLog="SELECT * FROM `data` WHERE `username`='$username' ";
    $result= mysqli_query($conn,$sqlLog);
    $numLog= mysqli_num_rows($result);
    if($numLog==1){
      while($rowLog = mysqli_fetch_assoc($result))
      {
        if(password_verify($password, $rowLog['password']))
        {
          $loggedin= true;
          session_start();
          $_SESSION['loggedin']= true;
          $_SESSION['username']= $username;
          header ( "location: welcome.php");
        }
        else{
          $logError ="Invalid Credentials";
        }
      }
    }
    else{
      $logError ="Invalid Credentials";
    }
  }
  if ($logError) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>' . $logError . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
  }
    ?>
    <div class="container">
    <form action="/login/login.php" method="POST">
  <div class="mb-3">
    <label for="username"  class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="username" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="password"  class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
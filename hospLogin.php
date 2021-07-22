<?php session_start(); 
if(isset($_SESSION["user_id"])){
  header("location:dashboard.php");
  }else if(isset($_SESSION["hospital_id"])){
    header("location:dashboard.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php"><span class="red_cross">+</span>Red Cross Community</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <style>
        .navbar-toggler:focus {
            box-shadow: none;
         }
    </style>  
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
            <?php
            if(!isset($_SESSION["name"]) && !isset($_SESSION["hospitalname"])){
                echo "<a class='nav-link' href='login.php'>LogIn(Receiver)</a>";
            }
            ?>
        </li>
        <li class="nav-item">
        <?php
            if(!isset($_SESSION["hospitalname"]) && !isset($_SESSION["name"])){
                echo "<a class='nav-link' href='hospLogin.php'>LogIn(Hospital)</a>";
            }
            ?>
        </li>
          </ul>
          <div>
  </div>
</nav>

<?php

include "dbcon.php";
if(isset($_POST["submit"])){
  $email = $_POST["email"];
  $password = $_POST["password"];

  $email_search = "select * from hospitalreg where email='$email' ";
  $query = mysqli_query($con, $email_search);

  $email_count = mysqli_num_rows($query);

  if($email_count){
    $email_pass = mysqli_fetch_assoc($query);

    $db_pass = $email_pass["password"]; //db_pass will store the password corresponding to the email
   $_SESSION["hospitalname"] = $email_pass["hospitalname"];  // store the name corresponding to the password 

   $_SESSION["hospital_id"] = $email_pass["id"];


    $pass_decode = password_verify($password, $db_pass);
     
    if($pass_decode){
      echo "login successfull";
      ?>
      <script>
        location.replace("dashboard.php");
      </script>
      <?php
      
    }else{
      echo "Invalid Cred";
    }
  }else{
    echo "Email doesn't exist";
  }

}



?>
<div class="card">
  <div class="card-body">
  <h5 class="card-title">Log In As Hospital</h5>
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
  <div class="form-group">
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <div class="form-group">
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
</div>
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  <div>Don't have an account?  <a href="hospSignup.php">Signup</a> </div>
 
</form>
  </div>
</div>
<div style=" text-align: center;" class="footer_div">
 <h6 style="margin-top: 1%;">Red Cross Community By Anurag Das </h6>
 <h6 style="font-weight: lighter;">© Since  <?php echo date("Y") ?> </h6>
</div>
</body>
</html>
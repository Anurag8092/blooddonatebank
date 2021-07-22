<?php session_start(); 
if(isset($_SESSION["hospital_id"])){
  header("location:dashboard.php");
  }else if(isset($_SESSION["user_id"])){
    header("location:dashboard.php");
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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

// Add db
include "dbcon.php";


if(isset($_POST["submit"])){
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $cpassword = mysqli_real_escape_string($con, $_POST["cpassword"]);
     
    $pass = password_hash($password, PASSWORD_BCRYPT);
    $cpass = password_hash($cpassword, PASSWORD_BCRYPT);
    
    $emailquery = "select * from receiverreg where email='$email' ";
    $query = mysqli_query($con, $emailquery);
    
    $emailcount = mysqli_num_rows($query);

    if($emailcount > 0){
        echo "email already exist";
    }else{
        if($password === $cpassword){
            $insertquery = "insert into receiverreg(name, email, password, cpassword) values('$name', '$email', '$pass', '$cpass')";
            $iquery = mysqli_query($con, $insertquery);

                if($iquery){
                    ?>
                <script>
                    alert("inserted");
                </script>
                
                <?php
                }else{
                    ?>
                <script>
                    alert("not inserted");
                </script>
                <?php
            }
        }else{
            echo "password not matching";
        }
    }

}
?>

<div class="card">
  <div class="card-body">
  <h5 class="card-title">Create a Receiver Account</h5>
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
  <div class="form-group">
  <input name="name" type="text" class="form-control" id="nameInput" aria-describedby="nameHelp" placeholder="Enter Name" required
  >
   
    <input name="email" type="email" class="form-control" id="exampleInputEmail1  " aria-describedby="emailHelp" placeholder="Enter email" required
    >
  </div>
  <div class="form-group">
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required
    >
    <input name="cpassword" type="password" class="form-control" id="exampleInputCPassword1" placeholder="Confirm Password" required
    >  
</div>
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  <div>Already have an Account?  <a href="login.php">Login</a> </div>
</form>
  </div>
</div>
<div style=" text-align: center;" class="footer_div">
 <h6 style="margin-top: 1%;">Red Cross Community By Anurag Das </h6>
 <h6 style="font-weight: lighter;">© Since  <?php echo date("Y") ?> </h6>
</div>


</body>
</html>
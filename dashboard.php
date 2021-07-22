<?php 
session_start(); 
// Turn off all error reporting
error_reporting(0);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>Dashboard</title>
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
        <li class="nav-item">
        <?php
    if(isset($_SESSION["hospitalname"])){
        ?>
        <form class="hospital" method="POST">
            <a class='nav-link' name="hospSub" href="hospital.php"><?php echo $_SESSION["hospitalname"] ?></a>
            </form>
            <?php
          }
        ?>
</li>
       <li class="nav-item"> 

        <?php
            if(isset($_SESSION["name"])){
                ?>
                <strong class='nav-link'>Hi, <?php echo $_SESSION["name"] ?></strong>
                <?php
            }
            ?>
        
        </li>

        <li class="nav-item">

        <?php
            if(isset($_SESSION["name"]) || isset($_SESSION["hospitalname"])){
                echo "<a class='nav-link' href='logout.php'>Logout</a>";
            }
        ?>
        </li>
      </ul>
    </div>
  </div>
</nav>






<?php

// Add db
include "dbcon.php";

$select_query = " select * from blooddata ";
$query = mysqli_query($con, $select_query);
$select_user_query = " select * from receiverreg ";
$userquery = mysqli_query($con, $select_user_query);


?>

<div class="container">
    <div class="row text-center flex-wrap ">
      <?php while($res = mysqli_fetch_assoc($query)){ ?>
          <div class="col col-lg-4 col-md-6 col-sm-12">    
          <h2 class=title><?php echo $res["hospitalname"] . " "; ?> </h2>
          <h2><?php echo "Blood Type: " . $res["bloodtype"] . " "; ?> </h2>
          <h2><?php echo "Quantity Available: " . $res['availability']. " ml<br>"; ?> </h2>

<div class="card">
  <div class="card-body">
    <form action="?id=<?php echo $res['id'] ?>"
     method="POST">
    <input type="number" name="volume" class="form-control" placeholder="Insert Volume Required" />
    <button name='requestblood' class="btn btn-primary">
        Request
    </button>   
    <?php echo '<div>
    <input type="hidden" name="user_id" value="' .$_SESSION["user_id"]. '" />
    </div>';
    ?>
    </form> 
  </div>
</div>
   
          </div>
      <?php } ?>
    </div>

  </div>


    <?php
    $id = $_GET["id"];
    $sno = $_POST["user_id"];
    $volume = $_POST["volume"];
    if(isset($_POST["requestblood"])){
        if(!isset($_SESSION["name"]) && !isset($_SESSION["hospitalname"])){
            ?>
            <script>
                alert("You are not logged in!");
                location.href = "login.php";
            </script>
            <?php
        }else if(isset($_SESSION["name"])){

            $isPendgin_state_query = "select * from receiverdata where isPending = '1' and user_id = '$sno' ";
            $run_isPendgin_state_query = mysqli_query($con, $isPendgin_state_query);
            $isPending = mysqli_fetch_assoc($run_isPendgin_state_query);
            $_SESSION["pending_state"] = $isPending["isPending"];
            if($_SESSION["pending_state"] === '1'){
                ?>
            <script>
                alert("Blood Sample Already Requested");
            </script>
            <?php
            }else{
                $hospitalname_query = "select * from blooddata where id = '$id' ";
                $run_hospitalname_query = mysqli_query($con, $hospitalname_query);
                $fetch_hospitalname_query = mysqli_fetch_assoc($run_hospitalname_query);
                $hospital_name = $fetch_hospitalname_query["hospitalname"];
                $blood_type = $fetch_hospitalname_query["bloodtype"];
                $volume_available = $fetch_hospitalname_query["availability"];
                $_SESSION["volume_available"] = $volume_available;
                

                $receiverdata_query = "select * from receiverreg where id = '$sno' ";
                $run_receiverdata_query = mysqli_query($con, $receiverdata_query);
                $fetch_receiverdata_query = mysqli_fetch_assoc($run_receiverdata_query);
                $user_id = $fetch_receiverdata_query["id"];
                $user_email = $fetch_receiverdata_query["email"];

                if($volume <= 0){
                    ?>
                <script>
                    alert("Please Mention the Volume");
                </script>
                <?php
                }else if($volume >= $volume_available){
                    ?>
                    <script>
                        alert("Please enter a volume within the limit or wait till quantity available increases!!");
                    </script>
                    <?php
                }else{
                    $insertreceiverdata = "insert into receiverdata(hospitalname, bloodtype, user_id, hospital_id, useremail, volume)
                    values( '$hospital_name', '$blood_type', '$user_id', '$id', '$user_email', '$volume' ) ";
                    $iquery = mysqli_query($con, $insertreceiverdata);
                    
                    // echo $_SESSION["volume_requested"];
                    ?>
                    <script>
                        alert("Blood Sample Requested");
                    </script>
                    <?php
                }
            }

        }else if(isset($_SESSION["hospitalname"])){
            ?>
            <script>
                alert("You need to be logged in as Receiver");
            </script>
            <?php
            }
        }

    if(isset($_POST["hospSub"])){
        if(isset($_SESSION["name"])){
            ?>
            <script>
                alert("You need to be logged in as Hospital");
            </script>
            <?php
        }else{
            header("location:hospLogin.php");
        }
    }
    ?>
<div style=" text-align: center;" class="footer_div">
 <h6 style="margin-top: 1%;">Red Cross Community By Anurag Das </h6>
 <h6 style="font-weight: lighter;">© Since  <?php echo date("Y") ?> </h6>
</div>
</body>



</html>
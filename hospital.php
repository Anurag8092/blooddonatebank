<?php 
session_start(); 
if(!isset($_SESSION["hospital_id"])){
    header("location:hospLogin.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link defer href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title><?php echo $_SESSION["hospitalname"] ?></title>

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

if(isset($_POST["submit"])){
    $hospitalname = $_SESSION["hospitalname"];
    $bloodtype = mysqli_real_escape_string($con, $_POST["bloodtype"]);
    $availability = mysqli_real_escape_string($con, $_POST["availability"]);
    if(!$bloodtype || !$availability){
        ?>
<script>
    alert("PLease Fill All Data");
</script>
        <?php
    }else{
        $insertquery = "insert into blooddata(hospitalname, bloodtype, availability) values('$hospitalname', '$bloodtype', '$availability')";
        $iquery = mysqli_query($con, $insertquery);
        if($iquery){
            ?>
        <script>
            alert("Data Inserted");
        </script>
        
        <?php
        }else{
            ?>
        <script>
            alert("Data Not Inserted");
        </script>
        <?php
    }
    }

}else if(isset($_POST["update"])){
    $bloodtype =  mysqli_real_escape_string($con, $_POST["bloodtype"]);
    $new_availability = mysqli_real_escape_string($con, $_POST["availability"]);
    if(!$bloodtype || !$new_availability){
        ?>
<script>
    alert("PLease Fill All Data");
</script>
        <?php
    }else{
        $update_blood_data = "update blooddata set availability = '$new_availability' where bloodtype = '$bloodtype' ";
        $updata_query = mysqli_query($con, $update_blood_data);
    
        if($updata_query){
        header("location:hospital.php");
        }else{
            ?>
        <script>
            alert("Data Not Updated");
        </script>
        <?php
    }
    }
}else if(isset($_POST["acceptreq"])){

$receiver_id = $_GET["id"];
// echo $receiver_id;

$hospitalname = $_SESSION["hospitalname"];
        $update_isAccepted_query = " update receiverdata set isAccepted = '1' where id = '$receiver_id' ";
        $update_isPending_query = "update receiverdata set isPending = '0' where isAccepted = '1' ";              
        $run_isAccepted_query = mysqli_query($con, $update_isAccepted_query);
        $run_isPending_query = mysqli_query($con, $update_isPending_query);


        $volume_req_query = "select * from receiverdata where id = '$receiver_id' ";
        $run_volume_req_query = mysqli_query($con, $volume_req_query);
        $res = mysqli_fetch_assoc($run_volume_req_query);
        $volume_req = $res["volume"];
        $hospital_id = $res["hospital_id"];
        // echo $volume_req;
        // echo $hospital_id;

        $hospital_id_query = "select * from blooddata where id = '$hospital_id' ";
        $run_hospital_id_query = mysqli_query($con, $hospital_id_query);
        $res = mysqli_fetch_assoc($run_hospital_id_query);
        $volume_available = $res["availability"];
        // echo $volume_available;
        
        $volume_remaining = floatval($volume_available) - floatval($volume_req);
         $update_volume_availability = "update blooddata set availability = '  $volume_remaining ' 
         where id = $hospital_id ";
         $run_update_volume_availability = mysqli_query($con, $update_volume_availability);

 ?>
<script>
    alert("Blood Sample Request Accepted");
</script>
 <?php

}


?>

<h1 class="heading"><?php echo $_SESSION["hospitalname"] ?></h1>

<?php



$hospitalname = $_SESSION["hospitalname"];
    $user_details_query = "select * from receiverdata where hospitalname = '$hospitalname' ";
    $run_user_details_query = mysqli_query($con, $user_details_query);
    ?>
    <div class="container">
    <div class="row text-center flex-wrap ">
      <?php 
      $user_num = mysqli_num_rows($run_user_details_query);
      if($user_num === 0){
        echo '<h2>No Requests</h2>'; 
      }else{
        echo '<h2 class="title">Blood Sample Requests</h2>'; 
        while($user_details = mysqli_fetch_assoc($run_user_details_query)){  ?>
            <div class="col col-lg-4 col-md-6 col-sm-12">  
            
            
            
              <h2><?php echo "Blood Type: " . $user_details['bloodtype'] ?></h2>
              <h2><?php echo "Requested By: " .  $user_details['useremail'] ?></h2>
              <h2><?php echo "Volume Requested: " .  $user_details['volume']. " ml<br>" ?></h2>
              <h2><?php echo "Requested At: " .  $user_details['timestamp'] ?></h2>
              <form action=" ?id=<?php echo $user_details['id'] ?>" method="POST">
          <?php 
          if($user_details['isAccepted']==='1') { 
              ?>
           <button disabled class="btn btn-primary">Accepted</button>
           <?php }else{ ?>
              <button name="acceptreq" class="btn btn-primary">Accept</button>
          <?php } ?>
              </form>
              </div>
      <?php
      }
          
      }
      ?>

    </div>

  </div>
  <hr>

<?php
 $hospitalname = $_SESSION["hospitalname"];
$blood_data = "select * from blooddata where hospitalname = '$hospitalname' ";
$blood_data_query = mysqli_query($con, $blood_data);
?>

<div class="container">
    <div class="row text-center flex-wrap ">
      <?php echo '<h2 class="title">Available Blood Samples</h2>'; 
     while($res = mysqli_fetch_assoc($blood_data_query)){  ?>
          <div class="col col-lg-4 col-md-6 col-sm-12">  
          
            <h2><?php echo "Blood Type:" .  $res['bloodtype'] ?></h2>
            <h2><?php echo "Quantity Available:" .  $res['availability']. " ml<br>" ?></h2>
            </div>
    <?php
    }
        ?>
    </div>
  </div>

  <div class="card">
  <div class="card-body">
  <hr>
  <h5 class="card-title">Add Samples/Update Existing Samples</h5>
  <form method="POST">
    <input type="text" name="bloodtype" class="form-control" placeholder="Blood Type"/>
    <input type="number" name="availability" class="form-control" placeholder="Total Blood Samples"/>
    <button name="submit" class="btn btn-primary">ADD</button>
    <button name="update" class="btn btn-primary">UPDATE</button>
    <input type="hidden" />
    </form>
  </div>
</div>
<div style=" text-align: center;" class="footer_div">
 <h6 style="margin-top: 1%;">Red Cross Community By Anurag Das </h6>
 <h6 style="font-weight: lighter;">© Since  <?php echo date("Y") ?> </h6>
</div>
  
    
</body>
</html>
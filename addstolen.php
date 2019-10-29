<!--==Author (c)frankline_bwire==-->
<?php
include 'connect.php';
$dname='';
$dtype='';
$dmodel='';
$dimei='';
if(isset($_POST['submit'])){
$dname=mysqli_real_escape_string($conn, $_POST['dname']);
$dtype=mysqli_real_escape_string($conn, $_POST['dtype']);
$dmodel=mysqli_real_escape_string($conn, $_POST['dmodel']);
$dimei=mysqli_real_escape_string($conn, $_POST['dimei']);
    //Check if user device exist
$user_check = "SELECT * FROM imei_reports WHERE imei='$dimei' LIMIT 1";
$result = mysqli_query($conn, $user_check);
$device = mysqli_fetch_assoc($result);
if ($device) { // if user exists
if ($device['imei'] === $dimei) {
array_push($errors, "device already exists");
}
}
    //post to database
$query="insert into imei_reports (name,type,model,imei) values ('$dname','$dtype','$dmodel','$dimei')";    
if(!mysqli_query($conn,$query)){
    echo "ERROR: Could not execute query. " . mysqli_error($conn);
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Stolen</title>
</head>
<body>
   <h3>This modules allows you to add a stolen or lost device and an alert will be sent to the user once the device is  discovered.</h3>
    <form method="post" action="addstolen.php">
       <?php include('errors.php'); ?>
       <div>
           <label for="dname">Phone Name</label>
        <input type="text" name="dname" placeholder="Samsung">
       </div>
        <div>
           <label for="dtype">Phone Type</label>
        <input type="text" name="dtype" placeholder="S8 Edge"> 
        </div>
        <div>
            <label for="dmodel">Phone Model</label>
        <input type="text" name="dmodel" placeholder="S300m">
        </div>
        <div>
            <label for="dimei">Phone IMEI No.</label>
        <input type="text" name="dimei" placeholder="33003600">
        </div>
        
        <input type="submit" name="submit" value="Add">
    </form>
    <input type="submit" name="logout" src="logout.php" value="SignOut">
</body>
</html>
<!--==Author (c)frankline_bwire==-->
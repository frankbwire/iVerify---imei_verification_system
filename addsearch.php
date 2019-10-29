<!--==Author (c)frankline_bwire==-->
<?php
include 'connect.php';
$query='';
$result='';
$output='';
if(isset($_POST['search'])){
	$q = $_POST['sterm'];
	$query ="SELECT * FROM `imei` WHERE `imei` = '$q'";
    $result=mysqli_query($conn,$query) or die ('error');
    
//Replace table_name with your table name and `thing_to_search` with the column you want to search
	$count = mysqli_num_rows($result);
	if(!$result){
		$output =  'YOUR DEVICE IS NOT GENUINE';
	}
    else{
        $ouput=  'YOUR DEVICE IS GENUINE';
    }
    
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMEI Code Verification</title>
    <style type="text/css">
        table{
            padding-top: 2em;
            width: 100%;
        }
        th{
            
        }
    </style>
</head>
<body>
   <h4>How to verify the IMEI Code of your mobile device</h4>
   <p><b>Instructions:</b> Please follow the steps below in order to verify the IMEI Code of your mobile device</p>
   <p>Dial *#06# on your mobile device.</p>
   <p>The number displayed in your device is the unique code specific for your mobile device and is called International Mobile Equipment Identity (IMEI).  For mobile devices having two SIM cards it will display two IMEI codes.</p>
   <p>Enter the IMEI code in the blank space provided and press "Validate My Mobile Device". The authenticity of the mobile device corresponding with the IMEI code will be displayed for you to compare and verify if your device is genuine or not.</p>
   
    <!--Search feature-->
      <form method="post" action="addsearch.php" >
         <table align="center">
           <th>ENTER IMEI CODE:</th>
           <th><input style="width:100%" type="text" id="search" name="sterm"  placeholder="Enter device IMEI code here." align="center"></th>
           <th><button type="submit" name="search" >VERIFY MY DEVICE</button></th>
           <tr>
               <td colspan="3" align="center">IMEI VERIFICATION RESULTS</td>
           </tr>
             <?php
             if ($result){
                            while ($rows=mysqli_fetch_assoc($result))
                            {
                             ?>
           <tr>
               <td>
                  <b>IMEI Code:</b> 
               </td>
                <td>
                 <?php echo $rows['imei']; ?>
                </td> 
           </tr>
           <tr>
                <td>
                   <b>Manufactured By:</b>
               </td>
                <td>
                 <?php echo $rows['Name']; ?>
                </td> 
           </tr>
            <tr>
                <td>
                  <b>Model and Type :</b> 
               </td>
                <td>
                 <?php echo $rows['Type']; ?>
                 
                 <?php echo $rows['Model']; ?>
                </td> 
           </tr>
           <tr>
               <td>
                   <?php echo $output; ?>
               </td>
           </tr>
             <?php
                           }
             }
                           ?>
       </table> 
      </form>
       
        
        
</body>
</html>
<!--==Author (c)frankline_bwire==-->
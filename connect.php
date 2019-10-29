<!--==Author (c)frankline_bwire==-->
<?php
//Create connection
$conn=mysqli_connect('localhost','root','','imeicodes');
//check connection
if(!$conn){
    echo 'unable to connect' . mysqli_connect_error($conn);
}
?>
<!--==Author (c)frankline_bwire==-->
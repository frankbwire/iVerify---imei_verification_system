<?php
include 'connect.php';
//IMEI VERIFICATION
$query='';
$result='';
$output='';
if(isset($_POST['search'])){
	$q = $_POST['sterm'];
	$query ="SELECT * FROM `imei` WHERE `imei` = '$q'";
    $result=mysqli_query($conn,$query) or die ('error');
    
//Check if device has been reported lost/stolen
$device_check = "SELECT * FROM imei_reports WHERE imei='$q' LIMIT 1";
$result2 = mysqli_query($conn, $device_check);
$check_imei = mysqli_fetch_assoc($result2);
if ($check_imei) { // if device exists
if ($check_imei['imei'] === $q) {
echo "<script>
alert('This device has been reported LOST/STOLEN. The owner has been NOTIFIED.');
</script>";
}

}
	}
//ADD DEVICE AND VERIFY IF STOLEN
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
$result3 = mysqli_query($conn, $user_check);
$device = mysqli_fetch_assoc($result3);
if ($device) { // if device exists
if ($device['imei'] === $dimei) {
echo "<script>
alert('This device was already reported LOST/STOLEN.');
</script>";
}
}
//post to database
$query="insert into imei_reports (name,type,model,imei) values ('$dname','$dtype','$dmodel','$dimei')";    
if(!mysqli_query($conn,$query)){
 mysqli_error($conn);
}
}
?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>iVerify - imei.verification.system</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
        <style type="text/css">
            li {
                font-weight: 500;
            }

            body {
                text-align: justify;
            }

            label {
                text-align: left;
            }

            .contus {
                font-weight: 600;
            }
        </style>
    </head>

    <body class="is-preload">

        <!-- Wrapper -->
        <div id="wrapper">
            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <li><a href="#intro" class="active">Introduction</a></li>
                    <li><a href="#first">Verify IMEI</a></li>
                    <li><a href="#second">Add Device</a></li>
                    <li><a href="#cta">Contact Us</a></li>
                   
                </ul>
            </nav>

            <!-- Main -->
            <div id="main">

                <!-- Introduction -->
                <section id="intro" class="main">
                    <div class="spotlight">
                        <div class="content">
                            <header class="major">
                                <h2>IMEI DEVICE VERIFICATION</h2>
                            </header>
                            <h4>How to verify the IMEI Code of your mobile device</h4>
                            <p><b>Instructions:</b> Please follow the steps below in order to verify the IMEI Code of your mobile device</p>
                            <p>Dial *#06# on your mobile device.</p>
                            <p>The number displayed in your device is the unique code specific for your mobile device and is called International Mobile Equipment Identity (IMEI). For mobile devices having two SIM cards it will display two IMEI codes.</p>
                            <p>Enter the IMEI code in the blank space provided and press "Validate My Mobile Device". The authenticity of the mobile device corresponding with the IMEI code will be displayed for you to compare and verify if your device is genuine or not.</p>
                        </div>
                    </div>
                </section>

                <!-- First Section -->
                <!--Verify Device if Genuine-->
                <section id="first" class="main special">
                    <header class="major">
                        <h2>VERIFY</h2>
                    </header>
                    <!--Search feature-->
                    <form method="post" action="index.php">
                        <table align="center">
                            <th>ENTER IMEI CODE:</th>
                            <th><input style="width:100%" type="text" id="search" name="sterm" placeholder="Enter device IMEI code here." align="center"></th>
                            <th><button type="submit" name="search">VERIFY MY DEVICE</button></th>
                            <?php
             if ($result){
                 
                            while ($rows=mysqli_fetch_assoc($result))
                            {
                             ?>
                                <tr>
                                    <td colspan="3" align="center">IMEI VERIFICATION RESULTS</td>
                                </tr>
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
                                        <b>Model and Types :</b>
                                    </td>
                                    <td>
                                        <?php echo $rows['Type']; ?>

                                        <?php echo $rows['Model']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
<td class="gen">THIS DEVICE IS <b style="color: firebrick; font-weight:500">GENUINE</b>
                                    </td>
                                </tr>
                                <?php
                           }
             }
                           ?>
                        </table>
                    </form>
                </section>

                <!-- Second Section -->
                <section id="second" class="main special">
                    <header class="major">
                        <h2>ADD NEW DEVICE</h2>
                        <p>This modules allows you to add a <b style="color: firebrick; font-weight:600">stolen</b> or <b style="color: firebrick; font-weight:600">lost</b> device and an alert will be sent to the user once the device is discovered.</p>
                    </header>
                    <form method="post" action="index.php">
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
                        <hr>
                        <div>
                            <input type="submit" name="submit" value="Add">
                        </div>
                    </form>
                </section>
            </div>

            <!-- Footer -->
            <footer id="footer">
                <section id="cta" class="main special">
                    <h2 class="contus">Contact Us</h2>
                    <dl class="alt">
                        <dt>Address:</dt>
                        <dd>1234 Street &bull; Kenya</dd>
                        <dt>Phone:</dt>
                        <dd>(123) 456-789 </dd>
                        <dt>Email:</dt>
                        <dd><a href="#">iverify.notchcom.solutions@gmail.com</a></dd>
                    </dl>
                    <ul class="icons">
                        <li><a href="#" class="icon fa-twitter alt"><span class="label">Twitter</span></a></li>
                        <li><a href="#" class="icon fa-facebook alt"><span class="label">Facebook</span></a></li>
                        <li><a href="#" class="icon fa-instagram alt"><span class="label">Instagram</span></a></li>
                        <li><a href="#" class="icon fa-github alt"><span class="label">GitHub</span></a></li>
                    </ul>
                </section>
                <p class="copyright">&copy; iVerify &bull; IMEI Device Verification</p>
            </footer>

        </div>

        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/browser.min.js"></script>
        <script src="assets/js/breakpoints.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>

    </body>

    </html>
<?php
ob_start();
include("../mysql.php"); 
include_once("../login.php"); 
include_once("../lang.php");
include_once("../precode.php");
include_once("../timezones.php");
	header('Content-Type: application/json', true);
	if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
	and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
	and (securelogin()==true) ) {
		if(isset($_POST['cmntid'])){
			$comid=$_POST['cmntid'];
			$sql="DELETE FROM newscmnt WHERE userid='".$_COOKIE['id']."' AND cid='".$comid."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			ob_end_clean();
			echo json_encode($comid);			
		}
	}
?>
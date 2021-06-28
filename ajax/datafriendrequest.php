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
		if(isset($_POST['friendrequest'])){
			$otherid2=$_POST['friendrequest'];
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='$otherid2' ");
			while($row = mysqli_fetch_array($result)){
					$frequest=unserialize($row['frequest']);
					if (!in_array($_COOKIE['id'], $frequest)) {
						array_push($frequest,$_COOKIE['id']);
					}
					$frequest=serialize($frequest);
					$sql="UPDATE users SET frequest='$frequest' WHERE id='".$otherid2."' ";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			if($lang=='gr'){$fres=["Το Αίτημα Στάλθηκε"];}
			if($lang=='en'){$fres=["Request Send"];}
			ob_end_clean();
			echo json_encode($fres);
		}
	}
?>
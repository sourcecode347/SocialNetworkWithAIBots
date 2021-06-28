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
		if(isset($_POST['block'])){
			$block=$_POST['block'];
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='$block' ");
			while($row = mysqli_fetch_array($result)){
					$othersblock=unserialize($row['othersblock']);
					if (!in_array($_COOKIE['id'], $othersblock)) {
						array_push($othersblock,$_COOKIE['id']);
					}
					$othersblock=serialize($othersblock);
					$sql="UPDATE users SET othersblock='$othersblock' WHERE id='".$block."' ";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
					$blocked=unserialize($row['blocked']);
					if (!in_array($block, $blocked)) {
						array_push($blocked,$block);
					}
					$blocked=serialize($blocked);
					$sql="UPDATE users SET blocked='$blocked' WHERE id='".$_COOKIE['id']."' ";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			if($lang=='gr'){$fres=["Μπλοκαρίστηκε"];}
			if($lang=='en'){$fres=["Blocked"];}
			ob_end_clean();
			echo json_encode($fres);
		}
	}
?>
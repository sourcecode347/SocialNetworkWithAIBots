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
		if(isset($_POST['unfriendrequest'])){
			$rejectedid=$_POST['unfriendrequest'];
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$friends=unserialize($row['friends']);
				if(in_array($rejectedid, $friends)) {
					$friends2=array();
					for($x=0;$x<count($friends);$x++){
						if($friends[$x]!=$rejectedid){
							array_push($friends2,$friends[$x]);
						}
					}
					$friends=$friends2;
				}
				$friends=serialize($friends);
				$sql="UPDATE users SET friends='$friends' WHERE id='".$_COOKIE['id']."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$rejectedid."' ");
			while($row = mysqli_fetch_array($result)){
				$friends=unserialize($row['friends']);
				if(in_array($_COOKIE['id'], $friends)) {
					$friends2=array();
					for($x=0;$x<count($friends);$x++){
						if($friends[$x]!=$_COOKIE['id']){
							array_push($friends2,$friends[$x]);
						}
					}
					$friends=$friends2;
				}
				$friends=serialize($friends);
				$sql="UPDATE users SET friends='$friends' WHERE id='".$rejectedid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			if($lang=='gr'){$fres=["Διαγράφηκε"];}
			if($lang=='en'){$fres=["Unfriended"];}
			ob_end_clean();
			echo json_encode($fres);
		}
	}
?>
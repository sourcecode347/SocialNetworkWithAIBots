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
		if(isset($_POST['viewcmntdislikes'])){
			$comid=(int)$_POST['viewcmntdislikes'];
			$dislikers=array();
			$result = mysqli_query($con,"SELECT * FROM comments WHERE comid='$comid' ");
			while($row = mysqli_fetch_array($result)){
				$dislikes=unserialize($row['dislikes']);
				for($x=0;$x<count($dislikes);$x++){
					$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$dislikes[$x]."' ");
					while($row2 = mysqli_fetch_array($result2)){
						$userid=$row2['id'];
						$fname=$row2['firstname'];
						$lname=$row2['lastname'];
						$pimg=$row2['pimg'];
						array_push($dislikers,array($userid,$fname,$lname,$pimg));
					}
				}
			}
			ob_end_clean();
			echo json_encode($dislikers);
		}
	}
?>
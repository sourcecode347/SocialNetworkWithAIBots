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
		if(isset($_POST['unviewcomments'])){
			$coms=array();
			$subcoms=array();
			$result = mysqli_query($con,"SELECT * FROM comments WHERE postid='".$_POST['unviewcomments']."' ");
			while($row = mysqli_fetch_array($result)){
				array_push($coms,$row['comid']);
			}
			$result = mysqli_query($con,"SELECT * FROM subcomments WHERE postid='".$_POST['unviewcomments']."' ");
			while($row = mysqli_fetch_array($result)){
				array_push($subcoms,$row['subcomid']);
			}
			$allcoms=array($coms,$subcoms);
			ob_end_clean();
			echo json_encode($allcoms);			
		}
	}
?>
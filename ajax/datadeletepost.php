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
		if(isset($_POST['postid'])){
			$postid=$_POST['postid'];
			$result = mysqli_query($con,"SELECT * FROM posts WHERE postid='".$postid."' ");
			while($row = mysqli_fetch_array($result)){
				$userid=$row['userid'];
				$posttype=$row['posttype'];
				$imgsrc=$row['imgsrc'];
			}
			if($userid==$_COOKIE['id']){
				if($posttype=="image"){
					unlink("../".$imgsrc);
				}
				$sql="DELETE FROM posts WHERE postid='".$postid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				$sql="DELETE FROM comments WHERE postid='".$postid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				$sql="DELETE FROM subcomments WHERE postid='".$postid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				$sql="DELETE FROM notifications WHERE postid='".$postid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			ob_end_clean();
			echo json_encode($postid);			
		}
	}
?>
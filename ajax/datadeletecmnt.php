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
			$result = mysqli_query($con,"SELECT * FROM comments WHERE comid='".$comid."' ");
			while($row = mysqli_fetch_array($result)){
				$postid=$row['postid'];
			}
			$result = mysqli_query($con,"SELECT * FROM posts WHERE postid='".$postid."' ");
			while($row = mysqli_fetch_array($result)){
				$comments=unserialize($row['comments']);
			}
			if(in_array($comid,$comments)){
				$comments2=array();
				for($x=0;$x<count($comments);$x++){
					if($comments[$x]!=$comid){
						array_push($comments2,$comid);
					}
				}
				$comments=$comments2;
			}
			$comments=serialize($comments);
			$sql="UPDATE posts SET comments='".$comments."' WHERE postid='".$postid."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			$sql="DELETE FROM comments WHERE userid='".$_COOKIE['id']."' AND comid='".$comid."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			$sql="DELETE FROM subcomments WHERE comid='".$comid."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			ob_end_clean();
			echo json_encode($comid);			
		}
	}
?>
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
		if(isset($_POST['subdislikeaction'])){
			$subcomid=(int)$_POST['subdislikeaction'];
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$coins=$row['coins'];
			}
			$result = mysqli_query($con,"SELECT * FROM subcomments WHERE subcomid='$subcomid' ");
			while($row = mysqli_fetch_array($result)){
				$likes=unserialize($row['likes']);
				$dislikes=unserialize($row['dislikes']);
				$profit=0;
				$puserid=$row['userid'];
				$postid=$row['postid'];
				$comid=$row['comid'];
				if(in_array($_COOKIE['id'], $likes)) {
					$likes2=array();
					for($x=0;$x<count($likes);$x++){
						if($likes[$x]!=$_COOKIE['id']){
							array_push($likes2,$likes[$x]);
						}
					}
					$likes=$likes2;
					$profit-=0.005;
				}
				if(in_array($_COOKIE['id'], $dislikes)) {
					$dislikes2=array();
					for($x=0;$x<count($dislikes);$x++){
						if($dislikes[$x]!=$_COOKIE['id']){
							array_push($dislikes2,$dislikes[$x]);
						}
					}
					$dislikes=$dislikes2;
					$profit-=0.005;
				}else{
					array_push($dislikes,$_COOKIE['id']);
					$profit+=0.005;
					$notid=0;
					$result2 = mysqli_query($con,"SELECT * FROM notifications ORDER BY notid DESC ");
					while($row2 = mysqli_fetch_array($result2)){
						$notid=(int)$row2['notid']+1;
						break;
					}
					$sql="INSERT INTO notifications (userid, actor ,postid ,comid , subcomid ,notid,likes,dislikes,comments,subcomments,clicked,spectator)
					VALUES ('".$puserid."','".$_COOKIE['id']."','".$postid."','".$comid."','".$subcomid."','".$notid."',".((int) false).",".((int) true).",".((int) false).",".((int) false).",".((int) false).",".((int) false).")";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				}
				$dislikes=serialize($dislikes);
				$likes=serialize($likes);
				$coins+=$profit;
				$sql="UPDATE users SET coins='$coins' WHERE id='".$_COOKIE['id']."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				$sql="UPDATE subcomments SET likes='$likes' WHERE subcomid='".$subcomid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				$sql="UPDATE subcomments SET dislikes='$dislikes' WHERE subcomid='".$subcomid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
		}
	}
?>
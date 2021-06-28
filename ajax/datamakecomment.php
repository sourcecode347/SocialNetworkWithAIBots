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
		if(isset($_POST['mcid'])){
			$mcid=$_POST['mcid'];
			$xcom=str_replace("XMP"," 3:) ",$_POST['xcom']);
			$xcom=str_replace("xmp"," 3:) ",$xcom);
			$xcom=str_replace("'","",$xcom);
			$mcid=str_replace("'","",$mcid);
			if (strlen(str_replace(" ","",$xcom))!=0){
				$likes=serialize(array());
				$dislikes=serialize(array());
				$subcomments=serialize(array());
				$comid=1;
				$result = mysqli_query($con,"SELECT * FROM comments ORDER BY comid DESC");
				while($row = mysqli_fetch_array($result)){
					$comid=$row['comid']+1;
					break;
				}
				$sql="INSERT INTO comments (userid,postid,comid,xpost,date,timezone,likes,dislikes,subcomments)
				VALUES ('".$_COOKIE['id']."','$mcid','$comid','$xcom','".datenow($_COOKIE['timezone'])."','".$_COOKIE['timezone']."',
				'".$likes."','".$dislikes."','".$subcomments."')";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				$result = mysqli_query($con,"SELECT * FROM posts WHERE postid='$mcid' ");
				while($row = mysqli_fetch_array($result)){
					$comments2=unserialize($row['comments']);
					array_push($comments2,$comid);
					$comments=serialize($comments2);
					$sql="UPDATE posts SET comments='$comments' WHERE postid='".$mcid."' ";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					#Notification
					$puserid=$row['userid'];
					$notid=getnotid();
					$sql="INSERT INTO notifications (userid, actor ,postid ,comid , subcomid ,notid,likes,dislikes,comments,subcomments,clicked,spectator)
					VALUES ('".$puserid."','".$_COOKIE['id']."','".$mcid."','0','0','".$notid."',".((int) false).",".((int) false).",".((int) true).",".((int) false).",".((int) false).",".((int) false).")";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					$uniqueusers=array();
					$result = mysqli_query($con,"SELECT * FROM comments WHERE postid='$mcid' ");
					while($row = mysqli_fetch_array($result)){
						$cuserid=$row['userid'];
						if(!in_array($cuserid, $uniqueusers)) {
							if($puserid!=$cuserid){
								$notid=getnotid();
								$sql="INSERT INTO notifications (userid, actor ,postid ,comid , subcomid ,notid,likes,dislikes,comments,subcomments,clicked,spectator)
								VALUES ('".$cuserid."','".$_COOKIE['id']."','".$mcid."','0','0','".$notid."',".((int) false).",".((int) false).",".((int) true).",".((int) false).",".((int) false).",".((int) true).")";
								if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}								
							}
						}
						array_push($uniqueusers,$cuserid);
					}
				}
			}
			$fres="Ok";
			ob_end_clean();
			echo json_encode($fres);		
		}
	}
?>
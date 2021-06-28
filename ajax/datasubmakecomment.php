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
		if(isset($_POST['submcid'])){
			$comid=(int)$_POST['submcid'];
			$xcom=str_replace("XMP"," 3:) ",$_POST['subxcom']);
			$xcom=str_replace("xmp"," 3:) ",$xcom);
			$xcom=str_replace("'","",$xcom);
			$comid=str_replace("'","",$comid);
			if (strlen(str_replace(" ","",$xcom))!=0){
				$likes=serialize(array());
				$dislikes=serialize(array());
				$subcomid=1;
				$result = mysqli_query($con,"SELECT * FROM subcomments ORDER BY subcomid DESC");
				while($row = mysqli_fetch_array($result)){
					$subcomid=$row['subcomid']+1;
					break;
				}
				$result = mysqli_query($con,"SELECT * FROM comments WHERE comid='$comid' ");
				while($row = mysqli_fetch_array($result)){
					$postid=$row['postid'];
					$subcomments2=unserialize($row['subcomments']);
					array_push($subcomments2,$subcomid);
					$subcomments=serialize($subcomments2);
					$sql="UPDATE comments SET subcomments='$subcomments' WHERE comid='".$comid."' ";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					#Notification
					$puserid=$row['userid'];
					$notid=getnotid();
					$sql="INSERT INTO notifications (userid, actor ,postid ,comid , subcomid ,notid,likes,dislikes,comments,subcomments,clicked,spectator)
					VALUES ('".$puserid."','".$_COOKIE['id']."','".$postid."','".$comid."','".$subcomid."','".$notid."',".((int) false).",".((int) false).",".((int) false).",".((int) true).",".((int) false).",".((int) false).")";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					$uniqueusers=array();
					$result = mysqli_query($con,"SELECT * FROM subcomments WHERE postid='$postid' ");
					while($row = mysqli_fetch_array($result)){
						$cuserid=$row['userid'];
						if(!in_array($cuserid, $uniqueusers)) {
							if($puserid!=$cuserid){
								$notid=getnotid();
								$sql="INSERT INTO notifications (userid, actor ,postid ,comid , subcomid ,notid,likes,dislikes,comments,subcomments,clicked,spectator)
								VALUES ('".$cuserid."','".$_COOKIE['id']."','".$postid."','".$comid."','".$subcomid."','".$notid."',".((int) false).",".((int) false).",".((int) false).",".((int) true).",".((int) false).",".((int) true).")";
								if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}								
							}
						}
						array_push($uniqueusers,$cuserid);
					}
				}
				$sql="INSERT INTO subcomments (userid,postid,comid,subcomid,xpost,date,timezone,likes,dislikes)
				VALUES ('".$_COOKIE['id']."','$postid','$comid','$subcomid','".$xcom."','".datenow($_COOKIE['timezone'])."','".$_COOKIE['timezone']."','".$likes."','".$dislikes."')";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			ob_end_clean();
			echo json_encode($subcomid);		
		}
	}
?>
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
		if(isset($_POST['notscoins'])){
			$notscoins=array();
			$counter=0;
			$nots=array();
			$burned=array();
			$result = mysqli_query($con,"SELECT * FROM notifications WHERE userid='".$_COOKIE['id']."' ORDER BY notid DESC");
			while($row = mysqli_fetch_array($result)){
				if($counter<31){
					$actor=$row['actor'];
					$postid=$row['postid'];
					$comid=$row['comid'];
					$subcomid=$row['subcomid'];
					$notid=$row['notid'];
					$likes=$row['likes'];
					$dislikes=$row['dislikes'];
					$clicked=$row['clicked'];
					$spec=$row['spectator'];
					$comments=$row['comments'];
					$subcomments=$row['subcomments'];
					$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$actor."' ");
					while($row2 = mysqli_fetch_array($result2)){
						$apimg=$row2['pimg'];
						$afname=$row2['firstname'];
						$alname=$row2['lastname'];
						$agen=$row2['genre'];
					}
					if($_COOKIE['id']!=$actor){
						array_push($nots,array($actor,$postid,$comid,$subcomid,$notid,$likes,$dislikes,$clicked,$spec,$apimg,$afname,$alname,$agen,$comments,$subcomments));
					}else{
						array_push($burned,$row['notid']);
						$counter-=1;
					}
				}else{
					array_push($burned,$row['notid']);
				}
				$counter+=1;
			}
			for($x=0;$x<count($burned);$x++){
				$sql="DELETE FROM notifications WHERE notid='".$burned[$x]."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$coins=number_format($row['coins'],3);
			}
			if(isset($_POST['unreadmessages'])){
				$counter=0;
				$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
				while($row = mysqli_fetch_array($result)){
					$friends=unserialize($row['friends']);
				}
				for($x=0;$x<count($friends);$x++){
					$result = mysqli_query($con,"SELECT * FROM messages WHERE actor1='".$friends[$x]."' AND actor2='".$_COOKIE['id']."' ");
					while($row = mysqli_fetch_array($result)){
						if($row['readed']==False){
							$counter+=1;
						}
					}
				}
				array_push($notscoins,$nots,$coins,$counter);
			}else{
				array_push($notscoins,$nots,$coins);
			}
			ob_end_clean();
			echo json_encode($notscoins);
		}
	}
?>
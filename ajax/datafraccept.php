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
		if(isset($_POST['fraccept'])){
			$acceptedid=$_POST['fraccept'];
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			$fdata=array();
			while($row = mysqli_fetch_array($result)){
				$frequest=unserialize($row['frequest']);
				if(in_array($acceptedid, $frequest)) {
					$frequest2=array();
					for($x=0;$x<count($frequest);$x++){
						if($frequest[$x]!=$acceptedid){
							array_push($frequest2,$frequest[$x]);
						}
					}
					$frequest=$frequest2;
				}
				$frequest=serialize($frequest);
				$sql="UPDATE users SET frequest='$frequest' WHERE id='".$_COOKIE['id']."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				
				$friends=unserialize($row['friends']);
				array_push($friends,$acceptedid);
				$friends=serialize($friends);
				$sql="UPDATE users SET friends='$friends' WHERE id='".$_COOKIE['id']."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$acceptedid."' ");
			$fdata=array();
			while($row = mysqli_fetch_array($result)){
				$frequest=unserialize($row['frequest']);
				if(in_array($_COOKIE['id'], $frequest)) {
					$frequest2=array();
					for($x=0;$x<count($frequest);$x++){
						if($frequest[$x]!=$_COOKIE['id']){
							array_push($frequest2,$frequest[$x]);
						}
					}
					$frequest=$frequest2;
				}
				$frequest=serialize($frequest);
				$sql="UPDATE users SET frequest='$frequest' WHERE id='".$acceptedid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				
				$friends=unserialize($row['friends']);
				array_push($friends,$_COOKIE['id']);
				$friends=serialize($friends);
				$sql="UPDATE users SET friends='$friends' WHERE id='".$acceptedid."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			ob_end_clean();
			echo json_encode("Ok");
		}
	}
?>
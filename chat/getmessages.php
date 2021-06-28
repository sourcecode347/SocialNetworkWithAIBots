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
		if(isset($_POST['actor1'])){
			$msgdata=array();
			$counter=0;
			$burned=array();
			$result = mysqli_query($con,"SELECT * FROM messages WHERE actor1='".$_POST['actor1']."' AND actor2='".$_POST['actor2']."' OR actor1='".$_POST['actor2']."' AND actor2='".$_POST['actor1']."' ORDER BY mesid DESC");
			while($row = mysqli_fetch_array($result)){
				$counter+=1;
				if($counter<31){
					$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$row['actor1']."' ");
					while($row2 = mysqli_fetch_array($result2)){
						$pimg=$row2['pimg'];
						$fname=$row2['firstname'];
						$lname=$row2['lastname'];
					}
					array_push($msgdata,array($row['actor1'],$row['mesid'],$row['message'],convertdate($row['date'],$row['timezone'],$_COOKIE['timezone']),$pimg,$fname,$lname));
				}else{
					array_push($burned,$row['mesid']);
				}
			}
			for($x=0;$x<count($burned);$x++){
				$sql="DELETE FROM messages WHERE mesid='".$burned[$x]."' ";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			$sql="UPDATE messages SET readed='".((int) true)."' WHERE actor1='".$_POST['actor2']."' AND actor2='".$_POST['actor1']."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			ob_end_clean();
			echo json_encode($msgdata);			
		}
	}
?>
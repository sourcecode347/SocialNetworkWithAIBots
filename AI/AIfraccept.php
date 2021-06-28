<?php
ob_start();
include("../mysql.php"); 
	header('Content-Type: application/json', true);
	if( (isset($_POST['id'])) and ($_POST['pass']=="AI@@@///!!!") ){
		$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_POST['id']."' ");
		$fdata=array();
		while($row = mysqli_fetch_array($result)){
			$friends=unserialize($row['friends']);
			$frequest=unserialize($row['frequest']);
			for($x=0;$x<count($frequest);$x++){
				if(!in_array($frequest[$x], $friends)){
					array_push($friends,$frequest[$x]);
					$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$frequest[$x]."' ");
					while($row2 = mysqli_fetch_array($result2)){
						$friends2=unserialize($row2['friends']);
						if(!in_array($_POST['id'], $friends2)){
							array_push($friends2,$_POST['id']);
						}
						$friends2=serialize($friends2);
						$sql="UPDATE users SET friends='$friends2' WHERE id='".$frequest[$x]."' ";
						if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					}
				}
			}
			$frequest=serialize(array());
			$sql="UPDATE users SET frequest='$frequest' WHERE id='".$_POST['id']."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			$friends=serialize($friends);
			$sql="UPDATE users SET friends='$friends' WHERE id='".$_POST['id']."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
		}
		ob_end_clean();
		echo json_encode("Ok");
	}
?>
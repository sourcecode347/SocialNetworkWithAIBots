<?php
ob_start();
include("../mysql.php");
	if( (isset($_POST['id'])) and ($_POST['pass']=="AI@@@///!!!") ){
		$result = mysqli_query($con,"SELECT * FROM users WHERE NOT id='".$_POST['id']."' ORDER BY RAND() LIMIT 1");
		while($row = mysqli_fetch_array($result)){
				$otherid=$row['id'];
				$frequest=unserialize($row['frequest']);
				$friends=unserialize($row['friends']);
				$blocked=unserialize($row['blocked']);
				if ( (!in_array($_POST['id'], $frequest)) and (!in_array($_POST['id'], $blocked)) and (!in_array($_POST['id'], $friends)) ){
					array_push($frequest,$_POST['id']);
					$frequest=serialize($frequest);
					$sql="UPDATE users SET frequest='$frequest' WHERE id='".$otherid."' ";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				}
		}
		$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_POST['id']."' ");
		while($row = mysqli_fetch_array($result)){
			$blocked=unserialize($row['blocked']);
			$othersblock=unserialize($row['othersblock']);
			$friends=unserialize($row['friends']);
		}
		$friends2=array();
		for($x=0;$x<count($friends);$x++){
			if( (in_array($friends[$x],$blocked)==false) and (in_array($friends[$x],$othersblock)==false) ){
				array_push($friends2,$friends[$x]);
			}
		}
		if(count($friends)!=count($friends2)){
			$friends=serialize($friends2);
			$sql="UPDATE users SET friends='".$friends."' WHERE id='".$_POST['id']."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
		}
		$fres="ok";
		ob_end_clean();
		echo json_encode($fres);
	}
?>
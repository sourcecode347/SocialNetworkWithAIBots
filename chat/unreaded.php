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
		if(isset($_POST['unreaded'])){
			$unreaded=array();
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$friends=unserialize($row['friends']);
			}
			for($x=0;$x<count($friends);$x++){
				$counter=0;
				$result = mysqli_query($con,"SELECT * FROM messages WHERE actor1='".$friends[$x]."' AND actor2='".$_COOKIE['id']."' ");
				while($row = mysqli_fetch_array($result)){
					if($row['readed']==False){
						$counter+=1;
					}
				}
				array_push($unreaded,array($friends[$x],$counter));
			}
			ob_end_clean();
			echo json_encode($unreaded);			
		}
	}
?>
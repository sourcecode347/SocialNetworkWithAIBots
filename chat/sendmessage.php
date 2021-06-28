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
		if(isset($_POST['msgid'])){
			$_POST['msgid']=str_replace("'","",$_POST['msgid']);
			$_POST['message']=str_replace("'","",$_POST['message']);
			$_POST['message']=str_replace("xmp","",$_POST['message']);
			$_POST['message']=str_replace("XMP","",$_POST['message']);
			if( (mb_strlen(str_replace(" ","",$_POST['message']))>0) and (mb_strlen(trim(preg_replace('/\s\s+/', ' ', $_POST['message'])))>0) ){
				$mesid=0;
				$result = mysqli_query($con,"SELECT * FROM messages ORDER BY mesid DESC");
				while($row = mysqli_fetch_array($result)){
					$mesid=$row['mesid']+1;
					break;
				}
				$sql="INSERT INTO messages (actor1, actor2 ,mesid ,message, readed ,date, timezone)
				VALUES ('".$_COOKIE['id']."' , '".$_POST['msgid']."' , '".$mesid."' , '".$_POST['message']."' , ".((int) false)." , '".datenow($_COOKIE['timezone'])."' , '".$_COOKIE['timezone']."' )";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			ob_end_clean();
			echo json_encode($mesid);			
		}
	}
?>
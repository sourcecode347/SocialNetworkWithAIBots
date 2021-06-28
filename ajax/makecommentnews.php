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
		if(isset($_POST['mcnid'])){
			$mcnid=$_POST['mcnid'];
			$xcom=str_replace("XMP"," 3:) ",$_POST['xcom']);
			$xcom=str_replace("xmp"," 3:) ",$xcom);
			$xcom=str_replace("'","",$xcom);
			$mcnid=str_replace("'","",$mcnid);
			if (strlen(str_replace(" ","",$xcom))!=0){
				$cid=1;
				$result = mysqli_query($con,"SELECT * FROM newscmnt ORDER BY cid DESC");
				while($row = mysqli_fetch_array($result)){
					$cid=$row['cid']+1;
					break;
				}
				$sql="INSERT INTO newscmnt (userid,nid,cid,xpost,date,timezone)
				VALUES ('".$_COOKIE['id']."','$mcnid','$cid','$xcom','".datenow($_COOKIE['timezone'])."','".$_COOKIE['timezone']."')";
				if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			}
			$fres="Ok";
			ob_end_clean();
			echo json_encode($fres);		
		}
	}
?>
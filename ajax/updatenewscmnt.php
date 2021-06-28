<?php
ob_start();
include("../mysql.php"); 
include_once("../login.php"); 
include_once("../lang.php");
include_once("../precode.php");
include_once("../timezones.php");
	header('Content-Type: application/json', true);
	if(isset($_POST['newscmnt'])){
		$newsid=null;
		$result = mysqli_query($con,"SELECT * FROM news ORDER BY id DESC");
		while($row = mysqli_fetch_array($result)){
			if($_POST['newscmnt']==$row['id']){
				$newsid=$row['id'];
				break;
			}
		}
		$cmntdata=array();
		if($newsid!=null){
			$result = mysqli_query($con,"SELECT * FROM newscmnt WHERE nid='$newsid' ");
			while($row = mysqli_fetch_array($result)){
				$userid=$row['userid'];
				$cmntpostid2=$row['nid'];
				$comid=$row['cid'];
				$xpost=$row['xpost'];
				if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
					and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
					and (securelogin()==true) ) {
					$dtime=convertdate($row['date'],$row['timezone'],$_COOKIE['timezone']);
				}else{
					$dtime=$row['date'];
				}
				$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='$userid' ");
				while($row2 = mysqli_fetch_array($result2)){
					$fname=$row2['firstname'];
					$lname=$row2['lastname'];
					$pimg=$row2['pimg'];
					$gen=$row2['genre'];
				}
				array_push($cmntdata,array($userid,$fname,$lname,$pimg,$comid,$xpost,$dtime,$cmntpostid2,$gen));
			}
		}
		ob_end_clean();
		echo json_encode($cmntdata);			
	}
?>
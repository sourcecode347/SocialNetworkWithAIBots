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
		if(isset($_POST['subid'])){
			$subcomid=$_POST['subid'];
			$result = mysqli_query($con,"SELECT * FROM subcomments WHERE subcomid='$subcomid' ");
			while($row = mysqli_fetch_array($result)){
				$comid=$row['comid'];
			}
			$result = mysqli_query($con,"SELECT * FROM comments WHERE comid='$comid' ");
			while($row = mysqli_fetch_array($result)){
				$subcomments=unserialize($row['subcomments']);
			}
			$subcomments2=array();
			for($x=0;$x<count($subcomments);$x++){
				if($subcomments[$x]!=$subcomid){
					array_push($subcomments2,$subcomments[$x]);
				}
			}
			$subcomments=serialize($subcomments2);
			$sql="UPDATE comments SET subcomments='".$subcomments."' WHERE comid='".$comid."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			$sql="DELETE FROM subcomments WHERE userid='".$_COOKIE['id']."' AND subcomid='".$subcomid."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			ob_end_clean();
			echo json_encode($subcomid);			
		}
	}
?>
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
		if(isset($_POST['lds'])){
			$flowdata=array();
			$ldsdata=array();
			for($x=0;$x<count($_POST['lds']);$x++){
				$postid=(int)$_POST['lds'][$x];
				$result = mysqli_query($con,"SELECT * FROM posts WHERE postid='$postid' ");
				while($row = mysqli_fetch_array($result)){
					$likes=unserialize($row['likes']);
					$dislikes=unserialize($row['dislikes']);
					$shares=unserialize($row['shares']);
					$comments=unserialize($row['comments']);
					array_push($ldsdata,array($likes,$dislikes,$shares,$postid,$comments));
				}
			}
			$cmntldsdata=array();
			for($x=0;$x<count($_POST['cmntlds']);$x++){
				$comid=(int)$_POST['cmntlds'][$x];
				$result = mysqli_query($con,"SELECT * FROM comments WHERE comid='$comid' ");
				while($row = mysqli_fetch_array($result)){
					$likes=unserialize($row['likes']);
					$dislikes=unserialize($row['dislikes']);
					$subcomments=unserialize($row['subcomments']);
					array_push($cmntldsdata,array($likes,$dislikes,$comid,$subcomments));
				}
			}
			$subldsdata=array();
			for($x=0;$x<count($_POST['sublds']);$x++){
				$subcomid=(int)$_POST['sublds'][$x];
				$result = mysqli_query($con,"SELECT * FROM subcomments WHERE subcomid='$subcomid' ");
				while($row = mysqli_fetch_array($result)){
					$likes=unserialize($row['likes']);
					$dislikes=unserialize($row['dislikes']);
					array_push($subldsdata,array($likes,$dislikes,$subcomid));
				}
			}
			$cmntdata=array();
			for($x=0;$x<count($_POST['cmnt']);$x++){
				$cmntpostid=(int)$_POST['cmnt'][$x];
				$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
				while($row = mysqli_fetch_array($result)){
					$blocked=unserialize($row['blocked']);
					$othersblock=unserialize($row['othersblock']);
				}
				$result = mysqli_query($con,"SELECT * FROM comments WHERE postid='$cmntpostid' ");
				while($row = mysqli_fetch_array($result)){
					$likes=unserialize($row['likes']);
					$dislikes=unserialize($row['dislikes']);
					$subcomments=unserialize($row['subcomments']);
					$userid=$row['userid'];
					$cmntpostid2=$row['postid'];
					$comid=$row['comid'];
					$xpost=$row['xpost'];
					$dtime=convertdate($row['date'],$row['timezone'],$_COOKIE['timezone']);
					if ( (!in_array($userid,$blocked)) and (!in_array($userid,$othersblock)) ){
						$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='$userid' ");
						while($row2 = mysqli_fetch_array($result2)){
							$fname=$row2['firstname'];
							$lname=$row2['lastname'];
							$pimg=$row2['pimg'];
							$gen=$row2['genre'];
						}
						array_push($cmntdata,array($likes,$dislikes,$subcomments,$userid,$fname,$lname,$pimg,$comid,$xpost,$dtime,$cmntpostid2,$gen));
					}
				}
			}
			$subdata=array();
			for($x=0;$x<count($_POST['subcmnt']);$x++){
				$subpostid=$_POST['subcmnt'][$x];
				$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
				while($row = mysqli_fetch_array($result)){
					$blocked=unserialize($row['blocked']);
					$othersblock=unserialize($row['othersblock']);
				}
				$result = mysqli_query($con,"SELECT * FROM subcomments WHERE comid='$subpostid' ");
				while($row = mysqli_fetch_array($result)){
					$likes=unserialize($row['likes']);
					$dislikes=unserialize($row['dislikes']);
					$userid=$row['userid'];
					$subpostid2=$row['postid'];
					$comid=$row['comid'];
					$subcomid=$row['subcomid'];
					$xpost=$row['xpost'];
					$dtime=convertdate($row['date'],$row['timezone'],$_COOKIE['timezone']);
					if ( (!in_array($userid,$blocked)) and (!in_array($userid,$othersblock)) ){
						$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='$userid' ");
						while($row2 = mysqli_fetch_array($result2)){
							$fname=$row2['firstname'];
							$lname=$row2['lastname'];
							$pimg=$row2['pimg'];
							$gen=$row2['genre'];
						}
						array_push($subdata,array($likes,$dislikes,$userid,$fname,$lname,$pimg,$comid,$xpost,$dtime,$subpostid2,$gen,$subcomid));
					}
				}
			}
			$posts=array();
			$postscounter=0;
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$friends=unserialize($row['friends']);
				$blocked=unserialize($row['blocked']);
				$othersblock=unserialize($row['othersblock']);
			}
			$result = mysqli_query($con,"SELECT * FROM posts ORDER BY counter DESC ");
			while($row = mysqli_fetch_array($result)){
				if ( (($row['userid']==$_COOKIE['id'])  or (in_array($row['userid'],$friends)) or ($row['super']=="true") ) 
				and (!in_array($row['userid'],$blocked)) and (!in_array($row['userid'],$othersblock)) ){
					if ($postscounter==1000){break;}
					array_push($posts,$row['postid']);
					$postscounter+=1;
				}
			}
			array_push($flowdata,$ldsdata,$cmntldsdata,$subldsdata,$cmntdata,$subdata,$posts);
			ob_end_clean();
			echo json_encode($flowdata);			
		}
	}
?>
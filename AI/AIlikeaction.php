<?php
ob_start();
include("../mysql.php"); 
	header('Content-Type: application/json', true);
	if( (isset($_POST['id'])) and ($_POST['pass']=="AI@@@///!!!") ){
		$result = mysqli_query($con,"SELECT * FROM posts WHERE NOT userid='".$_POST['id']."' ORDER BY RAND() LIMIT 20");
		while($row = mysqli_fetch_array($result)){
			$likes=unserialize($row['likes']);
			$dislikes=unserialize($row['dislikes']);
			$puserid=$row['userid'];
			$postid=$row['postid'];
			$super=$row['super'];
			$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$puserid."' ");
			while($row2 = mysqli_fetch_array($result2)){
				$friends2=unserialize($row2['friends']);
				$blocked2=unserialize($row2['blocked']);
				if ((!in_array($_POST['id'], $blocked2)) and ( (in_array($_POST['id'], $friends2)) or ($super=="true") ) ){
					if(in_array($_POST['id'], $dislikes)) {
						$dislikes2=array();
						for($x=0;$x<count($dislikes);$x++){
							if($dislikes[$x]!=$_POST['id']){
								array_push($dislikes2,$dislikes[$x]);
							}
						}
						$dislikes=$dislikes2;
					}
					if(!in_array($_POST['id'], $likes)) {
						array_push($likes,$_POST['id']);
						$notid=0;
						$result3 = mysqli_query($con,"SELECT * FROM notifications ORDER BY notid DESC ");
						while($row3 = mysqli_fetch_array($result3)){
							$notid=(int)$row3['notid']+1;
							break;
						}
						$sql="INSERT INTO notifications (userid, actor ,postid ,comid , subcomid ,notid,likes,dislikes,comments,subcomments,clicked,spectator)
						VALUES ('".$puserid."','".$_POST['id']."','".$postid."','0','0','".$notid."',".((int) true).",".((int) false).",".((int) false).",".((int) false).",".((int) false).",".((int) false).")";
						if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					}
					$dislikes=serialize($dislikes);
					$likes=serialize($likes);
					$sql="UPDATE posts SET likes='$likes' WHERE postid='".$postid."' ";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					$sql="UPDATE posts SET dislikes='$dislikes' WHERE postid='".$postid."' ";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				}
			}
		}
		ob_end_clean();
		echo json_encode("Ok");
	}
?>
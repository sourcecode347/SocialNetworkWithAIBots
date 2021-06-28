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
		if (isset($_POST['getposts'])){
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
					$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$row['userid']."' ");
					while($row2 = mysqli_fetch_array($result2)){
						$pfname=$row2['firstname'];
						$plname=$row2['lastname'];
						$ppimg=$row2['pimg'];
						$pgen=$row2['genre'];
					}
					$src="false";
					if ( ($row['posttype']=='link') and ($row['metaimg']=='true') ){
						$result2 = mysqli_query($con,"SELECT * FROM links WHERE link='".$row['metalink']."' ");
						while($row2 = mysqli_fetch_array($result2)){
							$src=$row2['imgsrc'];
						}
					}
					$post = array($row['userid'],$row['postid'],$row['counter'],$row['xpost'],$row['posttype'],$row['metaimg'],
					$row['metatitle'],$row['metadesc'],$row['metalink'],$row['metahost'],$row['videoid'],$row['imgsrc'],
					unserialize($row['likes']),unserialize($row['dislikes']),unserialize($row['comments']),unserialize($row['shares']),$row['shareid'],
					convertdate($row['date'],$row['timezone'],$_COOKIE['timezone']),$row['timezone'],$row['super'],
					$pfname,$plname,$ppimg,$pgen,$src);
					$postscounter=$postscounter+1;
					if ($postscounter==100){break;}
					array_push($posts,$post);
				}
			}
			ob_end_clean();
			echo json_encode($posts);
		}
	}
?>
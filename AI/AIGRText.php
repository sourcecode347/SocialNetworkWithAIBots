<?php
ob_start();
include("../mysql.php"); 
include("../timezones.php"); 
	header('Content-Type: application/json', true);
	if( (isset($_POST['id'])) and ($_POST['pass']=="AI@@@///!!!") and (isset($_POST['xpost'])) ){
		$metaimg="false";
		$metatitle = "false";
		$metadesc = "false";
		$metalink = "false";
		$metahost = "false";
		$result = mysqli_query($con,"SELECT * FROM posts order by postid desc");
		$pcounter=0;
		while($row = mysqli_fetch_array($result)){
			$postid=$row['postid']+1;
			$pcounter=1;
			break;
		}
		if($pcounter==0){$postid=1;}
		$result = mysqli_query($con,"SELECT * FROM posts order by counter desc");
		$c=0;
		while($row = mysqli_fetch_array($result)){
			$counter=$row['counter']+1;
			$c=1;
			break;
		}
		if($c==0){$counter=1;}
		$likes=serialize(array());
		$dislikes=serialize(array());
		$comments=serialize(array());
		$shares=serialize(array());
		$sss=rand(0,7);
		if($sss==0){
			$super="true";
		}else{
			$super="false";
		}
		$sql="INSERT INTO posts (userid,postid,counter,xpost,posttype,metaimg,metatitle,metadesc,metalink,metahost,videoid,imgsrc,
		likes,dislikes,comments,shares,shareid,date,timezone,super)
		VALUES ('".$_POST['id']."','$postid','$counter','".$_POST['xpost']."','text','".$metaimg."',
		'".$metatitle."','".$metadesc."','".$metalink."','".$metahost."','false',
		'false','$likes','$dislikes','$comments','$shares','false','".datenow("Europe/Athens")."','Europe/Athens','".$super.".')";
		if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
	}
	ob_end_clean();
	echo json_encode("Ok");
?>
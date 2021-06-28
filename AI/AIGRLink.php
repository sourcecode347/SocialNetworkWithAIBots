<?php
ob_start();
include("../mysql.php"); 
include("../timezones.php"); 
	header('Content-Type: application/json', true);
	function newimgsrc($ext){
		$run=1;
		while($run==1){
			$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
			$id="";
			for($x=0;$x<64;$x++){
				$id=$id.$char[rand(0,count($char)-1)];
			}
			include('../mysql.php');
			$result = mysqli_query($con,"SELECT * FROM links ");
			$testid=0;
			$newimgsrc="linkimg/".$id.".".$ext;
			while($row = mysqli_fetch_array($result)){
				if($newimgsrc==$row['imgsrc']){
					$testid=1;
				}
			}
			if($testid==0){
				$run=0;
				break;
			}
		}
		return $newimgsrc;
	}
	if( (isset($_POST['id'])) and ($_POST['pass']=="AI@@@///!!!") and (isset($_POST['gen'])) ){
		if ($_POST['gen']=="Male"){
				$result = mysqli_query($con,"select * from ( select * from news where lang='gr' order by id desc limit 10 ) as lastest_results order by rand() limit 1");
		}
		if ($_POST['gen']=="Female"){
				$result = mysqli_query($con,"select * from ( select * from news where lang='gr' and not cat='Sports' order by id desc limit 10 ) as lastest_results order by rand() limit 1");
		}
		while($row = mysqli_fetch_array($result)){
			$nid = $row['id'];
			$nimg = $row['img'];
			$metaimg="true";
			$metatitle = $row['title'];
			$metadesc = mb_substr($row['body'],0,147);
			$metalink = "https://fullhood.com/news.php?nid=".$nid."&lang=gr";
			$metahost = "www.fullhood.com";
		}
		$result = mysqli_query($con,"SELECT * FROM links WHERE link='".$metalink."'");
		while($row = mysqli_fetch_array($result)){
			unlink("../".$row['imgsrc']);
		}
		$sql="DELETE FROM links WHERE link='".$metalink."' ";
		if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
		$ext = pathinfo("../".$nimg, PATHINFO_EXTENSION);
		$newimg=newimgsrc($ext);
		copy("../".$nimg,"../".$newimg);
		$sql="INSERT INTO links (link,imgsrc) VALUES ('$metalink','$newimg')";
		if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
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
		$sql="INSERT INTO posts (userid,postid,counter,xpost,posttype,metaimg,metatitle,metadesc,metalink,metahost,videoid,imgsrc,
		likes,dislikes,comments,shares,shareid,date,timezone,super)
		VALUES ('".$_POST['id']."','$postid','$counter','".$metalink."','link','".$metaimg."',
		'".$metatitle."','".$metadesc."','".$metalink."','".$metahost."','false',
		'false','$likes','$dislikes','$comments','$shares','false','".datenow("Europe/Athens")."','Europe/Athens','false')";
		if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
	}
	ob_end_clean();
	echo json_encode("Ok");
?>
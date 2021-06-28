<?php 
include("mysql.php"); 
include_once("login.php"); 
include_once("lang.php");
include_once("precode.php");
include_once("timezones.php");
?>
<!DOCTYPE html>
<!--

MIT License

Copyright (c) 2021 Nikolaos Bazigos

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

https://github.com/sourcecode347/SocialNetworkWithAIBots

Official Website:
https://sourcecode347.com

Youtube Channel:
https://youtube.com/sourcecode347

-->
<html>
	<head>
		<link rel="stylesheet" href="styles.css">
		<title><?php echo $profilename; ?></title>
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
		<link rel="alternate" href="https://fullhood.com/index.php" hreflang="<?php echo $hreflang;?>"/>
		<meta name="robots" content="index, follow, noodp, noydir">
		<meta name="description" content="FullHood Social Network" />
		<meta property="og:image" content="https://fullhood.com/img/ogimage1024x512.png"/>
		<meta property="og:image:url" content="https://fullhood.com/img/ogimage1024x512.png"/>
		<meta property="og:image:secure_url" content="https://fullhood.com/img/ogimage1024x512.png"/>
		<meta property="og:image:width" content="512"/>
		<meta property="og:image:height" content="256"/>
		<meta property="og:image:alt" content="FullHood Social Network"/>
		<meta property="og:title" content="FullHood Social Network"/>
		<meta property="og:description" content="FullHood Social Network"/>
		<meta property="og:url" content="https://fullhood.com"/>
		<meta name="keywords" content="fullhood,full,hood"/>
		<meta name='yandex-verification' content='' />
		<meta name="alexaVerifyID" content=""/>
		<meta name="google-site-verification" content="BNYY2FnoBtgXmdgE3yO7aIf-FSnTZyS17I0idZETuy0" />
		<meta name="msvalidate.01" content="C6645F360922FC2DB3F085129F7A1E51" />
		<meta name="distribution" content="web"/>
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
		<!--meta name="viewport" content="height=device-height, initial-scale=0.33"-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>	
	<!--body style='background-image: radial-gradient(#ffffff, #80ccff, #0099ff);width:100%;height:100%;'-->
	<body style='background-image: radial-gradient(#20C20E, #282828, #000000);width:100%;height:100%;'>
    <canvas id="canvas">Canvas is not supported in your browser.</canvas>
    <canvas id="canvas2">Canvas is not supported in your browser.</canvas>
		<center>
		<div id='content'>
			<center>			
				<?php
					if(isset($_GET['id'])){
						$result = mysqli_query($con,"SELECT * FROM users ");
						$getid="false";
						while($row = mysqli_fetch_array($result)){
							if($row['id']==$_GET['id']){
								$getid=$row['id'];
								
							}
						}
						$_GET['id']=$getid;
						$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$getid."' ");
						$idexists=false;
						while($row = mysqli_fetch_array($result)){
							$idexists=true;
							$otherid=$row['id'];
							$profilepic=$row['pimg'];
							$profilewall=$row['pwall'];
							$profilename=$row['firstname']." ".$row['lastname'];
						}
						if ($getid=="false"){
							header("Location: index.php");
						}
					}
					if($lang=='gr'){
						$textfrequest="Αίτημα Φιλίας";
						$textunfriend="Διαγραφή Φιλίας";
						$textviewchangeprofpic="Ενημέρωση Εικόνων";
						$changepicstext='Ενημέρωση Εικόνων Προφίλ';
						$profilepictext="Εικόνα Προφίλ";
						$wallpictext="Εικόνα Τοίχου";
						$picsubmittext="Ενημέρωση";
						$exterror='Ο τύπος του αρχείου δεν υποστηρίζεται , επιλέχτε αρχεία JPEG ή JPG ή PNG ή GIF .';
						$sizeerror='Το μέγεθος της εικόνας δεν πρέπει να ξεπερνά τα 15 MB !';
						$textfriends="Φίλοι";
						$textblock="Μπλοκάρισμα";
					}
					if($lang=='en'){
						$textfrequest="Friend Request";
						$textunfriend="Unfriend";
						$textviewchangeprofpic="Update Images";
						$changepicstext='Update Profile Pictures';
						$profilepictext="Profile Picture";
						$wallpictext="Wall Picture";
						$picsubmittext="update";
						$exterror='Extension not allowed, please choose a JPEG or JPG or PNG or GIF file.';
						$sizeerror='File size must be excately 15 MB !';
						$textfriends="Friends";
						$textblock="Block";

					}
					$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
					while($row = mysqli_fetch_array($result)){
						$blocked=unserialize($row['blocked']);
						$othersblock=unserialize($row['othersblock']);
					}
					$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$getid."' ");
					while($row = mysqli_fetch_array($result)){
						$pblocked=unserialize($row['blocked']);
						$pothersblock=unserialize($row['othersblock']);
					}
					if ( (in_array($getid,$blocked)) or (in_array($getid,$othersblock)) or (in_array($_COOKIE['id'],$pblocked)) or (in_array($_COOKIE['id'],$pothersblock)) ){
						echo "<meta http-equiv='refresh' content='0; url=index.php' />";
					}
					function profileimgsrc($ext){
						$id="profilepic";
						$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
						for($x=0;$x<64;$x++){
							$id=$id.$char[rand(0,count($char)-1)];
						}
						$newimgsrc="users/".$_COOKIE['id']."/".$id.".".$ext;
						return $newimgsrc;
					}
					function wallimgsrc($ext){
						$id="wallpic";
						$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
						for($x=0;$x<64;$x++){
							$id=$id.$char[rand(0,count($char)-1)];
						}
						$newimgsrc="users/".$_COOKIE['id']."/".$id.".".$ext;
						return $newimgsrc;
					}
					if(!function_exists("create_square_image")){
						function create_square_image($original_file, $destination_file=NULL, $square_size = 96){
							
							if(isset($destination_file) and $destination_file!=NULL){
								if(!is_writable($destination_file)){
									echo '<p style="color:#FF0000">Oops, the destination path is not writable. Make that file or its parent folder wirtable.</p>'; 
								}
							}
							
							// get width and height of original image
							$imagedata = getimagesize($original_file);
							$original_width = $imagedata[0];	
							$original_height = $imagedata[1];
							
							if($original_width > $original_height){
								$new_height = $square_size;
								$new_width = $new_height*($original_width/$original_height);
							}
							if($original_height > $original_width){
								$new_width = $square_size;
								$new_height = $new_width*($original_height/$original_width);
							}
							if($original_height == $original_width){
								$new_width = $square_size;
								$new_height = $square_size;
							}
							
							$new_width = round($new_width);
							$new_height = round($new_height);
							
							// load the image
							if(substr_count(strtolower($original_file), ".jpg") or substr_count(strtolower($original_file), ".jpeg")){
								$original_image = imagecreatefromjpeg($original_file);
							}
							if(substr_count(strtolower($original_file), ".gif")){
								$original_image = imagecreatefromgif($original_file);
							}
							if(substr_count(strtolower($original_file), ".png")){
								$original_image = imagecreatefrompng($original_file);
							}
							
							$smaller_image = imagecreatetruecolor($new_width, $new_height);
							$square_image = imagecreatetruecolor($square_size, $square_size);
							
							imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
							
							if($new_width>$new_height){
								$difference = $new_width-$new_height;
								$half_difference =  round($difference/2);
								imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
							}
							if($new_height>$new_width){
								$difference = $new_height-$new_width;
								$half_difference =  round($difference/2);
								imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
							}
							if($new_height == $new_width){
								imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
							}
							

							// if no destination file was given then display a png		
							if(!$destination_file){
								imagepng($square_image,NULL,9);
							}
							
							// save the smaller image FILE if destination file given
							if(substr_count(strtolower($destination_file), ".jpg")){
								imagejpeg($square_image,$destination_file,100);
							}
							if(substr_count(strtolower($destination_file), ".gif")){
								imagegif($square_image,$destination_file);
							}
							if(substr_count(strtolower($destination_file), ".png")){
								imagepng($square_image,$destination_file,9);
							}

							imagedestroy($original_image);
							imagedestroy($smaller_image);
							imagedestroy($square_image);

						}
					}
					if (!isset($_COOKIE['id']) and !isset($_COOKIE['fname']) and !isset($_COOKIE['lname']) and !isset($_COOKIE['gen']) 
					and !isset($_COOKIE['lang']) and !isset($_COOKIE['status']) and !isset($_COOKIE['day']) and !isset($_COOKIE['month']) and !isset($_COOKIE['year']) ){
						include_once("divregistration.php"); 
					}else if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
					and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='dead') 
					and (securelogin()==true) ){
						include_once("divactivation.php");
					}else if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
					and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
					and (securelogin()==true) ) {
						echo "
						<div id='profile'>
							<div id='pitem'>
								<img src='$profilewall' width='512' height='256' onerror=\"this.onerror=null;this.src='img/ogimage1024x512.png';\" style='width:99%;height:300px;border: 5px #20C20E solid;' />
								<img src='$profilepic' onerror=\"this.onerror=null;this.src='img/ogimage1024x512.png';\" style='border-radius:50%;width:150px;height:150px;border: 5px #20C20E solid;top:180px;left:40px;position:absolute;' /><p4 style='color:#20C20E;'>$profilename</p4>
							</div>
							<div id='changeprofilepics'>
								<form action='profile.php?id=".$_COOKIE['id']."' method='POST' enctype='multipart/form-data'>
									<input type='image'  onclick='cppclose();' src='img/close.png' style='height:30px;width:30px;float:right;' />
									<p5><b>".$changepicstext."</b></p5><br><br>
									<select name='choosepic' ><option value='profile'>".$profilepictext."</option><option value='wall'>".$wallpictext."</option></select><br><br>
									<input type='file' id='picupl' name='picupl'/><br><br>
									<img src='#' id='picview' style='width:0px;height:0px;' /><br><br>
									<input type='submit' class='cbutton' value='".$picsubmittext."'/><br><br>
								</form>
							</div>";
							if( (isset($_FILES['picupl'])) and ($_FILES['picupl']['name']!='') ){
								$errors= array();
								$file_name = $_FILES['picupl']['name'];
								$file_size =$_FILES['picupl']['size'];
								$file_tmp =$_FILES['picupl']['tmp_name'];
								$file_type=$_FILES['picupl']['type'];
								$findext=explode('.',$_FILES['picupl']['name']);
								$file_ext=strtolower(end($findext));      
								$expensions= array("jpeg","jpg","png","gif");
								if(in_array($file_ext,$expensions)=== false){
									$errors[]=$exterror;
								}
								if($file_size > 15728640){
									$errors[]=$sizeerror;
								}
								if(empty($errors)==true){
									if($_POST['choosepic']=="profile"){
										$userimgsrc=profileimgsrc($file_ext);
										move_uploaded_file($file_tmp,$userimgsrc);
										unlink($profilepic);
										$sql="UPDATE users SET pimg='$userimgsrc' WHERE id='".$_COOKIE['id']."' ";
										create_square_image($userimgsrc,$userimgsrc,500);
										shell_exec('convert '.$userimgsrc.' -resize 512x '.$userimgsrc);
										shell_exec('convert '.$userimgsrc.' -quality 50% '.$userimgsrc);
									}
									if($_POST['choosepic']=="wall"){
										$userimgsrc=wallimgsrc($file_ext);
										move_uploaded_file($file_tmp,$userimgsrc);
										unlink($profilewall);
										$sql="UPDATE users SET pwall='$userimgsrc' WHERE id='".$_COOKIE['id']."' ";
										shell_exec('convert '.$userimgsrc.' -resize 512x '.$userimgsrc);
										shell_exec('convert '.$userimgsrc.' -quality 50% '.$userimgsrc);
									}
									if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
									echo "<meta http-equiv='refresh' content='0'>";
								}else{
									for($x=0;$x<count($errors);$x++){
										echo "<div id='profilenots'><br><p5>".$errors[$x]."</p5><br></div>";
									}
								}
							}
							echo "
							<div id='profilebar'>";
								$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
								while($row = mysqli_fetch_array($result)){
										$friends=unserialize($row['friends']);
										if (!in_array($getid, $friends)) {
											if ($_COOKIE['id']!=$getid){
												echo "
												<input type='submit' id='friendrequest' class='frbutton' value=' $textfrequest ' onclick='friendrequestdef();'/> 
												<input type='submit' id='blockrequest' class='ufrbutton' value=' $textblock ' onclick='blockdef();'/> 
												<input type='hidden' id='otherid' value='$otherid''/>";
											}else{
												echo "
												<input type='submit' id='viewchangeprofpic' class='frbutton' value=' $textviewchangeprofpic ' onclick='viewchangeprofpic();'/> ";
											}
										}else{
											echo "
											<input type='submit' id='unfriendrequest' class='ufrbutton' value=' $textunfriend ' onclick='unfriendrequestdef();'/> 
											<input type='hidden' id='otherid' value='$otherid''/>";	
										}
								}
								$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$getid."' ");
								while($row = mysqli_fetch_array($result)){
										$friends=unserialize($row['friends']);
										if( (in_array($_COOKIE['id'],$friends)) or ($getid==$_COOKIE['id']) ){
											echo "<p5 onclick='viewfriendsdef();' style='margin-top:10px;float:right;margin-right:10px;cursor:pointer;'><b>".$textfriends." ( ".count($friends)." )</b></p5>";
										}
								}
							echo "
							</div>
							<div id='viewfriends'>";
								echo "<input type='image'  onclick='vfclose();' src='img/close.png' style='height:30px;width:30px;float:right;' />";
								$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$getid."' ");
								while($row2 = mysqli_fetch_array($result2)){
									$friends=unserialize($row2['friends']);
									for($x=0;$x<count($friends);$x++){
										$result3 = mysqli_query($con,"SELECT * FROM users WHERE id='".$friends[$x]."' ");
										while($row3 = mysqli_fetch_array($result3)){
											$fid=$row3['id'];
											$fpimg=$row3['pimg'];
											$ffname=$row3['firstname'];
											$flname=$row3['lastname'];
											echo "<div id='notdiv'><a href='profile.php?id=".$fid."' class='ah3'><img src='".$fpimg."' onerror=\"this.onerror=null;this.src='img/ogimage1024x512.png';\" style='border-radius:50%;width:50px;height:50px;'></img><p6>".$ffname." ".$flname."</p6></a></div><br>";
										}
									}
								}
							echo "
							</div>";
							include("divflowprofile.php");
						echo "
						</div>";
						include("divfriends.php");
						
					}
				?>
			</center>
		</div>
		<?php include_once("divheader.php"); ?>
		</center>
		<center><?php include("aftercode.php"); ?></center>
		<script>
			if(getCookie('lang')=='gr'){
				changepicstext='Ενημέρωση Εικόνων Προφίλ';
				profilepic="Εικόνα Προφίλ";
				wallpic="Εικόνα Τοίχου";
				picsubmit="Ενημέρωση";
			}
			if(getCookie('lang')=='en'){
				changepicstext='Update Profile Pictures';
				profilepic="Profile Picture";
				wallpic="Wall Picture";
				picsubmit="update";
			}
			function friendrequestdef(){
				var request = $.ajax({
					type: "post",
					url: "ajax/datafriendrequest.php",
					data: {'friendrequest': document.getElementById("otherid").value},
					success : function(data){
						result=data;
						document.getElementById("friendrequest").value=result[0];
					}
				});
			}
			function unfriendrequestdef(){
				var request = $.ajax({
					type: "post",
					url: "ajax/dataunfriendrequest.php",
					data: {'unfriendrequest': document.getElementById("otherid").value},
					success : function(data){
						result=data;
						document.getElementById("unfriendrequest").value=result[0];
						location.reload();
					}
				});
			}
			function blockdef(){
				var request = $.ajax({
					type: "post",
					url: "ajax/datablock.php",
					data: {'block': document.getElementById("otherid").value},
					success : function(data){
						result=data;
						document.getElementById("blockrequest").value=result[0];
					}
				});
			}
			function viewchangeprofpic(){
				document.getElementById("changeprofilepics").style.visibility='visible';
				document.getElementById("changeprofilepics").style.height='auto';
			}
			function cppclose(){
				document.getElementById("changeprofilepics").style.visibility='hidden';
				document.getElementById("changeprofilepics").style.height='0px';
			}
			function viewfriendsdef(){
				document.getElementById("viewfriends").style.visibility='visible';
				document.getElementById("viewfriends").style.height='auto';
			}
			function vfclose(){
				document.getElementById("viewfriends").style.visibility='hidden';
				document.getElementById("viewfriends").style.height='0px';
			}
			function readURL2(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#picview').attr('src', e.target.result);
						$('#picview').attr('style', 'width:40%;height:auto;');
					}
					reader.readAsDataURL(input.files[0]);
				}
			}
			$("#picupl").change(function () {
				readURL2(this);
			});
		</script>
		<script src='matrix.js'></script>
	</body>
</html>
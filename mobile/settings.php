<?php 
include("../mysql.php"); 
include_once("login.php"); 
include_once("../lang.php");
include_once("../precode.php");
include_once("../timezones.php");

if($_COOKIE['lang']=="gr"){
	$textsettings="Ρυθμίσεις";
	$texttimezone='Ζώνη Ώρας';
	$textlanguage='Γλώσσα';
	$textupdate='Ενημέρωση';
	$textsuccessupdate='Οι ρυθμίσεις σου άλλαξαν με επιτυχία <br> Αποσυνδέσου και ξανασυνδέσου για να εφαρμοστούν (!)';
	$textblockedusers="Μπλοκαρισμένοι Χρήστες";
	$textunblock="Ξεμπλοκάρισμα";
}
if($_COOKIE['lang']=="en"){
	$textsettings="Settings";
	$texttimezone='Timezone';
	$textlanguage='Language';
	$textupdate='Update';
	$textsuccessupdate='Your settings changed successfully <br> Please log out and relogin to affect (!)';
	$textblockedusers="Blocked Users";
	$textunblock="Unblock";
}

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
		<link rel="stylesheet" href="mobilestyles.css">
		<title><?php echo $textsettings; ?></title>
<link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
<link rel="manifest" href="../site.webmanifest">
<link rel="mask-icon" href="../safari-pinned-tab.svg" color="#5bbad5">
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
	<body style='background-image: radial-gradient(#ffffff, #e6e6e6, #cccccc);width:100%;height:100%;'>
		<center>
		<div id='content'>
			<center>
			<div id='mobileflow'>
				<h1><?php echo $textsettings; ?></h1><br>
				<?php
					if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
						and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
						and (securelogin()==true) ) {
							if( (isset($_POST['language'])) and (isset($_POST['timezone'])) ){
								$sql="UPDATE users SET timezone='".$_POST['timezone']."' WHERE id='".$_COOKIE['id']."' ";
								if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
								$sql="UPDATE users SET language='".$_POST['language']."' WHERE id='".$_COOKIE['id']."' ";
								if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
								echo "<p2>".$textsuccessupdate."</p2><br><br>";
							}
							if(isset($_POST['unblock'])){
								$unblock=$_POST['unblock'];
								$result = mysqli_query($con,"SELECT * FROM users WHERE id='$unblock' ");
								while($row = mysqli_fetch_array($result)){
										$othersblock=unserialize($row['othersblock']);
										$othersblock2=array();
										for($x=0;$x<count($othersblock);$x++){
											if($othersblock[$x]!=$_COOKIE['id']){
												array_push($othersblock2,$othersblock[$x]);
											}
										}
										$othersblock=serialize($othersblock2);
										$sql="UPDATE users SET othersblock='$othersblock' WHERE id='".$unblock."' ";
										if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
								}
								$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
								while($row = mysqli_fetch_array($result)){
										$blocked=unserialize($row['blocked']);
										$blocked2=array();
										for($x=0;$x<count($blocked);$x++){
											if($blocked[$x]!=$unblock){
												array_push($blocked2,$blocked[$x]);
											}
										}
										$blocked=serialize($blocked2);
										$sql="UPDATE users SET blocked='$blocked' WHERE id='".$_COOKIE['id']."' ";
										if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
								}
							}
							echo "
							<form id='updatelt' name='updatelt' method='post' action='settings.php'>
								<table>
								<tr>
									<td><p2>$textlanguage</p2></td>
									<td>
										<select name='language' >
											<option value='gr'>gr</option>
											<option value='en'>en</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><p2>$texttimezone</p2></td>
									<td>
										<select name='timezone' >";
										for($x=0;$x<count($alltimezones);$x++){
											$tn = datehour($alltimezones[$x]);
											if($alltimezones[$x]=='Europe/Athens'){
												echo "<option value='$alltimezones[$x]' selected='selected'>$alltimezones[$x] : $tn</option>";
											}else{
												echo "<option value='$alltimezones[$x]'>$alltimezones[$x] : $tn</option>";
											}
										}
							echo	"</select>
									</td>
								</tr>
								</table><br>
								<input class=cbutton type='submit' name='button2' value='$textupdate'><br><br>
							</form><br><br>";
							echo "<h1>".$textblockedusers."</h1>";
							$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
							while($row = mysqli_fetch_array($result)){
								$blocked=unserialize($row['blocked']);
							}
							for($x=0;$x<count($blocked);$x++){
								$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$blocked[$x]."' ");
								while($row = mysqli_fetch_array($result)){
									$bid=$row['id'];
									$bpimg=$row['pimg'];
									$bfname=$row['firstname'];
									$blname=$row['lastname'];
									echo "
									<div id='notdiv'><img src='../".$bpimg."' style='width:50px;height:50px;'></img><p6>".$bfname." ".$blname."</p6>
										<form action='settings.php' method='POST'>
											<input type='hidden' name='unblock' value='".$bid."' />
											<input type='submit' class='cbutton' value='".$textunblock."'/>
										</form>
									</div><br>";
									
								}
							}
							
					}else{
						echo "<script>window.location.href = 'index.php';</script>";
					}
				?>
			</div>
			<?php include_once("aftercode.php"); ?>
			</center>
		</div>
		<?php include_once("divheader.php"); ?>
		</center>
	</body>
</html>
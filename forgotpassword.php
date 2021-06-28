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
		<title>FullHood</title>
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
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
		<meta name="google-site-verification" content="PHfIAmAiECS0XYYhlTYiAWilqn-D_tLbV2pEF0hDYFM" />
		<meta name="msvalidate.01" content="C6645F360922FC2DB3F085129F7A1E51" />
		<meta name="distribution" content="web"/>
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>	
	<!--body style='background-image: radial-gradient(#ffffff, #80ccff, #0099ff);width:100%;height:100%;'-->
	<body style='background-image: radial-gradient(#20C20E, #282828, #000000);width:100%;height:100%;'>
    <canvas id="canvas">Canvas is not supported in your browser.</canvas>
    <canvas id="canvas2">Canvas is not supported in your browser.</canvas>
		<center>
		<div id='content'>
			<center>
			<img src='img/ogimage1024x512.png' style='width:512px;height:256px;'></img><br>
			<div id='registration'>
				<?php
					if( ($_GET['lang']!='en') and ($_GET['lang']!='gr') ){
						$_GET['lang']="gr";
					}
					if($_GET['lang']=='gr'){
						$textfpass="<p2> Πρέπει να είσαγεις το μνημονικό σου <br> για να ανακτήσεις το λογαριασμό σου (!) <b><br><br> Μμνημονικό :</b><br>";
						$textplaceholder="Επικόλλησε το Μνημονικό σου εδώ ...";
						$recovervalue="Ανάκτηση";
						$newpass="Νέος κωδικός";
						$confirm="Επιβεβαίωση";
						$change="Αλλαγή";
						$textusername="Όνομα χρήστη";
						$passchangesuccess="Ο κωδικός άλλαξε με επιτυχία ! <br> Μπορείτε να συνδεθείτε με τα καινούρια στοιχεία σύνδεσης ...";
						$passchangefail="Οι κωδικοί δεν ταιριάζουν ! <br> Επιστρέψτε στην αρχική φόρμα ...";
						$checkpass='Ο κωδικός πρόσβασης πρέπει να έχει από 6 εώς 18 χαρακτήρες (!)<br>';
						$back="Επιστροφή";
						$wmtext="Μη έγκυρο μνημονικό";
						$rctext = "Πρέπει να επιβεβαιώσεις ότι δεν είσαι ρομπότ (!) ";
					}
					if($_GET['lang']=='en'){
						$textfpass="<p2> Must be enter your mnemonic <br> to recover your account (!) <b><br><br> Mnemonic :</b><br>";
						$textplaceholder="Enter your Mnemonic here...";
						$recovervalue="Recover";
						$newpass="New Password";
						$confirm="Confirm";
						$change="Change";
						$textusername="Username";
						$passchangesuccess="Password Changed Succesfully ! <br> You can login with new crendentials ...";
						$passchangefail="Passwords does not match ! <br> Back to the recover form ...";
						$checkpass='Password must be from 6 to 18 characters (!)<br>';
						$back="Go Back";
						$wmtext="Wrong Mnemonic";
						$rctext = "Must be confirm you are not a robot (!) ";
					}
					if($_GET['forgotpass']=="true"){
						echo "$textfpass
						<form action='forgotpassword.php?forgotpass=false&lang=".$_GET['lang']."' method='POST'>							
							<textarea rows='2' cols='10' id='mnemonic' name='mnemonic' placeholder='$textplaceholder' style='font-size:20px;width:480;height:80px;resize: none;' '></textarea><br><br>
							<div class='g-recaptcha' data-sitekey='ENTER YOUR RECAPTCHA V2 PUBLIC KEY'></div><br>
							<input type='submit' class='cbutton' value='".$recovervalue."' /><br><br>
						</form>";
					}
					if(isset($_POST['mnemonic'])){
						if (isset($_POST["g-recaptcha-response"])) {
							$gresponse = $reCaptcha->verifyResponse(
								$_SERVER["REMOTE_ADDR"],
								$_POST["g-recaptcha-response"]
							);
							if ($gresponse != null && $gresponse->success) {
								$mnemonic=str_replace("'","",$_POST['mnemonic']);
								$mnemonic=str_replace(" ","",$_POST['mnemonic']);
								$mnemonic=trim(preg_replace('/\s\s+/', ' ', $mnemonic));
								$mnemonic=md5(hash('sha512',$mnemonic));
								$result = mysqli_query($con,"SELECT * FROM users WHERE activation='".$mnemonic."' ");
								$mcounter=0;
								while($row = mysqli_fetch_array($result)){
									$id=$row['id'];
									$pimg=$row['pimg'];
									$fname=$row['firstname'];
									$lname=$row['lastname'];
									$username=$row['username'];
									$mcounter=1;
									echo "
									<div id='notdiv' style='overflow-x:hidden;'><img src='".$pimg."' onerror=\"this.onerror=null;this.src='img/ogimage1024x512.png';\" style='border-radius:50%;width:90px;height:90px;'></img><p style='font-size:32px;margin-left:20px;'>".$fname." ".$lname."</p2>
									</div><br><br>
									<form action='forgotpassword.php?forgotpass=false&lang=".$_GET['lang']."' method='POST'>
										<table>
											<tr>
												<td><p2>$textusername :</p2></td>
												<td><p2>&nbsp&nbsp&nbsp&nbsp$username</p2></td>
											</tr>
											<tr>
												<td><p2>$newpass</p2></td>
												<td><input name='pass' type='Password' id='pass' oninput=\"allowedchar('pass');\" style='height:25px;width:200px;font-size;22px;font-weight:bold;border:1px black solid;'></td>
											</tr>
											<tr>
												<td><p2>$confirm</p2></td>
												<td><input name='cpass' type='Password' id='cpass' oninput=\"allowedchar('cpass');\" style='height:25px;width:200px;font-size;22px;font-weight:bold;border:1px black solid;'></td>
											</tr>
										</table><br>
										<input type='hidden' name='xmemo' value='".$mnemonic."' /><br><br>
										<input type='submit' class='cbutton' value='".$change."' /><br><br>
									</form>
									<div id='charserror' style='background-color:#b4b4b4;width:420px;height:auto;max-height:500px;overflow-y:scroll;top:150px;left:150px;position:absolute;border:2px #000000 solid;visibility:hidden;'>
									</div>";
								}
								if($mcounter==0){
									echo "<p2>$wmtext</p2><br><br><a href='forgotpassword.php?forgotpass=true&lang=".$_GET['lang']."' class='ah3'>
									<input type='submit' class='cbutton' name='submit' value='$back'></a>
									<br><br>";
								}
							}else{
								echo "<p2>$rctext</p2><br><br><form action='forgotpassword.php?forgotpass=true&lang=".$_GET['lang']."' method='POST' style=''>
								<input type='hidden' name='lang' value='$lang'/>
								<input type='submit' class='cbutton' name='submit' value='$back'>
								</form><br><br>";
							}
						}else{
							echo "<p2>$rctext</p2><br><br>form action='forgotpassword.php?forgotpass=true&lang=".$_GET['lang']."' method='POST' style=''>
							<input type='hidden' name='lang' value='$lang'/>
							<input type='submit' class='cbutton' name='submit' value='$back'>
							</form><br><br>";
						}
					}
					if(isset($_POST['xmemo'])){
						if($_POST['cpass']==$_POST['pass']){
							if( (strlen($_POST['pass'])>=6) and (strlen($_POST['pass'])<=18) ){
								$sql="UPDATE users SET password='".md5(hash('sha512',$_POST['pass']))."' WHERE activation='".$_POST['xmemo']."' ";
								if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
								echo "<p2>".$passchangesuccess."</p2>";
							}else{
								echo "<p2>".$checkpass."</p2>";
								echo "<br><br>
								<form action='forgotpassword.php?forgotpass=true&lang=".$_GET['lang']."' method='POST'>
									<input type='submit' class='cbutton' value='".$back."' /><br><br>
								</form>";
							}
						}else{
							echo "<p2>".$passchangefail."</p2>";
							echo "<br><br>
							<form action='forgotpassword.php?forgotpass=true&lang=".$_GET['lang']."' method='POST'>
								<input type='submit' class='cbutton' value='".$back."' /><br><br>
							</form>";
						}
					}
				?>
			</div>
			</center>
		</div>
		<?php include_once("divheader.php"); ?>
		</center>
		<script>
			function allowedchar(id){
				chars=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9','Α','Β','Γ','Δ','Ε','Ζ','Η','Θ','Ι','Κ','Λ','Μ','Ν','Ξ','Ο','Π','Ρ','Σ','Τ','Υ','Φ','Χ','Ψ','Ω','α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','ο','π','ρ','σ','τ','υ','φ','χ','ψ','ω','Ά','Έ','Ή','Ύ','Ί','Ό','Ώ','ά','έ','ή','ύ','ί','ό','ώ','@','.','!','*','&','-'];
				text=document.getElementById(id).value;
				charstext="";
				ctcounter=0;
				for(x in chars){
					ctcounter+=1;
					if(ctcounter%10==0){
						charstext+="<br>";
					}
					charstext+=" "+chars[x];
				}
				for(x in text){
					if(chars.includes(text[x])==false){
						document.getElementById(id).value="";
						//alert(chars+" Only these characters allowed - Μόνο αυτοί οι χαρακτήρες επιτρέπονται !!!");
						document.getElementById("charserror").style.visibility='visible';
						document.getElementById("charserror").innerHTML = "<div id='notdiv'><input type='image'  onclick='ceclose();' src='img/close.png' style='height:30px;width:30px;float:right;' /><br><p11>Only these characters allowed (!) <br> Μόνο οι παρακάτω χαρακτήρες επιτρέπονται (!) <br><br> "+charstext+"</p11></div>";
					}
				}
				
			}
			function ceclose(){
				document.getElementById("charserror").style.visibility='hidden';
			}
		</script>
		<script src='matrix.js'></script>
	</body>
</html>
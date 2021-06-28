<?php 
include("mysql.php"); 
include_once("login.php"); 
include_once("lang.php");
include_once("precode.php");
include_once("timezones.php");
header("Content-Type: text/html; charset=utf-8");
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
		<link rel="alternate" href="https://fullhood.com/index.php" hreflang="<?php echo $hreflang;?>"/>
		<meta name="robots" content="index, follow, noodp, noydir">
		<meta name="description" content="FullHood Social Network" />
		<meta property="og:type" content="website" />
		<meta property="og:image" content="https://fullhood.com/img/ogimage.png"/>
		<meta property="og:image:url" content="https://fullhood.com/img/ogimage.png"/>
		<meta property="og:image:secure_url" content="https://fullhood.com/img/ogimage.png"/>
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image:width" content="1024"/>
		<meta property="og:image:height" content="512"/>
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
		<!--meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86"-->
		<!--meta name="viewport" content="width=1024, initial-scale=1"-->
		<!--meta name="viewport" content="width=device-width, initial-scale=0.5"-->
		<!--meta name="viewport" content="height=device-height, initial-scale=0.33"-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>	
	<!--body style='background-image: radial-gradient(#ffffff, #80ccff, #0099ff);width:100%;height:100%;'-->
	<body style='background-image: radial-gradient(#20C20E, #282828, #000000);width:100%;height:100%;'>
    <canvas id="canvas">Canvas is not supported in your browser.</canvas>
    <canvas id="canvas2">Canvas is not supported in your browser.</canvas>
		<center>
		<img src='img/ogimage.png' style='width:512px;height:256px;margin-top:-1000px;'></img>
		<div id='content'>
			<center>
				<?php
					if (!isset($_COOKIE['id']) and !isset($_COOKIE['fname']) and !isset($_COOKIE['lname']) and !isset($_COOKIE['gen']) 
					and !isset($_COOKIE['lang']) and !isset($_COOKIE['status']) and !isset($_COOKIE['day']) and !isset($_COOKIE['month']) and !isset($_COOKIE['year']) ){
						echo"<img src='img/ogimage1024x512.png' style='width:512px;height:256px;'></img><br>";
						//echo"<a href='news.php?lang=$lang' class=ah3' ><img src='img/news.png' style='width:100px;height:100px;position:fixed;bottom:30px;right:30px;'></img></a>";
						include_once("divregistration.php");
						include_once("aftercode.php");
					}else if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
					and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='dead') 
					and (securelogin()==true) ){
						echo"<img src='img/ogimage1024x512.png' style='width:512px;height:256px;'></img><br>";
						include_once("divactivation.php");
					}else if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
					and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
					and (securelogin()==true) ) {
						include("divflow.php");
						//include("divsugfriends.php");
						//include("divbanner.php");
						include("divfriends.php");
						include_once("aftercode.php");
					}else{
						echo "<div id='registration' style='height:auto;min-height:200px;'>
								<p2>Πρέπει να καθαρίσεις τα Cookies για να συνεχίσεις (!)<br><br>
								Must be clear Cookies to continue (!)<br>
								<br></p2>
									<form action='index.php' method='POST' style='float:right;margin-right:5px;'>
										<input type='hidden' name='logout' value='logout'/>
										<input type='submit' class='cbutton' value='Clear Cookies'/>
									</form><br><br>
							</div>";
					}
				?>
			</center>
		</div>
		<?php include_once("divheader.php"); ?>
		</center>
	<script src='matrix.js'></script>
	</body>
</html>
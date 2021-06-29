<?php 
include("../mysql.php"); 
include_once("login.php"); 
include_once("../lang.php");
include_once("../precode.php");
include_once("../timezones.php");
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
		<link rel="stylesheet" href="mobilestyles.css">
		<title>FullHood</title>
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
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>	
	<!--body style='background-image: radial-gradient(#ffffff, #80ccff, #0099ff);width:100%;height:100%;'-->
	<body style='background-image: radial-gradient(#ffffff, #e6e6e6, #cccccc);width:100%;height:100%;'>
		<script>
			function clearsearch(){
				document.getElementById("search").innerHTML = "";
			}
			function search(str){
				$("#search").show();
				document.getElementById("search").style.visibility='visible';
				if(getCookie('lang')=='gr'){xsearch='Αναζήτηση';} // jstranslate
				if(getCookie('lang')=='en'){xsearch='Search';}
				if (str.length == 0) {
					clearsearch();
					return;
				} else {
					clearsearch();
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							var foo = JSON.parse(this.responseText);
							for(x in foo){
								id=foo[x][0];
								fname=foo[x][1];
								lname=foo[x][2];
								img=foo[x][3];
								document.getElementById("search").innerHTML += "<div id='searchfriendsdiv'><a href='profile.php?id="+id+"' class='ah3'><img src='../"+img+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:100px;height:100px;float:left;'></img></a><a href='profile.php?id="+id+"' class='ah3'><p7 style='float:left;'>"+fname+" "+lname+"</p7></a></div><br><br><br><br><br><br>";
							}
						}
					};
					xmlhttp.open("GET", "../search.php?q=" + str, true);
					xmlhttp.send();
				}	
			}
		</script>
		<center>
		<div id='content'>
			<center>
				<?php
					if (!isset($_COOKIE['id']) and !isset($_COOKIE['fname']) and !isset($_COOKIE['lname']) and !isset($_COOKIE['gen']) 
					and !isset($_COOKIE['lang']) and !isset($_COOKIE['status']) and !isset($_COOKIE['day']) and !isset($_COOKIE['month']) and !isset($_COOKIE['year']) ){
						echo"<br><img src='../img/ogimage1024x512.png' style='width:512px;height:256px;'></img><br>";
						//echo"<a href='news.php?lang=$lang' class=ah3' ><img src='../img/news.png' style='width:100px;height:100px;position:fixed;bottom:30px;right:30px;'></img></a>";
						include_once("divregistration.php");
						include_once("aftercode.php");
					}else if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
					and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='dead') 
					and (securelogin()==true) ){
						echo"<br><img src='../img/ogimage1024x512.png' style='width:512px;height:256px;'></img><br>";
						include_once("divactivation.php");
					}else if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
					and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
					and (securelogin()==true) ) {
						if($lang=='en'){$textsearch="Search...";}
						if($lang=='gr'){$textsearch="Αναζήτηση...";}
						echo "
							<div id='search' style='width:100%;height:auto;margin-top:100px;position:absolute;'></div>
							<div style='height:70px;width:100%;margin-top:30px;top:100px;position:fixed;'>
								<input type='text' onkeyup='search(this.value)' placeholder='".$textsearch."' style='height:60px;width:80%;font-size:4vw;font-weight:bold;border:2px black solid;float:left;'>
								<img src='../img/search.png' style='height:60px;width:60px;float:left;'/><input type='image' id='searchclose' onclick='clearsearch();' src='../img/close.png' style='height:60px;width:60px;float:right;margin-right:10px;' />
							</div>
							";
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
	</body>
</html>
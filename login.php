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
<?php
	function othash(){
		$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
		$activationcode="";
		for($x=0;$x<32;$x++){
			$activationcode=$activationcode.$char[rand(0,count($char)-1)];
		}
		return $activationcode;
	}
	function securelogin(){
		include("mysql.php");
		$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
		$checkid=0;
		while($row = mysqli_fetch_array($result)){
			$checkid=1;
			if( ($_COOKIE['password']==$row['othash'])){
				return true;
			}else{
				echo "
				<form id='letsgoout' action='index.php' method='POST'>
				<input type='hidden' name='logout' value='logout' />
				</form>
				<script>document.getElementById('letsgoout').submit();</script>";
			}
		}
	}
	function logout(){
		setcookie('id', '', time()-7000000, '/', 'fullhood.com');
		setcookie('fname', '', time()-7000000, '/', 'fullhood.com');
		setcookie('lname', '', time()-7000000, '/', 'fullhood.com');
		setcookie('lang', '', time()-7000000, '/', 'fullhood.com');
		setcookie('gen', '', time()-7000000, '/', 'fullhood.com');
		setcookie('day', '', time()-7000000, '/', 'fullhood.com');
		setcookie('month', '', time()-7000000, '/', 'fullhood.com');
		setcookie('year', '', time()-7000000, '/', 'fullhood.com');
		setcookie('status', '', time()-7000000, '/', 'fullhood.com');
		setcookie('pimg', '', time()-7000000, '/', 'fullhood.com');
		setcookie('password', '', time()-7000000, '/', 'fullhood.com');
		setcookie('timezone', '', time()-7000000, '/', 'fullhood.com');
		header('Location: index.php');
	}
	if(isset($_POST['logout'])){
		setcookie('id', '', time()-7000000, '/', 'fullhood.com');
		setcookie('fname', '', time()-7000000, '/', 'fullhood.com');
		setcookie('lname', '', time()-7000000, '/', 'fullhood.com');
		setcookie('lang', '', time()-7000000, '/', 'fullhood.com');
		setcookie('gen', '', time()-7000000, '/', 'fullhood.com');
		setcookie('day', '', time()-7000000, '/', 'fullhood.com');
		setcookie('month', '', time()-7000000, '/', 'fullhood.com');
		setcookie('year', '', time()-7000000, '/', 'fullhood.com');
		setcookie('status', '', time()-7000000, '/', 'fullhood.com');
		setcookie('pimg', '', time()-7000000, '/', 'fullhood.com');
		setcookie('password', '', time()-7000000, '/', 'fullhood.com');
		setcookie('timezone', '', time()-7000000, '/', 'fullhood.com');
		setcookie('id', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('fname', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('lname', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('lang', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('gen', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('day', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('month', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('year', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('status', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('pimg', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('password', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('timezone', '', time()-7000000, '/', 'fullfacebook.com');
		setcookie('id', '', time()-7000000, '/', 'alientext.com');
		setcookie('fname', '', time()-7000000, '/', 'alientext.com');
		setcookie('lname', '', time()-7000000, '/', 'alientext.com');
		setcookie('lang', '', time()-7000000, '/', 'alientext.com');
		setcookie('gen', '', time()-7000000, '/', 'alientext.com');
		setcookie('day', '', time()-7000000, '/', 'alientext.com');
		setcookie('month', '', time()-7000000, '/', 'alientext.com');
		setcookie('year', '', time()-7000000, '/', 'alientext.com');
		setcookie('status', '', time()-7000000, '/', 'alientext.com');
		setcookie('pimg', '', time()-7000000, '/', 'alientext.com');
		setcookie('password', '', time()-7000000, '/', 'alientext.com');
		setcookie('timezone', '', time()-7000000, '/', 'alientext.com');
		header('Location: index.php');
	}
	$wronglogin=0;
	$iamrobot=0;
	require "recaptchalib.php";
	$secret = "ENTER YOUR SECRET KEY OF RECAPCTHA V2";
	$gresponse = null;
	$reCaptcha = new ReCaptcha($secret);
	if (isset($_POST['username']) && isset($_POST['password']) and isset($_POST['loginform']) ) {
		if (isset($_POST["g-recaptcha-response"])) {
			$gresponse = $reCaptcha->verifyResponse(
				$_SERVER["REMOTE_ADDR"],
				$_POST["g-recaptcha-response"]
			);
			if ($gresponse != null && $gresponse->success) {
				$result = mysqli_query($con,"SELECT * FROM users ");
				while($row = mysqli_fetch_array($result)){
					if (($_POST['username'] == $row['username']) && (md5(hash('sha512',$_POST['password'])) == $row['password'])) {
						if (isset($_POST['loginform'])) {
							$othash=othash();
							setcookie('id', $row['id'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('fname', $row['firstname'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('lname', $row['lastname'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('lang', $row['language'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('gen', $row['genre'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('day', $row['day'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('month', $row['month'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('year', $row['year'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('status', $row['status'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('pimg', $row['pimg'], time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('password', $othash, time()+60*60*24*365, '/', 'fullhood.com');
							setcookie('timezone', $row['timezone'], time()+60*60*24*365, '/', 'fullhood.com');
							$sql="UPDATE users SET othash='$othash' WHERE id='".$row['id']."' ";
							if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
						}else{
							setcookie('id', $row['id'], false, '/', 'fullhood.com');
							setcookie('fname', $row['firstname'], false, '/', 'fullhood.com');
							setcookie('lname', $row['lastname'], false, '/', 'fullhood.com');
							setcookie('lang', $row['language'], false, '/', 'fullhood.com');
							setcookie('gen', $row['genre'], false, '/', 'fullhood.com');
							setcookie('day', $row['day'], false, '/', 'fullhood.com');
							setcookie('month', $row['month'], false, '/', 'fullhood.com');
							setcookie('year', $row['year'], false, '/', 'fullhood.com');
							setcookie('status', $row['status'], false, '/', 'fullhood.com');
							setcookie('pimg', $row['pimg'], false, '/', 'fullhood.com');
							setcookie('password', $row['othash'], false, '/', 'fullhood.com');
							setcookie('timezone', $row['timezone'], false, '/', 'fullhood.com');
						}
						header('Location: index.php');
					}else{
						$wronglogin=1;
					}
				}
			}else{
				$iamrobot=1;
			}
		}else{
			$iamrobot=1;
		}
	}
?>

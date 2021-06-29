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
    include_once("login.php"); 
    include_once("../lang.php");
?>
<?php
	if($lang=='en'){
		$textact1='You must activate your account! <br>
			Paste your mnemonic to activate your account .... <br>';
		$submitact1='Activate';
		$textactcode='Mnemonic';
		$textplaceholder="Enter your Mnemonic here...";
	}
	if($lang=='gr'){
		$textact1='Πρέπει να ενεργοποιήσεις το λογαριασμό σου !<br>
			Κάνε επικόλληση το μνημονικό σου για να ενεργοποιήσεις το λογαριασμό σου....<br>';
		$textactcode='Μνημονικό';
		$submitact1='Ενεργοποίηση';
		$textplaceholder="Επικόλλησε το Μνημονικό σου εδώ ...";
	}
?>
<div id='registration'>
	<br>
	<?php
		if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
		and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='dead') ) {
			echo "
			<form action='index.php' method='POST'>
				<p2>$textact1</p2>
				<br><br>
				<p2>$textactcode</p2><br>
				<textarea rows='2' cols='10' id='actcode' name='actcode' placeholder='$textplaceholder' style='font-size:20px;width:480;height:80px;resize: none;' '></textarea><br><br>
				<input class=cbutton type='submit' name='button2' value='$submitact1'><br><br>
			</form>";
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$username=$row['username'];
			}
		}
	?>
</div>
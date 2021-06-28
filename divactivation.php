<?php
    include_once("login.php"); 
    include_once("lang.php");
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
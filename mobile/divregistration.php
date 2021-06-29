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
    include_once("../timezones.php");
?>
<?php
	if($lang=='en'){
		$textforgotpassword='Forgot Password';
		$textfirstname='FirstName';
		$textlastname='LastName';
		$textuser='Username';
		$textpassword='Password';
		$textconfirm='Confirm';
		$textiam='I am';
		$textmale='Male';
		$textfemale='Female';
		$textlanguage='Language';
		$textdob='Date Of Birth';
		$textday='Day';
		$textmonth='Month';
		$textyear='Year';
		$textJan='Jan';
		$textFeb='Feb';
		$textMar='Mar';
		$textApr='Apr';
		$textMay='May';
		$textJun='Jun';
		$textJul='Jul';
		$textAug='Aug';
		$textSep='Sep';
		$textOct='Oct';
		$textNov='Nov';
		$textDec='Dec';
		$textregister='Register';
		$checkback='Back';
		$checkfirstname='First Name must be from 2 to 18 characters (!)<br>';
		$checklastname='Last Name must be from 2 to 18 characters (!)<br>';
		$checkusername='Username must be from 2 to 18 characters (!)<br>';
		$checkpass='Password must be from 6 to 18 characters (!)<br>';
		$checkcpass='Passwords do not match (!)<br>';
		$checkdate='You must enter a valid Date Of Birth (!)<br>';
		$usernameexists='username is already in an account, try signing in (!)<br>';
		$createaccount='Congratulations you\'ve created your account successfully! <br> <br>
			Below you will find your mnemonic which is a 128 character code ... <br>
			Save your mnemonic in a text document and keep it safe ... <br>
			Mnemonic is the only way to recover your account! <br> <br
			Welcome to our social network !!!';
		$mailtitle='Activation code at fullhood.com';
		$wltext='Not Valid username Or Wrong Password (!)';
		$texttimezone='Timezone';
		$Mnemonic='Mnemonic';
		$info=" Info ";
		$rctext = "Must be confirm you are not a robot (!) ";
		$information = "<p2> fullhood.com is a new social network designed to become a great community <br>
		that will not exploit personal data for speculation and for no other reason ... <br> <br>
		You will not be limited to our social network as it supports freedom of speech ... <br> <br>
		You'll never pay to promote your post, as long as you do likes and dislikes <br>
		you will accumulate points and be able to promote posts with them and play games .. <br> <br>
		Also our network does not require any real personal data of the user and can provide anonymity ... <br> <br>
		Neither does it need an email because it works with a mnemonic, a 128-character code that you need to save on <br>
		sign up and keep it safe ... <br> <br>
		fullhood.com is coded by Nikolaos Bazigos and will continue to evolve ... <br> <br>
		Good start dear friends ... <br> <br> </p2> ";
	}
	if($lang=='gr'){
		$textforgotpassword='Ξέχασα Τον Κωδικό';
		$textfirstname='Όνομα';
		$textlastname='Επώνυμο';
		$textuser='Όνομα Χρήστη';
		$textpassword='Κωδικός';
		$textconfirm='Επιβεβαίωση';
		$textiam='Είμαι';
		$textmale='Άνδρας';
		$textfemale='Γυναίκα';
		$textlanguage='Γλώσσα';
		$textdob='Ημερομηνία Γέννησης';
		$textday='Ημέρα';
		$textmonth='Μήνας';
		$textyear='Χρόνος';
		$textJan='Ιανουάριος';
		$textFeb='Φεβρουάριος';
		$textMar='Μάρτιος';
		$textApr='Απρίλιος';
		$textMay='Μάιος';
		$textJun='Ιούνιος';
		$textJul='Ιούλιος';
		$textAug='Αύγουστος';
		$textSep='Σεπτέμβριος';
		$textOct='Οκτώμβριος';
		$textNov='Νοέμβριος';
		$textDec='Δεκέμβριος';
		$textregister='Εγγραφή';
		$checkback='Πίσω';
		$checkfirstname='Το Όνομα πρέπει να έχει από 2 εώς 18 χαρακτήρες (!)<br>';
		$checklastname='Το Επώνυμο πρέπει να έχει από 2 εώς 18 χαρακτήρες (!)<br>';
		$checkusername='Το Όνομα Χρήστη πρέπει να έχει από 6 εώς 18 χαρακτήρες (!) <br>';
		$checkpass='Ο κωδικός πρόσβασης πρέπει να έχει από 6 εώς 18 χαρακτήρες (!)<br>';
		$checkcpass='Οι κωδικοί δεν ταιριάζουν (!)<br>';
		$checkdate='Πρέπει να εισάγεις μια έγκυρη ημερομηνία γέννησης (!)<br>';
		$usernameexists='Το Όνομα Χρήστη υπάρχει ήδη σε λογαριασμό , δοκιμάστε να συνδεθείτε (!)<br>';
		$createaccount='Συγχαρητήρια έχετε δημιουργήσει το λογαριασμό σας με επιτυχία !<br><br>
			Παρακάτω θα δεις το μνημονικό σου που είναι ένας κωδικός 128 χαρακτήρων...<br>
			Αποθήκευσε το μνημονικό σου σε ένα εγγραφο κειμένου και κράτησε το ασφαλή... <br>
			Το μνημονικό είναι ο μόνος τρόπος να ανακτήσεις το λογαριασμό σου !<br><br>
			Καλώς ήρθατε στο κοινωνικό μας δίκτυο !!!';
		$mailtitle='Κωδικός Ενεργοποίησης στο fullhood.com';
		$wltext='Μη έγκυρο Όνομα Χρήστη ή Λάθος Κωδικός (!)';
		$texttimezone='Ζώνη Ώρας';
		$Mnemonic='Μνημονικό';
		$info=" Πληροφορίες ";
		$rctext = "Πρέπει να επιβεβαιώσεις ότι δεν είσαι ρομπότ (!) ";
		$information = "<p2> Το fullhood.com είναι ένα κοινωνικό δίκτυο ... <br>
		που δε θα εκμεταλεύεται τα προσωπικα δεδομένα για κερδοσκοπία και για κανένα άλλο λόγο ...<br><br>
		Στο κοινωνικό δίκτυο μας δε θα περιορίζεσαι καθώς υποστηρίζει την ελευθερία του λόγου ...<br><br>
		Δεν θα πληρώσεις ποτέ για να προωθήσεις μια δημοσίευση σου , καθώς όσο κάνεις likes και dislikes <br>
		θα μαζέυεις πόντους και θα μπορείς να προωθείς δημοσιεύσεις με αυτούς και να παίζεις παιχνίδια ..<br><br>
		Επίσης το δίκτυο μας δεν απαιτεί κανένα πραγματικό προσωπικό στοίχειο του χρήστη και μπορεί να προσφέρει ανωνυμία ...<br><br>
		Δεν χρείαζεται ούτε email καθώς λειτουργεί με μνημονικό , έναν κωδικό 128 χαρακτήρων που πρέπει να αποθηκεύσεις κατά την <br>
		εγγραφή σου και να τον κρατήσεις ασφαλή ...<br><br>
		To fullhood.com προγραμματίστηκε από τον Νικόλαο Μπαζίγο και θα συνέχισει να εξελίσσεται ...<br><br>
		Καλή αρχή αγαπητοί φίλοι ...<br><br></p2>";
	}
	######################################
	###  FUNCTIONS
	######################################
	function activationcode(){
		include("../mysql.php");
		$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
		while(true){
			$activationcode="";
			for($x=0;$x<128;$x++){
				$activationcode=$activationcode.$char[rand(0,count($char)-1)];
			}
			$exists=false;
			$result = mysqli_query($con,"SELECT * FROM users WHERE activation='".$activationcode."' ");
			while($row = mysqli_fetch_array($result)){
				$activation=$row['activation'];
				if($activation==md5(hash('sha512',$activationcode))){
					$exists=true;
					break;
				}
			}
			if($exists==false){
				break;
			}
		}
		return $activationcode;
	}
	function newid(){
		$run=1;
		while($run==1){
			$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
			$id="";
			for($x=0;$x<64;$x++){
				$id=$id.$char[rand(0,count($char)-1)];
			}
			include('../mysql.php');
			$result = mysqli_query($con,"SELECT * FROM users ");
			$testid=0;
			while($row = mysqli_fetch_array($result)){
				if($id==$row['id']){
					$testid=1;
				}
			}
			if($testid==0){
				$run=0;
				break;
			}
		}
		return $id;
	}
?>
<div id='registration'>
	<?php
		if (!isset($_COOKIE['id']) and !isset($_COOKIE['fname']) and !isset($_COOKIE['lname']) and !isset($_COOKIE['gen']) 
		and !isset($_COOKIE['lang']) and !isset($_COOKIE['status']) and !isset($_COOKIE['day']) and !isset($_COOKIE['month']) 
		and !isset($_COOKIE['year']) and !isset($_POST['fname']) and ($wronglogin==0) and ($iamrobot==0)  ) {
			echo "
				<form action='index.php' method='POST' style='float:left;margin-left:10px;'>
					<input type='hidden' name='lang' value='en'/>				
					<input type='image' name='submit' src='../img/eng.jpg' style='height:70px; width:116px;' value='Submit' />
				</form>
				<form action='index.php' method='POST' style='float:left;margin-left:10px;'>
					<input type='hidden' name='lang' value='gr'/>				
					<input type='image' name='submit' src='../img/gr.jpg' style='height:70px; width:116px;' value='Submit' />
				</form>
				<a href='forgotpassword.php?forgotpass=true&lang=$lang' class='ah3' style='float:right;margin:5px;'><p2>$textforgotpassword</p2></a>
			<br><br><br><br>			
			<form method='post' action='index.php'>
				<table width='auto' border='0' cellpadding='5' cellspacing='0'>
				<tr>
					<td style='width:200px;margin:5px;'><p2>$textfirstname</p2></td>
					<td width='91'><input name='fname' type='text' id='fname' value='' oninput=\"allowedchar('fname');\" style='height:25px;width:220px;font-size;22px;font-weight:bold;border:1px black solid;'></td>
				</tr>
				<tr>
					<td><p2>$textlastname</p2></td>
					<td><input name='lname' type='text' id='lname' value='' oninput=\"allowedchar('lname');\" style='height:25px;width:220px;font-size;22px;font-weight:bold;border:1px black solid;'></td>
				</tr>
				<tr>
					<td><p2>$textuser</p2></td>
					<td><input name='username' type='text' id='username' value='' oninput=\"allowedchar('username');\" style='height:25px;width:220px;font-size;22px;font-weight:bold;border:1px black solid;'></td>
				</tr>
				<tr>
					<td><p2>$textpassword</p2></td>
					<td><input name='pass' type='Password' id='pass' oninput=\"allowedchar('pass');\" style='height:25px;width:220px;font-size;22px;font-weight:bold;border:1px black solid;'></td>
				</tr>
				<tr>
					<td><p2>$textconfirm</p2></td>
					<td><input name='cpass' type='Password' id='cpass' oninput=\"allowedchar('cpass');\" style='height:25px;width:220px;font-size;22px;font-weight:bold;border:1px black solid;'></td>
				</tr>
				<tr>
					<td><p2>$textiam</p2></td>
					<td><label>
						<input name='gen' type='radio'  value='Male' checked='checked' />
						<p2>$textmale</p2></label>
						<input type='radio' name='gen'  value='Female' />
						<p2>$textfemale</p2>
					</td>
				</tr>
				<tr>
					<td><p2>$textlanguage</p2></td>
					<td>
						<select name='language' >
							<option value='en'>en</option>
							<option value='gr'>gr</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><p2>$texttimezone</p2></td>
					<td>
						<select name='timezone' style='width:220px;'>";
						for($x=0;$x<count($alltimezones);$x++){
							$tn = datehour($alltimezones[$x]);
							if($alltimezones[$x]=='Europe/Athens'){
								echo "<option value='$alltimezones[$x]' selected='selected'>$alltimezones[$x] : $tn</option>";
							}else{
								echo "<option value='$alltimezones[$x]'>$alltimezones[$x] : $tn</option>";
							}
						}
			echo	"
						</select>
					</td>
				</tr>
			</table><br>
					<p2>$textdob</p2><br>
						<select name='Day'>
							<option value='Day'>$textday</option>";	
							for($i=1; $i<= 31; $i++){
								echo "<option value='$i'>$i</option>";
							}
			echo "	
						</select>
						<select name='Month'>
							<option value='Month'>$textmonth</option>
							<option value='01'>$textJan</option>
							<option value='02'>$textFeb</option>
							<option value='03'>$textMar</option>
							<option value='04'>$textApr</option>
							<option value='05'>$textMay</option>
							<option value='06'>$textJun</option>
							<option value='07'>$textJul</option>
							<option value='08'>$textAug</option>
							<option value='09'>$textSep</option>
							<option value='10'>$textOct</option>
							<option value='11'>$textNov</option>
							<option value='12'>$textDec</option>
						</select>
						<select name='Year'>
							<option value='Year'>$textyear</option>";
								for($i=2005; $i>= 1905; $i--){
									echo "<option value='$i'>$i</option>";
								}
			echo "		</select>		
			<br><br>
			<input type='hidden' id='lang' name='lang' value='$lang'/>
			<div class='g-recaptcha' data-sitekey='6Ldqi9MUAAAAAKy2PoYRcxj4TO_iyGIlrMNbtBFw'></div><br>
			<input class=cbutton type='submit' name='button2' value='$textregister'><br><br>
			</form>
			<!--p2 class='ah3' onclick='showinfo();' style='cursor:pointer;'>$info</p2><br-->
			<div id='charserror' style='background-color:#b4b4b4;width:420px;height:auto;max-height:500px;overflow-y:scroll;top:150px;left:150px;position:absolute;border:2px #000000 solid;visibility:hidden;'>
			</div>";
		}
		if (!isset($_COOKIE['id']) and !isset($_COOKIE['fname']) and !isset($_COOKIE['lname']) and !isset($_COOKIE['gen']) 
		and !isset($_COOKIE['lang']) and !isset($_COOKIE['status']) and !isset($_COOKIE['day']) and !isset($_COOKIE['month']) 
		and !isset($_COOKIE['year']) and isset($_POST['fname']) and ($wronglogin==0) and ($iamrobot==0)){
			$_POST['fname']=str_replace("'","",$_POST['fname']);
			$_POST['fname']=str_replace('"',"",$_POST['fname']);
			$_POST['lname']=str_replace('"',"",$_POST['lname']);
			$_POST['lname']=str_replace("'","",$_POST['lname']);
			$_POST['username']=str_replace("'","",$_POST['username']);
			$_POST['username']=str_replace('"',"",$_POST['username']);
			echo "<p2>";
			if ((mb_strlen($_POST['fname']) < 2) or (mb_strlen($_POST['fname'])>18)){
				echo $checkfirstname;
				//echo "<br>".$_POST['fname'];
				//echo "<br>".mb_strlen($_POST['fname']);
			}
			if ((mb_strlen($_POST['lname']) < 2) or (mb_strlen($_POST['lname'])>18)){
				echo $checklastname;
				//echo "<br>".$_POST['lname'];
				//echo "<br>".mb_strlen($_POST['lname']);
			}
			if ( (mb_strlen($_POST['username']) < 2) or (mb_strlen($_POST['username'])>18) ){
				echo $checkusername;
			}
			if ((mb_strlen($_POST['pass']) < 6) or (mb_strlen($_POST['pass'])>18)){
				echo $checkpass;
			}
			if ($_POST['pass']!=$_POST['cpass']){
				echo $checkcpass;
			}
			if ( ($_POST['Day']=='Day') or ($_POST['Month']=='Month') or ($_POST['Year']=='Year') 
				or ($_POST['Day']=='30' and $_POST['Month']=='02')
				or ($_POST['Day']=='31' and $_POST['Month']=='02')
				or ($_POST['Day']=='31' and $_POST['Month']=='04')
				or ($_POST['Day']=='31' and $_POST['Month']=='06')
				or ($_POST['Day']=='31' and $_POST['Month']=='09')
				or ($_POST['Day']=='31' and $_POST['Month']=='11') ){
				echo $checkdate;	
			}
			echo "</p2>";
			if ((mb_strlen($_POST['fname']) < 2) or (mb_strlen($_POST['fname'])>18) or (mb_strlen($_POST['lname']) < 2) or (mb_strlen($_POST['lname'])>18) 
				or (mb_strlen($_POST['username']) < 2) or (mb_strlen($_POST['username'])>18) or (mb_strlen($_POST['pass']) < 6) or (mb_strlen($_POST['pass'])>18) 
				or ($_POST['pass']!=$_POST['cpass']) 
				or ($_POST['Day']=='Day') or ($_POST['Month']=='Month') or ($_POST['Year']=='Year') 
				or ($_POST['Day']=='30' and $_POST['Month']=='02')
				or ($_POST['Day']=='31' and $_POST['Month']=='02')
				or ($_POST['Day']=='31' and $_POST['Month']=='04')
				or ($_POST['Day']=='31' and $_POST['Month']=='06')
				or ($_POST['Day']=='31' and $_POST['Month']=='09')
				or ($_POST['Day']=='31' and $_POST['Month']=='11') ){
				echo "<br><form action='index.php' method='POST' style=''>
					<input type='hidden' name='lang' value='$lang'/>
					<input type='submit' class='cbutton' name='submit' value='$checkback'>
				</form><br><br>";
			}
			#####################################################################

			##########################################################################
			if (isset($_POST["g-recaptcha-response"])) {
				$gresponse = $reCaptcha->verifyResponse(
					$_SERVER["REMOTE_ADDR"],
					$_POST["g-recaptcha-response"]
				);
				if ($gresponse != null && $gresponse->success) {
					if ((mb_strlen($_POST['fname']) >=2) and (mb_strlen($_POST['fname'])<=18) and (mb_strlen($_POST['lname']) >= 2) and (mb_strlen($_POST['lname'])<=18) 
						and (mb_strlen($_POST['username']) >= 6) and (mb_strlen($_POST['username'])<=18) and (mb_strlen($_POST['pass']) >= 6) and (mb_strlen($_POST['pass'])<=18) 
						and ($_POST['pass']==$_POST['cpass']) 
						and ($_POST['Day']!='Day') and ($_POST['Month']!='Month') and ($_POST['Year']!='Year') 
						and ($_POST['Day'].$_POST['Month']!='3002')
						and ($_POST['Day'].$_POST['Month']!='3102')
						and ($_POST['Day'].$_POST['Month']!='3104')
						and ($_POST['Day'].$_POST['Month']!='3106')
						and ($_POST['Day'].$_POST['Month']!='3109')
						and ($_POST['Day'].$_POST['Month']!='3111') ){
							$result = mysqli_query($con,"SELECT * FROM users ");
							$testusername=0;
							while($row = mysqli_fetch_array($result)){
								if($_POST['username']==$row['username']){
									$testusername=1;
								}
							}
							if($testusername==1){						
								echo "<p2>$usernameexists</p2><br><form action='index.php' method='POST' style=''>
								<input type='hidden' name='lang' value='$lang'/>
								<input type='submit' class='cbutton' name='submit' value='$checkback'>
								</form><br><br>";						
							}else{
								$activation=activationcode();
								echo "<p2>$createaccount</p2><br><br><p style='word-wrap: break-word;'><b>$Mnemonic:</b></p><br><div style='word-wrap: break-word;width:320px;height:auto;background-color:#FFFFFF;'><p5 style='word-wrap: break-word;'>$activation</p5><br><br></div><br><br>";
								$id=newid();
								$friends=serialize(array());
								$frequest=serialize(array());
								$blocked=serialize(array());
								$othersblock=serialize(array());
								if($_POST['gen']=='Male'){
									$pimg='img/male.png';
								}else{
									$pimg='img/female.png';
								}
								if( ($_POST['language']!="gr") and ($_POST['language']!="en")){
									$_POST['language']="en";
								}
								if(!in_array($_POST['timezone'],$alltimezones)){
									$_POST['timezone']="Europe/Athens";
								}
								$sql="INSERT INTO users (id, firstname,lastname,username,password,genre,language,day,month,year,friends,frequest,blocked,othersblock,activation,status,pimg,pwall,timezone,othash,coins,lastaction,games)
								VALUES ('".$id."','".$_POST['fname']."','".$_POST['lname']."','".$_POST['username']."','".md5(hash('sha512',$_POST['pass']))."','".$_POST['gen']."','".$_POST['language']."'
								,'".$_POST['Day']."','".$_POST['Month']."','".$_POST['Year']."','".$friends."','".$frequest."','".$blocked."','".$othersblock."','".md5(hash('sha512',$activation))."','dead','".$pimg."','img/profilewallpaper.png'
								,'".$_POST['timezone']."','othash','0','0','no' )";
								if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
								$userpath="../users/".$id;
								if (!file_exists($userpath)) {
									mkdir($userpath, 0777, true);
								}
							}
					}
				}else{
					echo "<p2>$rctext</p2><br><form action='index.php' method='POST' style=''>
					<input type='hidden' name='lang' value='$lang'/>
					<input type='submit' class='cbutton' name='submit' value='$checkback'>
					</form><br><br>";
				}
			}else{
					echo "<p2>$rctext</p2><br><form action='index.php' method='POST' style=''>
					<input type='hidden' name='lang' value='$lang'/>
					<input type='submit' class='cbutton' name='submit' value='$checkback'>
					</form><br><br>";
			}
		}
		if ($wronglogin==1){
			echo "
			<p2>$wltext</p2> <br><br>
			<form action='index.php' method='POST' style=''>
				<input type='hidden' name='lang' value='$lang'/>
				<input type='submit' class='cbutton' name='submit' value='$checkback'>
			</form><br><br><a href='forgotpassword.php?forgotpass=true&lang=$lang' class='ah3' ><p2>$textforgotpassword</p2></a><br><br>";
		}
		if ($iamrobot==1){
			echo "
			<p2>$rctext</p2> <br><br>
			<form action='index.php' method='POST' style=''>
				<input type='hidden' name='lang' value='$lang'/>
				<input type='submit' class='cbutton' name='submit' value='$checkback'>
			</form><br><br>";
		}
	?>
</div>
<!--div id='info'>
	<?php /*echo $information*/ ?>
</div-->
<script>
	function allowedchar(id){
		chars=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9','Α','Β','Γ','Δ','Ε','Ζ','Η','Θ','Ι','Κ','Λ','Μ','Ν','Ξ','Ο','Π','Ρ','Σ','Τ','Υ','Φ','Χ','Ψ','Ω','α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','ο','π','ρ','σ','τ','υ','φ','χ','ψ','ω','Ά','Έ','Ή','Ύ','Ί','Ό','Ώ','ά','έ','ή','ύ','ί','ό','ώ','@','.','!','*','&','-','ς',' '];
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
				document.getElementById("charserror").innerHTML = "<div id='notdiv'><input type='image'  onclick='ceclose();' src='img/close.png' style='height:60px;width:60px;float:right;' /><br><p11>Only these characters allowed (!) <br> Μόνο οι παρακάτω χαρακτήρες επιτρέπονται (!) <br><br> "+charstext+"</p11></div>";
			}
		}
		
	}
	function ceclose(){
		document.getElementById("charserror").style.visibility='hidden';
	}
	function showinfo(){
		document.getElementById("info").style.visibility='visible';
		document.getElementById("info").style.height='auto';
	}
</script>
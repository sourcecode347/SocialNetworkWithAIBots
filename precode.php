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

<script src='jquery.js'></script>
<script>
$(document).ready(function() {
    $(window).keydown(function(event){
        if(event.keyCode == 116) {
            event.preventDefault();
			window.location.replace(window.location.href);
		}
	});
});
</script>
<?php
	$superpostcost=3.00;
	$marketplacecost=1.50;
	$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
	while($row = mysqli_fetch_array($result)){
		$coins=$row['coins'];
	}
	##########################################################
	#  FROM activation.php  -  activation code  - activate account
	##########################################################
	if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
	and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='dead') 
	and isset($_POST['actcode']) ) {
		$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
		while($row = mysqli_fetch_array($result)){
			$activation=$row['activation'];
		}
		if(md5(hash('sha512',$_POST['actcode']))==$activation){
			$sql="UPDATE users SET status='active' WHERE id='".$_COOKIE['id']."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			$_COOKIE['status']='active';
			setcookie('status', 'active', time()+60*60*24*365, '/', 'fullhood.com');
			//setcookie('status', 'active', time()+60*60*24*365);
		}
	}
	##########################################################
	#  FROM profile.php  -  get id - redirect and variables
	##########################################################
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
	#########################################################
	# GET NOTIFICATION ID
	#########################################################
	function getnotid(){
		include("mysql.php");
		$result = mysqli_query($con,"SELECT * FROM notifications ORDER BY notid DESC ");
		$id=0;
		while($row = mysqli_fetch_array($result)){
			$id=$row['notid']+=1;
			break;
		}
		return $id;
	}
	#########################################################
	# FIX ARRAY FRIENDS
	########################################################
	if(isset($_COOKIE['id'])){
		$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
		while($row = mysqli_fetch_array($result)){
			$friends=unserialize($row['friends']);
			$friends=serialize(array_unique($friends));
			$sql="UPDATE users SET friends='".$friends."' WHERE id='".$_COOKIE['id']."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
		}
	}
?>
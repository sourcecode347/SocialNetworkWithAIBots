<?php
ob_start();
include("../mysql.php"); 
include_once("../login.php"); 
include_once("../lang.php");
include_once("../precode.php");
include_once("../timezones.php");
	header('Content-Type: application/json', true);
	if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
	and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
	and (securelogin()==true) ) {
		$AIbots=array("EzTWO6wD93bJI2Iu9GJHUTFclxAYy2e3WDU9iNcOYyaB9eZ6bVFsN0qgDxcSTbPo","cxpvZhfEM1mrVaLMfHthoFC9xgN1uP6WxIMncsnpfwUS5DUc7Xi3OzbSaj0rrSFn"
			,"32jK4vWT7uxJrwiWiGbCFoA1XvXEiY5QngXEwDY0vl8XL6pKzNJi2VAkYmAbIjEg","BtmH7j1xVuNkRp9Zlba97vsiLHHkyodTsjfbRUxcqI9FRLGFLjur8tv6a3TW1W2y"
			,"3CKQONflXVGtxPW0aa0SC7zZuoKOiyPDUYWbHT0RAYMuW3wUIbP2IrAeqhPyOKvD","Rfv4PkYp62XO8eDI8fJM57tvLEaMoKwDff1otBDOgHfuIPKM8ShzWWctplZxcmYJ"
			,"wR7ezDpJzQ3BI0Ll1VgzYJLRf8HPdRfixs8TcM8HYxEt9So8c2gr7m3qqbykyK7Y","bbSUf58x60OEHX1VanxT0JXpCLFqDi7h8IKSu340hJdtQueTyqAyMWcTSkPi61EW"
			,"39JlDkcBhumGNK9eFjyx0sgRMTW6xLRBfJxSXawsOBSUZeKhEkV4QMnFYg2FtRHa","cPE4ygWH5U466kQ5rlzcYgLV3iTw9vWhYnaB3Y55hl7FCDwkuq1dBXOYuUincwHK"
			,"bO7XoQo09yOA0NYnhhtkggcWE6NBH2LqBD7b4pphwnjJAEXhJEwcMzpeIc1Q91f6","YD0CEey1MrPYBOnCxmiZWyYpZyYcBR3R9FSLSH0Vskaifm2A1D5v7YExqq55zis7");
		if( (isset($_POST['getfriendrequests'])) and (isset($_POST['getfriendrequestsdata'])) and (isset($_POST['lastaction'])) ){
			$aftercodedata=array();
			$fdata=array();
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$frequest=unserialize($row['frequest']);
				for($x=0;$x<count($frequest);$x++){
					$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$frequest[$x]."' ");
					while($row2 = mysqli_fetch_array($result2)){
						$uid=$row2['id'];
						$ufname=$row2['firstname'];
						$ulname=$row2['lastname'];
						$upimg=$row2['pimg'];
						$ugen=$row2['genre'];
						array_push($fdata,[$uid,$ufname,$ulname,$upimg,$ugen]);
					}
				}
			}
			$location=$_POST['lastaction'];
			$games="no";
			if ( (strpos($location, 'blackjack.php') !== false) || (strpos($location, 'spider.php') !== false) || (strpos($location, 'yahtzee.php') !== false) ) {
				$games="yes";
			}
			$lastaction=date5min("Europe/Athens");
			$sql="UPDATE users SET lastaction='$lastaction' WHERE id='".$_COOKIE['id']."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			$sql="UPDATE users SET games='$games' WHERE id='".$_COOKIE['id']."' ";
			if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
			$onlineusers=array();
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$friends=unserialize($row['friends']);
			}
			for($x=0;$x<count($friends);$x++){
				$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$friends[$x]."' ");
				while($row = mysqli_fetch_array($result)){
					$play=$row['games'];
					$fla=$row['lastaction'];
					$tla=datenow2("Europe/Athens");
					if(in_array($friends[$x], $AIbots)){
						array_push( $onlineusers , array($friends[$x],true) );	
					}else{
						if($fla<$tla){
							array_push( $onlineusers , array($friends[$x],false) );
						}else{
							if($play=="yes"){
								array_push( $onlineusers , array($friends[$x],null) );
							}else{
								array_push( $onlineusers , array($friends[$x],true) );
							}
						}
					}
				}
			}
			array_push($aftercodedata,$frequest,$fdata,$onlineusers);
			ob_end_clean();
			echo json_encode($aftercodedata);
		}
	}
?>
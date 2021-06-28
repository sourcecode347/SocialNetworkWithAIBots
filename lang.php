<?php
    $lang="en";
    $slang="en";
	//$hreflang='el';
	$hreflang='en';
	$readmore="Περισσότερα...";
    if(isset($_GET['lang'])){
	    if($_GET['lang']=="gr"){
			$lang="gr";
			$slang="gr";
			$hreflang='el';
			$readmore="Περισσότερα...";
		}
	    if($_GET['lang']=="en"){
			$lang="en";
			$slang="en";
			$hreflang='en';
			$readmore="Read More...";
		}
    }
    if(isset($_POST['lang'])){
	    if($_POST['lang']=="gr"){
			$lang="gr";
			$slang="gr";
			$hreflang='el';
			$readmore="Περισσότερα...";
		}
	    if($_POST['lang']=="en"){
			$lang="en";
			$slang="en";
			$hreflang='en';
			$readmore="Read More...";
		}
    }
    if(isset($_POST['language'])){
	    if($_POST['language']=="gr"){
			$lang="gr";
			$slang="gr";
			$hreflang='el';
			$readmore="Περισσότερα...";

		}
	    if($_POST['language']=="en"){
			$lang="en";
			$slang="en";
			$hreflang='en';
			$readmore="Read More...";
		}
    }
	if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) 
	and isset($_COOKIE['lang']) and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) ) {
		$lang=$_COOKIE['lang'];
	}
?>
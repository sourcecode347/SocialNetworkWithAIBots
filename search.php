<?php
ob_start();
include("mysql.php"); 
include_once("login.php"); 
include_once("lang.php");
include_once("precode.php");
include_once("timezones.php");
	header('Content-Type: application/json', true);
	function greektolower($str){
		$str=str_replace("Α","α",$str);
		$str=str_replace("Β","β",$str);
		$str=str_replace("Γ","γ",$str);
		$str=str_replace("Δ","δ",$str);
		$str=str_replace("Ε","ε",$str);
		$str=str_replace("Ζ","ζ",$str);
		$str=str_replace("Η","η",$str);
		$str=str_replace("Θ","θ",$str);
		$str=str_replace("Ι","ι",$str);
		$str=str_replace("Κ","κ",$str);
		$str=str_replace("Λ","λ",$str);
		$str=str_replace("Μ","μ",$str);
		$str=str_replace("Ν","ν",$str);
		$str=str_replace("Ξ","ξ",$str);
		$str=str_replace("Ο","ο",$str);
		$str=str_replace("Π","π",$str);
		$str=str_replace("Ρ","ρ",$str);
		$str=str_replace("Σ","σ",$str);
		$str=str_replace("Τ","τ",$str);
		$str=str_replace("Υ","υ",$str);
		$str=str_replace("Φ","φ",$str);
		$str=str_replace("Χ","χ",$str);
		$str=str_replace("Ψ","ψ",$str);
		$str=str_replace("Ω","ω",$str);
		$str=str_replace("Ά","α",$str);
		$str=str_replace("ά","α",$str);
		$str=str_replace("Έ","ε",$str);
		$str=str_replace("έ","ε",$str);
		$str=str_replace("Ή","η",$str);
		$str=str_replace("ή","η",$str);
		$str=str_replace("Ί","ι",$str);
		$str=str_replace("ί","ι",$str);
		$str=str_replace("Ό","ο",$str);
		$str=str_replace("ό","ο",$str);
		$str=str_replace("Ύ","υ",$str);
		$str=str_replace("ύ","υ",$str);
		$str=str_replace("Ώ","ω",$str);
		$str=str_replace("ώ","ω",$str);
		return $str;
	}
	if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
	and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
	and (securelogin()==true) ) {
		if (isset($_REQUEST['q'])){
			$q=$_REQUEST['q'];
			$usernames=array();
			$result = mysqli_query($con,"SELECT * FROM users ORDER BY RAND() LIMIT 10000");
			while($row = mysqli_fetch_array($result)){
				if ($q !== "") {
					$q = strtolower(greektolower($q));
					$len=strlen($q);
					$addto=true;
					if (stristr($q, substr(strtolower(greektolower($row['firstname'])), 0, $len))) {
						array_push($usernames,array($row['id'],$row['firstname'],$row['lastname'],$row['pimg']));
						$addto=false;
					}
					if (stristr($q, substr(strtolower(greektolower($row['lastname'])), 0, $len))) {
						if ($addto==true){
							array_push($usernames,array($row['id'],$row['firstname'],$row['lastname'],$row['pimg']));
							$addto=false;
						}
					}
				}
			}
			ob_end_clean();
			echo json_encode($usernames);
		}
	}
?>
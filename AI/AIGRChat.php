<?php
ob_start();
include("../mysql.php"); 
include("../timezones.php"); 
include("convertions.php"); 
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
	if( (isset($_POST['id'])) and ($_POST['pass']=="AI@@@///!!!") ){
		$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_POST['id']."' ");
		while($row = mysqli_fetch_array($result)){
			$friends=unserialize($row['friends']);
		}
		for($f=0;$f<count($friends);$f++){
			$mesid1=0;
			$mesid2=0;
			$xmes=Null;
			$result = mysqli_query($con,"SELECT * FROM messages WHERE actor1='".$friends[$f]."' AND actor2='".$_POST['id']."' ORDER BY mesid DESC LIMIT 1");
			while($row = mysqli_fetch_array($result)){
				$actor1=$row['actor1'];
				$mesid1=(int)$row['mesid'];
				$message=strtolower(greektolower($row['message']));
				$result2 = mysqli_query($con,"SELECT * FROM messages WHERE actor1='".$_POST['id']."' AND actor2='".$actor1."' ORDER BY mesid DESC LIMIT 1");
				while($row2 = mysqli_fetch_array($result2)){
					$mesid2=(int)$row2['mesid'];
				}
				if($mesid1>$mesid2){
					$response=Null;
					for($x=0;$x<count($convertions);$x++){
						$ccount=count($convertions[$x][0]);
						$ncount=0;
						for($c=0;$c<count($convertions[$x][0]);$c++){
							if (strpos($message, $convertions[$x][0][$c]) !== false) {
								$ncount+=1;
								if($ncount==$ccount){
									$mesid=0;
									$result3 = mysqli_query($con,"SELECT * FROM messages ORDER BY mesid DESC");
									while($row3 = mysqli_fetch_array($result3)){
										$mesid=$row3['mesid']+1;
										break;
									}
									$newmessage=$convertions[$x][1];
									echo $newmessage;
									$sql="INSERT INTO messages (actor1, actor2 ,mesid ,message, readed ,date, timezone)
									VALUES ('".$_POST['id']."' , '".$actor1."' , '".$mesid."' , '".$newmessage."' , ".((int) false)." , '".datenow("Europe/Athens")."' , 'Europe/Athens' )";
									if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
									$response=True;
								}
							}
						}
						if($response!=Null){
							break;
						}
					}
				}
				break;
			}
		}
	}
	#ob_end_clean();
	#echo json_encode("Ok!");
?>
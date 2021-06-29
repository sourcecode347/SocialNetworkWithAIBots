<?php 
include("../mysql.php"); 
include_once("login.php"); 
include_once("../lang.php");
include_once("../precode.php");
include_once("../timezones.php");
header("Content-Type: text/html; charset=utf-8");

	#error_reporting(E_ALL);
	ini_set('display_errors', 0);
	######################################
	###  SETTINGS
	######################################
	$server='localhost';
	$root='root';
	$rootpass='anonbaz1983mysql';
	$db='news_soccer_bot';
	$domain='https://fullhood.com';
	$hreflink='https://fullhood.com/news.php';
	$ogurl='https://fullhood.com/news.php';
	$favicon="../favicon-32x32.png";
	$homeicon="../img/news.png";
	$ptitle="FullHood News";
	$ogimage="../img/ogimage1024x512.png";
	$pdescription="fullhood Social Network With News !!!";
	$zdescription="fullhood,full,hood";
	$yandexVer='';
	$alexaVer='';
	$googleVer='BNYY2FnoBtgXmdgE3yO7aIf-FSnTZyS17I0idZETuy0';
	$bingVer='C6645F360922FC2DB3F085129F7A1E51';
	$copyright=" 2020 www.fullhood.com";
	$breakword=3; # Default = 3+
	######################################
	###  / SETTINGS
	######################################
	$activetitle=0;
	$pkeywords=$ptitle.",".str_replace(" ",",",$zdescription);
	$categories=array();
	
	
	$result = mysqli_query($con,"SELECT * FROM news ");
	while($row = mysqli_fetch_array($result)){
		$fcat=$row['cat'];
		if( ! in_array($fcat,$categories) ){array_push($categories,$fcat);}
	}
	
########################################################################
# REDIRECTS FOR SECURITY
########################################################################
	$langs=array('en','gr');
	if( ((isset($_GET['lang'])) and (!in_array($_GET['lang'],$langs)) ) or ( (isset($_GET['cat'])) and (!in_array($_GET['cat'],$categories)) and ($_GET['cat']!="nocat") ) ){
		header('Location: index.php');
	}
	if(isset($_GET['nid'])){
		$checkid=0;
		
		
		$result = mysqli_query($con,"SELECT * FROM news order by id desc");
		$pageprint=0;
		while($row = mysqli_fetch_array($result)){
			if($_GET['nid']==$row['id']){
				$checkid=1;
			}
		}
		
		if($checkid==0){
			header('Location: index.php');
		}
	}
if( (isset($_GET['lang'])) and (isset($_GET['nid'])) ){
	$lang=$_GET['lang'];
	$nid=$_GET['nid'];
	$access=0;
	
	
	$result = mysqli_query($con,"SELECT * FROM news ");
	while($row = mysqli_fetch_array($result)){
		if($nid==$row['id'] and $lang==$row['lang']){
			$access=1;
		}
	}
	if($access==1){
		$activetitle=1;
		$result = mysqli_query($con,"SELECT * FROM news WHERE id='$nid' AND lang='$lang' ");
		while($row = mysqli_fetch_array($result)){
			$ptitle=$row['title'];
			$ogimage=$row['img'];
			if ( (strpos($ogimage,'img/') !== false) and (strpos($ogimage,'http://') === false) 
				and (strpos($ogimage,'https://') === false) ){
					$ogimage="https://fullhood.com/".$ogimage;
			}
			$pdescription=substr($row['body'],0,147)."...";
			$zdescription=substr($row['body'],0,60);
			$pkeywords=$zdescription;
			$badkeywords=array(",τον,",",για,",",το,",",τη,",",την,",",στο,",",της,",",να,",",και,",",στην,",",έχει,",",μας,",",σας,",",τους,",",τις,",",οι,",",ο,",",Ο,",",Η,", ",η,",",τα,",",σε,",",the,",",The,",",a,",",An,",",And,",",and,",",of,",",Of,",",In,",",in,",",On,",",on,",",At,",",at,",",this,",",This,",",These,",",O,",",o,");
			$badsymbols=array(".","?","!",";","-","+","_","'",'"');
			for($bkw=0;$bkw<count($badsymbols);$bkw++){
				$pkeywords=str_replace($badsymbols[$bkw],"",$pkeywords);
			}
			$pkeywords=str_replace(" ",",",$pkeywords);
			for($bkw=0;$bkw<count($badkeywords);$bkw++){
				$pkeywords=str_replace($badkeywords[$bkw],",",$pkeywords);
			}
		}
		$threekeys=$pkeywords;
		$strlen=strlen($threekeys);
		$pkeywords="";
		$lcount=0;
		$hashtag="";
		$hashword=$breakword-2;
		$startword=$breakword-3;
		for( $i = 0; $i < $strlen; $i++ ) {
			if ($threekeys[$i]==","){$lcount+=1;}
			if ($lcount==$breakword){break;}
			if ($lcount==$hashword and $threekeys[$i]!=","){$hashtag.=$threekeys[$i];}
			if($lcount>=$startword){$pkeywords.=$threekeys[$i];}
		} 
	}
	
}
	$slang='gr';
	$readmore="Περισσότερα...";
    if(isset($_GET['lang'])){
	    if($_GET['lang']=="gr"){
			$slang="gr";
		}
	    if($_GET['lang']=="en"){
			$slang="en";
		}
    }
    if(isset($_POST['lang'])){
	    if($_POST['lang']=="gr"){
			$slang="gr";
		}
	    if($_POST['lang']=="en"){
			$slang="en";
		}
    }
	if( ( (isset($_POST['language'])) and ($_POST['language']=='en') ) or ( (isset($_GET['lang'])) and ($_GET['lang']=='en') ) ){
		$slang='en';
		$hreflang=$slang;
		$readmore="Read more...";
	}
	if( ( (isset($_POST['language'])) and ($_POST['language']=='gr') ) or ( (isset($_GET['lang'])) and ($_GET['lang']=='gr') ) ){
		$slang='gr';
		$hreflang='el';
		$readmore="Περισσότερα...";
	}
	$cat='nocat';
	if (isset($_POST['category'])){
		$tcat=$_POST['category'];
		if (in_array($tcat, $categories)){$cat=$tcat;}
	}
	if(isset($_GET['cat'])){		
		$tcat=$_GET['cat'];
		if (in_array($tcat, $categories)){$cat=$tcat;}
	}
	$page="1";
	if(isset($_GET['page'])){		
		$symbols=array("%","<",">","/","\\","'",'"',"?","(",")",";","a",'b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		for( $i = 0; $i < count($symbols); $i++ ){
			if (strpos($_GET['page'],$symbols[$i]) !== false) {
				header('Location: index.php');
			}
		}
		$page=$_GET['page'];
	}
	if(isset($_POST['page'])){
		$page=$_POST['page'];
	}
if(isset($_GET['nid'])){
	$access2=0;
	
	
	$result = mysqli_query($con,"SELECT * FROM news ");
	while($row = mysqli_fetch_array($result)){
		if($_GET['nid']==$row['id'] and $slang==$row['lang']){
			$access2=1;
		}
	}
	if($access2==1){
		$xtitle=str_replace(" ","_",$ptitle);
		$xtitle=str_replace("/","_",$xtitle);
		$xtitle=str_replace("\\","_",$xtitle);
		$plink=$domain."/news.php?nid=$nid%26lang=$slang";
		$ogurl=$domain."/news.php?nid=$nid&lang=$slang&title=$xtitle";
		$hreflink=$hreflink."?id=$nid&lang=$slang&title=$xtitle";
	}else{$plink=$domain;}
	
}else{$plink=$domain;}
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
<link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
<link rel="manifest" href="../site.webmanifest">
<link rel="mask-icon" href="../safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="robots" content="index, follow, noodp, noydir">
		<meta name="distribution" content="web"/>
		<meta name="viewport" content="width=device-width, initial-scale=0.66">
		<meta name="viewport" content="height=device-height, initial-scale=0.33">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $ptitle; ?></title>
		<link rel="alternate" href="<?php echo $hreflink;?>" hreflang="<?php echo $hreflang;?>"/>
		<meta name="description" content="<?php echo $pdescription; ?>" />
		<meta property="og:image" content="<?php echo $ogimage;?>"/>
		<meta property="og:image:url" content="<?php echo $ogimage;?>"/>
		<meta property="og:title" content="<?php echo $ptitle;?>"/>
		<meta property="og:description" content="<?php echo $pdescription;?>"/>
		<meta property="og:url" content="<?php echo $ogurl;?>"/>
		<meta name="keywords" content="<?php echo $pkeywords;?>"/>
		<meta name='yandex-verification' content='<?php echo $yandexVer; ?>' />
		<meta name="alexaVerifyID" content="<?php echo $alexaVer; ?>"/>
		<meta name="google-site-verification" content="<?php echo $googleVer; ?>" />
		<meta name="msvalidate.01" content="<?php echo $bingVer; ?>" />
		
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<script src="../jquery.js"></script>
	</head>	
	<!--body style='background-image: radial-gradient(#ffffff, #80ccff, #0099ff);width:100%;height:100%;'-->
	<body style='background-image: radial-gradient(#ffffff, #e6e6e6, #cccccc);width:100%;height:100%;'>
		<center>
		<div id='content'>
			<center>
			<div id='mobileflow'>
			<!------------------------------------------------------------------------------------------------------->
				<div id='p-pager'>
					<form action='news.php' method='POST' style='float:left;margin-left:10px;display:inline;'>
						<input type='hidden' name='language' value='<?php echo $slang;?>'/>
						<input type='hidden' name='category' value='nocat'/>
						<input type='image' name='submit' src='<?php echo $homeicon; ?>' style='height:50px; width:50px;' value='Submit' />
					</form>
					<form action='news.php' method='post' style='float:left;display: inline;'>
						<select class='cselect' name='category'>
							<?php
								for($c=0;$c<count($categories);$c++){
									if($slang=="gr"){
										if($categories[$c]=="Sports"){$namecat="Αθλητικά";}
										if($categories[$c]=="Politics"){$namecat="Πολιτικά";}
										if($categories[$c]=="Tech"){$namecat="Τεχνολογία";}
										if($categories[$c]=="Art"){$namecat="Τέχνη";}
										if($categories[$c]=="General"){$namecat="Γενικά";}
									}else{
										$namecat=$categories[$c];
									}
									if ($cat==$categories[$c]){
										echo "<option value='$categories[$c]' selected='True'>$namecat</option>";
									}else{
										echo "<option value='$categories[$c]'>$namecat</option>";
									}
								}
							?>
						</select>
						<input type='hidden' name='language' value='<?php echo $slang;?>' />
						<input type='submit' class='cbutton' value="Go!"/>
					</form>
					<form action='news.php' method='POST' style='float:left;margin-left:10px;'>
						<input type='hidden' name='language' value='en'/>
						<input type='hidden' name='category' value='<?php echo $cat;?>'/>
						<input type='image' name='submit' src='../img/eng.jpg' style='height:50px; width:70px;' value='Submit' />
					</form>
					<form action='news.php' method='POST' style='float:left;margin-left:10px;'>
						<input type='hidden' name='language' value='gr'/>
						<input type='hidden' name='category' value='<?php echo $cat;?>'/>
						<input type='image' name='submit' src='../img/gr.jpg' style='height:50px; width:70px;' value='Submit' />
					</form>
				</div><br>
				<div id='pager'>
					<marquee behavior='scroll' direction='left' scrollamount='4' style='width:100%;'>
					<?php
						
						
						$result = mysqli_query($con,"SELECT * FROM news order by id desc");
						$scrollcount=0;
						while($row = mysqli_fetch_array($result)){
							if($row['lang']==$slang ){
								$stitle=str_replace(" ","_",$row['title']);
								$stitle=str_replace("/","_",$stitle);
								$stitle=str_replace("\\","_",$stitle);
								$stitle=str_replace("&","",$stitle);
								$scrollcount+=1;
								echo "<a class='Scroll' href='news.php?nid=".$row['id']."&lang=".$row['lang']."&title=".$stitle."' >".$row['title']."</a>".str_repeat('&nbsp',30);
								if($scrollcount==50){break;}
							}
						}
						
					?>
					</marquee>
				</div>
				<?php 
					if( (isset($_GET['lang'])) and (isset($_GET['nid'])) ){
						$lang=$_GET['lang'];
						$nid=$_GET['nid'];
						$access=0;
						
						
						$result = mysqli_query($con,"SELECT * FROM news ");
						while($row = mysqli_fetch_array($result)){
							if($nid==$row['id'] and $lang==$row['lang']){
								$access=1;
							}
						}
						if($access==1){
							$stitle=str_replace(" ","_",$ptitle);
							$stitle=str_replace("/","_",$stitle);
							$stitle=str_replace("\\","_",$stitle);
							$stitle=str_replace("&","",$stitle);
							$plink=$domain."/news.php?nid=$nid%26lang=$slang%26title=$stitle";
							$onclick="onclick=\"window.open(this.href, 'popupwindow', 'width=500,height=500,scrollbars,resizable');return false;\"";
							$result = mysqli_query($con,"SELECT * FROM news WHERE id='$nid' AND lang='$lang' ");
							while($row = mysqli_fetch_array($result)){
								$hits=$row['hits']+1;
								mysqli_query($con,"UPDATE news SET hits='$hits' WHERE id='$nid' AND lang='$lang' ");
								echo "
								<div id='article'>
									<div id='p-pager'>
										<!--input type='image' name='submit' src='img/back.png' onclick='goBack();' style='height:70px; width:70px; float:left;margin-left:10px;' value='Submit' /-->
										<form action='news.php' method='POST' style='float:left;margin-left:10px;'>
											<input type='hidden' name='language' value='$slang'/>				
											<input type='hidden' name='category' value='$cat'/>
											<input type='hidden' name='page' value='$page'/>
											<input type='image' name='submit' src='../img/back.png' style='height:70px; width:70px;' value='Submit' />
										</form>
									</div>
									<h1><u>".$row['title']."</u></h1>".$row['date']."<br>";
								echo "
									<img src='../".$row['img']."' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" 
											style=' width:96%; height:auto; border:1px black solid;'></img><br><br>";
								echo "
									<p13>".$row['body']."</p13><br><br>";
								echo "
									<div id='inarticleads'>
										<iframe src='https://soccer-bot.com/frame2.php' frameBorder='0' style='width:350px;height:300px;overflow:hidden;overflow-x:hidden;overflow-y:hidden;'></iframe>
									</div>
									<div id='share-buttons'>
										<a href='http://www.facebook.com/sharer.php?u=$plink' $onclick>
										<img src='../img/facebook.png' alt='Facebook' /></a>
										<a href='http://twitter.com/share?url=$plink&text=$ptitle&hashtags=$hashtag' $onclick>
										<img src='../img/twitter.png' alt='Twitter' /></a>
										<!--a href='https://plus.google.com/share?url=$plink' $onclick>
										<img src='../img/google.png' alt='Google' /></a-->
										<a href='http://www.digg.com/submit?url=$plink' $onclick>
										<img src='../img/diggit.png' alt='Digg' /></a>
										<a href='http://reddit.com/submit?url=$plink&title=$ptitle' $onclick>
										<img src='../img/reddit.png' alt='Reddit' /></a>
										<a href='http://www.linkedin.com/shareArticle?mini=true&url=$plink' $onclick>
										<img src='../img/linkedin.png' alt='LinkedIn' /></a>
										<a href='http://www.stumbleupon.com/submit?url=$plink&title=$ptitle' $onclick>
										<img src='../img/stumbleupon.png' alt='StumbleUpon' /></a>
										<!--a href='//www.pinterest.com/pin/create/button/?url=$plink&media=$ogimage&description=$pdescription' data-pin-do='buttonPin' data-pin-config='above'>
										<img src='../img/pin.png'></img></a>
										<script type='text/javascript' src='//assets.pinterest.com/js/pinit.js'></script-->										
									</div>
								</div>";
								if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
									and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
									and (securelogin()==true) ) {
									if($lang="gr"){
										$textcomment="Σχολίασε";
									}
									if($lang=="en"){
										$textcomment="Comment";
									}
									echo 
									"
									<div id='maincommentnews' style='float:left;height:auto;width:99%;background-color:#cccccc;border: 2px #595959 solid;'>
										<div id='cmntnews' style='visibility:visible;float:left;background-color:#F8F8F8;min-width:500px;width:98%;height:auto;border:2px blue solid;margin:5px;position:relative;'>
											<textarea rows='2' cols='30' id='newsxpost' name='newsxpost' style='font-size:18px;max-width:400px;min-height:80px;'></textarea><br><br>
											<input type='submit' id='cbnews' class='cbutton' value='$textcomment' onclick=\"makecommentnews('$nid');\"/>
											<input type='hidden' id='getnid' name='getnid' value='$nid'/>
											<input type='hidden' id='getlang' name='getlang' value='null'/><br><br>
										</div>
									</div>";
								}else{
									if($slang=="gr"){
										$textreg="Κάντε εγγραφή για να σχολιάσετε ...";
										$butreg="Εγγραφή";
									}
									if($slang=="en"){
										$textreg="Register To Make a Comment";
										$butreg="Register";
									}
									echo 
									"
									<div id='maincommentnews' style='float:left;height:auto;width:99%;background-color:#cccccc;border: 2px #595959 solid;'>
										<div id='cmntnews' style='visibility:visible;float:left;background-color:#F8F8F8;min-width:500px;width:98%;height:auto;border:2px blue solid;margin:5px;position:relative;'>
											<form action='index.php' method='POST'>
												<input type='hidden' name='lang' value='$slang' />
												<p13>$textreg</p13><br><br>
												<input type='submit' id='cbnews' class='cbutton' value='$butreg'/><br><br>
											</form>
										</div>
										<input type='hidden' id='getnid' name='getnid' value='$nid'/>
										<input type='hidden' id='getlang' name='getlang' value='$slang'/>
									</div>";
								}
							}
		
						}
						
					}else{
						
						echo "<input type='hidden' id='getnid' name='getnid' value='null'/>";
						if ($cat=="nocat"){
							$result = mysqli_query($con,"SELECT * FROM news order by id desc");
							$pagecounter=0;
							$rnumber=rand(1,7);
							while($row = mysqli_fetch_array($result)){
								if($row['lang']==$slang ){
									if( (($page*10)>=$pagecounter) and (( ($page-1)*10)<=$pagecounter)  ){
										$stitle=str_replace(" ","_",$row['title']);
										$stitle=str_replace("/","_",$stitle);
										$stitle=str_replace("\\","_",$stitle);
										$stitle=str_replace("&","",$stitle);
										echo "<div id='article'><a class='ah3' href='news.php?nid=".$row['id']."&lang=".$row['lang']."&cat=".$cat."&page=".$page."&title=".$stitle."'><h3>".$row['title']."</h3></a>".$row['date']."<br>";
										echo "<img src='../".$row['img']."' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\"
										style=' width:40%;float:left; margin-left:15px; height:auto;border:1px black solid; '></img><br><br>";
										mb_internal_encoding("UTF-8");
										echo "<p13>".mb_substr($row['body'],0,180).".....</b></p13><a class='ac' href='news.php?nid=".$row['id']."&lang=".$row['lang']."&cat=".$cat."&page=".$page."&title=".$stitle."' >".$readmore."</a><br><br></div>";
									}
									$pagecounter+=1;
									if($pagecounter==$rnumber){
										echo '
											<!--div id="article">
											</div-->
										';
									}
									if($pagecounter==($page*10) ){break;}
								}
							}
							
							
							
							$result = mysqli_query($con,"SELECT * FROM news order by id desc");
							$pageprint=0;
							while($row = mysqli_fetch_array($result)){
								if($row['lang']==$slang ){
									$pageprint+=1;
								}
							}
							
						}else{
							$result = mysqli_query($con,"SELECT * FROM news order by id desc");
							$pagecounter=0;
							while($row = mysqli_fetch_array($result)){
								if($row['cat']==$cat and $row['lang']==$slang){
									if( (($page*10)>=$pagecounter) and (( ($page-1)*10)<=$pagecounter)  ){
										$stitle=str_replace(" ","_",$row['title']);
										$stitle=str_replace("/","_",$stitle);
										$stitle=str_replace("\\","_",$stitle);
										$stitle=str_replace("&","",$stitle);
										echo "<div id='article'><a class='ah3' href='news.php?nid=".$row['id']."&lang=".$row['lang']."&cat=".$cat."&page=".$page."&title=".$stitle."'><h3>".$row['title']."</h3></a>".$row['date']."<br>";
										echo "<img src='../".$row['img']."' 
										onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style=' width:40%;float:left; margin-left:15px; height:auto;border:1px black solid; '></img><br><br>";
										echo "<p13>".substr($row['body'],0,180).".....</b></p13><a class='ac' href='news.php?nid=".$row['id']."&lang=".$row['lang']."&cat=".$cat."&page=".$page."&title=".$stitle."' >".$readmore."</a><br><br></div>";
									}
									$pagecounter+=1;
									if($pagecounter==($page*10) ){break;}
								}
							}
							
							
							
							$result = mysqli_query($con,"SELECT * FROM news order by id desc");
							$pageprint=0;
							while($row = mysqli_fetch_array($result)){
								if($row['cat']==$cat and $row['lang']==$slang ){
									$pageprint+=1;
								}
							}
							
						}
						echo "
						<div id='pager'>";
						$pages=(int)($pageprint/10)+1;
						$pcount=0;
						$p13=(int)$page;
						for($p=$p13-5;$p<$p13;$p++){
							if($p<$p13 and $p>0){
								echo "<a href='news.php?page=".$p."&lang=".$slang."&cat=".$cat."' class='Scroll'>$p</a>".str_repeat('&nbsp',8);
							}
							$pcount+=1;
							if($pcount==5){break;}
						}
						$pcount=0;
						for($p=(int)$page;$p<=$pages;$p++){
							if($p==(int)$page){
								echo "<a style='color:red;' href='news.php?page=".$p."&lang=".$slang."&cat=".$cat."' class='Scroll'>$p</a>".str_repeat('&nbsp',8);
							}else{
								echo "<a href='news.php?page=".$p."&lang=".$slang."&cat=".$cat."' class='Scroll' >$p</a>".str_repeat('&nbsp',8);
							}
							$pcount+=1;
							if($pcount==6){break;}
						}
						echo "</div>";
					}		
				?>
				<div id='footer'>
					© <?php echo $copyright; ?>
				</div>
			<!------------------------------------------------------------------------------------------------------->	
			</div>
			<?php
				if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
					and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
					and (securelogin()==true) ) {
						//include('divfriends.php');
						include('aftercode.php');
				}else{
					//include('divnewusers.php');
					//include('divbanner.php');
				}
			?>
			</center>
		</div>
		<?php include("divheader.php"); ?>
		</center>
		<script>	
			var newscomids=[];
			function updatenewscmnt(){
				if(document.getElementById('getnid').value!="null"){
					try{
						var ulds = $.ajax({
							type: "post",
							url: "../ajax/updatenewscmnt.php",
							data: {'newscmnt': document.getElementById('getnid').value},
							success : function(ncmntdata){
								activecomids=[];
								for(x in ncmntdata){
									cmntuserid=ncmntdata[x][0];
									cmntfname=ncmntdata[x][1];
									cmntlname=ncmntdata[x][2];
									cmntpimg=ncmntdata[x][3];
									cmntcomid=ncmntdata[x][4];
									cmntxpost=ncmntdata[x][5];
									cmntdtime=ncmntdata[x][6];
									cmntpostid=ncmntdata[x][7];
									cmntgen=ncmntdata[x][8];
									activecomids.push(cmntcomid);
									if(cmntuserid==getCookie('id')){
										textdeletecmntbutton="<input type='image'  onclick='deletecmntnews("+cmntcomid+");' src='../img/delete.png' style='height:30px;width:30px;float:right;' />";
									}else{
										textdeletecmntbutton="";
									}
									if (newscomids.includes(cmntcomid)==false){
										if(document.getElementById('getlang').value=="null"){
											if(getCookie('lang')=='gr'){
												if(cmntgen=='Male'){protext="<p5>Ο ";}
												if(cmntgen=='Female'){protext="<p5>Η ";}
												titletext=protext+"<a href='profile.php?id="+cmntuserid+"' class='ah3' ><b>"+cmntfname+" "+cmntlname+"</b></a> σχολίασε στις "+cmntdtime+"</p5>";
											} // jstranslate
											if(getCookie('lang')=='en'){
												titletext="<p5><a href='profile.php?id="+cmntuserid+"' class='ah3' ><b>"+cmntfname+" "+cmntlname+"</b></a> leave a comment on "+cmntdtime+"</p5>";
											}
										}
										if(document.getElementById('getlang').value=='gr'){
											if(cmntgen=='Male'){protext="<p5>Ο ";}
											if(cmntgen=='Female'){protext="<p5>Η ";}
											titletext=protext+"<a href='profile.php?id="+cmntuserid+"' class='ah3' ><b>"+cmntfname+" "+cmntlname+"</b></a> σχολίασε στις "+cmntdtime+"</p5>";
										} // jstranslate
										if(document.getElementById('getlang').value=='en'){
											titletext="<p5><a href='profile.php?id="+cmntuserid+"' class='ah3' ><b>"+cmntfname+" "+cmntlname+"</b></a> leave a comment on "+cmntdtime+"</p5>";
										}
										document.getElementById("maincommentnews").innerHTML+="<div id='newscomment"+cmntcomid+"'"
											+"style='float:left;height:auto;width:99%;background-color:#cccccc;border: 2px #595959 solid;'>"
											+textdeletecmntbutton
											+"<div style='width:100%;height:auto;min-height:50px;'><img src='../"+cmntpimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius: 50%;width:50px;height:50px;float:left;'></img>"+titletext+"</div>"
											+"<div style='width:100%;'><p9><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+cmntxpost+"</xmp></p9></div><br><br>"
										+"</div>";
										newscomids.push(cmntcomid);
									}
								}
								for(x in newscomids){
									if(activecomids.includes(newscomids[x])==false){
										document.getElementById('newscomment'+newscomids[x]).style.visibility='hidden';
										document.getElementById('newscomment'+newscomids[x]).style.height='0px';
										document.getElementById('newscomment'+newscomids[x]).innerHTML='';
										document.getElementById('newscomment'+newscomids[x]).remove();
									}
								}
								newscomids=activecomids;
							}
						});
					}catch(err2){alert(err2.message);}
				}
			}
			function deletecmntnews(cmntid){
				try{
					var ucmnt = $.ajax({
						type: "post",
						url: "../ajax/deletecmntnews.php",
						data: {'cmntid': cmntid},
						success : function(subdata){
							document.getElementById('newscomment'+cmntid).style.visibility='hidden';
							document.getElementById('newscomment'+cmntid).style.height='0px';
							document.getElementById('newscomment'+cmntid).innerHTML='';
							document.getElementById('newscomment'+cmntid).remove();
							newscomids2=[];
							for(x in newscomids){
								if(newscomids[x]!=cmntid){
									newscomids2.push(newscomids[x]);
								}
							}
							newscomids=newscomids2;
						}
					});
				}catch(err2){alert(err2.message);}
			}
			nntime=1000;
			setInterval(function(){
				updatenewscmnt();
				nntime=5000;
			}, nntime);
			$(window).unload(function() {$.cookie('scrollTop',$(window).scrollTop());});
			function goBack(){
			  window.history.back();
			}
			function getCookie(c_name) {
				if (document.cookie.length > 0) {
					c_start = document.cookie.indexOf(c_name + "=");
					if (c_start != -1) {
						c_start = c_start + c_name.length + 1;
						c_end = document.cookie.indexOf(";", c_start);
						if (c_end == -1) {
							c_end = document.cookie.length;
						}
						return unescape(document.cookie.substring(c_start, c_end));
					}
				}
				return "";
			}
			function makecommentnews(mcnid){
				try{
					var ucmnt = $.ajax({
						type: "post",
						url: "../ajax/makecommentnews.php",
						data: {'mcnid': mcnid, 'xcom' : document.getElementById('newsxpost').value},
						success : function(mcndata){
							document.getElementById('newsxpost').value="";
						}
					});
				}catch(err2){alert(err2.message);}
			}
		</script>
	</body>
</html>
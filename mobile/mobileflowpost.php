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
include("../mysql.php"); 
include_once("login.php"); 
include_once("../lang.php");
include_once("../precode.php");
include_once("../timezones.php");
?>
<?php

	$vpostid="";
	$result = mysqli_query($con,"SELECT * FROM posts ");
	while($row = mysqli_fetch_array($result)){
		if($row['postid']==$_GET['postid']){
			$vpostid=$row['postid'];
		}
	}
	echo "<input type='hidden' id='vpostid' value='".$vpostid."' />";
	if($lang=='en'){
		$textpost='Post';
		$image='Image';
		$video='Video';
		$text='Text';
		$exterror='Extension not allowed, please choose a JPEG or JPG or PNG or GIF file.';
		$sizeerror='File size must be excately 15 MB !';
		$textsuperpost="SuperPost";
	}
	if($lang=='gr'){
		$textpost='Δημοσίευση';
		$image='Εικόνα';
		$video='Βίντεο';
		$text='Κείμενο';
		$exterror='Ο τύπος του αρχείου δεν υποστηρίζεται , επιλέχτε αρχεία JPEG ή JPG ή PNG ή GIF .';
		$sizeerror='Το μέγεθος της εικόνας δεν πρέπει να ξεπερνά τα 15 MB !';
		$textsuperpost="Υπερδημοσίευση";
	}
	######################################
	###  FUNCTIONS
	######################################	
	function newimgsrc($ext){
		$run=1;
		while($run==1){
			$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
			$id="";
			for($x=0;$x<64;$x++){
				$id=$id.$char[rand(0,count($char)-1)];
			}
			include('../mysql.php');
			$result = mysqli_query($con,"SELECT * FROM links ");
			$testid=0;
			$newimgsrc="linkimg/".$id.".".$ext;
			while($row = mysqli_fetch_array($result)){
				if($newimgsrc==$row['imgsrc']){
					$testid=1;
				}
			}
			if($testid==0){
				$run=0;
				break;
			}
		}
		return $newimgsrc;
	}
	function userimgsrc($ext){
		$run=1;
		while($run==1){
			$char=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
			$id="";
			for($x=0;$x<64;$x++){
				$id=$id.$char[rand(0,count($char)-1)];
			}
			include('../mysql.php');
			$result = mysqli_query($con,"SELECT * FROM posts WHERE userid='".$_COOKIE['id']."' AND posttype='image' ");
			$testid=0;
			$newimgsrc="users/".$_COOKIE['id']."/".$id.".".$ext;
			while($row = mysqli_fetch_array($result)){
				if($newimgsrc==$row['imgsrc']){
					$testid=1;
				}
			}
			if($testid==0){
				$run=0;
				break;
			}
		}
		return $newimgsrc;
	}
	function emptypost($xpost){
		if (strlen(str_replace(" ","",$xpost))==0){
			return false;
		}else{
			return true;
		}
	}
?>
<script src='../jquery.js'></script>
<script type="text/javascript">
	if(getCookie('lang')=='gr'){
		textcomment='Σχολίασε';
	} // jstranslate
	if(getCookie('lang')=='en'){
		textcomment='Comment';
	}
	function sqlfix(){
		var msgbody = document.getElementById('xpost').value;
		function fix1(find,repl,str) {
			return str.replace(new RegExp(find, 'g'), repl);
		}
		msgbody =fix1("'","", msgbody);
		document.getElementById('xpost').value=msgbody;
	}
	function sqlfix2(cmnttextid){
		cmnttextid="xpost"+cmnttextid;
		var msgbody = document.getElementById(cmnttextid).value;
		function fix1(find,repl,str) {
			return str.replace(new RegExp(find, 'g'), repl);
		}
		msgbody =fix1("'","", msgbody);
		document.getElementById(cmnttextid).value=msgbody;
	}
	function sqlfix3(cmnttextid){
		cmnttextid="subxpost"+cmnttextid;
		var msgbody = document.getElementById(cmnttextid).value;
		function fix1(find,repl,str) {
			return str.replace(new RegExp(find, 'g'), repl);
		}
		msgbody =fix1("'","", msgbody);
		document.getElementById(cmnttextid).value=msgbody;
	}
	function utf8Encode(unicodeString) {
		if (typeof unicodeString != 'string') throw new TypeError('parameter ‘unicodeString’ is not a string');
		const utf8String = unicodeString.replace(
			/[\u0080-\u07ff]/g,  // U+0080 - U+07FF => 2 bytes 110yyyyy, 10zzzzzz
			function(c) {
				var cc = c.charCodeAt(0);
				return String.fromCharCode(0xc0 | cc>>6, 0x80 | cc&0x3f); }
		).replace(
			/[\u0800-\uffff]/g,  // U+0800 - U+FFFF => 3 bytes 1110xxxx, 10yyyyyy, 10zzzzzz
			function(c) {
				var cc = c.charCodeAt(0);
				return String.fromCharCode(0xe0 | cc>>12, 0x80 | cc>>6&0x3F, 0x80 | cc&0x3f); }
		);
		return utf8String;
	}
	function utf8Decode(utf8String) {
		if (typeof utf8String != 'string') throw new TypeError('parameter ‘utf8String’ is not a string');
		// note: decode 3-byte chars first as decoded 2-byte strings could appear to be 3-byte char!
		const unicodeString = utf8String.replace(
			/[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g,  // 3-byte chars
			function(c) {  // (note parentheses for precedence)
				var cc = ((c.charCodeAt(0)&0x0f)<<12) | ((c.charCodeAt(1)&0x3f)<<6) | ( c.charCodeAt(2)&0x3f);
				return String.fromCharCode(cc); }
		).replace(
			/[\u00c0-\u00df][\u0080-\u00bf]/g,                 // 2-byte chars
			function(c) {  // (note parentheses for precedence)
				var cc = (c.charCodeAt(0)&0x1f)<<6 | c.charCodeAt(1)&0x3f;
				return String.fromCharCode(cc); }
		);
		return unicodeString;
	}
	function linkfinder(){
		var posttype = document.getElementById('posttype').value;
		if (posttype=="text"){
			var post = document.getElementById('xpost').value;
			sub1 = "http://";
			sub2 = "https://";
			if ( (post.indexOf(sub1) !== -1) || (post.indexOf(sub2) !== -1) ){
				if (post.indexOf(sub1) !== -1){
					var sub=sub1;
				}else{
					var sub=sub2;
				}
				var link=sub;
				var start=post.indexOf(sub)+sub.length;
				for (var i=start; i < post.length; i++) {
					link+=post[i];
					if (post[i]==" ")  {
						break;
					}
				}
				$.ajax({
					url: '../checklink.php',
					type: 'post',
					data: { "link": link},
					success: function(response) {
						if (response[0]=="true"){
							metaimg=response[1];
							metatitle=response[2];
							metadesc=response[3];
							host=response[4];
							if (metatitle!="false"){
								if (metadesc=="false"){metadesc=metatitle;}
								if ( (metaimg.indexOf(host) === -1) && (metaimg!="false") && (metaimg.indexOf(sub1) === -1) && (metaimg.indexOf(sub2) === -1) ){
									if (metaimg[0]=='/'){
										metaimg=host+metaimg;
									}else{
										metaimg=host+'/'+metaimg;
									}
								}
								if( (metaimg.indexOf(sub1) === -1) && (metaimg.indexOf(sub2) === -1) && (metaimg!="false") ){metaimg=sub+metaimg;}
								var metadatadiv = document.getElementById('metadata');
								metadatadiv.innerHTML = "<div style='width:100%;height:auto;'><a href='"+link+"' class='ah3' target='_blank'><p4><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+utf8Decode(metatitle)+"</xmp></p4></a></div><div style='width:100%;height:auto;float:left;'><img src='"+metaimg+"' id='mimg' onError=\"this.onerror = '';this.style.visibility='hidden';;this.style.width='0px';;this.style.height='0px';\" style='width:300px;height:200px;float:left;'></img><div style='width:300px;;float:left;display:inline;'><p5><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+utf8Decode(metadesc)+"</xmp></p5></div></div><div style='width:100%;height:auto;'><center><p2>"+host+"</p2></center></div>";
								document.getElementById('posttype').value='link';
								document.getElementById('metaimg').value=metaimg;
								document.getElementById('metatitle').value=metatitle;
								document.getElementById('metadesc').value=metadesc;
								document.getElementById('metalink').value=link;
								document.getElementById('metahost').value=host;
							}
							//if(metatitle!="false"){alert(metatitle+" : "+host+" : "+metaimg+" : "+metadesc);}
						}
					}
				});
			}
		}
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
	function postimage(){
		$("#postimg").show();
		document.getElementById("imginp").style.visibility='visible';
		var metadatadiv = document.getElementById('metadata');
		metadatadiv.innerHTML = "";
		document.getElementById('posttype').value='image';
		document.getElementById('metaimg').value='false';
		document.getElementById('metatitle').value='false';
		document.getElementById('metadesc').value='false';
		document.getElementById('metalink').value='false';
		document.getElementById('metahost').value='false';
		document.getElementById('videoid').value='false';
	}
	function linkyoutube(){
		var youtubelink = document.getElementById('youtubelink').value;
		var find ='watch?v=';
		if (youtubelink.indexOf(find) !== -1){
			var videoid='';
			var start=youtubelink.indexOf(find)+find.length;
			for (var i=start; i < youtubelink.length; i++) {
				videoid+=youtubelink[i];
				if (youtubelink[i]=="&")  {
					break;
				}
			}
			var metadatadiv = document.getElementById('metadata');
			metadatadiv.innerHTML = "<iframe width='500' height='315' src='https://www.youtube.com/embed/"+videoid+"' frameborder='0' allowfullscreen></iframe>";
			document.getElementById('videoid').value=videoid;
		}
	}
	function postvideo(){
		$("#postimg").hide();
		if(getCookie('lang')=='gr'){postvideotext='Αντιγράψτε και επικολλήστε ένα σύνδεσμο από βίντεο του youtube :';} // jstranslate
		if(getCookie('lang')=='en'){postvideotext='Copy and paste a youtube video link :';}
		var metadatadiv = document.getElementById('metadata');
		metadatadiv.innerHTML = "<div style='width:100%;height:auto;'><p5>"+postvideotext+"</p5><br><input type='text' id='youtubelink' oninput='linkyoutube();' style='height:25px;width:350px;font-size;22px;font-weight:bold;border:1px black solid;' /><br><br></div>";
		document.getElementById('posttype').value='video';
		document.getElementById('metaimg').value='false';
		document.getElementById('metatitle').value='false';
		document.getElementById('metadesc').value='false';
		document.getElementById('metalink').value='false';
		document.getElementById('metahost').value='false';
	}
	function posttext(){
		$("#postimg").hide();
		var metadatadiv = document.getElementById('metadata');
		metadatadiv.innerHTML = "";
		document.getElementById('posttype').value='text';
		document.getElementById('metaimg').value='false';
		document.getElementById('metatitle').value='false';
		document.getElementById('metadesc').value='false';
		document.getElementById('metalink').value='false';		
		document.getElementById('metahost').value='false';		
		document.getElementById('videoid').value='false';		
	}
	function hidepostimg(){
		$("#postimg").hide();
	}
	function viewcomments(postcomid){
		document.getElementById("cmnt"+postcomid).style.visibility='visible';
		document.getElementById("cmnt"+postcomid).style.height='auto';
	}
	function unviewcomments(postcomid){
		document.getElementById("cmnt"+postcomid).style.visibility='hidden';
		document.getElementById("cmnt"+postcomid).style.height='0px';
		var request = $.ajax({
			type: "post",
			url: "../ajax/dataunviewcomments.php",
			data: {'unviewcomments': postcomid},
			success : function(comdata){
				coms=comdata[0];
				subcoms=comdata[1];
				for(x=0;x<coms.length;x++){
					document.getElementById("subcmnt"+coms[x]).style.visibility='hidden';
					document.getElementById("subcmnt"+coms[x]).style.height='0px;';
					subunviewcomments(coms[x]);
				}
			}
		});
	}
	function subcommentaction(subpostcomid){
		document.getElementById("subcmnt"+subpostcomid).style.visibility='visible';
		document.getElementById("subcmnt"+subpostcomid).style.height='auto';
		var request = $.ajax({
			type: "post",
			url: "../ajax/datasubcommentaction.php",
			data: {'subcommentaction': subpostcomid},
			success : function(subcdata){
				subcoms=subcdata;
				for(x=0;x<subcoms.length;x++){
					document.getElementById("subcomment"+subcoms[x]).style.visibility='visible';
					document.getElementById("subcomment"+subcoms[x]).style.height='auto';
				}
			}
		});
	}
	function subunviewcomments(subpostcomid){
		document.getElementById("subcmnt"+subpostcomid).style.visibility='hidden';
		document.getElementById("subcmnt"+subpostcomid).style.height='0px';
		var request = $.ajax({
			type: "post",
			url: "../ajax/datasubcommentaction.php",
			data: {'subcommentaction': subpostcomid},
			success : function(subcdata){
				subcoms=subcdata;
				for(x=0;x<subcoms.length;x++){
					document.getElementById("subcomment"+subcoms[x]).style.visibility='hidden';
					document.getElementById("subcomment"+subcoms[x]).style.height='0px;';
				}
			}
		});
	}
	function likeaction(likeid){
		var laction = $.ajax({
			type: "post",
			url: "../ajax/datalikeaction.php",
			data: {'likeaction': likeid}
		});
	}
	function dislikeaction(dislikeid){
		var daction = $.ajax({
			type: "post",
			url: "../ajax/datadislikeaction.php",
			data: {'dislikeaction': dislikeid}
		});
	}
	function cmntlikeaction(likeid){
		var laction = $.ajax({
			type: "post",
			url: "../ajax/datacmntlikeaction.php",
			data: {'cmntlikeaction': likeid}
		});
	}
	function cmntdislikeaction(dislikeid){
		var daction = $.ajax({
			type: "post",
			url: "../ajax/datacmntdislikeaction.php",
			data: {'cmntdislikeaction': dislikeid}
		});
	}
	function sublikeaction(likeid){
		var laction = $.ajax({
			type: "post",
			url: "../ajax/datasublikeaction.php",
			data: {'sublikeaction': likeid}
		});
	}
	function subdislikeaction(dislikeid){
		var daction = $.ajax({
			type: "post",
			url: "../ajax/datasubdislikeaction.php",
			data: {'subdislikeaction': dislikeid}
		});
	}
	var postscounter=0;
	var postslimit=19;
	var enable=true;
	var postsids = [];
	var allposts = [];
	var comids = [];
	var subcomids = [];
	function getonepost(postid){
		var request = $.ajax({
			type: "post",
			url: "../ajax/getonepost.php",
			data: {'onepost': postid},
			success : function(data){
				allposts=data;
			}
		});
	}
	function activecomment(acid){
		var request = $.ajax({
			type: "post",
			url: "../ajax/dataactivecomment.php",
			data: {'comid': acid},
			success : function(data){
				active=data;
				if(active==false){
					document.getElementById("maincomment"+acid).remove();
				}
			}
		});		
	}
	function activesubcomment(ascid){
		var request = $.ajax({
			type: "post",
			url: "../ajax/dataactivesubcomment.php",
			data: {'subcomid': ascid},
			success : function(data){
				active=data;
				if(active==false){
					document.getElementById("subcomment"+ascid).remove();
				}
			}
		});		
	}
	function racepcounter(){
		postslimit+=20;
	}
	function vldclose(){
		$("#vld").hide();
		document.getElementById("vld").style.visibility='hidden';
		document.getElementById("vld").innerHTML = '';
	}
	function viewlikes(vlid){
		try{
			var vl = $.ajax({
				type: "post",
				url: "../ajax/dataviewlikes.php",
				data: {'viewlikes': vlid },
				success : function(vldata){
					if (vldata.length != 0){
						if(getCookie('lang')=='gr'){xlikes='Αρέσει';} // jstranslate
						if(getCookie('lang')=='en'){xlikes='Likes';}
						$("#vld").show();
						document.getElementById("vld").style.visibility='visible';
						document.getElementById("vld").innerHTML = "<div id='notdiv'><p6>"+xlikes+"</p6><input type='image'  onclick='vldclose();' src='../img/close.png' style='height:60px;width:60px;float:right;' /></div></div><div id='vldcontent'></div>";
					}
					for(x in vldata){
						id=vldata[x][0];
						fname=vldata[x][1];
						lname=vldata[x][2];
						pimg=vldata[x][3];
						document.getElementById("vldcontent").innerHTML += "<div id='notdiv'><a href='profile.php?id="+id+"' class='ah3'><img src='../"+pimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:50px;height:50px;'></img><p6>"+fname+" "+lname+"</p6></a></div>";
					}
				}
			});
		}catch(err2){alert(err2.message);}		
	}
	function viewdislikes(vlid){
		try{
			var vl = $.ajax({
				type: "post",
				url: "../ajax/dataviewdislikes.php",
				data: {'viewdislikes': vlid },
				success : function(vldata){
					if (vldata.length != 0){
						if(getCookie('lang')=='gr'){xdislikes='Δεν Αρέσει';} // jstranslate
						if(getCookie('lang')=='en'){xdislikes='Dislikes';}
						$("#vld").show();
						document.getElementById("vld").style.visibility='visible';
						document.getElementById("vld").innerHTML = "<div id='notdiv'><p6>"+xdislikes+"</p6><input type='image'  onclick='vldclose();' src='../img/close.png' style='height:60px;width:60px;float:right;' /></div></div><div id='vldcontent'></div>";
					}
					for(x in vldata){
						id=vldata[x][0];
						fname=vldata[x][1];
						lname=vldata[x][2];
						pimg=vldata[x][3];
						document.getElementById("vldcontent").innerHTML += "<div id='notdiv'><a href='profile.php?id="+id+"' class='ah3'><img src='../"+pimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:50px;height:50px;'></img><p6>"+fname+" "+lname+"</p6></a></div>";
					}
				}
			});
		}catch(err2){alert(err2.message);}		
	}
	function viewcmntlikes(vlid){
		try{
			var vlcmnt = $.ajax({
				type: "post",
				url: "../ajax/dataviewcmntlikes.php",
				data: {'viewcmntlikes': vlid },
				success : function(vlcmntdata){
					if (vlcmntdata.length != 0){
						if(getCookie('lang')=='gr'){xlikes='Αρέσει';} // jstranslate
						if(getCookie('lang')=='en'){xlikes='Likes';}
						$("#vld").show();
						document.getElementById("vld").style.visibility='visible';
						document.getElementById("vld").innerHTML = "<div id='notdiv'><p6>"+xlikes+"</p6><input type='image'  onclick='vldclose();' src='../img/close.png' style='height:60px;width:60px;float:right;' /></div></div><div id='vldcontent'></div>";
					}
					for(x in vlcmntdata){
						id=vlcmntdata[x][0];
						fname=vlcmntdata[x][1];
						lname=vlcmntdata[x][2];
						pimg=vlcmntdata[x][3];
						document.getElementById("vldcontent").innerHTML += "<div id='notdiv'><a href='profile.php?id="+id+"' class='ah3'><img src='../"+pimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:50px;height:50px;'></img><p6>"+fname+" "+lname+"</p6></a></div>";
					}
				}
			});
		}catch(err2){alert(err2.message);}		
	}
	function viewcmntdislikes(vlid){
		try{
			var vl = $.ajax({
				type: "post",
				url: "../ajax/dataviewcmntdislikes.php",
				data: {'viewcmntdislikes': vlid },
				success : function(vlcmntdata){
					if (vlcmntdata.length != 0){
						if(getCookie('lang')=='gr'){xdislikes='Δεν Αρέσει';} // jstranslate
						if(getCookie('lang')=='en'){xdislikes='Dislikes';}
						$("#vld").show();
						document.getElementById("vld").style.visibility='visible';
						document.getElementById("vld").innerHTML = "<div id='notdiv'><p6>"+xdislikes+"</p6><input type='image'  onclick='vldclose();' src='../img/close.png' style='height:60px;width:60px;float:right;' /></div></div><div id='vldcontent'></div>";
					}
					for(x in vlcmntdata){
						id=vlcmntdata[x][0];
						fname=vlcmntdata[x][1];
						lname=vlcmntdata[x][2];
						pimg=vlcmntdata[x][3];
						document.getElementById("vldcontent").innerHTML += "<div id='notdiv'><a href='profile.php?id="+id+"' class='ah3'><img src='../"+pimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:50px;height:50px;'></img><p6>"+fname+" "+lname+"</p6></a></div>";
					}
				}
			});
		}catch(err2){alert(err2.message);}		
	}
	function viewsublikes(vlid){
		try{
			var vlsub = $.ajax({
				type: "post",
				url: "../ajax/dataviewsublikes.php",
				data: {'viewsublikes': vlid },
				success : function(vlsubdata){
					if (vlsubdata.length != 0){
						if(getCookie('lang')=='gr'){xlikes='Αρέσει';} // jstranslate
						if(getCookie('lang')=='en'){xlikes='Likes';}
						$("#vld").show();
						document.getElementById("vld").style.visibility='visible';
						document.getElementById("vld").innerHTML = "<div id='notdiv'><p6>"+xlikes+"</p6><input type='image'  onclick='vldclose();' src='../img/close.png' style='height:60px;width:60px;float:right;' /></div></div><div id='vldcontent'></div>";
					}
					for(x in vlsubdata){
						id=vlsubdata[x][0];
						fname=vlsubdata[x][1];
						lname=vlsubdata[x][2];
						pimg=vlsubdata[x][3];
						document.getElementById("vldcontent").innerHTML += "<div id='notdiv'><a href='profile.php?id="+id+"' class='ah3'><img src='../"+pimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:50px;height:50px;'></img><p6>"+fname+" "+lname+"</p6></a></div>";
					}
				}
			});
		}catch(err2){alert(err2.message);}		
	}
	function viewsubdislikes(vlid){
		try{
			var vl = $.ajax({
				type: "post",
				url: "../ajax/dataviewsubdislikes.php",
				data: {'viewsubdislikes': vlid },
				success : function(vlsubdata){
					if (vlsubdata.length != 0){
						if(getCookie('lang')=='gr'){xdislikes='Δεν Αρέσει';} // jstranslate
						if(getCookie('lang')=='en'){xdislikes='Dislikes';}
						$("#vld").show();
						document.getElementById("vld").style.visibility='visible';
						document.getElementById("vld").innerHTML = "<div id='notdiv'><p6>"+xdislikes+"</p6><input type='image'  onclick='vldclose();' src='../img/close.png' style='height:60px;width:60px;float:right;' /></div></div><div id='vldcontent'></div>";
					}
					for(x in vlsubdata){
						id=vlsubdata[x][0];
						fname=vlsubdata[x][1];
						lname=vlsubdata[x][2];
						pimg=vlsubdata[x][3];
						document.getElementById("vldcontent").innerHTML += "<div id='notdiv'><a href='profile.php?id="+id+"' class='ah3'><img src='../"+pimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:50px;height:50px;'></img><p6>"+fname+" "+lname+"</p6></a></div>";
					}
				}
			});
		}catch(err2){alert(err2.message);}		
	}
	function flowdata(){
		try{
			var ulds = $.ajax({
				type: "post",
				url: "../ajax/flowRequests.php",
				data: {'lds': postsids,'cmntlds': comids,'sublds': subcomids,'cmnt': postsids,'subcmnt': comids,'deadposts': ''},
				success : function(flowdata){
					ldsdata=flowdata[0];
					for(x in ldsdata){
						ldslikes=ldsdata[x][0];
						ldsdislikes=ldsdata[x][1];
						ldsshares=ldsdata[x][2];
						ldsname=ldsdata[x][3].toString();
						ldsid=ldsdata[x][3];
						ldscomments=ldsdata[x][4];
						ldsdiv= document.getElementById('lds'+ldsname);
						ldshtml="<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='likeaction("+ldsname+")' /><a href='javascript:{}' onclick='viewlikes("+ldsname+");' class='ah4'><p8>"+ldslikes.length.toString()+"</p8></a>";
						ldshtml+="<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='dislikeaction("+ldsname+")' /><a href='javascript:{}' onclick='viewdislikes("+ldsname+");' class='ah4'><p8>"+ldsdislikes.length.toString()+"</p8></a>";
						ldshtml+="<input type='image' src='../img/comment-icon.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='viewcomments("+ldsname+")' /><a href='javascript:{}' onclick='viewcommenters("+ldsname+");' class='ah4'><p8>"+ldscomments.length.toString()+"</p8></a>";
						//ldshtml+="<img src='../img/share.png' style='width:70px;height:70px;float:left;margin-left:30px;'></img><p8>"+ldsshares.length.toString()+"</p8>";
						ldsdiv.innerHTML=ldshtml;
					}
					cmntldsdata=flowdata[1];
					for(x in cmntldsdata){
						cmntldslikes=cmntldsdata[x][0];
						cmntldsdislikes=cmntldsdata[x][1];
						cmntldsname=cmntldsdata[x][2].toString();
						cmntldsid=cmntldsdata[x][2];
						cmntldscomments=cmntldsdata[x][3];
						cmntldsdiv= document.getElementById('cmntlds'+cmntldsname);
						cmntldshtml="<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='cmntlikeaction("+cmntldsname+")' /><a href='javascript:{}' onclick='viewcmntlikes("+cmntldsname+");' class='ah4'><p10>"+cmntldslikes.length.toString()+"</p10></a>";
						cmntldshtml+="<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='cmntdislikeaction("+cmntldsname+")' /><a href='javascript:{}' onclick='viewcmntdislikes("+cmntldsname+");' class='ah4'><p10>"+cmntldsdislikes.length.toString()+"</p10></a>";
						cmntldshtml+="<input type='image' src='../img/comment-icon.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='subcommentaction("+cmntldsname+")' /><p10>"+cmntldscomments.length.toString()+"</p10>";
						//cmntldshtml+="<img src='../img/share.png' style='width:70px;height:70px;float:left;margin-left:30px;'></img><p10>"+cmntldsshares.length.toString()+"</p10>";
						cmntldsdiv.innerHTML=cmntldshtml;
					}
					subldsdata=flowdata[2];
					for(x in subldsdata){
						subldslikes=subldsdata[x][0];
						subldsdislikes=subldsdata[x][1];
						subldsname=subldsdata[x][2].toString();
						subldsid=subldsdata[x][2];
						subldsdiv= document.getElementById('sublds'+subldsname);
						subldshtml="<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='sublikeaction("+subldsname+")' /><a href='javascript:{}' onclick='viewsublikes("+subldsname+");' class='ah4'><p10>"+subldslikes.length.toString()+"</p10></a>";
						subldshtml+="<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='subdislikeaction("+subldsname+")' /><a href='javascript:{}' onclick='viewsubdislikes("+subldsname+");' class='ah4'><p10>"+subldsdislikes.length.toString()+"</p10></a>";
						//subldshtml+="<img src='../img/share.png' style='width:70px;height:70px;float:left;margin-left:30px;'></img><p10>"+subldsshares.length.toString()+"</p10>";
						subldsdiv.innerHTML=subldshtml;
					}
					cmntdata=flowdata[3];
					for(x in cmntdata){
						//alert(cmntdata);
						cmntlikes=cmntdata[x][0];
						cmntdislikes=cmntdata[x][1];
						subcomments=cmntdata[x][2];
						//alert(subcomments[0]);
						cmntuserid=cmntdata[x][3];
						cmntfname=cmntdata[x][4];
						cmntlname=cmntdata[x][5];
						cmntpimg=cmntdata[x][6];
						cmntcomid=cmntdata[x][7];
						cmntxpost=cmntdata[x][8];
						cmntdtime=cmntdata[x][9];
						cmntpostid=cmntdata[x][10];
						cmntgen=cmntdata[x][11];
						if(cmntuserid==getCookie('id')){
							textdeletecmntbutton="<input type='image'  onclick='deletecmnt("+cmntcomid+");' src='../img/delete.png' style='height:80px;width:80px;float:right;' />";
						}else{
							textdeletecmntbutton="";
						}
						if (comids.includes(cmntcomid)==false){
							if(getCookie('lang')=='gr'){
								if(cmntgen=='Male'){protext="<p5>Ο ";}
								if(cmntgen=='Female'){protext="<p5>Η ";}
								titletext=protext+"<a href='profile.php?id="+cmntuserid+"' class='ah3' ><b>"+cmntfname+" "+cmntlname+"</b></a> σχολίασε στις "+cmntdtime+"</p5>";
							} // jstranslate
							if(getCookie('lang')=='en'){
								titletext="<p5><a href='profile.php?id="+cmntuserid+"' class='ah3' ><b>"+cmntfname+" "+cmntlname+"</b></a> leave a comment on "+cmntdtime+"</p5>";
							}
							document.getElementById("cmnt"+cmntpostid).innerHTML+="<div id='maincomment"+cmntcomid+"' onclick='activecomment("+cmntcomid+");' onmouseover='activecomment("+cmntcomid+");' "
								+"style='float:left;height:auto;width:100%;background-color:#cccccc;'>"
								+textdeletecmntbutton
								+"<div style='width:100%;height:auto;min-height:50px;'><img src='../"+cmntpimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius: 50%;width:80px;height:80px;float:left;'></img>"+titletext+"</div>"
								+"<div style='width:100%;'><p9><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+cmntxpost+"</xmp></p9></div>"
								+"<div id='cmntlds"+cmntcomid+"' style='width:100%;height:auto;min-height:70px;background-color:#404040;'>"
									+"<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='cmntlikeaction("+cmntcomid+")' /><p10>"+cmntlikes.length.toString()+"</p10>"
									+"<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='cmntdislikeaction("+cmntcomid+")' /><p10>"+cmntdislikes.length.toString()+"</p10>"
									+"<input type='image' src='../img/comment-icon.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='subcommentaction("+cmntcomid+")' /><p10>"+subcomments.length.toString()+"</p10>"
								+"</div>"
								+"<div id='subcmnt"+cmntcomid+"' style='visibility:hidden;float:right;background-color:#F8F8F8;min-width:400px;width:80%;background-color:#cccccc;height:0px;position:relative;'>"
									+"<input type='image'  onclick='subunviewcomments("+cmntcomid+");' src='../img/close.png' style='height:60px;width:60px;float:right;' />"
									+"<textarea rows='2' cols='30' id='subxpost"+cmntcomid+"' name='subxpost"+cmntcomid+"' oninput='autosize(this.id);' style='font-size:4vw;width:80%;max-width:80%;height:auto;min-height:80px;'></textarea><br><br>"
									+"<input type='submit' id='subcb"+cmntcomid+"' class='cbutton' value='"+textcomment+"' onclick='sqlfix3("+cmntcomid+");submakecomment("+cmntcomid+");'/><br><br>"
								+"</div>"
							+"</div>";
							comids.push(cmntcomid);
						}
					}
					subdata=flowdata[4];
					if(comids.length>0){
						for(x in subdata){
							sublikes=subdata[x][0];
							subdislikes=subdata[x][1];
							subuserid=subdata[x][2];
							subfname=subdata[x][3];
							sublname=subdata[x][4];
							subpimg=subdata[x][5];
							subcomid=subdata[x][6];
							subxpost=subdata[x][7];
							subdtime=subdata[x][8];
							subpostid=subdata[x][9];
							subgen=subdata[x][10];
							//alert("enter");
							subsubcomid=subdata[x][11];
							//alert(subsubcomid);
							if(subuserid==getCookie('id')){
								textdeletesubbutton="<input type='image'  onclick='deletesub("+subsubcomid+");' src='../img/delete.png' style='height:80px;width:80px;float:right;' />";
							}else{
								textdeletesubbutton="";
							}
							if (subcomids.includes(subsubcomid)==false){
								//alert("enterif");
								if(getCookie('lang')=='gr'){
									if(subgen=='Male'){protext="<p5>Ο ";}
									if(subgen=='Female'){protext="<p5>Η ";}
									titletext=protext+"<a href='profile.php?id="+subuserid+"' class='ah3' ><b>"+subfname+" "+sublname+"</b></a> έκανε ένα υποσχόλιο στις "+subdtime+"</p5>";
								} // jstranslate
								if(getCookie('lang')=='en'){
									titletext="<p5><a href='profile.php?id="+subuserid+"' class='ah3' ><b>"+subfname+" "+sublname+"</b></a> leave a subcomment on "+subdtime+"</p5>";
								}
								document.getElementById("subcmnt"+subcomid).innerHTML+="<div id='subcomment"+subsubcomid+"' onclick='activesubcomment("+subsubcomid+");' onmouseover='activesubcomment("+subsubcomid+");' "
									+"style='float:left;height:auto;width:100%;background-color:#cccccc;'>"
									+textdeletesubbutton
									+"<div style='width:100%;height:auto;min-height:50px;'><img src='../"+subpimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius: 50%;width:80px;height:80px;float:left;'></img>"+titletext+"</div>"
									+"<div style='width:100%;'><p9><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+subxpost+"</xmp></p9></div>"
									+"<div id='sublds"+subsubcomid+"' style='width:100%;height:auto;min-height:70px;background-color:#404040;'>"
										+"<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='sublikeaction("+subsubcomid+")' /><p10>"+sublikes.length.toString()+"</p10>"
										+"<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='subdislikeaction("+subsubcomid+")' /><p10>"+subdislikes.length.toString()+"</p10>"
									+"</div>"
								+"</div>";
								subcomids.push(subsubcomid);
							}
						}
					}
					liveposts=flowdata[5];
					for(i in allposts){
						var lpostid=allposts[i][1];
						if(liveposts.includes(lpostid)==false){
							document.getElementById("post"+lpostid).remove();
						}
					}
				}
			});
		}catch(err2){alert(err2.message);}
	}
	function makecomment(mcid){
		try{
			var ucmnt = $.ajax({
				type: "post",
				url: "../ajax/datamakecomment.php",
				data: {'mcid': mcid, 'xcom' : document.getElementById('xpost'+mcid).value},
				success : function(mcdata){
					document.getElementById('xpost'+mcid).value="";
				}
			});
		}catch(err2){alert(err2.message);}
	}
	function submakecomment(submcid){
		try{
			var ucmnt = $.ajax({
				type: "post",
				url: "../ajax/datasubmakecomment.php",
				data: {'submcid': submcid, 'subxcom' : document.getElementById('subxpost'+submcid).value},
				success : function(mcdata){
					document.getElementById('subxpost'+submcid).value="";
				}
			});
		}catch(err2){alert(err2.message);}
	}
	window.onload = function() {
		hidepostimg();
		getonepost(document.getElementById("vpostid").value);
	};
	function deletesub(subid){
		try{
			var ucmnt = $.ajax({
				type: "post",
				url: "../ajax/datadeletesub.php",
				data: {'subid': subid},
				success : function(subdata){
					document.getElementById('subcomment'+subid).remove();
					for(x=0;x<subcomids.length;x++){
						if(subcomids[x]==subid){
							subcomids.splice(x,1);
							break;
						}
					}
				}
			});
		}catch(err2){alert(err2.message);}
	}
	function deletecmnt(cmntid){
		try{
			var ucmnt = $.ajax({
				type: "post",
				url: "../ajax/datadeletecmnt.php",
				data: {'cmntid': cmntid},
				success : function(subdata){
					document.getElementById('maincomment'+cmntid).style.visibility='hidden';
					document.getElementById('maincomment'+cmntid).style.height='0px';
					document.getElementById('maincomment'+cmntid).innerHTML='';
					document.getElementById('maincomment'+cmntid).remove();
					for(x=0;x<comids.length;x++){
						if(comids[x]==cmntid){
							comids.splice(x,1);
							break;
						}
					}
				}
			});
		}catch(err2){alert(err2.message);}
	}
	function deletepost(postid){
		try{
			var ucmnt = $.ajax({
				type: "post",
				url: "../ajax/datadeletepost.php",
				data: {'postid': postid},
				success : function(subdata){
					document.getElementById('post'+postid).style.visibility='hidden';
					document.getElementById('post'+postid).style.height='0px';
					document.getElementById('post'+postid).innerHTML='';
					document.getElementById('post'+postid).remove();
					for(x=0;x<postids.length;x++){
						if(postids[x]==postid){
							postids.splice(x,1);
							break;
						}
					}
				}
			});
		}catch(err2){alert(err2.message);}
	}
	alientime=1000;
	setInterval(function(){
		try{
			var flow = document.getElementById('flowposts');
			for(i in allposts){
				if( (postscounter<=postslimit) && (i>=postscounter) ){	
					var puserid=allposts[i][0];
					var ppostid=allposts[i][1];
					var pcounter=allposts[i][2];
					var pxpost=allposts[i][3];
					var pposttype=allposts[i][4];
					var pmetaimg=allposts[i][5];
					var pmetatitle=allposts[i][6];
					var pmetadesc=allposts[i][7];
					var pmetalink=allposts[i][8];
					var pmetahost=allposts[i][9];
					var pvideoid=allposts[i][10];
					var pimgsrc=allposts[i][11];
					var plikes=allposts[i][12];
					var pdislikes=allposts[i][13];
					var pcomments=allposts[i][14];
					var pshares=allposts[i][15];
					var pshareid=allposts[i][16];
					var pdate=allposts[i][17];
					var ptimezone=allposts[i][18];
					var psuper=allposts[i][19];
					var pfname=allposts[i][20];
					var plname=allposts[i][21];
					var ppimg=allposts[i][22];
					var pgen=allposts[i][23];
					var psrc=allposts[i][24];
					ldsid=ppostid.toString();
					if(puserid==getCookie('id')){
						textdeletepostbutton="<input type='image'  onclick='deletepost("+ppostid+");' src='../img/delete.png' style='height:80px;width:80px;float:right;' />";
					}else{
						textdeletepostbutton="";
					}
					try{
						var plikes = Object.keys(plikes).map(function(key) {
							return plikes[key];
						});
					}catch(err){alert(err.message);}
					try{
						var pdislikes = Object.keys(pdislikes).map(function(key) {
							return pdislikes[key];
						});
					}catch(err){alert(err.message);}
					if (pposttype=='text'){
						if(postsids.includes(ppostid)===false){
							postsids.push(ppostid);
						}
						if(getCookie('lang')=='gr'){
							if(pgen=='Male'){protext="<p5>Ο ";}
							if(pgen=='Female'){protext="<p5>Η ";}
							if(psuper=="true"){
								titletext=protext+"<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> έκανε μια υπερδημοσίευση στις "+pdate+"</p5>";
							}else{
								titletext=protext+"<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> δημοσίευσε ένα κείμενο στις "+pdate+"</p5>";
							}
						} // jstranslate
						if(getCookie('lang')=='en'){
							if(psuper=="true"){
								titletext="<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> make a superpost on "+pdate+"</p5>";
							}else{
								titletext="<p5><a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> posted a text on "+pdate+"</p5>";
							}
						}
						posthtml="<div id='post"+ppostid+"' style='visibility:visible;height:auto;float:left;background-color:#F8F8F8;min-width:500px;width:98%;border:2px blue solid;margin:5px;position:relative;'>";
							posthtml+=textdeletepostbutton;
							posthtml+="<div style='width:100%;height:auto;min-height:50px;'><img src='../"+ppimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius: 50%;width:80px;height:80px;float:left;'></img>"+titletext+"</div>";
							posthtml+="<div style='width:100%;'><p7><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+pxpost+"</xmp></p7></div>";
							posthtml+="<div id='lds"+ldsid+"' style='width:100%;height:auto;min-height:70px;background-color:#b4b4b4;margin-top:10px;'>";
								posthtml+="<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='likeaction("+ldsid+")' /><p8>"+plikes.length.toString()+"</p8>";
								posthtml+="<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='dislikeaction("+ldsid+")' /><p8>"+pdislikes.length.toString()+"</p8>";
								posthtml+="<input type='image' src='../img/comment-icon.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='commentaction("+ldsid+")' /><p8>"+pcomments.length.toString()+"</p8>";
								//posthtml+="<img src='../img/share.png' style='width:70px;height:70px;float:left;margin-left:30px;'></img><p8>"+pshares.length.toString()+"</p8>"
							posthtml+="</div>";
							posthtml+="<div id='cmnt"+ldsid+"' style='visibility:hidden;float:left;background-color:#F8F8F8;min-width:500px;width:100%;height:0px;position:relative;'>";
								posthtml+="<input type='image'  onclick='unviewcomments("+ldsid+");' src='../img/close.png' style='height:60px;width:60px;float:right;' />";
								posthtml+="<textarea rows='2' cols='30' id='xpost"+ldsid+"' name='xpost"+ldsid+"' oninput='autosize(this.id);' style='font-size:4vw;width:80%;max-width:80%;height:auto;min-height:80px;'></textarea><br><br>";
								posthtml+="<input type='submit' id='cb"+ldsid+"' class='cbutton' value='"+textcomment+"' onclick='sqlfix2("+ldsid+");makecomment("+ldsid+");'/><br><br>";
							posthtml+="</div>";
						posthtml+="</div>";
					}
					if(pposttype=="image"){
						if(postsids.includes(ppostid)===false){
							postsids.push(ppostid);
						}
						if(getCookie('lang')=='gr'){
							if(pgen=='Male'){protext="<p5>Ο ";}
							if(pgen=='Female'){protext="<p5>Η ";}
							if(psuper=="true"){
								titletext=protext+"<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> έκανε μια υπερδημοσίευση στις "+pdate+"</p5>";
							}else{
								titletext=protext+"<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> δημοσίευσε μία εικόνα στις "+pdate+"</p5>";
							}
						}
						if(getCookie('lang')=='en'){
							if(psuper=="true"){
								titletext="<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> make a superpost on "+pdate+"</p5>";
							}else{
								titletext="<p5><a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> posted an image on "+pdate+"</p5>";
							}
						}
						posthtml="<div id='post"+ppostid+"' style='visibility:visible;height:auto;float:left;background-color:#F8F8F8;min-width:500px;width:98%;border:2px blue solid;margin:5px;position:relative;'>";
							posthtml+=textdeletepostbutton;
							posthtml+="<div style='width:100%;height:auto;min-height:50px;'><img src='../"+ppimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius: 50%;width:80px;height:80px;float:left;'></img>"+titletext+"</div>";
							posthtml+="<div style='width:100%;'><p7><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+pxpost+"</xmp></p7></div>";
							posthtml+="<img src='../"+pimgsrc+"' style='width:80%;height:auto;'></img>";
							posthtml+="<div id='lds"+ldsid+"' style='width:100%;height:auto;min-height:70px;background-color:#b4b4b4;margin-top:10px;'>";
								posthtml+="<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='likeaction("+ldsid+")' /><p8>"+plikes.length.toString()+"</p8>";
								posthtml+="<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='dislikeaction("+ldsid+")' /><p8>"+pdislikes.length.toString()+"</p8>";
								posthtml+="<input type='image' src='../img/comment-icon.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='commentaction("+ldsid+")' /><p8>"+pcomments.length.toString()+"</p8>";
								//posthtml+="<img src='../img/share.png' style='width:70px;height:70px;float:left;margin-left:30px;'></img><p8>"+pshares.length.toString()+"</p8>";
							posthtml+="</div>";
							posthtml+="<div id='cmnt"+ldsid+"' style='visibility:hidden;float:left;background-color:#F8F8F8;min-width:500px;width:100%;height:0px;position:relative;'>";
								posthtml+="<input type='image'  onclick='unviewcomments("+ldsid+");' src='../img/close.png' style='height:60px;width:60px;float:right;' />";
								posthtml+="<textarea rows='2' cols='30' id='xpost"+ldsid+"' name='xpost"+ldsid+"' oninput='autosize(this.id);' style='font-size:4vw;width:80%;max-width:80%;height:auto;min-height:80px;'></textarea><br><br>";
								posthtml+="<input type='submit' id='cb"+ldsid+"' class='cbutton' value='"+textcomment+"' onclick='sqlfix2("+ldsid+");makecomment("+ldsid+");'/><br><br>";
							posthtml+="</div>";
						posthtml+="</div>";						
					}
					if(pposttype=="video"){
						if(postsids.includes(ppostid)===false){
							postsids.push(ppostid);
						}
						if(getCookie('lang')=='gr'){
							if(pgen=='Male'){protext="<p5>Ο ";}
							if(pgen=='Female'){protext="<p5>Η ";}
							if(psuper=="true"){
								titletext=protext+"<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> έκανε μια υπερδημοσίευση στις "+pdate+"</p5>";
							}else{
								titletext=protext+"<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> δημοσίευσε ένα βίντεο στις "+pdate+"</p5>";
							}
						}
						if(getCookie('lang')=='en'){
							if(psuper=="true"){
								titletext="<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> make a superpost on "+pdate+"</p5>";
							}else{
								titletext="<p5><a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> posted a video on "+pdate+"</p5>";
							}
						}
						posthtml="<div id='post"+ppostid+"' style='visibility:visible;height:auto;float:left;background-color:#F8F8F8;min-width:500px;width:98%;border:2px blue solid;margin:5px;position:relative;'>";
							posthtml+=textdeletepostbutton;
							posthtml+="<div style='width:100%;height:auto;min-height:50px;'><img src='../"+ppimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius: 50%;width:80px;height:80px;float:left;'></img>"+titletext+"</div>";
							posthtml+="<div style='width:100%;'><p7><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+pxpost+"</xmp></p7></div>";
							posthtml+="<iframe width='500' height='315' src='https://www.youtube.com/embed/"+pvideoid+"' frameborder='0' allowfullscreen></iframe>";
							posthtml+="<div id='lds"+ldsid+"' style='width:100%;height:auto;min-height:70px;background-color:#b4b4b4;margin-top:10px;'>";
								posthtml+="<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='likeaction("+ldsid+")' /><p8>"+plikes.length.toString()+"</p8>";
								posthtml+="<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='dislikeaction("+ldsid+")' /><p8>"+pdislikes.length.toString()+"</p8>";
								posthtml+="<input type='image' src='../img/comment-icon.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='commentaction("+ldsid+")' /><p8>"+pcomments.length.toString()+"</p8>";
								//posthtml+="<img src='../img/share.png' style='width:70px;height:70px;float:left;margin-left:30px;'></img><p8>"+pshares.length.toString()+"</p8>";
							posthtml+="</div>";
							posthtml+="<div id='cmnt"+ldsid+"' style='visibility:hidden;float:left;background-color:#F8F8F8;min-width:500px;width:100%;height:0px;position:relative;'>";
								posthtml+="<input type='image'  onclick='unviewcomments("+ldsid+");' src='../img/close.png' style='height:60px;width:60px;float:right;' />";
								posthtml+="<textarea rows='2' cols='30' id='xpost"+ldsid+"' name='xpost"+ldsid+"' oninput='autosize(this.id);' style='font-size:4vw;width:80%;max-width:80%;height:auto;min-height:80px;'></textarea><br><br>";
								posthtml+="<input type='submit' id='cb"+ldsid+"' class='cbutton' value='"+textcomment+"' onclick='sqlfix2("+ldsid+");makecomment("+ldsid+");'/><br><br>";
							posthtml+="</div>";
						posthtml+="</div>";					
					}
					if(pposttype=="link"){
						if(postsids.includes(ppostid)===false){
							postsids.push(ppostid);
						}
						if(getCookie('lang')=='gr'){
							if(pgen=='Male'){protext="<p5>Ο ";}
							if(pgen=='Female'){protext="<p5>Η ";}
							if(psuper=="true"){
								titletext=protext+"<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> έκανε μια υπερδημοσίευση στις "+pdate+"</p5>";
							}else{
								titletext=protext+"<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> δημοσίευσε ένα σύνδεσμο στις "+pdate+"</p5>";
							}
						}
						if(getCookie('lang')=='en'){
							if(psuper=="true"){
								titletext="<a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> make a superpost on "+pdate+"</p5>";
							}else{
								titletext="<p5><a href='profile.php?id="+puserid+"' class='ah3' ><b>"+pfname+" "+plname+"</b></a> posted a link on "+pdate+"</p5>";
							}
						}
						posthtml="<div id='post"+ppostid+"' style='visibility:visible;height:auto;float:left;background-color:#F8F8F8;min-width:500px;width:98%;border:2px blue solid;margin:5px;position:relative;'>";
							posthtml+=textdeletepostbutton;
							posthtml+="<div style='width:100%;height:auto;min-height:50px;'><img src='../"+ppimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius: 50%;width:80px;height:80px;float:left;'></img>"+titletext+"</div>";
							posthtml+="<div style='width:100%;'><p7><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+pxpost+"</xmp></p7></div>";
							posthtml+="<div style='width:100%;height:auto;'><a href='"+pmetalink+"' class='ah3' target='_blank'><p4><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+utf8Decode(pmetatitle)+"</xmp></p4>";
							posthtml+="</div><div style='width:100%;height:auto;float:left;'><img src='../"+psrc+"' id='mimg' onError=\"this.onerror = '';this.style.visibility='hidden';;this.style.width='0px';;this.style.height='0px';\" style='width:300px;height:200px;float:left;'></img><div style='width:300px;;float:left;display:inline;'><p5><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+utf8Decode(pmetadesc)+"</xmp></p5></div></div><div style='width:100%;height:auto;'><center><p2>"+pmetahost+"</p2></center></div></a>";
							posthtml+="<div id='lds"+ldsid+"' style='width:100%;height:auto;min-height:70px;background-color:#b4b4b4;margin-top:10px;'>";
								posthtml+="<input type='image' src='../img/like.png' style='width:70px;height:70px;float:left;margin-left:10px;' onclick='likeaction("+ldsid+")' /><p8>"+plikes.length.toString()+"</p8>";
								posthtml+="<input type='image' src='../img/dislike.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='dislikeaction("+ldsid+")' /><p8>"+pdislikes.length.toString()+"</p8>";
								posthtml+="<input type='image' src='../img/comment-icon.png' style='width:70px;height:70px;float:left;margin-left:30px;' onclick='commentaction("+ldsid+")' /><p8>"+pcomments.length.toString()+"</p8>";
								//posthtml+="<img src='../img/share.png' style='width:70px;height:70px;float:left;margin-left:30px;'></img><p8>"+pshares.length.toString()+"</p8>";
							posthtml+="</div>";
							posthtml+="<div id='cmnt"+ldsid+"' style='visibility:hidden;float:left;background-color:#F8F8F8;min-width:500px;width:100%;height:0px;position:relative;'>";
								posthtml+="<input type='image'  onclick='unviewcomments("+ldsid+");' src='../img/close.png' style='height:60px;width:60px;float:right;' />";
								posthtml+="<textarea rows='2' cols='30' id='xpost"+ldsid+"' name='xpost"+ldsid+"' oninput='autosize(this.id);' style='font-size:4vw;width:80%;max-width:80%;height:auto;min-height:80px;'></textarea><br><br>";
								posthtml+="<input type='submit' id='cb"+ldsid+"' class='cbutton' value='"+textcomment+"' onclick='sqlfix2("+ldsid+");makecomment("+ldsid+");'/><br><br>";
							posthtml+="</div>";
						posthtml+="</div>";	
					}
					flow.innerHTML+=posthtml;
					postscounter+=1;
					enable=true;
				}
				if( (postscounter==postslimit+1) && (enable==true) ){
					if(getCookie('lang')=='gr'){showmore='Δείτε Περισσότερα';} // jstranslate
					if(getCookie('lang')=='en'){showmore='Show More';}
					flow.innerHTML+="<div id='post' style='min-height:0px;' ><input type='submit' value='"+showmore+"' class='cbutton' onclick='racepcounter()' /></div>";
					enable=false;
				}
			}
			/*updatelds();
			updatecmnt();
			updatesub();
			updatecmntlds();
			updatesublds();
			removedeadposts();*/
			flowdata();
			alientime=3500;
		}catch(err){alert(err.message);}
	}, alientime);
</script>	
<div id='mobileflow'>
	<?php
		if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
		and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active')
		and (securelogin()==true) ) {
			$er="";
			if(isset($_POST['xpost'])){
				$_POST['xpost']=str_replace("xmp"," 3:) ",$_POST['xpost']);
				$_POST['xpost']=str_replace("XMP"," 3:) ",$_POST['xpost']);
				$_POST['xpost']=str_replace("'","",$_POST['xpost']);
				$result = mysqli_query($con,"SELECT * FROM posts order by postid desc");
				$pcounter=0;
				while($row = mysqli_fetch_array($result)){
					$postid=$row['postid']+1;
					$pcounter=1;
					break;
				}
				if($pcounter==0){$postid=1;}
				$result = mysqli_query($con,"SELECT * FROM posts order by counter desc");
				$c=0;
				while($row = mysqli_fetch_array($result)){
					$counter=$row['counter']+1;
					$c=1;
					break;
				}
				$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
				while($row = mysqli_fetch_array($result)){
					$usercoins=$row['coins'];
				}
				if($c==0){$counter=1;}
				$imgsrc="false";
				$shareid="false";
				if(isset($_POST['super'])){
					if($usercoins>=$superpostcost){
						$super="true";
						$usercoins=$usercoins-$superpostcost;
						$sql="UPDATE users SET coins='$usercoins' WHERE id='".$_COOKIE['id']."' ";
						if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					}else{
						$super="false";
					}
				}else{	
					$super="false";
				}
				$likes=serialize(array());
				$dislikes=serialize(array());
				$comments=serialize(array());
				$shares=serialize(array());
				if ($_POST['posttype']=='text'){
					if (emptypost($_POST['xpost'])==true){
						$sql="INSERT INTO posts (userid,postid,counter,xpost,posttype,metaimg,metatitle,metadesc,metalink,metahost,videoid,imgsrc,
						likes,dislikes,comments,shares,shareid,date,timezone,super)
						VALUES ('".$_COOKIE['id']."','$postid','$counter','".$_POST['xpost']."','".$_POST['posttype']."','".$_POST['metaimg']."',
						'".$_POST['metatitle']."','".$_POST['metadesc']."','".$_POST['metalink']."','".$_POST['metahost']."','".$_POST['videoid']."',
						'$imgsrc','$likes','$dislikes','$comments','$shares','$shareid','".datenow($_COOKIE['timezone'])."','".$_COOKIE['timezone']."','$super' )";
						if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}						
					}
				}
				if ($_POST['posttype']=='video'){
					if ( (emptypost($_POST['xpost'])==true) or ($_POST['videoid']!="false") ){
						if ($_POST['videoid']=="false"){$_POST['posttype']="text";}
						$sql="INSERT INTO posts (userid,postid,counter,xpost,posttype,metaimg,metatitle,metadesc,metalink,metahost,videoid,imgsrc,
						likes,dislikes,comments,shares,shareid,date,timezone,super)
						VALUES ('".$_COOKIE['id']."','$postid','$counter','".$_POST['xpost']."','".$_POST['posttype']."','".$_POST['metaimg']."',
						'".$_POST['metatitle']."','".$_POST['metadesc']."','".$_POST['metalink']."','".$_POST['metahost']."','".$_POST['videoid']."',
						'$imgsrc','$likes','$dislikes','$comments','$shares','$shareid','".datenow($_COOKIE['timezone'])."','".$_COOKIE['timezone']."','$super' )";
						if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
					}
				}
				if($_POST['posttype']=='link'){
					if($_POST['metaimg']!="false"){
						$findext=explode('.',$_POST['metaimg']);
						$img_ext=strtolower(end($findext));
						if (strpos($img_ext, 'png') !== false){$img_ext='png';}
						if (strpos($img_ext, 'jpg') !== false){$img_ext='jpg';}
						if (strpos($img_ext, 'jpeg') !== false){$img_ext='jpeg';}
						if (strpos($img_ext, 'gif') !== false){$img_ext='gif';}
						$nimgsrc=newimgsrc($img_ext);
						$content = file_get_contents($_POST['metaimg']);
						$fp = fopen($nimgsrc, "w");
						fwrite($fp, $content);
						fclose($fp);
						$result = mysqli_query($con,"SELECT * FROM links WHERE link='".$_POST['metalink']."' ");
						while($row = mysqli_fetch_array($result)){
							unlink($row['imgsrc']);
						}
						$sql="DELETE FROM links WHERE link='".$_POST['metalink']."' "; 
						if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
						$sql="INSERT INTO links (link,imgsrc)
						VALUES ('".$_POST['metalink']."','$nimgsrc' )";
						if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
						$_POST['metaimg']="true";
					}
					$sql="INSERT INTO posts (userid,postid,counter,xpost,posttype,metaimg,metatitle,metadesc,metalink,metahost,videoid,imgsrc,
					likes,dislikes,comments,shares,shareid,date,timezone,super)
					VALUES ('".$_COOKIE['id']."','$postid','$counter','".$_POST['xpost']."','".$_POST['posttype']."','".$_POST['metaimg']."',
					'".$_POST['metatitle']."','".$_POST['metadesc']."','".$_POST['metalink']."','".$_POST['metahost']."','".$_POST['videoid']."',
					'$imgsrc','$likes','$dislikes','$comments','$shares','$shareid','".datenow($_COOKIE['timezone'])."','".$_COOKIE['timezone']."','$super')";
					if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
				}
	 			if ($_POST['posttype']=='image'){
					if ( (emptypost($_POST['xpost'])==true) or isset($_FILES['imginp']) ){
						if( (isset($_FILES['imginp'])) and ($_FILES['imginp']['name']!='') ){
							$errors= array();
							$file_name = $_FILES['imginp']['name'];
							$file_size =$_FILES['imginp']['size'];
							$file_tmp =$_FILES['imginp']['tmp_name'];
							$file_type=$_FILES['imginp']['type'];
							$findext=explode('.',$_FILES['imginp']['name']);
							$file_ext=strtolower(end($findext));      
							$expensions= array("jpeg","jpg","png","gif");
							if(in_array($file_ext,$expensions)=== false){
								$errors[]=$exterror;
							}
							if($file_size > 3145728){
								$errors[]=$sizeerror;
							}
							if(empty($errors)==true){
								$userimgsrc=userimgsrc($file_ext);
								move_uploaded_file($file_tmp,"../".$userimgsrc);
								$sql="INSERT INTO posts (userid,postid,counter,xpost,posttype,metaimg,metatitle,metadesc,metalink,metahost,videoid,imgsrc,
								likes,dislikes,comments,shares,shareid,date,timezone,super)
								VALUES ('".$_COOKIE['id']."','$postid','$counter','".$_POST['xpost']."','".$_POST['posttype']."','".$_POST['metaimg']."',
								'".$_POST['metatitle']."','".$_POST['metadesc']."','".$_POST['metalink']."','".$_POST['metahost']."','".$_POST['videoid']."',
								'$userimgsrc','$likes','$dislikes','$comments','$shares','$shareid','".datenow($_COOKIE['timezone'])."','".$_COOKIE['timezone']."','$super' )";
								if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
							}else{
								for($x=0;$x<count($errors);$x++){
									echo "<p5>".$errors[$x]."</p5><br>";
								}
							}
						}else{
							$_POST['posttype']="text";
							$sql="INSERT INTO posts (userid,postid,counter,xpost,posttype,metaimg,metatitle,metadesc,metalink,metahost,videoid,imgsrc,
							likes,dislikes,comments,shares,shareid,date,timezone,super)
							VALUES ('".$_COOKIE['id']."','$postid','$counter','".$_POST['xpost']."','".$_POST['posttype']."','".$_POST['metaimg']."',
							'".$_POST['metatitle']."','".$_POST['metadesc']."','".$_POST['metalink']."','".$_POST['metahost']."','".$_POST['videoid']."',
							'$imgsrc','$likes','$dislikes','$comments','$shares','$shareid','".datenow($_COOKIE['timezone'])."','".$_COOKIE['timezone']."','$super' )";
							if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
						}
					}
				}
				if( ($_POST['posttype']=='video') or ($_POST['posttype']=='link') or ($_POST['posttype']=='text') or ($_POST['posttype']=='image') ){
					$result = mysqli_query($con,"SELECT * FROM posts WHERE userid='".$_COOKIE['id']."' ORDER BY counter DESC ");
					$counter=0;
					while($row = mysqli_fetch_array($result)){
						$counter+=1;
						$postid=$row['postid'];
						if($counter>30){
							echo "<script>deletepost(".$postid.");</script>";
						}
					}
				}
			}
			echo"<div id='flowposts'></div>";
		}
	?>
</div>
<script>
	function autosize(id){
		dir=document.getElementById(id);
        dir.style.height = "1px";
        dir.style.height = (dir.scrollHeight) + "px"; 
	}
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
				$('#blah').attr('style', 'width:80%;height:auto;');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imginp").change(function () {
		readURL(this);
    });
</script>
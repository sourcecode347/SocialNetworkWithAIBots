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
<head>
<script src='../jquery.js'></script>
<script>
ogimgsrc="../img/read.png";
if(getCookie('id').length>3){
	ogimgsrc="../img/read.png";
}
$(document).ready(function(){
	$("#search").hide();
	$("#vld").hide();
	$("#nfriends").hide();
	var counter=0;
	var counter2=0;
	var counter3=0;
    $("#buttonfriends").click(function(){
		document.getElementById("nfriends").style.visibility='visible';
		counter+=1;
		if(counter%2==1){
			$("#nfriends").show();
			$("#nmessages").hide();
			$("#nnotifications").hide();
			counter2=0;
			counter3=0;
		}else{
            $("#nfriends").hide();
		}
    });
    $("#frequestcount").click(function(){
		document.getElementById("nfriends").style.visibility='visible';
		counter+=1;
		if(counter%2==1){
			$("#nfriends").show();
			$("#nmessages").hide();
			$("#nnotifications").hide();
			counter2=0;
			counter3=0;
		}else{
            $("#nfriends").hide();
		}
    });
	$("#nmessages").hide();
    $("#buttonmessage").click(function(){
		document.getElementById("nmessages").style.visibility='visible';
		counter2+=1;
		if(counter2%2==1){
			$("#nmessages").show();
			$("#nfriends").hide();
			$("#nnotifications").hide();
			counter=0;
			counter3=0;			
		}else{
            $("#nmessages").hide();
		}
    });
	$("#nnotifications").hide();
    $("#buttonnotification").click(function(){
		document.getElementById("nnotifications").style.visibility='visible';
		counter3+=1;
		if(counter3%2==1){
			$("#nnotifications").show();
			$("#nfriends").hide();
			$("#nmessages").hide();
			counter2=0;
			counter=0;
		}else{
            $("#nnotifications").hide();
		}
    });
});
function sclose(){
	$("#search").hide();
	document.getElementById("search").style.visibility='hidden';
}
function postform(){
	document.getElementById('profilename').submit(); 
}
function gosettings(){
	window.location.href = "settings.php"; 
}
function postform2(){
	document.getElementById('coinform').submit();
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
/*function search(str){
	$("#search").show();
	document.getElementById("search").style.visibility='visible';
	if(getCookie('lang')=='gr'){xsearch='Αναζήτηση';} // jstranslate
	if(getCookie('lang')=='en'){xsearch='Search';}
    if (str.length == 0) {
        document.getElementById("search").innerHTML = "<div id='notdiv'><p6>"+xsearch+"</p6><input type='image' id='searchclose' onclick='sclose();' src='../img/close.png' style='height:60px;width:60px;float:right;' /></div>";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("search").innerHTML = "<div id='notdiv'><p6>"+xsearch+"</p6><input type='image' id='searchclose' onclick='sclose();' src='../img/close.png' style='height:60px;width:60px;float:right;' /></div>";
                var foo = JSON.parse(this.responseText);
				for(x in foo){
					id=foo[x][0];
					fname=foo[x][1];
					lname=foo[x][2];
					img=foo[x][3];
					document.getElementById("search").innerHTML += "<div id='notdiv'><a href='profile.php?id="+id+"' class='ah3'><img src='../"+img+"' onerror=\"this.onerror=null;this.src='img/ogimage1024x512.png';\" style='border-radius:50%;width:50px;height:50px;'></img><p6>"+fname+" "+lname+"</p6></a></div>";
				}
            }
        };
        xmlhttp.open("GET", "../search.php?q=" + str, true);
        xmlhttp.send();
    }	
}*/
function readnots(){
	var unots = $.ajax({
		type: "post",
		url: "../ajax/readnots.php",
		data: {'readnots': '',}
	});
}
function clicknot(nid){
	var unots = $.ajax({
		type: "post",
		url: "../ajax/clicknot.php",
		data: {'click': nid,}	
	});
}
notids=[];
function updatenotscoins(){
	var unots = $.ajax({
		type: "post",
		url: "../ajax/updatenotscoins.php",
		data: {'notscoins': '','unreadmessages': ''},
		success : function(notscoinsdata){
			unreadednots=0;
			unreadmes=0;
			notstextcounter=0;
			notsdata=notscoinsdata[0];
			cdata=notscoinsdata[1];
			unreadmes=notscoinsdata[2];
			document.getElementById('headercoins').innerHTML=cdata;
			for(i in notsdata){
				if(notsdata[i][7]==false){
					unreadednots+=1;
				}
			}
			if(unreadednots==0){
				document.getElementById('nots').innerHTML="";
				document.getElementById('nots').style.backgroundColor="transparent";
			}else{
				document.getElementById('nots').innerHTML="<p3>"+unreadednots+"</p3>";
				document.getElementById('nots').style.backgroundColor="red";
			}
			if(unreadmes==0){
				document.getElementById('mesnots').innerHTML="";
				document.getElementById('mesnots').style.backgroundColor="transparent";
			}else{
				document.getElementById('mesnots').innerHTML="<p3>"+unreadmes+"</p3>";
				document.getElementById('mesnots').style.backgroundColor="red";
			}
			//notsdata.reverse();
			document.getElementById('nnotifications').innerHTML="";
			if(getCookie('lang')=="gr"){
				document.getElementById('nnotifications').innerHTML="<div style='width:95%;height:84px;'><img src='../"+ogimgsrc+"' onclick='readnots();' style='border-radius:50%;height:80px;width:80px;float:left;left:0px;top:0px;margin:2px;position:absolute;cursor:pointer;' /><p15><b>Ειδοποιήσεις</b></p15></div>";
			}
			if(getCookie('lang')=="en"){
				document.getElementById('nnotifications').innerHTML="<div style='width:95%;height:84px;'><img src='../"+ogigmsrc+"' onclick='readnots();' style='border-radius:50%;height:80px;width:80px;float:left;left:0px;top:0px;margin:2px;position:absolute;cursor:pointer;' /><p15><b>Notifications</b></p15></div>";
			}
			for(i in notsdata){
				actor=notsdata[i][0];
				postid=notsdata[i][1];
				comid=notsdata[i][2];
				subcomid=notsdata[i][3];
				notid=notsdata[i][4];
				likes=notsdata[i][5];
				dislikes=notsdata[i][6];
				clicked=notsdata[i][7];
				spec=notsdata[i][8];
				npimg=notsdata[i][9];
				nfname=notsdata[i][10];
				nlname=notsdata[i][11];
				ngen=notsdata[i][12];
				comments=notsdata[i][13];
				subcomments=notsdata[i][14];
				if(ngen=="Male"){protext="Ο";}else{protext="Η";}
				if(clicked==false){ncolor="#F8F8F8";}else{ncolor="#b4b4b4";}
				if( (postid!=0) && (comid==0) && (subcomid==0) && (likes==true) && (dislikes==false) && (spec==false) ){ //Postlike
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"δήλωσε ότι του αρέσει η <a href='post.php?postid="+postid+"' class='ah3'><b>δημοσίευση </b></a>σας</p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"likes your <a href='post.php?postid="+postid+"' class='ah3'><b>post </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid==0) && (subcomid==0) && (likes==false) && (dislikes==true) && (spec==false) ){ //Postdislike
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"δήλωσε ότι δεν του αρέσει η <a href='post.php?postid="+postid+"' class='ah3'><b>δημοσίευση </b></a>σας</p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"dislikes your <a href='post.php?postid="+postid+"' class='ah3'><b>post </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid!=0) && (subcomid==0) && (likes==true) && (dislikes==false) && (spec==false) ){ //Comlike
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"δήλωσε ότι του αρέσει το <a href='post.php?postid="+postid+"' class='ah3'><b>σχόλιο </b></a>σας</p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"likes your <a href='post.php?postid="+postid+"' class='ah3'><b>comment </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid!=0) && (subcomid==0) && (likes==false) && (dislikes==true) && (spec==false) ){ //Comdislike
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"δήλωσε ότι δεν του αρέσει το <a href='post.php?postid="+postid+"' class='ah3'><b>σχόλιο </b></a>σας</p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"dislikes your <a href='post.php?postid="+postid+"' class='ah3'><b>comment </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid!=0) && (subcomid!=0) && (likes==true) && (dislikes==false) && (spec==false) ){ //SubComlike
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"δήλωσε ότι του αρέσει το <a href='post.php?postid="+postid+"' class='ah3'><b>υποσχόλιο </b></a>σας</p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"likes your <a href='post.php?postid="+postid+"' class='ah3'><b>subcomment </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid!=0) && (subcomid!=0) && (likes==false) && (dislikes==true) && (spec==false) ){ //SubComdislike
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"δήλωσε ότι δεν του αρέσει το <a href='post.php?postid="+postid+"' class='ah3'><b>υποσχόλιο </b></a>σας</p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"dislikes your <a href='post.php?postid="+postid+"' class='ah3'><b>subcomment </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid==0) && (subcomid==0) && (likes==false) && (dislikes==false) && (comments==true) && (subcomments==false) && (spec==false) ){ //PostComment
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"έκανε ένα σχόλιο στη <a href='post.php?postid="+postid+"' class='ah3'><b>δημοσίευση </b></a>σας</p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"comments at your <a href='post.php?postid="+postid+"' class='ah3'><b>post </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid==0) && (subcomid==0) && (likes==false) && (dislikes==false) && (comments==true) && (subcomments==false) && (spec==true) ){ //PostCommentSpecs
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"σχολίασε επίσης μια <a href='post.php?postid="+postid+"' class='ah3'><b>δημοσίευση </b></a></p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"also commented on a <a href='post.php?postid="+postid+"' class='ah3'><b>post </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid!=0) && (subcomid!=0) && (likes==false) && (dislikes==false) && (comments==false) && (subcomments==true) && (spec==false) ){ //PostSubComment
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"έκανε ένα υποσχόλιο στο <a href='post.php?postid="+postid+"' class='ah3'><b>σχόλιο </b></a>σας</p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"subcomments at your <a href='post.php?postid="+postid+"' class='ah3'><b>comment </b></a></p5>"
						+"<br><br></div>";
					}
				}
				if( (postid!=0) && (comid!=0) && (subcomid!=0) && (likes==false) && (dislikes==false) && (comments==false) && (subcomments==true) && (spec==true) ){ //PostSubCommentSpecs
					if(getCookie('lang')=="gr"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5>"+protext+" <a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"υποσχολίασε επίσης ένα <a href='post.php?postid="+postid+"' class='ah3'><b>σχόλιο </b></a></p5>"
						+"<br><br></div>";
					}
					if(getCookie('lang')=="en"){
						document.getElementById('nnotifications').innerHTML+="<div onclick='clicknot("+notid+");' style='width:95%;height:auto;min-height:50px;background-color:"+ncolor+";border: 2px black solid;white-space:pre-wrap; word-wrap:break-word;'>"
						+"<img src='../"+npimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;height:80px;width:80px;float:left;margin:5px;' />"
						+"<p5><a href='profile.php?id="+actor+"' class='ah3'><b>"+nfname+" "+nlname+" </b></a>"
						+"also subcommented on a <a href='post.php?postid="+postid+"' class='ah3'><b>commnent </b></a></p5>"
						+"<br><br></div>";
					}
				}
			}
		}
	});	
}
nctime=1000;
setInterval(function(){
	updatenotscoins();
	nctime=10000;
}, nctime);
parsedurl = window.location.href.toString();;
serverip="165.22.184.52";
if(parsedurl.includes(serverip)==true){
	parsedurl=parsedurl.replace(serverip, "fullhood.com");
	window.location.replace(parsedurl);
}
function mmchange(){
	if(document.getElementById('mobilemenu').value == "Logout" || document.getElementById('Logout').selected == true) {
		document.getElementById("mmlogout").submit();
	}
	if(document.getElementById('mobilemenu').value == "Profile" || document.getElementById('Profile').selected == true) {
		document.getElementById("mmprofile").submit();
	}
	if(document.getElementById('mobilemenu').value == "Settings" || document.getElementById('Settings').selected == true) {
		document.getElementById("mmsettings").submit();
	}
}
function showalertlogin(){
	document.getElementById('alertlogin').style.visibility = "visible";
}
function alertloginclose(){
	document.getElementById('alertlogin').style.visibility = "hidden";
}
</script>
</head>
<div id='header'>
	<form id='logo' action='index.php' method='POST' style='float:left;margin-left:10px;'>
		<input type='hidden' name='lang' value='<?php echo $lang; ?>'/>
		<p style='font-weight:bold;font-size:38px;color:#FFFFFF;cursor:pointer;' onclick='document.getElementById("logo").submit();' >
		<img src='../img/logo.png' style='height:88px;width:88px;float:left;margin:3px;' ></img></p>
	</form>
	<?php
		if (!isset($_COOKIE['id']) and !isset($_COOKIE['fname']) and !isset($_COOKIE['lname']) and !isset($_COOKIE['gen']) 
		and !isset($_COOKIE['lang']) and !isset($_COOKIE['status']) and !isset($_COOKIE['day']) and !isset($_COOKIE['month']) and !isset($_COOKIE['year']) ) {
			if($lang=='en'){$textpass="Password";$textlogin="Login";$textuser="Username";}
			if($lang=='gr'){$textpass="Κωδικός";$textlogin="Είσοδος";$textuser="Όνομα Χρήστη";}
			echo "
			<input type='submit' class='cbutton' value='$textlogin' onclick='showalertlogin();' style='float:right;margin-right:15px;margin-top:22px;'/>
			<div id='alertlogin' style='visibility:hidden;width:512px;;height:380px;background-color:#20C20E;margin-top:100px;'>
				<input type='image' onclick='alertloginclose();' src='../img/close.png' style='height:60px;width:60px;float:right;'/>
				<img src='../img/ogimage1024x512.png' style='width:256px;height:128px;margin-right:-15px;'></img>			
				<form name='login' method='post' action='index.php'>
					<table style='margin:10px;'>
						<tr>
							<td style='width:180px;margin:10px;'><p1>$textuser </p1></td>
							<td style='margin:10px;'><input type='text' name='username' ></td>
						</tr>
						<tr>
							<td style='width:180px;margin:10px;'><p1>$textpass</p1></td>
							<td style='margin:10px;'><input type='password' name='password'></td>
							<input type='hidden' name='lang' value='$lang'/>
							<input type='hidden' name='loginform' value='loginform'/>
						</tr>
					</table><br>
					<div class='g-recaptcha' data-sitekey='ENTER YOUR PUBLIC RECAPTCHA V2 KEY'></div><br>
					<center><input type='submit' class='cbutton' name='submit' value='$textlogin'></center>
				</form>
			</div>";

		}
		if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) 
		and isset($_COOKIE['lang']) and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year'])
		and (securelogin()==true) and ($_COOKIE['status']=='dead') ) {
			echo "
			<form action='index.php' method='POST' style='float:right;margin-right:5px;'>
				<input type='hidden' name='lang' value='$lang'/>
				<input type='hidden' name='logout' value='logout'/>
				<input type='image' name='submit' src='../img/logout.png' style='height:40px;width:40px;float:left;margin-top:5px;margin-right:5px;' value='Submit' />
			</form>";
		}
		if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
		and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') 
		and (securelogin()==true) ) {
			$result = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
			while($row = mysqli_fetch_array($result)){
				$pimg=$row['pimg'];
				$coins=$row['coins'];
			}
			echo "
			<form id='mmlogout' action='index.php' method='POST'>
				<input type='hidden' name='logout' value='logout'/>
			</form>
			<form id='mmprofile' action='profile.php' method='GET'>
				<input type='hidden' name='id' value='".$_COOKIE['id']."'/>
			</form>
			<form id='mmsettings' action='settings.php' method='POST'>
				<input type='hidden' name='gotosettings' value='gotosettings'/>
			</form>
			<select id='mobilemenu' onchange='mmchange();' style='float:right;width:88px;height:88px;float:right;margin-top:6px;margin-right:15px;' >
				<option id='Menu' name='Menu' style=\"background-image:url('../img/menu.png');\">Menu</option>
				<option id='Profile' name='Profile'>Profile</option>
				<option id='Settings' name='Settings'>Settings</option>
				<option id='Logout' name='Logout'>Logout</option>
			</select> 
			<input type='image' id='buttonnotification' src='../img/notification.png' style='height:88px;width:88px;float:right;margin-top:6px;margin-right:15px;' value='Submit' />
			<div id='nots' onclick='document.getElementById(\"buttonnotification\").click()'style='width:auto;min-width:88px;height:32px;top:68px;right:96px;position:absolute;background-color:transparent;border-radius:50%;float:right;margin-right:20px;cursor:pointer;'>
			</div>
			<a href='messages.php' class='ah3'>
				<input type='image' id='buttonmessage2' src='../img/message.png' style='height:88px;width:88px;float:right;margin-top:6px;margin-right:15px;' value='Submit' />
				<div id='mesnots' style='width:auto;min-width:88px;top:68px;height:32px;right:200px;position:absolute;background-color:transparent;border-radius:50%;float:right;margin-right:20px;cursor:pointer;'>
				</div>
			</a>
			<input type='image' id='buttonfriends' src='../img/friends2.png' style='height:88px;width:88px;float:right;margin-top:6px;margin-right:15px;' value='Submit'>
				<p id='frequestcount'>
				</p>
			</input>
			<div style='float:right;height:100px;width:87px;margin-right:5px;'>
				<center>
				<form id='coinform' action='coin.php' method='POST'>
					<input type='image' name='submit' src='../img/347coin.png' style='height:70px;width:87px;margin-top:5px;' value='Submit' />
				</form>
				<div>
					<a href='javascript:{}' onclick='postform2();' class='ah4'>
						<p20 id='headercoins'>".number_format($coins,3)."</p20>
					</a>
				</div>
				</center>
			</div>
			<a href='searchfriends.php' class='ah3' style=float:left;'><img src='../img/searchfriend.png' style='height:88px;width:88px;float:left;margin-left:15px;'/></a>
			<!--div style='height:30px;width:260px;margin-top:10px;float:left;'>
				<input type='text' onkeyup='search(this.value)' style='height:30px;width:200px;font-size:20px;font-weight:bold;border:2px black solid;float:left;'>
				<img src='../img/search.png' style='height:30px;width:30px;float:left;'/>
			</div-->
			<!--a href='news.php' class='ah3' style=float:right;'><img src='../img/news.png' style='height:44px;width:44px;float:right;margin-top:3px;margin-right:5px;'/></a-->
			";
		}
	?>
</div>

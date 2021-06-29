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
	if (isset($_COOKIE['id']) and isset($_COOKIE['fname']) and isset($_COOKIE['lname']) and isset($_COOKIE['gen']) and isset($_COOKIE['lang']) 
	and isset($_COOKIE['status']) and isset($_COOKIE['day']) and isset($_COOKIE['month']) and isset($_COOKIE['year']) and ($_COOKIE['status']=='active') and (securelogin()==true) ) {
		if($lang=="gr"){
			$friendrequeststext="Αιτήματα Φιλίας";
			$messagerequesttext="Αιτήματα Μυνημάτων";
			$notificationtext="Ειδοποιήσεις";
		}
		if($lang=="en"){
			$friendrequeststext="Friend Requests";
			$messagerequesttext="Message Requests";
			$notificationtext="Notifications";
		}
		echo "
		<div id='nfriends' class='notification'>
			<div style='width:95%;'><p15><b>$friendrequeststext</b></p15></div>
		</div>
		<div id='nmessages' class='notification'>
			<div style='width:95%;'><p15><b>$messagerequesttext</b></p15></div>
		</div>
		<div id='nnotifications' class='notification'>
			<div style='width:95%;height:40px;'><img src='../img/read.png' onclick='readnots();' style='border-radius:50%;height:40px;width:40px;float:left;left:0px;top:0px;margin:5px;position:absolute;cursor:pointer;' /><p5><b>$notificationtext</b></p5></div>
		</div>
		<div id='search' class='search'>
		</div>
		<div id='vld' class='vld'>
		</div>
		<div id='chatwindow'>
		</div>
		<div id='emoji'>";
			$emoji=array('😀','😃','😄','😁','😆','😅','🤣','😂','🙂','🙃',
			'😉','😊','😇','🥰','😍','🤩','😘','😗','😚','😙',
			'😋','😛','😜','🤪','😝','🤑','🤗','🤭','🤫','🤔',
			'🤐','🤨','😐','😑','😶','😏','😒','🙄','😬','🤥',
			'😌','😔','😪','🤤','😴','😷','🤒','🤕','🤢','🤮',
			'🤧','🥵','🥶','🥴','😵','🤯','🤠','🥳','😎','🤓',
			'🧐','😕','😟','🙁','☹','😮','😯','😲','😳','🥺',
			'😦','😧','😨','😰','😥','😢','😭','😱','😖','😣',
			'😞','😓','😩','😫','😤','😡','😠','🤬','😈','👿','💋',
			'💀','☠','💩','🤡','👹','👺','👻','👽','👾','🤖','🎧','⚽','💣','💊','💉',
			'🖐','✋','🖖','👌','✌','🤟','🤙','🖕','👍','👎','👅','👀');
			for($x=0;$x<count($emoji);$x++){
				echo "<p2 onclick=\"addemoji('".$emoji[$x]."');\" style='cursor:pointer;'>".$emoji[$x]."</p2>";
			}
		echo"
		</div>
		";
	}
?>
<script>
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
	var timeset=1000;
	if(getCookie('lang')=='gr'){faccept='Αποδοχή';freject='Διαγραφή';} // jstranslate
	if(getCookie('lang')=='en'){faccept='Accept';freject='Reject';}
	usedids=[];
	CookieGen=getCookie('gen');
	CookieLang=getCookie('lang');
	setInterval(function(){
		try{
			var request = $.ajax({
				type: "post",
				url: "../ajax/aftercodeRequests.php",
				data: {'getfriendrequests': '','getfriendrequestsdata': '','lastaction': window.location.href},
				success : function(data){
					gfrequest=data[0];
					if(gfrequest.length>0){
						document.getElementById("frequestcount").innerHTML=gfrequest.length;
						document.getElementById("frequestcount").style="border-radius:50%;width:88px;height:32px;font-size:24px;font-weight:bold;color:#FFFFFF;background-color:red;float:right;margin-right:-88px;margin-top:68px;cursor:pointer;overflow:hidden;";
					}else{
						document.getElementById("frequestcount").innerHTML="";
						document.getElementById("frequestcount").style="width:88px;height:32px;font-size:24px;font-weight:bold;color:#FFFFFF;background-color:transparent;float:right;margin-right:-88px;margin-top:68px;cursor:pointer;overflow:hidden;";
					}
					gfrequestdata=data[1];
					gfrequestdata.reverse();;
					for(var x=0;x<gfrequestdata.length;x++){
						uid=gfrequestdata[x][0];
						if (usedids.includes(uid)==false){
							ufname=gfrequestdata[x][1];
							ulname=gfrequestdata[x][2];
							upimg=gfrequestdata[x][3];
							ugen=gfrequestdata[x][4];
							if(CookieLang=='gr'){
								if(ugen=='Male'){fprotext="<p5>Ο ";}
								if(ugen=='Female'){fprotext="<p5>Η ";}
								frtext=fprotext+"<a href='profile.php?id="+uid+"' class='ah3' ><b>"+ufname+" "+ulname+"</b></a> σας έστειλε ένα αίτημα φιλίας ...</p5>";
							}
							if(CookieLang=='en'){frtext="<p5><a href='profile.php?id="+uid+"' class='ah3' ><b>"+ufname+" "+ulname+"</b></a> send you a friend request...</p5>";}
							document.getElementById("nfriends").innerHTML+="<div id='fra"+uid+"' style='width:95%;height:auto;min-height:120px;background-color:#FFFFFF;border: 2px blue solid;'>"
							+frtext
							+"<img src='../"+upimg+"' style='height:100px;width:100px;border-radius:50%;float:left;margin-top:5px;'/><br><br>"
							+"<div>"
								+"<input type='submit' class='frbutton' value='"+faccept+"' onclick=\"fracceptreq('"+uid+"')\"/>"
								+"<input type='submit' class='ufrbutton' style='margin-left:15px;' value='"+freject+"' onclick=\"frrejectreq('"+uid+"')\"/>"
							+"</div>"
							+"</div>";
							usedids.push(uid);
						}
					}
					onlineusers=data[2];
					for(o in onlineusers){
						ouid=onlineusers[o][0];
						oubool=onlineusers[o][1];
						if(oubool==false){
							document.getElementById('online'+ouid).innerHTML='';
							document.getElementById('online'+ouid).style="visibility:hidden;width:30px;top:0px;left:0px;position:absolute;height:30px;background-color:#1aff1a;border: 1px green solid;border-radius:50%;float:left;cursor:pointer;margin-left:80px;margin-top:5px;";
							document.getElementById('online'+ouid).style.visibility='hidden';
						}else if (oubool==null){
							document.getElementById('online'+ouid).innerHTML='';
							document.getElementById('online'+ouid).style="visibility:hidden;width:30px;top:0px;left:0px;position:absolute;height:30px;background-color:#33d6ff;border: 1px blue solid;border-radius:50%;float:left;cursor:pointer;margin-left:80px;margin-top:5px;";
							document.getElementById('online'+ouid).style.visibility='visible';
						}else{
							document.getElementById('online'+ouid).innerHTML='';
							document.getElementById('online'+ouid).style="visibility:hidden;width:30px;top:0px;left:0px;position:absolute;height:30px;background-color:#1aff1a;border: 1px green solid;border-radius:50%;float:left;cursor:pointer;margin-left:80px;margin-top:5px;";
							document.getElementById('online'+ouid).style.visibility='visible';
						}
					}
				}
			});
			timeset=15000;
		}catch(err){alert(err.message);}
	}, timeset);
	function frrejectreq(frid){
		var request = $.ajax({
			type: "post",
			url: "../ajax/dataunfraccept.php",
			data: {'unfraccept': frid},
			success : function(data){
				fraccepted=data;
				document.getElementById("fra"+frid).remove();
			}
		});	
	}
	function fracceptreq(frid){
		var request = $.ajax({
			type: "post",
			url: "../ajax/datafraccept.php",
			data: {'fraccept': frid},
			success : function(data){
				fraccepted=data;
				document.getElementById("fra"+frid).remove();
			}
		});		
	}
	function addemoji(emoji){
		document.getElementById("message").value+=emoji;	
	}
</script>
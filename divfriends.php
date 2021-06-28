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
include("mysql.php"); 
include_once("login.php"); 
include_once("lang.php");
include_once("precode.php");
include_once("timezones.php");
?>
<div id='friends' style='width:250px;margin-top:50px;right:0px;top:0px;bottom:0px;background-color:#F8F8F8;border:2px #20C20E solid;overflow-y:scroll;overflow-x:hidden;position:fixed;scrollbar-width: none;-ms-overflow-style: none;'>
	<?php
		$result2 = mysqli_query($con,"SELECT * FROM users WHERE id='".$_COOKIE['id']."' ");
		while($row2 = mysqli_fetch_array($result2)){
			$friends=unserialize($row2['friends']);
			for($x=0;$x<count($friends);$x++){
				$result3 = mysqli_query($con,"SELECT * FROM users WHERE id='".$friends[$x]."' ");
				while($row3 = mysqli_fetch_array($result3)){
					$fid=$row3['id'];
					$fpimg=$row3['pimg'];
					$ffname=$row3['firstname'];
					$flname=$row3['lastname'];
					echo "
					<div style='height:auto;width:250px;overflow-x:hidden;position:relative;' onclick=\"cwindow('$fid');\" >

						<div id='friendspicname' style='width:400px;position:relative;'>
						<a href='javascript:{}' class='ah3' style='float:left;'>
							<img src='".$fpimg."' onerror=\"this.onerror=null;this.src='img/ogimage1024x512.png';\" style='border-radius: 50%;width:35px;height:35px;' ></img>
						</a>
						<a href='javascript:{}' class='ah3' style='float:left;margin-top:10px;'>
							<p11>&nbsp&nbsp".$ffname." ".$flname."</p11>
						</a>
						</div>
						<div id='msg".$fid."' style='width:auto;min-width:38px;top:0px;right:0px;position:absolute;height:auto;background-color:transparent;border-radius:50%;float:right;margin-right:20px;cursor:pointer;'>
							<!--p3>1</p3-->
						</div>
						<div id='online".$fid."' style='visibility:hidden;width:15px;top:0px;left:25px;position:absolute;height:15px;background-color:#1aff1a;border: 1px green solid;border-radius:50%;float:left;cursor:pointer;'>
						</div>
					</div><br>";
				}
			}
		}			
	?>
	<input type='hidden' id='chatactor' value='null' />
</div>
<script>
	mesids=[];
	function cwindow(cfid){
		var openchat=cfid;
		document.getElementById('msg'+cfid).innerHTML="";
		document.getElementById('msg'+cfid).style.backgroundColor="transparent";
		if(getCookie('lang')=='gr'){phmsg='Γράψτε ένα μήνυμα...';msgsend='Αποστολή';}
		if(getCookie('lang')=='en'){phmsg='Write a message...';msgsend='Send';}
		var request = $.ajax({
			type: "post",
			url: "chat/getuserdata.php",
			data: {'getuserdata': cfid},
			success : function(data){
				var pimg = data[0];
				var fname = data[1];
				var lname = data[2];
		document.getElementById('chatwindow').innerHTML=""
		+"<div id='notdiv' style='overflow-x:hidden;'><a href='profile.php?id="+cfid+"' class='ah3'><img src='"+pimg+"' onerror=\"this.onerror=null;this.src='img/ogimage1024x512.png';\" style='border-radius:50%;width:30px;height:30px;'></img><p11>"+fname+" "+lname+"</p11></a>"
			+"<input type='image'  onclick='closechat();' src='img/close.png' style='height:20px;width:20px;right:0px;position:absolute;' />"
		+"</div>"
		+"<div id='msgflow' style='overflow-y:scroll;overflow-x:hidden;border: 2px grey solid;height:284px;width:97%;'></div>"
		+"<textarea rows='2' cols='10' id='message' name='message' placeholder='"+phmsg+"' onkeypress='pressenter(event);' style='font-size:16px;width:98%;height:50px;position:absolute;left:0px;bottom:30px;resize: none;' '></textarea>"
		+"<img src='img/emoji.png' onclick='showemoji();' style='width:30px;height:30px;position:absolute;bottom:27px;right:2px;cursor:pointer;'></img>"
		+"<button id='penter' class='chatbutton' style='height:26px;width:98%;position:absolute;bottom:0px;left:0px;' onclick=\"sendmessage('"+cfid+"');\"  />"+msgsend+"</button>";
	
		document.getElementById('chatwindow').style.visibility='visible';
		document.getElementById('chatactor').value=cfid;
		mesids=[];
			}
		});		

	}
	function pressenter(e) {
		if (e.keyCode == 13) {
			document.getElementById('penter').click()
		}
	}
	function closechat(){
		document.getElementById('chatactor').value='null';
		document.getElementById('chatwindow').style.visibility='hidden';
		document.getElementById('emoji').style.visibility='hidden';
		ecounter=0;
	}
	var ecounter=0;
	function showemoji(){
		ecounter+=1;
		if(ecounter%2==0){
			document.getElementById('emoji').style.visibility='hidden';
		}else{
			document.getElementById('emoji').style.visibility='visible';
		}
	}
	function sendmessage(msgid){
		function fix1(find,repl,str) {
			return str.replace(new RegExp(find, 'g'), repl);
		}
		message=document.getElementById('message').value;
		document.getElementById('message').value="";
		message =fix1("'","", message);
		message =fix1("</xmp>","", message);
		var request = $.ajax({
			type: "post",
			url: "chat/sendmessage.php",
			data: {'msgid': msgid,'message': message}
		});
		
	}
	function getmessages(actor1,actor2) {      
		var request = $.ajax({
			type: "post",
			url: "chat/getmessages.php",
			data: {'actor1': actor1 ,'actor2': actor2},
			success : function(msgdata2){
				messages=msgdata2;
				messages.reverse();
				onesound=true;
				for(i in messages){
					actor1=messages[i][0];
					mesid=messages[i][1];
					message=messages[i][2];
					date=messages[i][3];
					pimg=messages[i][4];
					fname=messages[i][5];
					lname=messages[i][6];
					if(mesids.includes(mesid)==false){
						document.getElementById('msgflow').innerHTML+=""
						+"<div id='notdiv' style='width:95%;white-space:pre-wrap; wor-wrap:break-word;'><a href='profile.php?id="+actor1+"' class='ah3'><img src='"+pimg+"' onerror=\"this.onerror=null;this.src='img/ogimage1024x512.png';\" style='border-radius:50%;width:30px;height:30px;top:2px;left:2px;position:absolute;'></img><p11>&nbsp&nbsp<b>"+fname+" "+lname+"</b></p11></a><br><p11>"+date+"</p11><br><br>"
						+"<p12><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+message+"</xmp></p12>"
						+"</div>";
						mesids.push(mesid);
						if(actor1==getCookie('id')){
							document.getElementById('msgflow').scrollTop = document.getElementById('msgflow').scrollHeight;
						}else{
							if(onesound==true){
								playmsg();
								onesound=false;
							}
							document.getElementById('msgflow').scrollTop = document.getElementById('msgflow').scrollHeight;
						}
					}
				}
			}
		});
	}
	var msgsound = new Audio('sounds/message.mp3');
	function playmsg(){
		msgsound.pause();
		msgsound.currentTime = 0;
		msgsound.volume = 1;
		msgsound.play();
	}
	function unreaded2(){
		var request = $.ajax({
			type: "post",
			url: "chat/unreaded.php",
			data: {'unreaded': ''},
			success : function(umsg){
				uread=umsg;
				for(i in uread){
					uid=uread[i][0];
					ucount=uread[i][1];
					if(ucount==0){
						document.getElementById('msg'+uid).innerHTML="";
						document.getElementById('msg'+uid).style.backgroundColor="transparent";
					}else{
						document.getElementById('msg'+uid).innerHTML="<p3>"+ucount+"</p3>";
						document.getElementById('msg'+uid).style.backgroundColor="red";						
					}
				}
			}
		});
	}
	setInterval(function(){
		unreaded2();
		try{
			if(document.getElementById('chatactor').value!='null'){
				messages=getmessages(getCookie('id'),document.getElementById('chatactor').value);
				
			}
		}catch(err){}
	}, 3500);
</script>
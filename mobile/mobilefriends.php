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
<div id='mobilefriends'>
	<div id='listfriends' style='height:300px;width:100%;overflow-y:scroll;overflow-x:hidden;position:absolute;'>
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
					<div style='overflow-x:hidden;position:relative;float:left;width:320px;height:300px;'>
						<div id='friendspicname' style='width:320px;position:relative;background-color:#FFFFFF;' onclick=\"cwindow('$fid');\">
							<a href='javascript:{}' class='ah3' style='float:left;'>
								<img src='../".$fpimg."' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius: 50%;width:130px;height:130px;' ></img>
								<br><br>
								<p14>&nbsp&nbsp".$ffname." ".$flname."</p14>
							</a>
						</div>
						<div id='msg".$fid."' style='font-size:5vw;width:auto;min-width:75px;top:55px;left:70px;position:absolute;height:auto;background-color:transparent;border-radius:50%;float:left;cursor:pointer;'>
							<!--p3>1</p3-->
						</div>
						<div id='online".$fid."' style='visibility:hidden;width:30px;top:0px;left:0px;position:absolute;height:30px;background-color:#1aff1a;border: 1px green solid;border-radius:50%;float:left;cursor:pointer;margin-left:80px;margin-top:5px;'>
						</div>
					</div>";
				}
			}
		}			
	?>
	</div>
	<?php
		$lf=count($friends)*320;
		echo "	
		<script>
			document.getElementById('listfriends').style.width='".$lf."px';
		</script>";
	?>
	<input type='hidden' id='chatactor' value='null' />
</div>
	<div id='mobilemessages'>
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
			url: "../chat/getuserdata.php",
			data: {'getuserdata': cfid},
			success : function(data){
				var pimg = data[0];
				var fname = data[1];
				var lname = data[2];
		document.getElementById('mobilemessages').innerHTML=""
		+"<div id='notdiv' style='overflow-x:hidden;width:100%;height:145px;'><a href='profile.php?id="+cfid+"' class='ah3'><img src='../"+pimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:130px;height:130px;'></img><p7>"+fname+" "+lname+"</p7></a>"
			//+"<input type='image'  onclick='closechat();' src='../img/close.png' style='height:40px;width:40px;right:0px;position:absolute;' />"
		+"</div>"
		+"<div id='msgflow' style='overflow-y:scroll;overflow-x:hidden;top:160px;left:0px;right:0px;bottom:240px;width:100%;position:absolute;'></div>"
		+"<textarea rows='2' cols='10' id='message' name='message' placeholder='"+phmsg+"' onkeypress='pressenter(event);' style='font-size:4vw;width:100%;height:180px;position:absolute;left:0px;bottom:30px;resize: none;' '></textarea>"
		//+"<img src='../img/emoji.png' onclick='showemoji();' style='width:30px;height:30px;position:absolute;bottom:27px;right:2px;cursor:pointer;'></img>"
		+"<button id='penter' class='chatbutton' style='height:70px;width:100%;font-size:4vw;position:absolute;bottom:0px;left:0px;' onclick=\"sendmessage('"+cfid+"');\"  />"+msgsend+"</button>";
	
		//document.getElementById('chatwindow').style.visibility='visible';
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
			url: "../chat/sendmessage.php",
			data: {'msgid': msgid,'message': message}
		});
		
	}
	function getmessages(actor1,actor2) {      
		var request = $.ajax({
			type: "post",
			url: "../chat/getmessages.php",
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
						+"<div id='notdiv' style='width:100%;white-space:pre-wrap; wor-wrap:break-word;'><a href='profile.php?id="+actor1+"' class='ah3'><img src='../"+pimg+"' onerror=\"this.onerror=null;this.src='../img/ogimage1024x512.png';\" style='border-radius:50%;width:130px;height:130px;top:2px;left:2px;position:absolute;'></img><p9>&nbsp&nbsp<b>"+fname+" "+lname+"</b></p9></a><br><p5>"+date+"</5><br><br><br><br>"
						+"<p7><xmp style='white-space:pre-wrap; word-wrap:break-word;'>"+message+"</xmp></p7>"
						+"</div>";
						mesids.push(mesid);
						if(actor1==getCookie('id')){
							document.getElementById('msgflow').scrollTop = document.getElementById('msgflow').scrollHeight;
						}else{
							document.getElementById('msgflow').scrollTop = document.getElementById('msgflow').scrollHeight;
							if(onesound==true){
								playmsg();
								onesound=false;
							}
						}
					}
				}
			}
		});
	}
	var msgsound = new Audio('../sounds/message.mp3');
	function playmsg(){
		msgsound.pause();
		msgsound.currentTime = 0;
		msgsound.volume = 1;
		msgsound.play();
	}
	function unreaded2(){
		var request = $.ajax({
			type: "post",
			url: "../chat/unreaded.php",
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
	mbtime=1000;
	setInterval(function(){
		unreaded2();
		try{
			if(document.getElementById('chatactor').value!='null'){
				messages=getmessages(getCookie('id'),document.getElementById('chatactor').value);
				
			}
		}catch(err){}
		mbtime=3500;
	}, mbtime);
</script>
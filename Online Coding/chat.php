<?php
   if ( ! isset($_COOKIE['login']) ) {
      echo "Need to log in first";
      header("refresh:2;url=login.html");
      exit;
   }
   $login=$_COOKIE['login'];
   $groupname = $_GET['groupname'];
   ?>
<html>
<head>
   <link rel="stylesheet" href="style/styles.css" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />
   <script>

         var groupname = '<?php echo $groupname; ?>';

var divx = document.getElementById("chat");
divx.scrollTop = divx.scrollHeight;

   </script>
<style>
.message {
   overflow:hidden;
   width:490px;
   margin-bottom:1.5px;
    padding: 1.5px 2px;
    border: 1px #222 solid;
}
.messagehead {
      overflow:hidden;
   color: #000080;
   width:490px;
}
.messagecontent {
   background: AliceBlue;

   overflow:hidden;
   width:490px;
}

</style>
</head>

<body class ="center">
<div id="dolphincontainer">
   <div id="dolphinnav">
      <ul>
         <li><a href="myaccount.php"><span>My Account</span></a></li>
         <li><a href="myfiles.php"><span>My Files</span></a></li>
         <li><a href="contacts.php"><span>My Contacts</span></a></li>
         <li><a href="groups.php"><span>My Projects</span></a></li>
         <li><a href="notifications.php"><span>Notifications</span></a></li>
         <li><a href="messages.php"><span>Messages</span></a></li>
         <li><a href="logout.php"><span>Log out</span></a></li>
      </ul>
   </div>
</div>
<h2>Group Chat</h2>

<form>
<div id="chat" style="max-height:500px; overflow:hidden;">
<div id="messages" style="max-height:500px" ></div>
<div id="error" style="width:500px;text-align:center;color:red;"></div>
</div>
<div id="write" style="text-align:left;"><textarea placeholder="Enter your message here" id="message" cols="71" rows="2" style="color:#00f;background-color:#ddd;"></textarea></br></br><input type="button" class="btn2" value="Send" onClick="send();"/></div>
</form>

<script type="text/javascript">
//This function will display the messages
function showmessages(){
   //Send an XMLHttpRequest to the 'show-message.php' file
         var groupname = '<?php echo $groupname; ?>';
   if(window.XMLHttpRequest){

      var show = 'show-messages.php?groupname=' + groupname;

      xmlhttp = new XMLHttpRequest();
      xmlhttp.open("GET",show,false);
      xmlhttp.send(null);
   }
   else{
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      xmlhttp.open("GET",show,false);
      xmlhttp.send();
   }
   //Replace the content of the messages with the response from the 'show-messages.php' file
   document.getElementById('messages').innerHTML = xmlhttp.responseText;
   //Repeat the function each 30 seconds
   setTimeout('showmessages()',500);
}
//Start the showmessages() function
showmessages();
//This function will submit the message
function send(){
   //Send an XMLHttpRequest to the 'send.php' file with all the required informations
   var groupname = '<?php echo $groupname; ?>';
   var message = document.getElementById('message').value;
   document.getElementById('message').value = ' ';
   var sendto = 'send.php?message=' + message + '&groupname=' + groupname;
   if(window.XMLHttpRequest){
      xmlhttp = new XMLHttpRequest();
      xmlhttp.open("GET",sendto,false);
      xmlhttp.send(null);
   }
   else{
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      xmlhttp.open("GET",sendto,false);
      xmlhttp.send();
   }

   var error = '';
   //If an error occurs the 'send.php' file send`s the number of the error and based on that number a message is displayed
   switch(parseInt(xmlhttp.responseText)){
   case 1:
      error = 'The database is down!';
      break;
   case 2:
      error = 'The database is down!';
      break;
   case 3:
      error = 'Don`t forget the message!';
      break;
   case 4:
      error = 'The message is too long!';
      break;
   case 5:
      error = 'Don`t forget the name!';
      break;
   case 6:
      error = 'The name is too long!';
      break;
   case 7:
      error = 'This name is already used by somebody else!';
      break;
   case 8:
      error = 'The database is down!';
   }
   if(error == ''){
      document.getElementById('error').innerHTML = '';
      showmessages();
   }
   else{
      document.getElementById('error').innerHTML = error;
   }
}
</script>

</body>
</html>
<?php 
header('Access-Control-Allow-Origin: *');
include 'inc_classes.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include "include/headHeader.php";?>
<?php //include "include/functions.php"; ?>
	
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.10/themes/smoothness/jquery-ui.css" type="text/css">
<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10/jquery-ui.min.js"></script>
<script>
var data1={action:'show_data',user_nicename:'kiran Vyavahare',user_login:'MM55A8QX',user_pass:'MM55A8QX',user_email:'vyavaharekiran@gmail.com',user_registered:'2020-12-28',display_name:'Kirankumar'};
$.ajax({
	url: "http://isasbeautyschool.co.in/lmsResponse.php",type:"post",data:data1,cache: false,crossDomain:true,async:true,dataType:'jsonp',
	success: function (html)
	{
		alert("successfully");
	},
	error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
	});
</script>
<body>

</body>
</html>
<?php $db->close();?>
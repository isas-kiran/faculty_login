<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
include 'inc_classes.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php include "include/headHeader.php";?>
<?php //include "include/functions.php"; ?>

<!--<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10	/jquery-ui.min.js"></script>
  <script type="text/javascript">  
        $.ajax({
          url: 'http://isasbeautyschool.co.in/lmsResponse.php',
          type: 'POST',
          dataType: 'jsonp',
          data: {action:'show_data',user_nicename:'kiran Vyavahare',user_login:'MM55A8QX',user_pass:'MM55A8QX',user_email:'vyavaharekiran@gmail.com',user_registered:'2020-12-28',display_name:'Kirankumar'},
          crossDomain: true,
          success: function (data, textStatus, xhr) {
            alert("successfully data add");
          },
          error: function (xhr, textStatus, errorThrown) {
            console.log(errorThrown);
          }
        });
</script>-->

<?php
    $ch = curl_init();                    // Initiate cURL
    $url = "http://isasbeautyschool.co.in/lmsResponse.php"; // Where you want to post data
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, true);  // Tell cURL you want to post something
    curl_setopt($ch, CURLOPT_POSTFIELDS, "user_nicename=kiran Test&user_login=kirantest&user_pass=kiran123&user_email=vyavaharekiran@gmail.com&user_registered=2020-12-28&display_name=Kiran Test"); // Define what you want to post
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the output in string format
    $output = curl_exec ($ch); // Execute

    curl_close ($ch); // Close cURL handle

    var_dump($output); // Show output
	
	
	
?>

<!--	
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
</script>-->

<body>

</body>
</html>
<?php $db->close();?>
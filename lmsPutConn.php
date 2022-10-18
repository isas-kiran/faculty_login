<?php include 'inc_classes.php';?>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>

<script>
var data1="action=show_data&user_nicename=kiran Vyavahare&user_login=MM55A8QX&user_pass=MM55A8QX&user_email=vyavaharekiran@gmail.com&user_registered=2020-12-28&display_name=Kirankumar";
$.ajax({
	url: "http://isasbeautyschool.co.in/lmsResponse.php", type: "post", data: data1, cache: false,
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
<?php
	/*echo $service_url ="http://isasbeautyschool.co.in/lmsResponse.php?user_nicename=kiran Vyavahare&user_login=MM55A8QX&user_pass=MM55A8QX&user_email=vyavaharekiran@gmail.com&user_registered=".date('Y-m-d H:i:s')."&display_name=Kirankumar";
	$homepage = file_get_contents($service_url);
	if($homepage)
	{
	  echo "<br/>Message Send Compleated...";
	}
	else
	{
		echo "&nbsp;SMS Faild to Send. Something Went Wrong...";
	}

echo $sms_url=sprintf("http://isasbeautyschool.co.in/lmsResponse.php?user_nicename=%s&user_login=%s&user_pass=%s&user_email=%s&user_registered=%s&display_name=%s",'kiran Vyavahare','kiran','kiran1234','kiran@gmail.com','2020-12-28 16:12:23','Kirankumar Vyavahare');
openurl($sms_url);
function openurl($url)
{

$ch=curl_init();

curl_setopt($ch,CURLOPT_URL,$url);

curl_setopt($ch, CURLOPT_POST, 1);

curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch,CURLOPT_TIMEOUT, 3);  
echo "<br/>".$content = trim(curl_exec($ch));  curl_close($ch);

}*/
?>
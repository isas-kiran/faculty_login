

<body>
<?php 

/* gets the data from a URL */
 //$url="http://202.54.31.7/citywx/city_weather1.php?id=42182/";
//======== MUMBAI Forecast URL 
$url = "https://www.google.co.in/search?q=udaipur+weather";
	
	$ch = curl_init();
	$timeout = 10;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    
	
	 $contents = curl_exec($ch);
	
	if (curl_errno($ch))
	 {
       echo curl_error($ch);
       echo "\n<br />";
       $contents = '';
     }
	  else 
	  {
        curl_close($ch);
      }
	  
	  if (!is_string($contents) || !strlen($contents)) 
	  {
        echo "Failed to get contents...";
        $contents = '';
      }
     else
	 {
      // echo $contents;
	  
	   $findme='Udaipur, Rajasthan'; 
	    $pos = strpos($contents, $findme);
	       $remaing_string = strstr( $contents, $findme);
		   
		  $sep_first =  explode('</table>',$remaing_string);
		 $sep_nd=explode('</td>',$sep_first[0]);
		 
		/*echo "Temperature". $int = intval(preg_replace('/[^0-9]+/', '', $sep_nd[1]), 10);
		 
		echo "humidity" .$int1 = intval(preg_replace('/[^0-9]+/', '', $sep_nd[20]), 10);
		 
		echo "wind" .$int2 = intval(preg_replace('/[^0-9]+/', '', $sep_nd[19]),10);*/
		
		
		
		 preg_match_all('/\d+/', $sep_nd[1], $matches1);
    echo $matches1[3];
	
	 preg_match_all('/\d+/', $sep_nd[20], $matches2);
    echo $matches2[2];
	
	 preg_match_all('/\d+/', $sep_nd[19], $matches3);
    echo $matches3[2];
		
		/*preg_match_all('!\d+!', $sep_nd[1], $matches);
		print_r($matches);
		
		preg_match_all('!\d+!', $sep_nd[20], $matches1);
		print_r($matches1);
		
		preg_match_all('!\d+!', $sep_nd[19], $matches2);
		print_r($matches2);*/
		
		echo  "Udaipur, Rajasthan Forecast data retrive from URL : $url <br/> Temperature = ".$precipitation = trim(strip_tags($sep_nd[1]));
		echo  "<br />humidity = ".$humidity = trim(strip_tags($sep_nd[20]));
		echo  "<br />wind = ".$wind = trim(strip_tags($sep_nd[19]));
		/*
		$check_exist = " select temp_id from bp_weather where added_hr='".date('Y-m-d H')."'";
		$ptr_check = mysql_query($check_exist);
		if(!mysql_num_rows($ptr_check))
		{
			 $insert_query = "INSERT INTO `bp_weather` (`temperature`, `precipitation`,`humidity`, `wind`, `added_hr`, `added_time`) VALUES ('".$temperature."', '".$precipitation."', '".$humidity."', '".$wind."', '".date(date('Y-m-d H'))."', '".date('Y-m-d H:i:s')."' ) ";
			$ptr_ins = mysql_query($insert_query);
			echo "<br /> Insert Latest value Successfully";
		}
		else
		 	echo "<br />  Latest value Exist";
		*/
	 }
   


 ?>
  <script lanjuage="javascript">
        setTimeout("document.location.href=document.location.href;",10800000);
</script>
    
</body>
</html>
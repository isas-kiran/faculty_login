<link rel="icon" href="../images/favicon.ico">
<!--<link rel="stylesheet" href="css/css.css" type="text/css" />-->
<link href="js/jquery_popup/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="js/jquery_popup/jquery-ui.min.js"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<!--<script src="js/calendar/jquery.calendar.js" ></script>-->

 <!--script language="javascript" src="../Hindi.js"></script>
<script language="javascript" src="../Parser.js"></script-->
<?php
/*function send_sms($mobile,$message) 
{
	send_sms_function($mobile,$message);	
}
function send_sms_function($mobile,$message)

{


	global $dbObj,$enno_prefix,$enno_sms_password,$enno_sms_user_id,$enno_sms_url,$enno_sms_sender_code,$enno_date,$enno_ip,$enno_logged_in_user_id,$enno_pagename,$enno_project_name;	

    $sql_check_remaining_count="select sms_count from ".$enno_prefix."visitor_count where id=1";

    $res_check_remaining_count=$dbObj->ennoexecutequery($sql_check_remaining_count);

	$row_check_remaining_count=mysql_fetch_array($res_check_remaining_count);

    if($row_check_remaining_count['sms_count'] > 0)

	{*/

		// no $sendmsg ="SMS ID - ".(time()*2)." ".$enno_project_name." Dear Sir, ".$message;
		
		/*$sendmsg=$enno_project_name." Dear Sir, ".$message;

		$cnt=1;

		$len=strlen($sendmsg);

		if($len > 160)

		{

		 $cnt=ceil($len/153);

		}

		decrease_sms_count($cnt);


		$sendmsg=urlencode($sendmsg);*/
		
		
		/*
		no
		$url = "http://bulkpush.mytoday.com/BulkSms/SingleMsgApi?feedid=334166&username=9561295613&password=mtdjw&To=".$mobile."&Text=".$sendmsg."&senderid=SMSSMS";

		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$retval = curl_exec($ch);

		curl_close($ch);*/

//no $url = "http://login.wishbysms.com/sendhttp.php?user=".urlencode('alfaagro')."&password=".urlencode('801275')."&mobiles=".urlencode

/*
$url = "http://sms.waakan.com/api/sendhttp.php?authkey=52271APYdfghhSnL52899896&sender=alfagt&route=4&mobiles=".urlencode
($mobile)."&message=".urlencode($sendmsg)."&sender=".urlencode('alfaat');
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $retval = curl_exec($ch);
                                curl_close($ch);
                                $retval;
		
		$retval=ennoclean($retval);



		$query="update ".$enno_prefix."sms_log set response='".$retval."' where id = '".$last_id_of_sms."'";

		$result=mysql_query($query);

	}

}*/
?>
<!--<link href="js/calendar/jquery.calendar.css" rel="stylesheet" type="text/css"/>-->
<!--<link media="screen" rel="stylesheet" href="../js/colorbox/colorbox.css" />-->

<link type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<!--		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>-->
<!--		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>-->
		<script type="text/javascript">
			$(function(){
				// Accordion
				$("#accordion").accordion({ active:false, header: "h3", autoHeight: false, collapsible: true });					
			});
		</script>
                <script type='text/javascript' src='js/jquery.tipsy.js'></script>
                <script type="text/javascript">
    jQuery(document).ready( function() 
    {       
        $('.example-fade').tipsy({fade: true});
    });
</script>

<script type="text/javascript">
    $(function()
    {
        //$("form").jqTransform();
        /* ----------for showing default text---------------*/
        $(".defaultText").focus(function(srcc)
        {
                if ($(this).val() == $(this)[0].title)
                {
                        $(this).removeClass("defaultTextActive");
                        $(this).val("");
                }
        });

        $(".defaultText").blur(function()
        {
                if ($(this).val() == "")
                {
                        $(this).addClass("defaultTextActive");
                        $(this).val($(this)[0].title);
                }
        });

        $(".defaultText").blur();
    });
    
    
    function redirect(value)
    {
        //alert(value);
        params = window.location.search.substring(1);
        if(params=="eq" || params=="")
            window.location.href=location.href+'?page=0&show_records='+value;
        else
            window.location.href=location.href+'&page=0&show_records='+value;
    }
    
    function checkAll(tmp_frmName,tmp_chkbox)
    {
            frmElement	= eval("document."+tmp_frmName+"['"+tmp_chkbox+"[]']");
            frmName	= eval("document."+tmp_frmName);
            if(frmElement.length)
            {
                    for(var i=0;i<frmElement.length;i++)
                    {
                            if (frmName.chkAll.checked)
                                    frmElement[i].checked = true;
                            else
                                    frmElement[i].checked = false;
                    }

            }
            else
                    {
                            if (frmName.chkAll.checked)
                                    frmElement.checked = true;
                            else
                                    frmElement.checked = false;
                    }

    }
</script>

<script type="text/javascript">
/* ==========CODE FOR Marathi Start========  */
function toggleLayer(whichLayer,m)
		{
     if (document.getElementById)
     {
          // this is the way the standards work
          var style2 = document.getElementById(whichLayer).style;
          style2.display = style2.display? "":"block";
          document.getElementById(m).innerHTML = style2.display?"Hide Instruction":"Show Instruction";
          

     }
     else if (document.all)
     {
          // this is the way old msie versions work
          var style2 = document.all[whichLayer].style;
          style2.display = style2.display? "":"block";
          document.all[m].innerHTML = style2.display?"Hide Instruction":"Show Instruction";

     }
     else if (document.layers)
     {
          // this is the way nn4 works
          var style2 = document.layers[whichLayer].style;
          style2.display = style2.display? "":"block";
          document.layers[m].innerHTML = style2.display?"Hide Instruction":"Show Instruction";

     }
}
function showme()
{
document.getElementById('hindi_images').style.display='block';	
}
function hideme()
{
document.getElementById('hindi_images').style.display='none';	
}

/* ==========CODE FOR Marathi END========  */

    $(function()
    {
        //$("form").jqTransform();
        /* ----------for showing default text---------------*/
        $(".defaultText").focus(function(srcc)
        {
                if ($(this).val() == $(this)[0].title)
                {
                        $(this).removeClass("defaultTextActive");
                        $(this).val("");
                }
        });

        $(".defaultText").blur(function()
        {
                if ($(this).val() == "")
                {
                        $(this).addClass("defaultTextActive");
                        $(this).val($(this)[0].title);
                }
        });

        $(".defaultText").blur();
    });
    function redirect(value)
    {
        //alert(value);
        params = window.location.search.substring(1);
        if(params=="eq" || params=="")
            window.location.href=location.href+'?page=0&show_records='+value;
        else
            window.location.href=location.href+'&page=0&show_records='+value;
    }
   
    function ajax_course(course_id)
	{
			course_id = course_id;
			//alert(course_id);
			if(course_id !='')
        	{
				service_taxes=parseFloat(document.getElementById("service_taxes").value);
				if( course_id != 'custome')
				{
           			var data1="action=show_course&course_id="+course_id+"&service_taxes="+service_taxes;
            		document.getElementById('custome_div').style.display="none";
            		$.ajax({
                	url: "ajax.php", type: "post", data: data1, cache: false,
                	success: function (html)
                	{
                   		//alert(html);
						vals =html.split('###');
						document.getElementById('duration_studies').value=vals[0].trim();
						document.getElementById('total_fees').value=vals[1].trim();
                	}
				
            		});
				}
				else
				{
					//alert("1");
					$( ".new_custom_course" ).dialog({
						width: '500',
						height:'400'
					});
					//document.getElementById('custome_div').style.display="block";
				}
            return false;
        }
				
	}
	
	
	function ajax_kit()
	{
			
		 $( ".new_custom_kit" ).dialog({
									width: '500',
									height:'400'
								});
				
            return false;
       
	}
	
	 function show_course(course_id)
	{
			course_id = course_id;
			//alert(course_id);
			if(course_id !='')
        	{
				if( course_id != 'new_course')
				{
            var data1="action=show_course_enrolled&course_id="+course_id;
            document.getElementById('custome_div').style.display="none";
            $.ajax({
                url: "ajax.php", type: "post", data: data1, cache: false,
                success: function (html)
                {
                  vals =html.split('###');
					//document.getElementById('duration_studies').value=vals[0].trim();
					document.getElementById('toal_fees').value=vals[1].trim();
					if(document.getElementById('course_only_fee'))
					{
						document.getElementById('course_only_fee').value=vals[1].trim();
					}
					show_record();
					
                }
				
            });
				}
				else
				{
                                    $( ".new_custom_course" ).dialog({
                                        width: '500',
                                        height:'400'
                                    });
					//document.getElementById('custome_div').style.display="block";
				}
            return false;
        }
				
	}
    function checkAll(tmp_frmName,tmp_chkbox)
    {
            frmElement	= eval("document."+tmp_frmName+"['"+tmp_chkbox+"[]']");
            frmName	= eval("document."+tmp_frmName);
            if(frmElement.length)
            {
                    for(var i=0;i<frmElement.length;i++)
                    {
                            if (frmName.chkAll.checked)
                                    frmElement[i].checked = true;
                            else
                                    frmElement[i].checked = false;
                    }

            }
            else
                    {
                            if (frmName.chkAll.checked)
                                    frmElement.checked = true;
                            else
                                    frmElement.checked = false;
                    }

    }
</script>

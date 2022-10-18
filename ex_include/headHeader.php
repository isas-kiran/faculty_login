<link rel="icon" href="../images/favicon.ico">
<!--<link rel="stylesheet" href="css/css.css" type="text/css" />-->
<link href="js/jquery_popup/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="js/jquery_popup/jquery-ui.min.js"></script>
<!--<script src="js/calendar/jquery.calendar.js" ></script>-->

 <!--<script language="javascript" src="../Hindi.js"></script>
<script language="javascript" src="../Parser.js"></script>



<link href="js/calendar/jquery.calendar.css" rel="stylesheet" type="text/css"/>
<link media="screen" rel="stylesheet" href="../js/colorbox/colorbox.css" />-->

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
				if( course_id != 'custome')
				{
            var data1="action=show_course&course_id="+course_id;
            document.getElementById('custome_div').style.display="none";
            $.ajax({
                url: "ajax.php", type: "post", data: data1, cache: false,
                success: function (html)
                {
                  // alert(html);
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

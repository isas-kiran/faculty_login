<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT subject_id,name,description,course_domain_id FROM subject where subject_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	
	$sel_topic= "select * from topic_map where subject_id=".$record_id." order by topic_id asc";	
    $query_topic = mysql_query($sel_topic);	
	$total_topic=mysql_num_rows($query_topic);
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Subject</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
<!--End multiselect -->
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
        function showdiv(val)
        {
            if(val=='Y')
            {
                $(".coursess").hide();
            }
            else
            {
                $(".coursess").show();
            }
        }
        function show_dicount(val)
        {            
            if(val=='Y')
            {
                $(".discount").show();
            }
            else
            {
                $(".discount").hide();
            }
        }
    </script>
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
        });
    </script>
    <script src="ckeditor/ckeditor.js"></script>
    <script>
	 function desriptionss(value)
	{
                
		varsss ='<textarea name="description'+value+'" id="description'+value+'"></textarea>';
		return varsss;
		
	}
	
	function subject_name(value)
	{
		vars ='Sebject Name<input type="text" name="name'+value+'" id="name'+value+'" class="input_text" >';
		return vars;
	}
	function techerss(value)
	{
		varss ='<select name="staff_id'+value+'" id="staff_id'+value+'" class="input_select" style="width:150px;"><option value="">Select Teacher </option><?php 
		$select_faculty = "select * from site_setting where 1 and type='f' ".$_SESSION['where']." order by admin_id asc";
		$ptr_faculty = mysql_query($select_faculty);
		while($data_faculty = mysql_fetch_array($ptr_faculty))
		{ 
		  echo '<option value="'.$data_faculty['admin_id'].'" >'.$data_faculty['name'].'</option>';  
		}
		?></select>';
		return varss;
	}
	function del_degree(del)  // for delete the degree
	{
		var i=parseInt(document.getElementById('extra').value);
		if(i !=0)
		{
			document.getElementById(i).style.display='none';
			document.getElementById('extra').value=parseInt((i-1));
		}
		//document.getElementById(j).style.display='none'; 
		
	}
	function add_degree(no) //for add a degree
	{
		// alert(document.getElementById('extra').value);
		var i=parseInt(document.getElementById('extra').value);
		i=i+1;
		
		var next = i+1;
		if(document.getElementById(i).style.display=='none')
		{
			document.getElementById(i).style.display='block';
		}
		else
		{
			var course= subject_name(i); 
			var description = desriptionss(i);
			var teacher = techerss(i)
		var value='<div id="'+i+'"><table class="table_class" width="90%"  cellspacing="0" cellpadding="2"> <tr style="text-align:center;"><td align="center" width=120px;><input type="text" name="name'+i+'" id="name'+i+'"  class="input_text"></td><td align="center">'+teacher+'</td><td align="center">'+description+'</td></tr></table></div> <div id="'+next+'"></div>';
			document.getElementById(i).innerHTML= value;
			document.getElementById('extra').value=i;
		}
	}  
	function select_topics(ids)
	{
		//contact= document.getElementById(is).value;
 	    var data1="action=select_topic&domain_ids="+ids;	
	   	//alert(data1);
        $.ajax({
		url: "show_topics.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			document.getElementById('que_div').innerHTML=html;
			//alert(html);
		}
		});
	}
	function removeSelected(a)
	{
		//alert(a);
		hide1=a;
		idsn="selected"+hide1;
		$('#'+idsn).remove();
	}
	/*function hideSelected(a)
	{
		total_cnt=document.getElementById("total_count").innerHTML;
		count=parseInt(total_cnt-1);
		document.getElementById("total_count").innerHTML=count;
		document.getElementById("total_ques_cnt").value=count;
		hide1=a;
		
		idsn="selected"+hide1;
		$('#'+idsn).remove();
		if(document.getElementById(hide1))
		{
			document.getElementById(hide1).style.display="block";
		}
		seprates=hide1.split("qs");
		$(":checkbox[id='chapter_id"+seprates[1]+"']").attr("checked", false);  
	}*/
	function hideSelected(a)
	{
		total_cnt=document.getElementById("total_count").innerHTML;
		count=parseInt(total_cnt-1);
		document.getElementById("total_count").innerHTML=count;
		document.getElementById("total_ques_cnt").value=count;
		hide1=a;
		
		idsn="selected"+hide1;
		$('#'+idsn).remove();
		if(document.getElementById(hide1))
		{
			document.getElementById(hide1).style.display="block";
		}
		seprates=hide1.split("qs");
		$(":checkbox[id='chapter_id"+seprates[1]+"']").attr("checked", false);  
	}
	no=0;
	function select_me(ids)
	{
		total_count='';
		divId="selected"+ids;
		//no= parseInt(no + 1);
		seps=ids.split("qs");
		var_sep =document.getElementById(ids).innerHTML;
		sep = var_sep.split('<?php echo '<span id="course"></span>'; ?>');
		new_id="<input type='hidden' name='topics[]' id='topics' value='"+seps[1]+"'>";
		var selected_subject_name= document.getElementById("selected_subjects"+seps[1]).value;
		img = '<img src="images/delete.gif" height="20" width="20" onclick="hideSelected('+ids+')" id="'+ids+'">';
		
		//if($('input[value='+seps[1]+']').attr('checked', false))		
		{
			if(document.getElementById(ids))
				document.getElementById(ids).style.display="none";
		}
		//alert(sep[1]);
		var topic_name=sep[1].split(".")[1];
		document.getElementById('selected_topic').innerHTML=document.getElementById('selected_topic').innerHTML+'<div id="'+divId+'" style="clear: both;"><table width="100%"><tr><td width="8%" align="center">'+seps[1]+'.</td><td align="center" width="10%">'+selected_subject_name+'</td><td width="65%" align="center">'+topic_name+'</td><td width="9%" align="center">'+img+sep[2]+'</td></tr></table>'+new_id+'</div>';
		
		//alert(Number(document.jqueryForm.new_selected.length))
		
		total_count = document.getElementsByName("topics[]").length;
		if(total_count)
		{
			document.getElementById("total_count").innerHTML=total_count;
			document.getElementById("total_ques_cnt").value=total_count;
		}
	}
	 </script>    
</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/course_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">            
        <?php
                    $errors=array(); $i=0;
                    $success=0;
                    if($_POST['save_changes'])
                    {
                        //$name=$_POST['name'];
						$name = ( true == isset( $_POST['name'] )) ? $_POST['name'] : "";
						$description= ( true ==  isset( $_POST['description'])) ? $_POST['description'] : "";
						//$sub_fees= ( true ==  isset( $_POST['sub_fees'])) ? $_POST['sub_fees'] : "0";
						$domain_id= ( true ==  isset( $_POST['domain_id'])) ? $_POST['domain_id'] : "0";
                       	$topics = $_POST['topics'];
                        if($name =="")
                        {
							$success=0;
							$errors[$i++]="Enter Subject name";
                        }
						if($domain_id =="")
                        {
							$success=0;
							$errors[$i++]="Select Course Domain name";
                        }
						/*if($record_id=='')
						{
							$select_subject="select name from subject where name='".$name."' ";
							$query_subject=mysql_query($select_subject);
							if(mysql_num_rows($query_subject))
							{
								$success=0;
								$errors[$i++]="Subject Name Already Exist. ";
							}
						}*/
                        if(count($errors))
                        {
                            ?>
                        	<tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                        echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                       		</td></tr>   <br></br>  
                    		<?php
                        }
                        else
                        {
                        	$success=1;
                            $data_record['name'] =$name;
                            $data_record['description'] =$description;
							$data_record['course_domain_id'] =$domain_id;
                           	//$data_record['sub_fees'] = $sub_fees;
							//===============================CM ID for Super Admin===============
							/*if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								
								$data_record['cm_id'] =$cm_id;
								
							}	
							else
							{
								$branch_name1=$_SESSION['branch_name'];
								$cm_id=$_SESSION['cm_id'];
								$data_record['cm_id'] =$cm_id;
							}*/
							//====================================================================
                            if($record_id)
                            {
                                $where_record=" subject_id='".$record_id."'";                                
                                $db->query_update("subject", $data_record,$where_record);     
								
								$del_old_rec="delete from topic_map where subject_id='".$record_id."' ";
								$ptr_deleted=mysql_query($del_old_rec);
					            
								for($i=0;$i<count($topics);$i++)
								{
									"<br/>".$insert_into_topic_map= "insert into topic_map (topic_id,course_domain_id, subject_id, admin_id, added_date) values('".$topics[$i]."','".$domain_id."','".$record_id."','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
									$insertt_top_map = mysql_query($insert_into_topic_map);
								}
								 
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
							    $data_record['added_date'] = date('Y-m-d H:i:s');					
								$subject_id=$db->query_insert("subject", $data_record);
								//echo "<br/>".count($topics);
								for($i=0;$i<count($topics);$i++)
								{
									$insert_into_topic_map= "insert into topic_map (topic_id, course_domain_id, subject_id, admin_id, added_date) values('".$topics[$i]."','".$domain_id."','".$subject_id."','".$_SESSION['admin_id']."','".date('Y-m-d H:i:s')."')";
									$insertt_top_map = mysql_query($insert_into_topic_map);
								}
                                echo '<br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                            }
						    
							/*$no_of_extra=$_POST['no_of_extra'];
                            for($i=1;$i<=$no_of_extra;$i++)
							{
								$data_record['admin_id'] = $_SESSION['admin_id'];
								$data_record_extra['name'] = $_POST['name'.$i];  
								$data_record_extra['description'] =$_POST['description'.$i]; 
								$data_record_extra['staff_id'] =$_POST['staff_id'.$i];  
								$data_record_extra['course_id'] =$_POST['course_id'.$i];  
								$data_record_extra['sub_fees'] =$_POST['sub_fees'.$i];  
								
								$data_record_extra['added_date'] = date('Y-m-d H:i:s');
								if($data_record_extra['name'] !='')
								{
									$chk_exist = " select subject_id from subject where name='".$data_record_extra['name']."'"; 
									$ptr_exist = mysql_query($chk_exist);
									if(!mysql_num_rows($ptr_exist))
									{
									  $courses_id=$db->query_insert("subject", $data_record_extra);  
									}
								}
							}*/
						}
					}
					if($success==0)
					{
						?>
						<tr><td>
						<form method="post" id="jqueryForm" enctype="multipart/form-data">
						<table border="0" cellspacing="10" cellpadding="0" width="100%">
						<tr><td  class="orange_font">* Mandatory Fields</td> </tr>
				
					<?php
                    /*if($_SESSION['type']=='S')
                    {
                    	?>
                        <td width="18%" align="center">
                        <div width="12%" style="height:30px">Branch Name <span class="orange_font">*</span></div>
                        <?php
						$sel_cm_id="select branch_name from site_setting where cm_id=".$row['cm_id']." ";
						$ptr_query=mysql_query($sel_cm_id);
						$data_branch_nmae=mysql_fetch_array($ptr_query);
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%" align="center"><tr><td align="center">';
						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>"  <?php if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
							</option>
							<?php
						}
						echo '</select>';
						echo "</td></tr></table>";
						?>
						</td>
                	
       					<?php 
					}
					else 
					{ 
						?>
       					<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
      					<?php 
					}*/
					?>
                    <tr>
                		<td width="20%" align="center">Select Domain <span class="orange_font">*</span></td>
                        <td width="80%">
                        <select name="domain_id" id="domain_id" class="validate[required] input_select" style="width:400px" onchange="select_topics(this.value)">  
                        <option value="">Select Domain Name </option>
                        <?php
                        $select_category = "select * from course_domain_category order by cat_id asc";
                        $ptr_category = mysql_query($select_category);
                        while($data_category = mysql_fetch_array($ptr_category))
                        {
                            $sel='';
                            if($data_category['cat_id'] == $row_record['course_domain_id'])
                            {
                                $sel='selected="selected"';
                            }
                            echo '<option value='.$data_category['cat_id'].' '.$sel.'>'.$data_category['cat_name'].'</option>';
                        }
                        ?>        
                        </select>
                		</td> 
                    </tr>
                    
                    <tr>
                		<td width="20%" align="center">Enter Subject Name <span class="orange_font">*</span></td>
                        <td width="80%"><input type="text" class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['name'];?>" style="width:400px"/>
                		</td> 
                    </tr>
                    <tr>
                    	<td align="center">Description</td>
                        <td>      
                        <textarea name="description" id="description" style="width:400px; height:100px" class="input_text"><?php if($_POST['save_changes']) echo stripslashes($_POST['description']); else echo stripslashes($row_record['description']);?></textarea>
                        </td> 
                          
            		</tr>
                    <tr>
                    	<td height="0" valign="top">Selected Topic<span class="orange_font"></span></td>
                  		<td colspan="4">
                        Total selected topic: <span id="total_count"><?php if($record_id){ echo $total_topic;} ?></span><br /><br />
                        <input type="hidden" name="total_ques_cnt" id="total_ques_cnt"  value="<?php if($record_id){ echo $total_topic;} ?>" />
                        <table width=100% style="border:1px solid; margin:0; padding:0" class="table">
                        	<tr>
                            	<td width="10%" align="center">Topic. No.</td>
                                <td width="20%" align="center">Domain Name</td>
                                <td width="60%" align="center">Topic Title</td>
                                <td width="10%" align="center">Remove</td>
                            </tr>     
                            <tr><td colspan="4">   
                            <div name="selected_topic"  id="selected_topic" style="width:100%;" cols="">
							<?php 
							if($record_id)
                            {
                                $sel_topic= "select * from topic_map where subject_id=".$record_id." order by topic_id asc";	
                                $query_topic = mysql_query($sel_topic);	
                                while($row_member_topic = mysql_fetch_array($query_topic))
                                {
                                    $sel_top = "select * from topic where topic_id='".$row_member_topic['topic_id']."' order by topic_id asc";	 
                                    $query_top = mysql_query($sel_top);
                                    $total_subject = mysql_num_rows($query_top);
                                    $conc_unit ='';
                                    $c=1;
                                    $row_memberx = mysql_fetch_array($query_top);
                                    //{
                                        $c++;
                                        
                                        $member_result='';
                                        $i=1;
                                        $n=1;
                                        $call_function ='';
                                       	$sele_init_name="select name,subject_id from subject where 1 and subject_id ='".$row_member_topic['subject_id']."' order by subject_id asc";
                                        $ptr_unit=mysql_query($sele_init_name);
                                        $row_member = mysql_fetch_array($ptr_unit);
										
										$sel_domain="select * from course_domain_category where 1 and cat_id='".$row_record['course_domain_id']."' order by cat_id asc"; 
										$ptr_domain=mysql_query($sel_domain);
										$data_domain=mysql_fetch_array($ptr_domain);
                                        //{ 
                                            /*if(in_array($row_member['subject_id'],$subject_array))
                                            {*/
                                                $checked='';
                                                ?>
                                                <div id="selectedqs<?php echo $row_member_topic['topic_id']; ?>" style="clear: both;">
                                                    <table width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td width="9%" align="center"><?php echo $row_member_topic['topic_id']; ?>.</td>
                                                                <td width="10%" align="center"><?php echo $data_domain['cat_name']; ?>.</td>
                                                                <td width="65%" align="center"><?php echo $row_memberx['topic_name']; ?></td>
                                                                <td width="9%" align="center">
                                                                <img id="qsimg<?php echo $row_member_topic['topic_id']; ?>" src="images/delete.gif" onclick="hideSelected('qs<?php echo $row_member_topic['topic_id']; ?>')" width="20" height="20">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <input id="topics" name="topics[]" value="<?php echo $row_member_topic['topic_id']; ?>" type="hidden">
                                                </div>
                                                <?php
                                            //}
                                            //$i++;
                                        //}
                                        //$n++;
                                    //}
                                }
                            } ?> 
                            </div>
                        </td>
                    </tr>
                </table>
            </td> 
        </tr>
        <tr>
        	<td colspan="3"><div id="que_div">
            <?php
			if($record_id!='')
			{
				echo "<table width='100%' id='wrapper'>";	
				$sel_unit="select * from course_domain_category where 1 and cat_id='".$row_record['course_domain_id']."' order by cat_id asc"; 
				$ptr_unit=mysql_query($sel_unit);
				if(mysql_num_rows($ptr_unit))
				{
						$data_unit=mysql_fetch_array($ptr_unit);
					//{
						//$sep_unit ='';
						//$sep_unit =" and subject_id='".$data_unit['subject_id']."' ";
						
						$sel_contact ="SELECT topic_id, topic_name FROM topic where 1 and course_domain_id='".$row_record['course_domain_id']."' order by topic_name asc ";	 
						$query_contact = mysql_query($sel_contact);
						$i=1;
						$total_contact = mysql_num_rows($query_contact);
						if($total_contact && $record_id =='')
						{
							echo "<table width='100%' id='wrapper'>";
							echo "<table><tr><td width='9%' valign='top'>Select Topic from ".$data_unit['cat_name']."<span class='orange_font'>*</span></td>";
							echo "<td width='41%' >";
							$member_result='';
							echo '<table width="100%">';
							/*echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';*/
							echo  '<tr>';
							$i=1;
							//$sel_unit="SELECT topic_id,topic_name FROM topic where 1 $concat order by subject_id asc ";
							//$ptr_unit=mysql_query($sel_unit);
							if($total_contact = mysql_num_rows($query_contact))
							{
								while($row_contact = mysql_fetch_array($query_contact))
								{
									echo  "<td id='qs".$row_contact['topic_id']."'><input type='checkbox' name='chapter_id[]' onclick='select_me(\"qs".$row_contact['topic_id']."\")'  value='".$row_contact['topic_id']."' id='chapter_id".$row_contact['topic_id']."' class='case ".$row_contact['topic_id']."' style='vertical-align:top' /><span id='course'></span>".$row_contact['topic_id'].". ".$row_contact['topic_name']." ";
									echo "<span id='course'></span><input type='hidden' name='selected_subject' id='selected_subjects".$row_contact['topic_id']."' value='".$data_unit['cat_name']."' >";
														
								   echo  '</td>';
								   if($i%4==0)
								   echo  '</tr><tr>';  
								   $i++;
								}
							}
							else
							{
								echo "* No Topic found or Already selected";
							}
							echo "</tr></table>";
							echo "</td></tr></table><hr />";
						}
						else if($total_contact && $record_id !='')
						{
							
							echo "<table><tr><td width='9%' valign='top'>Select Topic from ".$data_unit['cat_name']."<span class='orange_font'>*</span></td>";
							echo "<td width='41%' >";
							$member_result='';
							
							/*echo'<tr><td><input type="checkbox" name="chkAll" id="selectall" onclick="selectalls();"/>Check All</td></tr>';*/
							$i=1;
							echo '<table width="100%">';
							echo  '<tr>';
							while($row_contact = mysql_fetch_array($query_contact))
							{
								$checked='';
								$seleexam_se="select * from topic_map where topic_id='".$row_contact['topic_id']."' and subject_id='".$record_id."' ";
								$ptr_ex=mysql_query($seleexam_se);
								$tot_ques=mysql_num_rows($ptr_ex);
								$dis='';
								if($tot_ques !=0 || $tot_ques !='')
								{
									$checked="checked='checked'";
									$dis="style='display:none'";
								}
								echo  "<td id='qs".$row_contact['topic_id']."' ".$dis."><input type='checkbox' name='topic_id[]' onclick='select_me(\"qs".$row_contact['topic_id']."\")' ".$checked."  value='".$row_contact['topic_id']."' id='chapter_id".$row_contact['topic_id']."' class='case ".$row_contact['topic_id']."' style='vertical-align:top;'/><span id='course'></span>".$row_contact['topic_id'].". ".$row_contact['topic_name']." ";
								echo "<span id='course'></span><input type='hidden' name='selected_subject' id='selected_subjects".$row_contact['topic_id']."' value='".$data_unit['cat_name']."' >";
								echo  '</td>';
								if($i%2==0)
									echo  '</tr><tr>';  
								$i++;
							}
							echo "</tr></table>";
							echo "</td></tr></table><hr />";
						}
					//}
				}
				echo "</table>";
			}?>
            </div></td>
        </tr>
    </table>
    <input type="hidden" name="no_of_extra" id="extra"  value="0" />
    <div id='1'></div>
        <table width="100%">
            <tr>
                <td width="118">&nbsp;</td><td width="60">&nbsp; </td> <td width="59">&nbsp; </td>
                <td width="378"><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Subject" name="save_changes"  /></td>
    			<td width="18">&nbsp; </td><td width="44">&nbsp; </td>
			</tr>
        </table>
   </form>
        </td></tr>
<?php
 } ?>
        </table></td>
    <td class="mid_right"></td>
  </tr>
  <tr>
    <td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>
</div>
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>
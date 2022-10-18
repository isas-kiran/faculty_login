<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT subject_id,name,course_id,description,staff_id FROM subject where subject_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
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
						$sub_fees= ( true ==  isset( $_POST['sub_fees'])) ? $_POST['sub_fees'] : "0";
                       	// $description = $_POST['description'];
                        //$course_id = $_POST['course_id'];
                        //$sub_fees = $_POST['sub_fees'];
						//$staff_id = $_POST['staff_id'];
                        $branch_name=$_POST['branch_name'];
                        if($name =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Subject  name";
                        }
						
						if($record_id=='')
						{
							$select_subject="select name from subject where name='".$name."' ";
							$query_subject=mysql_query($select_subject);
							if(mysql_num_rows($query_subject))
							{
								$success=0;
								$errors[$i++]="subject Name Already Exist. ";
							}
						}
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
                           
						   	$data_record['admin_id'] = $_SESSION['admin_id'];
                            $data_record['name'] =$name;
                            $data_record['description'] =$description;
                           // $data_record['staff_id'] =$staff_id;
                            //$data_record['course_id'] =$course_id;
                            $data_record['sub_fees'] = $sub_fees;
							//===============================CM ID for Super Admin===============
							if($_SESSION['type']=='S')
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
							}
							//====================================================================
                            if($record_id)
                            {
                                $where_record="subject_id='".$record_id."'";                                
                                $db->query_update("subject", $data_record,$where_record);                              
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                            else
                            {
							    $data_record['added_date'] = date('Y-m-d H:i:s');
								
								$chk_exist1 = " select subject_id from subject where name='".$data_record['name']."'"; 
								$ptr_exist1 = mysql_query($chk_exist1);
								if(!mysql_num_rows($ptr_exist1))
								{
                                  $courses_id=$db->query_insert("subject", $data_record);                                
                                  echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
								}
                            }
						    
							$no_of_extra=$_POST['no_of_extra'];
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
							
							}
                          }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="10" cellpadding="0" width="100%">
            <tr><td  class="orange_font">* Mandatory Fields</td> </tr>
            
            <!--<tr>
                <td width="20%">Select Course<span class="orange_font">*</span></td>
                  <td width="20%">Subject Name<span class="orange_font">*</span></td>
                  <td width="20%">Subject Teacher</td>
                  <td width="20%" valign="top">Subject Description</td>
                 <td width="20%"><div id="coursess" class="coursess" >Subject Fees</div></td>
                </tr>-->
                <tr>
                <!--<td width="12%" >
                <div width="12%" style="height:30px">Select Course<span class="orange_font">*</span></div>
                    <select name="course_id" id="course_id" class="validate[required] input_select" >  
                        <option value=""> Select Course</option>
                        <?php
                            /*$select_category = "select * from courses ".$_SESSION['where_admin_id_2']." order by course_id asc";
                            $ptr_category = mysql_query($select_category);
                            while($data_category = mysql_fetch_array($ptr_category))
                            {
                                if($data_category['course_id'] == $row_record['course_id'])
                                    echo '<option value='.$data_category['course_id'].' selected="selected">'.$data_category['course_name'].'</option>';
                                else
                                    echo '<option value='.$data_category['course_id'].'>'.$data_category['course_name'].'</option>';
                            }*/
                            ?>        
                    </select>
                    </td> -->
                <?php
            	if($_SESSION['type']=='S')
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
                	
       			<?php }
	   			else { ?>
       					<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
      			<?php }?>   
                <td width="18%" align="center">
                <div width="12%" style="height:30px">Subject Name <span class="orange_font">*</span></div>
                    <input type="text" class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['name'];?>" />
                </td> 
              
            
            <!--<td width="16%" >
                <div width="12%" style="height:30px">Select Teacher <span class="orange_font"></span></div>
                <select  name="staff_id" id="staff_id" class="input_select" style="width:150px;">
                <option value="" >Select Teacher </option>                        
                        <?php 
                           /*  $select_faculty = "select * from site_setting where 1 and type='f' ".$_SESSION['where']." order by admin_id asc";
                            $ptr_faculty = mysql_query($select_faculty);
                            while($data_faculty = mysql_fetch_array($ptr_faculty))
                            { 
							  $selected='';
							  if($data_faculty['admin_id']==$row_record['staff_id'])
							  $selected='selected="selected"';
							  
                              echo '<option '.$selected.' value="'.$data_faculty['admin_id'].'" >'.$data_faculty['name'].'</option>';  
                            }*/
                            ?>        
                    </select>
                    </td><td></td> <td></td> -->
                <td align="center">
                <div width="10%" style="height:30px">Description</div>
                
                <textarea name="description" id="description"><?php if($_POST['save_changes']) echo stripslashes($_POST['description']); else echo stripslashes($row_record['description']);?></textarea>
                   
				
                </td> 
                
                <td > 
                 <input type="button" name="Add"   class="addBtn" onClick="javascript:add_degree(1);" alt="Add(+)" >
                 <input type="button" name="Add"  class="delBtn"  onClick="javascript:del_degree(1);" alt="Delete(-)" >
                 </td> 
                 
                 
                <!--<td width="13%">
                <div width="12%" style="height:30px">Fees <span class="orange_font">*</span></div>
                <input type="text" class=" input_text" name="sub_fees" id="sub_fees" value="<?php //if($_POST['save_changes']) echo $_POST['sub_fees']; else echo $row_record['sub_fees'];?>" />
                </td> -->
                               
            </tr>
            </table>
            
           <input type="hidden" name="no_of_extra" id="extra"  value="0" />
           <div id='1'></div>
            <table width="871">
            <tr>
            <td width="118">&nbsp; </td><td width="60">&nbsp; </td> <td width="59">&nbsp; </td>
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
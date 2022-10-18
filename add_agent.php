<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM site_setting where admin_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	$select_sallery_details="select * from sallery where admin_id='".$record_id."'";
	$sallery_details=mysql_query($select_sallery_details);
	$fetch_sallery=mysql_fetch_array($sallery_details);
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update site_setting set photo='' where admin_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("staff_photo/".$row_record['photo']))
        unlink("staff_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='94'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?> Agent</title>
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
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
			$("#staff_pre_id").multiselect().multiselectfilter();
			$("#edit_pre_id").multiselect().multiselectfilter();
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
    <script>
$(document).ready(function(){
    $("#flip").click(function(){

			$("#panel").show('slow');

			$("#flip").hide();
    });
});
/*
$(document).ready(function() {
    $("#user_type").change(function() {
        var selVal = $(this).val();
		//alert(selVal);
		$("#branch_name").html('');
        if(selVal == 'A' || selVal == 'F' || selVal == 'C' || selVal == 'B'  ) 
		{
			var data1="user_type="+selVal;	
			 $.ajax({
            url: "get_branch.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				  document.getElementById('branch_name').innerHTML=html;
				 //$("#branch_name").css("display:block !important")
				 //alert(html);
	             //show_bank(html);
            }
            });
		}
		else
		{}

    });
});
*/	
function validme()
{
	frm = document.jqueryForm;
	error='';
	disp_error = 'Clear The Following Errors : \n\n';
	if(frm.name.value=='')
	{
		 disp_error +='Enter Name\n';
		 document.getElementById('name').style.border = '1px solid #f00';
		 frm.name.focus();
		 error='yes';
	}
	if(frm.user_type.value=='U')
	{
		 disp_error +='Select User Type\n';
		 document.getElementById('user_type').style.border = '1px solid #f00';
		 frm.user_type.focus();
		 error='yes';
	}
	if(frm.contact_phone.value=='')
	{
		 disp_error +='Enter Mobile Number \n';
		 document.getElementById('contact_phone').style.border = '1px solid #f00';
		 frm.contact_phone.focus();
		 error='yes';
	}
	else
	{	 
		var text = frm.contact_phone.value;
		if(text.length <10)
		{
				 disp_error +='Enter Valid Mobile Number \n';
				 document.getElementById('contact_phone').style.border = '1px solid #f00';
				 error='yes';
			}
	}
   	if(frm.company_contact_no.value !='')
	{
		var text = frm.company_contact_no.value;
		if(text.length <10)
		{
			 disp_error +='Enter Valid Company Mobile Number \n';
			 document.getElementById('company_contact_no').style.border = '1px solid #f00';
			 error='yes';
		}
	}
	if(frm.email.value=='')
	{
		 disp_error +='Enter Email ID\n';
		 document.getElementById('email').style.border = '1px solid #f00';
		 frm.email.focus();
		 error='yes';
	}
	else
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(document.getElementById('email').value !='')
		{
			if (reg.test(document.getElementById('email').value) == false) 
			{
				disp_error +='Invalid Email Address\n';
				document.getElementById('email').style.border = '1px solid #f00';
				frm.email.focus();
				error='yes';
			}
		}
	}
	if(error=='yes')
	{
		alert(disp_error);
		return false;
	}
	else
	return true;
}
function isPastDate(value) {
	var now = new Date;
    var target = new Date(value);
	var new_date=value.split("/");
	
    if (new_date[2] < now.getFullYear()) {
		return true;
    } else if (new_date[1] < now.getMonth()) {
		return true;
    } else if (new_date[0] < now.getDate()) {
		return true;
   	}
	    return false;
}
function isFeatureDate(value) {
	var now = new Date;
	var target = new Date(value);
	var new_date=value.split("/");
	
	if (new_date[2] > now.getFullYear()) {
		return true;
	} else if (new_date[1] > now.getMonth()) {
		return true;
	} else if (new_date[0]  >= now.getDate()) {
		return true;
	}
	return false;
}

function isSpclChar(id)
{
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";
	vals = document.getElementById(id).value;
	for (var i = 0; i < vals.length; i++) {
    if (iChars.indexOf(vals.charAt(i)) != -1) {
          return 'yes';
        }
    }
}  
</script>
<style> 
#panel, #flip{
	}
#panel {
	display:none;
}
</style>
 <style>	
	.addBtn{background:no-repeat url(images/add.png); width:17px; border:0px; cursor:pointer;}
	.delBtn{background:no-repeat url(images/delete.png);width:17px; border:0px; cursor:pointer;}
	.editBtn{background:no-repeat url(images/edit_icon.gif); width:17px; border:0px; cursor:pointer;}
	.clrButton{background:no-repeat url(images/edit_clear.png);width:17px; border:0px; cursor:pointer;}
	.inactive{ background-color:#FFF;cursor:pointer; color:#000}
	.active{ background-color:#699;cursor:pointer; color:#FFF}
	.hidden{ display:none; width:0px; height:0px;}	
	.tbl{border-radius:3px; border:#333 solid 1px; background-color:#CCC; }
	.pointer{ cursor:pointer;}
	</style>
     <script language="javascript" src="js/script.js"></script>
     <script language="javascript" src="js/conditions-script.js"></script>
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
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
				$user_type=( ($_POST['user_type'])) ? $_POST['user_type'] : "";
				$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
				$name=( ($_POST['name'])) ? $_POST['name'] : "";
				$contact_phone=( ($_POST['contact_phone'])) ? $_POST['contact_phone'] : "";
				$email=( ($_POST['email'])) ? $_POST['email'] : "";
				$username=( ($_POST['username'])) ? $_POST['username'] : "";
				$pass=( ($_POST['pass'])) ? $_POST['pass'] : "";
				
				$company_name=( ($_POST['company_name'])) ? $_POST['company_name'] : "";
				$company_contact_no=( ($_POST['company_contact_no'])) ? $_POST['company_contact_no'] : "";
				$company_email=( ($_POST['company_email'])) ? $_POST['company_email'] : "";
				$company_address=( ($_POST['company_address'])) ? $_POST['company_address'] : "";
				
				$added_date=date('Y-m-d H:i:s');    
				if($record_id)
				{
					$admin_id="and admin_id !=".$record_id."";
				}
				else
				{
					 $admin_id="";
				}
				$chk_exist ="select username,attendence_id,email,contact_phone from site_setting where 1 and (username='".$username."' or email='".$email."' or contact_phone='".$contact_phone."') ".$admin_id." and branch_name='".$branch_name."' and system_status='Enabled' ";
				$ptr_chk_exit=mysql_query($chk_exist);
				$data_exist=mysql_fetch_array($ptr_chk_exit);
	
				$user_exist=trim($data_exist['username']);
				$email_exist=trim($data_exist['email']);
				$contact_exist=trim($data_exist['contact_phone']);
				
				if($user_exist==trim($username))
				{
					 $success=0;
					 $errors[$i++]="Username Already Exist.";
				} 
				if($email_exist==trim($email))
				{
					 $success=0;
					 $errors[$i++]="Email Already Exist.";
				} 
				if($contact_exist==trim($contact_phone))
				{
					 $success=0;
					 $errors[$i++]="Mobile no. Already Exist.";
				} 
				
				if($_POST['user_type']=='A')
				{
					$select_branch='select branch_name from site_setting where branch_name="'.$branch_name.'" and 	type="A"';
					$ptr_branch_name=mysql_query($select_branch);
					if(mysql_num_rows($ptr_branch_name))
					{
						$success=0;
						$errors[$i++]="Center manager already assigned to '<b>$branch_name</b>' branch.  ";
					}
				}
				if($name =="")
				{
					$success=0;
					$errors[$i++]="Enter name";
				}
				if($username =="")
				{
					$success=0;
					$errors[$i++]="Enter User Name";
				}
				if($pass =="")
				{
					$success=0;
					$errors[$i++]="Enter PassWord";
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
					if($user_type=='AG')
					{
						$data_record['designation']='Sales Agent';
					}
					$data_record['type']=$user_type;
					$data_record['name']=$name;
					$data_record['contact_phone'] =$contact_phone;
					$data_record['email'] =$email;
					$data_record['username'] =$username;
					$data_record['pass'] =$pass;
					$data_record['added_by'] = $_SESSION['admin_id'];
					
					$data_record['agent_company_name'] =$company_name;
					$data_record['company_contact_no'] = $company_contact_no;
					$data_record['company_email']=$company_email;
					$data_record['company_address']=$company_address;
					
					$data_record['added_date'] = $added_date;
					$data_record['branch_name'] = $_SESSION['branch_name'];
					
					//=====================================================
					if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
					{
						$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
						$ptr_branch=mysql_query($sel_branch);
						if(mysql_num_rows($ptr_branch))
						{
							$data_branch=mysql_fetch_array($ptr_branch);
							$data_record['cm_id']=$data_branch['cm_id'];
							$data_record['branch_name']=$branch_name;
							//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
						}
						else{
							$data_record['cm_id']='0';
							$data_record['branch_name']=$branch_name;
						}
					}	
					else
					{
						$data_record['cm_id']=$_SESSION['cm_id'];
						$data_record['branch_name']=$_SESSION['branch_name'];
					}
					if($file_uploaded)
					$data_record['photo'] = $uploaded_url;

					if($record_id)
					{
						$where_record="admin_id='".$record_id."'";                                
						$db->query_update("site_setting", $data_record,$where_record); 
						if($_POST['user_type']=='A')
						{  
							$update_cm_id="update site_setting set cm_id=admin_id where admin_id='".$record_id."'";
							mysql_query($update_cm_id);
						}
						$select_sallery="select admin_id from sallery where admin_id='".$record_id."' ";
						$query_sal=mysql_query($select_sallery);
						$num_rows=mysql_num_rows($query_sal);
						if($num_rows!='')
						{
							$update_sallery="update sallery set admin_id='".$admin_id."', basic_sallery='".$basic_sallery."', traveling_allowance='".$traveling_allowance."', dearness_allowance='".$dearness_allowance."', house_rent_allowance='".$house_rent_allowance."', total_sal='".$total_sal."' where admin_id='".$record_id."'";

							$query_update=mysql_query($update_sallery);
						}
						else
						{
							$insert_for_sallary = "insert into sallery (`admin_id`, `basic_sallery`, `traveling_allowance`, `dearness_allowance`, `house_rent_allowance`, `total_sal`, `added_date`) values('".$admin_id."', '".$basic_sallery."', '".$traveling_allowance."', '".$dearness_allowance."', '".$house_rent_allowance."', '".$total_sal."', '".date('Y-m-d H:i:s')."')";
							$ptr_insert_sallary = mysql_query($insert_for_sallary);
						}
						
															
						"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_agent','Edit','".$name."','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);           

						echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
					}
					else
					{
						$data_record['added_date'] = date('Y-m-d H:i:s');
						$data_record['status']="Inactive";
						$data_record['system_status']="Agent_Enabled";
						$courses_id=$db->query_insert("site_setting", $data_record);  
						$admin_id= mysql_insert_id();
						if($_POST['user_type']=='A')
						{  
							$update_cm_id ="update site_setting set cm_id = admin_id where admin_id='".$admin_id."'";
							mysql_query($update_cm_id);
						}
						//=========================ADMIN PREVELEGES===================================
						/*$privilege_ids = $_POST['privilege_id'];
						//echo count($privilege_ids);
						for($i=0;$i<count($privilege_ids);$i++)
						{
							"<br/>".$select_parent="select privilege_parent_id from previleges where privilege_id='".$privilege_ids[$i]."'";
							$ptr_parent=mysql_query($select_parent);
							$data_parent=mysql_fetch_array($ptr_parent);
							
							"<br/>".$insert_for_prevelgegeis = "insert into admin_previleges (`previlege_parent_id`,`privilege_id`,`admin_id`) values('".$data_parent['privilege_parent_id']."','".$privilege_ids[$i]."','".$admin_id."')";
							$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
						} 
						//=========================STAFF PREVELEGES===================================
						$staff_privilege_id = $_POST['staff_privilege_id'];
						//echo count($privilege_ids);
						for($i=0;$i<count($staff_privilege_id);$i++)
						{
							$select_parent="select privilege_parent_id from previleges where privilege_id='".$staff_privilege_id[$i]."'";
							$ptr_parent=mysql_query($select_parent);
							$data_parent=mysql_fetch_array($ptr_parent);
							$insert_for_prevelgegeis = "insert into staff_previleges (`previlege_parent_id`,`privilege_id`,`admin_id`,`cm_id`) values('".$data_parent['privilege_parent_id']."','".$staff_privilege_id[$i]."','".$admin_id."','".$data_record['cm_id']."')";
							$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
						}   
						//=========================Edit/ Delete PREVELEGES===================================
						$edit_privilege_id = $_POST['edit_privilege_id'];
						//echo count($privilege_ids);
						for($i=0;$i<count($edit_privilege_id);$i++)
						{
							$select_parent="select privilege_parent_id from previleges where privilege_id='".$staff_privilege_id[$i]."'";
							$ptr_parent=mysql_query($select_parent);
							$data_parent=mysql_fetch_array($ptr_parent);
							$insert_for_prevelgegeis = "insert into edit_previleges (`previlege_parent_id`,`privilege_id`,`admin_id`,`cm_id`) values('".$data_parent['privilege_parent_id']."','".$staff_privilege_id[$i]."','".$admin_id."','".$data_record['cm_id']."')";
							$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
						}*/   
						//===============================================================================
						 //$insert_for_sallary = "insert into sallery (`admin_id`, `basic_sallery`, `traveling_allowance`, `dearness_allowance`, `house_rent_allowance`, `total_sal`, `added_date`) values('".$admin_id."', '".$basic_sallery."', '".$traveling_allowance."', '".$dearness_allowance."', '".$house_rent_allowance."', '".$total_sal."', '".date('Y-m-d H:i:s')."')";
						//$ptr_insert_sallary = mysql_query($insert_for_sallary);

						//====================FOR Type1 INSERT======================================================
						/*for($j=1;$j<=$total_floor;$j++)
						{
								if($_POST['from'.$j] !='')
								{
									$data_record_type1['admin_id'] = $admin_id;
									$data_record_type1['from'] =addslashes(trim($_POST['from'.$j]));      
									$data_record_type1['to'] =addslashes(trim($_POST['to'.$j]));
									$data_record_type1['percentage'] =addslashes(trim($_POST['percentage'.$j]));
									$data_record_type1['added_date'] =date("Y-m-d H:i:s");
									$record_comission=$db->query_insert("comission_slab", $data_record_type1);
									$slab_id=mysql_insert_id();  
								 }
						 }*/
						 
						 "<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_user','Add','".$name."','".$admin_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);
						
						echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
					}
				}
			}
			if($success==0)
			{
				?>
            	<tr><td>
        		<form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
					<table border="0" cellspacing="15" cellpadding="0" width="100%">
            			<tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            			<tr>	
            				<td>Select User Type <span class="orange_font">*</span></td>
            	 			<td>
                 			<!--changes add on new user type Z & LD on 8 feb 21-->
                    			<select name="user_type" class="input_select_login" id="user_type"  style="width: 150px;">
								<option value="AG"<?php if($_POST['user_type']=='AG') echo 'selected'; elseif ('AG' == $row_record['type'] )  echo 'selected'; ?>>Sales Agent</option>
								</select>
                			</td>
                		</tr>
                	<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
					{
						?>
                		<tr>
                			<td>Select branch</td> 
                			<td colspan="2" align="left">
							<?php
                            $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                            $query_branch = mysql_query($sel_branch);
                            $total_Branch = mysql_num_rows($query_branch);
                            echo '<select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
                            while($row_branch = mysql_fetch_array($query_branch))
                            {
                                ?>
                                <option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];  ?>" > <?php echo $row_branch['branch_name']; ?> 
                                </option>
                                <?
                            }
                            echo '</select>';
                            ?>
                            <!--<div id="branch_name">
                            </div>-->
                            </td>
            			</tr>  
						<?php
                        if($record_id && ($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'))
                        {
                            ?>
                            <tr>
                                <td colspan="2">
                                <?php
                                $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                                $query_branch = mysql_query($sel_branch);
                                $total_Branch = mysql_num_rows($query_branch);
                                echo '<table width="100%"><tr><td width="35%">';
                                echo 'Select branch</td><td>';
                                echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
                                while($row_branch = mysql_fetch_array($query_branch))
                                {
                                    $selected=='';
                                    if(addslashes($row_record['branch_name']) == addslashes($row_branch['branch_name']) || $_POST['branch_name'] == $row_branch['branch_name'])
                                    {
                                        "<br />".$selected='selected="selected"';
                                    }
    
                                    ?>
                                    <option <?php if ($_POST['branch_name'] == $row_branch['branch_name']) echo $selected; elseif($row_record['branch_name'] == $row_branch['branch_name'])  echo $selected; ?> value="<?php echo $row_branch['branch_name'];  ?>" > <?php echo $row_branch['branch_name']; ?>
                                    <?php
                                }
                                echo '</select>';
                                echo "</td></tr></table>";
                                ?> 
                                </option></td>
                            </tr>  
                            <?php 
                        }
                    } ?> 
                    <tr>
                        <td width="20%" colspan="2" style="font-size:14px"><strong>Agent Details</strong><span class="orange_font"></span></td>
                    </tr>
                    <tr>
                        <td width="20%">Name<span class="orange_font">*</span></td>
                        <td width="40%"><input type="text" class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['name'];?>" /></td>
                        <td width="40%"></td>
                    </tr> 
                    <tr>
                        <td width="20%">Mobile No.<span class="orange_font">*</span></td>
                        <td width="40%">
                            <input type="text" class="validate[required] input_text" name="contact_phone" id="contact_phone" value="<?php if($_POST['save_changes']) echo $_POST['contact_phone']; else echo $row_record['contact_phone'];?>" />
                        </td> 
                        <td width="40%"></td>
                    </tr> 
                    
                    <tr>
                        <td width="20%">Email Id<span class="orange_font">*</span></td>
                        <td width="40%">
                        <input type="text" class="input_text" name="email" id="email" value="<?php if($_POST['save_changes']) echo $_POST['email']; else echo $row_record['email'];?>"/>
                        </td> 
                        <td width="40%"></td>
                    </tr> 
                    <tr>
                        <td width="20%"> User Name<span class="orange_font">*</span> </td>
                        <td width="40%">
                        <input type="text" class=" input_text" name="username" id="username" value="<?php if($_POST['save_changes']) echo $_POST['username']; else echo $row_record['username'];?>" />
                        </td> 
                        <td width="40%"></td>
                    </tr>
                    <tr>
                        <td width="20%">Password<span class="orange_font">*</span></td>
                        <td width="40%"><input type="password" class=" input_text" name="pass" id="pass" value="<?php if($_POST['save_changes']) echo $_POST['pass']; else echo $row_record['pass'];?>" />
                        </td> 
                        <td width="40%"></td>
                    </tr>
                    <tr>
                        <td width="20%" colspan="2" style="font-size:14px"><strong>Company Details</strong><span class="orange_font"></span></td>
                    </tr>
                    <tr>
                        <td width="20%">Company Name<span class="orange_font"></span></td>
                        <td width="40%"><input type="text" class="validate[required] input_text" name="company_name" id="company_name" value="<?php if($_POST['save_changes']) echo $_POST['company_name']; else echo $row_record['company_name'];?>" /></td>
                        <td width="40%"></td>
                    </tr>
                    <tr>
                        <td width="20%">Mobile No.</td>
                        <td width="40%">
                            <input type="text" class="input_text" name="company_contact_no" id="company_contact_no" value="<?php if($_POST['save_changes']) echo $_POST['company_contact_no']; else echo $row_record['company_contact_no'];?>" />
                        </td> 
                        <td width="40%"></td>
                    </tr>
                    <tr>
                        <td width="20%">Email Id<span class="orange_font"></span></td>
                        <td width="40%">
                        <input type="text" class="input_text" name="company_email" id="company_email" value="<?php if($_POST['save_changes']) echo $_POST['company_email']; else echo $row_record['company_email'];?>"/>
                        </td> 
                        <td width="40%"></td>
                    </tr>  
                    <tr>
                        <td width="20%">Address<span class="orange_font"></span></td>
                        <td width="40%">
                            <textarea type="text" style="height:60px" class="input_text" name="company_address" id="company_address" value="" ><?php if($_POST['save_changes']) echo $_POST['company_address']; else echo $row_record['company_address'];?></textarea>
                        </td> 
                        <td width="40%" ></td>
                    </tr>   
                    
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" class="input_btn" onClick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Staff" name="save_changes"  /></td>
                        <td></td>
                    </tr>
                </table>
        	</form>
        </td></tr>
		<?php
	}
	?>
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
<?php
if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' && $record_id=='')
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
	//exit();
}
?>
<script language="javascript">
create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>
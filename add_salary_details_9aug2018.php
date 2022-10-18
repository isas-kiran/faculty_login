<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM site_setting where attendence_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
    $row_record2=$db->fetch_array($db->query($sql_record));
    else
    $record_id=0;
	
	 $select_sallery_details="select * from pr_add_salary_details where staff_id='".$record_id."'";
	$sallery_details=mysql_query($select_sallery_details);
	$row_record=mysql_fetch_array($sallery_details);
	
	 $select_sallery_details1="select * from pr_add_incentive_details where staff_id='".$record_id."'";
	$sallery_details1=mysql_query($select_sallery_details1);
	$row_record1=mysql_fetch_array($sallery_details1);
}

/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Add Salary Details</title>
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

<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
   
    <script>

	 function validme()
	 {
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
	 if(frm.basic_salary.value!='')
		 {
			 disp_error +='Enter Basic Salary\n';
			 document.getElementById('basic_salary').style.border = '1px solid #f00';
			 frm.basic_salary.focus();
			 error='yes';
	     }
	 if(frm.house_rent_allowance.value=='')
		 {
			 disp_error +='Enter House Rent Allowance\n';
			 document.getElementById('house_rent_allowance').style.border = '1px solid #f00';
			 frm.house_rent_allowance.focus();
			 error='yes';
		 }
	   if(frm.traveling_allowance.value=='')
		 {
			 disp_error +='Enter Travelling Allowance \n';
			 document.getElementById('traveling_allowance').style.border = '1px solid #f00';
			 frm.traveling_allowance.focus();
			 error='yes';
	     }
		 if(frm.medical_allowance.value=='')
		 {
			 disp_error +='Enter Medical Allowance \n';
			 document.getElementById('medical_allowance').style.border = '1px solid #f00';
			 frm.medical_allowance.focus();
			 error='yes';
	     }
		 if(frm.proffessional_tax.value=='')
		 {
			 disp_error +='Enter Proffessional Tax \n';
			 document.getElementById('proffessional_tax').style.border = '1px solid #f00';
			 frm.proffessional_tax.focus();
			 error='yes';
	     }
		 if(frm.income_tax.value=='')
		 {
			 disp_error +='Enter Income Tax \n';
			 document.getElementById('income_tax').style.border = '1px solid #f00';
			 frm.income_tax.focus();
			 error='yes';
	     }
		  
		 if(frm.bank_account_number.value=='')
		 {
			 disp_error +='Enter Bank Account Number\n';
			 document.getElementById('bank_account_number').style.border = '1px solid #f00';
			 frm.bank_account_number.focus();
			 error='yes';
	     }
		 
		   if(frm.pan_number.value=='')
		 {
			 disp_error +='Enter Pan Number \n';
			 document.getElementById('pan_number').style.border = '1px solid #f00';
			 frm.pan_number.focus();
			 error='yes';
	     }
		 
		
		   if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 return true;
	
	 }
	 
</script>

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
    <td class="top_mid" valign="bottom"><?php include "include/payroll_menu.php"; ?></td>
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
						$salary=( ($_POST['salary'])) ? $_POST['salary'] : "";
						$basic_salary=( ($_POST['basic_salary'])) ? $_POST['basic_salary'] : "";
						$house_rent_allowance=( ($_POST['house_rent_allowance'])) ? $_POST['house_rent_allowance'] : "0";
						$medical_allowance=( ($_POST['medical_allowance'])) ? $_POST['medical_allowance'] : "0";
						$travelling_allowance=( ($_POST['travelling_allowance'])) ? $_POST['travelling_allowance'] : "0";
						$proffessional_tax=( ($_POST['proffessional_tax'])) ? $_POST['proffessional_tax'] : "0";
						$income_tax=( ($_POST['income_tax'])) ? $_POST['income_tax'] : "0";
						$bank_account_number=( ($_POST['bank_account_number'])) ? $_POST['bank_account_number'] : "0";
					    $pan_number=( ($_POST['pan_number'])) ? $_POST['pan_number'] : "0";
						$total_salary=( ($_POST['total_salary'])) ? $_POST['total_salary'] : "";
						$tds=( ($_POST['tds'])) ? $_POST['tds'] : "0";
						$bank_name=( ($_POST['bank_name'])) ? $_POST['bank_name'] : "0";
					    $added_date=date("y-m-d");
						
						
						
						$admin=( ($_POST['admin1'])) ? $_POST['admin1'] : "0";
						
						 if($salary =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Salary";
                        }
                        if($basic_salary =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Basic Salary";
                        }
						  
						
						if($total_salary =="")
                        {
                                $success=0;
                                $errors[$i++]="Enter Total Salary";
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
							$data_record['salary']=$salary;
							$data_record['basic_salary']=$basic_salary;
                            $data_record['house_rent_allowance']=$house_rent_allowance;
							$data_record['travelling_allowance']=$travelling_allowance;
							$data_record['medical_allowance'] = $medical_allowance;
                            $data_record['proffessional_tax'] =$proffessional_tax;
                            $data_record['income_tax'] =$income_tax;
                            $data_record['bank_account_number'] =$bank_account_number;
                            $data_record['pan_number'] =$pan_number;
							$data_record['total_salary'] =$total_salary;
							$data_record['tds'] =$tds;
                            $data_record['added_date'] = $added_date;
							$data_record['admin_id'] = $_SESSION['admin_id'];
							$data_record['staff_id'] = $_REQUEST['staff_id'];
							$data_record['bank_name'] = $bank_name;
						

								
							$data_record1['staff_id'] = $_REQUEST['staff_id'];
							$data_record1['admin_id'] = $admin;
							
							$branch_name = $_SESSION['branch_name'];
							//=====================================
							if($_SESSION['type']=='S')
							{
							   $sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								if(mysql_num_rows($ptr_branch))
								{
									$data_branch=mysql_fetch_array($ptr_branch);
									$cm_id=$data_record['cm_id']=$data_branch['cm_id'];
								
									$data_record['branch_name']=$branch_name;
								//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
								}
								else{
									$data_record['cm_id']="0";
									$data_record['branch_name']=$branch_name;
								}
							}	
							else
							{
								$cm_id=$data_record['cm_id']=$_SESSION['cm_id'];
								$data_record['branch_name']=$_SESSION['branch_name'];
							}
					      

						  $for_update = "select * from pr_add_salary_details where staff_id = '".$_REQUEST['staff_id']."' ";
						  $ptr_fs = mysql_query($for_update);
						  
							if(mysql_num_rows($ptr_fs)) {
								
								$where_record="staff_id='".$_REQUEST['staff_id']."'";
								$db->query_update("pr_add_salary_details", $data_record,$where_record);
								$id=mysql_insert_id();
								echo '<br></br><div id="msgbox" style="width:40%;">Record Updated successfully</center></div><br></br>';	
							}
							else 
								
								{
								 $insert_details=$db->query_insert("pr_add_salary_details", $data_record);
								 $id=mysql_insert_id();
                                 echo '<br></br><div id="msgbox" style="width:40%;">Record Added successfully</center></div><br></br>';								 
								}
								
							 	$total_floor=( ($_REQUEST['floor'])) ? $_REQUEST['floor'] : "";
								
								for($j=1;$j<=$total_floor;$j++)
								{
						
						
							$data_record1['s_from'] = $_POST['s_from'.$j];
							$data_record1['s_to'] = $_POST['s_to'.$j];
							$data_record1['s_percentage'] = $_POST['s_percentage'.$j];
							
							$data_record1['staff_id'] = $_REQUEST['admin1'];
							$data_record1['admin_id'] = $_SESSION['admin_id'];
							$data_record1['cm_id'] = $cm_id;
							$data_record1['record_id'] = $_REQUEST['record_id'];
							$data_record1['added_date'] = date('Y-m-d');
							
									
							
								
								
						//	$for_update1 = "select * from pr_add_service_incentive_details where staff_id = '".$_REQUEST['staff_id']."' ";
						//  $ptr_fs1 = mysql_query($for_update1);
							
                           if($_REQUEST['record']=='edit_record') {
								//echo "######################here";
								$where_record="s_id='".$_REQUEST['s_id'.$j]."'";
								$db->query_update("pr_add_service_incentive_details", $data_record1,$where_record);
							
							}
							else 
								{
								//echo ">>>>>>>>>>>>>>>>>>>>>>>>>>here";
								$insert_details1=$db->query_insert("pr_add_service_incentive_details", $data_record1);
                               						 
								}
							
								}
								
								
								$p_total_floor=( ($_REQUEST['total_type1'])) ? $_REQUEST['total_type1'] : "";
								
								for($i=1;$i<=$p_total_floor;$i++)
								{
						
						
							$data_record2['p_from'] = $_POST['p_from'.$i];
							$data_record2['p_to'] = $_POST['p_to'.$i];
							$data_record2['p_percentage'] = $_POST['p_percentage'.$i];
							
							$data_record2['staff_id'] = $_REQUEST['admin1'];
							$data_record2['admin_id'] = $_SESSION['admin_id'];
							$data_record2['cm_id'] = $cm_id;
							$data_record2['record_id'] = $_REQUEST['record_id'];
							$data_record2['added_date'] = date('Y-m-d');
							
									
							
								
								
						//	$for_update1 = "select * from pr_add_product_incentive_details where staff_id = '".$_REQUEST['staff_id']."' ";
						//  $ptr_fs1 = mysql_query($for_update1);
							
                           if($_REQUEST['record2']=='edit_record') {
								//echo "######################here";
								$where_record="p_id='".$_REQUEST['p_id'.$i]."'";
								$db->query_update("pr_add_product_incentive_details", $data_record2,$where_record);
							
							}
							else 
								{
								//echo ">>>>>>>>>>>>>>>>>>>>>>>>>>here";
								$insert_details1=$db->query_insert("pr_add_product_incentive_details", $data_record2);
                               						 
								}
							
								}
								
								$c_total_floor=( ($_REQUEST['total_type2'])) ? $_REQUEST['total_type2'] : "";
								
								for($c=1;$c<=$c_total_floor;$c++)
								{
						
						
							$data_record3['p_from'] = $_POST['p_from'.$c];
							$data_record3['p_to'] = $_POST['p_to'.$c];
							$data_record3['p_percentage'] = $_POST['p_percentage'.$c];
							
							$data_record3['staff_id'] = $_REQUEST['admin1'];
							$data_record3['admin_id'] = $_SESSION['admin_id'];
							$data_record3['cm_id'] = $cm_id;
							$data_record3['record_id'] = $_REQUEST['record_id'];
							$data_record3['added_date'] = date('Y-m-d');
							
									
							
								
								
						//	$for_update1 = "select * from pr_add_course_incentive_details where staff_id = '".$_REQUEST['staff_id']."' ";
						//  $ptr_fs1 = mysql_query($for_update1);
							
                           if($_REQUEST['record3']=='edit_record') {
								//echo "######################here";
								$where_record="c_id='".$_REQUEST['c_id'.$i]."'";
								$db->query_update("pr_add_course_incentive_details", $data_record3,$where_record);
							
							}
							else 
								{
								//echo ">>>>>>>>>>>>>>>>>>>>>>>>>>here";
								$insert_details1=$db->query_insert("pr_add_course_incentive_details", $data_record2);
                               						 
								}
							
								}
							
		  echo '<br></br><div id="msgbox" style="width:40%;">Record Updated successfully</center></div><br></br>';		
                          }
						  
                    }
                    if($success==0)
                    {
						$inc_month = "select * from pr_incentive_calculation where branch_name='".$_SESSION['branch_name']."'";
							$inc = $db->fetch_array($db->query($inc_month));
							
                        ?>
			<input type="hidden" name="basic_sal_type" id="basic_sal_type" value="<?php echo $inc['basic_sal_type']; ?>" />
			<input type="hidden" name="basic_sal_per" id="basic_sal_per" value="<?php echo $inc['basic_sal_per']; ?>" />
			
			<input type="hidden" name="house_rent_type" id="house_rent_type" value="<?php echo $inc['house_rent_type']; ?>" />
			<input type="hidden" name="house_rent_per" id="house_rent_per" value="<?php echo $inc['house_rent_per']; ?>" />
			    
			<input type="hidden" name="traveling_type" id="traveling_type" value="<?php echo $inc['traveling_type']; ?>" />
			<input type="hidden" name="travelling_per" id="travelling_per" value="<?php echo $inc['travelling_per']; ?>" />
			
			<input type="hidden" name="medical_type" id="medical_type" value="<?php echo $inc['medical_type']; ?>" />
			<input type="hidden" name="medical_per" id="medical_per" value="<?php echo $inc['medical_per']; ?>" />
			
		<input type="hidden" name="special_allowance1_type" id="special_allowance1_type" value="<?php echo $inc['special_allowance1_type']; ?>" />
	    <input type="hidden" name="special_allowance1" id="special_allowance1" value="<?php echo $inc['special_allowance1']; ?>" />
		
		<input type="hidden" name="special_allowance2_type" id="special_allowance2_type" value="<?php echo $inc['special_allowance2_type']; ?>" />
	    <input type="hidden" name="special_allowance2" id="special_allowance2" value="<?php echo $inc['special_allowance2']; ?>" />
            <tr><td>
        <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
           
            <tr>
                <td width="20%">Staff Name<span class="orange_font"></span></td>
                <td width="40%">
                   <label><?php echo $row_record2['name'];?></label>
				   <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $row_record2['attendence_id']; ?>" />
				    <input type="hidden" name="admin1" id="admin1" value="<?php echo $row_record2['admin_id']; ?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
               
			    <tr>
                <td width="20%">Salary<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onKeyUp="getsalcal();" class="validate[required] input_text" name="salary" id="salary" value="<?php if($_POST['save_changes']) echo $_POST['salary']; else echo $row_record['salary'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
			   
                <tr>
                <td width="20%">Basic Salary<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onKeyUp="getsalcal();"  class="validate[required] input_text" name="basic_salary" id="basic_salary" value="<?php if($_POST['save_changes']) echo $_POST['basic_salary']; else echo $row_record['basic_salary'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
             
            <tr>
                <td width="20%">House Rent Allowance<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" onKeyUp="getsalcal();"  class="validate[required] input_text" name="house_rent_allowance" id="house_rent_allowance" value="<?php if($_POST['save_changes']) echo $_POST['house_rent_allowance']; else echo $row_record['house_rent_allowance'];?>" />
                </td> 
                <td width="40%"></td>
            </tr> 
            
            
            <tr>
                <td width="20%">Travelling Allowance</td>
                <td width="40%">
                    <input type="text" onKeyUp="getsalcal();"  class="input_text" name="travelling_allowance" id="travelling_allowance" value="<?php if($_POST['save_changes']) echo $_POST['travelling_allowance']; else echo $row_record['travelling_allowance'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
            
            <tr>
                <td width="20%">Medical Allowance</td>
                <td width="40%">
                    <input type="text" onKeyUp="getsalcal();"  class="input_text" name="medical_allowance" id="medical_allowance" value="<?php if($_POST['save_changes']) echo $_POST['medical_allowance']; else echo $row_record['medical_allowance'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
                <td width="20%">Special Allowance 1</td>
                <td width="40%">
                    <input type="text" onKeyUp="getsalcal();"  class="input_text" name="special_allowance_1" id="special_allowance_1" value="<?php if($_POST['save_changes']) echo $_POST['special_allowance1']; else echo $row_record['special_allowance1'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
                <td width="20%">Special Allowance 2</td>
                <td width="40%">
                    <input type="text" onKeyUp="getsalcal();"  class="input_text" name="special_allowance_2" id="special_allowance_2" value="<?php if($_POST['save_changes']) echo $_POST['special_allowance2']; else echo $row_record['special_allowance2'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			<tr>
                <td width="20%">Total Salary</td>
                <td width="40%">
                    <input type="text" class="input_text" name="total_salary" id="total_salary" value="<?php if($_POST['save_changes']) echo $_POST['total_salary']; else echo $row_record['total_salary'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
              
            <tr>
                <td width="20%">Proffessional Tax<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="proffessional_tax" id="proffessional_tax"  value="<?php if($_POST['save_changes']) echo $_POST['proffessional_tax']; else echo $row_record['proffessional_tax'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
            
			 <tr>
                <td width="20%">TDS<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="tds" id="tds" 
                    value="<?php if($_POST['save_changes']) echo $_POST['tds']; else echo $row_record['tds'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>
			
			 <tr>
                <td width="20%">Bank Name<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_name" id="bank_name" 
                     value="<?php if($_POST['save_changes']) echo $_POST['bank_name']; else echo $row_record['bank_name'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
			
             <tr>
                <td width="20%">Bank A/C Number<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="bank_account_number" id="bank_account_number" 
                     value="<?php if($_POST['save_changes']) echo $_POST['bank_account_number']; else echo $row_record['bank_account_number'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
			             <tr>
                <td width="20%">Pan No.<span class="orange_font"></span></td>
                <td width="40%">
                    <input type="text" class="input_text" name="pan_number" id="pan_number" maxlength="10" size="10"
                    value="<?php if($_POST['save_changes']) echo $_POST['pan_number']; else echo $row_record['pan_number'];?>" />
                </td> 
                <td width="40%"></td>
            </tr>  
 <td colspan="2">

 
 
 
 
					 <!--===========================================================NEW TABLE START   Service=====================================-->



                        <table cellpadding="5" width="100%" >



                     



                                <tr><td> <strong>Service Incentive</strong> </td><td align="left"></td></tr>



                      

	  

  
  </table> 
                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>

<?php 
		   $for_update1 = "select * from pr_add_service_incentive_details where record_id = '".$_REQUEST['record_id']."' order by s_id asc";
						  $ptr_fs1 = mysql_query($for_update1);
							$no=mysql_num_rows($ptr_fs1);
                           if(mysql_num_rows($ptr_fs1)) {
							  
		   ?>
		   <input type="hidden" value="edit_record" name="record"  />
		   
		 
		   
		   <?php 
			$i=1;
		   while($val=mysql_fetch_array($ptr_fs1))
							   {
								   ?>
			<input type="hidden" name="s_id<?php echo $i; ?>" id="s_id<?php echo $i; ?>" value="<?php echo $val['s_id']; ?>" />
		   <tr>
		   <td style="width:10%;">From</td>
		   <td valign="top" width="10%" ><input type="text" name="s_from<?php echo $i; ?>" id="s_from<?php echo $i; ?>" value="<?php echo $val['s_from']; ?>" /></td>
		   <td style="width:10%;">To</td>
		   <td valign="top" width="10%" ><input type="text" name="s_to<?php echo $i; ?>" id="s_to<?php echo $i; ?>" value="<?php echo $val['s_to']; ?>" /></td>
		   <td style="width:10%;">Percentage</td>
		   <td valign="top" width="10%" ><input type="text" name="s_percentage<?php echo $i; ?>" id="s_percentage<?php echo $i; ?>" value="<?php echo $val['s_percentage']; ?>" /></td>
		   <input type="hidden" name="row_deleted<?php echo $i; ?>" id="row_deleted<?php echo $i; ?>" value="" />
		   <tr>
		    <input type="hidden" name="floor" id="floor"  value="<?php echo $no; ?>" />
							   <?php 
							   $i++;
							   }?>
		 
		   
		   <?php
						   }
						   else{
		   ?>
		   <input type="hidden" value="add_record" name="record"  />
		       <tr>



                         <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />



                         



                         <script language="javascript">



									



									function floors(idss)



									{



										var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="90%"><tr><td style="width:10%;">From</td><td valign="top" width="10%" ><input type="text" name="s_from'+idss+'" id="s_from'+idss+'" /></td><td style="width:10%;">To</td><td valign="top" width="10%" ><input type="text" name="s_to'+idss+'" id="s_to'+idss+'" /></td><td style="width:10%;">Percentage</td><td valign="top" width="10%" ><input type="text" name="s_percentage'+idss+'" id="s_percentage'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';



										document.getElementById('floor').value=idss;



										return shows_data;



									}



									



							</script>



                         



                         



                           <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 



<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >



  </td></tr>
           <input type="hidden" name="floor" id="floor"  value="0" />
		   <?php 
						   }?>
 

  <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>



  <tr>



                            <td colspan="6">



                           <!-- <table cellspacing="3" id="tbl" width="100%">



                            <tr>



                            <td valign="top" width="1%" align="center">Position</td>



                            <td valign="top" width="10%" align="center">Tag</td>



                            <td valign="top" width="10%" align="center" >Comment</td>



                            <td valign="top" width="10%"  align="center">Upload Image <font color="#CC66FF" size="-2">[jpg or gif only]</font></td>



                             </tr></table>-->



                    



                            <div id="create_floor"></div>



                        </td></tr></table>



                        <!--============================================================END TABLE=========================================-->


						
								 <!--===========================================================NEW TABLE START Product===================================-->



                        <table cellpadding="5" width="100%" >



                     



                                <tr><td> <strong>Product Incentive</strong> </td><td align="left"></td></tr>



                      

	  

  
  </table> 
                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>

<?php 
		   $for_update2 = "select * from pr_add_product_incentive_details where record_id = '".$_REQUEST['record_id']."' order by p_id asc";
						  $ptr_fs2 = mysql_query($for_update2);
							$no2=mysql_num_rows($ptr_fs2);
                           if(mysql_num_rows($ptr_fs2)) {
							  
		   ?>
		   <input type="hidden" value="edit_record" name="record2"  />
		   
		 
		   
		   <?php 
			$i=1;
		   while($val2=mysql_fetch_array($ptr_fs2))
							   {
								   ?>
			<input type="hidden" name="p_id<?php echo $i; ?>" id="p_id<?php echo $i; ?>" value="<?php echo $val2['p_id']; ?>" />
		   <tr>
		   <td style="width:10%;">From</td>
		   <td valign="top" width="10%" ><input type="text" name="p_from<?php echo $i; ?>" id="p_from<?php echo $i; ?>" value="<?php echo $val2['p_from']; ?>" /></td>
		   <td style="width:10%;">To</td>
		   <td valign="top" width="10%" ><input type="text" name="p_to<?php echo $i; ?>" id="p_to<?php echo $i; ?>" value="<?php echo $val2['p_to']; ?>" /></td>
		   <td style="width:10%;">Percentage</td>
		   <td valign="top" width="10%" ><input type="text" name="p_percentage<?php echo $i; ?>" id="p_percentage<?php echo $i; ?>" value="<?php echo $val2['p_percentage']; ?>" /></td>
		   <input type="hidden" name="row_deleted<?php echo $i; ?>" id="row_deleted<?php echo $i; ?>" value="" />
		   <tr>
		   
			  <input type="hidden" name="total_type1" id="total_type1"  value="<?php echo $no2; ?>" />
							   <?php 
							   $i++;
							   }?>
		 
		   
		   <?php
						   }
						   else{
		   ?>
		   <input type="hidden" value="add_record" name="record2"  />
		       <tr>



                         <input type="hidden" name="type1" id="type1" class="inputText" size="1" onKeyUp="create_type1();" value="0" />



                         



                         <script language="javascript">



						function type1(idss)

						{

                             //  res_tax= document.getElementById("res_tax").value;
							//alert(idss);

							var shows_data='<div id="type1_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="90%"><tr><td style="width:10%;">From</td><td valign="top" width="10%" ><input type="text" name="p_from'+idss+'" id="p_from'+idss+'" /></td><td style="width:10%;">To</td><td valign="top" width="10%" ><input type="text" name="p_to'+idss+'" id="p_to'+idss+'" /></td><td style="width:10%;">Percentage</td><td valign="top" width="10%" ><input type="text" name="p_percentage'+idss+'" id="p_percentage'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';

					   document.getElementById('total_type1').value=idss;

					   return shows_data;

						}


							</script>



                         



                         



                           <td align="right">
						   
						     <input type="button" name="Add"  class="addBtn" onClick="javascript:create_type1('add_type1');" alt="Add(+)" > 

                       <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_type1('delete_type1');" alt="Delete(-)" >



  </td></tr>
          <input type="hidden" name="total_type1" id="total_type1"  value="0" />
		   <?php 
						   }?>
 

  <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>



  <tr>



                            <td colspan="6">



                           <!-- <table cellspacing="3" id="tbl" width="100%">



                            <tr>



                            <td valign="top" width="1%" align="center">Position</td>



                            <td valign="top" width="10%" align="center">Tag</td>



                            <td valign="top" width="10%" align="center" >Comment</td>



                            <td valign="top" width="10%"  align="center">Upload Image <font color="#CC66FF" size="-2">[jpg or gif only]</font></td>



                             </tr></table>-->



                    



                         

                        <div id="create_type1"></div>




                        </td></tr></table>



                        <!--============================================================END TABLE=========================================-->
						
						
						
								 <!--===========================================================NEW TABLE START Course===================================-->



                        <table cellpadding="5" width="100%" >



                     



                                <tr><td> <strong>Course Incentive</strong> </td><td align="left"></td></tr>



                      

	  

  
  </table> 
                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>

<?php 
		   $for_update2 = "select * from pr_add_course_incentive_details where record_id = '".$_REQUEST['record_id']."' order by c_id asc";
						  $ptr_fs2 = mysql_query($for_update2);
							$no2=mysql_num_rows($ptr_fs2);
                           if(mysql_num_rows($ptr_fs2)) {
							  
		   ?>
		   <input type="hidden" value="edit_record" name="record3"  />
		   
		 
		   
		   <?php 
			$i=1;
		   while($val2=mysql_fetch_array($ptr_fs2))
							   {
								   ?>
			<input type="hidden" name="c_id<?php echo $i; ?>" id="c_id<?php echo $i; ?>" value="<?php echo $val2['c_id']; ?>" />
		   <tr>
		   <td style="width:10%;">From</td>
		   <td valign="top" width="10%" ><input type="text" name="c_from<?php echo $i; ?>" id="c_from<?php echo $i; ?>" value="<?php echo $val2['c_from']; ?>" /></td>
		   <td style="width:10%;">To</td>
		   <td valign="top" width="10%" ><input type="text" name="c_to<?php echo $i; ?>" id="c_to<?php echo $i; ?>" value="<?php echo $val2['c_to']; ?>" /></td>
		   <td style="width:10%;">Percentage</td>
		   <td valign="top" width="10%" ><input type="text" name="c_percentage<?php echo $i; ?>" id="c_percentage<?php echo $i; ?>" value="<?php echo $val2['c_percentage']; ?>" /></td>
		   <input type="hidden" name="c_row_deleted<?php echo $i; ?>" id="c_row_deleted<?php echo $i; ?>" value="" />
		   <tr>
		   
			  <input type="hidden" name="total_type2" id="total_type2"  value="<?php echo $no2; ?>" />
							   <?php 
							   $i++;
							   }?>
		 
		   
		   <?php
						   }
						   else{
		   ?>
		   <input type="hidden" value="add_record" name="record3"  />
		       <tr>



                         <input type="hidden" name="type2" id="type2" class="inputText" size="1" onKeyUp="create_type2();" value="0" />



                         



                         <script language="javascript">



										function type2(idss)

						{

                             //  res_tax= document.getElementById("res_tax").value;
							//alert(idss);

							var shows_data='<div id="type2_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="90%"><tr><td style="width:10%;">From</td><td valign="top" width="10%" ><input type="text" name="c_from'+idss+'" id="c_from'+idss+'" /></td><td style="width:10%;">To</td><td valign="top" width="10%" ><input type="text" name="c_to'+idss+'" id="c_to'+idss+'" /></td><td style="width:10%;">Percentage</td><td valign="top" width="10%" ><input type="text" name="c_percentage'+idss+'" id="c_percentage'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';

					   document.getElementById('total_type2').value=idss;

					   return shows_data;

						}


							</script>



                         



                         



                           <td align="right">
						   
						     <input type="button" name="Add"  class="addBtn" onClick="javascript:create_type1('add_type2');" alt="Add(+)" > 

                       <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_type1('delete_type2');" alt="Delete(-)" >



  </td></tr>
          <input type="hidden" name="total_type2" id="total_type2"  value="0" />
		   <?php 
						   }?>
 

  <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>



  <tr>



                            <td colspan="6">



                           <!-- <table cellspacing="3" id="tbl" width="100%">



                            <tr>



                            <td valign="top" width="1%" align="center">Position</td>



                            <td valign="top" width="10%" align="center">Tag</td>



                            <td valign="top" width="10%" align="center" >Comment</td>



                            <td valign="top" width="10%"  align="center">Upload Image <font color="#CC66FF" size="-2">[jpg or gif only]</font></td>



                             </tr></table>-->



                    



                         

                        <div id="create_type2"></div>




                        </td></tr></table>



                        <!--============================================================END TABLE=========================================-->

                        </td>



			</br>
            <tr>
                      <td><input type="submit" class="input_btn" onclick="return validme()" value="Add Salary Details" name="save_changes"  /></td>
            <td></td>
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

<?php
if($_SESSION['type']=="S" )
{
?>
    <script>
	//branch_id =document.getElementById("branch_name").value;
	//alert(branch_id);
	//show_bank(branch_id);
	</script>
    <?php } ?>


<script language="javascript">
function getsalcal()
{
	var basic_sal_per =$("#basic_sal_per").val();
	var house_rent_per =$("#house_rent_per").val();
	var medical_per =$("#medical_per").val();
	var travelling_per =$("#travelling_per").val();
	var salary =$("#salary").val();
	var travelling_allowance =$("#travelling_allowance").val();
    var medical_allowance =$("#medical_allowance").val();
	var special_allowance1 =$("#special_allowance1").val();
	var special_allowance2 =$("#special_allowance2").val();
	
	var basic_sal_type =$("#basic_sal_type").val();
	var house_rent_type =$("#house_rent_type").val();
	var traveling_type =$("#traveling_type").val();
	var medical_type =$("#medical_type").val();
	var special_allowance1_type =$("#special_allowance1_type").val();
	var special_allowance2_type =$("#special_allowance2_type").val();
	
	if(basic_sal_type=="rupees")
	{
	    var b_salary=parseFloat(basic_sal_per);
	}
	else
	{
	    var b_salary=(salary*basic_sal_per)/100;	
	}
	
	if(house_rent_type=="rupees")
	{
	    var hr=parseFloat(house_rent_per);
	}
	else
	{
	    var hr=(salary*house_rent_per)/100;	
	}
	
	if(traveling_type=="rupees")
	{
	    var tr=parseFloat(travelling_per);
	}
	else
	{
		var tr=(salary*travelling_per)/100;
	}
	
	if(medical_type=="rupees")
	{
	    var md=parseFloat(medical_per);
	}
	else
	{
	    var md=(salary*medical_per)/100;	
	}
	
	if(special_allowance1_type=="rupees")
	{
	    var sp1=parseFloat(special_allowance1);
	}
	else
	{
	    var sp1=(salary*special_allowance1)/100;	
	}
	
	if(special_allowance2_type=="rupees")
	{
	    var sp2=parseFloat(special_allowance2);
	}
	else
	{
	    var sp2=(salary*special_allowance2)/100;	
	}
	$('#basic_salary').val(b_salary);
	$('#house_rent_allowance').val(hr);
	$('#travelling_allowance').val(tr);
	$('#medical_allowance').val(md);
	$('#special_allowance_1').val(sp1);
	$('#special_allowance_2').val(sp2);

	var total_salary=parseFloat(b_salary)+parseFloat(hr)+parseFloat(travelling_allowance)+parseFloat(medical_allowance);
	//alert(total_salary);
	/* if(total_salary>salary)
	{
		alert("Please Enter Valid Amount");
	$('#travelling_allowance').val('');
	$('#medical_allowance').val('');
	} */
	$('#total_salary').val(salary);
	
}
</script>

<script language="javascript">



create_floor('add');

create_type1('add_type1');

create_type1('add_type2');

//create_floor_dependent();



</script>


</body>
</html>
<?php $db->close();?>
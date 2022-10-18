<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
   $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM pr_staff_service_incentive where staff_id='".$record_id."' AND month='".$_REQUEST['month']."' AND year='".$_REQUEST['year']."'";
    $row_record=$db->fetch_array($db->query($sql_record));
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?> Staff Service Incentive</title>
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
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
       
    </script>
	<script>
function delete_service(id,types)
{
	if(confirm('Do you really want to delete record'))
	{
		$('#service_id'+id).replaceWith(function(){
			return $('<input type="text"  name="service_id'+id+'" id="service_id'+id+'"  style="width:90%" />', {html: $(this).html()});
		});
		$('#sin_service_price'+id).replaceWith(function(){
			return $('<input type="text" name="sin_service_price'+id+'" id="sin_service_price'+id+'" value="" style="width:60px" />', {html: $(this).html()});
		});
		$('#sin_service_cgst'+id).replaceWith(function(){
			return $('<input type="text" name="sin_service_cgst'+id+'" id="sin_service_cgst'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_service_cgst_price'+id).replaceWith(function(){
			return $('<input type="text" name="sin_service_cgst_price'+id+'" id="sin_service_cgst_price'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_service_sgst'+id).replaceWith(function(){
			return $('<input type="text" name="sin_service_sgst'+id+'" id="sin_service_sgst'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_service_sgst_price'+id).replaceWith(function(){
			return $('<input type="text" name="sin_service_sgst_price'+id+'" id="sin_service_sgst_price'+id+'" value="" />', {html: $(this).html()});
		});
		
		$('#sin_service_igst'+id).replaceWith(function(){
			return $('<input type="text" name="sin_service_igst'+id+'" id="sin_service_igst'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_service_igst_price'+id).replaceWith(function(){
			return $('<input type="text" name="sin_service_igst_price'+id+'" id="sin_service_igst_price'+id+'" value="" />', {html: $(this).html()});
		});
		
		$('#temp_total'+id).replaceWith(function(){
			return $('<input type="text" name="temp_total'+id+'" id="temp_total'+id+'" value="" />', {html: $(this).html()});
		});
		$('#incentive_percentage'+id).replaceWith(function(){
			return $('<input type="text" name="incentive_percentage'+id+'" id="incentive_percentage'+id+'" value="" />', {html: $(this).html()});
		});
		$('#incentive_amount'+id).replaceWith(function(){
			return $('<input type="text" name="incentive_amount'+id+'" id="incentive_amount'+id+'" value="" />', {html: $(this).html()});
		});
		$('#adjustment_amount'+id).replaceWith(function(){
			return $('<input type="text" name="adjustment_amount'+id+'" id="adjustment_amount'+id+'" value="" />', {html: $(this).html()});
		});
		$('#total'+id).replaceWith(function(){
			return $('<input type="text" name="total'+id+'" id="total'+id+'" value="" />', {html: $(this).html()});
		});
		
		if(types=='floor')
		{  
			$('#floor_id'+id).hide();
			$('#del_floor'+id).val('yes');
			
		}
	
	}
	showUser();
}

function showUser()
{
	contact='';
	var total_sales_product= document.getElementsByName("total_sales_service[]");
	totals=total_sales_product.length;

	contact=''
	for(i=1; i<=totals;i++)
	{

		prod_totalssss=Number(document.getElementById("total"+i).value);
		if(prod_totalssss!='')
		{
			contact =Number(contact)+Number(prod_totalssss);
			
		}
	}

	document.getElementById('grandtot').value=contact;
}
</script>
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
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
						 if($_POST['month'] =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Month";
                        }
						  if($_POST['staff_id'] =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Staff";
                        }
						
						if($record_id)
						{
					   $total_floor=( ($_POST['no_of_floor'])) ? $_POST['no_of_floor'] : "0";
						}
						else{
						$total_floor=( ($_POST['floor'])) ? $_POST['floor'] : "0";
						}
						
						
						$branch_name=$_SESSION['branch_name'];
	
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
							
							
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								if(mysql_num_rows($ptr_branch))
								{
									$data_branch=mysql_fetch_array($ptr_branch);
									$data_record_type1['cm_id']=$data_branch['cm_id'];
									$data_record_type1['branch_name']=$branch_name;
									//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
								}
								else{
									$data_record_type1['cm_id']='0';
									$data_record_type1['branch_name']=$branch_name;
								}
							}	
							else
							{
								$data_record_type1['cm_id']=$_SESSION['cm_id'];
								$data_record_type1['branch_name']=$_SESSION['branch_name'];
							}
						 	
                            if($record_id)
			    {
				
				
				for($z=1;$z<=$total_floor;$z++)
				{
					"Floor- ". $_POST['del_floor'.$z]."<br />";
					"<br />floor_id- ".$_POST['floor_id_'.$z];
					if($_POST['del_floor'.$z]=='yes')
					{
						if($_POST['floor_id_'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
						{
							"<br />".$delete_row = "delete from pr_staff_service_incentive where staff_service_incentive_id='".$_POST['floor_id_'.$z]."' ";
							$ptr_delete = mysql_query($delete_row);
						}
					}
					
					if($_POST['del_floor'.$z] !='yes')
					{
					
					                        $data_record_type1['admin_id'] = $_SESSION['admin_id'];
											$data_record_type1['year'] = $_POST['year'];
											$data_record_type1['month'] = $_POST['month'];
											$data_record_type1['staff_id'] =addslashes(trim($_POST['staff_id'])); 
											$data_record_type1['service_id'] =addslashes(trim($_POST['service_id'.$z]));					
											$data_record_type1['sin_service_price'] =addslashes(trim($_POST['sin_service_price'.$z]));
											$data_record_type1['incentive_amount'] =addslashes(trim($_POST['incentive_amount'.$z]));
											
											
											$data_record_type1['sin_service_cgst_price'] =addslashes(trim($_POST['sin_service_cgst_price'.$z]));
											$data_record_type1['sin_service_cgst'] =addslashes(trim($_POST['sin_service_cgst'.$z]));
											$data_record_type1['sin_service_sgst'] =addslashes(trim($_POST['sin_service_sgst'.$z]));
											$data_record_type1['sin_service_sgst_price'] =addslashes(trim($_POST['sin_service_sgst_price'.$z]));
											$data_record_type1['sin_service_igst'] =addslashes(trim($_POST['sin_service_igst'.$z]));
											$data_record_type1['sin_service_igst_price'] =addslashes(trim($_POST['sin_service_igst_price'.$z]));
											$data_record_type1['sin_service_igst_price'] =addslashes(trim($_POST['sin_service_igst_price'.$z]));
											$data_record_type1['sin_service_card'] =addslashes(trim($_POST['sin_service_card'.$z]));
											$data_record_type1['sin_service_card_price'] =addslashes(trim($_POST['sin_service_card_price'.$z]));
											
											$data_record_type1['incentive_percentage'] =addslashes(trim($_POST['incentive_percentage'.$z]));
											$data_record_type1['adjustment_amount'] =addslashes(trim($_POST['adjustment_amount'.$z]));
											$data_record_type1['total'] =addslashes(trim($_POST['total'.$z]));
											$data_record_type1['temp_total'] =addslashes(trim($_POST['temp_total'.$z]));
											$data_record_type1['grand_total'] =addslashes(trim($_POST['grandtot']));
											$data_record_type1['added_date'] =date("Y-m-d H:i:s");
											$data_record_type1['status'] ="Not Paid";
					//echo "############".$_POST['floor_id'.$z]."##########".$_POST['service_id'.$z];
					if($_POST['floor_id_'.$z]=='' && $_POST['service_id'.$z] !='')
					{
					//	echo "^^^^^^^^^^^^^^^^^^^^^^^^^^^^here";
						 $type1_id=$db->query_insert("pr_staff_service_incentive", $data_record_type1);
					}
					else
					{
					//	echo ">>>>>>>>>>>>>>>>>>>>>>>>>>here";
						$where_record="staff_service_incentive_id='".$_POST['floor_id_'.$z]."'";
						$floor_id= $_POST['floor_id_'.$z];
						$db->query_update("pr_staff_service_incentive", $data_record_type1,$where_record);
					}
					unset($data_record_type1);
				   }
				}
				
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Edit','expense','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert); 
				 echo ' <br></br><div id="msgbox" style="width:40%;">Record Updated successfully</center></div> <br></br>';
			}
                            else
                            {
							   

								//====================FOR Type1 INSERT======================================================
								for($j=1;$j<=$total_floor;$j++)
								{
										
											$data_record_type1['admin_id'] = $_SESSION['admin_id'];
											$data_record_type1['year'] = $_POST['year'];
											$data_record_type1['month'] = $_POST['month'];
											$data_record_type1['staff_id'] =addslashes(trim($_POST['staff_id'])); 
											$data_record_type1['service_id'] =addslashes(trim($_POST['service_id'.$j]));					
											$data_record_type1['sin_service_price'] =addslashes(trim($_POST['sin_service_price'.$j]));
											$data_record_type1['incentive_amount'] =addslashes(trim($_POST['incentive_amount'.$j]));
											
											
											$data_record_type1['sin_service_cgst_price'] =addslashes(trim($_POST['sin_service_cgst_price'.$j]));
											$data_record_type1['sin_service_cgst'] =addslashes(trim($_POST['sin_service_cgst'.$j]));
											$data_record_type1['sin_service_sgst'] =addslashes(trim($_POST['sin_service_sgst'.$j]));
											$data_record_type1['sin_service_sgst_price'] =addslashes(trim($_POST['sin_service_sgst_price'.$j]));
											$data_record_type1['sin_service_igst'] =addslashes(trim($_POST['sin_service_igst'.$j]));
											$data_record_type1['sin_service_igst_price'] =addslashes(trim($_POST['sin_service_igst_price'.$j]));
											$data_record_type1['sin_service_card'] =addslashes(trim($_POST['sin_service_card'.$j]));
											$data_record_type1['sin_service_card_price'] =addslashes(trim($_POST['sin_service_card_price'.$j]));
											
											$data_record_type1['incentive_percentage'] =addslashes(trim($_POST['incentive_percentage'.$j]));
											$data_record_type1['adjustment_amount'] =addslashes(trim($_POST['adjustment_amount'.$j]));
											$data_record_type1['total'] =addslashes(trim($_POST['total'.$j]));
											$data_record_type1['temp_total'] =addslashes(trim($_POST['temp_total'.$j]));
											$data_record_type1['grand_total'] =addslashes(trim($_POST['grandtot']));
											$data_record_type1['added_date'] =date("Y-m-d H:i:s");
											$data_record_type1['status'] ="Not Paid";
											$record_comission=$db->query_insert("pr_staff_service_incentive", $data_record_type1);
											$slab_id=mysql_insert_id();  
								         
								 }
								 
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
		<?php if($row_record['status']=='Paid') { echo "<center style='margin-top:20px;'><b style='font-size:14px;color:green;'>**** Incentive Is Allready Paid For This Month ****</b></center>"; }?>
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
    
                		 
                		<td colspan="2">
						<?php
						echo '<table width="100%"><tr><td width="20%" style="padding-left:20px;">';
						echo 'Select Year<span class="orange_font">*</span></td><td>';
							$yearArray = range(2030, 2018);
						echo ' <select id="year" name="year">';
					
?>
    <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
    <?php
    foreach ($yearArray as $year) {
        // if you want to select a particular year
       // $selected = ($year == 2018) ? 'selected' : '';
        ?><option <?php if($year==$_REQUEST['year']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php
    }
    ?>
</select>
						<?php
						
						?> 
								</td>
								
								<td width="20%" style="padding-left:20px;">
						<?php
						
						echo 'Select Month<span class="orange_font">*</span></td><td>';
						$monthArray = range(1, 12);
						echo ' <select id="month" name="month" onChange="getreport();getmonthdays();">';
					?>
    <option value="">Select Month</option>
    <?php
    foreach ($monthArray as $month) {
        // padding the month with extra zero
        $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
        // you can use whatever year you want
        // you can use 'M' or 'F' as per your month formatting preference
        $fdate = date("F", strtotime("2015-$monthPadding-01"));
       ?><option <?php if($month==$row_record['month']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $monthPadding; ?>"><?php echo $fdate; ?></option>
   <?php
    }
    ?>
</select>
<?php
				
						?> 
								</td>
                         <td width="20%" style="padding-left:20px;">Select Staff<span class="orange_font">*</span></td>
                <td width="40%">
    <select id="staff_id" name="staff_id" onChange="getreport();getmonthdays();">
    <option value="">Select Staff</option>
	<?php
									if($_SESSION['type']=="S")
									{
										$sel_staff = "select attendence_id,admin_id,name from site_setting where 1  ".$_SESSION['where']." AND attendence_id!='' order by admin_id asc";	 
										$query_staff = mysql_query($sel_staff);
										if($total_staff=mysql_num_rows($query_staff))
										{
											while($data=mysql_fetch_array($query_staff))
											{
												?>
												<option <?php if($data['admin_id']==$row_record['staff_id']) echo "selected"; else echo "";  ?> value="<?php echo $data['admin_id']; ?>" ><?php echo $data['name']; ?></option>
											<?php }
										}
									}
									else
									{
										$sel_prev_id="select DISTINCT(admin_id) from staff_previleges where 1 ".$_SESSION['where']." ".$prev_value."";
										$ptr_id=mysql_query($sel_prev_id);
										if(mysql_num_rows($ptr_id))
										{
											while($data_prev_id=mysql_fetch_array($ptr_id))
											{
												$sel_staff = "select admin_id,name from site_setting where 1 and admin_id='".$data_prev_id['admin_id']."' ".$_SESSION['where']." order by admin_id asc";	
												$query_staff = mysql_query($sel_staff);
												if(mysql_num_rows($query_staff))
												{
													$data=mysql_fetch_array($query_staff);
													echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
												}
												
											}
										}
									}
									 ?>
	</select>
                </td> 
		</tr></table>
               </tr> 
           

            <tr>
	
	<td colspan="12">
		<table  width="100%" style="border:1px solid gray; margin-left: -15px;">
			<tr>
			<td colspan="12">
			<!--===========================================================NEW TABLE START===================================-->
			<table cellpadding="5" width="100%" >
			<tr>
			                   
<?php
			if($record_id =='')
			{
				?>
				<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
				<?php 
			}?>
			
			  <script language="javascript">
						function floors(idss)
						{
							var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td width="12%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="service_id'+idss+'" id="service_id'+idss+'" style="width:140px" onChange="getprice('+idss+')"><option value="">Select Service</option><?php
                                            $sel_tel = "select service_id,service_name,service_price,service_time from servies order by service_id asc";	 
                                            $query_tel = mysql_query($sel_tel);
                                            if($total=mysql_num_rows($query_tel))
                                            {
                                                while($data=mysql_fetch_array($query_tel))
                                                {
                                                    echo '<option value="'.$data['service_id'].'">'.$data['service_name'] ." &nbsp;&nbsp;&nbsp;       (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time']." min)".'</option>';
                                                }
                                            }
                                             ?>
                                             </select></td><td width="8%" align="center"><input type="text" onkeyup="calc_service_price('+idss+')" name="sin_service_price'+idss+'" id="sin_service_price'+idss+'" style=" width:100px;" value="<?php echo $data_exclusive['service_price'] ?>" /></td><td width="5%" align="center"><input type="text" name="sin_service_cgst'+idss+'" id="sin_service_cgst'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:60px"><input type="text" name="sin_service_cgst_price'+idss+'" id="sin_service_cgst_price'+idss+'" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_sgst'+idss+'" id="sin_service_sgst'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:60px"><input type="text" name="sin_service_sgst_price'+idss+'" id="sin_service_sgst_price'+idss+'" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_igst'+idss+'" id="sin_service_igst'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:60px"><input type="text" name="sin_service_igst_price'+idss+'" id="sin_service_igst_price'+idss+'" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_card'+idss+'" id="sin_service_card'+idss+'" onkeyup="calc_service_price('+idss+')" style=" width:60px"><input type="text" name="sin_service_card_price'+idss+'" id="sin_service_card_price'+idss+'" style=" width:60px" /></td><td width="4%" align="center"><input type="text" name="temp_total'+idss+'" id="temp_total'+idss+'" onkeyup="calc_service_price('+idss+')" style="width:60px;" /></td><td width="4%" align="center"><input type="text" name="incentive_percentage'+idss+'" id="incentive_percentage'+idss+'" onkeyup="calc_service_price('+idss+')" style="width:60px" /></td><td width="4%" align="center"><input type="text" name="incentive_amount'+idss+'" id="incentive_amount'+idss+'" onkeyup="calc_service_price('+idss+')" style="width:60px" /></td><td width="4%" align="center"><input type="text" name="adjustment_amount'+idss+'" id="adjustment_amount'+idss+'" style="width:60px" /></td><td width="4%" align="center"><input type="text" name="total'+idss+'" id="total'+idss+'" style="width:60px;margin-right: 30px;" /><input type="hidden" name="total_sales_service[]" id="total_sales_service'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></td><tr></table></div>';
							document.getElementById('floor').value=idss;
							return shows_data;
						}
						</script>
			<td align="right"><input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" ><input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" ></td></tr>
			<tr><td></td><td align="left"></td></tr>
		</table> 
		<table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr> <tr><td align="center" width="25%"> </td><td width="10%"> </td><td width="5%"> </td></tr>
		<tr>
			<td colspan="12">
				<table cellspacing="3" id="tbl" width="100%">
				<tr>
									<td valign="top" align="center" width="16%">Service Name</td>
									<td valign="top" align="center" width="14%">MRP</td>
									
									<td valign="top" width="7%" align="center">CGST</td>
									<td valign="top" width="7%" align="center">SGST</td>
									<td valign="top" width="7%" align="center">IGST</td>
									<td valign="top" width="7%" align="center">Card </br> Deduction</td>
									<td valign="top" width="9%" align="center">Total</td>
									<td valign="top" width="8%" align="center" >Incentive %</td>
									<td valign="top" width="7%" align="center">Incentive </br> Amount</td>
									<td valign="top" width="8%" align="center">Adjustment </br> Amount</td>
									<td valign="top" width="6%" align="center">Final Total</td>
									<td valign="top" width="2%"  align="center"> <?php	if($record_id){ echo "Acton"; } ?></td>
							</tr>
				<tr>
				<?php if($record_id=='') {?>
				 <td colspan="12">
							<div id="showdiv"></div>
							</td>
				<?php } ?>
					<td colspan="13">
					<?php
$staff_id=$_REQUEST['record_id'];
$month=$_REQUEST['month'];
$year=$_REQUEST['year'];
if($record_id)
{
	 $select_exc = "select * from pr_staff_service_incentive where month='".$month."' and year='".$year."' and staff_id='".$record_id."' order by  staff_service_incentive_id asc ";
	$ptr_fs = mysql_query($select_exc);
	$t=1;
	$total_comision= mysql_num_rows($ptr_fs);
	$total_conditions= mysql_num_rows($ptr_fs);
	while($data_exclusive = mysql_fetch_array($ptr_fs))
	{ 
		$slab_id= $data_exclusive['customer_service_map_id'];
		?> 
		<div class="floor_div" id="floor_id<?php echo $t; ?>">
		<table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
		<tr>
		<td valign="" width="16%" align="center"><select name="service_id<?php echo $t; ?>" id="service_id<?php echo $t; ?>" style="width:140px" onChange="getprice(<?php echo $t; ?>)"><option value="">Select Service</option><?php
		$sel_tel = "select service_id,service_name,service_price,service_time from servies order by service_id asc";	 
		$query_tel = mysql_query($sel_tel);
		if($total=mysql_num_rows($query_tel))
		{
			while($data=mysql_fetch_array($query_tel))
			{
				$selected='';
				if($data_exclusive['service_id'] ==$data['service_id'] )
				{
					$selected='selected="selected"';
				}
				echo '<option value="'.$data['service_id'].'" '.$selected.'>'.$data['service_name']."   (Price- ".$data['service_price'].")" ."     (Time- ".$data['service_time'].")".'</option>';
			}
		}
		?>
		</select></td>
		<td width="8%" align="center"><input type="text" onkeyup="calc_service_price('<?php echo $t; ?>')" name="sin_service_price<?php echo $t; ?>" id="sin_service_price<?php echo $t; ?>" style=" width:100px;" value="<?php echo $data_exclusive['sin_service_price']; ?>" /></td><td width="5%" align="center"><input type="text" name="sin_service_cgst<?php echo $t; ?>" id="sin_service_cgst<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_service_cgst']; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px"><input type="text" name="sin_service_cgst_price<?php echo $t; ?>" id="sin_service_cgst_price<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_service_cgst_price']; ?>" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_sgst<?php echo $t; ?>" id="sin_service_sgst<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_service_sgst']; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px"><input type="text" name="sin_service_sgst_price<?php echo $t; ?>" id="sin_service_sgst_price<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_service_sgst_price']; ?>" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_igst<?php echo $t; ?>" id="sin_service_igst<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_service_igst']; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px"><input type="text" name="sin_service_igst_price<?php echo $t; ?>" id="sin_service_igst_price<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_service_igst_price']; ?>" style=" width:60px" /></td><td width="5%" align="center"><input type="text" name="sin_service_card<?php echo $t; ?>" id="sin_service_card<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_service_card']; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style=" width:60px"><input type="text" name="sin_service_card_price<?php echo $t; ?>" id="sin_service_card_price<?php echo $t; ?>" value="<?php echo $data_exclusive['sin_service_card_price']; ?>"  style=" width:60px" /></td><td width="4%" align="center"><input type="text" name="temp_total<?php echo $t; ?>" id="temp_total<?php echo $t; ?>" value="<?php echo $data_exclusive['temp_total']; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style="width:60px;" /></td><td width="4%" align="center"><input type="text" name="incentive_percentage<?php echo $t; ?>" id="incentive_percentage<?php echo $t; ?>" value="<?php echo $data_exclusive['incentive_percentage']; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style="width:60px" /></td><td width="4%" align="center"><input type="text" name="incentive_amount<?php echo $t; ?>" id="incentive_amount<?php echo $t; ?>" value="<?php echo $data_exclusive['incentive_amount']; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style="width:60px" /></td><td width="4%" align="center"><input type="text" name="adjustment_amount<?php echo $t; ?>" id="adjustment_amount<?php echo $t; ?>" value="<?php echo $data_exclusive['adjustment_amount']; ?>" onkeyup="calc_service_price(<?php echo $t; ?>)" style="width:60px" value="0"/></td><td width="4%" align="center"><input type="text" name="total<?php echo $t; ?>" id="total<?php echo $t; ?>" value="<?php echo $data_exclusive['total']; ?>" style="width:60px" /><input type="hidden" name="total_sales_service[]" id="total_sales_service<?php echo $t; ?>" /><input type="hidden" name="row_deleted<?php echo $t; ?>" id="row_deleted<?php echo $t; ?>" value="" /></td>
		<td valign="top" width="2%" align="center">
		<?php
		if($record_id)
		{
			?>
			<input type="hidden" name="total_services[]" id="total_services<?php echo $t; ?>" />
			<input type="hidden" name="floor_id_<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['staff_service_incentive_id'] ?>" />
			<input type="button" style="margin-top: 14px;" title="Delete Options(-)" onClick="delete_service(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
			<input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
			<?php 	
		}
		?> 
		</td>
		
		</tr>
		
		</table>
		</div>
		
		<?php
		$t++;
	}
}
?>
				</tr>
				</table>
				<input type="hidden" name="floor" id="floor" value="0" />
			<div id="create_floor"></div>
			</td>
		</tr>
		<table style="float:right;" width="100%" bgcolor="#CCCCCC"><tr><td width="78%"></td><td><b>Grand Total</b></td><td><input type="text"  name="grandtot" id="grandtot"  value="<?php echo $row_record['grand_total']; ?>">
	</td></tr></table>
		</table>
		<?php
		if($record_id)
		{
			?>
			
			<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />
			<input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
			<?php 
		} 
		?> 
		<!--============================================================END TABLE=========================================-->
		</td>
		</tr>
		
	</table>
</td>
</tr>
			<?php if($row_record['status']!='Paid') { ?>		

            <td><input type="submit" class="input_btn" onClick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Record" name="save_changes"  /></td>
			<?php } } ?>	
   <td></td>
     </tr>
 </table>
 </form>
</td></tr>

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




<script language="javascript">
	function getmonthdays(i)
	{
		
		var staff = $("#staff_id").val();
		var month = $("#month").val();
		var year = $("#year").val();
		var ptype = 'service_incentive';
		 $.ajax({ 
			//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
				type: 'post',
				url: 'check_exist.php',
				data: { staff:staff,year:year,month:month,ptype:ptype },
				
			}).done(function(responseData) {
			 //alert(responseData);
			if(responseData!='' && responseData!=0)
			{
				alert("Record All Ready Exist For This Selection");
				//$("#incentive_paid_month").attr("disabled", "disabled");
			//	$("#payment_date").attr("disabled", "disabled");
				
			}
			else{
				
			//	$("#incentive_paid_month").removeAttr("disabled");
			//	$("#payment_date").removeAttr("disabled");
			}
			}).fail(function() {
				console.log('Failed');
			});
	 }
	</script>

	<script>
	function getreport() 
	{
		//var atype = $("#atype").val();
		var year = $("#year").val();
		var month = $("#month").val();
		var staff = $("#staff_id").val();
		//alert(staff);
		if(staff==''){
			alert("Please Select Staff");
			return false;
		}
		if(month==''){
			alert("Please Select Month");
			return false;
		}
		if(year==''){
			alert("Please Select Year");
			return false;
		}
			$.ajax({ 
			//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
				type: 'post',
				url: 'staff_service_incentive_ajax.php',
				data: { year: year,month:month,staff:staff },
				
			}).done(function(responseData) {
				//alert(responseData);
				var data=responseData.split("#####");
			$("#showdiv").html(data[0]);
			calc_service_price(data[1]);
			//getprice(data[1]);
			//alert(data[1]);
			for(i=1; i<=data[1];i++)
	{
		getprice(i);
	}
			document.getElementById('floor').value=data[1];
			document.getElementById('no_of_floor').value=data[1];
			document.getElementById('grandtot').value=contact;
			
			}).fail(function() {
				console.log('Failed');
			});
		}
	</script>



		<script>
		
		function getprice(val_idss)
	{
		//alert(val_idss);
		var service_id=document.getElementById('service_id'+val_idss).value;
		//alert(service_id);			
		var data1="service_id="+service_id;	
		
		//alert(data1);
			$.ajax({
				url: "get_service_price.php", type: "post", data: data1, cache: false,
				success: function (html)
				{
					//alert(html);
					service_split=html.split("-");
				var service_price= document.getElementById("sin_service_price"+val_idss).value=service_split[0];
				//	var service_discount=document.getElementById("service_disc"+val_idss).value = 0;
				var exit_cgst=document.getElementById("sin_service_cgst"+val_idss).value = 0;
				var exit_sgst=document.getElementById("sin_service_sgst"+val_idss).value = 0;
				var exit_igst=document.getElementById("sin_service_igst"+val_idss).value = 0;
				var adjustment_amount=document.getElementById("adjustment_amount"+val_idss).value = 0;
				//var total=document.getElementById("total"+val_idss).value = 0;
					
				}
				});
				setTimeout(calc_service_price,1000,val_idss);
	}
		
	function calc_service_price(val_idss)
	{
				//alert(val_idss);
		var total_price=document.getElementById('sin_service_price'+val_idss).value;

			disc_type='';
		frm = document.jqueryForm;  
		
			cgst_value=0;
			cgst_percent=parseFloat(document.getElementById("sin_service_cgst"+val_idss).value).toFixed(2);
			if(cgst_percent >0)
			{
				cgst_value= parseFloat((total_price*cgst_percent)/100).toFixed(2);
				cgst_price=parseFloat(cgst_value).toFixed(2);
				document.getElementById("sin_service_cgst_price"+val_idss).value=cgst_price;
			}
			else
			{
				document.getElementById("sin_service_cgst_price"+val_idss).value=0;
			}
			sgst_value=0;
			sgst_percent=parseFloat(document.getElementById("sin_service_sgst"+val_idss).value).toFixed(2);
			if(sgst_percent >0)
			{
				sgst_value= parseFloat((total_price*sgst_percent)/100).toFixed(2);
				//total_price_sgst=parseFloat(Number(total_price)+Number(sgst_value)).toFixed(2);
				sgst_price=parseFloat(sgst_value).toFixed(2);
				document.getElementById("sin_service_sgst_price"+val_idss).value=sgst_price;
			}
			else
			{
				document.getElementById("sin_service_sgst_price"+val_idss).value=0;
			}
			igst_value=0;
			igst_percent=parseFloat(document.getElementById("sin_service_igst"+val_idss).value).toFixed(2);
			if(igst_percent >0)
			{
				igst_value= parseFloat((total_price*igst_percent)/100).toFixed(2);
				//total_price_igst=parseFloat(Number(total_price)+Number(igst_value)).toFixed(2);
				igst_price=parseFloat(igst_value).toFixed(2);
				document.getElementById("sin_service_igst_price"+val_idss).value=igst_price;
			}
			else 
			{
				document.getElementById("sin_service_igst_price"+val_idss).value=0;
			}
			card_value=0;
			card_percent=parseFloat(document.getElementById("sin_service_card"+val_idss).value).toFixed(2);
			if(card_percent >0)
			{
				card_value= parseFloat((total_price*card_percent)/100).toFixed(2);
				//total_price_igst=parseFloat(Number(total_price)+Number(igst_value)).toFixed(2);
				card_price=parseFloat(card_value).toFixed(2);
				document.getElementById("sin_service_card_price"+val_idss).value=card_price;
			}
			else
			{
				document.getElementById("sin_service_card_price"+val_idss).value=0;
			}
			
			totals_price=Number(cgst_value) + Number(sgst_value)+ Number(igst_value)+ Number(card_value);
			
			var temp_total=total_price-totals_price;
			
			var t_amount=document.getElementById("temp_total"+val_idss).value=temp_total;
			incentive_percent=0;
			incentive_price=0;
			incentive_percent=parseFloat(document.getElementById("incentive_percentage"+val_idss).value).toFixed(2);
			if(incentive_percent >0)
			{
				
				incentive_percent= parseFloat((t_amount*incentive_percent)/100).toFixed(2);
				//alert(adjustment_amount+'*****'+incentive_percent);
				//total_price_igst=parseFloat(Number(total_price)+Number(igst_value)).toFixed(2);
				incentive_price=parseFloat(incentive_percent).toFixed(2);
				document.getElementById("incentive_amount"+val_idss).value=incentive_price;
					document.getElementById("total"+val_idss).value=incentive_price;
			}
			else
			{
				document.getElementById("incentive_amount"+val_idss).value=0;
				var tot=document.getElementById("total"+val_idss).value=0;
			}
			
			adjustment=parseFloat(document.getElementById("adjustment_amount"+val_idss).value).toFixed(2);
			//alert(adjustment);
				if(adjustment!='')
				{
				var total= (parseFloat(incentive_price)+parseFloat(adjustment));
				
				incentive_price=parseFloat(incentive_percent).toFixed(2);
				var tot=document.getElementById("total"+val_idss).value=total;
				}
				else
				{
				document.getElementById("total"+val_idss).value=0;	
				}
				contact=''
		for(i=1; i<=val_idss;i++)
		{
			
			prod_totalssss=Number(document.getElementById("total"+i).value);
			
			if(prod_totalssss!='')
			{
				contact =Number(contact)+Number(prod_totalssss);
				//alert(contact);
			}
			document.getElementById('grandtot').value=contact;
		}
		//alert(contact);
	}
	</script>
   





<script language="javascript">



//create_floor('add');



//create_floor_dependent();



</script>



</body>



</html>



<?php $db->close();?>
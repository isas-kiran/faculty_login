<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php

$expense_type_id='';
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
	
	$sel="select * from expense where expense_id='".$record_id."'";
	$ptr_data=mysql_query($sel);
	if(mysql_num_rows($ptr_data))
	$row_expense=mysql_fetch_array($ptr_data);
	$expense_type_id=$row_expense['expense_type_id']; 
	//echo $row_expense['expense_category_id'];	
	
	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_expense['payment_mode_id']."'";
	$ptr_payment_mode1=mysql_query($sel_payment_mode1);
	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);
	$pay_mode=trim($data_payment_mode1['payment_mode']);
	
	$sel_acc_no="select account_no from bank where bank_id='".$row_expense['bank_id']."'";
	$ptr_bank_id=mysql_query($sel_acc_no);
	$data_bank_id=mysql_fetch_array($ptr_bank_id);
}
else
{
	$record_id='';
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='175'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>consumption</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
   
	<link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
	
    <script type="text/javascript">
	var  pageName = "consumption_qty";
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'dd/mm/yy'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
			
			$("#employee_id").chosen({allow_single_deselect:true});
			$("#product_id").chosen({allow_single_deselect:true});
			//$("#employee").chosen({allow_single_deselect:true});
			//$("#payment_mode").chosen({allow_single_deselect:true});
       });
	</script>
    <script type="text/javascript" src="../js/common.js"></script>
    <script type="text/javascript">
        function submitAction(action)
        {
            var chks = document.getElementsByName('chkRecords[]');
            var hasChecked = false;
            for (var i = 0; i < chks.length; i++)
            {
                if (chks[i].checked)
                {
                    hasChecked = true;
                    break;
                }
            }
            if (hasChecked == false)
            {
                alert("Please select at least one record to do operation");
                $('#selAction').val('');
                return false;
            }

            document.getElementById('formAction').value=action;
            if(action=="delete")
            {
                if(confirm("Are you sure, you want to delete selected record(s)?"))
                    document.frmTakeAction.submit();
                else
                {
                    $('#selAction').val('');
                    return false;
                }
            }
            else
                document.frmTakeAction.submit();
        }
        function redirect1(value,value1)
        {           
            //alert(value);
           // alert(value1);
            window.location.href=value+value1;
        }

        function validationToDelete(type)
        {
            if(confirm("Are you sure, you want to delete selected record(s)?"))
                return true;
            else
                return false;
        }
		/*function show_acc_no(bank_id)
		{
			
			//alert(bank_id);
			var data1="action=show_account&bank_id="+bank_id;
			//alert(data1);
				 $.ajax({
            url: "ajax.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				 document.getElementById('account_no').value=html;
			}
			});
		}*/
    </script>
    
    <script>
	/*function payment(value)
	{
		payment_mode=value.split("-")
		//alert(payment_mode[0]);
		var branch_name=document.getElementById("branch_name").value;
		if(payment_mode[0]=="cheque")
		{
			document.getElementById("chaque_details").style.display = 'block';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'none';
			
			show_bank(branch_name,"cheque")
		}
		else if(payment_mode[0]=="Credit Card")
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'block';
			show_bank(branch_name,"credit_card")
			
		}
		else if(payment_mode[0]=="paytm")
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'block';
			document.getElementById("credit_details").style.display = 'none';
			show_bank(branch_name,"paytm")
		}
		else
		{
			document.getElementById("chaque_details").style.display = 'none';
			document.getElementById("bank_details").style.display = 'none';
			document.getElementById("credit_details").style.display = 'none';
			show_bank(branch_name,"")
		}
	}
	
	function show_acc_no(bank_id)
	{
		
		//alert(bank_id);
		var data1="action=show_account&bank_id="+bank_id;
		//alert(data1);
			 $.ajax({
		url: "ajax.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			 document.getElementById('account_no').value=html;
		}
		});
	}
	*/
	 function validme()
	 {
		 
		 frm = document.save;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
	 	if(frm.product_id.value=='')
		 {
			 
			 disp_error +='Select Product\n';
			 document.getElementById(product_id).style.border = '1px solid #f00';
			 frm.product_id.focus();
			 error='yes';
	     }
		 
		 if(frm.employee_id.value=='')
		 {
			 disp_error +='Select Employee\n';
			 document.getElementById('employee_id').style.border = '1px solid #f00';
			 frm.employee_id.focus();
			 error='yes';
	     }
		 else if(frm.quantity.value=='')
		 {
			 disp_error +='Enter Product Quantity\n';
			 document.getElementById('quantity').style.border = '1px solid #f00';
			 frm.quantity.focus();
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
	
	/*function show_bank(branch_id,vals)
	{
		//alert(branch_id);
		if(document.getElementById("record_id"))
		{
			record_id= document.getElementById("record_id").value;
		}
		document.getElementById("bank_record").style.display="none";
		var bank_data="action=expense&show_bnk=1&branch_id="+branch_id+"&payment_type="+vals+"&record_id="+record_id;
		
		$.ajax({
		url: "show_bank.php",type:"post", data: bank_data,cache: false,
		success: function(retbank)
		{
			document.getElementById("bank_id").innerHTML=retbank;
			if(document.getElementById("bank_name").value)
			{
				//alert(document.getElementById("bank_name").value);
				var bank_ids=document.getElementById("bank_name").value;
				show_acc_no(bank_ids)
			}
		}
		
		});
		
		var tax_data1="show_tax=1&branch_id="+branch_id;
		$.ajax({
		url: "show_tax_type.php",type:"post", data: tax_data1,cache: false,
		success: function(rettax)
		{
			//alert(rettax);
			document.getElementById("create_type1").innerHTML='';
			//document.getElementById("res1").value=rettax;
		}
		});
	}*/
	
	function show_product(value)
	{
		admin_id= value;
		var cat_data="action=show_produts_by_employee&admin_id="+admin_id;
		$.ajax({
		url: "show_checkout_product.php",type:"post", data: cat_data,cache: false,
		success: function(retbank)
		{
			document.getElementById("create_floor").innerHTML='';
			document.getElementById("res1").value=retbank;
			setTimeout(create_floor('add'),500);
		}
		
		});
		
		//document.getElementById("product_id").disabled = false;
		
	}
	function show_product_details(value,ids)
	{
		//alert(ids);
		product_id= value;
		employee_id=document.getElementById('employee_id').value;
		var cat_data="action=show_produts_details&product_id="+product_id+"&employee_id="+employee_id;
		$.ajax({
		url: "show_checkout_product.php",type:"post", data: cat_data,cache: false,
		success: function(retbank)
		{
			if(retbank.trim()!='')
			{
				//alert(retbank);
				//document.getElementById("product_details").innerHTML=retbank;
				//document.getElementById("res1").value=retbank;
				var sep=retbank.split("###");
				var quantity=sep[0];
				var unit=sep[1];
				var measure=sep[2];
				var description=sep[3];
				var added_date=sep[4];
				//alert(quantity+'--'+unit+'--'+measure);
				$("#curr_qty"+ids).html(quantity);
				$("#curr_unit"+ids).html(unit);
				$("#curr_measure"+ids).html(measure);
				$("#curr_desc"+ids).html(description);
				$("#current_qty"+ids).val(quantity);
				$("#current_unit"+ids).val(unit);
				$("#measure_unit"+ids).val(measure);
				//$("#curr_added_date"+ids).html(added_date);
				document.getElementById("product_details"+ids).style.display="block";
			}
		}
		});
	}
	</script>
	<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
</head>
<body>
<?php include "include/header.php"; ?>
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
		<?php       if($_POST['formAction'])
					{
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT expense_id FROM ".$GLOBALS["pre_db"]."expense where expense_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {
										"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Delete','expense','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
										$query=mysql_query($insert); 
										
                                        $delete_query="delete from ".$GLOBALS["pre_db"]."expense where expense_id='".$del_record_id."'";
                                        $db->query($delete_query);                                                                                        
                                    }
                             }
                             ?>
							<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
							<script type="text/javascript">
							   // $("#statusChangesDiv").dialog();
								$(document).ready(function() {
									$( "#statusChangesDiv" ).dialog({
										modal: true,
										buttons: {
													Ok: function() { $( this ).dialog( "close" ); }
												 }
										});
									});
							</script>
                            <?php                            
                        }
                    }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT expense_id FROM ".$GLOBALS["pre_db"]."expense where expense_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Delete','expense','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert); 
										
                            $delete_query="delete from ".$GLOBALS["pre_db"]."expense where expense_id='".$del_record_id."'";
                            $db->query($delete_query);      
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
                            <script type="text/javascript">
                               // $("#statusChangesDiv").dialog();
                                $(document).ready(function() {
                                    $( "#statusChangesDiv" ).dialog({
                                        modal: true,
                                        buttons: {
                                                    Ok: function() { $( this ).dialog( "close" ); }
                                                 }
                                        });
                                    });
                            </script>
                            <?php
                        }
                    }
                    ?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
    <?php
	$errors=array(); $i=0;
    $success=0;
	if($_POST['save_changes'])
	{
		$branch_name=$_POST['branch_name'];
		$employee_id=($_POST['employee_id']) ? $_POST['employee_id'] : "";
		$product_id=( ($_POST['product_id'])) ? $_POST['product_id'] : "0";
		$total_floor=$_POST['floor'];
		if($_POST['added_date'] !=''){
			$ad_date=explode('/',$_POST['added_date'],3);
			$added_date=$ad_date[2].'-'.$ad_date[1].'-'.$ad_date[0];
		}
		else $added_date=date('Y-m-d');
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
			</td></tr><br></br>  
		<?php
		}
		else
		{
			$success=1;
			$data_record['employee_id']=$employee_id;
			$data_record['added_date'] = $added_date;
			
			//===============================CM ID for Super Admin===============
			if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
			{
				$sel_branch="select cm_id ,admin_id from site_setting where branch_name='".$branch_name."' and type='A'";
				$ptr_branch=mysql_query($sel_branch);
				$data_branch=mysql_fetch_array($ptr_branch);
				$cm_id=$data_branch['cm_id'];
				
				$branch_name1=$branch_name;
				$_SESSION['cm_id_notification']=$data_branch['cm_id'];
			}	
			else
			{
				$cm_id=$_SESSION['cm_id'];
				$branch_name1=$_SESSION['branch_name'];
			}
			$admin_id=$_SESSION['admin_id'];
			//========================================================================
			
			if($record_id)
			{
				/*$update="update expense set payment_mode_id='".$data_record['payment_mode_id']."',bank_id='".$data_record['bank_name']."',account_no='".$data_record['account_no']."',chaque_no='".$data_record['chaque_no']."',chaque_date='".$data_record['date']."',amount_wo_tax='".$data_record['amount_wo_tax']."',amount='".$data_record['amount']."',description='".$data_record['description']."',vendor_id='".$data_record['vendor']."',employee_id='".$data_record['employee']."',added_Date='".$added_date."',expense_type_id='".$data_record['expense_type']."',credit_card_no= '".$data_record['credit_card_no']."', cm_id='".$cm_id."', expense_category_id='".$expense_category."', sac_code='".$sac_code."' where expense_id='".$record_id."'";
				$ptr_update=mysql_query($update);
				
				for($x=1;$x<=$total_type1;$x++)
				{
					$_POST['tax_type'.$x];
					if($_POST['del_floor_type1'.$x]=='yes')
					{
						if($_POST['type1_id'.$x]!='' && $_POST['del_floor_type1'.$x]=='yes' )
						{
							"<br />".$delete_row = " delete from expense_tax_map where expense_tax_map_id='".$_POST['type1_id'.$x]."' ";
							$ptr_delete = mysql_query($delete_row);
						}
					}
					if($_POST['del_floor_type1'.$x] !='yes')
					{
						$data_record_tax['expense_id'] =$record_id; 
						'<br/>'.$data_record_tax['tax_type'] =$_POST['tax_type'.$x];
						$data_record_tax['tax_value'] =$_POST['tax_value'.$x];
						$data_record_tax['tax_amount'] =$_POST['tax_amount'.$x];
						if($_POST['type1_id'.$x]=='' && $_POST['tax_type'.$x] !='')
						{
							$type1_id=$db->query_insert("expense_tax_map", $data_record_tax);
						}
						else
						{
							$where_record="expense_tax_map_id='".$_POST['type1_id'.$x]."'";
							$type1_id= $_POST['type1_id'.$x];
							$db->query_update("expense_tax_map", $data_record_tax,$where_record);
						}
						unset($data_record_tax);
					}
				}
				
				"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Edit','expense','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
				$query=mysql_query($insert); 
										
				echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
				?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense added successfully</p></center></div>
						<script type="text/javascript">
							$(document).ready(function() {
								$( "#statusChangesDiv" ).dialog({
										modal: true,
										buttons: {
													Ok: function() { $( this ).dialog( "close" );}
												 }
								});
								
							});
						   setTimeout('document.location.href="expense.php";',1000);
						</script>
                        <?php
				*/
			}
			else
			{
				for($i=1;$i<=$total_floor;$i++)
				{
					$quanity=$_POST['quantity'.$i];
					$unit=$_POST['unit'.$i];
					"<br/>".$current_unit=$_POST['current_unit'.$i];
					"<br/>".$current_qty=$_POST['current_qty'.$i];
					
					$remaining_qty=abs($current_qty - $quanity);
					$remaining_unit=abs($current_unit - $unit);
					
					
					$data_record['product_id'] = $_POST['product_id'.$i];
					$data_record['quantity'] = $remaining_qty;
					$data_record['unit'] = $remaining_unit;
					$data_record['consume_qty'] =$quanity;
					$data_record['consume_unit'] =$unit;
					$data_record['measure'] =$_POST['measure_unit'.$i];
					$data_record['description'] = $_POST['description'.$i];
					$checkout_id='';
					$consumption_id='';	
					$select_qty="select * from consumption where product_id='".$data_record['product_id']."' and employee_id='".$data_record['employee_id']."' and (quantity>0 or unit>0)";
					$ptr_qty=mysql_query($select_qty);
					if(mysql_num_rows($ptr_qty))
					{ 
						$data_qty=mysql_fetch_array($ptr_qty);
						$consumption_id=$data_qty['consumption_id'];
						$checkout_id=$data_qty['checkout_id'];
						"<br/>".$update_qty="update consumption set quantity='".$remaining_qty."',unit=".$remaining_unit.",consume_qty=consume_qty+".$quanity.",consume_unit=consume_unit+".$unit." where product_id='".$data_record['product_id']."' and employee_id='".$data_record['employee_id']."'";
						$ptr_qty=mysql_query($update_qty);
					}
					else
					{
						"</br>".$insert_for_receipt = "insert into consumption (`product_id`,`quantity`,`unit`,`consume_qty`,`consume_unit`,`measure`, `description`,`employee_id`,`admin_id`, `cm_id`,`added_date`) values('".$data_record['product_id']."','".$remaining_qty."','".$remaining_unit."','".$quanity."','".$unit."','".$data_record['measure']."','".$data_record['description']."','".$data_record['employee_id']."','".$_SESSION['admin_id']."','".$cm_id."','".$added_date."')";
						$ptr_insert_receipt = mysql_query($insert_for_receipt);
						$consumption_id=mysql_insert_id();
					}
					$update_user_qty="update product_user_map set quantity_in_consumable='".$remaining_qty."' where product_id='".$data_record['product_id']."' and user_id='".$data_record['employee_id']."'";
					$ptr_user_qty=mysql_query($update_user_qty);
					
					"</br>".$insert_for_receipt = "insert into consumption_map (`consumption_id`,`checkout_id`,`product_id`,`quantity`,`unit`,`consume_qty`,`consume_unit`,`measure`,`description`,`employee_id`,`admin_id`,`cm_id`,`added_date`) values('".$consumption_id."','".$checkout_id."','".$data_record['product_id']."','".$remaining_qty."','".$remaining_unit."','".$quanity."','".$unit."','".$data_record['measure']."','".$data_record['description']."','".$data_record['employee_id']."','".$_SESSION['admin_id']."','".$cm_id."','".$added_date."')";
					$ptr_insert_receipt = mysql_query($insert_for_receipt);
					$ins_is=mysql_insert_id();
				}
			
			echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
			?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense added successfully</p></center></div>
				<script type="text/javascript">
					$(document).ready(function() {
						$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" );}
										 }
						});
						
					});
					setTimeout('document.location.href="consumption_qty.php";',1000);
				</script>
			<?php
			/*}
			else
			{
				$success=0;
				$errors[$i++]="You can't update product quantity and unit because product quantity and already 0 . You need to first checkout the product.";
				if(count($errors))
				{
						?>
					<tr><td colspan="8">
						<table align="left" style="text-align:left;" class="alert" width="100%">
						<tr><td ><strong>Please correct the following errors</strong><ul>
							<?php
							for($k=0;$k<count($errors);$k++)
									echo '<li style="text-align:left;padding-top:5px;font-size:12px" class="red_head_font">'.$errors[$k].'</li>';?>
							</ul>
						</td></tr>
						</table>
					</td></tr><br></br>  
				<?php
				}
			}*/
			
			
			
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('Expense','Add','expense','".$ins_is."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert); 
									
			
			}
		}
	}
	/*if($success==0)
	{	*/
			
	?>
<form name="save" method="post">
<table cellspacing="3" cellpadding="3" style="border:1px solid #CCC; margin-top: 15px;" width="95%">
<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
{
	?>
<tr>
<td align="center">Select Branch</td>

<td>
<?php 
$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
$query_branch = mysql_query($sel_branch);
$total_Branch = mysql_num_rows($query_branch);
echo '<table width="100%"><tr><td>';
echo ' <select id="branch_name" style="width:200px" class="input_text" name="branch_name" >';

while($row_branch = mysql_fetch_array($query_branch))
{
	$selected='';
	if($_POST['branch_name']== $row_branch['branch_name'])
	{
		 $selected='selected="selected"';
	}
	$selected_branch="select branch_name from site_setting where cm_id= '".$row_expense['cm_id']."' and type='A' ";
	$ptr_selected=mysql_query($selected_branch);
	if(mysql_num_rows($ptr_selected))
	{
		$data_cm_id=mysql_fetch_array($ptr_selected);
		if($data_cm_id['branch_name'] == $row_branch['branch_name'] )
		{
			 $selected='selected="selected"';
		}
		
	}
	?>
	<option <?php echo $selected; ?> value="<?php echo $row_branch['branch_name'];?>"><?php echo $row_branch['branch_name']; ?> 
	</option>
	<?php

}
	echo '</select>';
	echo "</td></tr></table>";
	?>
</td>
</tr>
<?php }  
else { ?>
   <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
   <?php }?>
<tr>
	<td width="15%" align="center">Date<span class="orange_font">*</span><input type="hidden" name="res1" id="res1" /></td>
	<td width="25%"><input style="width:200px" type="text" id="added_date" name="added_date" class="input_text datepicker" value="<?php if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
	<input type="hidden" name="record_id" class="input_text" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
	
	</td>
</tr> 

 <tr>
    <td width="15%" class="tr-header" align="center">Select Employee</td>
    <td width="25%"><select name="employee_id" style="width:200px" class="input_text" id="employee_id" onchange="show_product(this.value)">
    <option value="select">Select Employee</option>
    <?php
	$sel_emp="select name,admin_id from site_setting";
	$ptr_emp=mysql_query($sel_emp);
	while($data_emp=mysql_fetch_array($ptr_emp))
	{
		$selected='';
		if($data_emp['admin_id'] == $row_expense['admin_id'])
		{
			$selected='selected="selected"';
		}
		echo '<option '.$selected.' value="'.$data_emp['admin_id'].'">'.$data_emp['name'].'</option>';
	}
	
	?>
    </select></td>
 </tr>
 <!--*********************************************************Multiple*******************************************************************************--->
           
           <tr>
            <td width="15%"  class="tr-header" align="center">Select Products<span class="orange_font">*</span></td>
            <td colspan="2">
              <table  width="101%" style="border:1px solid gray; ">
                <tr>
                   <td colspan="2">
                    <table cellpadding="5" width="100%" >
                     <tr>
                       <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                    
                         <script language="javascript">
                                
                                function floors(idss)
                                {
									res1= document.getElementById("res1").value;
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td width="30%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" style="width:200px" id="product_id'+idss+'" onChange="show_product_details(this.value,'+idss+');" required>'+res1+'</select></td><td width="15%" align="center"><input type="text" name="quantity'+idss+'" id="quantity'+idss+'" /></td><td width="25%" align="left"><input type="text" name="unit'+idss+'" id="unit'+idss+'" style="width:60px" /> in <input type="text" name="measure_unit'+idss+'" id="measure_unit'+idss+'"  style="width:30px" />(Ex.ml,gm)<input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></td><td width="20%" ><textarea name="description'+idss+'" id="description'+idss+'" placeholder="write description about product use"  style="width:100%;"></textarea></td></tr><tr><td colspan="7"><div style="display:none" id="product_details'+idss+'"><table style="width:100%" align="center"><tr><td width="7%">Current Quantity : <span id="curr_qty'+idss+'"></span><input type="hidden" name="current_qty'+idss+'" id="current_qty'+idss+'" /></td><td width="10%">Current Unit : <span id="curr_unit'+idss+'"></span><input type="hidden" name="current_unit'+idss+'" id="current_unit'+idss+'" /> <span id="curr_measure'+idss+'"></span></td><td width="15%">Description. : <span id="curr_desc'+idss+'"></span></td></tr></table></div></td></tr></table></div>';
                                    document.getElementById('floor').value=idss;
                                    return shows_data;
                                }
                                
                        </script>
                       <td align="right">
                       <input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
                       <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
                      </td>
                    </tr>
                    <tr><td></td><td align="left"></td></tr>
                 </table>
                    <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">
                    <tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
                    <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
                      <tr>
                        <td colspan="6">
                          <table cellspacing="3" id="tbl" width="100%">
                            <tr>
                                <td valign="top" align="center" width="33%" >Product Name</td>
                                <td valign="top" width="15%" align="center">Quantity</td>
                                <td valign="top" width="25%" align="center" >Unit</td>
								<td valign="top" width="30%" align="center" >Description</td>
                           </tr>
                          </table>
                            <input type="hidden" name="floor" id="floor"  value="0" />
                            <div id="create_floor"></div>
                        </td>
                      </tr>
                    </table>
                    
                    </td>
                    </tr>
                </table>
             </td>
            </tr>
         
           
           <!--****************************************************************************************************************************************--->
<!--<tr>
<td width="15%" class="tr-header" align="center">Select Product</td>
<td width="25%" id="product_ids"><select name="product_id" style="width:200px" class="input_text" id="product_id" onchange="show_product_details(this.value)">
<option value="select">Select Product</option>
	<?php
	/*$sel_tel = "select * from product where 1 ".$_SESSION['where']." ";	 
	$query_tel = mysql_query($sel_tel);
	while($data=mysql_fetch_array($query_tel))
	{
		echo '<option value="'.$data['product_id'].'">'.addslashes($data['product_name']).'</option>';
	}*/
	?>
</select></td>
</tr>-->
<!--<tr>
<td width="15%"></td>
<td id="product_details"></td>
</tr>
 <tr>
    <td width="15%" class="tr-header" align="center">Quantity</td>
    <td width="25%"><input type="text" name="quantity" id="quantity" style="width:200px" class="input_text" value="<?php //if($_POST['quantity']) echo $_POST['quantity']; else echo $row_expense['quantity']; ?>"  /></td>
 </tr>
<tr>
    <td width="15%" class="tr-header" align="center">Unit</td>
    <td width="25%"><input type="text" name="unit" id="unit" style="width:200px" class="input_text" value="<?php //if($_POST['unit']) echo $_POST['unit']; else echo $row_expense['unit']; ?>"  /> in <input type="text" name="measure" id="measure" style="width:100px" class="input_text" value="<?php if($_POST['measure']) echo $_POST['measure']; else echo $row_expense['measure']; ?>"  />(Note: Ex. in gm, ml, kg)
 </tr>
 <tr>
 <td width="15%" class="tr-header" align="center">Description about product use</td>
 <td><textarea name="description" id="description" class="input_text"  style="width:300px;height:70px" ><?php //if($_POST['description']) echo $_POST['description']; else echo $row_expense['description']; ?></textarea></td>
 </tr>-->
 <tr><td align="center" colspan="2"><input type="submit" class="input_button" onclick="return validme()" name="save_changes" value="Save"  /></td></tr>
</table>
</form>
<?php
	//}
?>

	</td>
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
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
<?php
/*if($_SESSION['type']=="S" && $record_id=='')
{
	?>
    <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
}*/
/*if($record_id || $_SESSION['type']=="S")
{
	?>
    <script>
	if(document.getElementById("payment_mode"))
	{
	vals= document.getElementById("payment_mode").value;
	payment(vals);
	}
	branch_name=document.getElementById("branch_name").value;
	show_bank(branch_name);
	</script>
	<?php
}
*/
?>
<script>
/*if(document.getElementById("payment_mode"))
{
	vals= document.getElementById("payment_mode").value;
	payment(vals);
}*/
//branch_name=document.getElementById("branch_name").value;
//show_product_by_branch(branch_name);
</script>
<?php

if($record_id)
{
	?>
	<script>
	//show_category(<?php echo $row_expense['expense_category_id'] ?>)
	</script>
    <?php
}
?>
</body>
</html>

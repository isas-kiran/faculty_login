<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM product_kit where kit_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Product Kit</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>

    <!-- Multiselect -->

    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>

    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
	var pageName = "add_inventory";
    $(document).ready(function()
    {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
			$("#vendor_id").chosen({allow_single_deselect:true});//product_id1
			$("#stockiest").chosen({allow_single_deselect:true});//product_id1
			$("#course_id").chosen({allow_single_deselect:true});
     });
	 $(document).keypress(
		function(event){
		 if (event.which == '13') {
			event.preventDefault();
		  }
	});
    </script>
    <script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
<script>
var reslts='';
record_id='';
function get_product_list(vendor_id,record_id)
{
	var total_product= document.getElementsByName("total_product[]");
	totals=total_product.length;
	//alert(totals);
	if(vendor_id!=record_id)
	{
		for(i=1;i<=totals;i++)
		{
			//alert('hi')
			//document.getElementById("type1_id"+i).innerHTML='';
			document.getElementById("floor_id"+i).innerHTML='';
		}
		var total_tax=document.getElementsByName("total_tax[]").length;
		//alert(total_tax);
		for(j=1;j<=total_tax;j++)
		{
			document.getElementById("type1_id"+j).innerHTML='';
		}
		document.getElementById("create_floor").innerHTML='';
		//document.getElementById("create_type1").innerHTML='';
		document.getElementById("no_of_floor").value=0;
		//document.getElementById("price").value=0;
		//document.getElementById("discount").value=0;
		//document.getElementById("total_cost").value=0;
		//document.getElementById("amount1").value=0;
	}
	var data1="vendor_id="+vendor_id+"totals="+totals;
	 //alert(data1)
	$.ajax({
		url: "get_product_list_stockiestwise.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
			//res=html;
			document.getElementById("create_floor").innerHTML='';
			//document.getElementById("create_type1").innerHTML='';
			document.getElementById("res1").value=html;
		}
	});
}
function precisionRound(number, precision) {
  var factor = Math.pow(10, precision);
  return Math.round(number * factor) / factor;
}


mail1=Array();
<?php
$sel_sms_cnt="select * from sms_mail_configuration_map where previlege_id='136' ".$_SESSION['where']."";
$ptr_sel_sms=mysql_query($sel_sms_cnt);
$tot_num_rows=mysql_num_rows($ptr_sel_sms);
$i=0;
while($data_sel_cnt=mysql_fetch_array($ptr_sel_sms))
{
	"<br/>".$sel_act=" select email from site_setting where admin_id='".$data_sel_cnt['staff_id']."' ".$_SESSION['where']."";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$data_cnt=mysql_fetch_array($ptr_cnt);
		?>
		mail1[<?php echo $i; ?>]='<?php echo  $data_cnt['email'];?>';
		<?php
		$i++;
	}
}
if($_SESSION['type']!='S')
{
	"<br/>".$sel_act="select contact_phone,email from site_setting where type='S'";
	$ptr_cnt=mysql_query($sel_act);
	if(mysql_num_rows($ptr_cnt))
	{
		$j=$tot_num_rows;
		while($data_cnt=mysql_fetch_array($ptr_cnt))
		{
			?>
			mail[<?php echo $j; ?>]='<?php echo  $data_cnt['email'];?>';
			<?php
			$j++;
		}
	}
}
"<br/>".$sel_mail_text="select email_text from previleges where privilege_id='136'";
$ptr_mail_text=mysql_query($sel_mail_text);
if($tot_mail_text=mysql_num_rows($ptr_mail_text))
{
	$data_mail_text=mysql_fetch_array($ptr_mail_text);
	?>
	email_text_msg='<?php echo  urlencode($data_mail_text['email_text']);?>';
	<?php
}
?>

function validme()
{
	 frm = document.jqueryForm;
	 error='';
	 disp_error = 'Clear The Following Errors : \n\n';
	 /*if(frm.vendor_id.value=='')
	 {
		 disp_error +='Select Vender\n';
		 document.getElementById('vendor_id').style.border = '1px solid #f00';
		 frm.vendor_id.focus();
		 error='yes';
	 }*/
	 /*var fields = $("input[name='requirment_id[]']").serializeArray(); 

	 if (fields.length == 0) 

	  { 

		disp_error +='Select Product\n';

		 

		error='yes';

	  } */
	 /*if(frm.discount.value=='')
	 {
		 disp_error +='Enter Discount\n';
		 document.getElementById('discount').style.border = '1px solid #f00';
		 frm.discount.focus();
		 error='yes';
	 }*/
	 /* if(frm.payment_mode.value=='')
	 {
			 disp_error +='Please select Payment Mode \n';
			 document.getElementById('payment_mode').style.border = '1px solid #f00';
			 frm.payment_mode.focus();
			 error='yes';
	 }*/
	 if(error=='yes')
	 {
		 alert(disp_error);
		 return false;
	 }
	 else
	 {
		 //return send();
	 }
	// return true;
 }
function delete_product(id,types)
{
	if(confirm('Do you really want to delete record'))
	{
		$('#product_id'+id).replaceWith(function(){
			return $('<select name="product_id'+id+'" id="product_id'+id+'" style="width:140px"><option value=""></option></select>', {html: $(this).html()});
		});
		
	
		$('#sin_product_qty'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_qty'+id+'" id="sin_product_qty'+id+'" value="" />', {html: $(this).html()});
		});
		$('#sin_product_total'+id).replaceWith(function(){
			return $('<input type="text" name="sin_product_total'+id+'" id="sin_product_total'+id+'" value="" />', {html: $(this).html()});
		});
		
		
		if(types=='floor')
		{
			$('#floor_id'+id).hide();
			$('#del_floor'+id).val('yes');
			//showUser();
			//calculte_total_cost()
		}
	}
}
function select_stockiest(branch_name)
{
	var data1="action=kit_stockiest&branch_name="+branch_name;	
	$.ajax({
	url: "get_stockiest.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html !='')
		{
			//alert(html);
			document.getElementById("stockiest_id").innerHTML=html;
			$("#stockiest").chosen({allow_single_deselect:true});
		}
	}
	});
	
	/*var id='Vendor';
	var branch_name= branch_name;
	var data1="action=show_data&action_page=sales_product&id="+id+'&branch_name='+branch_name;
	$.ajax({
	url: "ajax_customer_type_data.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		$('#show_type').html(html);
		// document.getElementById('show_type').value=html;
		//$("#realtxt").chosen({allow_single_deselect:true});
		$("#customer_id").chosen({allow_single_deselect:true});
		
	}
	});*/
}
</script> 
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>-->
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>
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
				$added_date=date('Y-m-d');
				$stockiest=$_POST['stockiest']; 
				$course_id=( ($_POST['course_id'])) ? $_POST['course_id'] : "0";
				$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
				
				if($_SESSION['type']=='S' || $_SESSION['type']=='LD' || $_SESSION['type']=='Z')
				{
					$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
					$ptr_branch=mysql_query($sel_branch);
					$data_branch=mysql_fetch_array($ptr_branch);
					$cm_id=$data_branch['cm_id'];
					$branch_name1=$branch_name;
					$data_record['cm_id']=$cm_id;
					$cm_id1=$cm_id;
				}	
				else
				{
					$data_record['cm_id']=$_SESSION['cm_id'];
					$branch_name1=$_SESSION['branch_name'];
					$data_record['cm_id']=$_SESSION['cm_id'];
					$cm_id1=$_SESSION['cm_id'];
				}
				$total_floor=$_POST['floor'];
				
				
				$kit_ids="";
				if($record_id)
				{
					$kit_ids="and kit_id !=".$record_id."";
				}
				
				$sel_mob_no="select kit_id from product_kit where course_id ='".$course_id."' ".$kit_ids." and cm_id='".$cm_id1."'";
				$ptr_mob_no=mysql_query($sel_mob_no);
				if(mysql_num_rows($ptr_mob_no))
				{
					$success=0;
					$errors[$i++]="Course Kit Already Exist. ";
				}
				if(count($errors))
				{
					?>
					<tr>
						<td> <br></br>
						<table align="left" style="text-align:left;" class="alert">
						<tr><td ><strong>Please correct the following errors</strong><ul>
								<?php
								for($k=0;$k<count($errors);$k++)
										echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
								</ul>
						</td></tr>
						</table>
						</td>
					</tr>   <br></br>  
					<?php
				}
				else
				{
					$success=1;
					$data_record['course_id']=$course_id;
					$data_record['stockiest_id']=$stockiest;
					$data_record['admin_id']=$_SESSION['admin_id'];
					$total_floor=$_POST['no_of_floor'];
					$total_type1=$_POST['total_type1'];
					if($record_id)
					{
						$where_record="kit_id='".$record_id."'";
						$db->query_update("product_kit", $data_record,$where_record);
						for($z=1;$z<=$total_floor;$z++)
						{
							"Floor- ". $_POST['del_floor'.$z]."<br />";
							"<br />floor_id- ".$_POST['floor_id'.$z];
							if($_POST['del_floor'.$z]=='yes')
							{
								if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )
								{
									"<br/>".$delete_row ="delete from product_kit_map where kit_map_id='".$_POST['floor_id'.$z]."' ";
									$ptr_delete = mysql_query($delete_row);
								}
							}
							if($_POST['del_floor'.$z] !='yes')
							{
								$data_record_service['kit_id'] =$record_id; 
								$data_record_service['product_id'] =$_POST['product_id'.$z];
								$data_record_service['sin_product_qty'] =$_POST['sin_product_qty'.$z];
								
								if($_POST['floor_id'.$z]=='' && $_POST['product_id'.$z] !='')
								{
									$type1_id=$db->query_insert("product_kit_map", $data_record_service);
									
									/*$sel_qty="select quantity,product_name from product where product_id='".$_POST['product_id'.$z]."' ";
									$ptr_qty=mysql_query($sel_qty);
									$data_qty=mysql_fetch_array($ptr_qty);
									$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$z]);
									$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$z]."'";
									$query_prod_qty=mysql_query($update_prod_qty);*/
								}
								else
								{
									$where_record="kit_map_id='".$_POST['floor_id'.$z]."'";
									$floor_id= $_POST['floor_id'.$z];
									$db->query_update("product_kit_map", $data_record_service,$where_record);
									
									/*$sel_qty="select quantity,product_name from product where product_id='".$_POST['product_id'.$z]."' ";
									$ptr_qty=mysql_query($sel_qty);
									$data_qty=mysql_fetch_array($ptr_qty);
									$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$z]);
									$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$z]."'";
									$query_prod_qty=mysql_query($update_prod_qty); */
								}
								unset($data_record_service);
							}
						}
						$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_product_kit','Edit','Kit Edit','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);
						echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
					}
					else
					{
						$data_record['added_date'] =$added_date;
						$record_id=$db->query_insert("product_kit", $data_record);
						for($i=1;$i<=$total_floor;$i++)
						{
							$data_record_service['kit_id'] =$record_id; 
							$data_record_service['product_id']=( ($_POST['product_id'.$i])) ? $_POST['product_id'.$i] : "0";
							$data_record_service['sin_product_qty']=( ($_POST['sin_product_qty'.$i])) ? $_POST['sin_product_qty'.$i] : "0";
							
							$customer_service_id=$db->query_insert("product_kit_map", $data_record_service);
							/*$sel_qty="select quantity from product where product_id='".$_POST['product_id'.$i]."' ";
							$ptr_qty=mysql_query($sel_qty);
							$data_qty=mysql_fetch_array($ptr_qty);
							$total_quantity=intval($data_qty['quantity'])+intval($_POST['sin_product_qty'.$i]);
							$update_prod_qty="update product set quantity='".$total_quantity."' where product_id='".$_POST['product_id'.$i]."'";
							$query_prod_qty=mysql_query($update_prod_qty); */
						}
						
						"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_product_kit','Add','add kit','".$record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);
							
						if($payment_type_val=="online")
							$status='pending';
						else
							$status='paid';
						
						$chaque_date_exp=explode('/', $chaque_date);
						$sep_check_date=$chaque_date_exp[2].'-'.$chaque_date_exp[1].'-'.$chaque_date_exp[0];
						//------send notification on Sale voucher--------------------
							$notification_args['reference_id'] =$record_id;
							$notification_args['on_action'] = 'product_purchase';
							$notification_status = addNotifications($notification_args);
						//---------------------------------------------------------------
						//=========================================================================
						?><div id="statusChangesDiv" title="Record added"><center><br><p>Record added successfully</p></center></div>
							<script type="text/javascript">
								$(document).ready(function() {
									$( "#statusChangesDiv" ).dialog({
											modal: true,
											buttons: {
														Ok: function() { $( this ).dialog( "close" );}
													 }
									});
								});
							setTimeout('document.location.href="manage_product_kit.php";',1000);
							</script>
						<?php
					}
				}
			}
			if($success==0)
			{
				?>
				<tr><td>
				<form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return validme()">
				<table border="0" cellspacing="15" cellpadding="0" width="100%">
				<tr>
				<td colspan="3" class="orange_font">* Mandatory Fields</td>
					<input type="hidden" name="res1" id="res1" />
					<input type="hidden" name="res_tax" id="res_tax" />
					<input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
				</tr>
				<!--<tr>
					<td width="20%">Date<span class="orange_font">*</span></td>
					<td width="49%"><input type="text" id="added_date" name="added_date" class="input_text datepicker" value="<?php //if($_POST['added_date']) echo $_POST['added_date']; else if($row_record['added_date']!=''){$arrage_date= explode('-',$row_record['added_date'],3);echo $arrage_date[2].'/'.$arrage_date[1].'/'.$arrage_date[0];}else{echo date("d/m/Y");}?>" />
					</td>
				</tr> -->
				<?php if($_SESSION['type']=='S')
                {
                	?>
					<tr>
						<td>Select Branch</td>
						<td>
						<?php 
						if($_REQUEST['record_id'])
						{
							$sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A' ";
							$ptr_query=mysql_query($sel_cm_id);
							$data_branch_nmae=mysql_fetch_array($ptr_query);
						}
						$sel_branch = "SELECT * FROM branch where 1 and status='Active' order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>'; 
						echo '<select id="branch_name" name="branch_name" onchange="select_stockiest(this.value)" >';
						echo '<option value="">Select Branch</option>';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
							</option>
							<?php
						}
						echo '</select>';
						echo "</td></tr></table>";
						?>
						</td>
					</tr>
					<?php 
				}
				else 
				{ 
					?>
                	<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                	<?php 
				}?> 
           		<tr>
            	<td>Select Course<span class="orange_font">*</span></td>
                <td>
                	<select name="course_id" id="course_id" class="input_select" style="width:200px;">
                   	<option value="">Select Course Name</option>
                   	<?php
				   	$course_category = " select category_name,category_id from course_category ";
				   	$ptr_course_cat=mysql_query($course_category);
				   	while($data_cat=mysql_fetch_array($ptr_course_cat))
				   	{
						echo "<optgroup label='".$data_cat['category_name']."'>";
						$get="SELECT course_id,course_name FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
						$myQuery=mysql_query($get);
						while($row = mysql_fetch_assoc($myQuery))
						{
							$selected_course='';
							if($row_record['course_id']==$row['course_id'])
							{
								$selected_course='selected="selected"';
							}
							?> 
							<option <?php echo $selected_course; ?> value="<?php echo $row['course_id']?>" <?php if (isset($course_interested) && $course_interested == $row['course_name']) echo "selected";?>> <?php echo $row['course_name'] ?></option>
							<?php 
						}
						echo " </optgroup>";
					}?>
                   	</select>
            	</td>
           	</tr>
		   	<tr>
            	<td>Select Stockiest <span class="orange_font">*</span></td>
                <td id="stockiest_id">
                <select name="stockiest" id="stockiest" class="input_select" style="width:200px;" onChange="get_product_list(this.value)">
                	<option value="">Select Stockiest</option>
                   	<?php
				   	$sql_vendor ="select name, admin_id from site_setting where 1 and type='ST' ".$_SESSION['where']." order by admin_id asc";
					$ptr_vendor = mysql_query($sql_vendor);
					while($data_vendor = mysql_fetch_array($ptr_vendor))
					{ 
						$selecteds = '';
						if($data_vendor['admin_id']==$row_record['stockiest_id'])
							$selecteds = 'selected="selected"';
						else
							$selecteds = '';	
						echo "<option value='".$data_vendor['admin_id']."' ".$selecteds.">".$data_vendor['name']."</option>";
					}
                   	?>
                </select>
            	</td>
          	</tr>
			<?php 
            $rowSQL = mysql_query("SELECT MAX(kit_id) as max FROM `product_kit`" );
            $row = mysql_fetch_array( $rowSQL );
            $largestNumber = $row['max']+1;
            ?>
        	<!--===========================================================NEW TABLE START===================================-->   
			<tr>
            	<td width="10%">Select Product<span class="orange_font">*</span></td>
            	<td colspan="2">
                <table  width="100%" style="border:1px solid gray; ">
                    <tr>
                    <td colspan="2">
                    <table cellpadding="5" width="100%" >
                    <tr>
                    <?php
					if($record_id =='')
					{
						?>
                        <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1"  onKeyUp="create_floor();" value="0" />
                        <?php 
					}?>
                    <script language="javascript">
					function floors(idss)
					{
						res= document.getElementById("res1").value;

						var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td><div id="prod_list"></div></td></tr><tr><td width="15%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" id="product_id'+idss+'" style="width:400px"><option value="">Select Product</option>'+res+'</select></td><td width="5%" align="center"><input type="text" name="sin_product_qty'+idss+'" id="sin_product_qty'+idss+'" style=" width:60px" /></td><td valign="top" width="1%" align="center"><input type="hidden" name="total_product[]" id="total_product'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /></tr><tr><td colspan="7"><div style="display:none" id="product_details'+idss+'"><table style="width:100%" align="center"><tr><td width="10%">Price : <span id="price_desc'+idss+'"></span></td><td width="10%">Brand : <span id="brand'+idss+'"></span></td><td width="10%">Unit : <span id="unit_desc'+idss+'"></span><span id="measure_desc'+idss+'"></span></td><td width="70%">Product Desc.: <span id="description_desc'+idss+'"></span></td></tr></table></div></td></tr></table></div>';
						document.getElementById('floor').value=idss;
						return shows_data;
					}
					</script>
						<td align="right"><input type="button"  name="Add" class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
						<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
					</td></tr>
                    <tr><td></td><td align="left"></td></tr>
                </table> 
                <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
    				<tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
    				<tr>
                        <td colspan="7">
                        	<table cellspacing="3" id="tbl" width="100%">
                        		<tr>
                        			<td valign="top" width="18%" align="center">Product Name</td>
                                   
                        			<td valign="top" width="7%"  align="center">Product Qty </td>
                        			
                        			<!--<td valign="top" width="2%"  align="center">acton</td>-->
                        		</tr>
                        		<tr>
                           			<td colspan="7">
									<?php
									if($record_id!='')
									{
                            			$select_exc = "select * from product_kit_map where kit_id='".$record_id."' order by kit_map_id asc ";
                            			$ptr_fs = mysql_query($select_exc);
                            			$t=1;
                            			$total_comision= mysql_num_rows($ptr_fs);
                            			$total_conditions= mysql_num_rows($ptr_fs);
                            			while($data_exclusive = mysql_fetch_array($ptr_fs))
                            			{ 
                                			$slab_id= $data_exclusive['kit_map_id'];
											?> 
											<div class="floor_div" id="floor_id<?php echo $t; ?>">
											<table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">
												<tr>
													<td valign="top" width="38%" align="center">
													<select name="product_id<?php echo $t; ?>" id="product_id<?php echo $t; ?>" style="width:400px">
                                                    <option value="">Select Product</option>
													<?php
													$sql_dest = " select product_id, admin_id from product where admin_id='".$row_record['stockiest_id']."' ";
													$ptr_edes = mysql_query($sql_dest);
													while($data_dist = mysql_fetch_array($ptr_edes))
													{
														$sel_tel = "select product_id,product_name,price from product where product_id='".$data_dist['product_id']."' ".$_SESSION['where']." order by product_id asc";	 
														$query_tel = mysql_query($sel_tel);
														if($total=mysql_num_rows($query_tel))
														{
															$data=mysql_fetch_array($query_tel);
															$selected='';
															if($data_exclusive['product_id'] ==$data['product_id'] )
															{
																$selected='selected="selected"';
															}
															echo '<option value="'.$data['product_id'].'" '.$selected.'>'.$data['product_name'].'</option>';
														}
													}
													?>
													</select>
													</td>
													<td width="11%" align="center"><input type="text"name="sin_product_qty<?php echo $t; ?>" id="sin_product_qty<?php echo $t; ?>" style=" width:100px" value="<?php echo $data_exclusive['sin_product_qty'] ?>" onKeyUp="getDiscount(<?php echo $t; ?>)"/></td>
													<td valign="top" width="6%" align="center">
													<?php
													if($record_id)
													{
													?>
														<input type="hidden" name="total_product[]" id="total_product<?php echo $t; ?>" />
														<input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['kit_map_id'] ?>" />
														<input type="button" title="Delete Options(-)" onClick="delete_product(<?php echo $t; ?>,'floor');" class="delBtn" name="del">
														<input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" />
													<?php
													} ?>   
													</td>
												</tr>
											</table>
											</div>
                                            <script>
												$("#product_id<?php echo $t; ?>").chosen({allow_single_deselect:true});
											</script>
											<?php
											$t++;
                         				}
									}
                       					?>
                                    </td>
                        		</tr> 
                        	</table>
                       		<input type="hidden" name="floor" id="floor"  value="0" />
                        	<div id="create_floor"></div>
                    	</td>
                     </tr>
                </table>
                <?php
				if($record_id)
				{
					?>
						<input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />
						<input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />
					<?php 
				} ?> 
                </td>
             </tr>
         </table>
      </td>
   </tr>
       <!--============================================================END TABLE=========================================-->
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Kit" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
        </td></tr>

<?php
}   ?>
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
<script>
/*if(document.getElementById("branch_name").value)
{
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
}*/
</script>
<?php
if($record_id!='')
{
	?>
    <script>
	vendor_id =document.getElementById("stockiest").value;
	//alert(vendor_id);
	get_product_list(vendor_id,vendor_id);
    //create_floor('add');
	//branch_name1 =document.getElementById("branch_name").value;
	//alert(branch_name1)
	//show_bank(branch_name1);
	</script>
    <?php
}
?>
</body>
</html>
<?php $db->close();?>
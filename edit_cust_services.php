<?php include 'inc_classes.php';?>

<?php include "admin_authentication.php";?>

<?php include "../classes/thumbnail_images.class.php";?>

<?php

if($_REQUEST['record_id'])

{

    $record_id=$_REQUEST['record_id'];

    $sql_record= "SELECT * FROM customer_service where customer_service_id='".$record_id."'";

    if(mysql_num_rows($db->query($sql_record)))

        $row_record=$db->fetch_array($db->query($sql_record));

    else

		$record_id=0;

		

	$select_cost="SELECT cust_name,cust_id FROM customer where cust_id='".$row_record['customer_id']."'";

	$query_cust=mysql_query($select_cost);

	$fetch_cust=mysql_fetch_array($query_cust); 

	

	$sel_payment_mode1="select payment_mode from payment_mode where payment_mode_id='".$row_record['payment_mode_id']."'";

	$ptr_payment_mode1=mysql_query($sel_payment_mode1);

	$data_payment_mode1=mysql_fetch_array($ptr_payment_mode1);

	$pay_mode=trim($data_payment_mode1['payment_mode']);

	

	$sel_acc_no="select account_no from bank where bank_id='".$row_record['bank_id']."'";

	$ptr_bank_id=mysql_query($sel_acc_no);

	$data_bank_id=mysql_fetch_array($ptr_bank_id);

	

}

/*if($record_id && $_REQUEST['deleteThumbnail'])

{

    $update_news="update servies set photo='' where service_id='".$record_id."'";

    echo $update_events;

    $db->query($update_news);



    if($row_record['photo'] && file_exists("../static_Page_photo/".$row_record['photo']))

        unlink("../static_Page_photo/".$row_record['photo']);

    $row_record=$db->fetch_array($db->query($sql_record));

}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?>Customer Service</title>
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
        });
</script>
<script>
 function calculte_other_cost(val)
 {
	 var total=isNaN(parseInt(val * 2)) ? 0 :(val * 2)
	 $('#other_cost').val(total);
	 var other_cost=document.getElementById("other_cost").value;
	 var total1=isNaN(parseInt((+val) + (+other_cost))) ? 0 :parseInt((+val) + (+other_cost))
	 $('#total_cost').val(total1);
	 var total_cost=document.getElementById("total_cost").value;
	 var total2=isNaN(parseInt(total_cost * 4)) ? 0 :parseInt(total_cost * 4)
	 $('#service_price').val(total2);
 }
</script> 
<script>
function getMembership(cust_id)
{
	var data1="customer_id="+cust_id;	
	//alert(data1);
        $.ajax({
            url: "get_membership.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				
				if(html.trim() =='')
				{
					document.getElementById('membership_id').style.display="none";
					document.getElementById('memb_discount').value=0;
				}
				else
				{
					document.getElementById('membership_id').style.display="block";
					var sep_val=html.split("-");
					var memb_name= sep_val[0].trim();
					var memb_disc= sep_val[1].trim();
					//alert(memb_disc);
					if(memb_disc !="undefined" || memb_disc !='')
					{
						document.getElementById('memb_name').innerHTML=memb_name;
						document.getElementById('memb_disc').innerHTML=memb_disc;
						document.getElementById('memb_discount').value=memb_disc;
						
					}
				}
				if(document.getElementsByName("total_services[]").length >1)
				showUser();	
            }
            });
}

function getprice(values,val_idss)
  {
	//alert(val_idss);
	var service_id=document.getElementById('service_id'+val_idss).value;
	//alert(service_id)			
	var data1="service_id="+service_id;	
	//alert(data1);
        $.ajax({
            url: "get_service_price.php", type: "post", data: data1, cache: false,
            success: function (html)
            {
				//alert(html);
				service_split=html.split("-");
				document.getElementById("sin_service_price"+val_idss).value=service_split[0];
				document.getElementById("sin_service_time"+val_idss).value=service_split[1];
				document.getElementById("sin_service_total"+val_idss).value=service_split[0];
				var exit_disc=document.getElementById("sin_service_disc"+val_idss).value = 0;
            }
            });
			
			var exit_disc='';
			if(values !="")
			{		
				document.getElementById("sin_service_price"+val_idss).disabled = false;
				document.getElementById("sin_service_disc"+val_idss).disabled = false;
				document.getElementById("sin_service_time"+val_idss).disabled = false;
				document.getElementById("sin_service_total"+val_idss).disabled = false;
				document.getElementById("staff_id"+val_idss).disabled = false;
			}
			else
			{
				document.getElementById("sin_service_price"+val_idss).disabled = true;
				document.getElementById("sin_service_disc"+val_idss).disabled = true;
				document.getElementById("sin_service_time"+val_idss).disabled = true;
				document.getElementById("sin_service_total"+val_idss).disabled = true;
				document.getElementById("staff_id"+val_idss).disabled = true;
			}
			setTimeout(showUser,800);
			//getDiscount(exit_disc,val_idss)
  }
function getDiscount(disc,idss)
{
	service_price=parseInt(document.getElementById("sin_service_price"+idss).value);
	discount= (service_price*disc)/100;
	total_price=service_price-discount;
	document.getElementById("sin_service_total"+idss).value=total_price;
	showUser();
}
function show_bank(branch_id)
{
	var bank_data="show_bnk=1&branch_id="+branch_id;
	//alert(branch_id);
	$.ajax({
	url: "show_bank.php",type:"post", data: bank_data,cache: false,
	success: function(retbank)
	{
		document.getElementById("bank_id").innerHTML=retbank;
	}
	});
	var tax_data="show_tax=1&branch_id="+branch_id;
	$.ajax({
	url: "show_tax.php",type:"post", data: tax_data,cache: false,
	success: function(rettax)
	{
		var taxes=rettax.split('-');
		service_tax= taxes[0];
		installment_tax= taxes[1];
		document.getElementById("service_tax_id").innerHTML=service_tax;
		document.getElementById("service_taxes").value=service_tax;
	}
	});
}
</script>
<script>
function payment(value)
{
	payment_mode=value.split("-")
	//alert(payment_mode[0]);
	if(payment_mode[0]=="cheque")
	{
		 document.getElementById("chaque_details").style.display = 'block';
		 document.getElementById("bank_details").style.display = 'block';
		 document.getElementById("credit_details").style.display = 'none';
	}
	else if(payment_mode[0]=="Credit Card")
	{
		 document.getElementById("chaque_details").style.display = 'none';
		 document.getElementById("bank_details").style.display = 'block';
		 document.getElementById("credit_details").style.display = 'block';
	}
	else
	{
		 document.getElementById("chaque_details").style.display = 'none';
		 document.getElementById("bank_details").style.display = 'none';
		 document.getElementById("credit_details").style.display = 'none';
	}
}
function show_acc_no(bank_id)
{
	var data1="action=show_account&bank_id="+bank_id;
	$.ajax({
	url: "ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		 document.getElementById('account_no').value=html;
	}
	});
}
function show_time(cut_time)
{
	
	if(cut_time >12)
	{
		alert("Start time is not greater than 12");
		document.getElementById("start_time").value=12;
	}
	else
	{
		times1=Number(document.getElementById('times').value);
		hours= Number(times1/60)
		end_time=Number(hours) + Number(cut_time);
		//alert(end_time);
		if(end_time>12)
		{
			var new_time=end_time-12;
			document.getElementById("end_time").value=new_time;
		}
		else
		{
			document.getElementById("end_time").value=end_time;
		}
	}
}
function show_exist_time(emp_id)
{
	var date=document.getElementById("date").value;
	var start_time = document.getElementById("start_time").value;
	var curr_date = document.getElementById("date").value;
	var data1="emp_id="+emp_id+"&start_time="+start_time+"&curr_date="+curr_date;
	//alert(data1);
	$.ajax({
	url: "get_exit_time.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html.trim());
		if(html.trim() !='')
		{
			alert("This Time Schedule is already exist for this Staff,Please Select another Start time");
			document.getElementById("start_time").value='';
			document.getElementById("end_time").value='';
			document.getElementById("employee_id").selectedIndex = "0";
		}
	}
	});
}

</script>
<!--<link href="js/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css">
<script src="js/jquery.flexdatalist.min.js"></script>
<script>
$('.flexdatalist').flexdatalist({
	minLength: 1
});
</script>-->
<script>
function myFunction(form)
{
	 if(document.getElementById("date").value == "")
	   {
		  alert("Please Enter Date"); // prompt user
		  document.getElementById("date").style.borderColor  = "red";
		  return false;
	   }
	   if(document.getElementById("start_time").value == "")
	   {
		  alert("Please Enter Start Time"); // prompt user
		  document.getElementById("start_time").style.borderColor  = "red";
		  return false;
	   }
	   if(document.getElementById("end_time").value == "")
	   {
		  alert("Please Enter End Time"); // prompt user
		  document.getElementById("end_time").style.borderColor  = "red";
		  return false;
	   }
	   if(document.getElementById("payment_mode").value == "")
	   {
			//alert(document.getElementById("payment_mode").value)
			alert("Please select Payment Mode"); 
			document.getElementById("payment_mode").style.borderColor  = "red";
			return false;
	   }
	   if(document.getElementById("employee_id").value == "")
	   {
		  alert("Please select Employee"); // prompt user
		  document.getElementById("employee_id").style.borderColor  = "red";
		  return false;
	   }
	   var i,
	   chks = document.getElementsByName('requirment_id[]');
	   for (i = 0; i < chks.length; i++)
	   {
		   	if (chks[i].checked)
			{
			   return true;
			}
			else
			{

        		alert('Please select Service');
        		return false;
    		}

  		}
}



</script>
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

    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php"; ?></td>

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

							$branch_name=$_POST['branch_name'];

                            $customer_id=$_POST['customer_id'];

                            $service_price=$_POST['service_price'];  

							$discount_price=$_POST['discount_price'];    

							$service_tax=$_POST['service_tax']; 

							$total_cost=$_POST['total_cost']; 

							$employee_id=$_POST['employee_id'];

							$service=$_POST['requirment_id'];

							$date=trim($_POST['date']);

							$start_time=trim($_POST['start_time']);

							$end_time=trim($_POST['end_time']);

							

							$bank_name='';

							$chaque_no='';

							$chaque_date='';

							$credit_card_no='';

							

							$payment_mode=$_POST['payment_mode'];

							$sep=explode("-",$payment_mode);

							$payment_mode_id=$sep[1];

							$amount=$_POST['amount'];
							if($payment_mode_id !="1" || $payment_mode_id !="3" ||$payment_mode_id !="5")
							{
								$bank_name=$_POST['bank_name'];
								$chaque_no=$_POST['chaque_no'];
								$credit_card_no=$_POST['credit_card_no'];
								$chaque_date=$_POST['cheque_date'];
							}
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_id;
								$data_record['cm_id']=$cm_id;
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
								$data_record['cm_id']=$_SESSION['cm_id'];
							}

							$total_floor=$_POST['floor'];
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

                                $data_record['customer_id'] =$customer_id;

                                $data_record['service_price'] =$service_price;

								$data_record['discount_price'] =$discount_price;

								$data_record['service_tax'] =$service_tax;

								$data_record['total_cost'] =$total_cost;

								$data_record['staff_id'] =$employee_id;

								$data_record['added_date']=date('Y-m-d H:i:s');

								$data_record['date'] =$date;

								$data_record['start_time'] =$start_time;

								$data_record['end_time'] =$end_time;

								

								$data_record['payment_mode_id'] =$payment_mode_id;

								$data_record['chaque_no'] =$chaque_no;

								$data_record['chaque_date'] =$chaque_date;
								$data_record['credit_card_no'] =$credit_card_no;
								$data_record['bank_id'] =$bank_name;
								$data_record['amount'] =$amount;
								$total_floor=$_POST['floor'];

								if($record_id)
								{
									$delete_service="delete from customer_service_map where customer_service_id='".$record_id."' ";
									$query_delete=mysql_query($delete_service);
									for($i=0;$i<count($service);$i++)
									{
											 '<br/>'.$ins_service1="insert into customer_service_map (`customer_service_id`,`customer_id`,`service_id`) values ('".$record_id."','".$customer_id."','".$_POST['requirment_id'][$i]."')";
											$ptr_ins1=mysql_query($ins_service1);
									}
									$where_record=" customer_service_id='".$record_id."'";
									$db->query_update("customer_service", $data_record,$where_record);
									echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';

								}
								else
								{
									$record_id=$db->query_insert("customer_service", $data_record);
									for($i=1;$i<=$total_floor;$i++)
									{
											$data_record_service['customer_service_id'] =$record_id; 
											$data_record_service['customer_id'] =$customer_id; 
											$data_record_service['service_id'] =$_POST['service_id'.$i];
											$data_record_service['service_price'] =$_POST['sin_service_price'.$i];
											$data_record_service['discount'] =$_POST['sin_service_disc'.$i];
											$data_record_service['total_price'] =$_POST['sin_service_total'.$i];
											$data_record_service['service_time'] =$_POST['sin_service_time'.$i];
											$data_record_service['admin_id'] =$_POST['staff_id'.$i];
											$customer_service_id=$db->query_insert("customer_service_map", $data_record_service);
											
											/* $insert_img="insert into customer_service_map (`customer_service_id`,`customer_id`,`service_id`) values('".$record_id."','".$customer_id."','".$data_record_service['service_id']."')";
											$ptr_img=mysql_query($insert_img);*/
											
									}
									/*for($i=0;$i<count($service);$i++)

									{

											echo $ins_service="insert into customer_service_map (`customer_service_id`,`customer_id`,`service_id`) values ('".$record_id."','".$customer_id."','".$_POST['requirment_id'][$i]."')";

											$ptr_ins=mysql_query($ins_service);

									}*/

									echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';

								}

							}

                        }

                        if($success==0)

                        {

                        

                        ?>

            <tr><td>

        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data" onSubmit="return myFunction(this)">

	<table border="0" cellspacing="15" cellpadding="0" width="100%">

              <tr>

                <td colspan="3" class="orange_font">* Mandatory Fields</td>

              </tr>

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

						$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 

						$query_branch = mysql_query($sel_branch);

						$total_Branch = mysql_num_rows($query_branch);

						echo '<table width="100%"><tr><td>'; 

						echo ' <select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';

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

				<?php } ?>
            <!--  <tr>
              <td width="20%" valign="top">Customer Name <span class="orange_font"> *</span></td>
              <td>
               <input  placeholder='Customer Name' value="<?php if($_POST['save_changes']) echo $_POST['cust_name']; else echo $fetch_cust['cust_name'];?>"  class='flexdatalist input_text' onChange='selectCountry(this.value)'  data-min-length='1'  multiple='multiple' list='cust_name'  type='text' id="cust_name" required/>
                <datalist id="cust_name">-->
					<?php
                   /* $query ="SELECT cust_name,cust_id FROM customer WHERE 1 ";
                        $result = mysql_query($query);
                        while($fetch_query=mysql_fetch_array($result))
                                  {
                                      echo '<option value="'.$fetch_query['cust_name'].'">'.$fetch_query['cust_name'].'</option>';
                                  }*/
                    ?>
               <!-- </datalist>
              </td>
           </tr>-->
              <tr>
               <td width="20%" valign="top">Select Customer<span class="orange_font">*</span></td>
               <td width="70%">
               <select name="customer_id" id="customer_id" style="width:200px;" required onChange="getMembership(this.value)">
                 <option value="">Select Customer</option> 
                  <?php  
                    $sql_cust = "select cust_name, cust_id from customer order by cust_id asc";
                    $ptr_cust = mysql_query($sql_cust);
                    while($data_cust = mysql_fetch_array($ptr_cust))
                    { 
                            $selecteds = '';
                            if($data_cust['cust_id']==$row_record['customer_id'])
                            $selecteds = 'selected="selected"';	
                        echo "<option value='".$data_cust['cust_id']."' ".$selecteds.">".$data_cust['cust_name']."</option>";

                    }
                    ?>

                </select>

                <td width="10%"></td>

              </tr>
            <tr>

                <td width="20%" valign="top" colspan="3">

                <div id="membership_id" style="display:none">

                <table>

					<tr>
					<td width="36%">Membership Details</td>
					<td width="25%">Name :<span id="memb_name"> </span><br />Discount(in %) : <span id="memb_disc"></span></td>
					</tr>
                </table><input type="hidden" name="memb_discount" id="memb_discount" value="">

                </div>

                </td>

             </tr> 

			<tr>
            	<td width="10%">Select Service<span class="orange_font">*</span></td>
            	<td colspan="2">
                <table  width="100%" style="border:1px solid gray; ">
                    <tr>
                    <td colspan="2">
                    <!--===========================================================NEW TABLE START===================================-->
                    <table cellpadding="5" width="100%" >
                     <tr>
                     <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                     
                     <script language="javascript">
                                
                                function floors(idss)
                                {
                                    var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="10%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="service_id'+idss+'" id="service_id'+idss+'" style="width:140px" onChange="getprice(this.value,'+idss+')"><option value="">Select Service</option><?php
									$sel_tel = "select service_id,service_name,service_price from servies order by service_id asc";	 
									$query_tel = mysql_query($sel_tel);
									if($total=mysql_num_rows($query_tel))
									{
										while($data=mysql_fetch_array($query_tel))
										{
											echo '<option value="'.$data['service_id'].'">'.$data['service_name'].'</option>';
										}
									}
									 ?>
									 </select></td><td width="8%" align="center"><input type="text" disabled="disabled" name="sin_service_price'+idss+'" id="sin_service_price'+idss+'" style=" width:100px" /></td><td width="8%" align="center"><input type="text" name="sin_service_disc'+idss+'" id="sin_service_disc'+idss+'" onkeyup="getDiscount(this.value,'+idss+')"  disabled="disabled" style=" width:100px" /></td><td width="8%" align="center"><input type="text" disabled="disabled" name="sin_service_total'+idss+'" id="sin_service_total'+idss+'" style=" width:100px"></td><td width="8%" align="center"><input type="text" disabled="disabled" name="sin_service_time'+idss+'" id="sin_service_time'+idss+'" style=" width:100px" /></td><td width="10%"><select name="staff_id'+idss+'" disabled="disabled" id="staff_id'+idss+'" style="width:90%"><option value="">Select Staff</option><?php
									$sel_staff = "select admin_id,name from site_setting order by admin_id asc";	 
									$query_staff = mysql_query($sel_staff);
									if($total_staff=mysql_num_rows($query_staff))
									{
										while($data=mysql_fetch_array($query_staff))
										{
											echo '<option value="'.$data['admin_id'].'">'.$data['name'].'</option>';
										}
									}
									 ?>
									 </select></td><input type="hidden" name="total_services[]" id="total_services'+idss+'" /><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                    document.getElementById('floor').value=idss;
                                    return shows_data;
                                }
                                
                        </script>
                       <td align="right"><input type="button"  name="Add"s class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
    <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
    </td></tr>
                            <tr><td>  </td><td align="left"></td></tr>
                    </table> 
                    <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
    <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
    <tr>
                        <td colspan="6">
                        <table cellspacing="3" id="tbl" width="100%">
                        <tr>
                        <td valign="top" width="8%" align="center">Service Name</td>
                        <td valign="top" width="6%"  align="center">Price</td>
                        <td valign="top" width="6%"  align="center">Discount (in %)</td>
                        <td valign="top" width="6%"  align="center">Total Price</td>
                        <td valign="top" width="6%"  align="center">Time(in Min.)</td>
                        <td valign="top" width="6%"  align="center">Staff</td>
                         </tr></table>
                         <input type="hidden" name="floor" id="floor"  value="0" />
                        <div id="create_floor"></div>
                    </td></tr></table>
                    <!--============================================================END TABLE=========================================-->
                    </td>
                    </tr>
                </table>
             </td>
         </tr>

             <tr>

                <td width="20%" valign="top">Service Price</td>

                <td width="70%"><input type="text"  class=" input_text" name="service_price" id="service_price" readonly="readonly" value="<?php if($_POST['service_price']) echo $_POST['service_price']; else echo $row_record['service_price'];?>" /></td> 

                <td width="10%"></td>

             </tr>

            <tr>

            <td colspan="4">

            <div id="memb_discount_div">

            <table width="100%">

            	<tr>

                <td width="20%" valign="top">Membership Discount Price</td>

                <td width="72%"><input type="text" class=" input_text" name="discount_price" id="discount_price" onBlur="showUser()" value="<?php if($_POST['discount_price']) echo $_POST['discount_price']; else echo $row_record['discount_price'];?>" /></td> 

                <td width="5%"></td>

                </tr>

            </table>

            </div>

            </td>

             </tr>

             <tr>      

                  <td width="20%" class="heading">Service Tax <?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} else echo '<span id="service_tax_id"></span>';  ?>%<span class="orange_font">*</span></td><input type="hidden" id="service_taxes" value="<?php if($_SESSION['type']!='S'){ echo $_SESSION['service_tax'];} ?>"  />

    

                  <td><input type="text" class=" input_text" readonly="readonly" name="service_tax" id="service_tax"  value="<?php if($_POST['service_tax']) echo $_POST['service_tax']; else echo $row_record['service_tax'];?>" /></td>

    

            </tr>

            <tr>

                <td width="20%" valign="top">Total Cost<span class="orange_font">*</span></td>

                <td width="70%"><input type="text" readonly="readonly" class=" input_text" name="total_cost" id="total_cost" value="<?php if($_POST['save_changes']) echo $_POST['total_cost']; else echo $row_record['total_cost'];?>" /></td> 

                <td width="10%"></td>

            </tr>

            <tr>

            	<td width="15%" valign="top">Date<span class="orange_font">*</span></td>

             	<td width="70%"><input type="text"  class=" input_text datepicker" name="date" id="date" value="<?php if($_POST['date']) echo $_POST['date']; else echo $row_record['date'];?>" /></td> 

              	<td width="10%"></td>

            </tr>

            <tr>

            	<td width="15%" valign="top">Start time<span class="orange_font">*</span></td>

             	<td width="70%"><input type="text"  class=" input_text" style="width:50px" name="start_time" id="start_time" onKeyPress="show_time(this.value)" maxlength="2" value="<?php if($_POST['start_time']) echo $_POST['start_time']; else echo $row_record['start_time'];?>" /><select name="time_prime_from"><option value="am">AM</option><option value="pm">PM</option></select></td> 

              	<td width="10%"><input type="hidden" name="times" id="times" value="" /></td>

            </tr>

            <tr>

            	<td width="15%" valign="top">End Time<span class="orange_font">*</span></td>

             	<td width="70%"><input type="text"  class=" input_text" style="width:50px" name="end_time" id="end_time" maxlength="2" value="<?php if($_POST['end_time']) echo $_POST['end_time']; else echo $row_record['end_time'];?>" /><select name="time_prime_to"><option value="am">AM</option><option value="pm">PM</option></select></td> 

              	<td width="10%"></td>

            </tr>

            <tr>

                <td class="tr-header">Select Payment Mode<span class="orange_font">*</span></td>

                <td width="25%"><select name="payment_mode" id="payment_mode" onChange="payment(this.value)" >

                <option value="">--Select--</option>

                <?php

                $sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";

                $ptr_payment_mode=mysql_query($sel_payment_mode);

                while($data_payment=mysql_fetch_array($ptr_payment_mode))

                {

                    $selected='';

                    if($data_payment['payment_mode_id'] == $row_record['payment_mode_id'])

                    {

                        $selected='selected="selected"';

                    }

                    echo '<option '.$selected.' value="'.$data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';

                }

                

                ?>

                </select></td>

             </tr>

             <tr>

             <td colspan="2">

             <div id="bank_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque') echo 'style="display:block"'; else echo ' style="display:none"'; ?>>

             <table width="100%">

             <tr>

             <td width="21%" class="tr-header" >Bank Name</td>

             <td>

             

            <?php 

            if($_SESSION['type'] !="S")

            {

            ?>

             <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">

             <option value="">--Select--</option>

             <?php

             $sle_bank_name="select bank_id,bank_name from bank ".$_SESSION['where_cm_id'].""; 

             $ptr_bank_name=mysql_query($sle_bank_name);

             while($data_bank=mysql_fetch_array($ptr_bank_name))

             {

                $selected='';

                if($data_bank['bank_id'] == $row_record['bank_id'])

                {

                    $selected='selected="selected"';

                }

                 echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';

             }

             ?>

             </select>

              <?php

             }

             ?>

          

            <?php 

            if($record_id !='')

            {

            ?>

            <div id="bank_record">

                 <select name="bank_name" id="bank_name" onChange="show_acc_no(this.value)">

                 <option value="">--Select--</option>

                 <?php

                 $sle_bank_name="select bank_id,bank_name from bank where cm_id='".$row_record['cm_id']."'"; 

                 $ptr_bank_name=mysql_query($sle_bank_name);

                 while($data_bank=mysql_fetch_array($ptr_bank_name))

                 {

                    $selected='';

                    if($data_bank['bank_id'] == $row_record['bank_id'])

                    {

                        $selected='selected="selected"';

                    }

                     echo '<option '.$selected.' value="'.$data_bank['bank_id'].'">'.$data_bank['bank_name'].'</option>';

                 }

                 ?>

                 </select>

                 </div>

              <?php

             }

             ?>

             <div id="bank_id"></div>

             </td>

             </tr>

             <tr>

             <td class="tr-header" width="21%">Account No</td>

             <td><input type="text" name="account_no" readonly="readonly" id="account_no" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $data_bank_id['account_no']; ?>" /></td>

             </tr>

             </table>

             </div>

             

             <div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>

             <table width="100%">

             <tr>

             <td class="tr-header" width="21%">Enter Chaque No</td>

             <td><input type="text" name="chaque_no" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_record['chaque_no']; ?>" /></td>

             </tr>

             <tr>

             <td class="tr-header" width="15%">Enter Chaque Date</td>

             <td><input type="text" name="cheque_date" id="cheque_date" class="datepicker" value="<?php if($_POST['cheque_date']) echo $_POST['cheque_date']; else echo $row_record['chaque_date']; ?>"  /></td>

             </tr>

             </table>

             </div>

             <div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>

             <table width="100%">

             <tr>

             <td class="tr-header" width="21%">Enter Credit Card No</td>

             <td><input type="text" name="credit_card_no" id="credit_card_no" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_record['credit_card_no']; ?>" /></td>

             </tr>

             </table>

             </div>

             

             <tr>

                <td width="" class="tr-header">Amount<span class="orange_font">*</span></td>

                <td width=""><input type="text" readonly="readonly" name="amount" id="amount" value="<?php if($_POST['amount']) echo $_POST['amount']; else echo $row_record['amount']; ?>"  /></td>

             </tr>

            <tr>

            	<td width="" class="tr-header" align="">Select Employee<span class="orange_font">*</span></td>

            	<td><select name="employee_id" id="employee_id" onChange="show_exist_time(this.value)">

             	<option value="">--Select--</option>

             	<?php

             	$sle_name="select admin_id,name from site_setting ".$_SESSION['where_cm_id'].""; 

             	$ptr_name=mysql_query($sle_name);

             	while($data_name=mysql_fetch_array($ptr_name))

             	{

                	$selected='';

                	if($data_name['admin_id'] == $row_record['staff_id'])

                	{

                	    $selected='selected="selected"';

                	}

                	echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';

             	}

             	?>

            	</select>

            	</td>

            </tr>

            <tr>

                  <td>&nbsp;</td>

                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Service" name="save_changes"  /></td>

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
<div id="footer"><?php require("include/footer.php");?></div>
<!--footer end-->
<?php
if($_SESSION['type']=="S" && $record_id=='')
{
	?>
     <script>
	branch_name =document.getElementById("branch_name").value;
	//alert(branch_name);
	show_bank(branch_name);
	</script>
    <?php
}
if($record_id)
{
	?>
    <script>
	customer_id= document.getElementById("customer_id").value;
	getMembership(customer_id);
	service_priceed= document.getElementById("service_price").value;
	showUser();
</script>
<?php
}
?>
<script language="javascript">
create_floor('add');
</script>

<script>
function showUser()
{
	//alert("hiiii");
	contact='';
	var total_service= document.getElementsByName("total_services[]");
	totals=total_service.length;
	for(i=1; i<=totals;i++)
	{
		//alert(i);
		servicesss_idddd=Number(document.getElementById("sin_service_total"+i).value);
		//alert(servicesss_idddd);
		if(servicesss_idddd!='')
		{
			contact =Number(contact)+Number(servicesss_idddd);
			//alert(contact);
		}
	}
	document.getElementById('service_price').value=contact;
	
	var service_price=contact;
	var membership_discount= parseInt(document.getElementById('memb_discount').value);
	if(membership_discount !=0)
	{
		var discount_price= service_price * (membership_discount/100);
	}
	else
	{
		var discount_price= 0;
	}
	if(discount_price !=0)
	{
		var total_discount_price= parseInt(service_price - discount_price);
		document.getElementById('memb_discount_div').style.display="block";
	}
	else
	{
		var total_discount_price=service_price;
		document.getElementById('memb_discount_div').style.display="none";
	}
	document.getElementById('discount_price').value=total_discount_price;
	var service_tax= document.getElementById('service_taxes').value;
	var disc_price= document.getElementById('discount_price').value;
	var service_tax__price= parseInt(disc_price * (service_tax/100));
	document.getElementById('service_tax').value=service_tax__price;
	var total_cost =  parseInt(disc_price) +  parseInt( service_tax__price);
	document.getElementById('total_cost').value=total_cost;
	document.getElementById('amount').value=total_cost;
	//alert(discount_price);
}
</script>

</body>

</html>

<?php $db->close();?>
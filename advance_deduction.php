<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
 $page_name = "advance deduction";
 
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM pr_staff_advance_salary_management where staff_advance_salary_id='".$record_id."'";
		//$_SESSION['sql_articles']=$sql_record;
    if(mysql_num_rows($db->query($sql_record)))
   		$row_record=$db->fetch_array($db->query($sql_record));
	
    $sql_record1= "SELECT * FROM pr_advance_installments where staff_advance_salary_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record1)))
   		$row_record1=$db->fetch_array($db->query($sql_record1));
    else
    $record_id=0;
	
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='205'";
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
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?> Advance Deduction
 </title>
<?php include "include/headHeader_gst.php";?>
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
       /* jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });*/
       
    </script>
<!--<script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->

<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script>
	$(document).ready(function()
        {
			$("#year").chosen({allow_single_deselect:true});
			$("#month").chosen({allow_single_deselect:true});
			$("#advance_type").chosen({allow_single_deselect:true});
			$("#staff_id").chosen({allow_single_deselect:true});
			<?php 
			if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
			{
				?>
				$("#branch_name").chosen({allow_single_deselect:true});
				<?php
			}
			?>
		});
		
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
		
		
		function payment(value)
		{
			payment_mode=value.split("-")
			//alert(payment_mode[0]);
			var branch_name=document.getElementById("branch_name").value;
			if(payment_mode[0]=="cheque")
			{
				document.getElementById("chaque_details").style.display = 'block';
				document.getElementById("bank_details").style.display = 'block';
				document.getElementById("credit_details").style.display = 'none';
				document.getElementById("paytm_details").style.display = 'none';
				
				show_bank_for_payment_mode(branch_name,"cheque")
			}
			else if(payment_mode[0]=="Credit Card")
			{
				document.getElementById("chaque_details").style.display = 'none';
				document.getElementById("bank_details").style.display = 'block';
				document.getElementById("credit_details").style.display = 'block';
				document.getElementById("bank_ref_no").style.display = 'none';
				document.getElementById("paytm_details").style.display = 'none';
				show_bank_for_payment_mode(branch_name,"credit_card")
					
			}
			else if(payment_mode[0]=="paytm")
			{
				document.getElementById("chaque_details").style.display = 'none';
				document.getElementById("bank_details").style.display = 'none';
				document.getElementById("credit_details").style.display = 'none';
				document.getElementById("bank_ref_no").style.display = 'none';
				document.getElementById("paytm_details").style.display = 'block';
				show_bank_for_payment_mode(branch_name,"paytm")
			}
			else if(payment_mode[0]=="online")
			{
				document.getElementById("bank_ref_no").style.display = 'block';
				document.getElementById("chaque_details").style.display = 'none';
				document.getElementById("bank_details").style.display = 'block';
				document.getElementById("credit_details").style.display = 'none';
				document.getElementById("paytm_details").style.display = 'none';
				show_bank_for_payment_mode(branch_name,"online")
			}
			else
			{
				document.getElementById("chaque_details").style.display = 'none';
				document.getElementById("bank_details").style.display = 'none';
				document.getElementById("credit_details").style.display = 'none';
				document.getElementById("bank_ref_no").style.display = 'none';
				document.getElementById("paytm_details").style.display = 'none';
				show_bank_for_payment_mode(branch_name,"")
			}
		}	
		
		function show_bank_for_payment_mode(branch_id,vals)
		{
			if(document.getElementById("record_id"))
			{
				record_id= document.getElementById("record_id").value;
			}
			else
			{
				document.getElementById("bank_record").style.display="none";
			}
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
		}
		</script>

		<script type="text/javascript">
        $(document).ready(function()
        {            
			$('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:'dd/mm/yy', showButtonPanel: true, closeText: 'Clear'});
			$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
			{
				res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
			}
        });
        </script>

<script type="text/javascript">
$(document).ready(function() {
    $("#dropdown").change(function() 
	{		
        var selVal = $(this).val();
        $("#textboxDiv").html('');
		var inst =parseInt (document.getElementById('installment_on').value);
		var no_inst = inst/selVal ;
		
        if(selVal > 0)
		{
            for(var i = 1; i<= selVal; i++) 
			{
                $("#textboxDiv").append('<table width="100%"><tr><td width="34%" class="heading">Installment '+i+' </span></td><td width="40%" colspan="2"><input type="text" class="input_text installment_input installment_inp_'+i+'" alt="'+i+'" name="installments[]" id="date_class1'+i+'" value="'+parseFloat(no_inst).toFixed(2)+'" /></td><td><input type="text" name="installment_date[]" class="datepicker date_class'+i+'" id="date_class'+i+'" placeholder="installment date " ></td></tr></table>');
            }
			$('#dropdown').removeClass("obrderclass"); 
			$(".installment_input").blur(function()
            {
				//alert('here');
                var installment_on = $("#installment_on").val();
                if(installment_on)
                installment_on = parseInt(installment_on);
			
				//alert(installment_on);
                var installments = $("#dropdown").val();
                var current_number = parseInt($(this).attr('alt'));
                var current_value = parseInt($(this).val());
                var prev_total = 0;
                for(var p=1;p<current_number;p++)
                {
                    var input_value = parseInt($(".installment_inp_"+p).val());
                    prev_total = prev_total + input_value;
                }
                if(current_value<=installment_on-prev_total)
                {
                    prev_total = prev_total + current_value;
                    if(prev_total<installment_on)
                    {
                        var final_total_installment = installment_on-prev_total;
                        var final_installment_term = parseFloat((final_total_installment/(installments-current_number)).toFixed(2));
                    }
                    else
                        final_installment_term=0;
                    for(var u=current_number+1;u<=installments;u++)
                    {
                        $(".installment_inp_"+u).val(final_installment_term);
                    }
                    var last_vale_select = $("#dropdown option:last-child").val();
                    if(current_number==last_vale_select-1)
                    {
                        $(".installment_inp_"+last_vale_select).prop('disabled',true);
                    }
           		}
            	else
            	{
            		$(this).val('');
                	for(var u=current_number+1;u<=installments;u++)
                	{
                		$(".installment_inp_"+u).val('');
                	}
                	alert("Invalid input.");
            	}
        	}); 
        }
		else
		$('#dropdown').addClass("obrderclass"); 
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
    });
	
	$(".installment_input").blur(function()
	{
		var installment_on = $("#installment_on").val();
		if(installment_on)
		installment_on = parseInt(installment_on);
	
		//alert(installment_on);
		var installments = $("#dropdown").val();
		var current_number = parseInt($(this).attr('alt'));
		var current_value = parseInt($(this).val());
		var prev_total = 0;
		for(var p=1;p<current_number;p++)
		{
			var input_value = parseInt($(".installment_inp_"+p).val());
			prev_total = prev_total + input_value;
		}
		if(current_value<=installment_on-prev_total)
		{
			prev_total = prev_total + current_value;
			if(prev_total<installment_on)
			{
				var final_total_installment = installment_on-prev_total;
				var final_installment_term = parseFloat((final_total_installment/(installments-current_number)).toFixed(2));
			}
			else
				final_installment_term=0;
			for(var u=current_number+1;u<=installments;u++)
			{
				$(".installment_inp_"+u).val(final_installment_term);
			}
			var last_vale_select = $("#dropdown option:last-child").val();
			if(current_number==last_vale_select-1)
			{
				$(".installment_inp_"+last_vale_select).prop('disabled',true);
			}
		}
		else
		{
			$(this).val('');
			for(var u=current_number+1;u<=installments;u++)
			{
				$(".installment_inp_"+u).val('');
			}
			alert("Invalid input.");
		}
	}); 
});


function get_staff(branch_name)
{
	var prod_data="action=get_staff_for_advance_deduction&branch_name="+branch_name;
	//alert(prod_data);
	$.ajax({
		url:"ajax.php",type:"post",timeout: 5000,data:prod_data,cache:false,
		success: function(prod_data)
		{
			$("#staff_name").html(prod_data);
			$("#staff_id").chosen({allow_single_deselect:true});
		}
	});
}
</script>
<style type = "text/css">
	#feedback
	{
		line-height:;
	}
	.obrderclass{ border:1px solid #f00}
</style>  
<script type="text/javascript">


	//===============================Validatio of form start============================
	function validme()
	{
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
		
		//================= Installment Date Validation===================

		no_of_installments = $("#dropdown").val();
		if(no_of_installments)
		{
			x=0;
			dates_array= new Array();
			for(t=1;t<=no_of_installments;t++)
			{
				if($(".date_class"+t).val()=='')
				{
					disp_error += t+' Installment date  is not added \n'; 
					error='yes';
				}
				else
				{
					var new_inst_date=$(".date_class"+t).val().split("/");
					inst_date=new_inst_date[2]+"-"+new_inst_date[1]+"-"+new_inst_date[0];
					var targets = Date.parse(inst_date);
					now = new Date;
					today_date = now.getTime();
					var milliseconds = today_date; // some mock date
						dates_array[x]=targets;
				   		$(".date_class"+t).removeClass("obrderclass");
				   		x++;
				}
			}
			///=========== Installemnt date less than greater than validation
			error_found_asc = '';
			s=0
			for(j=0;j<dates_array.length;j++)
			{
				for(k=j+1;k<dates_array.length;k++)
				{
					if(dates_array[j]>dates_array[k])//dates_array[j]>=dates_array[k]
					{
						error_found_asc ='yes';
						s=k;
						break;
					}
				}
			}
			
			if(error_found_asc=='yes')
			{
				disp_error +='Installment date not in incresing order \n'; 
				$(".date_class"+s).addClass("obrderclass"); 
				error='yes';
			}
				//=================================================================
		}
			if($('#installment_on').val() !=0 && $('#dropdown').val()==0)
			{
				disp_error +='Installment is not selected Or Paid type is wrong \n'; 
				error='yes';
				$('#dropdown').addClass("obrderclass"); 
				frm.numDep.focus();
			}
			else
			$('#dropdown').removeClass("obrderclass"); 
			//================= END Installmetn Dat4 Validation=========================
		if(error=='yes')
		{
			alert(disp_error);
			return false;
		}
		else
		{
			return send();
		}
		
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

	function isNumber(evt) 
	{
    	evt = (evt) ? evt : window.event;
    	var charCode = (evt.which) ? evt.which : evt.keyCode;
    	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }

    return true;

}
function isSpclChar(id)
{
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>? ";
	vals = document.getElementById(id).value;
	for (var i = 0; i < vals.length; i++) 
	{
		if (iChars.indexOf(vals.charAt(i)) != -1) 
		{
			return 'yes';
		}

    }
}  

</script>
<script type="text/javascript">
function submitform()
{
	document.customerData.submit();
}
</script>
</head>



<body>

<?php include "include/header.php";?>

<!--info start-->

<div id="info">

<!--left start-->

<?php include "include/menuLeft.php"; ?>

</div>

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
				$month=( ($_POST['month'])) ? $_POST['month'] : "";
                $year=( ($_POST['year'])) ? $_POST['year'] : "";
				$employee_id=( ($_POST['staff_id'])) ? $_POST['staff_id'] : "";
				$installment_on=( ($_POST['installment_on'])) ? $_POST['installment_on'] : "";
				$first_installment=( ($_POST['numDep'])) ? $_POST['numDep'] : "";
				$advance_type=( ($_POST['advance_type'])) ? $_POST['advance_type'] : "";
				$branch_name=( ($_POST['branch_name'])) ? $_SESSION['branch_name'] : "";
				
				$sel_att_id="select attendence_id from site_setting where admin_id='".$employee_id."' ";
				$ptr_att_id=mysql_query($sel_att_id);
				$data_att_id=mysql_fetch_array($ptr_att_id);
				$staff_id=$data_att_id['attendence_id'];
				
				if($month =="")
				{
						$success=0;
						$errors[$i++]="Select Month";
				}
				if($employee_id=="")
				{
						$success=0;
						$errors[$i++]="Select Staff";
				}
				if($installment_on =="")
				{
						$success=0;
						$errors[$i++]="Enter Installemnt On";
				}
				  if($first_installment =="")
				{
						$success=0;
						$errors[$i++]="Select Number Of Installemnts";
				}
				  if($advance_type =="")
				{
						$success=0;
						$errors[$i++]="Select Advance Type";
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
												
					$data_record['month']=$month;
					$data_record['year']=$year;
					$data_record['staff_id']=$staff_id;
					$data_record['employee_id']=$staff_id;
					$data_record['advance_payment']=$_POST['installment_on'];
					$data_record['des']=$_POST['des'];
					$data_record['advance_type']=$advance_type;
					$data_record['added_date'] =date("Y-m-d H:i:s");
					$data_record['admin_id'] =$_SESSION['admin_id'];
					$data_record['no_of_installments']=$_POST['numDep'];
					$data_record['admin_id']=$_SESSION['admin_id'];
					$data_record['added_date'] = date("Y-m-d");
				   // $branch_name=$_SESSION['branch_name'];
					
					//===============================CM ID for Super Admin===============
					if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
					{
						$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
						$ptr_branch=mysql_query($sel_branch);
						$data_branch=mysql_fetch_array($ptr_branch);
						$cm_id=$data_branch['cm_id'];
						$branch_name=$data_branch['branch_name'];
						$data_record['cm_id']=$cm_id;
						$data_record_invoice['cm_id']=$cm_id;
						$data_record_invoice1['cm_id']=$cm_id;
						
					}	
					else
					{
						$cm_id=$_SESSION['cm_id'];//New add
						$data_record['cm_id']=$_SESSION['cm_id'];
						$branch_name=$_SESSION['branch_name'];
						$data_record_invoice['cm_id']=$_SESSION['cm_id'];
						$data_record_invoice1['cm_id']=$_SESSION['cm_id'];
					}
					//====================================================================
					
					if($record_id)
					{
						$where_record="staff_advance_salary_id='".$record_id."'";       
						$db->query_update("pr_staff_advance_salary_management", $data_record,$where_record); 
						//echo $row_record['no_of_installments'].">>>>>>>>>>>>>".$data_record['no_of_installments'];
						
						$delete_inst="DELETE FROM `pr_advance_installments` WHERE ".$where_record."  ";
						$del_query=mysql_query($delete_inst);
						//$delete_inst1="DELETE FROM `installment_history` WHERE ".$where_record."  ";
						//$del_query=mysql_query($delete_inst1);
						//echo ">>>>>>>>>>>>>>>".$data_record['no_of_installments'];
						if($data_record['no_of_installments'] !=0)
						{
							for($i=1;$i<=$data_record['no_of_installments'];$i++)
						 	{
								$installment_date='';
								if($_POST['installments'][$i-1] !='')
								{
									$sep_date =explode('/',$_POST['installment_date'][$i-1]);
									$installment_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
									$insert_query ="insert into pr_advance_installments(i_amount, i_date,status,staff_advance_salary_id,inst_amount) values('".$_POST['installments'][$i-1]."','$installment_date','Not Paid','$record_id','".$_POST['installments'][$i-1]."' ) ";
								$insert_ptr = mysql_query($insert_query);
								}
							}   
						}
						echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
					}
					else
					{
						$pm=explode("-",$_POST['payment_mode']);
						$p_mode=$pm['1'];
						$added_date=date('Y-m-d');	
						$insert_for_receipt = "insert into expense (`expense_category_id`,`expense_type_id`,`payment_mode_id`,`bank_id`,`account_no`,`chaque_no`,`chaque_date`,`amount`,`amount_wo_tax`,`total_price`,`description`,`employee_id`,`added_date`,`cm_id`) values('137','176','".$p_mode."','".$_POST['bank_name']."','".$_POST['account_no']."','".$_POST['cheque_no']."','".$_POST['date']."','".$_POST['installment_on']."','".$_POST['installment_on']."','".$_POST['installment_on']."','".$_POST['des']."','".$employee_id."','".$added_date."','".$cm_id."')";
						$ptr_insert_receipt = mysql_query($insert_for_receipt);	 	
						
						$data_record_invoice['month']=$month;
						$data_record_invoice['year']=$year;
						$data_record_invoice['staff_id']=$staff_id;
						$data_record_invoice['employee_id']=$employee_id;
						$data_record_invoice['advance_payment']=$_POST['installment_on'];
						$data_record_invoice['added_date'] =date("Y-m-d H:i:s");
						$data_record_invoice['admin_id'] =$_SESSION['admin_id'];
						$data_record_invoice['no_of_installments']=$first_installment;
						$data_record_invoice['admin_id']=$_SESSION['admin_id'];
						$data_record_invoice['des']=$_POST['des'];
						$data_record_invoice['advance_type']=$_POST['advance_type'];
						$data_record_invoice['branch_name']=$_SESSION['branch_name'];
						$staff_id_in=$db->query_insert("pr_staff_advance_salary_management", $data_record_invoice);  
													
						$data_record_invoice1['month']=$month;
						$data_record_invoice1['year']=$year;
						$data_record_invoice1['staff_id']=$staff_id;
						$data_record_invoice1['employee_id']=$employee_id;
						$data_record_invoice1['amount']=$_POST['installment_on'];
						$data_record_invoice1['payable_amount']=0;
						$data_record_invoice1['remaining_amount']=$_POST['installment_on'];
						$data_record_invoice1['added_date'] =date("Y-m-d H:i:s");
						$data_record_invoice1['admin_id'] =$_SESSION['admin_id'];
					  
						$data_record_invoice1['status']='Paid';
						
						$data_record_invoice1['advance_type']=$_POST['advance_type'];
						$data_record_invoice1['branch_name']=$_SESSION['branch_name'];
						$data_record_invoice1['staff_advance_salary_id']=$staff_id_in;
						$staff_id=$db->query_insert("pr_staff_advance_invoice", $data_record_invoice1);  
					   
						if($data_record_invoice['no_of_installments'] !=0)
						{
							for($i=1;$i<=$data_record_invoice['no_of_installments'];$i++)
							{
								$installment_date='';
								if($_POST['installments'][$i-1] !='')
								{
									//echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>";
									$sep_date =  explode('/',$_POST['installment_date'][$i-1]);
									$installment_date = $sep_date[2].'-'.$sep_date[1].'-'.$sep_date[0];
								 	"<br />".  $insert_query = "  insert into pr_advance_installments(i_amount, i_date,staff_advance_salary_id,status,inst_amount) values('".$_POST['installments'][$i-1]."','$installment_date','$staff_id_in','Not Paid','".$_POST['installments'][$i-1]."' ) ";
									$insert_ptr = mysql_query($insert_query);

									//$insert_query1 = "  insert into installment_history(enroll_id, course_id, installment_amount, installment_date, status, invoice_id) values('$student_id','".$data_record['course_id']."','".$_POST['installments'][$i-1]."','$installment_date','not paid','$student_id_in') ";
									//   $insert_ptr1 = mysql_query($insert_query1);
								}
							}   
						}
						"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('enrollment','Add','".$name."','".$student_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);  
						echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
					}
				}
			}
			if($success==0)
			{
				?>
            	<tr>
                    <td>
        			<form name="jqueryForm" method="post" id="jqueryForm" enctype="multipart/form-data" onsubmit="return validme();">
					<table border="0" cellspacing="15" cellpadding="0" width="100%">
                        <tr>
                            <td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
                            <input type="hidden" name="record_id" id="record_id" value="<?php if($_REQUEST['record_id']) { echo $record_id ;} ?>"  />
                        <tr>
              				<td width="20%"class="orange_font">* Date Format should be [ DD/MM/YYYY ]</td>
						</tr>	
						<?php 
                        if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                        {
                            ?>
                            <tr>
                                <td width="20%">Select Branch<span class="orange_font">*</span></td>
                                <td width="40%">
                                    <?php 
                                    if($_REQUEST['record_id'])
                                    {
                                        $sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A'";
                                        $ptr_query=mysql_query($sel_cm_id);
                                        $data_branch_nmae=mysql_fetch_array($ptr_query);
                                    }
                                    $sel_branch="SELECT * FROM branch where 1 order by branch_id asc ";	 
                                    $query_branch=mysql_query($sel_branch);
                                    $total_Branch=mysql_num_rows($query_branch);
                                    echo'<table width="100%"><tr><td>'; 
                                    echo'<select style="width:25%;" id="branch_name" name="branch_name" onchange="get_staff(this.value);">';
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
                            <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']?>"> 
                           <?php 
                        }?>
                        <tr>
                            <td width="20%">
                            <?php
                            echo 'Select Year</td><td>';
                            $nxt=date('Y')-1;
                            $yearArray = range($nxt, 2030);
                            echo ' <select required id="year" name="year" style="width:100px;">';
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
                            </td>
                        </tr>
                        <tr>
                            <td>Select Month</td>
                            <td>
                                <?php
                                $monthArray = range(1, 12);
                                echo '<select id="month" name="month" >';
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
                               <?php }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <table id="staff_name" width="100%">
                                    <tr>
                                        <td width="22%">Select Staff<span class="orange_font">*</span></td>
                                        <td width="42%">
                                            <select id="staff_id" name="staff_id" onChange="getmonthdays(this.value);" >
                                                <option value="">Select Staff</option>
                                                <?php  
                                                if($record_id)
                                                {
                                                    $sel_staff="select admin_id,attendence_id,name from site_setting where 1 AND attendence_id!='' order by attendence_id asc";	 
                                                    $query_staff = mysql_query($sel_staff);
                                                    if($total_staff=mysql_num_rows($query_staff))
                                                    {
                                                        while($data=mysql_fetch_array($query_staff))
                                                        {
                                                            ?>
                                                            <option <?php if($data['admin_id']==$row_record['employee_id']) echo "selected"; else echo "";  ?> value="<?php echo $data['admin_id']; ?>" ><?php echo $data['name']; ?></option>
                                                            <?php 
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <input type="hidden" name="today" id="today" value="<?php echo date('d/m/Y'); ?>"  /> 
                        <tr>
                            <td width="20%">Advance Type<span class="orange_font">*</span></td>
                            <td width="40%">
                                <select id="advance_type" name="advance_type" >
                                    <option value="">Select Advance Type</option>
                                    <option <?php if($row_record['advance_type']=="Other Advance"){ echo "selected"; } else { echo ""; } ?> value="Other Advance">Other Advance</option>
                                    <option <?php if($row_record['advance_type']=="Salary Advance"){ echo "selected"; } else { echo ""; } ?> value="Salary Advance">Salary Advance</option>
                    
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">Select Payment Mode<span class="orange_font">*</span></td>
                            <td width="25%">
                                <select name="payment_mode" style="width:200px" class="input_text" id="payment_mode" onchange="payment(this.value)">
                                <option value="select">--Select--</option>
                                <?php
                                $sel_payment_mode="select payment_mode,payment_mode_id from payment_mode";
                                $ptr_payment_mode=mysql_query($sel_payment_mode);
                                while($data_payment=mysql_fetch_array($ptr_payment_mode))
                                {
                                    $selected='';
                                    if($data_payment['payment_mode_id'] == $row_expense['payment_mode_id'])
                                    {
                                        $selected='selected="selected"';
                                    }
                                    echo '<option '.$selected.' value="'.$data_payment['payment_mode'].'-'.$data_payment['payment_mode_id'].'">'.$data_payment['payment_mode'].'</option>';
                                }
                                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="bank_ref_no" <?php if($_POST['payment_type'] =='online-5') echo 'style="display:block"'; else if($data_invoice['paid_type'] =='5') echo 'style="display:block"';  else echo 'style="display:none"'; ?>>
                                    <table width="100%">
                                        <tr>
                                            <td width="18%">Bank Ref. no</td>
                                            <td width="35%"><input type="text" name="bank_ref_no" class="input_text" style="width:200px" id="bank_ref_no" value="<?php if($_POST['bank_ref_no']) echo $_POST['bank_ref_no']; else echo $data_invoice['bank_ref_no']; ?>"/></td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="bank_details" <?php if($data_payment_mode1['payment_mode']=='Credit Card' || $data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                                    <table width="100%">
                                        <tr>
                                            <td width="34%">Bank Name<span class="orange_font">*</span></td>
                                            <td>
                                                <div id="bank_record">
                                                <?php 
                                                //if($record_id !='')
                                                {
                                                    ?>
                                                    <select name="bank_name" class="input_text" style="width:200px" id="bank_name" onChange="show_acc_no(this.value)">
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    $sle_bank_name="select bank_id,bank_name from bank where cm_id='".$_SESSION['cm_id']."'"; 
                                                    $ptr_bank_name=mysql_query($sle_bank_name);
                                                    while($data_bank=mysql_fetch_array($ptr_bank_name))
                                                    {
                                                        $selected='';
                                                        if($data_bank['bank_id'] == $row_expense['bank_id'])
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
                                                </div>         
                                                <div id="bank_id"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="34%">Enter Account No<span class="orange_font">*</span></td>
                                            <td><input type="text" name="account_no" class="input_text" style="width:200px" id="account_no" readonly="readonly" value="<?php if($_POST['account_no']) echo $_POST['account_no']; else echo $row_expense['account_no']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="chaque_details" <?php  if($data_payment_mode1['payment_mode']=='cheque') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                                    <table width="100%">
                                        <tr>
                                            <td width="34%">Enter Chaque No<span class="orange_font">*</span></td>
                                            <td><input type="text" name="chaque_no" class="input_text" style="width:200px" id="chaque_no" value="<?php if($_POST['chaque_no']) echo $_POST['chaque_no']; else echo $row_expense['chaque_no']; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td width="34%">Enter Chaque Date<span class="orange_font">*</span></td>
                                            <td><input type="text" name="date" id="date" style="width:200px"  class="datepicker input_text" value="<?php if($_POST['date']) echo $_POST['date']; else echo $row_expense['chaque_date']; ?>"  /></td>
                                        </tr>
                                    </table>
                                </div> 
                                <div id="credit_details" <?php  if($data_payment_mode1['payment_mode']=='Credit Card') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                                    <table width="100%">
                                        <tr>
                                            <td width="34%">Enter Credit Card No<span class="orange_font">*</span></td>
                                            <td><input type="text" name="credit_card_no" class="input_text" style="width:200px" id="credit_card_no" maxlength="4" value="<?php if($_POST['credit_card_no']) echo $_POST['credit_card_no']; else echo $row_expense['credit_card_no']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="paytm_details" <?php  if($data_payment_mode1['payment_mode']=='paytm') echo ' style="display:block"'; else echo ' style="display:none"'; ?>>
                                    <table width="100%">
                                        <tr>
                                            <td width="34%">ISAS Mobile No</td>
                                            <td><input type="text" name="isas_paytm_no" class="input_text" style="width:200px" id="isas_paytm_no" maxlength="10" value="<?php if($_POST['isas_paytm_no']) echo $_POST['isas_paytm_no']; else echo $row_record['isas_paytm_no']; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td width="34%">Cust. Mobile No</td>
                                            <td><input type="text" name="cust_paytm_no" class="input_text" style="width:200px" id="cust_paytm_no" maxlength="10" value="<?php if($_POST['cust_paytm_no']) echo $_POST['cust_paytm_no']; else echo $row_record['cust_paytm_no']; ?>" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Description<span class="orange_font">*</span></td>
                            <td width="40%">
                                <textarea id="des" name="des"><?php echo $row_record['des']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                        <?php
                        $year= date('Y');
                        $month=date('M');
                        $array = array('ISAS',$year,$month);
                        $comma_separated = implode("/",$array);
                        ?>
                            <td class="heading">Installment on</td>
                            <td colspan="2"> <input type="text" name="installment_on" id="installment_on" value="<?php if($_POST['advance_payment']) echo $_POST['advance_payment']; else if($row_record['advance_payment']!=0) echo $row_record['advance_payment']; else echo 0;?>"/>
                            </td> 
                        </tr>
                        <tr>
                            <td class="heading"> Number of Installment</td>
                            <td colspan="2">
                                <select name="numDep" id="dropdown" >
                                <?php 
                                for ($i = 0; $i <= 10; $i++)
                                {
                                    $selc = '';
                                    if($row_record['no_of_installments']== $i || $_POST['numDep']== $i)
                                    {
                                        $selc ='selected="selected" ';
                                    }
                                        echo '<option value="'.$i.'" '.$selc.'>'.$i.'</option>';
                                }
                                    //endfor;
                                  ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"> <div id="textboxDiv">
                            <?php if($record_id && $row_record['no_of_installments'] !=0)
                            {
                                ?>
                                <table width="100%">
                                <?php
                                $selec_installemnt = " select * from pr_advance_installments where staff_advance_salary_id='$record_id'  ";
                                $ptr_installment= mysql_query($selec_installemnt);
                                $i=1;
                                while($dat_installment = mysql_fetch_array($ptr_installment))
                                {
                                    $dates = $dat_installment['i_date'];
                                    $sep_da = explode('-',$dates);
                                    $dates=$sep_da[2].'/'.$sep_da[1].'/'.$sep_da[0];
                                    
                                    if($dat_installment['status']=="Not Paid")
                                    {
                                        $style="style='font-size:12px;color:red;'";
                                        $disabled="";
                                    }
                                    else
                                    {
                                        $style="style='font-size:12px;color:green;'";
                                        $disabled="disabled";
                                    }
                                    ?>
                                    <tr><td width="40%" class="heading">Installment <?php echo $i; ?> </span></td><td width="40%" colspan="2"><input type="text" class="input_text installment_input  installment_inp_<?php echo $i; ?>" alt="<?php echo $i; ?>" name="installments[]" id="ins_price" value='<?php if($_POST['installments']) echo $_POST['installments']; else echo $dat_installment['i_amount'];  ?>' <?php echo $disabled; ?> /></td><td><input type="text" name="installment_date[]" class="datepicker date_class<?php echo $i; ?>" placeholder="installment date" id="date_class<?php echo $i; ?>" value="<?php if($_POST['installment_date']) echo $_POST['installment_date']; else echo $dates ;?>" <?php echo $disabled; ?>  ></td><td width="40%"><span <?php echo $style; ?>><?php echo $dat_installment['status']; ?></span></td></tr>
                                        <?php 
                                        $i++;
                                }?>
                                </table>
                                <?php
                            }
                            ?>
                            </div>
                        </td> 
                        </tr>
						<?php
                        $sql_invoice="select * from invoice where enroll_id='".$row_record['enroll_id']."' and course_id='".$row_record['course_id']."' 
                        and installment_id='0' ";
                        $my_query_invoice=mysql_query($sql_invoice);
                        if(mysql_num_rows($my_query_invoice))
                        {
                            $row_invoice= mysql_fetch_array($my_query_invoice);
                            if($chaque_date  !='//')
                            {
                                $chaque_date = $data_invoice['chaque_date'];
                                $sep_chk_dt = explode('-',$chaque_date);
                                $chaque_date=$sep_chk_dt[1].'/'.$sep_chk_dt[2].'/'.$sep_chk_dt[0];
                            }
                        }
                        ?>
					</table>
        			<center>
                    <input type="hidden" name="course_only_fee" id="course_only_fee" value="" />
                    <table>
                        <tr>
                        <?php
                        if($record_id !='')
                        {
                            $sql_records= "SELECT * FROM pr_advance_installments where staff_advance_salary_id=".$record_id." AND status='Paid'";
                            $query_records=mysql_query($sql_records);
                            $no_of_records=mysql_num_rows($db->query($sql_records));
                        }
                        if(!$no_of_records)
                        {
                            ?>
                            <td align="right">
                            <?php
                            if($record_id !='')
                            { 
                                ?>
                                <input type="submit" value="Update Record" name="save_changes" /> 
                                <?php
                            }
                            else
                            {
                                ?>
                                <input type="submit" value="Save Record" name="save_changes"  /> 
                                <?php 
                            }?>			
                            </td>
                            <?php 
                        }?>		
                        </tr>
                    </table>
                    </center>   
                </form>
            </td>
        </tr>
        <?php
    }?>
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
</div>
<!--info end-->
<div class="clearit"> </div>
<!--footer start-->
<script>
<?php 
if($_SESSION['type']!="S" && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' )
{
	?>
	branch_name=document.getElementById('branch_name').value;
	get_staff(branch_name);
	<?php
}
?>
</script>
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>
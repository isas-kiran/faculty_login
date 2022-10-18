<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Outstanding Installment Report By Day</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='149'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
	<link rel="stylesheet" href="js/chosen.css">
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function()
	{            
		/*$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}*/
		$("#staff_id").chosen({allow_single_deselect:true});
		<?php 
		if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			<?php
		}
		?>
		$('.datepicker').datepicker( {
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'mm/yy',
			onClose: function(dateText, inst) { 
				$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
				 $(".ui-datepicker-calendar").hide();
			}
		});
	});
	</script>
    <style>
	.ui-datepicker-calendar {
    display: none;
    }
	</style>
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
	function getstaff(branch_id)
	{
		var data1="action=stack_report&branch_id="+branch_id;	
		$.ajax({
		url: "show_councellor.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			if(html !='')
			{
				//alert(html);
				document.getElementById("staff_details").innerHTML=html;
				$("#staff_id").chosen({allow_single_deselect:true});
			}
		},
		error:function(exception){alert('Exception:'+exception);}
		});
	}
    </script>
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
        <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
        <td class="top_right"></td>
    </tr>
    <tr>
        <td class="mid_left"></td>
        <td class="mid_mid" align="center">
        	<span style="color:red; font-size:12px"><strong>Note :</strong> This report is only for <strong>Outstanding amounts</strong> and its based on Installment date.<strong> Realised amount</strong> will be vary based on month filter and installmet date.</span>
            <table cellspacing="0" cellpadding="0" class="table" width="95%">
            <?php
            $sep_url_string='';
            $sep_url= explode("?",$_SERVER['REQUEST_URI']);
            if($sep_url[1] !='')
            {
                $sep_url_string="?".$sep_url[1];
            }
			
			if($_REQUEST['keyword']!="Keyword")
				$keyword=trim($_REQUEST['keyword']);
				
			if($keyword)
			{                            
				$pre_keyword =" and (e.name like '%".$keyword."%' )";
			}                            
			else
				$pre_keyword="";
		
			if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
			{
				$frm_date=explode("/",$_REQUEST['from_date']);
				$first_month=$frm_date[0];
				$first_year=$frm_date[1];
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $first_month, $first_year);
				
				$from_date="01-".$frm_date[0]."-".$frm_date[1];
				$last_date=$days_in_month.'-'.$frm_date[0].'-'.$frm_date[1];
				
				$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($from_date))."'";
				$pre_to_date=" and DATE(admission_date) <='".date('Y-m-d',strtotime($last_date))."'";
				
				$installment_from_date=" and DATE(installment_date) >='".date('Y-m-d',strtotime($from_date))."'";
				$installment_to_date=" and DATE(installment_date) <='".date('Y-m-d',strtotime($last_date))."'";
				
				$installment_from_date_i=" and DATE(i.installment_date) >='".date('Y-m-d',strtotime($from_date))."'";
				$installment_to_date_i=" and DATE(i.installment_date) <='".date('Y-m-d',strtotime($last_date))."'";
				
				$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($from_date))."'";
				$paid_to_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($last_date))."'";
			}
			else
			{
				/*$pre_from_date=""; 
				$paid_from_date="";
				$installment_from_date="";
				$installment_from_date_i="";*/
				
				$first_month=date('m');
				$first_year=date('Y');
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $first_month, $first_year);
				
				$from_date="01-".$first_month."-".$first_year;
				$last_date=$days_in_month.'-'.$first_month.'-'.$first_year;
				
				$pre_from_date=" and DATE(admission_date) >='".date('Y-m-d',strtotime($from_date))."'";
				$pre_to_date=" and DATE(admission_date) <='".date('Y-m-d',strtotime($last_date))."'";
				
				$installment_from_date=" and DATE(installment_date) >='".date('Y-m-d',strtotime($from_date))."'";
				$installment_to_date=" and DATE(installment_date) <='".date('Y-m-d',strtotime($last_date))."'";
				
				$installment_from_date_i=" and DATE(i.installment_date) >='".date('Y-m-d',strtotime($from_date))."'";
				$installment_to_date_i=" and DATE(i.installment_date) <='".date('Y-m-d',strtotime($last_date))."'";
				
				$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($from_date))."'";
				$paid_to_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($last_date))."'";
				                         
			}
			/*if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
			{
				$to_date=explode("/",$_REQUEST['to_date']);
				$second_month=$to_date[0];
				$second_year=$to_date[1];
				$days_in_second_month = cal_days_in_month(CAL_GREGORIAN, $second_month, $second_year);
				
				$to_dates=$days_in_second_month."-".$to_date[0]."-".$to_date[1];
				
				$pre_to_date=" and DATE(admission_date) <='".date('Y-m-d',strtotime($to_dates))."'";
				$installment_to_date=" and DATE(installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
				$installment_to_date_i=" and DATE(i.installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
				$paid_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";		
			}
			else
			{
				$second_month=date('m');
				$second_year=date('Y');
				$days_in_second_month = cal_days_in_month(CAL_GREGORIAN, $second_month, $second_year);
				$to_dates=$days_in_second_month."-".$second_month."-".$second_year;
				
				$pre_to_date=" and DATE(admission_date) <='".date('Y-m-d',strtotime($to_dates))."'";
				$installment_to_date=" and DATE(installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
				$installment_to_date_i=" and DATE(i.installment_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
				$paid_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
			}*/
			
			$search_cm_id='';
			$search_cm_id_i='';
			$cm_ids=$_SESSION['cm_id'];
			if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
			{
				if($_REQUEST['branch_name']!='')
				{
					$branch_name=$_REQUEST['branch_name'];
					$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
					$ptr_cm_id=mysql_query($select_cm_id);
					$data_cm_id=mysql_fetch_array($ptr_cm_id);
					$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
					$search_cm_id_i=" and e.cm_id='".$data_cm_id['cm_id']."'";
					$cm_ids=$data_cm_id['cm_id'];
				}
				else
				{
					$search_cm_id=" and cm_id='2'";
					$search_cm_id_i=" and e.cm_id='2'";
					$cm_ids=2;
				}
			}
			if($_REQUEST['staff_id'])
            {
                $staff_ids=$_REQUEST['staff_id'];
                $where_staff_id=" and admin_id='".$staff_ids."'";
				$where_staff_id_e=" and e.assigned_to='".$staff_ids."'";
				
            }
            else
            {
                $where_staff_id='';
				$where_staff_id_e='';
            }
			if($_REQUEST['page'])
				$page=$_REQUEST['page'];
			else
				$page=0;
			if($_REQUEST['show_records'])
				$show=$_REQUEST['show'];
			else
				$show=0;
			if($_GET['order']=='asc')
			{
				$order='desc';
				$img = "<img src='images/sort_up.png' border='0'>";
			}
			else if($_GET['order']=='desc')
			{
				$order='asc';
				$img = "<img src='images/sort_down.png' border='0'>";
			}
			else
				$order='desc';
			if($_GET['orderby']=='name' )
				$img1 = $img;
			if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
			{
				$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
				$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
			}
			else
				$select_directory='order by e.enroll_id desc'; 
				
			$where_cm='';
			if($_SESSION['where']!='')
			{
				$where_cm=" and e.cm_id='".$_SESSION['cm_id']."'";
			}
			
			/*$monthRanger = count(range($first_month, $second_month));
			
			if($monthRanger >= 2 && $monthRanger <= 3)
			{
				$colspan = 11 + ($monthRanger * 4);
			}
			else if($monthRanger < 2)
			{
				$colspan= 15;
			}
			else
			{
				$colspan= 24;
			}*/
            ?>
            <tr class="head_td">
                <td colspan="24">
                    <form method="get" name="search">
                    <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                    <tr>
                        <td class="" width="12%">
                        <?php
						if($_REQUEST['from_date'] =='')
						{
							?>
							<lable><strong>Default Records show <?php echo date('M Y')?></strong></lable>
							<?php
						}
						?> 
                        </td>
                        <!--<td width="20%">
                                <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                        <option value="">-Operation-</option>
                                        <option value="delete">Delete</option>
                                </select>
                         </td>-->
                        <?php 
                        if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                        {
                            ?>
                            <td width="12%">
                                <select name="branch_name" id="branch_name" class="input_select_login" onchange="getstaff(this.value)" style="width: 200px;">
                                    <option value=""> Select Branch Name</option>
                                    <?php 
                                    $sel_branch="select branch_id,branch_name from branch";
                                    $ptr_sel=mysql_query($sel_branch);
                                    while($data_branch=mysql_fetch_array($ptr_sel))
                                    {
                                        $sel='';
                                        if($data_branch['branch_name']==$_GET['branch_name'])
                                        {
                                            $sel='selected="selected"';
                                        }
										else if($data_branch['branch_name']=='Pune' && $_GET['branch_name']=='')
										{
											$sel='selected="selected"';
										}
                                        echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <?php
                        }
						else
						{
							?>
                            <td colspan="2" align="left">
                            <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"> 
                            </td>
                            <?php 
						}
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{
							?>
							<td width="12%" align="center" id="staff_details">
								<select name="staff_id" id="staff_id" class="input_select" style="width:150px">
								<option value="">Select Staff</option>
								<?php
								if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
								{
									if($_REQUEST['branch_name']!='')
									{
										$branch_name=$_REQUEST['branch_name'];
										$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
										$ptr_cm_id=mysql_query($select_cm_id);
										$data_cm_id=mysql_fetch_array($ptr_cm_id);
										$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
										$cm_ids=$data_cm_id['cm_id'];
									}
									else
									{
										$search_cm_id=" and cm_id='2'";
										$cm_ids='2';
									}
								}
								$sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." ".$search_cm_id." and system_status='Enabled' and (type='C' or type='A' or type='Z') order by name asc"; 
								$ptr_name=mysql_query($sle_name);
								while($data_name=mysql_fetch_array($ptr_name))
								{
									$selected='';
									if($data_name['admin_id'] == $_REQUEST['staff_id'])
									{
										$selected='selected="selected"';
									}
									echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
								}
								?>
								</select>
							</td>
							<?php
						}
                        ?>
                        <!--<td width="12%" align="center"><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>-->
                        <td width="15%" align="center"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Month" readonly="1" id="from_date" title="From Month" style="width:175px !important" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                        </td>
                        <!--<td width="15%" align="center"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Month" readonly="1" id="to_date"  title="To Month" style="width:175px !important" value="<?php //if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                        </td>-->
                        <td width="10%"><input type="submit" style="width:100px" name="search" value="Search" class="inputButton"></td>
                        <?php
                        if($_SESSION['type']=="S" || $_SESSION['type']=="Z" || $_SESSION['type']=="LD" || $edit_access=='yes')
                        {
                        	?>
                            <td width="5%"> <a href="daily_outstanding_installment_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>
                            <?php
                        }
                        ?>
                    </tr>
               </table>
            </form>	
        </td>
    </tr>
    <?php
	
	if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
		$sql_query="SELECT DISTINCT(e.enroll_id),e.cm_id,e.name,e.course_id, e.net_fees,e.down_payment, e.paid,e.balance_amt,e.assigned_to FROM enrollment e, installment i WHERE 1 and (e.student_status ='Active' or e.student_status is NULL) and e.enroll_id=i.enroll_id ".$where_staff_id_e." ".$where_cm." ".$search_cm_id_i." ".$installment_from_date_i." ".$installment_to_date_i." ".$pre_keyword." ".$select_directory."  "; 
	}
	else
	{
		$sql_query="SELECT DISTINCT(e.enroll_id),e.cm_id,e.name,e.course_id, e.net_fees,e.down_payment,e.paid,e.balance_amt, e.assigned_to FROM enrollment e, installment i WHERE 1 and (e.student_status ='Active' or e.student_status is NULL) and e.enroll_id=i.enroll_id and e.assigned_to='".$_SESSION['admin_id']."' ".$where_staff_id_e." ".$where_cm." ".$search_cm_id_i." ".$installment_from_date_i." ".$installment_to_date_i." ".$pre_keyword." ".$select_directory." "; 
	}
	$db=mysql_query($sql_query);
	$no_of_records=mysql_num_rows($db);
	if($no_of_records)
	{
		$bgColorCounter=1;
	//$query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&branch_name ='.$_REQUEST['branch_name'];
		//$query_string1=$query_string.$date_query;
	   // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
		//$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
		//$all_records= $pager->paginate();
		?>
		<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
        <input type="hidden" name="formAction" id="formAction" value=""/>
			<tr class="grey_td" >
            	<td colspan="11" align="center"><strong></strong></td>
                <?php
				for($i=1;$i<=$days_in_month;$i++)
				{
					$curr_date=$first_year.'-'.$first_month.'-'.$i;
					$pr_month=Date('M',strtotime($curr_date));
					$todays_date=Date('d/m/Y',strtotime($curr_date));
					
					echo '<td align="center" colspan="3"><strong>'.$todays_date.'</strong></td>';
				}
				?>
            </tr>
            <tr class="grey_td">
                <td width="4%" align="center" style="background-color:#FAFDBB"><strong>Sr. No.</strong></td>
                <td width="6%" align="center" style="background-color:#FAFDBB"><strong>Branch Name</strong></td>
                <td width="19%" align="center" style="background-color:#FAFDBB"><strong>Student Name</strong></td>
                <td width="19%" align="center" style="background-color:#FAFDBB"><strong>Course Name</strong></td>
                <td width="6%" align="center" style="background-color:#FAFDBB"><strong>Course Fee</strong></td>
                <td width="6%" align="center" style="background-color:#FAFDBB"><strong>DP Amount</strong></td>
                <td width="6%" align="center" style="background-color:#FAFDBB"><strong>DP Date</strong></td>
                <td width="6%" align="center" style="background-color:#FAFDBB"><strong>DP Payment Mode</strong></td>
                <td width="6%" align="center" style="background-color:#FAFDBB"><strong>Amount Realised Till date</strong></td>
                <td width="6%" align="center" style="background-color:#FAFDBB"><strong>Pending Amount Till Month</strong></td>
                <td width="12%" align="center" style="background-color:#FAFDBB"><strong>Sales Executive</strong></td>
                <?php
				for($i=1;$i<=$days_in_month;$i++)
				{
					$curr_date=$first_year.'-'.$first_month.'-'.$i;
					$pr_month=Date('M',strtotime($curr_date));
					$todays_date=Date('d/m/Y',strtotime($curr_date));
					?>
                    <td width="6%" align="center" style="background-color:#FECBBA"><strong>Installment Amount</strong></td>
                    <!--<td width="6%" align="center" style="background-color:#FECBBA"><strong>Installment Date</strong></td>-->
                    <td width="6%" align="center" style="background-color:#CDE3FC"><strong>Amount Realised</strong></td>
                    <td width="6%" align="center" style="background-color:#CDE3FC"><strong>Payment Mode</strong></td>
                    <?php
				}
				?>
            </tr>
			<?php
            $total_paid=0;
			$total_exp_amnt=0;
            $monthly_expected=0;
			$total_dp=0;
            while($val_query=mysql_fetch_array($db))
            {
                if($bgColorCounter%2==0)
                    $bgcolor='class="grey_td"';
                else
                    $bgcolor=""; 
                    $listed_record_id=$val_query['enroll_id'];
                
                include "include/paging_script.php";
                echo '<tr '.$bgcolor.'>';
                echo '<td align="center">'.$sr_no.'</td>';
				
                $sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A' order by cm_id asc";
				$ptr_branch=mysql_query($sel_branch);
                $data_branch=mysql_fetch_array($ptr_branch);
				
				echo '<td align="center">'.$data_branch['branch_name'].'</td>';
				echo '<td align="center">'.$val_query['name'].'</td>';
                
				$select_course="select course_name from courses where course_id = '".$val_query['course_id']."'  ";
				$query=mysql_query($select_course);
				$val_course= mysql_fetch_array($query);
                echo '<td>'.$val_course['course_name'].'</td>';
                echo '<td>'.$val_query['net_fees'].'</td>';
				echo '<td>'.$val_query['down_payment'].'</td>';
				$total_dp +=$val_query['down_payment'];
				
				$sel_in="select paid_type,added_date from invoice where enroll_id='".$val_query['enroll_id']."' and type='down_payment'";
				$ptr_inv=mysql_query($sel_in);
				$data_inv=mysql_fetch_array($ptr_inv);
				
				echo '<td>'.date('Y-m-d',strtotime($data_inv['added_date'])).'</td>';
				
				$sel_paymode="select payment_mode from payment_mode where payment_mode_id='".$data_inv['paid_type']."'";
				$ptr_paymode=mysql_query($sel_paymode);
				$data_paymode=mysql_fetch_array($ptr_paymode);
				echo '<td>'.$data_paymode['payment_mode'].'</td>';
				
				echo '<td>'.$val_query['paid'].'</td>';
				
				$sel_bal="select SUM(installment_amount) as total_balance from installment where enroll_id='".$val_query['enroll_id']."' ".$installment_to_date." order by installment_id asc";
				$ptr_bal=mysql_query($sel_bal);
                $data_bal=mysql_fetch_array($ptr_bal);
				echo '<td>'.$data_bal['total_balance'].'</td>';
				
				$sel_counc="select name from site_setting where admin_id='".$val_query['assigned_to']."' order by admin_id asc";
				$ptr_counc=mysql_query($sel_counc);
                $data_couc=mysql_fetch_array($ptr_counc);
                
				echo '<td>'.$data_couc['name'].'</td>';
				for($i=1;$i<=$days_in_month;$i++)
				{
					$curr_date=$first_year.'-'.$first_month.'-'.$i;
					$pr_month=Date('M',strtotime($curr_date));
					$todays_date=Date('d/m/Y',strtotime($curr_date));
					//============================ START=========================================
					$start_date=date('Y-m-d',strtotime($curr_date));
					$end_date= date('Y-m-d',strtotime($curr_date));
					
					$installment_from_date=" and DATE(installment_date) >='".$start_date."'";
					$installment_to_date=" and DATE(installment_date)<='".$end_date."' ";
					
					$paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($start_date))."'";
					$paid_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($end_date))."'";
					//============== Installment Amount =============================
					echo '<td>';
					$select_installments="SELECT installment_date,installment_amount FROM installment where enroll_id ='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
					$ptr_installment= mysql_query($select_installments);
					if($tot_insts=mysql_num_rows($ptr_installment))
					{
						$is=1;
						while($data_installment=mysql_fetch_array($ptr_installment))
						{
							$col_paid ='<font color="#000">';
							if($data_installment['installment_date'] < date("Y-m-d"))
							{
								$col_paid ='<font color="#FF3333">';
							}
							else
								$past_rec='';
							echo $col_paid.$data_installment['installment_amount']."</font><br/>";	
							$is++;
						}
					}
					echo '</td>';
					//==================INSTALLMENT DATE ================================
					/*echo '<td>';
					$select_installments="SELECT installment_date FROM installment where enroll_id ='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
					$ptr_installment = mysql_query($select_installments);
					if(mysql_num_rows($ptr_installment))
					{
						while($data_installment = mysql_fetch_array($ptr_installment))
						{
							$col_paid ='<font color="#000">';
							if($data_installment['installment_date'] < date("Y-m-d"))
							{
								$col_paid ='<font color="#FF3333">';
							}
							else
								$past_rec='';
							echo $col_paid.$data_installment['installment_date']."</font><br>";	
						}
					}*/
					//================= AMOUNT REALISED =================================
					$amount=0;
					echo '<td>';
					$select_realised="SELECT amount,paid_type FROM invoice where enroll_id ='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' ".$paid_from_date." ".$paid_to_date."";
					$ptr_realised= mysql_query($select_realised);
					if(mysql_num_rows($ptr_realised))
					{
						$amount=0;
						while($data_realised=mysql_fetch_array($ptr_realised))
						{
							if($data_realised['amount'] >0)
							{
								/*$sel_paymode="select payment_mode from payment_mode where payment_mode_id='".$data_realised['paid_type']."'";
								$ptr_paymode=mysql_query($sel_paymode);
								$data_paymode=mysql_fetch_array($ptr_paymode);*/
								
								$amount +=$data_realised['amount'];
								$col_paid ='<font color="#000">';
								$dt=strtotime($data_realised['added_date']);
								$datess=date("Y-m-d", $dt);
								
								echo $data_realised['amount']."<br>";
								$total_paid=$total_paid+$data_realised['amount'];
							}
						}
					}
					echo '</td>';
					//==================== PAYMENT MODE ===========================
					echo '<td>';
					$select_installments="SELECT amount,paid_type FROM invoice where enroll_id ='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' ".$paid_from_date." ".$paid_to_date."";
					$ptr_installment = mysql_query($select_installments);
					if(mysql_num_rows($ptr_installment))
					{
						$amount=0;
						while($data_installment = mysql_fetch_array($ptr_installment))
						{
							if($data_installment['amount'] >0)
							{
								$sel_paymode="select payment_mode from payment_mode where payment_mode_id='".$data_installment['paid_type']."'";
								$ptr_paymode=mysql_query($sel_paymode);
								$data_paymode=mysql_fetch_array($ptr_paymode);
								echo $data_paymode['payment_mode']."<br>";
							}
						}
					}
					echo '</td>';
					
					array_push($realised_arr,$amount);
				}
				echo '</tr>';
                $bgColorCounter++;
            }
			print_r($realised_arr);
            ?>
            
            <tr class="grey_td">
                <td width="4%" colspan="11" style="font-size:12px; font-weight:700" align="center"> Total</td>
                <!--<td width="4%" colspan="4" style="font-size:12px; font-weight:700" align="center">Totla Down Payment &nbsp; &nbsp;<?php //echo $total_dp; ?></td>
                <td width="4%" colspan="2" style="font-size:12px; font-weight:700" align="center"></td>-->
				<?php
                for($i=1;$i<=$days_in_month;$i++)
                {
                    $curr_date=$first_year.'-'.$first_month.'-'.$i;
                    $pr_month=Date('M',strtotime($curr_date));
                    $todays_date=Date('d/m/Y',strtotime($curr_date));
                    
                    $start_date=date('Y-m-d',strtotime($curr_date));
                    $end_date= date('Y-m-d',strtotime($curr_date));
                    
                    $installment_from_date=" and DATE(installment_date) >='".$start_date."'";
                    $installment_to_date=" and DATE(installment_date)<='".$end_date."' ";
					
					$installment_from_date_i=" and DATE(i.installment_date) >='".$start_date."'";
                    $installment_to_date_i=" and DATE(i.installment_date)<='".$end_date."' ";
                    
                    $paid_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($start_date))."'";
                    $paid_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($end_date))."'";
					
					
					$realised_amount=0;
					$total_month_amnt=0;
                    //============== Installment Amount =============================
                    
                    if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
					{
						$sql_query_qs="SELECT DISTINCT(e.enroll_id),e.cm_id,e.name,e.course_id,e.net_fees,e.down_payment,e.paid,e.balance_amt,e.assigned_to FROM enrollment e, installment i WHERE 1 and (e.student_status ='Active' or e.student_status is NULL) and e.enroll_id=i.enroll_id ".$where_staff_id_e." ".$where_cm." ".$search_cm_id_i." ".$installment_from_date_i." ".$installment_to_date_i." ".$pre_keyword." ".$select_directory."  "; 
					}
					else
					{
						$sql_query_qs="SELECT DISTINCT(e.enroll_id),e.cm_id,e.name,e.course_id, e.net_fees,e.down_payment,e.paid,e.balance_amt, e.assigned_to FROM enrollment e, installment i WHERE 1 and (e.student_status ='Active' or e.student_status is NULL) and e.enroll_id=i.enroll_id and e.assigned_to='".$_SESSION['admin_id']."' ".$where_staff_id_e." ".$where_cm." ".$search_cm_id_i." ".$installment_from_date_i." ".$installment_to_date_i." ".$pre_keyword." ".$select_directory." "; 
					}
                    $ptr_sql_qs=mysql_query($sql_query_qs);
                    while($data_tot_query=mysql_fetch_array($ptr_sql_qs))
                    {
                        $select_installments="SELECT * FROM installment where enroll_id ='".$data_tot_query['enroll_id']."' and course_id='".$data_tot_query['course_id']."' ".$installment_from_date." ".$installment_to_date." ";
                        $ptr_installment= mysql_query($select_installments);
                        if($tot_insts=mysql_num_rows($ptr_installment))
                        {
                            $is=1;
                            while($data_installment = mysql_fetch_array($ptr_installment))
                            {
                                $total_month_amnt +=$data_installment['installment_amount'];	
                                $is++;
                            }
                            //if($tot_insts != $is) echo '<hr />'; else	echo '';
                        }
                        
                        //================= AMOUNT REALISED =================================
                       $select_realised="SELECT amount,paid_type FROM invoice where enroll_id ='".$data_tot_query['enroll_id']."' and course_id='".$data_tot_query['course_id']."' ".$paid_from_date." ".$paid_to_date."";
                        $ptr_realised=mysql_query($select_realised);
                        if(mysql_num_rows($ptr_realised))
                        {
                            while($data_realised=mysql_fetch_array($ptr_realised))
                            {
                                if($data_realised['amount'] > 0)
                                {
                                    $realised_amount +=number_format($data_realised['amount']);
                                }
                            }
                        }
                    }
					echo '<td style="color:red">';
                    echo '<strong>'.$total_month_amnt.'</strong>';
                    echo '</td>';
                    //echo '<td></td>';
                    echo '<td style="color:green"><strong>'.$realised_amount.'</strong></td>';
                    echo '<td></td>';
                    $sec_month=$second_month;   /// $_REQUEST['second_month']
                    $start=1;
                }
                ?>
			</tr>
  		</form>
  		<?php 
	} 
    else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';?>
</table>
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
</body>
</html>
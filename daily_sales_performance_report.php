<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily Sales Performance Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='154'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
    <script type="text/javascript" src="../js/common.js"></script>
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
		var data1="action=utilization_report&branch_id="+branch_id;	
		$.ajax({
		url: "show_councellor.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			if(html !='')
			{
				document.getElementById("staff_details").innerHTML=html;
				//$("#staff_id").chosen({allow_single_deselect:true});
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
		<table cellspacing="0" cellpadding="0" class="table" width="95%">
			<?php
            $sep_url_string='';
            $sep_url= explode("?",$_SERVER['REQUEST_URI']);
            if($sep_url[1] !='')
            {
                $sep_url_string="?".$sep_url[1];
            }
            ?>   
            <tr class="head_td">
                <td colspan="10">
                    <form method="get" name="search">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
                            <?php
                            if($_REQUEST['from_date'] =='')
                            {
                                ?>
                                <!--Default Records show from <?php //echo date('d/m/Y',strtotime('-30 days')) ?> to <?php //echo date('d/m/Y') ?>-->
                                <?php
                            }
                            ?>
                            <tr>
                                <td class="width5"></td>
                                <!--<td width="20%">
                                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                        <option value="">-Operation-</option>
                                        <option value="delete">Delete</option>
                                    </select></td>-->
                                <td width="15%" align="center"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                                {
                                ?>
                                 <td width="15%">
                                    <select name="branch_name" id="branch_name" onchange="getstaff(this.value)" class="input_select_login"  style="width: 150px; ">
                                        <option value="">-Branch Name-</option>
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
                                                if($_GET['branch_name']=='' && $data_branch['branch_name']=='Pune')
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
                                    <input type="hidden" name="branch_name_s" id="branch_name_s" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                                    </td>
                                    <?php 
                                }
                                if($_SESSION['type']=="S" || $_SESSION['type']=="A" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                                {
                                    ?>
                                    <td width="10%" align="center" style="padding-left:0px;width: 15%;" id="staff_details">
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
                                        $sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." ".$search_cm_id." and system_status='Enabled' order by name asc"; 
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
                                <td width="10%" align="center">
                                <input type="text" name="on_date" class="input_text datepicker" placeholder="Date" id="on_date" title="Date" value="<?php if($_REQUEST['on_date']!="Date") echo $_REQUEST['on_date'];?>">
                                <!--<input type="text" name="from_date" class="input_text datepicker" placeholder="From Date"  id="from_date" title="From Date" value="<?php //if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">-->
                                </td>
                                <!--<td width="10%" align="center">
                                <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" id="to_date"  title="To Date" value="<?php //if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                                </td>-->
                                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                <?php
                                if($_SESSION['type']=='S' || $_SESSION['type']=='LD' || $_SESSION['type']=='Z' || $edit_access=='yes')
                                {
                                    ?>
                                    <td> <a href="DSP_report_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>
                                    <?php
                                }
                                ?>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
	<?php
    if($_REQUEST['keyword']!="Keyword")
        $keyword=trim($_REQUEST['keyword']);
        
    if($keyword)
    {                            
        $pre_keyword =" and (name like '%".$keyword."%' )";
    }                            
    else
        $pre_keyword="";
        
    if($_REQUEST['staff_id'])
    {
        $staff_ids=$_REQUEST['staff_id'];
        $where_staff_id=" and admin_id='".$staff_ids."'";
    }
    else
    {
        $where_staff_id='';
    }
	
	if($_REQUEST['on_date'] && $_REQUEST['on_date']!=="0000-00-00" && $_REQUEST['on_date']!="From Date")
	{
		$frm_date=explode("/",$_REQUEST['on_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$date_for_month=$frm_date[2]."-".$frm_date[1];
		$start_date=$frm_dates;
		$first_date_month=date("Y-m-d", strtotime($frm_dates . "first day of this month"));
		$last_date_month=date('Y-m-d',strtotime($frm_dates ."last day of this month"));
		$added_date=" and DATE(added_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$dsr_added_date=" and DATE(dsr_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$added_date_i=" and DATE(i.added_date) ='".date('Y-m-d',strtotime($frm_dates))."'";
		$added_f_date=" and DATE(followup_date) ='".date('Y-m-d',strtotime($frm_dates))."' ";
		$end_added_date=" and DATE(added_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates . '-4 month'))."'"; //date('Y-m-d',strtotime('-1 days'))
		$followup_from_date=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates . '-4 month'))."' ";
		$end_followup_date=" and DATE(followup_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$end_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime($frm_dates))."'";
		$last_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime($frm_dates . "last day of this month"))."'";
		$from_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($frm_dates . "first day of previous month"))."'";
		$to_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($frm_dates . "last day of previous month"))."'";
		$to_last_day_of_current_month= " and DATE(added_date) <='".date("Y-m-d", strtotime($frm_dates . "last day of this month"))."'";
		$first_day_of_current_month=" and DATE(added_date) >='".date("Y-m-d", strtotime($frm_dates . "first day of this month"))."'";
		$secondlastmonth = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $frm_dates ) )) ;
		$from_second_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($secondlastmonth . "first day of previous month"))."'";
		$to_second_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($secondlastmonth . "last day of previous month"))."'";
		$from_thirty_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates . '-30 days'))."'"; //
	}
	else
	{
		$first_date_month=date("Y-m-d", strtotime("first day of this month"));
		$last_date_month=date('Y-m-d',strtotime("last day of this month"));
		$added_f_date=" and DATE(followup_date) ='".date('Y-m-d')."'";
		$added_date=" and DATE(added_date) ='".date('Y-m-d')."'";
		$dsr_added_date=" and DATE(added_date) ='".date('Y-m-d')."'";
		$added_date_i=" and DATE(i.added_date) ='".date('Y-m-d')."'";
		$end_added_date=" and DATE(added_date) <='".date('Y-m-d')."'";
		$date_for_month=date('Y-m');
		$date=date('Y-m-d');
		$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime('-4 month'))."'"; //date('Y-m-d',strtotime('-1 days'))
		$followup_from_date=" and DATE(followup_date) >='".date('Y-m-d')."' ";
		$end_followup_date=" and DATE(followup_date) <='".date('Y-m-d')."'";
		$end_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d')."'";
		$last_installment_date_i= " and DATE(i.installment_date) <='".date('Y-m-d',strtotime("last day of this month"))."'";
		$from_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime("first day of previous month"))."'";
		$to_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime("last day of previous month"))."'";
		$to_last_day_of_current_month= " and DATE(added_date) <='".date("Y-m-d", strtotime("last day of this month"))."'";
		$first_day_of_current_month=" and DATE(added_date) >='".date("Y-m-d", strtotime("first day of this month"))."'";
		$secondlastmonth = date("Y-m-d", strtotime ( '-1 month' , strtotime ( $date ) )) ;
		$from_second_last_installment_month= " and DATE(i.installment_date) >='".date("Y-m-d", strtotime($secondlastmonth . "first day of previous month"))."'";
		$to_second_last_installment_month= " and DATE(i.installment_date) <='".date("Y-m-d", strtotime($secondlastmonth . "last day of previous month"))."'";
		$from_thirty_date=" and DATE(added_date) >='".date('Y-m-d',strtotime('-30 days'))."'"; //
	}
	/*if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
	{
		$frm_date=explode("/",$_REQUEST['from_date']);
		$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
		$start_date=$frm_dates;
		$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
		$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
		$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
		$followup_from_date=" and DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates))."' ";
	}
	else
	{
		$enquiry_from_date=""; 
		$followup_from_date="";
		
		if($_REQUEST['to_date']=='')
		{
			$enquiry_from_date=" and DATE(`added_date`) >='".date('Y-m-d')."'"; //date('Y-m-d',strtotime('-1 days'))
			$followup_from_date=" and DATE(`followup_date`) >='".date('Y-m-d')."'";//date('Y-m-d',strtotime('-1 days'))
			$start_date=date('d/m/y');
		}
		else
		{
			$enquiry_from_date="";
			$followup_from_date='';
			$start_date='';
		}
	}
	if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
	{
		$to_date=explode("/",$_REQUEST['to_date']);
		$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
		$end_date=$to_dates;
		$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
		$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
		$enquiry_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
		$followup_to_date=" and DATE(followup_date)<='".date('Y-m-d',strtotime($to_dates))."'";
	}
	else
	{
		$enquiry_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
		$followup_to_date=" and DATE(`followup_date`)<='".date('Y-m-d')."'";
		$end_date=date('d/m/y');
	}*/
	
	$search_cm_id='';
	//$cm_ids=$_SESSION['cm_id'];
	if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{
		if($_REQUEST['branch_name']!='')
		{
			$branch_name=$_REQUEST['branch_name'];
			$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_cm_id=mysql_query($select_cm_id);
			$data_cm_id=mysql_fetch_array($ptr_cm_id);
			$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
			//$cm_ids=$data_cm_id['cm_id'];
			$search_cm_id_e=" and e.cm_id='".$data_cm_id['cm_id']."'";
		}
		else
		{
			$search_cm_id=" and cm_id='2'";
			$search_cm_id_e=" and e.cm_id='2'";
		}
	}
	
	$cm_ids=='';
	if($_SESSION['where'] !='')
	{
		$cm_ids=" and e.cm_id='".$_SESSION['cm_id']."'";
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
		$select_directory='order by `invoice_id` desc';         
	
	
	/*$sql_query= "SELECT DISTINCT(enroll_id) FROM `invoice` WHERE 1  ".$paid_from_date." ".$paid_to_date." ".$_SESSION['where']." ".$search_cm_id." ".$select_directory." "; 
	$db=mysql_query($sql_query);
	$no_of_records=mysql_num_rows($db);
	if($no_of_records)
	{*/
		//$bgColorCounter=1;
		//$_SESSION['show_records'] = 10;
		//$query_string='&keyword='.$keyword;
		//$query_string1=$query_string.$date_query;
	   	//$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
		$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
		$all_records= $pager->paginate();
		?>
		<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
		<input type="hidden" name="formAction" id="formAction" value=""/>
		<tr class="grey_td" >
			<td align="center" width="5%"><strong>Sr. No.</strong></td>
            <td align="center" width="20%"><strong>Field Name</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				?>
				<td align="center"><strong><?php echo $data_couc['name']; ?></strong></td>
				<?php
			}
			if($_REQUEST['staff_id']!='')
			{
				?>
				<td align="center" width="40%"></td>
				<?php
			}
			?>
        </tr>
        <!--=====================================No of leads given by L.D.======================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>1</strong></td>
        	<td align="center" width="12%"><strong>No of leads given by L.D.</strong></td>
			<?php
			$tota_ld_lead='';
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$sql_query="SELECT * FROM inquiry where 1 and campaign_type='lead_distribution' and employee_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id."  ".$added_date." ";
				$ptr_query=mysql_query($sql_query);
				$tota_ld_lead=mysql_num_rows($ptr_query);
				?>
				<td align="center"><strong><?php echo $tota_ld_lead; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--============================================No of Fresh Lead Assign=====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>2</strong></td>
        	<td align="center" width="12%"><strong>No of Fresh Lead Assign</strong></td>
			<?php
			$count_enquiry='';
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enquiry="select inquiry_id from inquiry where 1 and (campaign_type !='lead_distribution' or campaign_type is NULL ) and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
				$query_enquiery=mysql_query($select_enquiry);
				$count_enquiry=mysql_num_rows($query_enquiery);
				?>
				<td align="center"><strong><?php echo $count_enquiry; ?></strong></td>
				<?php
			}
			?>
        </tr>
        
        <!--=================================No of Fresh Call Done..======================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>3</strong></td>
        	<td align="center"><strong>No of Fresh Call Done.</strong></td>
			<?php
			$count_enq_called='';
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enq_cnt="select inquiry_id from inquiry where 1 and (followup_date !='' or followup_date is NOT NULL) and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
				$query_enq_cnt=mysql_query($select_enq_cnt);
				$count_enq_called=mysql_num_rows($query_enq_cnt);
				?>
				<td align="center"><strong><?php echo $count_enq_called; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================Total followup Call Done.====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>4</strong></td>
        	<td align="center"><strong>No. of followup Call Done</strong></td>
			<?php
			$no_of_foll_call='';
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enq_cnt="select inquiry_id from inquiry where 1 and (followup_date !='' or followup_date is NOT NULL) and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
				$query_enq_cnt=mysql_query($select_enq_cnt);
				$count_enq_called=mysql_num_rows($query_enq_cnt);
				
				$select_tot_called="Select DISTINCT(student_id) from followup_details where 1 and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date." ";
				$query_tot_called=mysql_query($select_tot_called);
				$tot_foll_called=mysql_num_rows($query_tot_called);
				?>
				<td align="center"><strong><?php echo $no_of_foll_call = round($tot_foll_called - $count_enq_called); ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--============================================= Total Salon followup Call Done ====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>5</strong></td>
        	<td align="center"><strong>Total Salon followup Call Done</strong></td>
			<?php
			$salon_foll_called='';
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$salon_tot_called="select followup_id from service_followup_details where 1 and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date." ";
				$salon_tot_called=mysql_query($salon_tot_called);
				$salon_foll_called=mysql_num_rows($salon_tot_called);
				?>
				<td align="center"><strong><?php echo $salon_foll_called; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--============================================= No. of Career-consultant calls ====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>6</strong></td>
        	<td align="center"><strong>No. of Career Consultant calls</strong></td>
			<?php
			$count_enq_catd='';
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enq_cat="select inquiry_id from inquiry where 1 and enquiry_type_category ='career_consultant' and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
				$query_enq_cat=mysql_query($select_enq_cat);
				$count_enq_catd=mysql_num_rows($query_enq_cat);
				?>
				<td align="center"><strong><?php echo $count_enq_catd; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--================================================= Any other tieups calls ===============================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>7</strong></td>
        	<td align="center"><strong>Any other Tie-up calls</strong></td>
			<?php
			$count_enq_tieup='';
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enq_tieup="select inquiry_id from inquiry where 1 and enquiry_type_category ='other_tie-up' and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."  ".$added_date." ";
				$query_enq_tieup=mysql_query($query_enq_tieup);
				$count_enq_tieup=mysql_num_rows($query_enq_cat);
				?>
				<td align="center"><strong><?php echo $count_enq_tieup; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--====================================================Total Calls done=====================================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>8</strong></td>
        	<td align="center"><strong>Total Calls Done</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_tot_called="Select followup_id from followup_details where 1 and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date." ";
				$query_tot_called=mysql_query($select_tot_called);
				$total_foll_called=mysql_num_rows($query_tot_called);
				?>
				<td align="center"><strong><?php echo round($total_foll_called); ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================No of cousnseling done Today=================================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>9</strong></td>
        	<td align="center"><strong>No. of Cousnseling Done Today</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enq_walkin="select DISTINCT(student_id) from followup_details where 1 and response='1' and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date." ";
				$query_enq_walkin=mysql_query($select_enq_walkin);
				$count_enq_walkin=mysql_num_rows($query_enq_walkin);
				?>
				<td align="center"><strong><?php echo $count_enq_walkin; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================No of cousnseling done till date (Monthly)====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>10</strong></td>
        	<td align="center"><strong>No. of Cousnseling Done Till Date (Monthly)</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$monthly_enq_walkin="select DISTINCT(student_id) from followup_details where 1 and response='1' and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." and DATE(`added_date`) >= '".$date_for_month."-01'  ".$end_added_date." ";
				$mont_enq_walkin=mysql_query($monthly_enq_walkin);
				$count_month_walkin=mysql_num_rows($mont_enq_walkin);
				?>
				<td align="center"><strong><?php echo $count_month_walkin; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=================================No. of Enrollments done today============================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>11</strong></td>
        	<td align="center"><strong>No. of Enrollments done today</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_inst="select enroll_id from enrollment where 1 and (student_status ='Active' or student_status is NULL) and ref_id='0' and assigned_to='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id."  ".$added_date." ";
				$query_inst=mysql_query($select_inst);
				$count_enroll=mysql_num_rows($query_inst);
				?>
				<td align="center"><strong><?php echo $count_enroll; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--===============================No. of Enrollments  till date (Monthly)==================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>12</strong></td>
        	<td align="center"><strong>No. of Enrollments  till date (Monthly)</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enroll="select enroll_id from enrollment where 1 and (student_status ='Active' or student_status is NULL) and ref_id='0' and assigned_to='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." and DATE(`added_date`) >= '".$date_for_month."-01'  ".$end_added_date." ";
				$query_enroll=mysql_query($select_enroll);
				$count_monthly_enroll=mysql_num_rows($query_enroll);
				?>
				<td align="center"><strong><?php echo $count_monthly_enroll; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--===================================No. of upgrade done today====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>13</strong></td>
        	<td align="center"><strong>No. of Upgrade done today</strong></td>
			<?php
			$count_upgrade='';
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enroll="select enroll_id from enrollment where 1 and (student_status ='Active' or student_status is NULL) and ref_id!='0' and assigned_to='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id."  ".$added_date." ";
				$query_enroll=mysql_query($select_enroll);
				$count_upgrade=mysql_num_rows($query_enroll);
				?>
				<td align="center"><strong><?php echo $count_upgrade; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================No. of upgrade done  till date (Monthly)====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>14</strong></td>
        	<td align="center"><strong>No. of upgrade done till date (Monthly)</strong></td>
        	<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_enroll="select enroll_id from enrollment where 1 and (student_status ='Active' or student_status is NULL) and ref_id!='0' and assigned_to='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." and DATE(`added_date`) >= '".$date_for_month."-01'  ".$end_added_date." ";
				$query_enroll=mysql_query($select_enroll);
				$count_monthly_upgrade=mysql_num_rows($query_enroll);
				?>
				<td align="center"><strong><?php echo $count_monthly_upgrade; ?></strong></td>
				<?php
			}
			?>
         </tr>
        <!--===========================No of Pending Followups since last 4 months==============================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>15</strong></td>
        	<td align="center"><strong>No of Pending Followups since last 4 months</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$sel_exst_foll2="SELECT * FROM inquiry where 1 and status = 'Enquiry' and employee_id='".$data_couc['admin_id']."' ".$search_cm_id." and (response !='7' and response!='8' or response is NULL) ".$followup_from_date." ".$end_followup_date." order by inquiry_id desc";
				$ptr_exst_foll2=mysql_query($sel_exst_foll2);
				$total_foll=mysql_num_rows($ptr_exst_foll2);
				?>
				<td align="center"><strong><?php echo round($total_foll,2); ?></strong></td>
				<?php
			}
			?>
        </tr>
        				
        <!--================================No of Invalid leads done Today==========================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>16</strong></td>
        	<td align="center"><strong>No of Invalid leads done Today</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_inv="select DISTINCT(student_id) from followup_details where 1 and response='8' and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date."";
				$query_inv=mysql_query($select_inv);
				$count_invalid=mysql_num_rows($query_inv);
				
				?>
				<td align="center"><strong><?php echo round($count_invalid,2); ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================No of Not Interested leads done Today====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>17</strong></td>
        	<td align="center"><strong>No of Not Interested leads done Today</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_ni="select DISTINCT(student_id) from followup_details where 1 and response='7' and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date."";
				$query_ni=mysql_query($select_ni);
				$count_ni=mysql_num_rows($query_ni);
				?>
				<td align="center"><strong><?php echo round($count_ni,2); ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================Today's Realised Amount ====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>18</strong></td>
        	<td align="center"><strong>Today's Realised Amount</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$sel_real_amnt="select SUM(amount) as total_amnt from invoice where 1 and assigned_to='".$data_couc['admin_id']."' ".$search_cm_id."  ".$_SESSION['where']."  ".$added_date." ";
				$query_real_amnt=mysql_query($sel_real_amnt);
				$data_real_amnt=mysql_fetch_array($query_real_amnt);
				?>
				<td align="center"><strong><?php if($data_real_amnt['total_amnt'] > 0) echo round($data_real_amnt['total_amnt'],2); else echo '0'; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================Amount Realised till date====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>19</strong></td>
        	<td align="center"><strong>Amount Realised Till Date (Monthly)</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$sel_real_month_amnt="select SUM(amount) as total_amnt from invoice where 1 and assigned_to='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']." and DATE(`added_date`) >= '".$date_for_month."-01'  ".$end_added_date." ";
				$query_real_month_amnt=mysql_query($sel_real_month_amnt);
				$data_real_month_amnt=mysql_fetch_array($query_real_month_amnt);
				?>
				<td align="center"><strong><?php if($data_real_month_amnt['total_amnt'] >0) echo round($data_real_month_amnt['total_amnt'],2); else echo '0'; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================Recovery for this Month ====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>20</strong></td>
        	<td align="center"><strong>Recovery for this Month</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				//$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' ".$search_cm_id_e."  and DATE(i.installment_date) >= '".$date_for_month."-01'  ".$last_installment_date_i." ";
				$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and (e.student_status ='Active' or e.student_status is NULL) and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' ".$search_cm_id_e."  and DATE(i.installment_date) >= '".$date_for_month."-01'  ".$last_installment_date_i." and (e.added_date NOT BETWEEN ('".$first_date_month."') and ('".$last_date_month."')) ";
				$query_recv_amnt=mysql_query($sel_recv_amnt);
				$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
				?>
				<td align="center"><strong><?php if($data_recv_amnt['total_amnt'] > 0 ) echo round($data_recv_amnt['total_amnt']); else echo 0; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================Recovery Realised for this month till date ====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>21</strong></td>
        	<td align="center"><strong>Recovery Realised for this month till date</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$sel_rel_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and (e.student_status ='Active' or e.student_status is NULL) and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' ".$search_cm_id_e."  and DATE(i.installment_date) >= '".$date_for_month."-01'  ".$end_installment_date_i." ";
				$query_rel_amnt=mysql_query($sel_rel_amnt);
				$data_rel_amnt=mysql_fetch_array($query_rel_amnt);
				?>
				<td align="center"><strong><?php if($data_rel_amnt['total_amnt'] > 0) echo round($data_rel_amnt['total_amnt'],2); else echo '0'; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================Recovery Pending of Last Month====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>22</strong></td>
        	<td align="center"><strong>Recovery Pending of Last Month</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and (e.student_status ='Active' or e.student_status is NULL) and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' ".$search_cm_id_e."  ".$from_last_installment_month." ".$to_last_installment_month." ";
				$query_recv_amnt=mysql_query($sel_recv_amnt);
				$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
				?>
				<td align="center"><strong><?php if($data_recv_amnt['total_amnt']) echo round($data_recv_amnt['total_amnt'],2); else echo '0'; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================Recovery Pending of Second Last Month====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>23</strong></td>
        	<td align="center"><strong>Recovery Pending of Second Last Month</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and (e.student_status ='Active' or e.student_status is NULL) and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' ".$search_cm_id_e."  ".$from_second_last_installment_month." ".$to_second_last_installment_month." ";
				$query_recv_amnt=mysql_query($sel_recv_amnt);
				$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
				?>
				<td align="center"><strong><?php if($data_recv_amnt['total_amnt']) echo round($data_recv_amnt['total_amnt'],2); else echo '0'; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================Recovery Pending since before second last month====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>24</strong></td>
        	<td align="center"><strong>Recovery Pending since before second last month</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$sel_recv_amnt="select SUM(i.installment_amount) as total_amnt from installment i, enrollment e where 1 and (e.student_status ='Active' or e.student_status is NULL) and i.enroll_id=e.enroll_id and e.assigned_to='".$data_couc['admin_id']."' ".$search_cm_id_e."  ".$from_second_last_installment_month." ".$end_installment_date_i." ";
				$query_recv_amnt=mysql_query($sel_recv_amnt);
				$data_recv_amnt=mysql_fetch_array($query_recv_amnt);
				?>
				<td align="center"><strong><?php if($data_recv_amnt['total_amnt']) echo round($data_recv_amnt['total_amnt'],2); else echo '0'; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================No of Very Hot Leads (Last 30 days)====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>25</strong></td>
        	<td align="center"><strong>No of Very Hot Leads (Last 30 days)</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_vh="select inquiry_id from inquiry where 1 and lead_grade='very_hot' and employee_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$from_thirty_date." ".$end_added_date." ";
				$query_vh=mysql_query($select_vh);
				$count_vh=mysql_num_rows($query_vh);
				?>
				<td align="center"><strong><?php if($count_vh) echo round($count_vh,2); else echo '0'; ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================No of  Hot Leads (Last 30 days)====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>26</strong></td>
        	<td align="center"><strong>No of  Hot Leads (Last 30 days)</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_hot="select inquiry_id from inquiry where 1 and lead_grade='hot' and employee_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$from_thirty_date." ".$end_added_date." ";
				$query_hot=mysql_query($select_hot);
				$count_hot=mysql_num_rows($query_hot);
				?>
				<td align="center"><strong><?php echo round($count_hot,2); ?></strong></td>
				<?php
			}
			?>
        </tr>
        <!--=============================================No of Warm Leads (Last 30 days)====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>27</strong></td>
        	<td align="center"><strong>No of Warm Leads (Last 30 days)</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_warm="select inquiry_id from inquiry where 1 and lead_grade='warm' and employee_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$from_thirty_date." ".$end_added_date." ";
				$query_warm=mysql_query($select_warm);
				$count_warm=mysql_num_rows($query_warm);
				?>
				<td align="center"><strong><?php if($count_warm) echo round($count_warm,2); else echo '0'; ?></strong></td>
				<?php
			}
			?>
        </tr>
        
        <!--=============================================Booking Amount Funnel (Last 30 Days)====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>28</strong></td>
        	<td align="center"><strong>Booking Amount Funnel (Last 30 Days)</strong></td>
			<?php
			$array = array();
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$crs_price ='';
				$select_ni="select course_id from inquiry where 1 and (lead_grade='very_hot' or lead_grade='hot') and employee_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$from_thirty_date." ".$to_last_day_of_current_month." ";
				$query_ni=mysql_query($select_ni);
				if($count_ni=mysql_num_rows($query_ni))
				{
					$data_course_id=mysql_fetch_array($query_ni);
					$select_price="select course_price from courses_price where course_id='".$data_course_id['course_id']."'";
					$ptr_crs=mysql_query($select_price);
					$data_crs_price=mysql_fetch_array($ptr_crs);
					$crs_price +=$data_crs_price['course_price'];
					?>
					<td align="center"><strong><?php echo round($crs_price,2); ?></strong></td>
					<?php
				}
				else
				{
					?>
					<td align="center"><strong><?php echo 0; ?></strong></td>
					<?php
				}
				
				$sel_tot="select enroll_id,net_fees from enrollment where 1 and (student_status ='Active' or student_status is NULL) and assigned_to='".$data_couc['admin_id']."' ".$search_cm_id." ".$_SESSION['where']." ".$first_day_of_current_month." ".$to_last_day_of_current_month." ";
				$ptr_tots=mysql_query($sel_tot);
				$tot_num=mysql_num_rows($ptr_tots);
				while($data_tot=mysql_fetch_array($ptr_tots))
				{
					$sle_inv="select SUM(amount) as total_amnt from invoice where 1 and enroll_id='".$data_tot['enroll_id']."' ".$search_cm_id." ".$_SESSION['where']." ".$first_day_of_current_month." ".$to_last_day_of_current_month." ";
					$ptr_inv=mysql_query($sle_inv);
					$data_inv=mysql_fetch_array($ptr_inv);
					$course_fee=$data_tot['net_fees'];
					$paid_amount=$data_inv['total_amnt'];
					$cal_per=number_format(($paid_amount / $course_fee)*100,2);
					$tot_per +=$cal_per;
				}
				$month_enroll_perc=number_format($tot_per / $tot_num,2);
				$realised_funnel= $month_enroll_perc * $crs_price / 100 ;
				array_push($array, $realised_funnel);
			}
			?>
        </tr>
        <!--=============================================Realised Amount Funnel====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>29</strong></td>
        	<td align="center"><strong>Realised Amount Funnel</strong></td>
			<?php
			/*for($i=0;$i<count($array);$i++)
			{}*/
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			$i=0;
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				?>
                <td align="center"><strong><?php echo round($array[$i],2); ?></strong></td>
                <?php
				$i++;
			}
			?>
        </tr>
        <!--=============================================No of student/ client Review ====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>30</strong></td>
        	<td align="center"><strong>No of Student Review</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$select_rev="select * from action_final i, enrollment e where 1 and (e.student_status ='Active' or e.student_status is NULL) and i.enroll_id=e.enroll_id and i.google_action='yes' and e.employee_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$cm_ids." ".$search_cm_id_e." ".$added_date_i." ";
				$query_rev=mysql_query($select_rev);
				$count_review=mysql_num_rows($query_rev);
				?>
                <td align="center"><strong><?php echo $count_review; ?></strong></td>
                <?php
            }
			?>
        </tr>
        <!--=============================================No. of student/ client Testimonial====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>31</strong></td>
        	<td align="center"><strong>No. of Student Testimonial</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$crs_price ='';
				$select_ni="select * from action_final i, enrollment e where 1 and (e.student_status ='Active' or e.student_status is NULL) and i.enroll_id=e.enroll_id and i.video_action='yes' and e.employee_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$cm_ids." ".$search_cm_id_e." ".$added_date_i." ";
				$query_ni=mysql_query($select_ni);
				if($count_testominal=mysql_num_rows($query_ni))
				{
					?>
					<td align="center"><strong><?php echo $count_testominal; ?></strong></td>
					<?php
				}
				else
				{
					?>
					<td align="center">0</td>
					<?php
				}
            }
			?>
        </tr>
        <!--=============================================No. of Models added in Model Bank====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>32</strong></td>
        	<td align="center"><strong>No. of Models added in Model Bank</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$crs_price ='';
				$select_model="select model_id from model_bank where 1 and admin_id='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$added_date."  ";
				$query_model=mysql_query($select_model);
				if($count_model=mysql_num_rows($query_model))
				{
					?>
					<td align="center"><strong><?php echo $count_model; ?></strong></td>
					<?php
				}
				else
				{
					?>
					<td align="center">0</td>
					<?php
				}
            }
			?>
		</tr>
        <!--=============================================DSR report matched====================================================-->
        <tr class="grey_td" >
        	<td align="center" width="12%"><strong>33</strong></td>
        	<td align="center"><strong>DSR Report Matched</strong></td>
			<?php
			$select_counc="select * from site_setting where 1 and (type='Z' or type='A' or type='C') and system_status='Enabled' ".$_SESSION['where']." ".$where_staff_id." ".$search_cm_id." order by admin_id asc";
			$ptr_counc=mysql_query($select_counc);
			while($data_couc=mysql_fetch_array($ptr_counc))
			{
				$dsr_matched ='';
				$select_ni="select * from dsr_match_reprot where 1 and added_by='".$data_couc['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$dsr_added_date." ";
				$query_ni=mysql_query($select_ni);
				if($count_ni=mysql_num_rows($query_ni))
				{
					$data_course_id=mysql_fetch_array($query_ni);
					?>
					<td align="center"><strong><?php echo $data_course_id['status']; ?></strong></td>
					<?php
				}
				else
				{
					?>
					<td align="center">--</td>
					<?php
				}
            }
			?>
        </tr>
    </form>
    <?php 
	//} 
	/*else
		echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';*/?>
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
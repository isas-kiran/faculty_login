<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Stack Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script src="js/chosen.jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            $("#staff_id").chosen({allow_single_deselect:true});
			<?php 
			if($_SESSION['type']=="S")
			{
				?>
				$("#branch_name").chosen({allow_single_deselect:true});
				<?php
			}
			?>
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
function getstaffrecords() 
{ 
$('#loading_spinners').show();
	var staff_id = $("#staff_id").val();
	var start_date = $("#start_date").val();
	var end_date = $("#end_date").val();
	
	if(staff_id==''){
		alert("Please Select Staff");
		return false;
	}
	if(start_date==''){
		alert("Please Enter Start Date");
		return false;
	}
	if(end_date==''){
		alert("Please Enter End Date");
		return false;
	}
	
	/*$.ajax({ 
		type: 'post',
		url: 'stack_ajax.php',
		data: { staff_id: staff_id,start_date:start_date,end_date:end_date},
		
	}).done(function(responseData) {
	$("#show_stack_report").html(responseData);
	}).fail(function() {
		console.log('Failed');
	});*/
	var data1="staff_id="+staff_id+"&start_date="+start_date+"&end_date="+end_date;	
	//alert(data1);
	$.ajax({
	url: "stack_ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
		if(html !='')
		{
			document.getElementById("show_stack_report").innerHTML=html;
			 $('#loading_spinners').hide();
		}
	},
    error:function(exception){alert('Exception:'+exception);}
	});
}
function getstaff(branch_id)
{
	var data1="action=stack_report&branch_id="+branch_id;	
	//alert(data1);
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
<style>
#loading_spinners { display:none; }

.table1, .th1, .td1 {
    border: 1px solid;
    border-collapse: collapse;

    padding: 4px;
	font-size:12px;
}
.td2 {
   text-align:center;
}
input {
	text-align:center;
}
</style>
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
        <img id="loading_spinners" src="images/loading.gif">
            <table cellspacing="0" cellpadding="0"  width="97%">
                <tr><td>
					<form method="get" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
					<table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
                	<tr>
                    <?php 
                    if($_SESSION['type']=='S')
                    { ?>
                        <td style="width: 8%;">Select branch</td> 
                        <td colspan="2" align="left" style="padding-left:0px;width: 12%;">
                        <?php
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                        $query_branch = mysql_query($sel_branch);
                        $total_Branch = mysql_num_rows($query_branch);
                        echo '<select id="branch_name" name="branch_name" style="width:120px" onchange="getstaff(this.value)">';
                        while($row_branch = mysql_fetch_array($query_branch))
                        {
                            ?>
                            <option value="<?php if($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name']; ?>"> <?php echo $row_branch['branch_name']; ?></option>
                            <?php
                        }
                        echo '</select></td>';
                    }
                    else 
                    {
                        ?>
                        <td colspan="2" align="left">
                        <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                        </td>
                        <?php 
                    }?>
                    <td width="10%" align="center"><strong>Select Staff</strong></td>
                    <td width="10%" align="center" style="padding-left:0px;width: 15%;" id="staff_details">
                    	<select name="staff_id" id="staff_id" class="input_select" style="width:150px">
                            <option value="">Select Staff</option>
							<?php
                            $sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' and type='C' order by name asc"; 
                            $ptr_name=mysql_query($sle_name);
                            while($data_name=mysql_fetch_array($ptr_name))
                            {
                                $selected='';
                                if($data_name['admin_id'] == $_GET['assigned_to'])
                                {
                                    $selected='selected="selected"';
                                }
                                echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td width="10%" align="center"><strong>Select From Date</strong></td>
                    <td width="10%" align="center"><input type="text" name="start_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="start_date" title="From Date" value="<?php if($_REQUEST['start_date']!="From Date") echo $_REQUEST['start_date'];?>"></td>
                    <td width="10%" align="center"><strong>Select To Date</strong></td>
                    <td width="10%" align="center"><input type="text" name="end_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="end_date"  title="To Date" value="<?php if($_REQUEST['end_date']!="To Date") echo $_REQUEST['end_date'];?>"></td>
                    <td width="10%" align="center"><input type="submit" name="search" id="search" value="Search" 	/></td>
                 	</tr>
            		</table>
            		</form> 
                	</td>
            	</tr>
        	</table>
            <?php
			if($_REQUEST['staff_id']!='')
			{
				$staff_id=$_REQUEST['staff_id'];
				$start_date=$_REQUEST['start_date'];
				$end_date=$_REQUEST['end_date'];
				if($start_date)
				{
					$frm_date=explode("/",$start_date);
					$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
					$followup_from_date=" DATE(followup_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
					$enquiry_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
					$start_date=date('Y-m-d',strtotime($frm_dates));
				}
				else
				{
					$enquiry_from_date=""; 
					if($_REQUEST['to_date']=='')
					{
						$enquiry_from_date=" and DATE(`added_date`) >='".date('Y-m-d')."'";
					}
					else
					{
						$enquiry_from_date="";
						$start_date='';
					}
				}
				if($end_date)
				{
					$to_date=explode("/",$end_date);
					$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
					$followup_to_date=" and DATE(followup_date)<='".date('Y-m-d',strtotime($to_dates))."' ";
					$enquiry_to_date=" and DATE(added_date)<='".date('Y-m-d',strtotime($to_dates))."'";
					$end_date=date('Y-m-d',strtotime($to_dates));
				}
				else
				{
					$enquiry_to_date=" and DATE(`added_date`)<='".date('Y-m-d')."'";
					$end_date=date('Y-m-d');
				}
				?>
                <table border="0" cellspacing="15" cellpadding="0" class="table" width="97%">
                    <tr>
                        <td><div id="show_stack_report"></div>
                            <table class="">
                            <?php
                            $sql_query= "select name,admin_id from site_setting where 1 and admin_id='".$staff_id."' ".$_SESSION['where']." ";
                            $db_query=mysql_query($sql_query); //and system_status='Enabled'
                            $no_of_records=mysql_num_rows($db_query);
                            if($no_of_records)
                            {
                                ?>
                                <form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                                <input type="hidden" name="formAction" id="formAction" value=""/>
                                <tr class="grey_td" >
                                <td width="4%" align="center"><strong>Sr. No.</strong></td>
                                <td width="10%" align="center"><strong>Name</strong></td>
                                <td width="10%" align="center"><strong>Total New Enq. Assign</strong></td>
                                <td width="10%" align="center"><strong>Total New Leads Called</strong></td>
                                <td width="10%" align="center"><strong>Total Exist. Followups Calls Done</strong></td>
                                <td width="10%" align="center"><strong>Total Walkin handled</strong></td>
                                <td width="10%" align="center"><strong>Total Enrollments</strong></td>
                                <!--<td width="10%" align="center"><strong>Down Payment</strong></td>
                                <td width="10%" align="center"><strong>Installment amount</strong></td>
                                <td width="10%" align="center"><strong>Total Amount</strong></td>-->
                                </tr>
                                <?php
                                $i=1;
                                $total_assign=0;
                                $total_pending=0;
                                $total_completed=0;
                                $total_walkin=0;
                                $total_enrolled=0;
                                while($val_query=mysql_fetch_array($db_query))
                                {
                                    $name = '';
                                    if($bgColorCounter%2==0)
                                        $bgcolor='class="grey_td"';
                                    else
                                        $bgcolor="";                
                                    $listed_record_id=$val_query['admin_id']; 
                                    include "include/paging_script.php";
                                    
                                    echo '<td align="center">'.$i.'</td>';
                                    echo '<td align="center">'.$val_query['name'].'</td>';
                                    
                                   	$select_enquiry="select inquiry_id, followup_date from inquiry where 1 and employee_id='".$val_query['admin_id']."'  ".$search_cm_id." ".$_SESSION['where']."".$enquiry_from_date." ".$enquiry_to_date."";
                                    $query_enquiery=mysql_query($select_enquiry);
                                    $count_enquiry=mysql_num_rows($query_enquiery);
                                    echo '<td align="center">'.$count_enquiry.'</td>';
                                    $total_assign +=$count_enquiry;
                                    $cnt_new_followup=0;
                                    $cnt_pd=0;
                                    while($data_new_inq=mysql_fetch_array($query_enquiery))
                                    {
                                        if($data_new_inq['followup_date']!='' || $data_new_inq['followup_date'] !=NULL)
                                        {
                                            $cnt_new_followup +=1; 
                                        }
                                        else
                                        {
                                            $cnt_pd +=1;
                                        }
                                    }
                                    
                                    $cnt_exist=0;
                                    $cnt_new=0;
                                    $sel_exst_foll="select DISTINCT(student_id) from followup_details where admin_id='".$val_query['admin_id']."' ".$enquiry_from_date." ".$enquiry_to_date." order by student_id ";
                                    $ptr_exst_foll=mysql_query($sel_exst_foll);
                                    $cnt_exist=0;
                                    $cnt_new=0;
                                    if($cnt_foll=mysql_num_rows($ptr_exst_foll))
                                    {
                                        while($data_foll=mysql_fetch_array($ptr_exst_foll))
                                        {
                                            $sele_f="select followup_id from followup_details where student_id='".$data_foll['student_id']."' ";
                                            $ptr_f=mysql_query($sele_f);
                                            if(mysql_num_rows($ptr_f) >1)
                                            {
                                                $cnt_exist +=1;
                                            }
                                            else
                                            {
                                                $cnt_new +=1;
                                            }
                                        }
                                    }
                                    echo '<td align="center">'.$cnt_new_followup.'</td>';
                                    $total_new +=$cnt_new_followup;
                                    echo '<td align="center">'.$cnt_exist.'</td>';
                                    $total_exist +=$cnt_exist;
                                    
                                    $select_enq_walkin="select DISTINCT(student_id) as total_walkedin from followup_details where 1 and response='1' and admin_id='".$val_query['admin_id']."' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date."";
                                    $query_enq_walkin=mysql_query($select_enq_walkin);
                                    $total_walkedin=mysql_num_rows($query_enq_walkin);
                                        
                                    echo '<td align="center"> '.$total_walkedin.'</td>';
                                    $total_walkin +=$data_walkedin['total_walkedin'];
                                    
                                    $select_inst="select enroll_id from enrollment where 1 and assigned_to='".$val_query['admin_id']."' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
                                    $query_inst=mysql_query($select_inst);
                                    $count_enroll=mysql_num_rows($query_inst);
                                    echo '<td align="center">'.$count_enroll.'</td>';
                                    $total_enrolled +=$count_enroll;
                                    
                                    /*$sel_down_amnt="select SUM(amount) as total_amnt from invoice where 1 and type='down_payment' and assigned_to='".$val_query['admin_id']."' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
                                    $query_down_amnt=mysql_query($sel_down_amnt);
                                    $data_down_amnt=mysql_fetch_array($query_down_amnt);
                                    echo '<td align="center">'.intval($data_down_amnt['total_amnt']).'</td>';
                                    
                                    $sel_recv_amnt="select SUM(amount) as total_amnt from invoice where 1 and (type!='down_payment' or type is NULL) and assigned_to='".$val_query['admin_id']."' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
                                    $query_recv_amnt=mysql_query($sel_recv_amnt);
                                    $data_recv_amnt=mysql_fetch_array($query_recv_amnt);
                                    echo '<td align="center">'.intval($data_recv_amnt['total_amnt']).'</td>';
                                    
                                    $select_amnt="select SUM(amount) as total_amnt from invoice where 1 and assigned_to='".$val_query['admin_id']."' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
                                    $query_amnt=mysql_query($select_amnt);
                                    $data_amnt=mysql_fetch_array($query_amnt);
                                    echo '<td align="center">'.intval($data_amnt['total_amnt']).'</td>';
                                    $total_amnt +=$data_amnt['total_amnt'];*/
                                    echo '</tr>'; 
                                    $i++;
                                }
                                ?>
                                </form>
                                <?php
                            }
                            ?>
                            </table>
                        </td>
                    </tr>
                </table>
                <?php 
			}
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
</body>
</html>

<?php include 'inc_classes.php';?>
<style>
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
</br>
<?php
$staff_id=$_POST['staff_id'];
$start_date=$_POST['start_date'];
$end_date=$_POST['end_date'];
if($staff_id!='')
{
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
	
	$search_cm_id='';
	$cm_ids=$_SESSION['cm_id'];
	if($_SESSION['type']=="S")
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
			$search_cm_id='';
		}
	}
?>
<table class="">
	<?php
    $sql_query= "select * from site_setting where 1 and admin_id='".$staff_id."' ".$_SESSION['where']." ";
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
        <td width="10%" align="center"><strong>Total Enrollments / Upgrade</strong></td>
        <td width="10%" align="center"><strong>Down Payment</strong></td>
        <td width="10%" align="center"><strong>Installment amount</strong></td>
        <td width="10%" align="center"><strong>Total Amount</strong></td>
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
            
           	$select_enquiry="select inquiry_id, followup_date from inquiry where 1 and employee_id='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']."".$enquiry_from_date." ".$enquiry_to_date."";
            $query_enquiery=mysql_query($select_enquiry);
            $count_enquiry=mysql_num_rows($query_enquiery);
            echo '<td align="center"><a target="_blank" href="show_students.php?assigned_to='.$val_query['admin_id'].'&branch_name='.$_REQUEST['branch_name'].'&start_date='.$_REQUEST['start_date'].'&end_date='.$_REQUEST['end_date'].'">'.$count_enquiry.'</a></td>';
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
            
			
			//total new followup done
			
			//total existing folllowup done
			
            $cnt_exist=0;
            $cnt_new=0;
			"<br/>".$sel_exst_foll="select DISTINCT(student_id) from followup_details where admin_id='".$val_query['admin_id']."' ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date." order by student_id ";
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
            echo '<td align="center"><a target="_blank" href="show_students.php?assigned_to='.$val_query['admin_id'].'&followup_by=followup_completed&branch_name='.$_REQUEST['branch_name'].'&start_date='.$_REQUEST['start_date'].'&end_date='.$_REQUEST['end_date'].'">'.$cnt_new_followup.'</a></td>';
            $total_new +=$cnt_new_followup;
			
            echo'<td align="center"><a target="_blank" href="followup_record.php?stack_report=1&employee_id='.$val_query['admin_id'].'&branch_name='.$_REQUEST['branch_name'].'&from_date='.$_REQUEST['start_date'].'&to_date='.$_REQUEST['end_date'].' ">'.$cnt_exist.'</a></td>';
            $total_exist +=$cnt_exist;
            
           	$select_enq_walkin="select DISTINCT(student_id) as total_walkedin from followup_details where 1 and response='1' and admin_id='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date."";
            $query_enq_walkin=mysql_query($select_enq_walkin);
			$total_walkedin=mysql_num_rows($query_enq_walkin);
				
            echo '<td align="center"><a target="_blank" href="followup_record.php?stack_report=1&response=1&employee_id='.$val_query['admin_id'].'&branch_name='.$_REQUEST['branch_name'].'&from_date='.$_REQUEST['start_date'].'&to_date='.$_REQUEST['end_date'].' ">'.$total_walkedin.'</a></td>';
            $total_walkin +=$data_walkedin['total_walkedin'];
            		
			$select_inst="select enroll_id from enrollment where 1 and ref_id='0' and assigned_to='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date." ";
			$query_inst=mysql_query($select_inst);
			$count_enroll=mysql_num_rows($query_inst);
			
			$sel_enroll="select enroll_id from enrollment where 1 and ref_id!='0' and assigned_to='".$val_query['admin_id']."' ".$_SESSION['where']." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date." ";
			$query_enroll=mysql_query($sel_enroll);
			$cnt_enroll=mysql_num_rows($query_enroll);
			
            echo '<td align="center"><a target="_blank" href="total_enrollment.php?assign_to='.$val_query['admin_id'].'&branch_name='.$_REQUEST['branch_name'].'&start_date='.$_REQUEST['start_date'].'&end_date='.$_REQUEST['end_date'].'">'.$count_enroll.' / '.$cnt_enroll.'</a></td>';
            $total_enrolled +=$count_enroll;
            
			$sel_down_amnt="select SUM(amount) as total_amnt from invoice where 1 and type='down_payment' and assigned_to='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
            $query_down_amnt=mysql_query($sel_down_amnt);
            $data_down_amnt=mysql_fetch_array($query_down_amnt);
            echo '<td align="center">'.intval($data_down_amnt['total_amnt']).'</td>';
			
			$sel_recv_amnt="select SUM(amount) as total_amnt from invoice where 1 and (type!='down_payment' or type is NULL) and assigned_to='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
            $query_recv_amnt=mysql_query($sel_recv_amnt);
            $data_recv_amnt=mysql_fetch_array($query_recv_amnt);
            echo '<td align="center">'.intval($data_recv_amnt['total_amnt']).'</td>';
			
            $select_amnt="select SUM(amount) as total_amnt from invoice where 1 and assigned_to='".$val_query['admin_id']."' ".$search_cm_id." ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ";
            $query_amnt=mysql_query($select_amnt);
            $data_amnt=mysql_fetch_array($query_amnt);
            echo '<td align="center">'.intval($data_amnt['total_amnt']).'</td>';
            $total_amnt +=$data_amnt['total_amnt'];
            echo '</tr>'; 
            $i++;
        }
        ?>
        
    </form>
    <?php
	}
	?>
</table>
<?php
}
?>
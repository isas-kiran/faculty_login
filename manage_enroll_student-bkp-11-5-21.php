<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
}
else
$record_id='';


$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='39'";
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
<title>Manage Enroll Student</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
			else if(action=="change_owner")
			{
				$( ".new_custom_course" ).dialog({
					width: '500',
					height:'150'
				});
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
		
function action_status(val,status)
{
	var data1="action=enroll_action_status&enroll_id="+val+"&status="+status;
	//alert(data1);
	$.ajax({
	url: "set_status.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		alert(html);
		
		setTimeout('document.location.href="manage_enroll_student.php?record_id=<?php echo $record_id; ?>";',500);
	}
	});
}
</script>

<style>
.dot {
    height: 25px;
    width: 25px;
    background-color: #FEF1E3;
    border-radius: 50%;
    display: inline-block;
}
.middle > * {
  vertical-align: middle;
  padding:1px;
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
    	<td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
    	<td class="top_right"></td>
  	</tr>
    <?php 
	$sep_url_string='';
	$sep_url= explode("?",$_SERVER['REQUEST_URI']);
	if($sep_url[1] !='')
	{
		$sep_url_string="?".$sep_url[1];
	}
	
	if($_POST['formAction'])
	{
		if($_POST['formAction']=="delete")
		{
			for($r=0;$r<count($_POST['chkRecords']);$r++)
			{
				$del_record_id=$_POST['chkRecords'][$r];
				$sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."enrollment where enroll_id ='".$del_record_id."'";
				$my_query=mysql_query($sql_query);
				
				if(mysql_num_rows($my_query))
				{       
					$data_delete=mysql_fetch_array($my_query);         
					
					"<br>".$sql_query= "SELECT name FROM enrollment where enroll_id ='".$del_record_id."' ";              
					$query=mysql_query($sql_query);
					$fetch=mysql_fetch_array($query);
					
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_enroll_student','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert); 
												 
					$delete_query="delete from ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
					$db->query($delete_query);      
					
					$delete_query_invoice="delete from ".$GLOBALS["pre_db"]."invoice where enroll_id='".$del_record_id."'";
					$db->query($delete_query_invoice);
					
					$delete_query_inst="delete from ".$GLOBALS["pre_db"]."installment where enroll_id='".$del_record_id."'";
					$db->query($delete_query_inst);    
					
					$delete_query_inst_his="delete from ".$GLOBALS["pre_db"]."installment_history where enroll_id='".$del_record_id."'";
					$db->query($delete_query_inst_his);  
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
										Ok: function() { $( this ).dialog( "close" );}
									 }
					});
				});
				setTimeout('document.location.href="manage_enroll.php<?php echo $sep_url_string; ?>";',1000);
			</script>
			<?php                            
		}
		else if($_POST['formAction']=="change_owner")
		{
			if($_POST['councillior_admin_id']!="")
			{
				$total_count=count($_POST['chkRecords']);
				for($r=0;$r<count($_POST['chkRecords']);$r++)
				{
					$sel_record_id=$_POST['chkRecords'][$r];
					$councillior_id=$_POST['councillior_admin_id'];
					
					$sel_cm="select cm_id from site_setting where admin_id='".$councillior_id."'";
					$ptr_sel_cm=mysql_query($sel_cm);
					$data_center_m=mysql_fetch_array($ptr_sel_cm);
					
					$sql_query= "SELECT inquiry_id,admin_id,cm_id FROM inquiry where inquiry_id ='".$sel_record_id."'";
					$my_query=mysql_query($sql_query);
					if(mysql_num_rows($my_query))
					{
						$data_cm=mysql_fetch_array($my_query);             
						$update_query="update inquiry set employee_id='".$councillior_id."',cm_id='".$data_center_m['cm_id']."',transfer_from_cm_id='".$data_cm['cm_id']."',transfer_from_admin_id='".$data_cm['admin_id']."' where inquiry_id='".$sel_record_id."'";
						$query=mysql_query($update_query);    
					}
				}
				?>
				<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) owner transfer successfully</p></center></div>
				<script type="text/javascript">
				// $("#statusChangesDiv").dialog();
					$(document).ready(function() {
						$( "#statusChangesDiv" ).dialog({
								modal: true,
								buttons: {
											Ok: function() { $( this ).dialog( "close" );}
										 }
						});
					});
					//setTimeout('document.location.href="manage_student.php";',2000);
				</script>
				<?php 
			}
			else
			{
				?>
				<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Error : Councillor Not Selected</p></center></div>
				<?php
			}
		}   
	}
	if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
	{
		$del_record_id=$_REQUEST['record_id'];
		$sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{
			"<br>".$sql_query= "SELECT name FROM enrollment where enroll_id ='".$del_record_id."' ";              
			$query=mysql_query($sql_query);
			$fetch=mysql_fetch_array($query);
			
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_enroll_student','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert); 
							
			$delete_query="delete from ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
			$db->query($delete_query);
			
			$delete_query_invoice="delete from ".$GLOBALS["pre_db"]."invoice where enroll_id='".$del_record_id."'";
			$db->query($delete_query_invoice);
			
			$delete_query_inst="delete from ".$GLOBALS["pre_db"]."installment where enroll_id='".$del_record_id."'";
			$db->query($delete_query_inst);    
			
			$delete_query_inst_his="delete from ".$GLOBALS["pre_db"]."installment_history where enroll_id='".$del_record_id."'";
			$db->query($delete_query_inst_his);  
			?>
			<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
			<script type="text/javascript">
			// $("#statusChangesDiv").dialog();
				$(document).ready(function() {
					$( "#statusChangesDiv" ).dialog({
							modal: true,
							buttons: {
										Ok: function() { $( this ).dialog( "close" );}
									 }
					});
				});
				setTimeout('document.location.href="manage_enroll.php<?php echo $sep_url_string; ?>";',1000);
			</script>
			<?php
		}
	}
	?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
		<table cellspacing="0" cellpadding="0" class="table" width="98%">
  		<tr class="head_td">
    		<td colspan="16">
        	<form method="get" name="search">
			<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <?php
				if($_SESSION['type']=='S' || $_SESSION['type']=='A' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
					?>
                    <td width="20%">
                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <?php
						if($_SESSION['type']=='S' || $edit_access=='yes')
						{
							?>
							<option value="delete">Delete</option>
							<?php
						}
						?>
                        <option value="change_owner">Transfer admission to another branch</option>
                    </select>
                    </td>
                	<?php
				}
				?>
                <td class="rightAlign" > 
                	<table border="0" cellspacing="0" cellpadding="0" align="right">
                        <tr>
                        <td></td>
                        <td class="width5"></td>
                        <!--<td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>-->
                        <td class="width2"></td>
                        <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                        </tr>
                    </table>	
                </td>
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
                            $pre_keyword =" and (name like '%".$keyword."%' || username like '%".$keyword."%' || qualification like '%".$keyword."%')";
                        }                            
                        else
                            $pre_keyword="";
                        

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

                        if($_GET['order'] !='' && ($_GET['orderby']=='name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by enroll_id desc';                      
                           $sql_query= "SELECT * FROM enrollment where 1 and ref_id='".$record_id."' or enroll_id='".$record_id."' ".$_SESSION['where']." ".$pre_keyword." ".$select_directory.""; 
                       //echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                           	// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    						<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                            <input type="hidden" name="formAction" id="formAction" value=""/>
                            <input type="hidden" name="councillior_admin_id" id="councillior_admin_id" value=""  />
                            <?php
							$sql_query= "SELECT name,contact,mail,cm_id FROM enrollment where 1 and ref_id='".$record_id."' or enroll_id='".$record_id."' ".$_SESSION['where']." ";
						   	$ptr_name=mysql_query($sql_query); 
						   	$data_info=mysql_fetch_array($ptr_name);
						   
							$sel_branch="select branch_name from site_setting where cm_id='".$data_info['cm_id']."' and type='A'";
							$ptr_branch=mysql_query($sel_branch);
							$data_branch=mysql_fetch_array($ptr_branch);
									
							?>
                            <tr>
                                 <td colspan="10" style="font-size:14px"><strong>Name : </strong> <?php echo $data_info['name']; ?><br />
                                 <strong>Contact  :</strong> <img src="images/mobile-phone-8-16.ico"><?php echo $data_info['contact']; ?><br />
                                 <strong>Email : </strong> <img src="images/mail.png"><?php echo $data_info['mail']; ?><br />
                                 <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
								 {?>
                                 <strong>Branch : </strong> <?php echo $data_branch['branch_name']; ?>
                                 <?php }?>
                                 </td>
                                 <?php
								$select_amnt1="select SUM(amount) as total from enroll_outstanding where 1 and enroll_id='".$record_id."' and type='outstanding' order by outstand_id";
								$ptr_amt1=mysql_query($select_amnt1);
								$total_amount1=0;
								if(mysql_num_rows($ptr_amt1))
								{
									$data_amnt1=mysql_fetch_array($ptr_amt1);
									$total_outstand=$data_amnt1['total'];
								}
								$select_amnt2="select SUM(amount) as total from enroll_outstanding where 1 and enroll_id='".$record_id."' and type='pay_to_student' order by outstand_id";
								$ptr_amt2=mysql_query($select_amnt2);
								$total_amount1=0;
								if(mysql_num_rows($ptr_amt2))
								{
									$data_amnt2=mysql_fetch_array($ptr_amt2);
									$total_pay=$data_amnt2['total'];
								}
								?>
                                 <td colspan="4" align="center" ><a href="enroll_outstanding.php?record_id=<?php echo $record_id; ?>" style="font-size:16px; font-weight:700; color:#06C">Debit/Credit</a> <br/><br/><br/><span style="float:left; color:#F00">Total Outstanding: <?php echo $total_outstand ?></span> <span style="float:right; color: #090">Total Pay: <?php echo $total_pay ?></span></td>
                                 </tr>
  <tr class="grey_td" >
    <!--<td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
    <td width="3%" align="center"><strong>Sr. No.</strong></td>
   <!-- <td width="15%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Name</strong></a> <?php echo $img1;?></td>-->
    <?
    if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
	{ 
		?>
		<!--<td width="5%" align="center"><strong>Branch name </strong></td>-->
		<? 
	}?>
    <td width="15%" align="center"><strong>Course Name</strong></td>
    <!--<td width="5%" align="center"><strong>Login </strong></td>-->
    <td width="4%" align="center"><strong>Down Fee</strong></td>
    <td width="5%" align="center"><strong>Balance Fee</strong></td>
    <td width="12%" colspan="2" align="center"><strong>Installments</strong></td>
    <td width="4%" align="center"><strong>Kit</strong></td>
    <!--<td width="15%" align="center"><strong>Kit</strong></td>-->
     <?
   // if($_SESSION['type']=='S' || $_SESSION['type']=='A' || $_SESSION['type']=='F')
	//{ ?>
    <!--<td width="5%" align="center"><strong>View Logsheet</strong></td>-->
    <? //}?>
    <td width="5%" align="center"><strong>View Payment</strong></td>
   
    <td width="5%" align="center"><strong>Add New Course</strong></td>
  
    <td width="4%" align="center"><strong>Details</strong></td>
    
	<td width="5%" align="center"><strong>Followup details</strong></td>
    
    <td width="5%" <?php if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ echo 'colspan="2"';} ?> align="center"><strong>Date</strong></td>
    <?php
    if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')//|| $_SESSION['name']=="isasfinance"
	{	
		?>
		<td width="4%" align="center" class="centerAlign"><strong>Action</strong></td>
		<?php
	}
	?>
	<!--<td width="10%" colspan="2" align="center" class="centerAlign"><strong>Verification Status</strong></td>-->
  </tr>
                            <?php
							$it=1;
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor=""; 
								
								/*if($val_query['action_status']=="not_verify")
								{
									$bgcolor='bgcolor="#FEF1E3"';
								}*/								
								$listed_invoce_id=$val_query['invoice_no'];               
                                $listed_record_id=$val_query['enroll_id']; 
								
                                $select_course = "select * from courses where course_id = '".$val_query['course_id']."'  ";
                                $val_course= $db->fetch_array($db->query($select_course));
								
								$is_parent=$val_course['is_parent'];
                                include "include/paging_script.php";
                                $alpha = array('0','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                                echo '<tr '.$bgcolor.' >';
								/* echo '<td align="center">';
								if($val_query['ref_id'] ==0)
								{
			
								}
								else
								{
									echo'<input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'">';
								}
								echo'</td>'; */
                                echo '<td align="center"><b>'.$alpha[$sr_no].'</b></td>';                                
                               /* echo '<td ><a href="enroll.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['name'].'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['contact'].' <br /> <img src="images/mail.png">'.$val_query['mail'].'</a></td>';*/
								/*if($_SESSION['type']=='S')
								  {
									  $sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
									  $ptr_branch=mysql_query($sel_branch);
									  $data_branch=mysql_fetch_array($ptr_branch);
									   echo '<td >'.$data_branch['branch_name'].'</td>';
								  }*/
								
                                echo '<td style="font-size:13px"><b>'.$val_course['course_name'].'</b><br><img src="images/indian-rupee-16.ico">'.$val_query['net_fees'].'/-(With Tax)</td>';
								//echo '<td ><img src="images/username.png" title="username">'.$val_query['username'].'<br /><img src="images/key.png" title="password">'.$val_query['pass'].'</td>';
								$disco ='';
								if(trim($val_query[discount]) !='0')
								$disco= '<br /> Discount: '.$val_query[discount];
								echo '<td >'.$val_query['down_payment'].$disco.'</td>';
								echo '<td >'.$val_query['balance_amt'].'</td>';
								echo '<td colspan="2">';
								$select_installments ="SELECT * FROM `installment` where enroll_id ='".$listed_record_id."' and course_id='".$val_query['course_id']."'  ";
								$ptr_installment = mysql_query($select_installments);
								if(mysql_num_rows($ptr_installment))
								{
									while($data_inst = mysql_fetch_array($ptr_installment))
									{
										$col_paid ='<font color="#006600">';
										if($data_inst['status'] =='not paid')
											$col_paid ='<font color="#FF3333">';
									 	echo $data_inst['installment_amount'].'/- '.$data_inst['installment_date'].' : '.$col_paid.$data_inst['status']."</font><br>";	
									}
									
								}
								else
								{
								}
								$sel_inv="SELECT * FROM invoice where enroll_id=".$listed_record_id." and status='paid'";
								$ptr_inv=mysql_query($sel_inv);
								while($data_inv=mysql_fetch_array($ptr_inv))
								{
									$col_paid_inv ='';
									$col_paid ='<font color="#FF3333">';
									$date_i=explode(" ",$data_inv['added_date']);
									$date_invs=$date_i[0];
									echo $data_inv['amount'].'/- '.$date_invs.' :<font color="#006600"> '.$data_inv['status'].'</font><br>';	
								}
								echo '</td>';
								$sql_invoice="select invoice_id from invoice where enroll_id='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' and installment_id='0' order by invoice_id desc ";
								$my_query_invoice=mysql_query($sql_invoice);
								$row_invoice= mysql_fetch_array($my_query_invoice);
								
								//$url_kit_strt='';
								//$url_kit_end='';
								//if($val_query['action_status']!="not_verify")
								//{
									$url_kit_strt='<a href="add_student_kit.php?record_id='.$listed_record_id.'">';
									$url_kit_end='</a>';
								//}
								echo '<td><center>'.$url_kit_strt.'<img src="images/items.jpg" border="0" title="View Logsheet" height="30px" width="30px">'.$url_kit_end.'</center></td>';
								
								/*echo '<td><center><a href="add_student_kit.php?record_id='.$listed_record_id.'"><img src="images/items.jpg" border="0" title="View Logsheet" height="30px" width="30px"></a></center></td>';*/
								//if($_SESSION['type']=='S')
								//{ 
								/*$url_log_strt='';
								$url_log_end='';
								if($val_query['action_status']!="not_verify")
								{
									$url_log_strt='<a href="view-logsheet.php?record_id='.$listed_record_id.'">';
									$url_log_end='</a>';
								}
								echo '<td><center>'.$url_log_strt.'<img src="images/logsheet.png" border="0" title="View Logsheet" height="30px" width="30px">'.$url_log_end.'</center></td>';*/
								 //}
								 
								//$url_inv_strt='';
								//$url_inv_end='';
								//if($val_query['action_status']!="not_verify")
								//{
									$url_inv_strt='<a href="invoice-summary.php?record_id='.$listed_record_id.'">';
									$url_inv_end='</a>';
								//}
								echo '<td><center>'.$url_inv_strt.'<img src="images/view_bill.jpg" border="0" width="30px" height="30px" title="View Payment">'.$url_inv_end.'</center></td>';
								if($val_query['ref_id'] ==0)
								{
									/* $url_crs_strt='';
									$url_crs_end='';
									if($val_query['action_status']!="not_verify")
									{
										$url_crs_strt='<a href="add_new_course.php?record_id='.$listed_record_id.'">';
										$url_crs_end='</a>';
									} */
									echo '<td><center><a href="add_new_course_gst.php?record_id='.$listed_record_id.'"><img src="images/course.png" border="0" width="30px" height="30px" title="Add New Course"></a></center></td>';
								}
								else
								{
									echo '<td><center><img src="images/fireeagle_location.png" border="0" width="30px" height="30px" title="New Course added"></center></td>';
								}
								
								//$url_pay_strt='';
								//$url_pay_end='';
								//if($val_query['action_status']!="not_verify")
								//{
									$url_pay_strt='<a href="action.php?record_id='.$record_id.'">';
									$url_pay_end='</a>';
								//} 
								echo '<td>';
								
								echo'<center>'.$url_pay_strt.'<img src="images/action.jpg" border="0" width="30px" height="30px" title="View Payment">'.$url_pay_end.'</center><br/>';
								
								$action_final="select action_final_id from action_final where enroll_id='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' and print_certificate_action='yes'";
								$ptr_action=mysql_query($action_final);
								if(mysql_num_rows($ptr_action))
								{
									echo'<center><img src="images/certificate_print.png" border="0" width="30px" height="30px" title="Certificate Printed"></center>';	
								}
								
								/*if($val_query['ref_id']==0)
								{*/									
								//}
								echo '</td>';
											
								//$url_foll_strt='';
								//$url_foll_end='';
								//if($val_query['action_status']!="not_verify")
								//{
									$url_foll_strt='<a href="installment_followup_details.php?record_id='.$listed_record_id.'&show=false">';
									$url_foll_end='</a>';
								//}
								echo '<td><center>'.$url_foll_strt.'<img src="images/followup.png" border="0" width="30px" height="30px" title="Installment Followup">'.$url_foll_end.'</center></td>';
								
								if($_SESSION['type']!='S' && $_SESSION['type']!='Z' && $_SESSION['type']!='LD' ){ $col='colspan="2"';}else $col='';
								echo '<td '.$col.' align="center">'.$val_query['added_date'].'</td>';
								
								if($_SESSION['type']=='S' ||  $edit_access=='yes' )//|| $_SESSION['name']=="isasfinance"
								{
									echo '<td align="center">';
									/*if($val_query['service_tax'] >0)
									{
										echo '<a href="enroll.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a> &nbsp;&nbsp;';
									}
									else if($val_query['cgst_tax'] >=0)
									{*/
										echo '<a href="enroll_gst.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
									//}
									//if($val_query['service_tax'] >0)
									//{
										//echo '<a href="" onClick="window.open(\'invoice-generate.php?record_id='.$row_invoice['invoice_id'].'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/invoice.png" title="View Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
									//}
									//else if($val_query['cgst_tax'] >=0)
									//{
										//echo '<a href="" onClick="window.open(\'invoice-generate_gst.php?record_id='.$row_invoice['invoice_id'].'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/gst1.png" width="21" height="21" title="View GST Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
									//}	
									
											   
									if($val_query['ref_id'] ==0)
									{
									}
									else
									{
										echo '&nbsp;&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
									}

									echo '</td>';
								}
								/*if($_SESSION['type'] =='S' || $_SESSION['type'] =='A' || $_SESSION['type'] =='AC')
								{
									echo'<td align="left" colspan="2">';
									if($val_query['action_status']=="not_verify" || $val_query['action_status']=="")
									{
										$urlstr='';
										if($_SESSION['type'] =='S' || $_SESSION['type'] =='A' || $_SESSION['type'] =='AC')
										{
											$urlstr='<a href="#" onClick="action_status('.$listed_record_id.',1)">'; //1= Enroll verify
										}
										echo'<span>'.$urlstr.'<img src="images/missing.png" border="0" width="20px" height="20px" title="Verification pending"> Enrollment Verify Pending</a></span>';
									}
									else if ($val_query['action_status']!="not_verify" || $val_query['action_status']=="verified" )
									{
										$sel_status="select * from enroll_verification where enroll_id='".$listed_record_id."' and status='verified' ";
										$ptr_status=mysql_query($sel_status);
										$data_sts=mysql_fetch_array($ptr_status);
										
										$sel_admin="select name from site_setting where admin_id='".$data_sts['admin_id']."'";
										$ptr_admin=mysql_query($sel_admin);
										$data_admin=mysql_fetch_array($ptr_admin);
										
										echo'<div class="middle"><img src="images/verified_all.png" border="0" width="20px" height="20px" title="Verified"> Enroll Verified by '.$data_admin['name'].'</div>';
									}
									
									if($val_query['action_status']=="verified")
									{
										$urlstrt='';
										if($_SESSION['type'] =='S' || $_SESSION['type'] =='A' )
										{
											$urlstrt='<a href="#" onClick="action_status('.$listed_record_id.',2)">';//2=acknowledgement
										}
										echo'<span><center>'.$urlstrt.'<img src="images/missing.png" border="0" width="20px" height="20px" title="Acknowledgement Pending">Acknowledgement Pending</a></center></span>';
									}
									else if($val_query['action_status']=="acknowledgement")
									{
										$sel_status="select * from enroll_verification where enroll_id='".$listed_record_id."' and status='acknowledgement' ";
										$ptr_status=mysql_query($sel_status);
										$data_sts=mysql_fetch_array($ptr_status);
										
										$sel_admin="select name from site_setting where admin_id='".$data_sts['admin_id']."'";
										$ptr_admin=mysql_query($sel_admin);
										$data_admin=mysql_fetch_array($ptr_admin);
										
										echo'<div class="middle"><img src="images/verified_all.png" border="0" width="20px" height="20px" title="Verified"> Acknowledged by '.$data_admin['name'].'</div>';
									}
									else
									{}
									echo'</td>';
								}
								else
								{
									echo'<td>AC, CM can verify the enrollment First</td>';
								}*/
								echo '</tr>';
								/* echo '<tr bgcolor="#E9E9E9"><td colspan="15" align="center"><strong>PDC Details</strong></td></tr>';
                                echo '<tr bgcolor="#d7edf9"><td align="center"><strong>Sr. No.</strong></td><td colspan="3" align="center"><b>Installment Details</b></td><td align="center" colspan="2"><strong>Chaque No</strong></td><td colspan="2" align="center"><strong>Chaque Date</strong></td><td colspan="3" align="center"><strong>Bank Name</strong></td><td colspan="2" align="center"><strong>Add</strong></td></tr>';
                                            
                                $select_installments="SELECT * FROM `installment` where enroll_id ='".$listed_record_id."' ";
                                $ptr_installment = mysql_query($select_installments);
                                if(mysql_num_rows($ptr_installment))
                                {
                                    $k=$bgColorCounter;
                                    while($data_installment=mysql_fetch_array($ptr_installment))
                                    {
                                        echo'<tr bgcolor="#FEF1E3">';
                                        echo'<td align="center">'.$k.'</td>';
                                        echo'<td align="center">'.$data_installment['installment_amount'].'</td>';
                                        echo'<td align="center">'.$data_installment['installment_date'].'</td>';
                                        if($data_installment['status'] =='not paid')
                                            $col_paid ='<font color="#FF3333">';
                                        echo'<td align="center">'.$col_paid.$data_installment['status'].'</font></td>';
                                        
                                        echo '<td style="color:#000080" align="center" colspan="2">'.$data_installment['pdc_chaque_no'].'</td>';
                                        
                                        echo  '<td align="center" colspan="2">'.$data_installment['pdc_chaque_date'].'</td>';
                                        
                                        echo'<td align="center" colspan="3">'.$data_installment['pdc_bank_name'].'</td>';
                                        //echo  '<td align="center"><a href="add_payment_to_do.php?record_id='.$enroll_id.'&installment_id='.$data_installment['installment_id'].'&ref_id='.$data_installment['installment_ref_id'].'"><img src="images/payment_service.png"height="25" width="25"  border="0" title="Add Payment With Service Tax"></a></td>';
                                        
                                        if($data_installment['pdc_chaque_no'] !='')
                                        {
                                            echo'<td align="center" align="center" colspan="2"><a target="_blank" href="add_pdc_details.php?record_id='.$listed_record_id.'&installment_id='.$data_installment['installment_id'].'&ref_id='.$data_installment['installment_ref_id'].'">Edit</a></td>';
                                        }
                                        else
                                        {
                                            echo'<td align="center" align="center" colspan="2"><a target="_blank" href="add_pdc_details.php?record_id='.$listed_record_id.'&installment_id='.$data_installment['installment_id'].'&ref_id='.$data_installment['installment_ref_id'].'">Add</a></td>';
                                        }
                                        //echo $data_installment['installment_amount'].'/- '.$data_installment['installment_date'].' : '.$col_paid.$data_installment['status']."</font><br>";	
                                        echo'</tr>';
                                        $k++;
                                    }
                                } */	
															
								if($is_parent=='y')
								{
									$sel_map="SELECT * FROM courses_map WHERE course_parent_id = '".$val_query['course_id']."' ";
									$ptr_courses=mysql_query($sel_map);
									if($total_course=mysql_num_rows($ptr_courses))
									{
										echo '<tr bgcolor="#d7edf9"><td colspan="4" align="center"><strong>Sr. No.</strong></td><td colspan="3" align="center"><b>Course Name</b></td><td colspan="2" align="center"><strong>Course Logsheet</strong></td><td colspan="2" align="center"><strong>Course Status</strong></td><td align="center"><strong>Is Batch Scheduled</strong></td><td align="center"><strong>Batch Start Date</strong></td></tr>';
										$c1=1;
										while($data_map=mysql_fetch_array($ptr_courses))
										{
											$sel_course="select course_name,course_id from courses where course_id='".$data_map['course_id']."'";
											$ptr_course=mysql_query($sel_course);
											$data_course=mysql_fetch_array($ptr_course);
											
											$sel_map1="SELECT * FROM courses_map WHERE course_parent_id = '".$data_map['course_id']."' ";
											$ptr_courses1=mysql_query($sel_map1);
											if($total_course=mysql_num_rows($ptr_courses1))
											{
												echo '<tr class="grey_td"><td colspan="2" align="right">'.$c1.'</td><td colspan="12"><b>'.$data_course['course_name'].'</b></td></tr>';
												$c2=1;
												while($data_map1=mysql_fetch_array($ptr_courses1))
												{
													$sel_course1="select course_name,course_id from courses where course_id='".$data_map1['course_id']."'";
													$ptr_course1=mysql_query($sel_course1);
													$data_course1=mysql_fetch_array($ptr_course1);
													
													echo '<tr><td colspan="4" align="right">'.$c2.'</td><td colspan="3"><b>'.$data_course1['course_name'].'</b></td><td colspan="2"><center><a href="student_logsheet.php?record_id='.$listed_record_id.'&course_id='.$data_course1['course_id'].'"><img src="images/logsheet.png" border="0" title="View Logsheet" height="25px" width="25px"></a></center></td><td colspan="2" align="center">Started</td><td align="center">Yes</td><td align="center">2019-07-25</td></tr>';
													$c2++;
												}
											}
											else
											{
												echo '<tr ><td colspan="2" align="right">'.$c1.'</td><td colspan="5"><b>'.$data_course['course_name'].'</b></td><td colspan="2"><center><a href="student_logsheet.php?record_id='.$listed_record_id.'&course_id='.$data_course['course_id'].'"><img src="images/logsheet.png" border="0" title="View Logsheet" height="25px" width="25px"></a></center></td><td colspan="2" align="center">Started</td><td align="center">Yes</td><td align="center">2019-07-25</td></tr>';
											}
											$c1++;
										}
									}
								}
								else
								{
									echo '<tr bgcolor="#d7edf9"><td colspan="4" align="center"><strong>Sr. No.</strong></td><td colspan="3" align="center"><b>Course Name</b></td><td colspan="2" align="center"><strong>Course Logsheet</strong></td><td colspan="2" align="center"><strong>Course Status</strong></td><td align="center"><strong>Is Batch Scheduled</strong></td><td align="center"><strong>Batch Start Date</strong></td></tr>';
									
									$sel_course2="select course_name,course_id from courses where course_id='".$val_query['course_id']."'";
									$ptr_course2=mysql_query($sel_course2);
									$data_course2=mysql_fetch_array($ptr_course2);
									
									echo '<tr><td colspan="4" align="center">'.$it.'</td><td colspan="3" ><b>'.$data_course2['course_name'].'</b></td><td colspan="2"><center><a href="student_logsheet.php?record_id='.$listed_record_id.'&course_id='.$data_course2['course_id'].'"><img src="images/logsheet.png" border="0" title="View Logsheet" height="25px" width="25px"></a></center></td><td colspan="2" align="center">Started</td><td align="center">Yes</td><td align="center">2019-07-25</td></tr>';
								}
								
								$bgColorCounter++;
								$it++;
							 }    
                ?>
  
  
  <tr class="head_td">
    <td colspan="16">
       <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                    if($no_of_records>10)
					{
						echo '<td width="3%" align="left">Show</td>
						<td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
						$show_records=array(0=>'10',1=>'20','50','100');
						for($s=0;$s<count($show_records);$s++)
						{
							if($_SESSION['show_records']==$show_records[$s])
								echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
							else
								echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
						}
						echo'</td></select>';
					}
					echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';
                         
                 ?>
                                    
            </tr>
        </table>                              
    </td>
    </tr>
	</form>
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Student found related to your search criteria, please try again</div><br></td></tr>';?>
</table>

<table width="97%" align="right"  cellpadding="0" cellspacing="1"  class="" style="width: 97%;" >                                      
<!--<tr>
	<td align="center" width="5%"><span class="dot"></span></td><td width="95%">Enrollment Verification Pending / Aknowledgement Pending ==> Please Contact Your Center Manager or Accountant</td>
</tr>-->
</table>
	</td>
    <td>
    
    <script type="text/javascript">
	$(function()    
	{
		$(".custom_cuorse_submit").click(function(){
		var councillior_id = $("#councillior_id").val();
				   
		if(councillior_id == "" || councillior_id == undefined)
		{
			alert("Select Councillor name.");
			return false;
		}
		else
		{
			//alert(councillior_id);
			$("#councillior_admin_id").val(councillior_id);
			$('.new_custom_course').dialog( 'close');
			setTimeout(document.frmTakeAction.submit(),3000)
		}
		/*if(mobile1 == "" || mobile1 == undefined)
		{
			alert("Enter Mobile no.");
			return false;
		}
		if(email == "" || email == undefined)
		{
			alert("Eneter Email ID.");
			return false;
		}*/
		/*var data1 = 'action=custome_councillior_submit&councillior_id='+councillior_id
		$.ajax({
			url: "ajax.php", type: "post", data: data1, cache: false,
			success: function (html)
			{
				if(html.trim() =='mobile')
				{
					alert("Mobile no. or Email already Exist");
					return false;
				}
				else if(html.trim() =='cust_id')
				{
					alert("Customer Name already Exist");
					return false;
				}
				else if (html.trim() =='blank')
				{
					alert("Please enter Mobile number");
					return false;
				}
				else
				{
					$(".customized_select_box").html(html);
				   
					$('.new_custom_course').dialog( 'close');
					$("#customer_id").chosen({allow_single_deselect:true});
				   
				}
			}
			});*/
			});
		});
		</script>
		<div class="new_custom_course" style="display: none;">
			<form method="post" id="jqueryForm" name="discount" enctype="multipart/form-data">
				<table border="0" cellspacing="15" cellpadding="0" width="100%">
					<tr>
						<td colspan="3" class="orange_font">* Mandatory Fields</td>
					</tr>
					<tr>
						<td width="20%">Select Councillior<span class="orange_font">*</span></td>
						<td width="40%">
						<select name="councillior_id" id="councillior_id">
						<option value="">Select Name</option>
						<?php
						$cm_category = "select name,branch_name,system_status,cm_id from site_setting where type='A' and system_status='Enabled' group by cm_id ";
						$ptr_cm = mysql_query($cm_category);
						while($data_cm = mysql_fetch_array($ptr_cm))
						{
							echo " <optgroup label='".$data_cm['branch_name']."'>";
							
							$sle_name="select admin_id,name,branch_name from site_setting where 1 and system_status='Enabled' and (type='C' or type='A') and cm_id='".$data_cm['cm_id']."' order by name asc"; 
							$ptr_name=mysql_query($sle_name);
							while($data_name=mysql_fetch_array($ptr_name))
							{
								echo '<option value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
							}
							echo " </optgroup>";
						}
						?>
						</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit"/>&nbsp;
							<input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog( 'close');"/>
						</td>
					</tr>
				</table>
			</form>
		</div>
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

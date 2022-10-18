<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Total Enrollment</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='98'";
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
    <td colspan="12">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
                        <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{
						?>
						 <td width="12%">
							<select name="branch_name" id="branch_name"  class="input_select_login" >
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
										echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
									}
								?>
							</select>
						</td>
						<?php
						}
						?>
                        
                        <td width="8%">Select Course<span class="orange_font">*</span></td>
                        <td class="customized_select_box" width="12%">
                        <select id="course_id" name="course_id" class="input_text" >
                           <option value="">Select</option>
                           <?php
                           $course_category = " select category_name,category_id from course_category ";
                           $ptr_course_cat = mysql_query($course_category);
                           while($data_cat = mysql_fetch_array($ptr_course_cat))
                           {
                                echo " <optgroup label='".$data_cat['category_name']."'>";
                                $get="SELECT course_id,course_name FROM courses where category_id='".$data_cat['category_id']."' order by course_id";
                                $myQuery=mysql_query($get);
                                while($row = mysql_fetch_assoc($myQuery))
                                {
                                    $selected_course='';
                                    if($_REQUEST['course_id'] == $row['course_id'])
                                    {
                                        $selected_course='selected="selected"';
                                    }
                                	?>
                                    <option <?php echo $selected_course; ?> value = "<?php echo $row['course_id']?>" > <?php echo $row['course_name'] ?> </option>
                                    <?php 
								}
                            	echo " </optgroup>";
                        	}?>
                        </select>
                        </td>
                        
                        <td width="6%">Assign to<span class="orange_font">*</span></td>
                        <td class="customized_select_box" width="12%">
                       	<select id="assign_to" name="assign_to" class="input_text" >
                           	<option value="">Select</option>
                           	<?php
                           	$sel_admin= " select name,admin_id from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled'";
                           	$ptr_admin= mysql_query($sel_admin);
                           	while($data_admin= mysql_fetch_array($ptr_admin))
                           	{
                            	$sel_assign='';
                            	if($_REQUEST['assign_to'] == $data_admin['admin_id'])
                            	{
									$sel_assign='selected="selected"';
                                }
                                ?>
                                <option <?php echo $sel_assign; ?> value ="<?php echo $data_admin['admin_id']?>" > <?php echo $data_admin['name'] ?> </option>
                                <?php 
							}
                            ?>
                        </select>
                        </td>
                        
                        <td width="6%">Added by<span class="orange_font">*</span></td>
                        <td class="customized_select_box" width="12%">
                       	<select id="added_by" name="added_by" class="input_text" >
                           	<option value="">Select</option>
                           	<?php
                           	$sel_admin="select name,admin_id from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' ";
                           	$ptr_admin= mysql_query($sel_admin);
                           	while($data_admin= mysql_fetch_array($ptr_admin))
                           	{
                            	$sel_assign='';
                            	if($_REQUEST['added_by'] == $data_admin['admin_id'])
                            	{
									$sel_assign='selected="selected"';
                                }
                                ?>
                                <option <?php echo $sel_assign; ?> value ="<?php echo $data_admin['admin_id']?>" > <?php echo $data_admin['name'] ?> </option>
                                <?php 
							}
                            ?>
                        </select>
                        </td>
                        
                        <td width="8%">
                        <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                        </td>
                         
                        <td width="8%">
                        <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                        </td>
                        
                        <td width="8%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                        <?php if($_SESSION['type']=='S' || $edit_access=='yes') {?><td width="8%"> <a href="enroll_export_report.php<?php echo $sep_url_string; ?>">&nbsp;<img src="images/excel.png" height="30px" width="30px"/></a></td><?php } ?>
                        <!--<td class="rightAlign" > 
                            <table border="0" cellspacing="0" cellpadding="0" align="right">
                              <tr>
                              <td></td>
                              <td class="width5"></td>
                                <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                <td class="width2"></td>
                                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                              </tr>
                            </table>	
                        </td>-->
            		</tr>
        		</table>
        	</form>	
    	</td>
  </tr>
    
     <?php
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							echo "<br/>".$enquiry_from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date=""; 
							$enquiry_from_date="";
							$installment_from_date="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
							$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
							echo "<br/>".$enquiry_to_date=" and added_date<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$enquiry_to_date="";
							$installment_to_date="";
						}
						
						//======================================From Stack Report=======================================
						if($_REQUEST['start_date'] && $_REQUEST['start_date']!=="0000-00-00" && $_REQUEST['start_date']!="Start Date")
						{
							$frm_date=explode("/",$_REQUEST['start_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							$enquiry_from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						
						
						if($_REQUEST['end_date']  && $_REQUEST['end_date']!="End Date")
						{
							$to_date=explode("/",$_REQUEST['end_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
							$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
							$enquiry_to_date=" and added_date<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						
						//=============================================================================
						$search_cm_id='';
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
						$where_course='';
						if($_REQUEST['course_id']!='')
						{
							$course_id=$_REQUEST['course_id'];
							$where_course=" and course_id='".$course_id."'";
						}
						
						$where_assign_to='';
						if($_REQUEST['assign_to']!='')
						{
							$assign_id=$_REQUEST['assign_to'];
							$where_assign_to=" and assigned_to='".$assign_id."'";
						}
						
						$where_added_by='';
						if($_REQUEST['added_by']!='')
						{
							$added_id=$_REQUEST['added_by'];
							$where_added_by=" and admin_id='".$added_id."'";
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
							
						$select_directory='order by enroll_id desc';                      
                       echo "<br/>". $sql_query= "SELECT * FROM enrollment where 1 ".$_SESSION['where']." ".$where_course." ".$where_assign_to." ".$where_added_by." ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date."  ".$select_directory."";
						$db=mysql_query($sql_query);
                        $no_of_records=mysql_num_rows($db);
						
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&branch_name='.$_REQUEST['branch_name'].'&course_id='.$_REQUEST['course_id'].'&assign_to='.$_REQUEST['assign_to'].'&added_by='.$_REQUEST['added_by'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
   
    <form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
                        <td width="4%" align="center"><strong>Sr. No.</strong></td>
                        <td width="10%" align="center"><strong>Name</strong></td>
                        <td width="10%" align="center"><strong>Contact No</strong></td>
                        <td width="10%" align="center"><strong>Email Id</strong></td>
                        <td width="10%" align="center"><strong>Branch name</strong></td>
                        <td width="10%" align="center"><strong>Course Name</strong></td>
                        <td width="7%" align="center"><strong>Down Fee</strong></td>
                        <td width="5%" align="center"><strong>Balance Fee</strong></td>
                        <td width="15%" align="center"><strong>Installments</strong></td>
                        <td width="10%" align="center"><strong>Assign to</strong></td>
                       	<td width="10%" align="center"><strong>Added by</strong></td>
                        <td width="8%" align="center"><strong>Date</strong></td>
                      </tr>
                           	<?php					
                            while($val_query=mysql_fetch_array($all_records))
                            {
								if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor=""; 
                                include "include/paging_script.php";
								
                                echo '<tr '.$bgcolor.'>';
									echo '<td align="center">'.$sr_no.'</td>';
									echo '<td align="center">'.$val_query['name'].'</td>';
									echo '<td align="center">Mob. 1: '.$val_query['contact'].' <br/> Mob. 2: '.$val_query['contact_home'].'</td>';
									echo '<td align="center">'.$val_query['mail'].'</td>';
								   	$sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
								   	$ptr_branch=mysql_query($sel_branch);
								   	$data_branch=mysql_fetch_array($ptr_branch);
								   	echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								
                                   	//echo '<td >username:'.$val_query['username'].'<br />Password:'.$val_query['pass'].'</td>';
								   	$select_course = "select * from courses where course_id = '".$val_query['course_id']."' ";
									$query=mysql_query($select_course); 
                                    $val_course= mysql_fetch_array($query);   
                                    echo '<td align="center"><b>'.$val_course['course_name'].'</b><br><img src="images/indian-rupee-16.ico">'.$val_course['course_price'].'/-</td>';
								   
								   	$disco ='';
									if(trim($val_query['discount']) !='0')
								 		$disco= '<br /> Discount: '.$val_query['discount'];
								  
									echo '<td align="center">'.$val_query['down_payment'].$disco.'</td>';
									echo '<td align="center">'.$val_query['balance_amt'].'</td>';
								
									echo '<td >';
								 	$select_installments = " SELECT * FROM `installment` where enroll_id =".$val_query['enroll_id']." and course_id='".$val_query['course_id']."'  ";
									$ptr_installment = mysql_query($select_installments);
									while($data_insta= mysql_fetch_array($ptr_installment))
									{
										$col_paid ='<font color="#006600">';
										if($data_insta['status'] =='not paid')
											$col_paid ='<font color="#FF3333">';
								 		echo $data_insta['installment_amount'].'/- '.$data_insta['installment_date'].' : '.$col_paid.$data_insta['status']."</font><br>";	
									}
									$sql_invoice="select invoice_id from invoice where enroll_id='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' and installment_id='0' ";
									$my_query_invoice=mysql_query($sql_invoice);
									$row_invoice= mysql_fetch_array($my_query_invoice);
									echo '</td>';
									$sel_assign="select name from site_setting where admin_id='".$val_query['assigned_to']."'";
								   	$ptr_assign=mysql_query($sel_assign);
								   	$data_assign=mysql_fetch_array($ptr_assign);
									echo '<td align="center">'.$data_assign['name'].'</td>';
									$sel_added="select name from site_setting where admin_id='".$val_query['assigned_to']."'";
								   	$ptr_added=mysql_query($sel_added);
								   	$data_added=mysql_fetch_array($ptr_added);
									echo '<td align="center">'.$data_added['name'].'</td>';
									echo '<td align="center">'.$val_query['added_date'].'</td>';
                               	echo '</tr>';
								$bgColorCounter++;                                
							}
                            ?>
                                
                            <tr class="head_td">
                            <td colspan="12">
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
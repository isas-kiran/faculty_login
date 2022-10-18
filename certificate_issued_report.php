<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Certificate Issued Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='364'";
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
    <td colspan="20">
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
						 <td width="10%">
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
                        <!--<td width="6%">Select Type<span class="orange_font">*</span></td>
                        <td width="10%">
                        <select id="ad_type_id" name="ad_type_id" class="input_text" >
                           <option value="">Select Type</option>
                           <option value="0" <?php //if($_REQUEST['ad_type_id']=='0') echo 'selected="selected"'; ?>>Fresh Admission</option>
                           <option value="1" <?php //if($_REQUEST['ad_type_id']=='1') echo 'selected="selected"'; ?>>Course Upgrade</option>
                        </select>
                        </td>-->
                        
                        <td width="6%">Select Course<span class="orange_font">*</span></td>
                        <td class="customized_select_box" width="10%">
                        <select id="course_id" name="course_id" class="input_text" >
                           <option value="">Select Course</option>
                           <?php
                           $course_category="select category_name,category_id from course_category ";
                           $ptr_course_cat=mysql_query($course_category);
                           while($data_cat=mysql_fetch_array($ptr_course_cat))
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
                        
                        <!--<td width="5%">Assign to<span class="orange_font">*</span></td>
                        <td class="customized_select_box" width="10%">
                       	<select id="assign_to" name="assign_to" class="input_text" >
                           	<option value="">Select</option>
                           	<?php
                           	/*$sel_admin= " select name,admin_id from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled'";
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
							}*/
                            ?>
                        </select>
                        </td>-->
                        
                        <td width="5%">Printed by<span class="orange_font">*</span></td>
                        <td class="customized_select_box" width="10%">
                       	<select id="added_by" name="added_by" class="input_text" >
                           	<option value="">Select Name</option>
                           	<?php
                           	$sel_admin="select name,admin_id from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' ";
                           	$ptr_admin= mysql_query($sel_admin);
                           	while($data_admin= mysql_fetch_array($ptr_admin))
                           	{
                            	$sel_assign='';
                            	if($_REQUEST['added_by']==$data_admin['admin_id'])
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
                        <?php if($_SESSION['type']=='S' || $edit_access=='yes') {?><td width="8%"> <a href="certificate_issue_export_report.php<?php echo $sep_url_string; ?>">&nbsp;<img src="images/excel.png" height="30px" width="30px"/></a></td><?php } ?>
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
                $enquiry_from_date=" and a.added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
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
				$enquiry_to_date=" and a.added_date<='".date('Y-m-d',strtotime($to_dates))."'";
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
				$enquiry_from_date=" and a.added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
			}
			
			
			if($_REQUEST['end_date']  && $_REQUEST['end_date']!="End Date")
			{
				$to_date=explode("/",$_REQUEST['end_date']);
				$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
				$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
				$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
				$enquiry_to_date=" and a.added_date<='".date('Y-m-d',strtotime($to_dates))."'";
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
					$search_cm_id=" and e.cm_id='".$data_cm_id['cm_id']."'";
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
				$where_course=" and a.course_id='".$course_id."'";
			}
			/*$where_type='';
			if($_REQUEST['ad_type_id']!='')
			{
				$ref_id=$_REQUEST['ad_type_id'];
				if($ref_id=='0')
					$where_type=" and (ref_id=0 or ref_id is NULL)";
				else
					$where_type=" and ref_id > 0 ";
			}
			$where_assign_to='';
			if($_REQUEST['assign_to']!='')
			{
				$assign_id=$_REQUEST['assign_to'];
				$where_assign_to=" and assigned_to='".$assign_id."'";
			}*/
			
			$where_added_by='';
			if($_REQUEST['added_by']!='')
			{
				$added_id=$_REQUEST['added_by'];
				$where_added_by=" and a.admin_id='".$added_id."'";
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
			
			$where_cm_id='';
			if($_SESSION['where']!='')
			{
				$where_cm_id=" and e.cm_id='".$_SESSION['cm_id']."' ";
			}
			$select_directory='order by id desc';                      
			$sql_query= "SELECT a.name,a.course_id,a.enroll_id,a.added_date,a.admin_id,e.balance_amt,e.net_fees,e.cm_id FROM action_print_certificate a, enrollment e where 1 and e.enroll_id=a.enroll_id ".$where_cm_id." ".$where_course." ".$where_added_by."  ".$search_cm_id." ".$enquiry_from_date." ".$enquiry_to_date." group by a.enroll_id ".$select_directory." ";
			$db=mysql_query($sql_query);
			$no_of_records=mysql_num_rows($db);
			
			if($no_of_records)
			{
				$bgColorCounter=1;
				//$_SESSION['show_records'] = 10;
				$query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'].'&branch_name='.$_REQUEST['branch_name'].'&course_id='.$_REQUEST['course_id'].'&added_by='.$_REQUEST['added_by'];
				$query_string1=$query_string.$date_query;
			   	// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
				$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
				$all_records= $pager->paginate();
				?>
   				<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                	<input type="hidden" name="formAction" id="formAction" value=""/>
                    <tr class="grey_td" >
                        <td width="3%" align="center"><strong>Sr. No.</strong></td>
                        <td width="4%" align="center"><strong>Branch Name</strong></td>
                        <td width="10%" align="center"><strong>Student Name</strong></td>
                        <td width="8%" align="center"><strong>Course Name</strong></td>
                        <td width="8%" align="center"><strong>Course Fees</strong></td>
                        <td width="8%" align="center"><strong>Total Outstanding</strong></td>
                        <td width="8%" align="center"><strong>Certificate Print Date</strong></td>
                        <td width="8%" align="center"><strong>Print by</strong></td>
                        
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
							$sel_br="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
                            $ptr_branch=mysql_query($sel_br);
                            $data_branch=mysql_fetch_array($ptr_branch);
                            echo '<td align="center">'.$data_branch['branch_name'].'</td>';
                            
                            echo '<td align="center">'.$val_query['name'].'</td>';
                            
                            $select_course ="select * from courses where course_id='".$val_query['course_id']."' ";
                            $query=mysql_query($select_course); 
                            $val_course= mysql_fetch_array($query);   
                            echo '<td align="center"><b>'.$val_course['course_name'].'</b></td>';
							
							/*$sel_enr="select balance_amt from enrollment where enroll_id='".$val_query['enroll_id']."'";
                            $ptr_enr=mysql_query($sel_enr);
                            $data_enroll=mysql_fetch_array($ptr_enr);*/
							echo '<td align="center">'.$val_query['net_fees'].'</td>';
                           	echo '<td align="center">'.$val_query['balance_amt'].'</td>';
							
							$date_ex=explode("-",$val_query['added_date']);
							$date_added=$date_ex[2].'/'.$date_ex[1].'/'.$date_ex[0];
                            echo '<td align="center">'.$date_added.'</td>';
							
							$sel_admin="select name from site_setting where admin_id='".$val_query['admin_id']."'";
                            $ptr_admin=mysql_query($sel_admin);
                            $data_name=mysql_fetch_array($ptr_admin);
                           	echo '<td align="center">'.$data_name['name'].'</td>';
							
							
                        echo '</tr>';
                        $bgColorCounter++;                                
                    }
                    ?>
                        <tr class="head_td">
                        <td colspan="20">
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
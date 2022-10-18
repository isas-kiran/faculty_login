<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Complaints Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>

   <link rel="stylesheet" href="js/chosen.css" />
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
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
		$("#status").chosen({allow_single_deselect:true});
		<?php
		if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
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
    </script>
    <style>
	.counter{background: none repeat scroll 0 0 #9ECB4A; border: 1px solid #CCCCCC; border-radius: 3px 3px 3px 3px;  float: right;  height: 14px;  text-align: center; width: 16px;}
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
    <td class="top_mid" valign="bottom"><?php include "include/complaint_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
  
  			<?php 
  			if($_REQUEST['changeStatus1'] && $_REQUEST['value'])
            {
                $update_query1="update student_complaint set other_status='".$_REQUEST['value']."' where id='".$_REQUEST['changeStatus1']."'";
                $db->query($update_query1);
                ?>
                <div id="statusChangesDiv" title="Status Changed"><center><br/><p></p></center></div>
                <script type="text/javascript">
                    // $("#statusChangesDiv").dialog();
					$(document).ready(function() {
						$( "#statusChangesDiv" ).dialog({
							modal: true,
							buttons: {
										Ok: function() { $( this ).dialog( "close" ); }
									 }
							});
						});
				</script>
                <?php
            }
			if($_POST['formAction'])
            {
                if($_POST['formAction']=="delete")
                {
					for($r=0;$r<count($_POST['chkRecords']);$r++)
                    {
                        $del_record_id=$_POST['chkRecords'][$r];
                       	$sql_query= "SELECT id FROM student_complaint where id ='".$del_record_id."'";
						$ptr_del=mysql_query($sql_query);
                        if(mysql_num_rows($ptr_del) > 0 )
						{                                                
							$delete_query="delete from student_complaint where id='".$del_record_id."'";
							$ptr_query=mysql_query($delete_query);                                                                                   
						}
                    }
                    ?>
                    <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
                    <?php
				}
				else if($_POST['formAction']=="Active")
				{
					for($r=0;$r<count($_POST['chkRecords']);$r++)
					{
						$update_record_id=$_POST['chkRecords'][$r];
						$update_record= "update student_complaint set status='Active' where id='".$update_record_id."'";
						$ptr_query=mysql_query($update_record);  
					}
					?><div id="msgbox" style="width: 40%;">Selected records activated successfully</div><?php
				}
				else if($_POST['formAction']=="Inactive")
				{
					for($r=0;$r<count($_POST['chkRecords']);$r++)
					{
						$update_record_id=$_POST['chkRecords'][$r];
						$update_record= "update student_complaint set status='Inactive' where id='".$update_record_id."'";
						$ptr_query=mysql_query($update_record);  
					}
					?><div id="msgbox" style="width: 40%;">Selected records deactivated successfully</div><?php
				}
			}

            if($_REQUEST['changeStatus'] && $_REQUEST['value'])
            {
                $update_query1="update student_complaint set status='".$_REQUEST['value']."' where id='".$_REQUEST['changeStatus']."'";
                //echo $update_query1;
                $ptr_query=mysql_query($update_query1); 
                ?>
                <div id="statusChangesDiv" title="Status Changed"><center><br/><p>Status changed successfully</p></center></div>
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
                </script>
            <?php                            
            }                       
             
            if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
            {
                $del_record_id=$_REQUEST['record_id'];
                $sql_query= "SELECT id FROM student_complaint where id='".$del_record_id."'";
                if(mysql_num_rows($db->query($sql_query)))
                {                           
					$delete_query="delete from student_complaint where id='".$del_record_id."'";
					$ptr_query=mysql_query($delete_query); 
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
                    </script>
                    <?php
                }
            }
            ?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="12">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                            <option value="">-Operation-</option>
                            <option value="delete">Delete</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                    </select>
                </td>
                <td class="width5"></td>
                <?php if($_SESSION['type']=='S'|| $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
					?>
					 <td width="15%">
						<select name="branch_name" id="branch_name"  class="input_select_login"  style="width: 150px; ">
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
                <td class="width5"></td>
                <td width="10%">
                	<select name="status" id="status" class="input_select">
                    	<option value="">Select Status</option>
                        <option <?php if($_REQUEST['status']=='Open') echo 'selected="selected"'; ?> value="Open">Open</option>
                        <option <?php if($_REQUEST['status']=='In Progress') echo 'selected="selected"'; ?> value="In Progress">In Progress</option>
                        <option <?php if($_REQUEST['status']=='Close') echo 'selected="selected"'; ?> value="Close">Close</option>
                    </select>
                </td>
                <td class="width5"></td>
                <td width="10%">
                	<input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                </td>
                <td width="10%">
                	<input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                </td>
                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              			<tr>
              				<td></td>
             				<td class="width5"></td>
                            <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
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
                        if($_POST['submit'])
                        {
                            $contact_for=$_POST['contact_for'];
                            $other_status=$_POST['other_status'];
                            $id=  $_POST['id'];
                            
                            $quert = "insert into student_complaint (`complaint_id`,`comment`,`reply_by`,`added_date`) values('".$contact_for."','Admin','".date('Y-m_d H:i:S')."')";
                            $inser_commnet = mysql_query($quert);
                            
                            $update_read_status = "update student_complaint set `other_status`='".$other_status."' where id='".$id."' and reply_by='User' ";
                            $query_update = mysql_query($update_read_status); 
                        }
                        
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                        {                            
                            $pre_keyword =" and (name like '%".$keyword."%' || email_id like '%".$keyword."%' || phone_no like '%".$keyword."%' )";
                        }                            
                        else
                            $pre_keyword="";
                        
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
							$enquiry_from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						 }
						else
						{
							$pre_from_date=""; 
							$enquiry_date="";
							$installment_from_date="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_date=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
							$pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
							$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
							$enquiery_to_date=" and added_date<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$enquiery_to_date="";
							$installment_to_date="";
						}
						
                        $search_cm_id='';
                        $cm_ids=$_SESSION['cm_id'];
                        if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                        {
                            if($_REQUEST['branch_name']!='')
                            {
                                $branch_name=$_REQUEST['branch_name'];
                                $select_cm_id="select cm_id,branch_name from site_setting where branch_name='".$branch_name."' and type='A'";
                                $ptr_cm_id=mysql_query($select_cm_id);
                                $data_cm_id=mysql_fetch_array($ptr_cm_id);
                                $search_cm_id=" and branch_name='".$data_cm_id['branch_name']."'";
                                $cm_ids=$data_cm_id['cm_id'];
                            }
                            else
                            {
                                $search_cm_id='';
                            }
                        }
						$where_status="";
                        if($_REQUEST['status']!='')
						{
							$status=$_REQUEST['status'];
							$where_status=" and other_status='".$status."'";
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
        
                        if($_GET['order'] !='' && ($_GET['orderby']=='name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        
                        $select_directory='order by id desc';                      
                        $sql_query= "select branch_name from branch where status='Active' ".$search_cm_id." "; 
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
                            <tr class="grey_td" >
                                <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                                <td width="5%" align="center"><strong>Sr. No.</strong></td>
                                <td width="8%"><strong>Branch Name</strong> </td>
                                <td width="15%"><strong>Total Tickets</strong> </td>
                                <td width="10%"><strong>Open</strong></td>
                                <td width="8%"><strong>In Progress</strong></td>
                                <td width="20%"><strong>Close</strong></td>
                                
                            </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['id'];                                
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';
								                     
                                $sel_data="SELECT * FROM student_complaint where complaint_id='0' and status='Active' and branch_name='".$val_query['branch_name']."' ".$where_status." ".$enquiry_from_date." ".$enquiery_to_date."  ".$pre_keyword." ".$select_directory."";
								$ptr_data=mysql_query($sel_data);
								$tot_complaint=mysql_num_rows($ptr_data);
								
								$sel_open_data="SELECT * FROM student_complaint where complaint_id='0' and status='Active' and other_status='Open' and branch_name='".$val_query['branch_name']."' ".$where_status." ".$enquiry_from_date." ".$enquiery_to_date."  ".$pre_keyword." ".$select_directory."";
								$ptr_open_data=mysql_query($sel_open_data);
								$tot_open=mysql_num_rows($ptr_open_data);
								
								$sel_inp_data="SELECT * FROM student_complaint where complaint_id='0' and status='Active' and other_status='In Progress' and branch_name='".$val_query['branch_name']."' ".$where_status." ".$enquiry_from_date." ".$enquiery_to_date."  ".$pre_keyword." ".$select_directory."";
								$ptr_inp_data=mysql_query($sel_inp_data);
								$tot_inProgress=mysql_num_rows($ptr_inp_data);
								
								$sel_cls_data="SELECT * FROM student_complaint where complaint_id='0' and status='Active' and other_status='Close' and branch_name='".$val_query['branch_name']."' ".$where_status." ".$enquiry_from_date." ".$enquiery_to_date."  ".$pre_keyword." ".$select_directory."";
								$ptr_cls_data=mysql_query($sel_cls_data);
								$tot_close=mysql_num_rows($ptr_cls_data);
								
								
								echo '<td >' .$val_query['branch_name']. '</td>';
								echo '<td >' .$tot_complaint. '</td>';
								echo '<td >' .$tot_open. '</td>';
                                echo '<td >'.$tot_inProgress.'</td>';
								echo '<td >'.$tot_close.'</td>';
								
                                echo '</tr>';

                                $bgColorCounter++;
                            }  
                            ?>
                            <tr class="head_td">
                                <td colspan="12">
                                   <table cellspacing="0" cellpadding="0" width="100%" >
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
        				echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Enquiry found related to your search criteria, please try again</div><br></td></tr>';?>
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

<?php include "include/footer.php"; ?>

<!--footer end-->


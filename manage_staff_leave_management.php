<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Staff Leave Management</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='212'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
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

					//alert("hi");

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
<script>
function set_cookiess(username, user_id)
{
	var data1="action=cookies&user_id="+user_id+"&username="+username;	
	//alert(data1);
	$.ajax({
	url: "set_cookies.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html !='')
		{
			//alert(html);
			alert("Setting save successfully for "+username);
			//document.getElementById("unit_id").innerHTML=html;
			document.location.href="manage_leave_management.php";
		}
	}
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

    <td class="top_mid" valign="bottom"><?php include "include/payroll_menu.php";?></td>

    <td class="top_right"></td>

  </tr>

    <?php if($_POST['formAction'])

                    {

                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT staff_leave_id FROM ".$GLOBALS["pre_db"]."pr_staff_leave_management where staff_leave_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                {
									"<br>".$sql_query= "SELECT * FROM pr_staff_leave_management where staff_leave_id ='".$del_record_id."' ";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
										
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);       
									                                     
                                    $delete_query="delete from ".$GLOBALS["pre_db"]."pr_staff_leave_management where staff_leave_id='".$del_record_id."'";
                                    $db->query($delete_query);

									$delete_query1="delete from ".$GLOBALS["pre_db"]."pr_previous_leave_management where staff_id='".$fetch['staff_id']."' AND month='".$fetch['month']."' AND year='".$fetch['year']."'";
                                    $db->query($delete_query1);
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
							</script>
                            <?php                            

                                }                       

                     }

                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT staff_leave_id FROM ".$GLOBALS["pre_db"]."pr_staff_leave_management where staff_leave_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$sql_query= "SELECT * FROM pr_staff_leave_management where staff_leave_id ='".$del_record_id."' ";              
							$query=mysql_query($sql_query);
							$fetch=mysql_fetch_array($query);
								
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);                        
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."pr_staff_leave_management where staff_leave_id='".$del_record_id."'";
                        	$db->query($delete_query);

							$delete_query1="delete from ".$GLOBALS["pre_db"]."pr_previous_leave_management where staff_id='".$fetch['staff_id']."' AND month='".$fetch['month']."' AND year='".$fetch['year']."'";
                            $db->query($delete_query1);
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

    <td colspan="17">

        <form method="get" name="search">

	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">

              <tr>

                <td class="width5"></td>

                <td width="20%">

                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">

                                <option value="">-Operation-</option>

                                <option value="delete">Delete</option>

                        </select>

                </td>

                

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
                        if($_REQUEST['keyword']!="Keyword")

                            $keyword=trim($_REQUEST['keyword']);

                        if($keyword !='')
						{                            
						   $pre_keyword="and ((u.name like '%".$keyword."%') || (o.year like '%".$keyword."%') || (o.month like '%".$keyword."%'))";
						}                            
                        else
                            {$pre_keyword="";}

                        if($_REQUEST['free_course'])
                             $course_keyword="  and type ='".$_REQUEST['free_course']."'";
                        else 
                             $course_keyword="";
						if($_REQUEST['branch_name'])
                        	$branch_keyword="  and branch_name ='".$_REQUEST['branch_name']."'";
                        else 
                             $branch_keyword="";
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

                        if($_GET['orderby']=='course_name' )

                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='course_name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by admin_id desc';                      
							
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
							$type='';
						else
							$type="and type !='S'";
						$user_type="";

						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and admin_id='".$_GET['record_id']."' ";
							
						} 
						if($_SESSION['where']!='')
						{
							$where="and o.cm_id='".$_SESSION['cm_id']."'";
						}
						else
						{
							$where="";
						}
						$sql_query= "SELECT u.attendence_id,u.name,o.staff_leave_id,o.year,o.staff_id,o.month,o.number_of_days_in_month,o.present_days,o.leave_days,o.previous_balance_leaves,o.monthly_leaves,o.working_days,o.extra_days,o.final_leave_balance,o.final_paid_days,o.branch_name  FROM site_setting u, pr_staff_leave_management o where 1 ".$where." ".$pre_keyword." AND o.employee_id=u.admin_id ORDER BY o.staff_leave_id DESC";
                       // $sql_query= "SELECT * FROM pr_staff_leave_management where 1"; 
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
							<?php if($_SESSION['type']=='S' ||  $edit_access='yes')
                            {
                            	?>
                            	<td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
								<?php 
							} ?>
    							<td width="4%" align="center"><strong>Sr. No.</strong></td>
    							<td width="12%"><strong>Staff Name</strong></td>
  								<td width="10%"><strong>year</strong></td>
    							<td width="10%"><strong>Month</strong></td>
								<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                { ?>
                                    <td width="7%"><strong>Branch Name</strong></td>
                                    <?php 
                                }?>
                                <td width="9%"><strong>Number Of Days</strong></td>
                                <td width="7%"><strong>Present Days</strong></td>
                                <td width="7%"><strong>Extra Days</strong></td>
                                <td width="7%"><strong>Leave Days</strong></td>
                                <td width="7%"><strong>Previous Balance Leaves</strong></td>
                                <td width="7%"><strong>Final leave Balance</strong></td>
                                <td width="7%"><strong>Final Paid Days</strong></td>
                                <?php if($_SESSION['type']=='S' ||  $edit_access='yes')
                                { ?>
                                    <td width="7%" class="centerAlign"><strong>Action</strong></td>
                                    <?php 
                                }?>
                        	</tr>
							<?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
								if($val_query['month']=='1'){ $month="January"; }
								if($val_query['month']=='2'){ $month="February "; }
								if($val_query['month']=='3'){ $month="March"; }
								if($val_query['month']=='4'){ $month="April"; }
								if($val_query['month']=='5'){ $month="May"; }
								if($val_query['month']=='6'){ $month="June"; }
								if($val_query['month']=='7'){ $month="July"; }
								if($val_query['month']=='8'){ $month="Auguest"; }
								if($val_query['month']=='9'){ $month="September"; }
								if($val_query['month']=='10'){ $month="October"; }
								if($val_query['month']=='11'){ $month="November"; }
								if($val_query['month']=='12'){ $month="December"; }
                                $name = '';

                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor=""; 
								               
								$listed_record_id=$val_query['staff_leave_id']; 
                                //$select_staff = "select * from site_setting where attendence_id= '".$val_query['staff_id']."'";                              	//$staff = $db->fetch_array($db->query($select_staff));
								/*$select_name = "select * from admin_previleges where staff_id = '".$staff_id."' ";                                while($val_name = $db->fetch_array($db->query($select_name)))
								{
									$name .=$val_name['privilege_id'].', ';
								}                                    
								 $names = rtrim($name, ", ");
                                */
                                include "include/paging_script.php";
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=='S' ||  $edit_access='yes')
								{
									echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';                                
								echo '<td >'.$val_query['name'].'</td>';
								echo '<td ><a href="staff_leave_management.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['year'].'</a></td>';
								echo '<td >'.$month.'</td>';
								if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
								{
									echo '<td >'.$val_query['branch_name'].'</td>';
								}
                                echo '<td >'.$val_query['number_of_days_in_month'].'</td>';
								echo '<td >'.$val_query['present_days'].'</td>';							
								echo '<td >'.$val_query['extra_days'].'</td>';
								echo '<td >'.$val_query['leave_days'].'</td>';
								echo '<td >'.($val_query['previous_balance_leaves']+$val_query['monthly_leaves']).'</td>';
								echo '<td >'.$val_query['final_leave_balance'].'</td>';
								echo '<td >'.$val_query['final_paid_days'].'</td>';
								
								if($_SESSION['type']=='S' || $edit_access='yes')
								{
									echo '<td align="center"><a href="staff_leave_management.php?record_id='.$val_query['staff_leave_id'].'"><img src="images/edit_icon.png" height="20px" width="20px" title="Edit Event" class="example-fade"/></a>&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
									echo '</td>';
								}
                                echo '</tr>';
                                $bgColorCounter++;
                            }
							?>
        <tr class="head_td">
            <td colspan="17">
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
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No course found related to your search criteria, please try again</div><br></td></tr>';?>
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
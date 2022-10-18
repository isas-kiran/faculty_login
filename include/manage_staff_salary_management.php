<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Staff Salary Management</title>
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
                                $sql_query= "SELECT staff_salary_id FROM ".$GLOBALS["pre_db"]."pr_staff_salary_management where staff_salary_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                {
									"<br>".$sql_query= "SELECT * FROM pr_staff_salary_management where staff_salary_id ='".$del_record_id."' ";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
										
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);       
									                                     
                                    $delete_query="delete from ".$GLOBALS["pre_db"]."pr_staff_salary_management where staff_salary_id='".$del_record_id."'";
                                    $db->query($delete_query);                                                                                        
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
                        $sql_query= "SELECT staff_salary_id FROM ".$GLOBALS["pre_db"]."pr_staff_salary_management where staff_salary_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$sql_query= "SELECT name FROM pr_staff_salary_management where staff_salary_id ='".$del_record_id."' ";              
							$query=mysql_query($sql_query);
							$fetch=mysql_fetch_array($query);
								
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);                        
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."pr_staff_salary_management where staff_salary_id='".$del_record_id."'";
                        	$db->query($delete_query);

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
							
							if($_SESSION['type']=="S")
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
						$sql_query= "SELECT u.attendence_id,u.name,o.staff_salary_id,o.year,o.staff_id,o.month,o.days_in_month,o.actual_present_days,o.absent_days,o.days_in_month,o.per_day_amount,o.salary_to_be_paid,o.after_professional_tax,o.tds,o.advance_deduction,o.after_deduction,o.expence_deduction,o.after_expence_deduction,o.incentive_on_service,o.incentive_on_product,o.event_incentive,o.course_incentive,o.other_incentive,o.salary,o.working_days,o.branch_name FROM site_setting u, pr_staff_salary_management o where 1 ".$where." ".$pre_keyword." AND o.staff_id=u.attendence_id ORDER BY o.staff_salary_id DESC"; 
                     //   $sql_query= "SELECT * FROM pr_staff_salary_management where 1"; 
						
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
<?php if($_SESSION['type']=='S')
	{
	?>
					<td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
<?php } ?>
					<td width="4%" align="center"><strong>Sr. No.</strong></td>
					<td width="6%"><strong>Staff Name</strong></td>
					<td width="3%"><strong>year</strong></td>
					<td width="3%"><strong>Month</strong></td>
					<?php if($_SESSION['type']=='S')
							{ ?>
					<td width="10%"><strong>Branch Name</strong></td>
							<?php }
							 ?>
					<td width="10%"><strong>Days</strong></td>
					<td width="4%"><strong>Salary</strong></td>
					<td width="10%"><strong>After Tax</strong></td>
					<td width="8%"><strong>After Advance Deduction</strong></td>
					<td width="8%"><strong>After Expense Addition</strong></td>
					<td width="12%"><strong>Incentive</strong></td>
					<td width="6%"><strong>Salary To Be Paid</strong></td>
					<?php if($_SESSION['type']=='S')
							{ ?>
					<td width="3%" class="centerAlign"><strong>Action</strong></td>
<?php }
							 ?>
  </tr>

                            <?php



                            while($val_query=mysql_fetch_array($all_records))

                            {
								

                                $name = '';

                                if($bgColorCounter%2==0)

                                    $bgcolor='class="grey_td"';

                                else

                                    $bgcolor="";                

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

                               $listed_record_id=$val_query['staff_salary_id']; 

                                $select_staff = "select * from site_setting where attendence_id= '".$val_query['staff_id']."' ";                                           

                                $staff = $db->fetch_array($db->query($select_staff));

                                

                                    /*$select_name = "select * from admin_previleges where staff_id = '".$staff_id."' ";                                           

                                    while($val_name = $db->fetch_array($db->query($select_name)))

									{

									

                                        $name .=$val_name['privilege_id'].', ';

                                    }                                    

                                     $names = rtrim($name, ", ");

                                */

                                include "include/paging_script.php";

                                

                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=='S')
								{
									echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
								echo '<td align="center">'.$sr_no.'</td>';                                
								echo '<td >'.$staff['name'].'</td>';
								echo '<td ><a href="staff_leave_management.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['year'].'</a></td>';

								echo '<td >'.$month.'</td>';
								if($_SESSION['type']=='S')
							{
									 echo '<td >'.$val_query['branch_name'].'</td>';
							}
								echo '<td > Days in Month :- '.$val_query['days_in_month'].'</br>
								Working Days :-  '.$val_query['working_days'].'</br>
								Present Days :-  '.$val_query['actual_present_days'].'</br>
								Absent Days :-  '.$val_query['absent_days'].'</td>';
								echo '<td >'.$val_query['salary'].'</td>';



								echo '<td >After Proffesional Tax :- '.$val_query['after_professional_tax'].'</br>
								After TDS :- '.$val_query['tds'].'</br>
								</td>';
								echo '<td >'.$val_query['after_deduction'].'</br></td>';
								echo '<td >'.$val_query['after_expence_deduction'].'</br></td>';
										
								echo '<td > Service Incentive :- '.$val_query['incentive_on_service'].'</br>
								            Product Incentive :-  '.$val_query['incentive_on_product'].'</br>
											Event Incentive :-  '.$val_query['event_incentive'].'</br>
											Course Incentive :-  '.$val_query['course_incentive'].'</br>
											Other Incentive :-  '.$val_query['other_incentive'].'</br>
											</td>';

								
								 echo '<td >'.$val_query['salary_to_be_paid'].'</td>';
								?>
								<!--<td >
								       <?php     if($val_query['payment_mode']=='Online') { ?>
											Payment Mode :- <?php echo $val_query['payment_mode'] ?></br>
								            Bank Name :-  <?php echo $val_query['bank_name']; ?></br>
											Branch Name :- <?php echo $val_query['bank_branch_name']; ?></br>
											A/C Number :- <?php echo $val_query['bank_account_number']; ?></br>
											<?php } 
											else  if($val_query['payment_mode']=='Cheque') 
											{ ?>
											Payment Mode :- <?php $val_query['payment_mode']; ?> </br>
											Bank Name :- <?php $val_query['bank_name']; ?> </br>
											Payment By :- <?php $val_query['payment_by']; ?> </br>
											Cheque Number :- <?php $val_query['cgeque_no']; ?> </br>
											<?php }
											else { ?>
											Payment Mode :- <?php echo $val_query['payment_mode']; ?></br>	
											<?php } ?>
											</td> -->
								<?php
								if($_SESSION['type']=='S')
							{
									echo '<td align="center"><a href="staff_salary_management.php?record_id='.$listed_record_id.'"><img src="images/edit_icon.png" height="20px" width="20px" title="Edit Event" class="example-fade"/></a>&nbsp;
									
									<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
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

    </tr></form>

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


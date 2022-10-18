<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM pr_incentive_calculation where incentive_cal_id='".$record_id."'";
  
 $row_record=$db->fetch_array($db->query($sql_record));

	
	 $select_sallery_details="select * from sallery where admin_id='".$record_id."'";
	$sallery_details=mysql_query($select_sallery_details);
	$fetch_sallery=mysql_fetch_array($sallery_details);
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update site_setting set photo='' where admin_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);
    if($row_record['photo'] && file_exists("staff_photo/".$row_record['photo']))
        unlink("staff_photo/".$row_record['photo']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
/*$select_coupon = "select * from discount_coupon where course_id = '".$record_id."' ";                                           
$val_coupon = $db->fetch_array($db->query($select_coupon));*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
 Incentive Calculation</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>

<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
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
	 function validme()
	 {
		 frm = document.jqueryForm;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
	 if(frm.month.value=='')
		 {
			 disp_error +='Select month\n';
			 document.getElementById('month').style.border = '1px solid #f00';
			 frm.month.focus();
			 error='yes';
	     }
	 if(frm.no_of_days.value=='U')
		 {
			 disp_error +='Select No. of days\n';
			 document.getElementById(no_of_days).style.border = '1px solid #f00';
			 frm.no_of_days.focus();
			 error='yes';
		 }
	   if(frm.no_of_working_days_in_month.value=='')
		 {
			 disp_error +='Enter No. of working days \n';
			 document.getElementById('no_of_working_days_in_month').style.border = '1px solid #f00';
			 frm.no_of_working_days_in_month.focus();
			 error='yes';
	     }

		 if(frm.no_of_holidays.value=='')
		 {
			 disp_error +='Enter No. of Holidays. \n';
			 document.getElementById('no_of_holidays').style.border = '1px solid #f00';
			 frm.no_of_holidays.focus();
			 error='yes';
	     }
		
		  
	 }
	
</script>
  
     <script language="javascript" src="js/script.js"></script>
     <script language="javascript" src="js/conditions-script.js"></script>
 
</head>
<body>
<?php include "include/header.php";?>
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
    <td class="top_mid" valign="bottom"><?php include "include/payroll_menu.php"; ?></td>
    <td class="top_right"></td>
    </tr>
    <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
    <table width="100%" cellspacing="0" cellpadding="0">  
        <?php
                    $errors=array(); $i=0;
                    $success=0;
                    if($_POST['save_changes'])
                    {
						
						$incentive_salary_month=( ($_POST['incentive_salary_month'])) ? $_POST['incentive_salary_month'] : "0";
                        
						$incentive_paid_month=( ($_POST['incentive_paid_month'])) ? $_POST['incentive_paid_month'] : "";
						
				
				
                        if($incentive_salary_month =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Incentive Salary Month";
                        }
						  if($incentive_paid_month =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Incentive Paid Month";
                        }
						
						
                        if(count($errors))
                        {
                                ?>
                        <tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                         </td></tr>   <br></br>  
                    <?php
                        }
                        else
                        {
                            $success=1;
							
							$data_record['incentive_salary_month']=$incentive_salary_month;
                            $data_record['incentive_paid_month']=$incentive_paid_month;
							
							$data_record['added_date'] =date("Y-m-d H:i:s");
							$data_record['admin_id'] =$_SESSION['admin_id'];
                            $branch_name=$_POST['branch_name'];
							if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								if(mysql_num_rows($ptr_branch))
								{
									$data_branch=mysql_fetch_array($ptr_branch);
									$data_record['cm_id']=$data_branch['cm_id'];
								
									$data_record['branch_name']=$branch_name;
								//$_SESSION['cm_id_notification']=$data_branch['cm_id'];
								}
								else{
									$data_record['cm_id']="0";
									$data_record['branch_name']=$branch_name;
								}
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$data_record['branch_name']=$_SESSION['branch_name'];
							}
							
                            if($record_id)
                            {
								
                                $where_record="incentive_cal_id='".$record_id."'";                                
                                $db->query_update("pr_incentive_calculation", $data_record,$where_record); 
								
                                echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                            }
                           else{
                                            $record_comission=$db->query_insert("pr_incentive_calculation", $data_record);
											$slab_id=mysql_insert_id(); 
											  echo '<br></br><div id="msgbox" style="width:40%;">Record Added successfully</center></div><br></br>';
						   }
                          }
                    }
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
        


		<tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
         <?php if($_SESSION['type']=='S')
						{
					?>
					  <tr>
						<td>Select Branch</td>
						<td>

						<?php 
						if($_REQUEST['record_id'])
						{
						 $sel_cm_id="select branch_name from site_setting where cm_id=".$row_record['cm_id']." and type='A'";
						$ptr_query=mysql_query($sel_cm_id);
						$data_branch_nmae=mysql_fetch_array($ptr_query);
						}
						$sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>'; 
						echo ' <select style="width:20%;" id="branch_name" name="branch_name" onchange="getmonthdays();">';
						echo ' <option>Select Branch</option>';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							?>
							<option value="<?php echo $row_branch['branch_name'];?>" <?php if ($_POST['branch_name'] ==$row_branch['branch_name']) echo 'selected="selected"'; else if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 

							</option>
							<?php
						}
							echo '</select>';
							echo "</td></tr></table>";
							?>
					</td>
                   
                    
				
				<?php }  else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       <?php }?>
          </tr>
		  <tr>
 
                		<?php
						
						echo '<td>Incentive Salary Month</td><td>';
						?>
						<input style="width:20%;" type="text" id="incentive_salary_month" name="incentive_salary_month" readonly value="1" />
								</td>
								</tr>
								<tr>
								
						<?php
						
						echo '<td>Select Paid Month</td><td>';
						$monthArray = range(1, 12);
						echo ' <select style="width:20%;" id="incentive_paid_month" name="incentive_paid_month">';
					?>
    <option value="">Select Month</option>
    <?php
    foreach ($monthArray as $month) {
        // padding the month with extra zero
        $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
        // you can use whatever year you want
        // you can use 'M' or 'F' as per your month formatting preference
        $fdate = date("m", strtotime("2015-$monthPadding-01"));
	
        ?><option <?php if($month==$row_record['incentive_paid_month']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $monthPadding; ?>"><?php echo $fdate; ?></option>
   <?php }
    ?>
</select>
<?php
										?> 
								</td>
								
								
            		</tr>  

      <tr>
                <td width="20%">Payment Date <span class="orange_font"></span></td>
                <td width="">
 <input style="width:20%;" type="text" class=" datepicker input_text" name="payment_date" id="payment_date" value="<?php if($_POST['save_changes']) echo $_POST['payment_date']; else echo $row_record['payment_date'];?>" />
              
                   
                </td> 
                <td width=""></td>
            </tr>
             
        
      
			
            <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="input_btn" onclick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> Incentive Calculation" name="save_changes"  /></td>
            <td></td>
            </tr>
        </table>
        </form>
        </td></tr>
<?php
 } ?>
        </table></td>
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

<!-- List view Start -->

<div id="right_info">

<table border="0" cellspacing="0" cellpadding="0" width="100%">

 

    <?php if($_POST['formAction'])

                    {

                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT incentive_cal_id FROM ".$GLOBALS["pre_db"]."pr_incentive_calculation where incentive_cal_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                {
									"<br>".$sql_query= "SELECT * FROM pr_incentive_calculation where incentive_cal_id ='".$del_record_id."' ";              
									$query=mysql_query($sql_query);
									$fetch=mysql_fetch_array($query);
										
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);       
									                                     
                                    $delete_query="delete from ".$GLOBALS["pre_db"]."pr_incentive_calculation where incentive_cal_id='".$del_record_id."'";
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
                        $sql_query= "SELECT incentive_cal_id FROM ".$GLOBALS["pre_db"]."pr_incentive_calculation where incentive_cal_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$sql_query= "SELECT name FROM pr_incentive_calculation where incentive_cal_id ='".$del_record_id."' ";              
							$query=mysql_query($sql_query);
							$fetch=mysql_fetch_array($query);
								
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);                        
                        	$delete_query="delete from ".$GLOBALS["pre_db"]."pr_incentive_calculation where incentive_cal_id='".$del_record_id."'";
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

    <td colspan="16">

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

                               $pre_keyword=" ((u.name like '%".$keyword."%') || (o.year like '%".$keyword."%') || (o.month like '%".$keyword."%'))";
                            }                            

                        else

                            {$pre_keyword=1;}

                        

                       

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
                       // $sql_query= "SELECT * FROM pr_previous_leave_management where 1"; 
					   $sql_query= "SELECT * from pr_incentive_calculation where ".$pre_keyword." ORDER BY incentive_cal_id DESC"; 
									//".$_SESSION['where_admin_id-cm_id']."
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
<?php if($_SESSION['type']=='S')
	{
	?>
    <td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
	<?php } ?>
    <td width="4%" align="center"><strong>Sr. No.</strong></td>

    <td width="12%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Branch Name</strong></a> <?php echo $img1;?></td>


    <td width="9%"><strong>Incentive Salary Month</strong></td>

    <td width="7%"><strong>Incentive Paid Month</strong></td>

    <td width="7%" class="centerAlign"><strong>Action</strong></td>

  </tr>

                            <?php



                            while($val_query=mysql_fetch_array($all_records))

                            {

                                $name = '';

                                if($bgColorCounter%2==0)

                                    $bgcolor='class="grey_td"';

                                else

                                    $bgcolor="";                

                                

                               $listed_record_id=$val_query['incentive_cal_id']; 

                               /* $select_category = "select * from courses where course_id = '".$val_query['course_id']."' ";                                           

                                $val_category = $db->fetch_array($db->query($select_category));*/

                                

                                    /*$select_name = "select * from admin_previleges where staff_id = '".$staff_id."' ";                                           

                                    while($val_name = $db->fetch_array($db->query($select_name)))

									{

									

                                        $name .=$val_name['privilege_id'].', ';

                                    }                                    

                                     $names = rtrim($name, ", ");

                                */
$select_staff = "select * from site_setting where attendence_id= '".$val_query['staff_id']."' ";                                        $staff = $db->fetch_array($db->query($select_staff));
                                include "include/paging_script.php";
								
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=='S')
								{
									echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';                                
								echo '<td >'.$val_query['branch_name'].'</td>';
									echo '<td >'.$val_query['incentive_salary_month'].'</td>';
								
									echo '<td >'.$val_query['incentive_paid_month'].'</td>';
                                

								
							
									echo '<td align="center"><a href="incentive_calculation.php?record_id='.$val_query['incentive_cal_id'].'"><img src="images/edit_icon.png" height="20px" width="20px" title="Edit Event" class="example-fade"/></a>&nbsp;
									
									<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
									echo '</td>';
								
                                echo '</tr>';

                                $bgColorCounter++;

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

<!-- List view End -->





</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script language="javascript">

function getmonthdays(i)
{
	
	var branch_name = $("#branch_name").val();
	var ptype = 'incentive_calculation';
	 $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'check_exist.php',
            data: { branch_name:branch_name,ptype:ptype },
            
        }).done(function(responseData) {
		 //alert(responseData);
		if(responseData==1)
		{
			alert("Record All Ready Exist For This Selection");
			//$('#previous_balance_leaves').val('');
			//$('#monthly_leave').val('');
			//$("#previous_balance_leaves").attr("disabled", "disabled");
			$("#incentive_paid_month").attr("disabled", "disabled");
			
		}
		else{
			//$("#previous_balance_leaves").removeAttr("disabled");
			$("#incentive_paid_month").removeAttr("disabled");
		}
        }).fail(function() {
            console.log('Failed');
        });
 }
</script>
<script language="javascript">
create_floor('add');
</script>

</body>
</html>
<?php $db->close();?>
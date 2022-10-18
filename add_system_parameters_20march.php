<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM pr_incentive_calculation where incentive_cal_id='".$record_id."'";
  
	$row_record=$db->fetch_array($db->query($sql_record));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
 System Parameters</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
  <link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script>
	$(document).ready(function()
        {
			$("#incentive_paid_month").chosen({allow_single_deselect:true});
			$("#payment_date").chosen({allow_single_deselect:true});
			
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
	<?php if($_SESSION['type']=='S')
						 { ?>
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
						
						$basic_sal_per=( ($_POST['basic_sal_per'])) ? $_POST['basic_sal_per'] : "0";
						
						$house_rent_per=( ($_POST['house_rent_per'])) ? $_POST['house_rent_per'] : "0";
						
						$travelling_per=( ($_POST['travelling_per'])) ? $_POST['travelling_per'] : "0";
						
						$medical_per=( ($_POST['medical_per'])) ? $_POST['medical_per'] : "0";
						
				        $payment_date=( ($_POST['payment_date'])) ? $_POST['payment_date'] : "";
						$branch_name=( ($_POST['branch_name'])) ? $_POST['branch_name'] : "";
				
						if($branch_name =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Branch Name";
                        }
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
						
						if($payment_date =="")
                        {
                                $success=0;
                                $errors[$i++]="Select Payment Date";
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
							$data_record['payment_date']=$payment_date;
							$data_record['basic_sal_per']=$basic_sal_per;
							$data_record['house_rent_per']=$house_rent_per;
							$data_record['travelling_per']=$travelling_per;
							$data_record['medical_per']=$medical_per;
							
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
						echo '<option value="">Select Branch</option>';
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
						<?php 
					}  
					else 
					{ ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name'];?>"/> 
						<?php 
					}?>
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
               <select style="width:20%;" name="payment_date" id="payment_date" >
                                                     <?php 
													 for ($i = 1; $i <= 31; $i++)
													 {
													 	$selc = '';
                                                		if($row_record['payment_date']== $i)
														{
															$selc ='selected="selected" ';
														}
															echo '<option value="'.$i.'" '.$selc.'>'.$i.'</option>';
													 }
													  	//endfor;
													  ?>
                                                  </select>
                   
                </td> 
                <td width=""></td>
            </tr>
             
         <tr>
 
                		<?php
						
						echo '<td>Basic Salary %</td><td>';
						?>
						<input style="width:20%;" onKeyUp="get_total();" type="text" id="basic_sal_per" name="basic_sal_per" value="<?php echo $row_record['basic_sal_per']; ?>" />
								</td>
								</tr>
      
			
			 <tr>
 
                		<?php
						
						echo '<td>House Rent Allowance %</td><td>';
						?>
						<input style="width:20%;" onKeyUp="get_total();" type="text" id="house_rent_per" name="house_rent_per" value="<?php echo $row_record['house_rent_per']; ?>" />
								</td>
								</tr>
								
								
								 <tr>
 
                		<?php
						
						echo '<td>Travelling Allowance %</td><td>';
						?>
						<input style="width:20%;" onKeyUp="get_total();" type="text" id="travelling_per" name="travelling_per" value="<?php echo $row_record['travelling_per']; ?>" />
								</td>
								</tr>
								
								 <tr>
 
                		<?php
						
						echo '<td>Medical Allowance %</td><td>';
						?>
						<input style="width:20%;" onKeyUp="get_total();" type="text" id="medical_per" name="medical_per" value="<?php echo $row_record['medical_per']; ?>" />
								</td>
								</tr>
			
            <tr>
            <td>&nbsp;</td>
            <td><input type="submit" class="input_btn" onclick="return validme()" value="<?php if($record_id) echo "Update"; else echo "Add";?> System Parameters" id="save_changes" name="save_changes"  /></td>
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
						 <?php } ?>
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

                               $pre_keyword="and ((branch_name like '%".$keyword."%'))";
                            }                            

                        else

                            {$pre_keyword="";}

                        

                       

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
					   $sql_query= "SELECT * from pr_incentive_calculation where 1 ".$_SESSION['where']." ".$pre_keyword." ORDER BY incentive_cal_id DESC"; 
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
 <?php if($_SESSION['type']=='S')
							{ ?>
  <td width="12%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Branch Name</strong></a> <?php echo $img1;?></td>

					  <?php }?>
   

    <td width="9%"><strong>Incentive Salary Month</strong></td>

    <td width="7%"><strong>Incentive Paid Month</strong></td>
	 
	 <td width="7%"><strong>Payment Date</strong></td>
	  <td width="7%"><strong>Basic Salary (%)</strong></td>
	   <td width="7%"><strong>House Rent Allowance (%)</strong></td>
	    <td width="7%"><strong>Traveling Allowance (%)</strong></td>
		 <td width="7%"><strong>Medical Allowance (%)</strong></td>
<?php if($_SESSION['type']=='S')
							{ ?>
    <td width="7%" class="centerAlign"><strong>Action</strong></td>
	  <?php }?>
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
if($_SESSION['type']=='S')
							{								
								echo '<td >'.$val_query['branch_name'].'</td>';
							}
									echo '<td >'.$val_query['incentive_salary_month'].'</td>';
								
									echo '<td >'.$val_query['incentive_paid_month'].'</td>';
                                
								$ends = array('th','st','nd','rd','th','th','th','th','th','th');
								if (($val_query['payment_date'] %100) >= 11 && ($val_query['payment_date']%100) <= 13)
								$abbreviation = $val_query['payment_date']. '<sup>th</sup>Of Month';
								else
								$abbreviation = $val_query['payment_date'].'<sup>'.$ends[$val_query['payment_date'] % 10].'</sup> Of Month';
								echo '<td >'.$abbreviation.'</td>';
								echo '<td >'.$val_query['basic_sal_per'].'</td>';
								echo '<td >'.$val_query['house_rent_per'].'</td>';
								echo '<td >'.$val_query['travelling_per'].'</td>';
								echo '<td >'.$val_query['medical_per'].'</td>';
							if($_SESSION['type']=='S')
								{
									echo '<td align="center"><a href="add_system_parameters.php?record_id='.$val_query['incentive_cal_id'].'"><img src="images/edit_icon.png" height="20px" width="20px" title="Edit Event" class="example-fade"/></a>&nbsp;
									
									<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
									echo '</td>';
								}
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
			//$("#incentive_paid_month").attr("disabled", "disabled");
			//$("#payment_date").attr("disabled", "disabled");
			
			$("#save_changes").hide();
		}
		else{
			//$("#previous_balance_leaves").removeAttr("disabled");
			//$("#incentive_paid_month").removeAttr("disabled");
			//$("#payment_date").removeAttr("disabled");
			$("#save_changes").show();
		}
        }).fail(function() {
            console.log('Failed');
        });
 }
 
 function get_total()
 {
	 var basic_sal_per = $("#basic_sal_per").val();
	 var house_rent_per = $("#house_rent_per").val();
	 var travelling_per = $("#travelling_per").val();
	 var medical_per = $("#medical_per").val();
	 
	 var tot=parseFloat(basic_sal_per)+parseFloat(house_rent_per)+parseFloat(travelling_per)+parseFloat(medical_per);
	 if(tot>100)
	 {
		 alert('Invalid Input');
		  $('#basic_sal_per').val('');
		   $('#house_rent_per').val('');
		    $('#travelling_per').val('');
			 $('#medical_per').val('');
	 }
 }
</script>
<script language="javascript">
//create_floor('add');
</script>

</body>
</html>
<?php $db->close();?>
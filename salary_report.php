<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title id="title">Salary Report</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='222'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
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
 
     <script language="javascript" src="js/script.js"></script>



     <script language="javascript" src="js/conditions-script.js"></script>

 <link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script>
	$(document).ready(function()
        {
			$("#year").chosen({allow_single_deselect:true});
			$("#month").chosen({allow_single_deselect:true});
			
			<?php 
			if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
			{
				?>
				$("#branch_name").chosen({allow_single_deselect:true});
				<?php
			}
			?>
		});
	</script>  

    <?php 
if($_POST['save_changes'])
{
	
for($z=1;$z<=$_REQUEST['total'];$z++)
{			
	$payment_mode=$_POST['payment_mode'.$z];
	$data_record_type1['payment_mode'] =addslashes(trim($_POST['payment_mode'.$z]));
	if($payment_mode=='Online')
							{
							$data_record_type1['bank_name'] =$_POST['bank_name'.$z];
							$data_record_type1['account_no'] =$_POST['account_no'.$z];	
                            $data_record_type1['cheque_no'] =$_POST['cheque_no'.$z];				
							}
							elseif($payment_mode=='Cheque')
							{
							$data_record_type1['cheque_no'] =$_POST['cheque_no'.$z];
							$data_record_type1['account_no'] =0;	
                            $data_record_type1['bank_name'] =0;							
							}
							elseif($payment_mode=='Cash')
							{
							$data_record_type1['cheque_no'] =0;	
							$data_record_type1['account_no'] =0;	
                            $data_record_type1['bank_name'] =0;
							}
							else 
							{
							$data_record_type1['cheque_no'] =0;	
							$data_record_type1['account_no'] =0;	
                            $data_record_type1['bank_name'] =0;
							}
							if(isset($_POST['action'.$z]))
							{
							$data_record_type1['payment_action'] =1;							
							}
							else{
							$data_record_type1['payment_action'] =0;		
							}
							$data_record_type1['comment'] =$_POST['comment'.$z];
							$data_record_type1['payment_date'] =date("Y-m-d",strtotime($_POST['payment_date'.$z]));
							
	$where_record="staff_salary_id='".$_POST['floor_id'.$z]."'";
	$db->query_update("pr_staff_salary_management", $data_record_type1,$where_record);
}
}
?>



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
                    $success=0;
                    if($success==0)
                    {
                        ?>
            <tr><td>
        <form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
            <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
            
			 <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
							{ ?>
			 <td>Select branch</td> 
                <td colspan="2" align="left" style="padding-left:20px;">
                <?php
                $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
				$query_branch = mysql_query($sel_branch);
				$total_Branch = mysql_num_rows($query_branch);
				echo '<select id="branch_name" name="branch_name" >';
				while($row_branch = mysql_fetch_array($query_branch))
				{
						?>
						<option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];  ?>" > <?php echo $row_branch['branch_name']; ?> 
                        </option>
						<?
				}
				echo '</select>';
                ?>
                <!--<div id="branch_name">
                    </div>-->
                    </td>
			
							<?php }
						else { ?>
                       <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       <?php }?>
			
							</td>
                        
			
			
                		<td colspan="2">
						<?php
						echo '<table width="100%"><tr><td width="20%" style="padding-left:20px;">';
						echo 'Select Year<span class="orange_font">*</span></td><td>';
$nxt=date('Y')-1;
$yearArray = range($nxt, 2030);
						echo ' <select required id="year" name="year" style="width:100px;">';
					
?>
    <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
    <?php
    foreach ($yearArray as $year) {
        // if you want to select a particular year
       // $selected = ($year == 2018) ? 'selected' : '';
	   
	   ?><option <?php if($year==$_REQUEST['year']) { echo "selected"; } else { echo ''; } ?> value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php
    }
    ?>
</select>
						<?php
						
						?> 
								</td>
								
								<td width="20%" style="padding-left:20px;">
						<?php
						
						echo 'Select Month<span class="orange_font">*</span></td><td>';
						$monthArray = range(1, 12);
						$currentMonth =date('Y').'-'.date('m').'-01';
                        $prv_month=Date('F', strtotime('-1 month',strtotime($currentMonth)));
						 $prv_month1=Date('m', strtotime('-1 month',strtotime($currentMonth)));
						echo ' <select required id="month" name="month">';
					?>
    <option value="<?php echo $prv_month1; ?>"><?php echo $prv_month; ?></option>
    <?php
    foreach ($monthArray as $month) {
        // padding the month with extra zero
        $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
        // you can use whatever year you want
        // you can use 'M' or 'F' as per your month formatting preference
        $fdate = date("F", strtotime("2015-$monthPadding-01"));
        echo '<option value="'.$monthPadding.'">'.$fdate.'</option>';
    }
    ?>
</select>
<?php
				
						?> 
				
				
				
				<td><input style="margin-right: 165px;margin-left: 0px;width:50%;" type="button" class="input_btn" onClick="getsalarydetails()" value="Generate" name=""  /></td>
		</tr></table>
               </tr> 
 </table>
 
   <div id="showdiv">
					  </div>
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







</div>



<!--info end-->



<div class="clearit"></div>



<!--footer start-->



<div id="footer"><?php require("include/footer.php");?></div>



<!--footer end-->








<script language="javascript">



function getsalarydetails() {
 
	//var atype = $("#atype").val();
	var year = $("#year").val();
	var month = $("#month").val();
	var branch_name = $("#branch_name").val();
	
	if(month==''){
		alert("Please Select Month");
		return false;
	}
	if(year==''){
		alert("Please Select Year");
		return false;
	}
	if(branch_name==''){
		alert("Please Select branch name");
		return false;
	}
	//alert(branch_name);
        $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'salary_report_ajax.php',
            data: { year: year,month:month,branch_name:branch_name },
            
        }).done(function(responseData) {
        $("#showdiv").html(responseData);
        }).fail(function() {
            console.log('Failed');
        });

    }



</script>


</body>



</html>



<?php $db->close();?>
<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM  salary_deduction where sallery_id ='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Salary Settings</title>
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
    <!--End multiselect -->
     <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
    <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'dd-mm-yy'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
       });
	</script>
    
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
    <td class="top_mid" valign="bottom"><?php include "include/general_setting_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  
   <?php       		if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT sallery_id FROM salary_deduction where sallery_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
								{
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_sallary','Delete','sallary','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									
									$delete_query="delete from salary_deduction where sallery_id='".$del_record_id."'";
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
											Ok: function() { $( this ).dialog( "close" ); }
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
                        $sql_query= "SELECT sallery_id FROM salary_deduction where sallery_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_sallary','Delete','sallary','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);
                            $delete_query="delete from salary_deduction where sallery_id='".$del_record_id."'";
                            $db->query($delete_query);      
                            ?>
                            <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
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
                    }
     ?>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">            
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
                            $travelling_allowance=$_POST['travelling_allowance'];
							$dearness_allowance=$_POST['dearness_allowance'];
							$house_rent_allowance=$_POST['house_rent_allowance'];
							$medical_allowance=$_POST['medical_allowance'];
							$branch_name=$_POST['branch_name'];
							
                            if($_SESSION['type']=='S')
							{
								$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_branch=mysql_query($sel_branch);
								$data_branch=mysql_fetch_array($ptr_branch);
								
								$cm_id=$data_branch['cm_id'];
								$branch_name1=$branch_name;
								$data_record['cm_id']=$cm_id;
								$data_record['cm_id']=$cm_id;
							}	
							else
							{
								$data_record['cm_id']=$_SESSION['cm_id'];
								$branch_name1=$_SESSION['branch_name'];
								$data_record['cm_id']=$_SESSION['cm_id'];
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
								$data_record['branch_name'] = $branch_name;
								//$data_record['admin_id'] = $_SESSION['admin_id'];
                                $data_record['travelling_allowance'] =$travelling_allowance;
                                $data_record['dearness_allowance'] = $dearness_allowance;
								$data_record['house_rent_allowance'] = $house_rent_allowance;
								$data_record['medical_allowance'] = $medical_allowance;
								$data_record['added_date_time'] = date('Y-m-d H:i:s');
                               	if($record_id)
                                {
                                	$where_record=" sallery_id ='".$record_id."'";
                                    $db->query_update("salary_deduction", $data_record,$where_record);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_sallary','Edit','sallary','".$record_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
									$_SESSION['service_tax']=$service_tax;
                					$_SESSION['installment_tax']=$installment_course;
									?>
                                    <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record added successfully</p></center></div>
									<script type="text/javascript">
                                        $(document).ready(function() {
                                            $( "#statusChangesDiv" ).dialog({
                                                    modal: true,
                                                    buttons: {
                                                                Ok: function() { $( this ).dialog( "close" );}
                                                             }
                                            });
                                            
                                        });
                                       //setTimeout('document.location.href="add_sallery.php";',1000);
                                    </script>
                                    <?php
                                }
                                else
                                {
                                    $record_id=$db->query_insert("salary_deduction", $data_record);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_sallary','Add','sallary','".$record_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
									$_SESSION['service_tax']=$service_tax;
                					$_SESSION['installment_tax']=$installment_course;
									?>
                                    <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Record added successfully</p></center></div>
									<script type="text/javascript">
                                        $(document).ready(function() {
                                            $( "#statusChangesDiv" ).dialog({
                                                    modal: true,
                                                    buttons: {
                                                                Ok: function() { $( this ).dialog( "close" );}
                                                             }
                                            });
                                            
                                        });
                                       //setTimeout('document.location.href="add_sallery.php";',1000);
                                    </script>
                                    <?php
                                }
                            }
                        }
                        if($success==0)
                        {
                        	//United States USA
                        	//  Canada CAN
                        	?>
            <tr><td>	
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
              </tr>
              <tr>
              	<td>Select Branch</td>
              	<td>
                	<?php 
						$sel_branch = "SELECT branch_name FROM branch where 1 order by branch_id asc ";	 
						$query_branch = mysql_query($sel_branch);
						$total_Branch = mysql_num_rows($query_branch);
						echo '<table width="100%"><tr><td>';
						echo ' <select id="branch_name" name="branch_name">';
						while($row_branch = mysql_fetch_array($query_branch))
						{
							$selected='';
							if($row_branch['branch_name']==$row_record['branch_name'])
							{
							 	$selected='selected="selected"';
							}
							?>
							<option  value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name']; ?>" <?php echo $selected ?>><? echo $row_branch['branch_name']; ?> 
							</option>
							<?php
						
						}
							echo '</select>';
							echo "</td></tr></table>";
				
					?>
                </td>
              </tr>
              <tr>
                <td width="20%">House Rent Allowance(in %) <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="house_rent_allowance" id="house_rent_allowance" value="<?php if($_POST['house_rent_allowance']) echo $_POST['house_rent_allowance']; else echo $row_record['house_rent_allowance'];?>" /></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                <td width="20%">Travelling Allowance(in %) <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="travelling_allowance" id="travelling_allowance" value="<?php if($_POST['travelling_allowance']) echo $_POST['travelling_allowance']; else echo $row_record['travelling_allowance'];?>" /></td> 
                <td width="40%"></td>
              </tr>  
              <tr>
              	<td width="20%">Dearness Allowance(in %) <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="dearness_allowance" id="dearness_allowance" value="<?php if($_POST['dearness_allowance']) echo $_POST['dearness_allowance']; else echo $row_record['dearness_allowance'];?>" /></td> 
                <td width="40%"></td>
              </tr>  
              <tr>
                <td width="20%">Medical Allowance(in %) <span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="medical_allowance" id="medical_allowance" value="<?php if($_POST['medical_allowance']) echo $_POST['medical_allowance']; else echo $row_record['medical_allowance'];?>" /></td> 
              	<td width="40%"></td>
              </tr>         
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Sallery" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
        </td></tr>
		<?php
     }?>
     
    <table cellspacing="0" cellpadding="0" class="table" width="95%"> 
    	<tr class="head_td">
    		<td colspan="10">
        		<form method="get" name="search">
            	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
            	<tr>
                	<td class="width5"></td>
                	<td width="20%">
                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                    	<option value="">-Operation-</option>
                        <option value="delete">Delete</option>
                    </select></td>
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
		if($keyword)
			$pre_keyword=" and (travelling_allowance like '%".$keyword."%' or dearness_allowance like '%".$keyword."%' or house_rent_allowance like '%".$keyword."%' or branch_name like '%".$keyword."%')";
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

		if($_GET['orderby']=='sallery_id' )
			$img1 = $img;

		if($_GET['order'] !='' && ($_GET['orderby']=='sallery_id'))
		{
			$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
			$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
		}
		else
			$select_directory='order by sallery_id desc';
		$record_cat_id='';
		if($_GET['record_id'] !='')
		{
			$record_cat_id="and sallery_id='".$_GET['record_id']."' ";
			
		} 
		$sql_query= "SELECT * FROM salary_deduction where 1 ".$record_cat_id." ".$pre_keyword." ".$select_directory." "; 
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
                <td width="20%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=category".$query_string;?>" class="table_font"><strong>Branch Name</strong></a> <?php echo $img1;?></td>
                <td width="15%"><strong>House Rent Allowance (%) </strong></td>
                <td width="15%"><strong>Travelling Allowance (%)</strong></td>
                <td width="15%"><strong>Dearness Allowance (%)</strong></td>
                <td width="15%"><strong>Medical Allowance (%) </strong></td>
                <?php if($_SESSION['type']=='S')
                {
                    ?>
                    <td width="10%" class="centerAlign"><strong>Action</strong></td>
                    <?php 
                }
                ?>
            </tr>
			<?php
            while($val_query=mysql_fetch_array($all_records))
            {
                if($bgColorCounter%2==0)
                    $bgcolor='class="grey_td"';
                else
                    $bgcolor="";                
                
                $listed_record_id=$val_query['sallery_id']; 
                include "include/paging_script.php";                
                echo '<tr '.$bgcolor.' >
                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                echo '<td align="center">'.$sr_no.'</td>';       
                echo '<td align="center"><a href="add_sallery.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['branch_name'].'</a></td>';
                 echo '<td align="center">'.$val_query['house_rent_allowance'].'</td>';
                echo '<td align="center">'.$val_query['travelling_allowance'].'</td>';
                echo '<td align="center">'.$val_query['dearness_allowance'].'</td>';
                echo '<td align="center">'.$val_query['medical_allowance'].'</td>';
                
                if($_SESSION['type']=='S')
                {
                	echo '<td align="center"><a href="add_sallery.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                	<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
                	echo '</td>';
                }
                echo '</tr>';                                 
                $bgColorCounter++;
            }    
            ?>
			<tr class="head_td">
    			<td colspan="10">
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
    	echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found, please try again</div><br></td></tr>';?>
</table>
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
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>
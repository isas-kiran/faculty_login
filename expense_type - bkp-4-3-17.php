<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Expense Type</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
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
    
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            $("#user_id").multiselect().multiselectfilter();
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
        function showdiv(val)
        {
            if(val=='Y')
            {
                $(".coursess").hide();
            }
            else
            {
                $(".coursess").show();
            }
        }
        function show_dicount(val)
        {            
            if(val=='Y')
            {
                $(".discount").show();
            }
            else
            {
                $(".discount").hide();
            }
        }
    </script>
<script language="javascript" src="js/script.js"></script>
<script language="javascript" src="js/conditions-script.js"></script>
    <style>	
					 
	.addBtn{background:no-repeat url(images/add.png); width:17px; border:0px; cursor:pointer;}
	.delBtn{background:no-repeat url(images/delete.png);width:17px; border:0px; cursor:pointer;}
	.editBtn{background:no-repeat url(images/edit_icon.gif); width:17px; border:0px; cursor:pointer;}
	.clrButton{background:no-repeat url(images/edit_clear.png);width:17px; border:0px; cursor:pointer;}
	.inactive{ background-color:#FFF;cursor:pointer; color:#000}
	.active{ background-color:#699;cursor:pointer; color:#FFF}
	.hidden{ display:none; width:0px; height:0px;}	
	.tbl{border-radius:3px; border:#333 solid 1px; background-color:#CCC; }
	.pointer{ cursor:pointer;}
	</style>
    </head>
<body>
<?php include "include/header.php";?>

<div id="info"> 

<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/expense_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
     <?php 
                    if($_REQUEST['deleteRecord'])
                    {
                        $del_record_id=$_REQUEST['deleteRecord'];
                        $sql_query= "SELECT expense_type FROM ".$GLOBALS["pre_db"]."expense_type where expense_type_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        $delete_query="delete from ".$GLOBALS["pre_db"]."expense_type where expense_type_id='".$del_record_id."'";
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
  <script>
 function validme()
	 {
		 frm = document.frmTakeAction;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
	 	if(frm.expense_category.value=='')
		 {
			 disp_error +='Enter Expense Type\n';
			 document.getElementById('expense_category').style.border = '1px solid #f00';
			 frm.expense_category.focus();
			 error='yes';
	     }
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 return true;
	
	 }
</script>                          
                      <form method="post" name="frmTakeAction">
                      <?php
                                $sql_records= "SELECT * FROM expense_type where 1 ".$pre_transcation_id." order by expense_type_id asc";
                                $no_of_records=mysql_num_rows($db->query($sql_records));
                                if($no_of_records)
                                {
                           
                                    $bgColorCounter=1;
                                    if(!$_SESSION['showRecords'])
                                        $_SESSION['showRecords']=10;

                                    $query_string.="&show_records=".$showRecord;
                                    $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
                                    $all_records= $pager->paginate();?>
                                    
                                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                    
                                    <tr><td valign="top" colspan="2">
                                       <table width="98%" align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 97%;">
								<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><td width="11%" class="tr-header"><strong>Expense name</strong></td><td width="11%" class="tr-header"><strong>Expense Category</strong></td><td width="12%" class="tr-header"><strong>Action</strong></td></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										$se_kit="select * from expense_category where expense_category_id='".$val_record['category_id']."'";
										$ptr_kit_name=mysql_query($se_kit);
										$data_kit_name=mysql_fetch_array($ptr_kit_name);
										
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 $payment_mode_id=$val_record['expense_type_id'];
										 $paid_totas=0;
                                       $listed_record_id=$val_record['expense_type_id'];
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td align="center">'.$sr_no.'</td>';
										echo "<td align='center'>".$val_record['expense_type']."</td>";
										echo "<td align='center'>".$data_kit_name['name']."</td>";
										echo '<td align="center">';
										if($listed_record_id !="1")
										{
										echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$listed_record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;<a href="expense_type_edit.php?record_id='.$listed_record_id.'&cat_id='.$val_record['category_id'].'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
										}
										echo '</td>';
                                        echo '</tr>';
                                       $bgColorCounter++;
                                    }
                                    ?>
                                        </table>
                                       
                                    </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
                                                    if($no_of_records>10)
                                                    {
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';

                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
                                                            if($_SESSION['show_records']==$show_records[$s])
                                                                echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                            else
                                                                echo '<option value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';
                                                        }
                                                        echo'</td></select>';
                                                    }
                                                    ?>
                                                    <td align="right"><?php echo $pager->renderFullNav();?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    </table>
                                    
                                    
                                    <?php
                                }
                                else if($_GET['search'])
                                    echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                                else
                                    echo'<center><br><div id="alert" style="width:30%">No Records here</div><br></center>';
							$errors=array(); $i=0;			
							$success=0;
							
							
							if($_POST['save_changes'])
							{
								if($_POST['expense_category'] =="")
								{
										$success=0;
										$errors[$i++]="Enter Expense Category";
								}
								
								$select_kit="select expense_category_id from expense_category where name='".$_POST['expense_category'] ."' ";
								$ptr_sel_kit=mysql_query($select_kit);
								if(mysql_num_rows($ptr_sel_kit))
								{
									$success=0;
									$errors[$i++]="Expense Category Already Exist";
								}
								
								$added_date=date('Y-m-d H:i:s');  
								$total_floor=$_POST['floor'];  
								if(count($errors))
								{
										?>
								<tr><td colspan="2"> <br></br>
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
									$data_record['name'] = $_POST['expense_category'];
									$data_record['added_date'] = date('Y-m-d H:i:s');
									if($data_record['name'] !='')
									{
										$expense_category = $_POST['expense_category'];
										$select_kit="select expense_category_id from expense_category where name='".$expense_category."' ";
										$ptr_sel_kit=mysql_query($select_kit);
										if(!mysql_num_rows($ptr_sel_kit))
										{
											$insert_for_prevelgegeis = "insert into expense_category (`name`,`added_date`) values('".$data_record['name']."','".date('Y-m-d H:i:s')."')";
											$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
											$category_id=mysql_insert_id();
										}
									    for($j=1;$j<=$total_floor;$j++)
										{
											if($_POST['sub_name'.$j] !='')
											{
												
												$data_record_type1['added_date']=$added_date;
												$data_record_type1['category_id']=$category_id;
												$data_record_type1['expense_type'] = addslashes(trim($_POST['sub_name'.$j])); 
												$record_ids=$db->query_insert("expense_type",$data_record_type1);
												$sub_id=mysql_insert_id();  
											 }
										}                      
										echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
										?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Expense type added successfully</p></center></div>
												<script type="text/javascript">
													$(document).ready(function() {
														$( "#statusChangesDiv" ).dialog({
																modal: true,
																buttons: {
																			Ok: function() { $( this ).dialog( "close" );}
																		 }
														});
														
													});
												  // setTimeout('document.location.href="expense_type.php";',1000);
												</script>
					 
									<?php
									}
									else
									{
										?>
                                        <script type="text/javascript">
												   setTimeout('document.location.href="expense_type.php";');
										</script>
                                        <?php
									}
								}
							}
							if($success==0)
							{	
									
                            ?>
                            <table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
                            <tr>
                            	<td width="15%" class="tr-header" align="center">Enter Expense Category</td>
                                 <td width="25%" class="customized_select_box">
                      			<input type="text" name="expense_category" id="expense_category" >
                               </td>
                               <!--<td width="20%" ><input type="button" onClick="ajax_kit()" value="Add New Item" /></td> -->
                            </tr>
                            <tr>
                                <td colspan="3">
                                  <table  width="80%" style="border:0px solid gray; ">
                                    <tr>
                                        <td colspan="2">
                                        <!--===========================================================NEW TABLE START===================================-->
                                        <table cellpadding="5" width="100%" >
                                         <tr>
                                         <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                                         
                                         <script language="javascript">
                                                    
                                                    function floors(idss)
                                                    {
                                                        var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="80%"><tr><td style="width:10%;">Subcategory '+idss+'</td><td valign="top" width="10%" ><input type="text" name="sub_name'+idss+'" id="sub_name'+idss+'" required/></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                                        document.getElementById('floor').value=idss;
                                                        return shows_data;
                                                    }
                                                    
                                            </script>
                                         
                                         
                                           <td align="right"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
                <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
                  </td></tr>
                                                <tr><td>  </td><td align="left"></td></tr>
                                        </table> 
                                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
                  <tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
                  <tr>
                                            <td colspan="6">
                                            <!--<table cellspacing="3" id="tbl" width="100%">
                                            <tr>
                                            <td valign="top" width="1%" align="center">Position</td>
                                            <td valign="top" width="10%" align="center">Tag</td>
                                            <td valign="top" width="10%" align="center" >Comment</td>
                                            <td valign="top" width="10%"  align="center">Upload Image <font color="#CC66FF" size="-2">[jpg or gif only]</font></td>
                                             </tr></table>-->
                                             <input type="hidden" name="floor" id="floor"  value="0" />
                                            <div id="create_floor"></div>
                                        </td></tr>
										</table>
                                        <!--============================================================END TABLE=========================================-->
                                        </td>
                                        </tr>
                                                        
                                                    </table>
                                               
                                 </td>
                              </tr>
                             
                            <tr>
                            	<td align="center" colspan="2"><input type="submit" name="save_changes" onclick="return validme();"  value="Save"  /></td>
                            </tr>
                            </table>
                            
                      <?php }?>
                            </form>
                           
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
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
<script language="javascript">
//create_floor('add');
</script>
<script language="javascript">
create_floor('add');
//create_floor_dependent();
</script>
</body>
</html>
<?php $db->close();?>
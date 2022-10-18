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
<title>Invoice Summery</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
     <?php 
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['deleteRecord'];
                        $sql_query= "SELECT student_kit_id FROM ".$GLOBALS["pre_db"]."student_kit_map where student_kit_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        $delete_query="delete from ".$GLOBALS["pre_db"]."student_kit_map where student_kit_id='".$del_record_id."'";
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
                          
                      <form method="post" name="frmTakeAction">
                      <?php
                                $sql_records= "SELECT * FROM student_kit_map where enroll_id=".$record_id." ".$pre_transcation_id." order by student_kit_id asc";
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
								<tr align="center" class="grey_td" ><td width="7%" class="tr-header"><strong>Sr.</strong></td><td width="11%" class="tr-header"><strong>Kit Name</strong></td><td width="12%" class="tr-header"><strong>Action</strong></td></tr><?php
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
										$se_kit="select kit_name from kit where kit_id='".$val_record['kit_id']."'";
										$ptr_kit_name=mysql_query($se_kit);
										$data_kit_name=mysql_fetch_array($ptr_kit_name);
										
										if($bgColorCounter%2==0)
                                    		$bgcolor='class="grey_td"';
                                		else
                                    		$bgcolor=""; 
										 $enroll_id=$val_record['enroll_id'];
										 $paid_totas=0;
                                       $listed_record_id=$val_record['student_kit_id'];
                                        include "include/paging_script.php";
                                        echo '<tr class="'.$bgclass.'">';
                                        echo '<td align="center">'.$sr_no.'</td>';
										echo "<td align='center'>".$data_kit_name['kit_name']."</td>";
										echo '<td align="center"><a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$listed_record_id.'&record_id='.$record_id.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

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
									
							$success=0;
							if($_POST['save_changes'])
							{
								
								$added_date=date('Y-m-d H:i:s');  
								$item=$_POST['item'];
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
									$data_record['enroll_id'] = $record_id;
									$data_record['added_date'] = date('Y-m-d H:i:s');
									
										
									$kit_id = $_POST['kit_id'];
									for($i=0;$i<count($kit_id);$i++)
									{
										$select_kit="select student_kit_id from student_kit_map where enroll_id='".$record_id."' and kit_id='".$kit_id[$i]."'";
										$ptr_sel_kit=mysql_query($select_kit);
										if(!mysql_num_rows($ptr_sel_kit))
										{
										$insert_for_prevelgegeis = "insert into student_kit_map (`kit_id`,`enroll_id`,`added_date`) values('".$kit_id[$i]."','".$record_id."','".date('Y-m-d H:i:s')."')";
										$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
										}
									} 
									
									
									$item_name=$_POST['item'];
									
									if($item_name  && $item_name !="custom_item" )
									{
									"<br />".$select_item="select item_id,item_name from items where item_name='".$item_name."'";
									$ptr_item=mysql_query($select_item);
									$data_item=mysql_fetch_array($ptr_item);
									$item_qty = $_POST['item_qty'];
									
									$data_record_kit['kit_name'] =$item_name;
									$data_record_kit['added_date'] = date('Y-m-d H:i:s');
									$record_id11=$db->query_insert("kit", $data_record_kit);
									$kit_id1=mysql_insert_id();
									
									
									"<br />".$insert_for_unit = "insert into kit_items_map (`kit_id`,`item_id`,`item_qty`,`added_date`) values('".$kit_id1."','".$data_item['item_id']."','".$item_qty."','".date('Y-m-d H:i:s')."')";
									$ptr_insert_unit = mysql_query($insert_for_unit);
									
									"<br />".$insert_for_prevelgegeis = "insert into student_kit_map (`kit_id`,`enroll_id`,`added_date`) values('".$kit_id1."','".$record_id."','".date('Y-m-d H:i:s')."')";
									$ptr_insert_preilgef = mysql_query($insert_for_prevelgegeis);
									}
									                           
										echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
										?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Kit added successfully</p></center></div>
												<script type="text/javascript">
													$(document).ready(function() {
														$( "#statusChangesDiv" ).dialog({
																modal: true,
																buttons: {
																			Ok: function() { $( this ).dialog( "close" );}
																		 }
														});
														
													});
												   setTimeout('document.location.href="manage_enroll.php";',1000);
												</script>
					 
									<?php
									//}
								}
							}
							if($success==0)
							{	
									
                            ?>
                            <table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
                            <tr>
                            	<td width="52%" class="tr-header" align="center">Select Kit</td>
                                 <td width="25%" class="customized_select_box">
                      
                                    <select  multiple="multiple" id="user_id" name="kit_id[]" style="box-shadow: 3px 3px 3px #888888; width:250px;">                        
                                        <?php 
                                            
                                            $select_kit = "select * from kit order by kit_id asc";
                                            $ptr_kit = mysql_query($select_kit);
                                            $i=0;
                                            while($data_kit = mysql_fetch_array($ptr_kit))
                                            { 
                                                $selecteds = '';
                                               
                                               if($record_id !='' || $record_id)
                                               {
                                                    $selc = " select kit_id FROM `student_kit_map` where enroll_id =$record_id and kit_id= '".$data_kit['kit_id']."'";
                                                    $ptr_sle = mysql_query($selc);
                                                    $selecteds='';
                                                    if(mysql_num_rows($ptr_sle))
                                                    echo "<br/>".	$selecteds = 'selected="selected"';
                                               }
                                                    
                                                    echo '<option value="'.$data_kit['kit_id'].'" '.$selecteds.' >'.$data_kit['kit_name'].' </option>';  
                                                    
                                                 
                                            $i++;
                                            }
                                            ?>
                                                
                                    </select>
                               </td>
                               <!--<td width="20%" ><input type="button" onClick="ajax_kit()" value="Add New Item" /></td> -->
                            </tr>
                            
                            <tr>
                            	<td width="52%" class="tr-header" align="center">Select Item</td>
                                 <td width="25%" class="customized_select_box">
                      
                                    <select id="item" name="item">      
                                    <option value="">Select</option>                  
                                        <?php 
                                            $select_kit = "select * from items order by item_id asc";
                                            $ptr_kit = mysql_query($select_kit);
                                            $i=0;
                                            while($data_kit = mysql_fetch_array($ptr_kit))
                                            { 
                                                $selecteds = '';
                                               
                                               /*if($record_id !='' || $record_id)
                                               {
                                                    $selc = " select kit_id FROM `student_kit_map` where enroll_id =$record_id and kit_id= '".$data_kit['kit_id']."'";
                                                    $ptr_sle = mysql_query($selc);
                                                    $selecteds='';
                                                    if(mysql_num_rows($ptr_sle))
                                                    echo "<br/>".	$selecteds = 'selected="selected"';
                                               }*/
                                                    
                                                    echo '<option value="'.$data_kit['item_name'].'" '.$selecteds.' >'.$data_kit['item_name'].' </option>';  
                                                    
                                                 
                                            $i++;
                                            }
                                            ?>
                                             <option onClick="ajax_kit()" value="custom_item">Add Custom Item</option>   
                                    </select>
                               </td>
                               
                            </tr>
                            <tr>
                            	<td width="52%" class="tr-header" align="center">Item Quantity</td>
                                <td width="25%" ><input type="item_qty" id="item_qty" /></td>
                            </tr>
                            <tr>
                            	<td align="center" colspan="2"><input type="submit" name="save_changes" value="Save"  /></td>
                            </tr>
                            </table>
                            
                      <?php }?>
                            </form>
                            <script type="text/javascript">
                        $(function() 
                        {
                            $(".custom_kit_submit").click(function(){
                                var item_name = $("#item_name").val();
								var item_price = $("#item_price").val();
								var item_qty = $("#item_qty").val();
								
								
                                if(item_name == "" || item_name == undefined)
                                {
                                    alert("Eneter the Item name.");
                                    return false;
                                }
                                
                                var data1 = 'action=custome_kit_submit&item_name='+item_name+'&item_price='+item_price+'&item_qty='+item_qty
                                $.ajax({
                                    url: "ajax.php", type: "post", data: data1, cache: false,
                                    success: function (html)
                                    {
                                        $(".customized_select_box").html(html);
                                        $('.new_custom_kit').dialog( 'close');
                                    }
                                });
                            });
							
							
							
							
                        });
                    </script>
                    <div class="new_custom_kit" style="display: none;">
                        <form method="post" id="jqueryForm" enctype="multipart/form-data">
                        
                        
                        
                            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                                <tr>
                                    <td colspan="3" class="orange_font">* Mandatory Fields</td>
                                </tr>
                                <!--<tr>
                                    <td width="20%">Kit Name<span class="orange_font">*</span></td>
                                    <td width="40%"><input type="text" class="inputText" name="kit_name" id="kit_name"/></td>
                                </tr>-->
                               
                               <tr><td colspan="3"> 
                               <tr>
                                    <td width="20%">Item Name<span class="orange_font">*</span></td>
                                    <td width="40%"><input type="text" class="inputText" name="item_name" id="item_name"/></td>
                                </tr>
                                 <tr>
                                    <td width="20%">Item Price<span class="orange_font">*</span></td>
                                    <td width="40%"><input type="text" class="inputText" name="item_price" id="item_price"/></td>
                                </tr>
                                <tr>
                                    <td width="20%">Item Quantity<span class="orange_font">*</span></td>
                                    <td width="40%"><input type="text" class="inputText" name="item_qty" id="item_qty"/></td>
                                </tr>
                               <!--===========================================================NEW TABLE START===================================-->
                                <!--<table cellpadding="5" width="100%" >
                                 <tr>
                                 <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                                 
                                 <script language="javascript">
                                            
                                            function floors(idss)
                                            {
                                                
                                                var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><td valign="top" width="10%" ><input type="text" name="item_name'+idss+'" id="item_name'+idss+'" /></td><td valign="top" width="10%" ><input type="text" name="item_price'+idss+'" id="item_price'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                                document.getElementById('floor').value=idss;
                                            return shows_data;
                                            }
                                            
                                    </script>
                                 
                                 
                                   <td><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
                					<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
                					</td></tr>
                                        <tr><td>  </td><td align="left"></td></tr>
                                </table> 
                                <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr>
                					<tr ><td align="center" width="25%" > </td><td width="10%"> </td><td width="5%"> </td></tr>
                					<tr>
                                    <td colspan="6">
                                    <table cellspacing="3" id="tbl" width="100%">
                                    <tr>
                                    <td valign="top" width="10%" >Item Name</td>
                                    <td valign="top" width="10%" >Item Price</td>
                                     </tr></table>
                                     <input type="hidden" name="floor" id="floor"  value="0" />
                                    <div id="create_floor"></div>
                                </td></tr></table>-->
                                <!--============================================================END TABLE=========================================--> 
                                </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="button" class="inputButton custom_kit_submit" value="Submit" name="submit"/>&nbsp;
                                        <input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_kit').dialog( 'close');"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
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
</body>
</html>
<?php $db->close();?>
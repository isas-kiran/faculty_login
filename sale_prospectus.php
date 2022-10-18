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
<title>Sale Prospectus</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" href="js/chosen.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />

    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
   	<script type="text/javascript">
	var pageName="add_student_kit";
    $(document).ready(function()
	{            
		//$("#product_id1").chosen({allow_single_deselect:true});	
	});
    </script>
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
						$action='delete';
                        $del_record_id=$_REQUEST['record_id'];
						$product_id=$_REQUEST['product_id'];
						$quantity=$_REQUEST['quantity'];
						$totaal='';
						
						
						$query="SELECT  `quantity`,product_name FROM `product` WHERE `product_id`='".$product_id."'";
						$query=mysql_query($query);
						$fetch=mysql_fetch_array($query);
						
						$totaal=$fetch['quantity']+$quantity;
						$sql_query="UPDATE `product` SET `quantity`='".$totaal."' WHERE `product_id`='".$product_id."'";
						$query=mysql_query($sql_query);
						
						$delete_kit="delete from student_kit_map where student_kit_id='".$del_record_id."'";
						$ptr_delete=mysql_query($delete_kit);
						
                        "<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_student_kit','Delete','".$fetch['product_name']."','".$del_record_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
						$query=mysql_query($insert);			

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
                    ?>
                    <form method="post" name="frmTakeAction">
                    <?php
						$success=0;
						if($_POST['save_changes'])
						{
							$branch_name=$_POST['branch_name'];
							$added_date=date('Y-m-d H:i:s');  
							$total_floor=$_POST['floor'];
							//$item=$_POST['item'];
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
								/* $del="delete * from student_kit_map where enroll_id='".$record_id."'";
								$ptr_del=mysql_query($del); */
								if($_SESSION['type']=='S')
								{
									$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
									$ptr_branch=mysql_query($sel_branch);
									$data_branch=mysql_fetch_array($ptr_branch);
									$cm_id=$data_branch['cm_id'];
									$branch_name1=$branch_name;										
									$data_record['cm_id']=$cm_id;
									$cm_id1=$cm_id;
								}	
								else
								{
									$data_record['cm_id']=$_SESSION['cm_id'];
									$branch_name1=$_SESSION['branch_name'];
									$data_record['cm_id']=$_SESSION['cm_id'];
									$cm_id1=$_SESSION['cm_id'];
								}
								$data_record['admin_id']=$_SESSION['admin_id'];
								$data_record['enroll_id'] = $record_id;
								$data_record['product_id']=$_POST['product_id'.$i];
								$data_record['product_qty']=$_POST['product_qty'.$i];
								$data_record['added_date'] = date('Y-m-d H:i:s');
								$kit_prod_id=$db->query_insert("student_kit_map",$data_record);
								$update_product="update product set quantity=(quantity -'".$_POST['product_qty'.$i]."') where product_id='".$_POST['product_id'.$i]."' ";
								$query_update=mysql_query($update_product);
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
										   ///setTimeout('document.location.href="manage_enroll.php";',1000);
										</script>
							<?php							
							}
						}
						if($success==0)
						{	
							?>
							<table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
								<tr>
									<td colspan="3">
		  							<?php if($_SESSION['type']=='S')
									{
										?>
                                        <table width="100%" >
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
                                            echo ' <select id="branch_name" name="branch_name" >';
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
                                        </tr>
                                        </table>
                    					<?php 
									} 
									else 
									{
										?>
                       					<input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                       					<?php 
									}?>
                                    </td>
								</tr>
                                <tr>
                                	<td>Select Product</td>
                                    <td>
                                    	<select name="product_id" id="product_id">
                                        <option value="">Select Product</option>
                                        <?php 
                                        $sel_prod="select product_id,product_name,quantity,admin_id from product where quantity > 0 and product_name like '%ISAS - SCHOOL BROCHURE (BOOKLET)%' ".$_SESSION['where']." order by product_id asc";
                                        $ptr_prod=mysql_query($sel_prod);
                                        while($data_prod=mysql_fetch_array($ptr_prod))
                                        {
											?>
											<option value="<?php echo $data_prod['product_id']; ?>"><?php echo $data_prod['product_name']; ?></option>
											<?php
                                        }
                                        ?>
                                        </select>
                                    </td>
								</tr>
                                <tr>
                                	<td colspan="3" align="center"><input type="submit" class="input_btn" value="Add Kit" name="save_changes"  /></td>             
                                </tr>
                                <tr>
                                	<!--<td class="mid_left"></td>-->
                                    <td class="mid_mid" align="center">
                                    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                    	<table cellspacing="0" cellpadding="0" class="table" width="95%">
                                        	<tr class="head_td">
                                            	<td colspan="8"></td>
                                            </tr>
    										<?php
											if($_REQUEST['keyword']!="Keyword")
												$keyword=trim($_REQUEST['keyword']);
											if($keyword)
												$pre_keyword=" and (category_name like '%".$keyword."%' )";
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
											if($_GET['orderby']=='category_name' )
												$img1 = $img;
											if($_GET['order'] !='' && ($_GET['orderby']=='category_name'))
											{
												$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
												$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
											}
											if($_GET['record_id'])
											{
												$select_directory='order by student_kit_id asc';                      
												$sql_query = "select * from student_kit_map where enroll_id='".$record_id."' order by student_kit_id asc ";
											}
											else
											{
												$select_directory='order by sale_id asc';                      
												$sql_query= "select * from student_sale where 1 ".$_SESSION['where']." ".$_SESSION['user_id']." order by sale_id asc "; 
											}
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
                                                    
                                                   		<input type="hidden" name="formAction" id="formAction" value=""/>
  														<tr class="grey_td" >
                                                        	<!--<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction', 'chkRecords')"/></td>-->
                                                        	<td width="5%" align="center"><strong>Sr. No.</strong></td>
                                                        	<td width="20%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=country_name".$query_string;?>" class="table_font"><strong>Product Name</strong></a> <?php echo $img1;?></td>
                                                        	<td width="10%"><strong>Quantity</strong></td>
                                                    		<!--<td width="10%"><strong>Post date</strong></td>
                                                        	<td width="15%"><strong>Tag</strong></td>
                                                        	<td width="20%" class="centerAlign"><strong>Image</strong></td>-->
                                                        	<?php 
                                                        	if($_SESSION['type']=='S')
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
															$listed_record_id=$val_query['sale_id']; 														
															include "include/paging_script.php";
														   echo '<tr '.$bgcolor.' >';
																 // <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
															echo '<td align="center">'.$sr_no.'</td>';       
															echo '<td>';
															$sel_tel = "select product_id,product_name,quantity from product where 1 and product_id='".$val_query['product_id']."' ".$_SESSION['where']." order by product_id asc";	 
															$query_tel = mysql_query($sel_tel);
															while($data=mysql_fetch_array($query_tel))
															{
																echo $data['product_name'];
															}
															echo '</td>';
															echo '<td >'.$val_query['product_qty'].'</td>';
															if($_SESSION['type']=='S')
															{
																echo '<td align="center"><a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&product_id='.$val_query['product_id'].'&quantity='.$val_query['product_qty'].'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
																echo '</td>';
															}
															echo '</tr>';
															$bgColorCounter++;
														}    
														?>
                                                        <tr class="head_td">
                                                            <td colspan="18">
                                                               <table cellspacing="0" cellpadding="0" width="100%">
                                                                    <tr>
                                                                        <?php
                                                                        	if($no_of_records>10)
																			{
																				echo '<td width="3%" align="left">Show</td>
																				<td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';												$show_records=array(0=>'10',1=>'20','50','100');
																				for($s=0;$s<count($show_records);$s++)
																				{
																					if($_SESSION['show_records']==$show_records[$s])
																						echo '<option selected="selected" value="'.$show_records[$s].'">'.$show_records[$s].' Records</option>';																			else
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
                                                    
                                                  	<?php 
												} 
      										else
       												echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Page found related to your search criteria, please try again</div><br></td></tr>';?>
											</table>
                                            </form>
										</td>
    									
  									</tr>
                                    <!--<tr>
                                    	<td class="bottom_left"></td>
                                        <td class="bottom_mid"></td>
                                        <td class="bottom_right"></td>
                                    </tr>-->
								</table>
                       <?php }	?>
							</div>
                                <!--right end-->
						</div>
                        <!--info end-->
                        <div class="clearit"></div>
                        <!--footer start-->
                        <div id="footer">
                        	<?php include "include/footer.php"; ?>
                        </div>
                        <td class="mid_right"></td>
                            <!--footer end-->
	</body>
</html>
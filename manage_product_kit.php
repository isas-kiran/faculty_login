<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Product Kit</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='317'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

?>

	<script type="text/javascript" src="../js/common.js"></script>
     <!-- Multiselect -->
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />
    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>
    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>
    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript">
       
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat:"dd/mm/yy", showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		//             $('input:radio[name=free_course][value=N]').click();
		//             $('input:radio[name=discount_course][value=Y]').click();
		//             $('input:radio[name=status][value=Inactive]').click();
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
    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT kit_id FROM product_kit where kit_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
								{
									$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('product_kit','Delete','kit delete','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									
									/*$sel_inv="select * from inword_product_map where inword_id='".$del_record_id."'";
									$ptr_inv=mysql_query($sel_inv);
									while($data_inv=mysql_fetch_array($ptr_inv))
									{
										$qty=$data_inv['sin_product_qty'];
										$product_id=$data_inv['product_id'];
								
										$sel_qty="select quantity from product where `product_id`='".$product_id."'";
										$ptr_qty=mysql_query($sel_qty);
										$data_qty=mysql_fetch_array($ptr_qty);
										$total=intval($data_qty['quantity']-$qty);
										
										$sql_query="UPDATE `product` SET `quantity`='".$total."' WHERE `product_id`='".$product_id."'";
										$query=mysql_query($sql_query);
									}*/
									
									$delete_query="delete from product_kit where kit_id='".$del_record_id."'";
									$db->query($delete_query); 
									
									$delete_query1="delete from product_kit_map where kit_id='".$del_record_id."'";
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
                        $sql_query= "SELECT kit_id FROM product_kit where kit_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {  
							$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('product_kit','Delete','Kit delete','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);
							
							/*$sel_inv="select * from product_kit_map where kit_id='".$del_record_id."'";
							$ptr_inv=mysql_query($sel_inv);
							while($data_inv=mysql_fetch_array($ptr_inv))
							{
								$qty=$data_inv['sin_product_qty'];
								$product_id=$data_inv['product_id'];
								$sel_qty="select quantity from product where `product_id`='".$product_id."'";
								$ptr_qty=mysql_query($sel_qty);
								$data_qty=mysql_fetch_array($ptr_qty);
								$total=intval($data_qty['quantity']-$qty);
								
								$sql_query="UPDATE `product` SET `quantity`='".$total."' WHERE `product_id`='".$product_id."'";
								$query=mysql_query($sql_query);
							}*/
                            $delete_query="delete from product_kit where kit_id='".$del_record_id."'";
                            $db->query($delete_query); 
							
							$delete_query1="delete from product_kit_map where kit_id='".$del_record_id."'";
                            $db->query($delete_query1);
							
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
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="16">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td width="20%">
                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                        <option value="">-Operation-</option>
                        <option value="delete">Delete</option>
                        <!-- <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>-->
                    </select>
				</td>
				<?php if($_SESSION['type']=='S')
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
				<!--<td width="10%"><input type="text" name="from_date" class="input_text datepicker" placeholder="From Date"  id="from_date" title="From Date" value="<?php //if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>"></td>
				<td width="10%"><input type="text" name="to_date" class="input_text datepicker" placeholder="To Date"  id="to_date"  title="To Date" value="<?php //if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>"></td>-->
				<td width="10%"><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
				<td width="40%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <!--<td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              	<tr>
              	<td></td>
              	<td class="width5"></td>
                
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              	</tr>
                    </table>	
                </td>
-->            </tr>
        	</table>
        </form>	
    </td>
  </tr>
						<?php
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                            $pre_keyword=" and (course_id like '%".$keyword."%')";
                        else
                            $pre_keyword="";
						
						$search_cm_id='';
						if($_SESSION['type']=="S" || $_SESSION['type']=="Z" || $_SESSION['type']=="LD")
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$search_cm_id_s=" and i.cm_id='".$data_cm_id['cm_id']."'";
							}
							else
							{
								$search_cm_id='';
								$search_cm_id_s='';
							}
						}
						$from_date='';
						$to_date='';
						$from_date_sp='';
						$to_date_sp='';
						if($_REQUEST['from_date']!="")
						{
							$sep=explode("/",$_REQUEST['from_date']);
							$from_dates=$sep[2]."-".$sep[1]."-".$sep[0];
							$from_date=" and DATE(added_date) >='".$from_dates."'";
                          	$from_date_i=" and DATE(i.added_date) >='".$from_dates."'";
						}
						if($_REQUEST['to_date']!="")
						{
							$sep=explode("/",$_REQUEST['to_date']);
							$to_dates=$sep[2]."-".$sep[1]."-".$sep[0];
                            $to_date=" and DATE(added_date) <='".$to_dates."'";
							$to_date_i=" and DATE(i.added_date) <='".$to_dates."'";
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

                        if($_GET['orderby']=='inventory_id' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='inventory_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by kit_id desc';  
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and kit_id='".$_GET['record_id']."' ";
						}	
						/*if($pre_keyword=='')
						{                    
						    $sql_query= "SELECT * FROM inword_inventory where 1 ".$record_cat_id." ".$_SESSION['where']."  ".$search_cm_id." ".$from_date." ".$to_date." ".$pre_keyword." ".$select_directory."";//".$_SESSION['user_id']." 25-12-17
						}
						else
						{
							$cm_ids=='';
							$admin_ids='';
							if($_SESSION['where'] !='')
							{
								$cm_ids=" and i.cm_id='".$_SESSION['cm_id']."'";
							}
							if($_SESSION['user_id'] !='')
							{
								$admin_ids=" and i.admin_id='".$_SESSION['admin_id']."'";
							}
						    
						}*/
						$sql_query= "select * from product_kit where 1 ".$_SESSION['where']." ".$search_cm_id." ".$pre_keyword." ".$select_directory." "; //".$admin_ids."  25-12-17
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    						<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     		<input type="hidden" name="formAction" id="formAction" value=""/>
                          	<tr class="grey_td" >
                            <?php
                            if( $_SESSION['type'] =='S' )
                            {	
								?>
									<td width="2%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
								<?php 
								}
                            ?>
                            <td width="3%" align="center"><strong>Sr. No.</strong></td>
                            <td width="15%" align="center"><strong>Branch Name</strong></td>
                            <td width="20%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=vendor".$query_string;?>"class="table_font"><strong>Course Name</strong></a><?php echo $img1;?></td>
                            <td width="10%" align="center"><strong>Stockiest</strong></td>
                            <td width="10%" align="center"><strong>No. Of Products</strong></td>
                           	<td width="10%" align="center"><strong>Added_date</strong></td>
                          	<td width="10%" align="center"><strong>Action</strong></td>
	                       	</tr>
                      
                      		<style>
								hr.style4 { 
								  border: 0; 
								  height: 1px; 
								  background-image: -webkit-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
								  background-image: -moz-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
								  background-image: -ms-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0);
								  background-image: -o-linear-gradient(left, #f0f0f0, #8c8b8b, #f0f0f0); 
								}
							</style>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['kit_id']; 
                                include "include/paging_script.php";
								if($_SESSION['type'] =='S')
								{
									echo '<tr '.$bgcolor.' >
                                    <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>'; 
								
								$sel_branchNme="select name,branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
								$ptr_brName=mysql_query($sel_branchNme);
								$data_brName=mysql_fetch_array($ptr_brName);
								$branchName=$data_brName['branch_name'];
								echo '<td align="center">'.$branchName.'</td>'; 
								
								$sql_course="select * from courses where course_id='".$val_query['course_id']."' ";
								$ptr_course= mysql_query($sql_course);
								$val_course= mysql_fetch_array($ptr_course);
								echo '<td align="center">'.$val_course['course_name'].'</td>'; 
								
							  	$sql_stockiest= " select name, admin_id from site_setting where admin_id='".$val_query['stockiest_id']."' ";
								$ptr_stockiest= mysql_query($sql_stockiest);
								$data_stockiest= mysql_fetch_array($ptr_stockiest);
                                echo '<td align="center">'.$data_stockiest['name'].'</td>';
								
								$sql_kit= "select kit_map_id from product_kit_map where kit_id='".$val_query['kit_id']."' ";
								$ptr_kit= mysql_query($sql_kit);
								$total_kit = mysql_num_rows($ptr_kit);
                                echo '<td align="center">'.$total_kit.'</td>';
								
								/*echo '<td align="center">';
								$sel_product="select inword_id,product_id,sin_product_qty from inword_product_map where inword_id ='".$val_query['inword_id']."'";
								$ptr_product=mysql_query($sel_product);
								$k=1;
								$count=mysql_num_rows($ptr_product);
								while($data_product=mysql_fetch_array($ptr_product))
								{
									$select_service_name="select product_name,price,admin_id from product where product_id='".$data_product['product_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									$name='';
									if($_SESSION['type'] =='S')
									{
										$sel_emp="select name from site_setting where admin_id='".$data_service_name['admin_id']."'";
										$ptr_admin_id=mysql_query($sel_emp);
										$data_name=mysql_fetch_array($ptr_admin_id);
										
										$name= "(".$data_name['name'].")";
									}
									echo $data_service_name['product_name']."&nbsp;&nbsp;&nbsp;".$name."<br />";
									if($k !=$count)
									{
										echo '<hr class="style4">';
									}
									$k++;
								}
								echo '</td>';*/
								
                                echo '<td align="center">'.$val_query['added_date'].'</td>';
                                echo '<td align="center">';
								//echo '<a href="add_inventory.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
								echo '<a href="product_kit.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
								echo '<a href="sale_product_kit.php?record_id='.$listed_record_id.'" target="_blank"><img src="images/ch_product.png" title="Sale Kit" width="20" hight="20" class="example-fade"/></a>&nbsp;&nbsp;';
								if($_SESSION['type'] =='S')
								{
                                    echo' &nbsp;&nbsp; <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
								}
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
                            </tr>
                       	</form>
      					<?php 		
					} 
      				else
        				echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Page found related to your search criteria, please try again</div><br></td></tr>';?>
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
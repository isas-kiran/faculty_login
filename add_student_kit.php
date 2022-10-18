<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='39'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Student Kit</title>
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
    	<table width="100%" cellspacing="0" cellpadding="0">
     	<?php 
		if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
		{
			$action='delete';
			$del_record_id=$_REQUEST['record_id'];
			$product_id=$_REQUEST['product_id'];
			$quantity=$_REQUEST['quantity'];
			$totaal='';
			
			
			$query_kit="SELECT * FROM `student_kit_map` WHERE `student_kit_id`='".$del_record_id."' ";
			$kit_query=mysql_query($query_kit);
			$fetch_kit=mysql_fetch_array($kit_query);
			
			
			$sql_query="UPDATE `product_user_map` SET quantity_in_consumable=(quantity_in_consumable +".$fetch_kit['product_qty'].") WHERE `product_id`='".$fetch_kit['product_id']."' and user_id='".$fetch_kit['admin_id']."'";
			$query=mysql_query($sql_query);
			
			$sql_query="UPDATE `consumption` SET quantity=(quantity +".$fetch_kit['product_qty']."), consume_qty=(consume_qty -".$fetch_kit['product_qty'].") WHERE `product_id`='".$fetch_kit['product_id']."' and employee_id='".$fetch_kit['admin_id']."'";
			$query=mysql_query($sql_query);
			
			$delete_kit="delete from consumption_map where checkout_id='".$del_record_id."' and product_id='".$fetch_kit['product_id']."'";
			$ptr_delete=mysql_query($delete_kit);
			
			$delete_kit_map="delete from student_kit_map where student_kit_id='".$del_record_id."' ";
			$ptr_delete_map=mysql_query($delete_kit_map);
			
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_student_kit','Delete','".$fetch_kit['product_id']."','".$del_record_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
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
				setTimeout('document.location.href="add_student_kit.php?record_id=<?php echo $_GET['record_id']; ?>";',500);
				</script>
                
				<?php
			
		}
        $success=0;
        if($_POST['save_changes'])
        {
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
                $sel_recod="select * from enrollment where enroll_id='".$record_id."'";
				$ptr_record=mysql_query($sel_recod);
				$data_enroll_record=mysql_fetch_array($ptr_record);
				
                $data_record['admin_id']=$_SESSION['admin_id'];
				$data_record['cm_id']=$data_enroll_record['cm_id'];
                for($i=1;$i<=$total_floor;$i++)
                {
                    if($_POST['product_id'.$i] !='')
                    {
                        $data_record['enroll_id'] = $record_id;
                        $data_record['product_id']=$_POST['product_id'.$i];
                        $data_record['product_qty']=$_POST['product_qty'.$i];
                        $data_record['added_date'] = date('Y-m-d H:i:s');
                        
                        $kit_prod_id=$db->query_insert("student_kit_map",$data_record);
                        
						$select_qty="select * from consumption where product_id='".$data_record['product_id']."' and employee_id='".$data_record['admin_id']."'";
						$ptr_qty=mysql_query($select_qty);
						if(mysql_num_rows($ptr_qty))
						{ 
							$data_qty=mysql_fetch_array($ptr_qty);
							$consumption_id=$data_qty['consumption_id'];
							$remaining_qty=$data_qty['quantity']-$_POST['product_qty'.$i];
							
							$update_qty="update consumption set quantity=(quantity - '".$_POST['product_qty'.$i]."'),consume_qty=consume_qty+".$_POST['product_qty'.$i]." where product_id='".$data_record['product_id']."' and employee_id='".$data_record['admin_id']."'";
							$ptr_qty=mysql_query($update_qty);
						}
						else
						{
							$sel_qty="select quantity_in_consumable from product_user_map where product_id='".$_POST['product_id'.$i]."' and user_id='".$data_record['admin_id']."'";
							$ptr_qty=mysql_query($sel_qty);
							$data_qty=mysql_fetch_array($ptr_qty);
							
							$remaining_qty=$data_qty['quantity_in_consumable']-$_POST['product_qty'.$i];
							
							$insert_for_receipt = "insert into consumption (`product_id`,`quantity`,`consume_qty`,`description`,`employee_id`,`admin_id`, `cm_id`,`added_date`) values('".$data_record['product_id']."','".$remaining_qty."','".$_POST['product_qty'.$i]."','Student Kit issued','".$data_record['admin_id']."','".$data_record['admin_id']."','".$data_record['cm_id']."','".date('Y-m-d')."')";
							$ptr_insert_receipt = mysql_query($insert_for_receipt);
							$consumption_id=mysql_insert_id();
						}
						
						$insert_for_receipt = "insert into consumption_map (`consumption_id`,`checkout_id`,`product_id`,`quantity`,`consume_qty`,`description`,`employee_id`,`admin_id`,`cm_id`,`added_date`) values('".$consumption_id."','".$kit_prod_id."','".$data_record['product_id']."','".$remaining_qty."','".$_POST['product_qty'.$i]."','Student Kit issued','".$data_record['admin_id']."','".$_SESSION['admin_id']."','".$data_record['cm_id']."','".date('Y-m-d')."')";
						$ptr_insert_receipt = mysql_query($insert_for_receipt);
						
						$update_product="update product_user_map set quantity_in_consumable=(quantity_in_consumable - '".$_POST['product_qty'.$i]."') where product_id='".$_POST['product_id'.$i]."' and user_id='".$data_record['admin_id']."'";
						$up_prod=mysql_query($update_product);
                        //$query_update=mysql_query($update_product);
                    }
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
                setTimeout('document.location.href="add_student_kit.php?record_id=<?php echo $record_id; ?>";',700);
                </script>
                <?php								
            }
        }
		
        if($success==0)
        {	
			?>
            <tr>
       		<td colspan="4">
            <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                <tr>
                    <td width="18%">Select Product<span class="orange_font">*</span></td>
                    <td width="70%" colspan="2">
                        <table  width="75%" style="border:1px solid gray; ">
                            <tr>
                                <td colspan="2">
                                    <!--===========================================================NEW TABLE START===================================-->
                                    <table cellpadding="5" width="100%" >
                                        <tr>
                                        <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText" size="1" onKeyUp="create_floor();" value="0" />
                                        <script language="javascript">                               
                                        function floors(idss)
                                        {
                                            var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="4%" align="center"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><select name="product_id'+idss+'" id="product_id'+idss+'" style="width:200px" ><option value="">Select Product</option><?php
                                            $sel_tel = "select product_id,quantity_in_consumable from product_user_map where quantity_in_consumable > 0 ".$_SESSION['where']." and user_id='".$_SESSION['admin_id']."' order by product_id asc";	 
                                            $query_tel = mysql_query($sel_tel);
                                            if($total=mysql_num_rows($query_tel))
                                            {
                                                while($data=mysql_fetch_array($query_tel))
                                                {
                                                    $sel_emp="select product_name from product where product_id='".$data['product_id']."'";
                                                    $ptr_admin_id=mysql_query($sel_emp);
                                                    $data_name=mysql_fetch_array($ptr_admin_id);
                                                    $name= "(".$data_name['name'].")";
                                                    
                                                    echo '<option value="'.$data['product_id'].'">'.stripslashes($data_name['product_name']).'&nbsp;&nbsp;(Quantity remaining-'.$data['quantity_in_consumable'].')</option>';
                                                }
                                            } 
                                            ?>
                                            </select></td><td width="3%" align="center"><input type="text" name="product_qty'+idss+'" id="product_qty'+idss+'" style=" width:100px" onkeyup="validation(this.value,'+idss+')"/></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';
                                            document.getElementById('floor').value=idss;
                                            return shows_data;
                                        }
                                        </script>
                                            <td align="right"><input type="button"  name="Add"s class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 
                                            <input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>  </td><td align="left"></td>
                                        </tr>
                                    </table> 
                                    <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">
                                        <tr>
                                            <td align="center"></td><td align="center"></td><td align="center"></td>
                                        </tr>
                                        <tr >
                                            <td align="center" width="25%" ></td>
                                            <td width="10%"> </td><td width="5%"> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                            <table cellspacing="3" id="tbl" width="100%">
                                            <tr>
                                            <td valign="top" width="33%" align="center">Product Name</td>
                                            <!--<td valign="top" width="20%"  align="center">Total Quantity</td>-->
                                            <td valign="top" width="20%"  align="center">Quantity</td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="floor" id="floor"  value="0" />
                                    <div id="create_floor"></div>
                                </td>
                            </tr>
                        </table>
                    			</td>
                			</tr>
                		</table>
                	</td>
                </tr>
                <tr>                 
                    <td colspan="3" align="center"><input type="submit" class="input_btn" value="Save Product" name="save_changes" /></td>      
                </tr>
            </table>
            </form>
            </td>
            </tr>
            <?php
		} 
		
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
				$select_directory='order by student_kit_id asc';                      
				$sql_query = "select * from student_kit_map where enroll_id='".$record_id."' order by student_kit_id desc ";                
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
                    	<!--<td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>-->
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
                        <td width="20%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=country_name".$query_string;?>" class="table_font"><strong>Product Name</strong></a> <?php echo $img1;?></td>
                        <td width="10%"><strong>Quantity</strong></td>
                    	<!--<td width="10%"><strong>Post date</strong></td>
                        <td width="15%"><strong>Tag</strong></td>
                        <td width="20%" class="centerAlign"><strong>Image</strong></td>-->
                        <?php 
                        if($_SESSION['type']=='S' || $edit_access=='yes')
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
						
						$listed_record_id=$val_query['student_kit_id']; 
						include "include/paging_script.php";						
					   	// echo '<tr '.$bgcolor.' >
						// <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
						echo '<td align="center">'.$sr_no.'</td>';       
						echo '<td >';
						$sel_tel = "select product_id,product_name,quantity from product where 1 and product_id='".$val_query['product_id']."' ".$_SESSION['where']." order by product_id asc";	 
						$query_tel = mysql_query($sel_tel);
						while($data=mysql_fetch_array($query_tel))
						{
							echo $data['product_name'];
						}
						echo '</td>';
						echo '<td >'.$val_query['product_qty'].'</td>';
						if($_SESSION['type']=='S' || $edit_access=='yes')
						{
							echo '<td align="center"><a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
							echo '</td>';
						}
						echo '</tr>';														
						$bgColorCounter++;
					}
					?>
					<tr class="head_td">
                        <td colspan="8">
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
<script language="javascript">
create_floor('add');
</script>
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

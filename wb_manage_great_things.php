<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Great Things</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
<link rel="stylesheet" href="js/chosen.css" />
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
var pageName = "manage_product";
$(document).ready(function()
{   <?php
	if($_SESSION['type']=='S') {?>
	$("#branch_name").chosen({allow_single_deselect:true});
	<?php
	}
	?>
	$("#stockiest").chosen({allow_single_deselect:true});
	$("#status_type").chosen({allow_single_deselect:true});
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
	else if(action=="change_owner")
	{
		$( ".new_custom_course" ).dialog({
			width: '500',
			height:'150'
		});
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
function select_stockiest(branch_name)
{
	var data1="action=stockiest&branch_name="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "get_stockiest.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html !='')
		{
			//alert(html);
			document.getElementById("stockiest_id").innerHTML=html;
			$("#stockiest").chosen({allow_single_deselect:true});
		}
	}
	});
}
function set_status(values,ids)
{
	var data1="action=set_web_status&status="+values+"&prod_id="+ids;	
	//alert(data1);
	$.ajax({
		url: "set_status.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
		}
	});
}
function set_sequance(values,ids)
{
	var data1="action=set_web_seq_status&status="+values+"&prod_id="+ids;	
	//alert(data1);
	$.ajax({
		url: "set_status.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
		}
	});
}
function set_brand(values,ids)
{
	var data1="action=set_prod_brand&status="+values+"&prod_id="+ids;	
	//alert(data1);
	$.ajax({
		url: "get_assigned.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
		}
	});
}

function change_qty(id,values)
{
	var data1="action=set_quantity&id="+id+"&values="+values;	
	//alert(data1);
	$.ajax({
		url: "set_quantity.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			//alert(html);
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
        <td class="top_mid" valign="bottom"><?php include "include/website_menu.php";?></td>
        <td class="top_right"></td>
  	</tr>
    <?php       
	if($_POST['formAction'])
	{
		if($_POST['formAction']=="delete")
		{
			for($r=0;$r<count($_POST['chkRecords']);$r++)
			{
				$del_record_id=$_POST['chkRecords'][$r];
				$sql_query= "SELECT id,event_name FROM wb_great_things where id ='".$del_record_id."'";
				$ptr_query=mysql_query($sql_query);
				if(mysql_num_rows($ptr_query))
				{    
					$cust_data=mysql_fetch_array($ptr_query);  
					
					$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_great_things','Delete','".$cust_data['event_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);                                                   
					$delete_query="delete from wb_great_things where id='".$del_record_id."'";
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
		$sql_query= "SELECT id,event_name FROM wb_great_things where id='".$del_record_id."'";
		$ptr_query=mysql_query($sql_query);
		if(mysql_num_rows($ptr_query))
		{    
			$cust_data=mysql_fetch_array($ptr_query);  
			
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_great_things','Delete','".$cust_data['event_name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert);                          
			$delete_query="delete from wb_great_things where id='".$del_record_id."'";
			$db->query($delete_query);

			?>
			<div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record deleted successfully</p></center></div>
			<script type="text/javascript">
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
			<?php
			$sep_url_string='';
			$sep_url= explode("?",$_SERVER['REQUEST_URI']);
			if($sep_url[1] !='')
			{
				$sep_url_string="?".$sep_url[1];
			}
			?>   
  			<tr class="head_td">
    			<td colspan="21">
        			<form method="get" name="search">
						<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              				<tr>
                				<td class="width5"></td>
               					<td width="20%">
								<?php
                                if( $_SESSION['type'] =='S')
                                {	
                                    ?>
                                    <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                        <option value="">-Operation-</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    </td>
                                    <?php
                                }
                                if($_SESSION['type']=='S')
                                {
                                    ?>
                                    <td width="15%">
                                        <select name="branch_name" id="branch_name" onchange="select_stockiest(this.value)" class="input_select_login" style="width: 150px; ">
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
                                } ?>
                                <td width="15%">
                                    <select name="status_type" id="status_type" class="input_select_login" style="width: 150px;">
                                    	<option value="">-Select Status-</option>
                                    	<option value="Active" <?php if($_REQUEST['status_type']=='Active') echo 'selected="selected"'; else if($_REQUEST['status_type']=='') echo 'selected="selected"'; ?> >Active</option>
                                    	<option value="Inactive" <?php if($_REQUEST['status_type']=='Inactive') echo 'selected="selected"';?>>Inactive</option>
                                    </select>
                                </td>
								<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
								<!--<td> <a href="product_export.php<?php //echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  -->
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
				$pre_keyword=" and (event _name like '%".$keyword."%')";
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
			if($_SESSION['type']=="S")
			{
				if($_REQUEST['branch_name']!='')
				{
					$branch_name=$_REQUEST['branch_name'];
					$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
					$ptr_cm_id=mysql_query($select_cm_id);
					$data_cm_id=mysql_fetch_array($ptr_cm_id);
					$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
				}
				else
				{
					$branch_name='';
				}
				
			}
			else
			{
				$search_cm_id_S='';
			}

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

			if($_GET['orderby']=='asset_name' )
				$img1 = $img;

			
							
			$record_cat_id='';
			if($_GET['record_id'] !='')
			{
				$record_cat_id="and id='".$_GET['record_id']."' ";
			}
			
			$status_type ="";
			if($_REQUEST['status_type']!='')
			{
				if($_REQUEST['status_type']=='Inactive')
				{
					$status_type .=" or status is NULL )";
				}
				else if($_REQUEST['status_type']=='Active')
				{
					$status_type .=" or status is NULL )";
				}
			}
			
			if($_GET['order'] !='' && ($_GET['orderby']=='asset_name'))
			{
				$select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
				$date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
			}
			else
				$select_directory='order by ABS(sequence_id) asc';  
				
			$sql_query= "SELECT * FROM wb_great_things where 1 ".$status_type." ".$pre_keyword." ".$select_directory." "; 
			$no_of_records=mysql_num_rows($db->query($sql_query));
			if($no_of_records)
			{
				$bgColorCounter=1;
				//$_SESSION['show_records'] = 10;
				$query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&status_type='.$_REQUEST['status_type'];
				$query_string1=$query_string.$date_query;
				// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
				$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
				$all_records= $pager->paginate();
				?>
    				<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                    	<input type="hidden" name="formAction" id="formAction" value=""/>
                    	<input type="hidden" name="councillior_admin_id" id="councillior_admin_id" value=""  />
                      	<tr class="grey_td" >
                            <td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                            <td width="3%" align="center"><strong>Sr. No.</strong></td>
                            <td width="4%" align="center"><strong>Sequence No</strong></td>
                            <td width="15%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=product_name".$query_string;?>" class="table_font"><strong>Event Name</strong></a> <?php echo $img1;?></td>
                            <td width="5%" align="center"><strong>Event Category</strong></td>
                            <td width="4%" align="center"><strong>Description</strong></td>
                            <td width="3%" align="center"><strong>Fb Link</strong></td>
                            <td width="3%" align="center"><strong>Gogole Link</strong></td>
                            <td width="3%" align="center"><strong>Image 1</strong></td>
                            <td width="3%" align="center"><strong>Image 2</strong></td>
                            <td width="3%" align="center"><strong>Image 3</strong></td>
							<td width="4%" align="center"><strong>Status</strong></td>
                        	<td width="5%" align="center"><strong>Added By</strong></td>
                         	<td width="5%" align="center"><strong>Added Date</strong></td>
                        	<td width="5%" class="centerAlign"><strong>Action</strong></td>
                      	</tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['id']; 
                                $position=100; // Define how many character you want to display.                                
                                $post = substr(stripslashes($val_query['description']), 0, $position);
								
                                include "include/paging_script.php";
								echo '<tr '.$bgcolor.' >';								
								echo '<td align="center">';
									echo '<input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'">';
								echo '</td>';
                                echo '<td align="center">'.$sr_no.'</td>'; 
								echo '<td align="center"><input type="text" style="width:30px" width="50px" name="sequence_no" id="sequence_no" value="'.$val_query['sequence_id'].'" onkeyup="set_sequance(this.value,'.$listed_record_id.')"></td>';
                                echo '<td >'.$val_query['event_name'].'</td>';
								$cat_name='';					
								if($val_query['category_id']=='1')
								{
									$cat_name='Events';
								}
								else if($val_query['category_id']=='2')
								{
									$cat_name='Student Post';
								}
								else if($val_query['category_id']=='3')
								{
									$cat_name='Ceremoney & Awards';
								}
								else if($val_query['category_id']=='4')
								{
									$cat_name='Latest News';
								}

								echo '<td align="center">'.$cat_name.'</td>';
								echo '<td align="center">'.$post.'...<strong>Read More</strong></td>';
								echo '<td align="center">'.$val_query['fb_link'].'</td>';
								echo '<td align="center">'.$val_query['google_link'].'</td>';
								if($val_query['image1']!='')
								{
									echo '<td align="center"><img height="50px" width="50px" src="images/website/'.$val_query['image1'].'"></td>';
								}
								else
								{
									echo '<td></td>';
								}
								if($val_query['image2']!='')
								{
									echo '<td align="center"><img height="50px" width="50px" src="images/website/'.$val_query['image2'].'"></td>';
								}
								else
								{
									echo '<td></td>';
								}
								if($val_query['image3']!='')
								{
									echo '<td align="center"><img height="50px" width="50px" src="images/website/'.$val_query['image3'].'"></td>';
								}
								else
								{
									echo '<td></td>';
								}
								echo '<td align="center">';
								echo '<select name="eve_status" id="eve_status" class="input_select" style="width:100px;" onChange="set_status(this.value,'.$listed_record_id.')">
								<option value="">Select</option>';
								$act_selecteds = '';
								$inact_selecteds='';
								if($val_query['status']=='Active')
									$act_selecteds = 'selected="selected"';
								else if	($val_query['status']=='Inactive')
									$inact_selecteds = 'selected="selected"';
									
								echo "<option value='Active' ".$act_selecteds." >Active</option>";
								echo "<option value='Inactive' ".$inact_selecteds." >Inactive</option>";
								echo'</select>';
								echo '</td>';
								
								$sel_emp="select name from site_setting where admin_id='".$val_query['admin_id']."'";
								$ptr_admin_id=mysql_query($sel_emp);
								if(mysql_num_rows($ptr_admin_id))
								{
									$data_name=mysql_fetch_array($ptr_admin_id);
									$name= "".$data_name['name']."";
								}
								echo '<td align="center">'.$name.'</td>';
                                echo '<td align="center">'.$val_query['added_date'].'</td>';
								
                                echo '<td align="center">';
								//if( $_SESSION['type'] =='S' || $_SESSION['type'] =='LD' || $_SESSION['type'] =='Z')
						       	//{
									echo '<a href="wb_add_great_things.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
								//}
								if( $_SESSION['type'] =='S')
						       	{
                                	echo'<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
								}
                                echo '</td>';
							   	echo '</tr>';
                                $bgColorCounter++;
                            }    
                            ?>
  
  <tr class="head_td">
    <td colspan="20">
       <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                      if($no_of_records>10)
						{
							echo '<td width="3%" align="left">Show</td>
							<td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
							$show_records=array(0=>'10',1=>'20','50','100','200','300');
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
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Page found related to your search criteria, please try again</div><br></td></tr>';?>
</table>
	</td>
    <td>
    
    <script type="text/javascript">
                $(function()    
                {
    	            $(".custom_cuorse_submit").click(function(){
                    var councillior_id = $("#councillior_id").val();
                               
                    if(councillior_id == "" || councillior_id == undefined)
                    {
        	            alert("Select Councillor name.");
                        return false;
                    }
					else
					{
						$("#councillior_admin_id").val(councillior_id);
						$('.new_custom_course').dialog( 'close');
						setTimeout(document.frmTakeAction.submit(),3000)
					}
                    /*if(mobile1 == "" || mobile1 == undefined)
                    {
            	        alert("Enter Mobile no.");
                        return false;
                    }
                    if(email == "" || email == undefined)
                    {
                	    alert("Eneter Email ID.");
                        return false;
                    }*/
                    /*var data1 = 'action=custome_councillior_submit&councillior_id='+councillior_id
                    $.ajax({
                    	url: "ajax.php", type: "post", data: data1, cache: false,
                        success: function (html)
                        {
                        	if(html.trim() =='mobile')
                            {
                            	alert("Mobile no. or Email already Exist");
                                return false;
                            }
                            else if(html.trim() =='cust_id')
                            {
                            	alert("Customer Name already Exist");
                                return false;
                            }
                            else if (html.trim() =='blank')
                            {
                            	alert("Please enter Mobile number");
                                return false;
                            }
                            else
                            {
                            	$(".customized_select_box").html(html);
                               
                                $('.new_custom_course').dialog( 'close');
                                $("#customer_id").chosen({allow_single_deselect:true});
                               
                            }
                        }
                        });*/
                    });
             });
            </script>
            <div class="new_custom_course" style="display: none;">
                <form method="post" id="jqueryForm" name="discount" enctype="multipart/form-data">
                    <table border="0" cellspacing="15" cellpadding="0" width="100%">
                        <tr>
                            <td colspan="3" class="orange_font">* Mandatory Fields</td>
                        </tr>
                        <tr>
                            <td width="20%">Select Vendor<span class="orange_font">*</span></td>
                            <td width="40%">
                            <select name="councillior_id" id="councillior_id">
                            <option value="">Select Vendor Name</option>
                            <?php
							$sle_name="select * from vendor where 1 ".$_SESSION['where']." order by vendor_id asc"; 
							$ptr_name=mysql_query($sle_name);
							while($data_name=mysql_fetch_array($ptr_name))
							{
								
								echo '<option value="'.$data_name['vendor_id'].'">'.$data_name['name'].'</option>';
							}
							?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="button" class="inputButton custom_cuorse_submit" value="Submit" name="submit"/>&nbsp;
                                <input type="reset" class="inputButton" value="Close" onClick="$('.new_custom_course').dialog( 'close');"/>
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
<!--footer start-->
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>

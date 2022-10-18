<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Return Book</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
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
			document.getElementById("stockiest").innerHTML=html;
		}
	}
	});
}
function set_status(values,ids)
{
	var data1="action=set_prod_status&status="+values+"&prod_id="+ids;	
	//alert(data1);
	$.ajax({
		url: "get_assigned.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			alert(html);
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
    <td class="top_mid" valign="bottom"><?php include "include/library_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT book_issue_id FROM lb_book_issue where book_issue_id ='".$del_record_id."'";
                                $ptr_query=mysql_query($sql_query);
								if(mysql_num_rows($ptr_query))
								{    
									$cust_data=mysql_fetch_array($ptr_query);  
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_issue_book','Delete','".$cust_data['book_issue_id']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);              
									                                     
									$delete_query="delete from lb_book_issue where book_issue_id='".$del_record_id."'";
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
                        $sql_query= "SELECT book_issue_id FROM lb_book_issue where book_issue_id='".$del_record_id."'";
                        $ptr_query=mysql_query($sql_query);
						if(mysql_num_rows($ptr_query))
						{    
							$cust_data=mysql_fetch_array($ptr_query);  
							
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_isssue_book','Delete','".$cust_data['book_issue_id']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert);                          
                            $delete_query="delete from lb_book_issue where book_issue_id='".$del_record_id."'";
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
    <td colspan="18">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
<!--                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>-->
                        </select></td>
				<?php if($_SESSION['type']=='S')
				{
				?>
                 <td width="20%">
                    <select name="branch_name" id="branch_name" onchange="select_stockiest(this.value)" class="input_select_login"  style="width: 150px; ">
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
				<td id="stockiest" width="16%">
				<?php
				if($_GET['branch_name'] !='')
				{
					$branch_name=$_GET['branch_name'];
					echo'<select name="stockiest" id="stockiest" class="input_select_login"  style="width: 150px; ">
							<option value="">-Select Stockiest-</option>';
					$sel_stockiest="select * from site_setting where branch_name='".$branch_name."' and type='ST'";
					$ptr_stockiest=mysql_query($sel_stockiest);
					while($data_stockist=mysql_fetch_array($ptr_stockiest))
					{
						$sel='';
						if($data_stockist['admin_id']==$_GET['stockiest'])
						{
							$sel='selected="selected"';
						}
						echo '<option '.$sel.' value="'.$data_stockist['admin_id'].'" > '.$data_stockist['name'].'</option>';
					}
					echo '</select>';
				}
				?>
				</td>		
				<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <? } ?>
				<td> <a href="product_export.php<?php echo $sep_url_string; ?>"><img src="images/excel.png" height="30px" width="30px"/></a></td>  
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
                            $pre_keyword=" and (b.book_name like '%".$keyword."%' || b.isbn_no like '%".$keyword."%' || i.status like '%".$keyword."%' || i.user_type like '%".$keyword."%' || i.issue_days like '%".$keyword."%')";
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
								$search_cm_id_S=" and i.cm_id='".$data_cm_id['cm_id']."'";
							}
							else
							{
								$branch_name='';
								$search_cm_id_S='';
							}
						}
						else
						{
							$search_cm_id_S='';
							$search_admin_id_S='';
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

                        if($_GET['orderby']=='book_return_id' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='book_return_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							$select_directory='order by i.book_return_id desc';  
						$record_cat_id='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and i.book_return_id='".$_GET['record_id']."' ";
						}
						if($_SESSION['where'] !='')
						{
							$cm_ids="and i.cm_id='".$_SESSION['cm_id']."'";
						}
						$sql_query= "SELECT i.book_return_id,i.book_id,i.return_by,i.return_date,s.issue_date,i.user_type,i.status,i.fine FROM lb_book_return i left join lb_book_issue s on i.book_issue_id=s.book_issue_id ".$record_cat_id." ".$cm_ids." ".$search_cm_id_S." ".$pre_keyword." ".$select_directory."";
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    				<form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
					   <?php
						if( $_SESSION['type'] =='S')
						{	
							?>
							<td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
							<?php
						}
						?>
                        <td width="3%" align="center"><strong>Sr. No.</strong></td>
                        <td width="7%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=book_name".$query_string;?>" class="table_font"><strong>Book Name</strong></a> <?php echo $img1;?></td>
						<td width="5%" align="center"><strong>ISBN No</strong></td>
                        <td width="9%" align="center"><strong>Issued to</strong></td>
                        <td width="4%" align="center"><strong>Issued date</strong></td>
                        <td width="4%" align="center"><strong>Returned date</strong></td>
                        <td width="6%" align="center"><strong>Fine</strong></td>
                        <td width="4%" align="center"><strong>User type</strong></td>
                        <td width="10%" align="center"><strong>Status</strong></td>
                        	
						<?php
						if( $_SESSION['type'] =='S' || $_SESSION['type'] =='ST')
						{	
						?>
                            <td width="6%" class="centerAlign"><strong>Action</strong></td>
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
							
							$listed_record_id=$val_query['book_return_id']; 
							$position=120; // Define how many character you want to display.                                
							$post = substr(strip_tags($val_query['description']), 0, $position);
						   	
							$sel_book="select book_name,isbn_no from lb_book where book_id='".$val_query['book_id']."'";
							$ptr_book=mysql_query($sel_book);
							$data_book=mysql_fetch_array($ptr_book);
							
							include "include/paging_script.php";
							echo '<tr '.$bgcolor.' >';
							if($_SESSION['type'] =='S')
							{	
								echo '<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
							}
							echo '<td align="center">'.$sr_no.'</td>'; 
							echo '<td >'.$data_book['book_name'].'</td>';			
							if($val_query['user_type']=="Student")	
							{
								$sel_user="select name from enrollment where enroll_id='".$val_query['return_by']."'";
								$query_user=mysql_query($sel_user);
								$data_user=mysql_fetch_array($query_user);
								$name=$data_user['name'];
							}	
							else if($val_query['user_type']=="Employee")		
							{
								$sel_user="select name from site_setting where admin_id='".$val_query['return_by']."'";
								$query_user=mysql_query($sel_user);
								$data_user=mysql_fetch_array($query_user);
								$name=$data_user['name'];
							}	
							
							echo '<td align="center">'.$data_book['isbn_no'].'</td>';
							echo '<td align="center">'.$name.'</td>';
							echo '<td align="center">'.$val_query['issue_date'].'</td>';							
							echo '<td align="center">'.$val_query['return_date'].'</td>';
							echo '<td align="center">'.$val_query['fine'].'</td>';
							echo '<td align="center">'.$val_query['user_type'].'</td>';
							echo '<td align="center">'.$val_query['status'].'</td>';
							
							echo '<td align="center">';
							if( $_SESSION['type'] =='S' || $_SESSION['type'] =='ST')
							{
								//echo '<a href="lb_add_book.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
							}
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
    <td colspan="18">
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

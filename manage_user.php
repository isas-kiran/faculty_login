<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage User</title>
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
function set_cookiess(username, user_id)
{
	var data1="action=cookies&user_id="+user_id+"&username="+username;	
	//alert(data1);
	$.ajax({
	url: "set_cookies.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html !='')
		{
			//alert(html);
			alert("Setting save successfully for "+username);
			//document.getElementById("unit_id").innerHTML=html;
			document.location.href="manage_user.php";
		}
	}
	});
}
</script>
<script>
function user_status(values,ids)
{
	var data1="action=user_status&status="+values+"&admin_id="+ids;	
	$.ajax({
		url: "set_status.php", type: "post", data: data1, cache: false,
		success: function (html)
		{
			alert(html);
		}
	});
}

function sys_status(values,ids)
{
	var data1="action=system_status&status="+values+"&admin_id="+ids;	
	$.ajax({
		url: "set_status.php", type: "post", data: data1, cache: false,
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
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='93'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/user_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php if($_POST['formAction'])
	{
		if($_POST['formAction']=="delete")
		{
			for($r=0;$r<count($_POST['chkRecords']);$r++)
			{
				$del_record_id=$_POST['chkRecords'][$r];
				$sql_query= "SELECT admin_id FROM ".$GLOBALS["pre_db"]."site_setting where admin_id ='".$del_record_id."'";
				if(mysql_num_rows($db->query($sql_query)))
				{
					"<br>".$sql_query= "SELECT name FROM site_setting where admin_id ='".$del_record_id."' ";              
					$query=mysql_query($sql_query);
					$fetch=mysql_fetch_array($query);
						
					"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
					$query=mysql_query($insert);       
														 
					$delete_query="delete from ".$GLOBALS["pre_db"]."site_setting where admin_id='".$del_record_id."'";
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
		$sql_query= "SELECT admin_id FROM ".$GLOBALS["pre_db"]."site_setting where admin_id='".$del_record_id."'";
		if(mysql_num_rows($db->query($sql_query)))
		{
			"<br>".$sql_query= "SELECT name FROM site_setting where admin_id ='".$del_record_id."' ";              
			$query=mysql_query($sql_query);
			$fetch=mysql_fetch_array($query);
				
			"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_user','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
			$query=mysql_query($insert);                        
			$delete_query="delete from ".$GLOBALS["pre_db"]."site_setting where admin_id='".$del_record_id."'";
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
                                    <td>
                                        <select name="user_type" id="user_type" class="input_select_login"  style="width:150px; ">
                                        <option value="">-User Type-</option>
                                        <?php 
                                        if($_SESSION['type']=='S' )
                                        {
                                            ?>
                                            <option value="S" <?php if($_REQUEST['user_type']=="S") echo 'selected="selected"'; ?>>Super admin</option>
                                            <?php 
                                        }?>
                                            <option value="A" <?php if($_REQUEST['user_type']=="A") echo 'selected="selected"'; ?>>Admin</option>
                                            <option value="Z" <?php if($_REQUEST['user_type']=="Z") echo 'selected="selected"'; ?>>Zonal Manager</option>
                                            <option value="LD" <?php if($_REQUEST['user_type']=="LD") echo 'selected="selected"'; ?>>Lead Distributor</option>
                                            <option value="F" <?php if($_REQUEST['user_type']=="F") echo 'selected="selected"'; ?>>Staff</option>
                                            <option value="C" <?php if($_REQUEST['user_type']=="C") echo 'selected="selected"'; ?>>Councellor</option>
                                            <option value="B" <?php if($_REQUEST['user_type']=="B") echo 'selected="selected"'; ?>>BOP</option>
                                            <option value="ST" <?php if($_REQUEST['user_type']=="ST") echo 'selected="selected"'; ?>>Stockiest</option>
                                            <option value="AC" <?php if($_REQUEST['user_type']=="AC") echo 'selected="selected"'; ?>>Accountant</option>
                                            <option value="Q" <?php if($_REQUEST['user_type']=="Q") echo 'selected="selected"'; ?>>Quality</option>
                                            <option value="PK" <?php if($_REQUEST['user_type']=="PK") echo 'selected="selected"'; ?>>Packing</option>
                                            <option value="DL" <?php if($_REQUEST['user_type']=="DL") echo 'selected="selected"'; ?>>Delivery</option>
                                            <option value="DP" <?php if($_REQUEST['user_type']=="DP") echo 'selected="selected"'; ?>>Dispatch</option>
                                         </select>
                                    </td>
                                    <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
                                    {
                                    	?>
                                    	<td>
                                        	<select name="branch_name" id="branch_name" class="input_select_login"  style="width: 150px; ">
                                            	<option value="">-Branch Name-</option>
                                            	<?php 
                                                $sel_branch="select branch_id,branch_name from branch";
                                                $ptr_sel=mysql_query($sel_branch);
                                                while($data_branch=mysql_fetch_array($ptr_sel))
                                                {
                                                    $sel='';
                                                    if($_REQUEST['branch_name']==$data_branch['branch_name'])
                                                    {
                                                        $sel='selected="selected"';
                                                    }
                                                    echo '<option value="'.$data_branch['branch_name'].'" '.$sel.' > '.$data_branch['branch_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <? } ?>                
                                      <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                      <td width="20%"></td>                
                                    <td class="rightAlign" > 
                                        <table border="0" cellspacing="0" cellpadding="0" align="right">
                                  <tr>
                                  <td></td>
                                  <td class="width5"></td>
                                  <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                    <td class="width2"></td>
                                    <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade" /></td>
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
	                        $pre_keyword=" and (name like '%".$keyword."%' or  username like '%".$keyword."%' or  email like '%".$keyword."%' )";
                        }                            
                        else
                        {
							$pre_keyword="";
						}                      
                        if($_REQUEST['user_type'])
                             $course_keyword="  and type ='".$_REQUEST['user_type']."'";
                        else 
 	                       $course_keyword="";
						 if($_REQUEST['branch_name'])
	                        $branch_keyword="  and branch_name ='".$_REQUEST['branch_name']."'";
                        else 
	                        $branch_keyword="";
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
                        $sql_query= "SELECT * FROM site_setting where 1 ".$record_cat_id." ".$type." ".$pre_keyword." ".$course_keyword." ".$branch_keyword." ".$select_directory.""; 
						//".$_SESSION['where_admin_id-cm_id']."
                       	//echo $sql_query;
                        $no_of_records=mysql_num_rows($db->query($sql_query));
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&user_type='.$_REQUEST['user_type'].'&branch_name='.$_REQUEST['branch_name'];
                            $query_string1=$query_string.$date_query;
                            // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
    <input type="hidden" name="formAction" id="formAction" value=""/>
	<tr class="grey_td" >
<?php if($_SESSION['type']=='S' || $edit_access=='yes' )
{
?>
	<td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
	<?php } ?>
    <td width="4%" align="center"><strong>Sr. No.</strong></td>
    <td width="12%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Staff Name</strong></a> <?php echo $img1;?></td>
    <td width="10%"><strong>AttendenceId</strong></td>
    <td width="10%"><strong>Contact NO</strong></td>
    <td width="9%"><strong>User type</strong></td>
    <td width="7%"><strong>Branch</strong></td>
    <td width="7%"><strong>Address</strong></td>
    <td width="9%"><strong>Email</strong></td>
    <!--<td width="8%"><strong>Basic Sallery</strong></td>
    <td width="8%"><strong>Total Sallery</strong></td>-->
    <td width="9%"><strong>User Name</strong></td>
    <td width="9%"><strong>Password</strong></td>
	<td width="9%"><strong>Status</strong></td>
    <td width="9%"><strong>System Status</strong></td>
	<?php if($_SESSION['type']=='S' || $edit_access=='yes')
	{
		?>
		<td width="9%"><strong>Settings</strong></td>
		<td width="7%" class="centerAlign"><strong>Action</strong></td>
		<?php 
	} ?>
</tr>
                           <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                                      
								$listed_record_id=$val_query['admin_id']; 
								/* $select_category = "select * from courses where course_id = '".$val_query['course_id']."' ";                                           
                                $val_category = $db->fetch_array($db->query($select_category));*/                              
                                    /*$select_name = "select * from admin_previleges where staff_id = '".$staff_id."' ";                                           
                                    while($val_name = $db->fetch_array($db->query($select_name)))
									{
                                        $name .=$val_name['privilege_id'].', ';
                                    }                                    
                                     $names = rtrim($name, ", ");

                                */
                                include "include/paging_script.php";
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=='S' || $edit_access=='yes')
								{
									echo'<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';                                
								if($_SESSION['type']=='S' || $edit_access=='yes')
								{
									echo '<td ><a href="add_user_edit.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['name'].'</a></td>';
								}
								else
									echo '<td align="center">'.$val_query['name'].'</td>';
								echo '<td align="center">'.$val_query['attendence_id'].'</td>';
                                echo '<td align="center">'.$val_query['contact_phone'].'</td>';
								echo '<td align="center">'.$val_query['designation'].'</td>';
								echo '<td align="center">'.$val_query['branch_name'].'</td>';
                                echo '<td align="center">'.$val_query['contact_address'].'</td>';
                                echo '<td align="center">'.$val_query['email'].' <br/> '.$val_query['alternate_email'].'</td>';		
								/*$select_sallery="select basic_sallery, total_sal from sallery where admin_id='".$val_query['admin_id']."' ";
								$query_sallery=mysql_query($select_sallery);
								$fetch_sallery=mysql_fetch_array($query_sallery);
							    echo '<td >'.$fetch_sallery['basic_sallery'].'</td>'; 
								echo '<td >'.$fetch_sallery['total_sal'].'</td>'; */
                                echo '<td align="center">'.$val_query['username'].'</td>';
								echo '<td align="center">'.$val_query['pass'].'</td>';
								echo '<td align="center">';
								?>
                                	<select name="status" class="input_select" style="width:80px" onchange="user_status(this.value,<?php echo $listed_record_id; ?>)">
                                    	<option value="">Select</option>
                                        <option value="Active" <?php if($val_query['status'] =="Active") echo 'selected="selected"'; ?> >Active</option>
                                        <option value="Inactive" <?php if($val_query['status'] =="Inactive") echo 'selected="selected"'; ?>>Inactive</option>
                                    </select>
                                <?php
								echo '</td>';
								echo '<td align="center">';
								?>
                                	<select name="system_status" id="system_status" class="input_select" style="width:80px" onchange="sys_status(this.value,<?php echo $listed_record_id; ?>)">
                                    	<option value="">Select</option>
                                        <option value="Enabled" <?php if($val_query['system_status'] =="Enabled") echo 'selected="selected"'; ?> >Enabled</option>
                                        <option value="Disabled" <?php if($val_query['system_status'] =="Disabled") echo 'selected="selected"'; ?>>Disabled</option>
                                    </select>
                                <?php
								echo '</td>';
								if($_SESSION['type']=='S' || $edit_access=='yes')
								{
									echo '<td align="center">';
									$cookiess_name='isas_user_'.$val_query['username'];
									if($val_query['cookies']=="set" && $_COOKIE[$cookiess_name]==$val_query['username'])
									{
										?>
										<a onClick="set_cookiess('<?php echo $val_query['username'] ?>','<?php echo $listed_record_id ; ?>')" ><img src="images/set_cookies_fixed.jpg" height="50" width="50" title="Edit Record" class="example-fade"/></a>
										<?php
									}
									else
									{
										?>
										<a onClick="set_cookiess('<?php echo $val_query['username'] ?>','<?php echo $listed_record_id ; ?>')" ><img src="images/set_cookies.jpg" height="50" width="50" title="Edit Record" class="example-fade"/></a>
										<?php
									}
									//echo '<td >';
									
									echo '<td align="center"><a href="add_user_edit.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;

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


<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='336'";
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
<title>Agent Type</title>
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
	<script type="text/javascript">
    var pageName='';
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear',dateFormat: 'dd/mm/yy'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
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
                        $sql_query= "SELECT expense_category_id FROM ".$GLOBALS["pre_db"]."expense_category where expense_category_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('expence_type','Delete','expense','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert); 
				
							$delete_query="delete from ".$GLOBALS["pre_db"]."expense_type where category_id='".$del_record_id."'";
							$db->query($delete_query);
							
							$delete_query="delete from ".$GLOBALS["pre_db"]."expense_category where expense_category_id='".$del_record_id."'";
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
			 disp_error +='Select Expense Category\n';
			 document.getElementById('expense_category').style.border = '1px solid #f00';
			 frm.expense_category.focus();
			 error='yes';
	     }
		 if(frm.sub_name1.value=='')
		 {
			 disp_error +='Enter Expense Type\n';
			 document.getElementById('sub_name1').style.border = '1px solid #f00';
			 frm.sub_name1.focus();
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
                      
	<?php
    $record_cat_id='';
    if($_GET['record_id'] !='')
    {
        $record_cat_id="and agent_id='".$_GET['record_id']."' ";
        
    }
    $pre_keyword='';
    $pre_keyword_cat='';
    if($_REQUEST['keyword']!="Keyword")
    $keyword=trim($_REQUEST['keyword']);
    if($keyword)
    {
        $pre_keyword =" and ( agent_name like '%".$keyword."%')";
        $pre_keyword_cat =" and ( agent_name like '%".$keyword."%')";
    }
    $sql_records="select * from agent_type where 1 ".$record_cat_id." ".$pre_keyword_cat." ";
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
            <tr class="head_td">
                <td colspan="14">
                    <form method="get" name="search">
                        <table border="0" cellspacing="0" cellpadding="0" width="80%" align="center">
                            <tr>
                                <td class="width5"></td>
                                <td width="20%"></td>
                                
                                <td class="rightAlign" > 
                                <table border="0" cellspacing="0" cellpadding="0" align="right">
                                    <tr>
                                        <td></td>
                                        <td>Search by Category:  &nbsp;&nbsp;&nbsp;</td>
                                        <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                                        <td class="width2"></td>
                                        <td><input type="submit" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
                                    </tr>
                                </table>	
                                </td>
                            </tr>
                        </table>
                    </form>	
                </td>
            </tr>
            <tr><td valign="top" colspan="2">
               	<table align="center"  cellpadding="0" cellspacing="1"  class="table" style="width: 100%;margin:0px !important">
					<tr align="center" class="grey_td" >
                    	<td width="7%" class="tr-header"><strong>Sr.</strong></td>
                        <?php 
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
						{ 
							?>
                            <td width="12%" class="tr-header"><strong>Branch Name</strong></td>
							<?php 
						} ?>
                        <td width="11%" class="tr-header"><strong>Agent Name</strong></td>
						<?php 
						//if($_SESSION['type']=="S" )
						//{ 
							?>
                            <td width="12%" class="tr-header"><strong>Action</strong></td>
							<?php 
						//} ?>
                   	</tr><?php
					while($val_record=mysql_fetch_array($all_records))
					{
						if($bgColorCounter%2==0)
							$bgcolor='class="grey_td"';
						else
							$bgcolor=""; 
						$payment_mode_id=$val_record['expense_type_id'];
						$paid_totas=0;
						echo $listed_record_id=$val_record['expense_type_id'];
						include "include/paging_script.php";
						echo '<tr class="'.$bgclass.'">';
						echo '<td align="center">'.$sr_no.'</td>';
						
						$sel_br="select branch_name from site_setting where cm_id='".$val_record['cm_id']."'";
						$ptr_br=mysql_query($sel_br);
						$data_br=mysql_fetch_array($ptr_br);
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
						{
							echo "<td align='center'>".$data_br['branch_name']."</td>";
						}
						echo "<td align='center'>".$val_record['agent_name']."</td>";
						
						//if($_SESSION['type']=="S")
						//{
						echo '<td align="center">';
						if($listed_record_id !="1" )
						{
						echo '<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord='.$val_record['agent_id'].'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;<a href="agent_type.php?record_id='.$listed_record_id.'&cat_id='.$val_record['agent_id'].'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
						}
						echo '</td>';
						//}
						echo '</tr>';
					   $bgColorCounter++;
					}
					?>
        		</table>
        	</td>
        </tr>
        <tr>
        	<td height="10"></td>
        </tr>
        <tr>
        	<td valign="middle" align="right">
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
            </td>
        </tr>
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
    $branch_name=$_POST['branch_name'];
	$agent_name=$_POST['agent_name'];
    if($_POST['agent_name'] =="")
    {
            $success=0;
            $errors[$i++]="Enter agent name";
    }
    
    $select_kit="select agent_id from agent_type where agent_name like '%".$_POST['agent_name'] ."%' ";
    $ptr_sel_kit=mysql_query($select_kit);
    if(mysql_num_rows($ptr_sel_kit))
    {
        $success=0;
        $errors[$i++]="Agent Name Is Already Exist";
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
        $data_record['agent_name'] = $agent_name;
        $data_record['added_date'] = date('Y-m-d H:i:s');
        
        //===============================CM ID for Super Admin===============
		if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
		{
			$sel_branch="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
			$ptr_branch=mysql_query($sel_branch);
			$data_branch=mysql_fetch_array($ptr_branch);
			$cm_id=$data_branch['cm_id'];
			$data_record_type1['cm_id'] =$cm_id;
		}	
		else
		{
			$branch_name1=$_SESSION['branch_name'];
			$cm_id=$_SESSION['cm_id'];
			$data_record_type1['cm_id'] =$cm_id;
		}
    	//====================================================================
    
		if($data_record['agent_name'] !='')
		{
			$select_agent="select agent_id from agent_type where agent_name like '%".$agent_name."%' ";
			$ptr_agent=mysql_query($select_agent);
			if(!mysql_num_rows($ptr_agent))
			{
				$insert_agent= "insert into agent_type (`agent_name`,`added_date`,`cm_id`) values('".$data_record['agent_name']."','".date('Y-m-d H:i:s')."','".$cm_id."')";
				$ptr_insert_preilgef = mysql_query($insert_agent);
				$ag_id=mysql_insert_id();
			}
			$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('agent_type','Add','agent_type','".$ag_id."','".date('Y-m-d')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
	$query=mysql_query($insert);    
					
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
			setTimeout('document.location.href="agent_type.php";',1000);
			</script>
			<?php
		}
	}
}

if($success==0)
{
	?>
	<form method="post" name="frmTakeAction">
		<table width="98%" align="center"  cellpadding="3" cellspacing="3" style="width:90%; border:1px solid #CCC">
			<?php
            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
            {
            ?>
                <tr>
                    <td align="center">Select Branch</td>
                    <td>
                    <?php
                    $sel_cm_id="select branch_name from site_setting where cm_id=".$row['cm_id']." ";
                    $ptr_query=mysql_query($sel_cm_id);
                    $data_branch_nmae=mysql_fetch_array($ptr_query);
                    $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                    $query_branch = mysql_query($sel_branch);
                    $total_Branch = mysql_num_rows($query_branch);
                    echo '<table width="100%"><tr><td>';
                    echo '<select id="branch_name" name="branch_name" onchange="show_bank(this.value)">';
                    while($row_branch = mysql_fetch_array($query_branch))
                    {
                        ?>
                        <option value="<?php if ($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name'];?>"  <?php if($row_branch['branch_name']==$data_branch_nmae['branch_name']) echo 'selected="selected"' ?> /><?php echo $row_branch['branch_name']; ?> 
                        </option>
                        <?php
                    }
					echo '</select>';
					echo "</td></tr></table>";
                    ?>
                    </td>
                </tr>
                <?php 
            }
            else 
            {
                ?>
                <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>" /> 
                <?php 
            }?>
            <tr>
                <td width="15%" class="tr-header" align="center">Enter Agent Name</td>
                <td width="25%">
                <input type="text" name="agent_name" id="agent_name" class="input_text" >
               </td>
            </tr>
            <tr>
                <td align="center" colspan="2"><input type="submit" name="save_changes" onclick="return validme();" value="Save"  /></td>
            </tr>
		</table>
		</form>
		<?php 
	}?>
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
<div class="clearit"></div><noscript>Warning! JavaScript must be enabled for proper operation of the Administrator backend.</noscript>
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
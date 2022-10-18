<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php
if($_REQUEST['record_id'])
{
	$record_id=$_REQUEST['record_id'];
}
else
$record_id='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Enroll Student</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."enrollment where enroll_id ='".$del_record_id."'";
								$my_query=mysql_query($sql_query);
								
                                if(mysql_num_rows($my_query))
                                    {       
										$data_delete=mysql_fetch_array($my_query);         
										
										"<br>".$sql_query= "SELECT name FROM enrollment where enroll_id ='".$del_record_id."' ";              
										$query=mysql_query($sql_query);
										$fetch=mysql_fetch_array($query);
										
										"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_enroll_student','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
										$query=mysql_query($insert); 
										                             
                                        $delete_query="delete from ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
                                        $db->query($delete_query);      
										
										$delete_query_invoice="delete from ".$GLOBALS["pre_db"]."invoice where enroll_id='".$del_record_id."'";
                                        $db->query($delete_query_invoice);
										
										$delete_query_inst="delete from ".$GLOBALS["pre_db"]."installment where enroll_id='".$del_record_id."'";
                                        $db->query($delete_query_inst);    
										
										$delete_query_inst_his="delete from ".$GLOBALS["pre_db"]."installment_history where enroll_id='".$del_record_id."'";
                                        $db->query($delete_query_inst_his);  
										
                                    }
                             }
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
$sep_url_string="?".$sep_url[1];
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
										setTimeout('document.location.href="manage_enroll.php<?php echo $sep_url_string; ?>";',1000);
                                    </script>
                            <?php                            
                                }                       
                     }
					 
					 


                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT enroll_id FROM ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {       
						
							"<br>".$sql_query= "SELECT name FROM enrollment where enroll_id ='".$del_record_id."' ";              
							$query=mysql_query($sql_query);
							$fetch=mysql_fetch_array($query);
							
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_enroll_student','Delete','".$fetch['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert); 
											
							$delete_query="delete from ".$GLOBALS["pre_db"]."enrollment where enroll_id='".$del_record_id."'";
							$db->query($delete_query);
							
							$delete_query_invoice="delete from ".$GLOBALS["pre_db"]."invoice where enroll_id='".$del_record_id."'";
							$db->query($delete_query_invoice);
							
							$delete_query_inst="delete from ".$GLOBALS["pre_db"]."installment where enroll_id='".$del_record_id."'";
							$db->query($delete_query_inst);    
							
							$delete_query_inst_his="delete from ".$GLOBALS["pre_db"]."installment_history where enroll_id='".$del_record_id."'";
							$db->query($delete_query_inst_his);  
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
								setTimeout('document.location.href="manage_enroll.php<?php echo $sep_url_string; ?>";',1000);
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
                        </select></td>
                <td class="rightAlign" > 
                    <table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <!--<td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>-->
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
                            {                            
                                $pre_keyword =" and (name like '%".$keyword."%' || username like '%".$keyword."%' || qualification like '%".$keyword."%')";
                            }                            
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

                        if($_GET['orderby']=='name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by enroll_id desc';                      
                           $sql_query= "SELECT * FROM enrollment where 1 and ref_id='".$record_id."' or enroll_id='".$record_id."' ".$_SESSION['where']." ".$pre_keyword." ".$select_directory.""; 
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
                                 <?php
								   $sql_query= "SELECT name,contact,mail,cm_id FROM enrollment where 1 and ref_id='".$record_id."' or enroll_id='".$record_id."' ".$_SESSION['where']." ";
								   $ptr_name=mysql_query($sql_query); 
								   $data_info=mysql_fetch_array($ptr_name);
								   
								    $sel_branch="select branch_name from site_setting where cm_id='".$data_info['cm_id']."' and type='A'";
									$ptr_branch=mysql_query($sel_branch);
									$data_branch=mysql_fetch_array($ptr_branch);
									
								 ?>
                                 <tr>
                                 <td colspan="16" style="font-size:14px"><strong>Name : </strong> <?php echo $data_info['name']; ?><br />
                                 <strong>Contact  : </strong> <img src="images/mobile-phone-8-16.ico"><?php echo $data_info['contact']; ?><br />
                                 <strong>Email : </strong> <img src="images/mail.png"><?php echo $data_info['mail']; ?><br />
                                 <?php if($_SESSION['type']=='S')
								  {?>
                                 <strong>Branch : </strong> <?php echo $data_branch['branch_name']; ?>
                                 <?php }?>
                                 </td>
                                 </tr>
  <tr class="grey_td" >
    <td width="3%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
    <td width="4%" align="center"><strong>Sr. No.</strong></td>
   <!-- <td width="15%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Name</strong></a> <?php echo $img1;?></td>-->
    <?
    if($_SESSION['type']=='S')
	{ ?>
    <!--<td width="5%" align="center"><strong>Branch name </strong></td>-->
    <? }?>
    <td width="9%" align="center"><strong>Course Name</strong></td>
     <td width="5%" align="center"><strong>Login </strong></td>
    <td width="7%" align="center"><strong>Down Fee</strong></td>
    <td width="5%" align="center"><strong>Balance Fee</strong></td>
    <td width="15%" align="center"><strong>Installments</strong></td>
    <td width="6%" align="center"><strong>Kit</strong></td>
    <!--<td width="15%" align="center"><strong>Kit</strong></td>-->
     <?
   // if($_SESSION['type']=='S' || $_SESSION['type']=='A' || $_SESSION['type']=='F')
	//{ ?>
    <td width="6%" align="center"><strong>View Logsheet</strong></td>
    <? //}?>
    <td width="6%" align="center"><strong>View Payment</strong></td>
   
    <td width="6%" align="center"><strong>Add New Course</strong></td>
  
    <td width="6%" align="center"><strong>Action</strong></td>
    
	<td width="6%" align="center"><strong>Installment Followup</strong></td>
    
    <td width="6%" align="center"><strong>Date</strong></td>
     <?php
    if($_SESSION['type'] =='S' )//|| $_SESSION['name']=="isasfinance"
	{	
   ?>
    <td width="4%" align="center" class="centerAlign"><strong>Action</strong></td>
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
									$listed_invoce_id=$val_query['invoice_no'];               
                                $listed_record_id=$val_query['enroll_id']; 
                                $select_course = "select * from courses where course_id = '".$val_query['course_id']."'  ";
                                $val_course= $db->fetch_array($db->query($select_course));
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >
                                      <td align="center">';
									  if($val_query['ref_id'] ==0)
										{
									   	
										}
										else
										{
											echo'<input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'">';
										}
									  echo'</td>';
                                echo '<td align="center">'.$sr_no.'</td>';                                
                               /* echo '<td ><a href="enroll.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['name'].'<br /> <img src="images/mobile-phone-8-16.ico">'.$val_query['contact'].' <br /> <img src="images/mail.png">'.$val_query['mail'].'</a></td>';*/
								/*if($_SESSION['type']=='S')
								  {
									  $sel_branch="select branch_name from site_setting where cm_id='".$val_query['cm_id']."' and type='A'";
									  $ptr_branch=mysql_query($sel_branch);
									  $data_branch=mysql_fetch_array($ptr_branch);
									   echo '<td >'.$data_branch['branch_name'].'</td>';
								  }*/
								
                                echo '<td ><b>'.$val_course['course_name'].'</b><br><img src="images/indian-rupee-16.ico">'.$val_query['net_fees'].'/-(With Tax)</td>';
								echo '<td ><img src="images/username.png" title="username">'.$val_query['username'].'<br /><img src="images/key.png" title="password">'.$val_query['pass'].'</td>';
								$disco ='';
								if(trim($val_query[discount]) !='0')
								$disco= '<br /> Discount: '.$val_query[discount];
								echo '<td >'.$val_query['down_payment'].$disco.'</td>';
								echo '<td >'.$val_query['balance_amt'].'</td>';
								
								$select_installments = " SELECT * FROM `installment` where enroll_id ='$listed_record_id' and course_id='".$val_query['course_id']."'  ";
								$ptr_installment = mysql_query($select_installments);
								if(mysql_num_rows($ptr_installment))
								{
									echo '<td >';
									while($data_installment = mysql_fetch_array($ptr_installment))
									{
										$col_paid ='<font color="#006600">';
										if($data_installment[status] =='not paid')
										$col_paid ='<font color="#FF3333">';
									 echo $data_installment[installment_amount].'/- '.$data_installment[installment_date].' : '.$col_paid.$data_installment[status]."</font><br>";	
									}
									echo '</td>';
								}
								else
								{
									echo '<td align="center">--</td>';
								}
								
								$sql_invoice="select invoice_id from invoice where enroll_id='".$val_query['enroll_id']."' and course_id='".$val_query['course_id']."' and installment_id='0' order by invoice_id desc ";
								$my_query_invoice=mysql_query($sql_invoice);
								$row_invoice= mysql_fetch_array($my_query_invoice);
									
								echo '<td><center><a href="add_student_kit.php?record_id='.$listed_record_id.'">
						<img src="images/items.jpg" border="0" title="View Logsheet" height="30px" width="30px"></a></center></td>';
								
								/*echo '<td><center><a href="add_student_kit.php?record_id='.$listed_record_id.'">
						<img src="images/items.jpg" border="0" title="View Logsheet" height="30px" width="30px"></a></center></td>';*/
								//if($_SESSION['type']=='S')
								//{ 
								echo '<td><center><a href="view-logsheet.php?record_id='.$listed_record_id.'">
						<img src="images/logsheet.png" border="0" title="View Logsheet" height="30px" width="30px"></a></center></td>';
								 //}
								echo '<td><center><a href="invoice-summary.php?record_id='.$listed_record_id.'">
						<img src="images/view_bill.jpg" border="0" width="30px" height="30px" title="View Payment"></a></center></td>';
						if($val_query['ref_id'] ==0)
						{
							echo '<td><center><a href="add_new_course.php?record_id='.$listed_record_id.'">
							<img src="images/course.png" border="0" width="30px" height="30px" title="Add New Course"></a></center></td>';
						}
						else
						{
							echo '<td><center><img src="images/fireeagle_location.png" border="0" width="30px" height="30px" title="New Course added"></center></td>';
						}
  
						echo '<td><center><a href="action.php?record_id='.$listed_record_id.'">
						<img src="images/action.jpg" border="0" width="30px" height="30px" title="View Payment"></a></center></td>';
						
						echo '<td><center><a href="installment_followup_details.php?record_id='.$listed_record_id.'">
						<img src="images/followup.png" border="0" width="30px" height="30px" title="Installment Followup"></a></center></td>';
						
						echo '<td >'.$val_query['added_date'].'</td>';
						if($_SESSION['type'] =='S' )//|| $_SESSION['name']=="isasfinance"
						{
							if($val_query['service_tax'] >0)
							{
							echo '<td align="center"><a href="enroll.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
							}
							else if($val_query['cgst_tax'] >0)
							{
								echo '<td align="center"><a href="enroll_gst.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;';
							}
							if($val_query['service_tax'] >0)
							{
								echo '<a href="" onClick="window.open(\'invoice-generate.php?record_id='.$row_invoice['invoice_id'].'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/invoice.png" title="View Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
							}
							else if($val_query['cgst_tax'] >0)
							{
								echo '<a href="" onClick="window.open(\'invoice-generate_gst.php?record_id='.$row_invoice['invoice_id'].'\', \'win1\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=900,height=600,directories=no,location=no\'); return false;" ><img src="images/gst1.png" width="21" height="21" title="View GST Invoice" class="example-fade"/></a>&nbsp;&nbsp;';
							}	
							
									   
							if($val_query['ref_id'] ==0)
							{
							}
							else
							{
								echo '&nbsp;&nbsp;<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
							}

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
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Student found related to your search criteria, please try again</div><br></td></tr>';?>
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

<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Services Inquiry</title>
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
    
    <script>
	function service_status(values,ids)
	{
		var data1="status="+values+"&customer_id="+ids;	
		//alert(data1);
			$.ajax({
				url: "get_status.php", type: "post", data: data1, cache: false,
				success: function (html)
				{
					if(html=="success")
					{
						alert("Status changed successfully");
					}
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT inquiry_id,name FROM service_inquiry where inquiry_id ='".$del_record_id."'";
								$ptr_query=mysql_query($sql_query);
                                if(mysql_num_rows($ptr_query))
								{    
									$cust_data=mysql_fetch_array($ptr_query);
									
									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('manage_service_inquiry','Delete','".$cust_data['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);
									                                            
									$delete_query="delete from service_inquiry where inquiry_id='".$del_record_id."'";
									$db->query($delete_query);  
									
									$delete_query="delete from service_followup_details where inquiry_id='".$del_record_id."'";
									$db->query($delete_query);  

									$delete_query1="delete from service_inquiry_map where inquiry_id='".$del_record_id."'";
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
											setTimeout('document.location.href="manage_service_inquiry.php";',1000);
                                    </script>
									
                            <?php                            
                                }
                     }
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT inquiry_id,name FROM service_inquiry where inquiry_id ='".$del_record_id."'";
                        $ptr_query=mysql_query($sql_query);
						if(mysql_num_rows($ptr_query))
						{                            
							$cust_data=mysql_fetch_array($ptr_query);
							
							"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('service_inquiry','Delete','".$cust_data['name']."','".$del_record_id."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
							$query=mysql_query($insert); 
							
							$delete_query="delete from service_inquiry where inquiry_id='".$del_record_id."'";
							$db->query($delete_query);  
							
							$delete_query="delete from service_followup_details where inquiry_id='".$del_record_id."'";
							$db->query($delete_query);  

							$delete_query1="delete from service_inquiry_map where inquiry_id='".$del_record_id."'";
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
									 setTimeout('document.location.href="manage_service_inquiry.php";',1000);
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
<!--                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>-->
                </select></td>
				<?php if($_SESSION['type']=='S')
				{
				?>
                 <td width="15%">
                    <select name="branch_name" id="branch_name" class="input_select_login"  style="width: 150px; ">
                                <option value="">-Branch Name-</option>
                                <?php 
									$sel_branch="select branch_id,branch_name from branch";
									$ptr_sel=mysql_query($sel_branch);
									while($data_branch=mysql_fetch_array($ptr_sel))
									{
										$sel='';
										if($_REQUEST['branch_name'] == $data_branch['branch_name'])
										{
											$sel='selected="selected"';
										}
										echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
									}
								?>
                        </select>
                </td>
				<td> <a href="service_followup_summery.php<?php echo $sep_url_string; ?>"><strong>Followup Summery</strong></a></td>
				<td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                <? } ?>
				
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
						else
							$keyword='';
                        if($keyword)
                            $pre_keyword=" and (name like '%".$keyword."%' || mobile like '%".$keyword."%' || service_price like '%".$keyword."%' || status like '%".$keyword."%')";
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
						
						if($_REQUEST['branch_name'])
						{
							$sel_branch="select cm_id from site_setting where branch_name='".$_REQUEST['branch_name']."' and type='A'";
							$ptr_branch=mysql_query($sel_branch);
							$data_branch=mysql_fetch_array($ptr_branch);
							$cm_id=$data_branch['cm_id'];
							
							$branch_keyword="  and cm_id ='".$cm_id."'";
							$branch_keyword_p="and i.cm_id ='".$cm_id."'";
						}
						else {
							$branch_keyword="";
							$branch_keyword_p="";
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

                        if($_GET['orderby']=='service_name' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='name'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by inquiry_id desc';  
						$record_cat_id='';
						$record_cat_idss='';
						if($_GET['record_id'] !='')
						{
							$record_cat_id="and inquiry_id='".$_GET['record_id']."' ";
							$record_cat_idss="and i.inquiry_id='".$_GET['record_id']."' ";
							
						}	
						$cmids="";
						if($_SESSION['where']!='')
						{
							$cmids=" and i.cm_id='".$_SESSION['cm_id']."'";
						}
						
						if($pre_keyword=='')
						{                     
							$sql_query= "SELECT * FROM service_inquiry where 1 ".$record_cat_id." ".$_SESSION['where']." ".$branch_keyword." ".$pre_keyword." ".$select_directory.""; 
						}
						else
						{
							$sql_query= "SELECT distinct(i.inquiry_id) as inquiry_id FROM service_inquiry i, servies s, service_inquiry_map sim where 1  and (i.service_price like '%".$keyword."%' or i.total_cost like '%".$keyword."%' or i.name like '%".$keyword."%' or i.mobile1 like '%".$keyword."%' or s.service_name like '%".$keyword."%' or sim.service_price like '%".$keyword."%') and i.inquiry_id=sim.inquiry_id  and sim.service_id=s.service_id ".$cmids." ".$branch_keyword_p." ".$record_cat_idss." order by i.inquiry_id desc"; 
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
    <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
					  <?php
					  if($_SESSION['type']=="S")
					  {
					  ?>
                        <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
						<?php
					  } ?>
                        <td width="5%" align="center"><strong>Sr. No.</strong></td>
						<?php
						if($_SESSION['type']=="S")
						{?>
							<td width="10%" align="center"><strong>Branch</strong></td>
						<?php
						}
						?>
                        <td width="10%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=service_name".$query_string;?>" class="table_font"><strong>Customer Name</strong></a> <?php echo $img1;?></td>
                        <td width="10%" align="center"><strong>Services</strong></td>
                        <td width="10%" align="center"><strong>Total Cost</strong></td>
                        <td width="12%" align="center"><strong>Enquiry Added By</strong></td>
						<td width="12%" align="center"><strong>Enquiry Assigned To</strong></td>
						<td width="8%" align="center"><strong>Enquiry Source</strong></td>
						<td width="8%" align="center"><strong>Respose Category</strong></td>
                        <td width="10%" align="center"><strong>Status</strong></td>
						<td width="7%" align="center"><strong>Followup</strong></td>
						<td width="8%" align="center"><strong>Enrollment</strong></td>
                        <td width="10%" align="center"><strong>Added Date</strong></td>
                        <td width="10%" class="centerAlign"><strong>Action</strong></td>
                    </tr>
                            <?php
                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['inquiry_id']; 
                                $position=120; // Define how many character you want to display.                                
                                $post = substr(strip_tags($val_query['remark']), 0, $position);
                                include "include/paging_script.php";
                                echo '<tr '.$bgcolor.' >';
								if($_SESSION['type']=="S")
								{
                                      echo '<td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
								}
                                echo '<td align="center">'.$sr_no.'</td>';  
								if($_SESSION['type']=="S")
								{
									$sql_branch = "  select branch_name, cm_id from site_setting where cm_id='".$val_query['cm_id']."' ";
									$ptr_branch = mysql_query($sql_branch);
									$data_branch = mysql_fetch_array($ptr_branch);
									echo '<td align="center">'.$data_branch['branch_name'].'</td>';
								}
								echo '<td ><a href="service_inquiry.php?record_id='.$listed_record_id.'">'.$val_query['name'].'<br>'.$val_query['mobile'].'</a></td>';
								
								echo '<td align="center">';
								$sel_cust_services="select inquiry_id,service_id from service_inquiry_map where inquiry_id ='".$val_query['inquiry_id']."'";
								$ptr_sel_service=mysql_query($sel_cust_services);
								while($data_service=mysql_fetch_array($ptr_sel_service))
								{
									$select_service_name="select service_name,service_price from servies where service_id='".$data_service['service_id']."'";
									$ptr_service=mysql_query($select_service_name);
									$data_service_name=mysql_fetch_array($ptr_service);
									echo $data_service_name['service_name']."(Price - ".$data_service_name['service_price'].")<br />";
								}
								echo '</td>';
                                echo '<td align="center">'.$val_query['total_cost'].'</td>';
								
								"<br />".$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_names=mysql_fetch_array($ptr_name);
								
								"<br />".$sel_name="select name from site_setting where admin_id='".$val_query['staff_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_assign_by=mysql_fetch_array($ptr_name);
								
								echo '<td align="center">'.$data_names['name'].'</td>';
								echo '<td align="center">'.$data_assign_by['name'].'</td>';
								
								$enq_src="select source_name from source where source_id='".$val_query['enquiry_src']."'";
								$ptr_enq_src=mysql_query($enq_src);
								$data_enq_src=mysql_fetch_array($ptr_enq_src);
								
								echo '<td align="center">'.$data_enq_src['source_name'].'</td>';
								$response='';
								if($val_query['response'] == "1")
								{
									$response="Walk in";
								}
								else if($val_query['response'] == "2")
								{
									$response="Will walk in";
								}
								else if($val_query['response'] == "3")
								{
									$response="Call Back Later";
								}
								else if($val_query['response'] == "4")
								{
									$response="Call did not pick up";
								}
								else if($val_query['response'] == "5")
								{
									$response="Not reachable";
								}
								else if($val_query['response'] == "6")
								{
									$response="Call Taken";
								}
								echo '<td align="center">'.$response.'</td>';
								echo '<td align="center">'.$val_query['status'].'</td>';
								if($val_query['status']=='Enrolled')
								{
									echo '<td style="color:#FF0000" align="center"><img title="Followup Completed" src="images/enroll_cmpleted.png" height="30" width="30"></td>';
								}
								else
								echo '<td style="color:#FF0000" align="center"><a href="service_followup_details.php?record_id='.$listed_record_id.'" ><img title="Followup" src="images/followup.png" height="30" width="30"></a></td>';
								
								if($val_query['status']=='Enrolled')
								{
									echo '<td style="color:#FF0000" align="center"><img src="images/enroll_cmpleted.png" title="Enrollment Completed" height="30" width="30"></td>';
								}
								else
									echo '<td style="color:#FF0000" align="center"><a href="enquiry_book_service.php?record_id='.$listed_record_id.'" ><img src="images/enrolls.png" title="Enrollment" height="30" width="30"></a></td>';
								echo '<td align="center">'.$val_query['added_date'].'</td>';
                                echo '<td align="center">';
								if($_SESSION['type']=="S" || trim($val_query['status']) !="Completed")
								{
									echo '<a href="service_inquiry.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>';
								}
								if($_SESSION['type']=="S")
								{
									 echo'<a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';
								}
                                echo '</td>';
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }    
                                ?>
  
  
  <tr class="head_td">
    <td colspan="15">
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

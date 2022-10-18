<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Complaints</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="js/common.js"></script>
  <!--  <link href="css/style_gallaery.css" rel="stylesheet" type="text/css" />
    <link type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/colorbox/colorbox.css" type="text/css"/>
    <script type='text/javascript' src='js/jquery.tipsy.js'></script>
    <script src="js/colorbox/jquery.colorbox.js" type="text/javascript" charset="utf-8"></script>-->
  <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
			 $('.gallery').colorbox({width:700,height:500,href:function(){
                var url = $(this).attr('href');
                return url;
            }});
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
    <style>
	.counter{background: none repeat scroll 0 0 #9ECB4A; border: 1px solid #CCCCCC; border-radius: 3px 3px 3px 3px;  float: right;  height: 14px;  text-align: center; width: 16px;}
	</style>
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
    <td class="top_mid" valign="bottom"><?php include "include/complaint_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
  
  <?php 
  if($_REQUEST['changeStatus1'] && $_REQUEST['value'])
            {
                $update_query1="update student_complaint set other_status='".$_REQUEST['value']."' where id='".$_REQUEST['changeStatus1']."'";
               // echo $update_query1;
                $db->query($update_query1);
                ?>
                <div id="statusChangesDiv" title="Status Changed"><center><br/><p></p></center></div>
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
            }?>
            
    <?php if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT id FROM student_complaint where id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_record)))
                                    {                                                
                                        $delete_query="delete from student_complaint where id='".$del_record_id."'";
                                        $db->query($delete_query);                                                                                        
                                    }
                             }
                             ?>
                                    <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
                                    
                                    <?php
							}
						else if($_POST['formAction']=="Active")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $update_record_id=$_POST['chkRecords'][$r];
                                $update_record= "update student_complaint set status='Active' where id='".$update_record_id."'";
                                $db->query($update_record);
                            }
                            ?><div id="msgbox" style="width: 40%;">Selected records activated successfully</div><?php
                        }
                        else if($_POST['formAction']=="Inactive")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $update_record_id=$_POST['chkRecords'][$r];
                                $update_record= "update student_complaint set status='Inactive' where id='".$update_record_id."'";
                                $db->query($update_record);
                            }
                            ?><div id="msgbox" style="width: 40%;">Selected records deactivated successfully</div><?php
                        }
                       
                    }

                    if($_REQUEST['changeStatus'] && $_REQUEST['value'])
                    {
                        $update_query1="update student_complaint set status='".$_REQUEST['value']."' where id='".$_REQUEST['changeStatus']."'";
                        //echo $update_query1;
                        $db->query($update_query1);
                        ?>
                        <div id="statusChangesDiv" title="Status Changed"><center><br/><p>Status changed successfully</p></center></div>
                        
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
                     
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT id FROM student_complaint where id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                        $delete_query="delete from student_complaint where id='".$del_record_id."'";
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
    <td colspan="12">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                        </select></td>
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
	

			  if($_POST['submit'])
			      {
				  $contact_for=$_POST['contact_for'];
				  $other_status=$_POST['other_status'];
			      $id=  $_POST['id'];
				  
				  	$_REQUEST['record_id'];
				  
				 $quert = "insert into student_complaint (`complaint_id`,`comment`,`reply_by`,`added_date`) values('".$contact_for."','Admin','".date('Y-m_d H:i:S')."')";
				 $inser_commnet = mysql_query($quert);
				 
				 $update_read_status = "update student_complaint set `other_status`='".$other_status."' where id='".$id."' and reply_by='User' ";
				 $query_update = mysql_query($update_read_status); 
				  }
			  ?>
    
    <?php
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                            {                            
                                $pre_keyword =" and (name like '%".$keyword."%' || email_id like '%".$keyword."%' || phone_no like '%".$keyword."%' )";
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
							
						
                            $select_directory='order by id desc';                      
                             $sql_query= "SELECT * FROM student_complaint where complaint_id='0'  ".$pre_keyword." ".$select_directory.""; 
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
    <td width="5%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
    <td width="5%" align="center"><strong>Sr. No.</strong></td>
    <td width="15%"><strong>Name</strong> </td>
     <td width="10%"><strong>Ticket No.</strong></td>
    <td width="10%"><strong>Contact No  </strong></td>
    <!--<td width="10%"><strong>Address </strong></td>-->
    <td width="20%"><strong>Email Id</strong></td>
    <td width="5%"><strong>Complaint</strong></td>
    
     <td width="10%"><strong>Date</strong></td>
     
      <!--<td width="10%" class="centerAlign"><strong>Image</strong></td>-->
      
      <td width="10%"><strong>Status</strong></td>
     <!-- <td width="20%" align="center"><strong>Other Status</strong></td>-->
    
    <td width="10%" class="centerAlign"><strong>Action</strong></td>
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['id']; 
//                                
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';                                
                                
								
								echo '<td >' .$val_query['name']. '</td>';
								echo '<td >' .$val_query['ticket_no']. '</td>';
                                echo '<td >'.$val_query['phone_no'].'</td>';
                                //echo '<td >'.$val_query['address'].'</td>';
								echo '<td >'.$val_query['email_id'].'</td>';
								
								 $select_counter = "SELECT * from student_complaint where complaint_id= ".$val_query['id']."";
								$counter_sel = mysql_query($select_counter);
								$count = mysql_num_rows($counter_sel);
								
								echo '<td align="center"><a href="complaint_details.php?id='.$val_query['id'].'" class="gallery ">'.strip_tags($val_query['contact_for']).'<div class="counter" style="width:100%;text-align:center">'.$count.'</div></a></td>';
								
								echo '<td >'.$val_query['added_date'].'</td>';
								
								
								/* echo '<td align="center">';
								 $photo='';
								
								 if(trim($val_query['image']) !='')
								 {
									 $photo = $val_query['image'];
								 echo '<img height="50px" width="50px" src="../form_images/'.$photo.'">';
								 }
								 else
								 {
								 $photo='';
								
								 }
								 echo'</td>'; */
								
								//echo '<td align="center"><img height="50px" width="50px" src="../form_images/'.$val_query['image'].'"></td>';
								
								/*echo '<td><select name="status" class="input_select_login" onchange="redirect1(\'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?changeStatus='.$listed_record_id.$query_string1.'&value=\',this.value)">';
								
					echo '<option value="0" selected="selected">-Status-</option>';
						if($val_query['status']=='Active')
							echo '<option value="Active" selected="selected">Active</option>';
						else
							echo '<option value="Active">Active</option>';
						if($val_query['status']=='Inactive')
							echo '<option value="Inactive" selected="selected">Inactive</option>';
						else
							echo '<option value="Inactive">Inactive</option>';
						
					echo '</select>';
					echo '</td>';*/
					
					
					/***********Other status*****************/
								
								echo '<td align="center"> <select class="input_select_login" name="other_status" onchange="redirect1(\'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?changeStatus1='.$listed_record_id.$query_string1.'&value=\',this.value)">';
                                echo '<option value="0">-Status-</option>';
                                    if($val_query['other_status']=='Open')
                                        echo '<option value="Open" selected="selected">Open</option>';
                                    else
                                        echo '<option value="Open">Open</option>';
                                    if($val_query['other_status']=='In Progress')
                                        echo '<option value="In Progress" selected="selected">In Progress</option>';
                                    else
                                        echo '<option value="In Progress">In Progress</option>';
                                    if($val_query['other_status']=='Close')
                                        echo '<option value="Close" selected="selected">Close</option>';
                                    else
                                        echo '<option value="Close">Close</option>';
                                echo '</select>';
                                echo '</td>';
								/****************************/
								
                                echo '<td align="center"> <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp; </td>';

                                echo '</td>';
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }  
							  
                                ?>
  
  
  <tr class="head_td">
    <td colspan="12">
       <table cellspacing="0" cellpadding="0" width="100%" >
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
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Enquiry found related to your search criteria, please try again</div><br></td></tr>';?>
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

<?php include "include/footer.php"; ?>

<!--footer end-->


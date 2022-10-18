<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Complaint Details</title>

<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<link type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>

    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
  
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
   <?php 
    $contact_query= "SELECT * FROM student_complaint where id='".$_GET['id']."'";
   $ptr_contact_query=mysql_query($contact_query);
   $contact_fetch=mysql_fetch_array($ptr_contact_query);
   echo '<p style=" font-size:15px; color:blue; ">'.$contact_fetch['comment'].'</p>';
	
	?>
        
<table cellspacing="0" cellpadding="0" class="table" width="100%">

    
 
 <?php 
	

			if($_POST['submit'])
			{
				$comment=$_POST['comment'];
				$other_status=$_POST['other_status'];
			    $id=  $_POST['id'];
				  
				//echo	$_REQUEST['id'];
				$sele_name="select name,email,contact_phone from site_setting where admin_id='".$_SESSION['admin_id']."'";
				$ptr_name=mysql_query($sele_name);
				$data_name=mysql_fetch_array($ptr_name);
				
				$quert = "insert into student_complaint (`name`,`email_id`,`phone_no`,`complaint_id`,`comment`,`reply_by`,`admin_id`,`added_date`) values('".$data_name['name']."','".$data_name['email']."','".$data_name['contact_phone']."','".$_REQUEST['id']."','".$comment."','Admin','".$_SESSION['admin_id']."','".date('Y-m-d')."')";
				$inser_commnet = mysql_query($quert);
				 
				// $update_read_status = "update student_complaint set `other_status`='".$other_status."' where id='".$id."' and reply_by='User' ";
				 //$query_update = mysql_query($update_read_status); 
				 
				 
				 
				 $sql_query_id= "SELECT * from student_complaint where id='".$_GET['id']."'";
				 $query_select_id = mysql_query($sql_query_id);
				 $records_id=mysql_fetch_array($query_select_id);
				 $email= $records_id['email_id'];
				  
				 
				  /*------------send a mail to admin about this---------------------*/
                $subject = "Reply from  ".$siteUrlName."";
                $message= '
                    <table cellpadding="3" align="left" cellspacing="3" width="75%">
                    <tr>
                    <td width="35%"><strong>Reply</strong></td>
                    <td>:</td>
                    <td width="65%">'.$comment.'</td>
                    </tr>';
					
				
                
                $message.= '
                    </table>';
                    $sendMessage=$box_message_top='<br>
        <table style=" color:#FFFFFF; width:100%; background-color:#1380DE;"><tr><td>
        <table align="center" width="100%" cellpadding="1" cellspacing="1">
        <tr><td style="color:#FFFFFF;padding-left:10px;	font-size:18px;	font-weight:600;padding-top:5px; padding-bottom:5px;">Lokkhitfoundationpune.com</td></tr>
        <tr><td style="color:#666; padding-left:30px; background-color:#FFFFFF;" align="left">';
                    
                    $sendMessage.=$box_message_bottom='</td></tr> </table></td></tr></table>';
					 $sendMessage.=$message;
                    $from_id='erp.isas@gmail.com';
                   $headers= 'MIME-Version: 1.0' . "\n";
                    $headers.='Content-type: text/html; charset=utf-8' . "\n";
                    $headers.='From:'.$from_id;
                   
					
					 mail('vyavaharekiran@gmail.com', $subject, $sendMessage, $headers);
					 
                    //$mailSent=sendAdminMail('sudhir.pawar@waakan.com',$subject,$message,"");
                /*-------------------------------------------------------------------------*/
				
                
				  }
			  ?>
 
 
     
     
    <?php
        $select_directory='  order by student_complaint.added_date asc';                      
		$sql_query= "SELECT * from student_complaint where id='".$_GET['id']."' or  complaint_id='".$_GET['id']."' ".$select_directory." "; 
		$query = mysql_query($sql_query);
		$no_of_records=mysql_num_rows($db->query($sql_query));
		if($no_of_records)
        {
		    $i=1;
			$bgColorCounter=1;
			$query_string='&keyword='.$keyword;
			$query_string1=$query_string;
			$pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
			$all_records= $pager->paginate();
			?>  
            <form method="post"  name="frmTakeAction" action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>" >
                                 <input type="hidden" name="formAction" id="formAction" value=""/>
  <tr class="grey_td" >
   
    <td width="5%" align="center"><strong>Sr. No.</strong></td>
    <td width="10%" align="center"><strong>admin photo</strong> </td>
    <td width="10%" align="center"><strong>Type</strong> </td>
    
    <td width="10%"><strong>Name</strong> </td>
    
    <td width="10%" align="center"><strong>Contact No  </strong></td>
      
    <td width="10%"><strong>Email Id</strong></td>
    <td width="15%"><strong>Comment</strong></td>
    
     <td width="10%" align="center"><strong>Date</strong></td>
     
      <!--<td width="10%" class="centerAlign"><strong>Image</strong></td>-->
      
      <td width="10%"><strong>Status</strong></td>
      
    
    
  </tr>
  
  <?php
  
	while($records=mysql_fetch_array($query))
		{
				if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor=""; 
				 $listed_record_id=$records['id']; 
				 include "include/paging_script.php";
				
				//$image='';
				$class='';
				$title='';
				if($records['reply_by']=='Admin')
				{
					$class='admin'; 
					//$image='admin_image.png';
					$title = 'Admin';
				}
				else
				{
					$class='dealar'; 
					//$image='dealar_image.png';
					$title = 'User';
				}
			$date_fort = strtotime($records['added_date']); 
			$new_date = date('d M Y',$date_fort);
				
			if($records['reply_by']=='Admin')
			{
				$sel_admin="select name, photo from site_setting where admin_id='".$records['admin_id']."'";
				$ptr_sel=mysql_query($sel_admin);
				$data_infos=mysql_fetch_array($ptr_sel);
				$photos='images/profile-pic.png';
				if($data_infos['photo'] !='')
				{
					$photos="staff_photo/".$data_infos['photo']."";
				}
				$type = 'Reply';
			}
			else
			{
				$type='Comment';
				$photos='images/profile-pic.png';
			}
 
			echo '<tr '.$bgcolor.' >';
			
            echo '<td align="center">'.$sr_no.'</td>'; 
			
			echo '<td align="center"><img src="'.$photos.'" height="40" width="40" title='.$title.' /></td>';
			
			echo '<td align="center">'.$type.'</td>';
								 
			echo '<td >' .$records['name']. '</td>';  
					
			echo '<td align="center">'.$records['phone_no'].'</td>';
			  
			echo '<td >'.$records['email_id'].'</td>';
			  
			echo '<td >'.$records['comment'].'</td>';
			  
			echo '<td align="center">'.$new_date.'</td>';

					
			/*echo '<td align="center">';
					 $photo='';
					
					 if(trim($records['image']) !='')
					 {
						 $photo = $records['image'];
					 echo '<img height="50px" width="50px" src="../form_images/'.$photo.'">';
					 }
					 else
					 {
					 $photo='';
					
					 }
			echo'</td>'; */
					
					
					echo '<td><select name="status" class="input_select_login" onchange="redirect1(\'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?changeStatus='.$listed_record_id.$query_string1.'&value=\',this.value)">';
								
					echo '<option value="0" selected="selected">-Status-</option>';
						if($records['status']=='Active')
							echo '<option value="Active" selected="selected">Active</option>';
						else
							echo '<option value="Active">Active</option>';
						if($records['status']=='Inactive')
							echo '<option value="Inactive" selected="selected">Inactive</option>';
						else
							echo '<option value="Inactive">Inactive</option>';
						
					echo '</select>';
					echo '</td>';
					
					?>
            <?php
			echo '</tr>';
			$i++;
			$bgColorCounter++;
			
			}
			?>
            
            
            </form>
            <style>
			.collapse {
    border-collapse: collapse;
}
			</style>
            
           <table align="center" width="50%" style="margin-top:30px" border="1" class="collapse">
            <tr>
              <td>
               <form method="post" id="jqueryForm">
                    <table>
                        <tr> <td>Enter Reply</td>
                        <td><textarea name="comment" cols="70" rows="2" id="comment" class="validate[required] input_textarea" ></textarea></td><td></td></tr>
                        <!-- <tr> <td>Status</td>
                        <td><select name="other_status" class="input_select">
						<?php 
							$sel_status = mysql_query("select other_status from student_complaint where id='".$_GET['id']."' order by added_date asc ");
						    $ststus_date = mysql_fetch_array($sel_status);
						 ?>
                                <option value="Open" <?php //if($ststus_date['other_status']=='Open') echo 'selected="selected"';?>>Open</option>
                                <option value="Progress" <?php //if($ststus_date['other_status']=='Progress') echo 'selected="selected"';?>>In Progress</option>	
                                <option value="Close" <?php //if($ststus_date['other_status']=='Close') echo 'selected="selected"';?>>Close</option>
                            </select></td><td></td></tr>-->
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                        <tr><td></td><td><input type="submit" name="submit" value="Comment" class="input_btn" /></td><td></td> </tr>
                    </table>
                </form>
              </td>
            </tr>
            </table>
           
            
           <?php
}
else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Enquiry found related to your search criteria, please try again</div><br></td></tr>';
?>

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
</body>
</html>

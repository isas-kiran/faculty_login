<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Pages</title>
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
    <td class="top_mid" valign="bottom"><?php include "include/photo_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
    <?php       if($_POST['formAction'])
                    {
                        if($_POST['formAction']=="delete")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $del_record_id=$_POST['chkRecords'][$r];
                                $sql_query= "SELECT  	gallery_id FROM ".$GLOBALS["pre_db"]."video  where  	gallery_id ='".$del_record_id."'";
                                if(mysql_num_rows($db->query($sql_query)))
                                    {                                                
                                        $delete_query="delete from ".$GLOBALS["pre_db"]."video  where gallery_id='".$del_record_id."'";
                                        $db->query($delete_query);                                                                                        
                                    }
							}
                             ?>
                             <div id="statusChangesDiv" title="Record Deleted"><center><br><p>Selected record(s) deleted successfully</p></center></div>
                              <?
							}
						else if($_POST['formAction']=="Active")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $update_record_id=$_POST['chkRecords'][$r];
                                $update_record= "update ".$GLOBALS["pre_db"]."video  set status='Active' where gallery_id='".$update_record_id."'";
                                $db->query($update_record);
                            }
                            ?><div id="msgbox" style="width: 40%;">Selected records activated successfully</div><?php
                        }
                        else if($_POST['formAction']=="Inactive")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $update_record_id=$_POST['chkRecords'][$r];
                                $update_record= "update ".$GLOBALS["pre_db"]."video  set status='Inactive' where gallery_id='".$update_record_id."'";
                                $db->query($update_record);
                            }
                            ?><div id="msgbox" style="width: 40%;">Selected records deactivated successfully</div><?php
                        }
                        else if($_POST['formAction']=="Banned")
                        {
                            for($r=0;$r<count($_POST['chkRecords']);$r++)
                            {
                                $update_record_id=$_POST['chkRecords'][$r];
                                $update_record= "update ".$GLOBALS["pre_db"]."video  set status='Banned' where gallery_id='".$update_record_id."'";
                                $db->query($update_record);
                            }
                            ?><div id="msgbox" style="width: 40%;">Selected records banned successfully</div><?php
                        }
                    }

                    if($_REQUEST['changeStatus'] && $_REQUEST['value'])
                    {
                        $update_query1="update ".$GLOBALS["pre_db"]."video  set status='".$_REQUEST['value']."' where gallery_id='".$_REQUEST['changeStatus']."'";
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
                                                            Ok: function() { $( this ).dialog( "close" ); }
                                                         }
                                                });
                                            });
                                    </script>
                            <?php                            
                                }
								
                     
                    if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
                    {
                        $del_record_id=$_REQUEST['record_id'];
                        $sql_query= "SELECT gallery_id FROM ".$GLOBALS["pre_db"]."video  where gallery_id='".$del_record_id."'";
                        if(mysql_num_rows($db->query($sql_query)))
                        {                           
                            $delete_query="delete from ".$GLOBALS["pre_db"]."video  where gallery_id='".$del_record_id."'";
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
        
<table cellspacing="0" cellpadding="0" class="table" width="99%">
    
    
  <tr class="head_td">
    <td colspan="8">
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
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                            $pre_keyword=" and (title like '%".$keyword."%' || event_date like '%".$keyword."%')";
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

                        if($_GET['orderby']=='title' )
                            $img1 = $img;
							if($_GET['orderby']=='event_date' )
                            $img2 = $img;
                        if($_GET['order'] !='' && ($_GET['orderby']=='title' || $_GET['orderby']=='event_date' ))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
                            $select_directory='order by gallery_id desc';                      
                            $sql_query= "SELECT * FROM video  where 1  ".$pre_keyword." ".$select_directory.""; 
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
                        <td width="7%" align="center"><input type="checkbox" name="chkAll" onClick="Javascript:checkAll('frmTakeAction','chkRecords')"/></td>
                        <td width="7%" align="center"><strong>Sr. No.</strong></td>
                        <td width="8%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=title".$query_string;?>" 
                        class="table_font"><strong>Title</strong></a> <?php echo $img1;?></td>
                     <td width="11%"> Discription</td>
                     <td width="9%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=date_saving".$query_string;?>" 
                     class="table_font"><strong>Event Dte</strong></a> <?php echo $img3;?></td>
                         <td width="15%"><strong>Total Images</strong></td>
                         <td width="18%"><strong>Added Date</strong></td>
                          <td width="11%"><strong>Status</strong></td>
                         <!--
                       <td width="15%"><strong>Tag</strong></td>
                        <td width="20%" class="centerAlign"><strong>Image</strong></td>-->
                        
                        <td width="14%" class="centerAlign"><strong>Action</strong></td>
                      </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['gallery_id']; 
                                
								 $sql_record1= "SELECT vdo_id FROM ".$GLOBALS["pre_db"]."gallery_videos where gallery_id='".$val_query['gallery_id']."'";
                                $total_images=mysql_num_rows($db->query($sql_record1));
								if($total_images !=0)
								$total_images = "<a href='manage_videos.php?gallery_id=$listed_record_id'>$total_images</a>";
								
                                $position=120; // Define how many character you want to display.                                
                                $post = substr(strip_tags($val_query['description']), 0, $position);
                                
                                include "include/paging_script.php";
                                
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';       
                                echo '<td ><a href="add_vedio_gallery.php?record_id='.$listed_record_id.'" >'.$val_query['title'].'</a></td>';
                                echo '<td >'.$post.'</td>';
							    echo '<td >'.$val_query['event_date'].'</td>';
								
								
							  
							    echo '<td >' .$total_images. '</td>';
					 echo '<td><select name="status" class="input_select_login" onchange="redirect1(\'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?changeStatus='.$listed_record_id.$query_string1.'&value=\',this.value)">';
					echo '<option value="0" selected="selected">-Status-</option>';
						if($val_query['status']=='Active')
							echo '<option value="Active" selected="selected">Active</option>';
						else
							echo '<option value="Active">Active</option>';
						if($val_query['status']=='Inactive')
							echo '<option value="Inactive" selected="selected">Inactive</option>';
						else
							echo '<option value="Inactive">Inactive</option>';
						if($val_query['status']=='Banned')
							echo '<option value="Banned" selected="selected">Banned</option>';
						else
							echo '<option value="Banned">Banned</option>';
					echo '</select>';
					echo '</td>';
								
								
                                echo '<td align="center">'.$val_query['added_date'].'</td>';
                                echo '<td align="center"><a href="add_vedio_gallery.php?record_id='.$listed_record_id.'" ><img src="images/edit_icon.png" title="Edit Record" class="example-fade"/></a>&nbsp;&nbsp;
                                      <a onclick="return validationToDelete(\''.$_SERVER['PHP_SELF'].'\');" href="'.$_SERVER['PHP_SELF'].'?deleteRecord=1&record_id='.$listed_record_id.'&page='.$_REQUEST['page'].$query_string1.'"><img src="images/delete_icon.png" title="Delete Record" class="example-fade" /></a>&nbsp;&nbsp;';

                                echo '</td>';
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
    </tr></form>
      <?php } 
      else
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Gallery found related to your search criteria, please try again</div><br></td></tr>';?>
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

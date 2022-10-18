<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Subscriber</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
	  <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
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
    <td class="top_mid" valign="bottom"><?php include "include/sms_mail_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
 
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
  <tr class="head_td">
    <td colspan="15">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
                       
                </td>
              
                    
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
						
						
						$from_date=explode('/',$_REQUEST['from_date'],3);
			            $chnge_from_date=$from_date[2].'-'.$from_date[1].'-'.$from_date[0];
						
						$to_date=explode('/',$_REQUEST['to_date'],3);
			            $chnge_to_date=$to_date[2].'-'.$to_date[1].'-'.$to_date[0];
						
						if($_REQUEST['from_date'] && $_REQUEST['to_date'])
						 {
						  	$pre_from_date=" and from_date >='".$chnge_from_date."' and from_date <='".$chnge_to_date."'";
						 }
						else
						 {
							$pre_from_date=""; 	                   
						 }
	
                        if($_REQUEST['keyword']!="Keyword")
                            $keyword=trim($_REQUEST['keyword']);
                        if($keyword)
                            {                            
                                $select_name = "select course_name from courses where (course_name LIKE '%".$keyword."%' or course_description LIKE '%".$keyword."%')";                                           
                                if(mysql_num_rows($db->query($select_name)))
                                {
                                    $val_name = $db->fetch_array($db->query($select_name));
                                    $name_to_array = "or course_name like concat(concat('%','".$val_name['course_name']."','%')) ";
                                }
                                $category = '';
                                $select_category = "select category_id from course_category where category_name like '%".$keyword."%' ";
                                if(mysql_num_rows($db->query($select_category)))
                                {
                                    $val_category_name = $db->fetch_array($db->query($select_category));
                                   $category = "or category_id = '".$val_category_name['category_id']."' ";
                                }
                                
                                $pre_keyword=" and (campaign_name like '%".$keyword."%')";
                            }                            
                        else
                            $pre_keyword="";
                        
                        if($_REQUEST['free_course'])
                             $pre_keyword_corse="  and (free_course ='".$_REQUEST['free_course']."')";
                            else 
                             $pre_keyword_corse="";

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
                            $select_directory='order by user_id desc';                      
                          $sql_query= "SELECT DISTINCT (mobile_no),name,email_id,user_status,user_id FROM isas_subscriber_details where 1  ".$pre_keyword."  ";  //".$_SESSION['where_admin_id']."
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
                            
  <tr class="grey_td" >
   
    <td width="7%" align="center"><strong>Sr. No.</strong></td>
    <td width="15%"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=course_name".$query_string;?>" class="table_font"><strong>Name</strong></a> <?php echo $img1;?></td>
    

	  <td width="15%"><strong>Mobile Number</strong></td>
	   <td width="15%"><strong>Email ID</strong></td>
	    <td width="15%"><strong>Status</strong></td>
		
	
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
                                $name = '';
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                
                                $listed_record_id=$val_query['campaign_id']; 
                                $select_category = "select category_name from course_category where category_id = '".$val_query['category_id']."' ";                                			                                $val_category = $db->fetch_array($db->query($select_category));
                                
                                $select_crsid="select subject_id from courses where course_id='".$listed_record_id."'";
								$ptr_crsid=mysql_query($select_crsid);
								$data_crsid=mysql_fetch_array($ptr_crsid);
								
								$select_id="select subject_id from topic_map where course_id='".$listed_record_id."'";
								$ptr_id=mysql_query($select_id);
								$data_id=mysql_fetch_array($ptr_id);
								
								$sel_inq="select inquiry_id from inquiry where course_id='".$listed_record_id."'";
								$ptr_inq=mysql_query($sel_inq);
								$data_inq=mysql_fetch_array($ptr_inq);
								
								$sel_enroll="select enroll_id from enrollment where course_id='".$listed_record_id."'";
								$ptr_enroll=mysql_query($sel_enroll);
								$data_enroll=mysql_fetch_array($ptr_enroll);
                                /*$arr=explode(",", $val_query['course_author']);
                                for($i=0;$i<=count($arr);$i++)
                                {
                                    $select_name = "select first_name,last_name from user where user_id = '".$arr[$i]."' ";                                           
                                    $val_name1 = $db->fetch_array($db->query($select_name));
                                    if($val_name1['first_name'])
                                    {
                                        $name .=$val_name1['first_name'].' '.$val_name1['last_name'].', ';
                                    }                                    
                                }*/
                                //$names = rtrim($name, ", ");
                                include "include/paging_script.php";
                               
                                echo '<tr '.$bgcolor.' >';
                                      
                                echo '<td align="center">'.$sr_no.'</td>'; 
								if($_SESSION['type'] =='S')
								{                               
                               		echo '<td><a href="add_course.php?record_id='.$listed_record_id.'" class="table_font">'.$val_query['name'].'</a></td>';
								}
								else
								{
									echo '<td >'.$val_query['name'].'</td>';
								}
                                echo '<td >'.$val_query['mobile_no'].'</td>';
                                echo '<td >'.$val_query['email_id'].'</td>';
                               
							
							    ?>
								<td><select name="status" id="status" onChange="change_status(this.value,<?php echo $val_query['user_id']; ?>);">
								<option value="">Select</option>
								<option value="Active" <?php if($val_query['user_status']=='Active') { echo 'selected';} else { echo ""; } ?>>Active</option>
								<option value="Inactive" <?php if($val_query['user_status']=='Inactive') { echo 'selected';} else { echo ""; } ?>>Inactive</option>
								</select></td>
								<?php								
								
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
<script>
function change_status(status,id) {
	
        $.ajax({ 
		//alert(staff+">>>>>>>>>"+month+">>>>>>>>>>>>>"+year);
	        type: 'post',
            url: 'change_status_ajax.php',
            data: { status: status,id:id,type:'subscriber' },
            
        }).done(function(responseData) {
       // $("#showdiv").html(responseData);
	   
		$(this).hide();
		$('.window').hide();
	   $('#mask').hide();
	   
        }).fail(function() {
            console.log('Failed');
        });

    }
</script>
<!--footer end-->
</body>
</html>

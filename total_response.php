<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Total Response</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='101'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
    <script type="text/javascript" src="../js/common.js"></script>
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
     <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd', showButtonPanel: true, closeText: 'Clear'});
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
    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
   
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="8">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <!--<td width="20%">
                        <select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
                                <option value="">-Operation-</option>
                                <option value="delete">Delete</option>
                        </select></td>-->
                        
                         <td width="10%">
                         <input type="text" name="from_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="from_date" title="From Date" value="<?php if($_REQUEST['from_date']!="From Date") echo $_REQUEST['from_date'];?>">
                         </td>
                         
                         <td width="10%">
                         <input type="text" name="to_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="to_date"  title="To Date" value="<?php if($_REQUEST['from_date']!="To Date") echo $_REQUEST['to_date'];?>">
                         </td>
                         
                                <td width="10%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                
                <td class="rightAlign" > 
                    <!--<table border="0" cellspacing="0" cellpadding="0" align="right">
              <tr>
              <td></td>
              <td class="width5"></td>
                <td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
                <td class="width2"></td>
                <td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
              </tr>
                    </table>	-->
                </td>
            </tr>
        </table>
        </form>	
    </td>
  </tr>
    
     <?php
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						 {
						  	$pre_from_date=" and DATE(`admission_date`) >='".date('Y-m-d')."'";
							
							$installment_from_date=" and DATE(`admission_date`) >='".date('Y-m-d')."'";
							
							$enquiry_from_date=" and DATE(`added_date`) >='".$_REQUEST['from_date']."'";
						 }
						else
						{
							$pre_from_date=""; 
							$enquiry_date="";
							$installment_from_date="";                           
						}
						
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							 $_REQUEST['to_date'];
							 
							 $pre_to_date=" and DATE(`admission_date`) <='".date('Y-m-d')."'";
							
							$installment_to_date=" and DATE(`admission_date`)<='".date('Y-m-d')."' ";
							
							$enquiery_to_date=" and DATE(`added_date`)<='".$_REQUEST['to_date']."'";
						}
						else
						{
							$pre_to_date="";
							$enquiery_to_date="";
							$installment_to_date="";
						}
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

                        if($_GET['order'] !='' && ($_GET['orderby']=='firstname'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							
							/*$branch_id='';
                       		$select_directory='order by source_id asc';                      
                       		$sql_query= "SELECT source_id,source_name FROM source where 1 ".$select_directory.""; 
							$db=mysql_query($sql_query);
							$no_of_records=mysql_num_rows($db);*/
						
                       /* if($no_of_records)
                        {*/
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword;
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
   
    <form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                     <input type="hidden" name="formAction" id="formAction" value=""/>
                      <tr class="grey_td" >
                      
                        <td width="4%" align="center"><strong>Sr. No.</strong></td>
                        <td width="10%" align="center"><strong>Source Name</strong></td>
                        <td width="10%" align="center"><strong>Total</strong></td>
                      
                      </tr>
                      <tr>
                      		<td align="center">1</td>
                            <td align="center">Walk in</td>
                            <?php
							 "<br />".$sel_resp1="select count(inquiry_id) as total_resp from inquiry where 1 and response='walk_in' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date." ";
							$ptr_resp1=mysql_query($sel_resp1);
							$data_resp1=mysql_fetch_array($ptr_resp1);
							?>
                            <td align="center"><?php echo $data_resp1['total_resp']; ?></td>
                      </tr>
                      <tr>
                      		<td align="center">2</td>
                            <td align="center">Will Walk in</td>
                           <?php
							 "<br />".$sel_resp2="select count(inquiry_id) as total_resp from inquiry where response='will_walkin' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."";
							$ptr_resp2=mysql_query($sel_resp2);
							$data_resp2=mysql_fetch_array($ptr_resp2);
							?>
                            <td align="center"><?php echo $data_resp2['total_resp']; ?></td>
                      </tr>
                      <tr>
                      		<td align="center">3</td>
                            <td align="center">Call Back Later</td>
                            <?php
							 "<br />".$sel_resp3="select count(inquiry_id) as total_resp from inquiry where response='call_back_later' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."";
							$ptr_resp3=mysql_query($sel_resp3);
							$data_resp3=mysql_fetch_array($ptr_resp3);
							?>
                            <td align="center"><?php echo $data_resp3['total_resp']; ?></td>
                      </tr>
                      <tr>
                      		<td align="center">4</td>
                            <td align="center">Call did not pick up</td>
                            <?php
							 "<br />".$sel_resp4="select count(inquiry_id) as total_resp from inquiry where response='call_not_pickup' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."";
							$ptr_resp4=mysql_query($sel_resp4);
							$data_resp4=mysql_fetch_array($ptr_resp4);
							?>
                            <td align="center"><?php echo $data_resp4['total_resp']; ?></td>
                      </tr>
                      <tr>
                      		<td align="center">5</td>
                            <td align="center">Not reachable</td>
                            <?php
							 "<br />".$sel_resp5="select count(inquiry_id) as total_resp from inquiry where response='not_reachable' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."";
							$ptr_resp5=mysql_query($sel_resp5);
							$data_resp5=mysql_fetch_array($ptr_resp5);
							?>
                            <td align="center"><?php echo $data_resp5['total_resp']; ?></td>
                      </tr>
                      <tr>
                      		<td align="center">6</td>
                            <td align="center">Call taken</td>
                            <?php
							 "<br />".$sel_resp6="select count(inquiry_id) as total_resp from inquiry where response='call_taken' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiery_to_date."";
							$ptr_resp6=mysql_query($sel_resp6);
							$data_resp6=mysql_fetch_array($ptr_resp6);
							?>
                            <td align="center"><?php echo $data_resp6['total_resp']; ?></td>
                      </tr>
                            <?php
							 /*include "include/paging_script.php";
								
                                echo '<tr '.$bgcolor.'>';
								   echo '<td align="center">'.$sr_no.'</td>';
								echo '</tr>';  
								echo '<tr '.$bgcolor.'>';
								   echo '';
								 echo '</tr>';  
								echo '<tr '.$bgcolor.'>'; 
								   echo '';
								echo '</tr>';  
								echo '<tr '.$bgcolor.'>';   
								   echo '';
								echo '</tr>';  
								echo '<tr '.$bgcolor.'>';   
								   echo '';
								echo '</tr>';  
								echo '<tr '.$bgcolor.'>';   
								   echo '';
								 echo '</tr>';  
								echo '<tr '.$bgcolor.'>';  
								   echo '';
								echo '</tr>';  
								echo '<tr '.$bgcolor.'>';
                                   echo '<td >'.$total_source.'</td>';
                                
                                
                                echo '</tr>';*/
                           /* while($val_query=mysql_fetch_array($all_records))
                            {
								if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor=""; 
								$total_source='';	       
                                $sel_source="select s.enquiry_source,e.source from inquiry s, enrollment e where s.enquiry_source =".$val_query['source_id']." or e.source =".$val_query['source_id']." ";*/
							   
							  /*echo  $sel_source="Select A.enquiry_source
From inquiry A Left Outer Join
     enrollment B on A.enquiry_source = B.source where  A.enquiry_source = '".$val_query['source_id']."' 
INTERSECT
Select C.source
From enrollment C left join
     inquiry D on C.source = D.enquiry_source where C.source = '".date('Y-m-d')."' ";*/
	 
								/*$ptr_source=mysql_query($sel_source);
								$total_source=mysql_num_rows($ptr_source);
								
                               
								$bgColorCounter++;
                                                                
							}*/
                                ?>
                                
                                <tr class="head_td">
    <td colspan="15">
       <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <?php
                     /* if($no_of_records>10)
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
                            echo '<td width="75%" align="right">'.$pager->renderFullNav().'</td>';*/
                         
                 ?>
                                    
            </tr>
        </table>
 
    
                                    
                                       
                               
    </td>
    </tr>
  
  
  </form>
  <?php //} 
	  
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
<div id="footer">
<?php include "include/footer.php"; ?>
</div>
<!--footer end-->
</body>
</html>

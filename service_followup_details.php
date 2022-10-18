<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['record_id']))
$record_id = $_GET['record_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Followup Summery</title>
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
    
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    
     <script type="text/javascript">
       
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
            
//             $('input:radio[name=free_course][value=N]').click();
//             $('input:radio[name=discount_course][value=Y]').click();
//             $('input:radio[name=status][value=Inactive]').click();
        });
		
function date()
 {
 var followup_date= document.getElementById('followup_date');
 alert (followup_date)
 var date = new Date();
 if(followup_date < Date())
 {
	alert("Followup Date should Be Greater than Todays Date");
	document.getElementById('followup_date').style.border = '1px solid #f00';
 }
 }
 
 
 function validme()
	 {
		 frm = document.frmTakeAction;
		 error='';
		 disp_error = 'Clear The Following Errors : \n\n';
		 
		 if(frm.followup_date.value=='')
		 {
			 disp_error +='Enter followup date  \n';
			 document.getElementById('followup_date').style.border = '1px solid #f00';
			 frm.followup_date.focus();
			 error='yes';
	     }
		 else
		 {
			 
			if(isFeatureDate(frm.followup_date.value))
	 	 		{
		 		}
			 else
			 {
				 disp_error +='Enter Valid Follow (feature) up Date\n';
				  document.getElementById('followup_date').style.border = '1px solid #f00';
				 error='yes';
			 }
		 }
		 
		 if(error=='yes')
		 {
			 alert(disp_error);
			 return false;
		 }
		 else
		 return true;
		 
	 }
	 
	 
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
		</script>
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
    <td class="top_mid" valign="bottom"><?php include "include/services_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
     <?php if($_POST['formAction'])
			{ 
				if($_POST['formAction']=="delete")
				{
					for($r=0;$r<count($_POST['chkRecords']);$r++)
					{
						$del_record_id=$_POST['chkRecords'][$r];
						$sql_query= "SELECT followup_id FROM ".$GLOBALS["pre_db"]."service_service_followup_details where followup_id ='".$del_record_id."'";
						$my_query=mysql_query($sql_query);
						
						if(mysql_num_rows($my_query))
							{       
								$data_delete=mysql_fetch_array($my_query);         
																
								$delete_query="delete from ".$GLOBALS["pre_db"]."service_followup_details where followup_id='".$del_record_id."'";
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
								setTimeout('document.location.href="followup_summery.php";',2000);
							</script>
					<?php                            
						}                       
			 }
			if($_REQUEST['deleteRecord'] && $_REQUEST['record_id'])
			{
				$del_record_id=$_REQUEST['record_id'];
				$sql_query= "SELECT followup_id FROM ".$GLOBALS["pre_db"]."service_followup_details where followup_id ='".$del_record_id."'";
				if(mysql_num_rows($db->query($sql_query)))
				{                           
				$delete_query="delete from ".$GLOBALS["pre_db"]."service_followup_details where followup_id='".$del_record_id."'";
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
						setTimeout('document.location.href="followup_summery.php";',2000);
					</script>
					<?php
				}
			}
			?>
  
  <!-- ================================================Start Table=============================================================================================-->
<?php
 $sql_query= "select inquiry_id,name from service_inquiry where inquiry_id ='".$record_id."'"; 
 $db=mysql_query($sql_query);
 $data_ptr=mysql_fetch_array($db);
 
?>

<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="11">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <td class="width5"></td>
                <td width="20%">
					<select name="selAction" id="selAction" class="input_select_login" onChange="Javascript:submitAction(this.value);">
							<option value="">-Operation-</option>
							<option value="delete">Delete</option>
					</select></td>
                <td><strong>Name- </strong><?php echo $data_ptr['name']; ?></td>  
                
                <td  align="right"><a href="service_followup_summery.php?record_id= <?php echo $record_id; ?>"><input type="button" name="update_followup" value="Update Followup" /></a></td>
                <td  align="right"><a href="service_followup_summery.php"><input type="button" name="back" value="Back" /></a></td>
                <td class="rightAlign" > 
				<table border="0" cellspacing="0" cellpadding="0" align="right">
				  <!--<tr>
				  <td></td>
				  <td class="width5"></td>
					<td><input type="text" value="<?php if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
					<td class="width2"></td>
					<td><input type="image" src="images/search.jpg" name="search" value="Search" title="Search" class="example-fade"  /></td>
				  </tr>-->
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
                                $pre_keyword =" and (lead_category_followup like '%".$keyword."%' or lead_grade like '%".$keyword."%' )";
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

                        if($_GET['orderby']=='followup_id' )
                            $img1 = $img;

                        if($_GET['order'] !='' && ($_GET['orderby']=='followup_id'))
                        {
                            $select_directory .= " order by ".$_GET['orderby']." " .$_GET['order'] ;
                            $date_query='&order='.$_GET['order'].'&orderby='.$_GET['orderby'];
                        }
                        else
							
							$branch_id='';
							
						
                            $select_directory='order by followup_id desc';                      
                           $sql_query= "select * from service_followup_details where inquiry_id ='".$record_id."' ".$_SESSION['where']." ".$pre_keyword." ".$select_directory.""; 
                       //echo $sql_query;
					   	$db=mysql_query($sql_query);
                        $no_of_records=mysql_num_rows($db);
						
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
    <td width="20%" align="center"><a href="<?php echo $_SERVER['PHP_SELF'];?>?order=<?php echo $order."&orderby=name".$query_string;?>" class="table_font"><strong>Followup Category</strong></a> <?php echo $img1;?></td>
    <td width="15%" align="center"><strong>Followup Date</strong></td>
    <td width="15%" align="center"><strong>Lead Grade</strong></td>
	<td width="15%" align="center"><strong>Response by</strong></td>
    <td width="15%" align="center"><strong>Followup Details </strong></td>
    <td width="15%" align="center"><strong>Followup By </strong></td>
     <td width="10%" align="center"><strong>Added Date</strong></td>
  </tr>
                            <?php

                            while($val_query=mysql_fetch_array($all_records))
                            {
								
								/*$sele_latest_rec="select followup_date,lead_category_followup,lead_grade, added_date,service_followup_details from service_followup_details where inquiry_id = '".$record_id."' order by followup_id desc";
								$ptr_select_letest_rec=mysql_query($sele_latest_rec);
								$val_select_letest_rec=mysql_fetch_array($ptr_select_letest_rec);*/	
								
								
								if($val_query['lead_category_followup']=='walkin_followup')
								$lead_cat= "Walk-in Followup";
								else
								$lead_cat= "Phone Followup";
								
								if($val_query['lead_grade']=="very_hot")
								{
									$lead_grade="Very Hot";
									$bgcolr="#980000";
									$color="#fff";
								}
								else if($val_query['lead_grade']=="hot")
								{
									$lead_grade="Hot";
									$bgcolr="#FF0000";
									$color="#fff";
								}
								else if($val_query['lead_grade']=="warm")
								{
									$lead_grade="Warm";
									$bgcolr="#F58F09";
									$color="#000";
								}
								else if($val_query['lead_grade']=="Nutral")
								{
									$lead_grade="Neutral";
									$bgcolr="#FFFF66";
									$color="#000";
								}
								else if($val_query['lead_grade']=="cold")
								{
									$lead_grade="Cold";
									$bgcolr="#377A07";
									$color="#000";
								}
								
								$sel_name="select name from site_setting where admin_id='".$val_query['admin_id']."'";
								$ptr_name=mysql_query($sel_name);
								$data_name=mysql_fetch_array($ptr_name);
								
                                if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor="";                
                                $listed_record_id=$val_query['followup_id']; 
//                                $select_country = "select country_name from PB_country where country_id = '".$val_query['country_id']."' ";
//                                $val_contry = $db->fetch_array($db->query($select_country));
                                include "include/paging_script.php";
                                
								$response="select respnce_category_name from responce_category where responce_id='".$val_query['response']."'";
								$ptr_response=mysql_query($response);
								$data_response=mysql_fetch_array($ptr_response);
								
                                echo '<tr '.$bgcolor.' >
                                      <td align="center"><input type="checkbox" name="chkRecords[]" value="'.$listed_record_id.'"></td>';
                                echo '<td align="center">'.$sr_no.'</td>';                                
                                echo '<td align="center">'.$lead_cat.'</td>';
								echo '<td align="center">'.$val_query['followup_date'].'</td>';  
                                echo '<td align="center" bgcolor='.$bgcolr.' style="color:'.$color.'">'.$lead_grade.'</td>';
								 echo '<td align="center">'.$data_response['respnce_category_name'].'</td>';
                                echo '<td align="center">'.$val_query['followup_details'].'</td>';
								echo '<td align="center">'.$data_name['name'].'</td>';
								echo '<td align="center">'.$val_query['added_date'].'</td>';
								
                                echo '</tr>';
                                                                
                                $bgColorCounter++;
                            }  
							  
                                ?>
  
  
  <tr class="head_td">
    <td colspan="11">
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
        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No Student found related to your search criteria, please try again</div><br></td></tr>';?>
</table>
<?

	//==========================================================END Table========================================================================================================
								
								
								
                                    //echo'<center><br><div id="alert" style="width:30%">No Record history here</div><br></center>';
                            ?>
                            
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
                    <noscript>
                            Warning! JavaScript must be enabled for proper operation of the Administrator backend.				</noscript>
                 <div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>

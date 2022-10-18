<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";
include "include/ps_pagination.php"; 
$db= new Database(); $db->connect();
if(isset($_GET['course_id']))
$record_id = $_GET['course_id'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> Online Transaction Summery</title>
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
    
    <script>
	finish = 0;
	remain=0;
	function calculate_total(amount_paid)   // caloculate the total of sell
  	{
		var balance_amount= document.getElementById('balance_amount').value;
		//alert(balance_amount);
	    amount_paid_id=parseInt(amount_paid); 
		//alert(amount_paid_id);
		//amount_paid_id= document.getElementById(amount_paid_id).value;
		avail_balance_id = parseInt(balance_amount) - parseInt(amount_paid_id);
		//alert(avail_balance_id);	
		document.getElementById('bal_amt').value=avail_balance_id;
		no_of_installment = $("#no_of_installment").val();	
		//alert(no_of_installment);
		var remaining =	parseInt(balance_amount);
		
		for(x=1;x<=no_of_installment;x++)
		{ 
		  //  alert(finish);
			if(finish!=x)
			{
			inst_id_val = $("#inst_"+x).val();					
			//alert(inst_id_val);
			vlsd = inst_id_val-amount_paid_id;
			//alert(amount_paid_id);
			if(vlsd<0)
			{
				remain= vlsd;
				$("#int_id_"+x).html(0);
				//$("#inst_"+(x+1)).val($("#inst_"+x).val()+remain);
				nx =(parseInt($("#inst_"+x).val())+remain);
				$("#inst_"+(x+1)).val(nx);
				$("#inst_"+x).val(vlsd)
				if(nx<0 && $("#inst_"+(x+1)))
				{
					$("#inst_"+(x+1)).val(0);
					//alert(nx);
					//alert($("#inst_"+(x+1)).val());
					$("#int_id_"+(x+1)).html(0);
					if($("#inst_"+(x+2)))
					{
						nx2 = (parseInt($("#inst_"+(x+2)).val())+nx);
						$("#int_id_"+(x+2)).html(nx2);
					}
				}
				else
				{
					$("#int_id_"+(x+1)).html(nx);
				}
				
				//alert(nx);
				
				finish=x;
				break;
					
			}else
			if(amount_paid_id <= parseInt(inst_id_val))
			{ 
			   
				if($("#int_id_"+x).html() !=0)
				{	
				 	
					$("#int_id_"+x).html(vlsd);
					if($("#int_id_"+x).html()==0)
					finish=x;
					break;
				}
				
				
				
			}
			
			//alert(finish);
			}
		}
		//alert($("#inst_1").val());
		document.getElementById('avail_balance').value=avail_balance_id;		
		document.getElementById('avail_balance_show').innerHTML = avail_balance_id;
    }
	jQuery(document).ready( function() 
	{
		$("#action").multiselect().multiselectfilter();
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
	
	
	
	//document.getElementById("save_changes").disabled = true;
	/*EnableSubmit = function(val)
		{
			var sbmt = document.getElementById("action11");
	
		if (val.checked == true)
		{
			sbmt.disabled = false;
		}
		else
		{
			sbmt.disabled = true;
		}
}        */
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
    <td class="top_mid" valign="bottom"><?php include "include/student_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
    					<?php
    						if($_POST['save_changes'])
                        	{
								
								$action=$_POST['action'];
								foreach($action as $student)
								{
								$extract = explode(',',$student);
								$data_record_update['course_status']='completed';
								$data_record_update['course_status_date']=date('y-m-d');
								$where_record="enroll_id='$extract[0]'";
								$db->query_update("enrollment",$data_record_update,$where_record);
								}
								?>
                                <script>
								alert("Record Successfully Updated");
								</script>
								<?
                        	}
                                
                         	?>       
                                <form method="get" name="jqueryForm" id="jqueryForm">
                                    <table align="center" border="0" width="60%"> 
                                <tr>
                                <td width="20%" ><strong>Search By.. </strong> </td>
                                 <td width="30%" ><input type="text" name="bank_ref_id" placeholder="Bank Ref. ID"/>
                                 <font style="text-align:right">OR</font>
                                  </td>
                                  <td><input type="text" name="order_id" placeholder="Order ID"/></td>
                                    <td width="20%"><input type="submit" name="search" value="Search" class="inputButton"/></td>
                                </tr>
                                </table>
                                </form>
                         <?php
						 {
								$pre_bank_ref_id ='';
								if($_REQUEST['bank_ref_id']!="BILL ID" && $_REQUEST['bank_ref_id']!='')
								{
								   $pre_bank_ref_id = " and bank_ref_id ='".$_REQUEST['bank_ref_id']."'  " ;
								}	
								$pre_order_id ='';
								if($_REQUEST['order_id']!="BILL ID" && $_REQUEST['order_id']!='')
								{
								   $pre_order_id = " and order_id ='".$_REQUEST['order_id']."'  " ;
								}	
                            $sql_records= "SELECT * FROM online_trans_details where 1 ".$pre_bank_ref_id." ".$pre_order_id." order by trans_id  desc";// order by year(added_date) desc,month(added_date) desc,day(added_date) asc";
							   $_SESSION['sql_articles']=$sql_records;
								
                               	 //echo $sql_records;
                                $no_of_records=mysql_num_rows($db->query($sql_records));
                                if($no_of_records)
                                {
                                    $bgColorCounter=1;
                                    if(!$_SESSION['showRecords'])
                                        $_SESSION['showRecords']=10;

                                    $query_string.="&show_records=".$showRecord;
                                    $pager = new PS_Pagination($sql_records,$_SESSION['show_records'],10,$query_string);
                                    $all_records= $pager->paginate();?>
                                    <form method="post" name="frmTakeAction">
                                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                    <tr><td valign="middle" align="right">
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
                                        </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr><td valign="top" colspan="2">
                                        <table cellspacing="1"  cellpadding="3" width="100%" align="center">
                                        <tr align="center" bgcolor="#CCCCCC">
                                            <td class="tr-header" valign="middle" width="6%"><strong>Sr. No.</strong></td>
                                            <td class="tr-header" valign="middle" width="18%"><strong>Student Name</strong></td>
                                            <td class="tr-header" valign="middle" width="23%"><strong>Order ID</strong></td>
                                            <td class="tr-header" valign="middle" width="16%"><strong>Bank Ref. ID</strong></td>
                                            <td class="tr-header" valign="middle" width="16%"><strong>Payment Mode</strong></td>
                                            <td class="tr-header" valign="middle" width="14%"><strong>Payment</strong></td>
                                            <td class="tr-header" valign="middle" width="14%"><strong>Status</strong></td>
                                            <td class="tr-header" valign="middle" width="9%"><strong>Added Date</strong></td>
                                         </tr><?php
										$sell_quantity=0;
										$purchase_quantity=0;
										$sell_amount=0;
										$purchase_amount=0;
										$active_save ='';
                                    while($val_record=mysql_fetch_array($all_records))
                                    {
                                        if($sr_no%2==0)
                                            $bgclass="#E4E4E4";
                                        else
                                            $bgclass="#F1F1F1";
                                        include "include/paging_script.php";
                                        echo '<tr bgcolor="'.$bgclass.'">';
                                        echo '<td align="center">'.$sr_no.'</td>';
										$name ='';
										$email_id = '';
										$phone_no ='';
									
										$select_invoice = "SELECT enroll_id from invoice where invoice_id='".$val_record['order_id']."'  ";
										$data_select = mysql_fetch_array(mysql_query($select_invoice));
										
										$select_name = "SELECT name from enrollment where enroll_id='".$data_select['enroll_id']."'  ";
										$data_select_name = mysql_fetch_array(mysql_query($select_name));
										
										echo '<td align="left" style="padding-left:5px;"><b>'.$data_select_name['name'].'</b> </td>';
										
										
										echo '<td align="center">';
										echo ''.$val_record['order_id'].'';
										echo '</td>';
										
										echo '<td align="center">';
										echo ''.$val_record['bank_ref_id'].'';
										echo '</td>';
										
										echo '<td align="center">';
										echo ''.$val_record['paymode'].'';
										echo '</td>';
										echo '<td align="center">';
										echo ''.$val_record['payment'].'';
										echo '</td>';
										if($val_record['status']=='paid')
										{
											echo '<td align="center" style="padding-left:5px;color:#00CC00"><b>'.$val_record['status'].'</b></td>';
										}
										elseif($val_record['status']=='Aborted')
										{
											echo '<td align="center" style="padding-left:5px;color:#FFFF00"><b>'.$val_record['status'].'</b></td>';
										}
										else
										{
											echo '<td align="center" style="padding-left:5px;color:#FF0000"><b>'.$val_record['status'].'</b></td>';
										}
										echo '<td align="center">';
										echo ''.$val_record['added_date'].'';
										echo '</td>';
                                        echo '</tr>';
                                        $bgColorCounter++;
									
									  }
                                    ?>
                                        </table>
                                        
                                        <table width="100%" align="center">
                                        	<tr  style="font-weight:bold; height:30px;">
                                    			<td align="center" colspan="3">
                                                <?php
												if($active_save=='yes')
												{ 
												?>
                                                <input type="submit" name="save_changes"  id="save_changes" value="Save"   /> 
                                                <?php } ?>
                                                </td>
                                  			</tr>
                                        </table>
                                    </td></tr>
                                    <tr><td height="10"></td></tr>
                                    <tr><td valign="middle" align="right">
                                            <table width="100%" cellpadding="0" callspacing="0" border="0">
                                                <tr>
                                                    <?php
													
                                                    if($no_of_records>10)
                                                    {
														//echo $no_of_records;
                                                        echo '<td width="3%" align="left">Show</td>
                                                        <td width="12%" align="left"><select class="inputSelect" name="show_records" onchange="redirect(this.value)">';
                                                        
                                                        for($s=0;$s<count($show_records);$s++)
                                                        {
															//echo'Hiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii';
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
                                        </td></tr>
                                    </table>
                                    
                                    </form><?php
                                }
                                else if($_GET['search'])
                                    echo'<center><br><div id="alert" style="width:80%">Records not found related to your search criteria, please try again to get more results</div><br></center>';
                                else
                                    echo'<center><br><div id="alert" style="width:30%">No Payment history here</div><br></center>';
						}
						 
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
<?php $db->close();?>
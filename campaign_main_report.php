<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Campaign Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='256'";
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
    <link rel="stylesheet" href="js/chosen.css" />
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
     <script type="text/javascript">
    $(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		
		$("#campaign_name").chosen({allow_single_deselect:true});
		<?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
		{ 
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			<?php 
		}
		?>
		$("#type").chosen({allow_single_deselect:true});
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
    <script>
	function change_campaign(branch)
	{
		var branch=document.getElementById('branch_name').value
		var cat_data="action=show_campaign&branch="+branch;
		$.ajax({
		url: "ajax.php",type:"post", data: cat_data,cache: false,
		success: function(retbank)
		{
			document.getElementById("camaign").innerHTML=retbank;
			$("#campaign_name").chosen({allow_single_deselect:true});
		}
		});
	}
	function change_type(type)
	{
		var branch_id=document.getElementById('branch_name').value;
		var type=document.getElementById('type').value;
		var cat_data="action=show_campaign_type&type="+type+"&branch_id="+branch_id;
		//alert(cat_data);
		$.ajax({
		url: "ajax.php",type:"post", data: cat_data,cache: false,
		success: function(retbank)
		{
			//alert(retbank);
			document.getElementById("camaign").innerHTML=retbank;
			$("#campaign_name").chosen({allow_single_deselect:true});
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
    <td class="top_mid" valign="bottom"><?php include "include/campaign_menu.php";?></td>
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
	                    <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
						{
						?>
						 <td width="15%">
							<select name="branch_name" id="branch_name"  class="input_select_login"  style="width:150px;" onchange="change_campaign(this.value);">
								<option value="">-Branch Name-</option>
								<?php 
									$sel_branch="select branch_id,branch_name from branch";
									$ptr_sel=mysql_query($sel_branch);
									while($data_branch=mysql_fetch_array($ptr_sel))
									{
										$sel='';
										if($data_branch['branch_name']==$_GET['branch_name'])
										{
											$sel='selected="selected"';
										}
										echo '<option '.$sel.' value="'.$data_branch['branch_name'].'" > '.$data_branch['branch_name'].'</option>';
									}
								?>
							</select>
						</td>
                        <td>Select Type<span class="orange_font">*</span></td>
						 <td width="15%">
							<select name="type" id="type"  class="input_select_login"  style="width: 150px;" onchange="change_type(this.value);">
								<option value="">-Type-</option>
								<option value="institute">Institute</option>
                                <option value="service">Service</option>
							</select>
						</td>
                        <td>Select Campaign<span class="orange_font">*</span></td>
                        <td width="15%" id="camaign">
							<select id="campaign_name" name="campaign_name" class="input_select">
							<option value="">Select Campaign</option>
								<?php 
                                $course_category = " select DISTINCT(cm_id),branch_name from site_setting where type='A' ".$_SESSION['where']."";
                                $ptr_course_cat = mysql_query($course_category);
                                while($data_cat = mysql_fetch_array($ptr_course_cat))
                                {
                                    echo " <optgroup label='".$data_cat['branch_name']."'>";
                                    $sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and status='Active' order by campaign_for asc";
                                    $ptr_src=mysql_query($sel_source);
                                    while($data_src=mysql_fetch_array($ptr_src))
                                    {
                                         $sele_source="";
                                        if($data_src['campaign_id'] == $_REQUEST['campaign_name'] || $_POST['campaign_name']== $data_src['campaign_id'] )
                                        {
                                            $sele_source='selected="selected"';
                                        }
                                        ?>
                                        <option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($_REQUEST['campaign_name']) && $_REQUEST['campaign_name'] == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
                                        <?
                                    }
                                    echo " </optgroup>";
                                }?>
							</select>
						</td>
						<?php
						}
						?>
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
						$search_cm_id='';
						$cm_ids=$_SESSION['cm_id'];
						if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
						{
							if($_REQUEST['branch_name']!='')
							{
								$branch_name=$_REQUEST['branch_name'];
								$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
								$ptr_cm_id=mysql_query($select_cm_id);
								$data_cm_id=mysql_fetch_array($ptr_cm_id);
								$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
								$cm_ids=$data_cm_id['cm_id'];
							}
							else
							{
								$search_cm_id='';
							}
						}
						$enquiry_src='';
						$campaign_src='';
						$enroll_src='';
						if($_REQUEST['campaign_name'])
						{
                            $enq_src=$_REQUEST['campaign_name'];
							$enquiry_src=" and enquiry_source = '".$enq_src."'";
							$campaign_src=" and campaign_id='".$enq_src."'";
							$enroll_src=" and source='".$enq_src."'";
						}
						
						if($_REQUEST['from_date'] && $_REQUEST['from_date']!=="0000-00-00" && $_REQUEST['from_date']!="From Date")
						{
							$frm_date=explode("/",$_REQUEST['from_date']);
							$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
							$pre_from_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($frm_dates))."'";
							
							//$pre_from_date=" and DATE(`admission_date`) >='".date('Y-m-d')."'";
							$inst_from_date=" and DATE(`admission_date`) >='".date('Y-m-d')."'";
							$enquiry_from_date=" and DATE(`added_date`) >='".date('Y-m-d',strtotime($frm_dates))."'";
						}
						else
						{
							$pre_from_date=""; 
							$enquiry_from_date="";
							$installment_from_date="";                           
						}
						if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
						{
							$to_date_exp=explode("/",$_REQUEST['to_date']);
							$to_dates=$to_date_exp[2]."-".$to_date_exp[1]."-".$to_date_exp[0];
							$pre_to_date=" and DATE(added_date) >='".date('Y-m-d',strtotime($to_dates))."'";
									
							$installment_to_date=" and DATE(`admission_date`)<='".date('Y-m-d')."' ";
							$enquiry_to_date=" and DATE(`added_date`)<='".date('Y-m-d',strtotime($to_dates))."'";
						}
						else
						{
							$pre_to_date="";
							$enquiry_to_date="";
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
							$branch_id='';
                       		$select_directory='order by campaign_id asc';                      
                       		$sql_query= "SELECT branch_name,campaign_id,campaign_name,campaign_for FROM campaign where 1 and status='Active' ".$search_cm_id." ".$campaign_src."  ".$select_directory.""; 
							$db=mysql_query($sql_query);
							$no_of_records=mysql_num_rows($db);
					

	                    if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$_REQUEST['branch_name'].'&from_date='.$_GET['from_date'].'&to_date='.$_GET['to_date'];
                            $query_string1=$query_string.$date_query;
                           // $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>  

    <form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">

                     <input type="hidden" name="formAction" id="formAction" value=""/>

                      <tr class="grey_td" >
                        <td width="10%" align="center"><strong>Sr. No.</strong></td>
						<td width="20%" align="center"><strong>Branch Name</strong></td>
                        <td width="30%" align="center"><strong>Campaign Name</strong></td>
                        <td width="30%" align="center"><strong>Campaign For</strong></td>
                        <td width="20%" align="center"><strong>Total Inquiries</strong></td>
	                    <td width="20%" align="center"><strong>Total Enrolled</strong></td>

                      </tr>
                            <?php
							$total_inq_source=0;
							$total_enroll_src=0;
                            while($val_query=mysql_fetch_array($all_records))
                            {
								if($bgColorCounter%2==0)
                                    $bgcolor='class="grey_td"';
                                else
                                    $bgcolor=""; 
								$total_source='';	       
                                $sel_inq_source="select inquiry_id from inquiry where 1 and enquiry_source ='".$val_query['campaign_id']."' ".$_SESSION['where']."  ".$enquiry_from_date." ".$enquiry_to_date." ".$enquiry_src." ";
								$ptr_inq_source=mysql_query($sel_inq_source);
								$total_inq_source=mysql_num_rows($ptr_inq_source);

								$sel_enroll_src="select enroll_id from enrollment where 1 and ref_id='0' and source ='".$val_query['campaign_id']."' ".$_SESSION['where']." ".$enquiry_from_date." ".$enquiry_to_date." ".$enroll_src." ";
								$ptr_enroll_src=mysql_query($sel_enroll_src);
								$total_enroll_src=mysql_num_rows($ptr_enroll_src);

								include "include/paging_script.php";
							   	echo '<tr '.$bgcolor.'>';
							   	echo '<td align="center">'.$sr_no.'</td>';
							   	echo '<td align="center">'.$val_query['branch_name'].'</td>';
							   	echo '<td align="center">'.$val_query['campaign_name'].'</td>';
							   	echo '<td align="center">'.$val_query['campaign_for'].'</td>';
							   	echo '<td align="center">'.$total_inq_source.'</td>';
							 	echo '<td align="center">'.$total_enroll_src.'</td>';
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
                                            echo'<td width="3%" align="left">Show</td><td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
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
                            </tr>
					</form>

  <?php } 

	  

      else

        echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';?>

      

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


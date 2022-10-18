<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='97'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}

?>
	<link rel="stylesheet" href="js/chosen.css" />
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    
    <script type="text/javascript">
	$(document).ready(function()
	{            
		$('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		$("#country").chosen({allow_single_deselect:true});
		$("#state").chosen({allow_single_deselect:true});
		$("#city").chosen({allow_single_deselect:true});
		$("#area").chosen({allow_single_deselect:true});
		<?php
		if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
		{
			?>
			$("#branch_name").chosen({allow_single_deselect:true});
			<?php
		}
		?>
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
		
		function select_state(country_id)
		{
			var state_data="action=state_m&country_id="+country_id;
			$.ajax({
			url: "ajax_state_city.php",type:"post", data: state_data,cache: false,
			success: function(retstate)
			{
				//alert(retbank);
				document.getElementById("show_states").innerHTML=retstate;
				document.getElementById("city").innerHTML='';
				
				$("#state").chosen({allow_single_deselect:true});
				$("#city").chosen({allow_single_deselect:true});
		
			}
			});
		}
		function select_city(state_id)
		{
			var city_data="action=city_m&state_id="+state_id;
			$.ajax({
			url: "ajax_state_city.php",type:"post", data: city_data,cache: false,
			success: function(retcity)
			{
				//alert(retbank);
				document.getElementById("show_cities").innerHTML=retcity;
				$("#city").chosen({allow_single_deselect:true});
			}
			});
		}
		function select_area(city_id)
		{
			//alert('hi');
			var state_id=document.getElementById("state").value;
			//alert(state_id);
			var area_data="action=area&city_id="+city_id+"&state_id="+state_id;
			$.ajax({
			url: "ajax_state_city.php",type:"post", data: area_data,cache: false,
			success: function(retcity)
			{
				//alert(retbank);
				document.getElementById("show_area").innerHTML=retcity;
				$("#area").chosen({allow_single_deselect:true});
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
    <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
    <td class="top_right"></td>
  </tr>
   
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid" align="center">
        
<table cellspacing="0" cellpadding="0" class="table" width="95%">
    
    
  <tr class="head_td">
    <td colspan="14">
        <form method="get" name="search">
	<table border="0" cellspacing="0" cellpadding="0" width="99%" align="center">
              <tr>
                <?php if($_SESSION['type']=='S'|| $_SESSION['type']=='Z' || $_SESSION['type']=='LD' )
				{
				?>
				 <td width="15%">
					<select name="branch_name" id="branch_name"  class="input_select_login"  style="width: 150px; ">
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
				<?php
				}
				?>
                <td class="width5"></td>
                 <td width="10%">
                        <select id="country" name="country" onchange="select_state(this.value)" style="width:150px" class="input_select" >
                        <option value="">Select Country</option>
                        <?php 
                        $sel_countries="select * from countries where 1";
                        $ptr_countries=mysql_query($sel_countries);
                        while($data_countries=mysql_fetch_array($ptr_countries))
                        {
                            $sel_c='';
                            if($_GET['country']==$data_countries['id'])
                            {	
                                $sel_c='selected="selected"';
                            }
                            ?>
                            <option <?php echo $sel_c; ?> value="<?php echo $data_countries['id'];?>"> <?php echo $data_countries['name'];?> </option>
                            <?php						
                        }?>
                        </select>
                    </td>
                    <td class="width5"></td>
                    <td width="10%" id="show_states">
                        <select id="state" name="state" onchange="select_city(this.value)" style="width:150px" class="input_select">
                            <option value="">Select State</option>
                            <?php
                            if($_REQUEST['state']!='')
                            {
                                $countrys='';
                                if($_REQUEST['country'])
                                {
                                    $countrys_ids=$_REQUEST['country'];
                                    $countrys=" and country_id='".$countrys_ids."'";
                                }
                                
                                $sel_state="select * from states where 1 ".$countrys."";
                                $ptr_states=mysql_query($sel_state);
                                while($state_data= mysql_fetch_array($ptr_states))
                                {
                                    $sel='';
                                    if($_REQUEST['state']==$state_data['id'])
                                    {
                                        $sel='selected="selected"';
                                    }
                                    echo '<option value="'.$state_data['id'].'" '.$sel.'>'.$state_data['name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td class="width5"></td>
                    <td width="10%" id="show_cities">
                        <select id="city" name="city" class="input_select" style="width:150px" onchange="select_area(this.value)">
                            <option value="">Select City</option>
                            <?php
                            if($_REQUEST['city']!='')
                            {
                                $country_id='';
                                if($_REQUEST['country'])
                                {
                                    $countrys=$_REQUEST['country'];
                                    $country_id=" and country_id='".$countrys."'";
                                }
                                $state_id='';
                                if($_REQUEST['state'])
                                {
                                    $stateid=$_REQUEST['state'];
                                    $state_id=" and state_id='".$stateid."'";
                                }
                                
                                $sel_city = "select * from cities where 1 ".$country_id." ".$state_id." ";
                                $ptr_city = mysql_query($sel_city);
                                while($city_data= mysql_fetch_array($ptr_city))
                                {
                                    $sel='';
                                    if($_REQUEST['city']==$city_data['id'])
                                    {
                                        $sel='selected="selected"';
                                    }
                                    echo '<option value="'.$city_data['id'].'" '.$sel.'>'.$city_data['name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td class="width5"></td>
                    <td width="10%" id="show_area">
                        <select id="area" name="area" class="input_select" style="width:150px">
                            <option value="">Select Area</option>
                            <?php
                            if($_REQUEST['area']!='')
                            {
                                
                                $state_id='';
                                if($_REQUEST['state'])
                                {
                                    $stateid=$_REQUEST['state'];
                                    $state_id=" and state_id='".$stateid."'";
                                }
                                $city_id='';
                                if($_REQUEST['city'])
                                {
                                    $city=$_REQUEST['city'];
                                    $city_id=" and city_id='".$city."'";
                                }
                                $sel_area = "select * from city_area where 1 ".$state_id." ".$city_id." ";
                                $ptr_area = mysql_query($sel_area);
                                while($area_data= mysql_fetch_array($ptr_area))
                                {
                                    $sel='';
                                    if($_REQUEST['area']==$area_data['id'])
                                    {
                                        $sel='selected="selected"';
                                    }
                                    echo '<option value="'.$area_data['area_id'].'" '.$sel.'>'.$area_data['area_name'].'</option>';
                                }
                            }
                            ?>
                        </select>
                 	</td>    
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
                            <td><input type="text" value="<?php //if($_REQUEST['keyword']!="Keyword") echo $_REQUEST['keyword'];?>" name="keyword" class="defaultText search_box" title="Keyword" /></td>
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
						$frm_date=explode("/",$_REQUEST['from_date']);
						$frm_dates=$frm_date[2]."-".$frm_date[1]."-".$frm_date[0];
						
						$pre_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						
						$installment_from_date=" and admission_date >='".date('Y-m-d',strtotime($frm_dates))."'";
						
						$enquiry_from_date=" and added_date >='".date('Y-m-d',strtotime($frm_dates))."'";
					 }
					else
					{
						$pre_from_date=""; 
						$enquiry_date="";
						$installment_from_date="";                           
					}
					
					if($_REQUEST['to_date']  && $_REQUEST['to_date']!="To Date")
					{
						 $to_date=explode("/",$_REQUEST['to_date']);
						$to_dates=$to_date[2]."-".$to_date[1]."-".$to_date[0];
						
						 $pre_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."'";
						
						$installment_to_date=" and admission_date<='".date('Y-m-d',strtotime($to_dates))."' ";
						
						$enquiery_to_date=" and added_date<='".date('Y-m-d',strtotime($to_dates))."'";
					}
					else
					{
						$pre_to_date="";
						$enquiery_to_date="";
						$installment_to_date="";
					}
					$search_cm_id='';
					$cm_ids=$_SESSION['cm_id'];
					if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD')
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
					
					$country='';
					if($_REQUEST['country'])
					{
						$country_id=$_REQUEST['country'];
						$country=" and country_id='".$country_id."'";
					}
					$state='';
					if($_REQUEST['state'])
					{
						$state_id=$_REQUEST['state'];
						$state=" and state_id='".$state_id."'";
					}
					$city='';
					if($_REQUEST['city'])
					{
						$city_id=$_REQUEST['city'];
						$city=" and city_id='".$city_id."'";
					}
					$area='';
					if($_REQUEST['area'])
					{
						$area_id=$_REQUEST['area'];
						$area=" and area_id='".$area_id."'";
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
						
					if($_REQUEST['city']!='')
					{
                        $select_directory='order by area_id asc';                      
						echo $sql_query="select * from city_area where city_id='".$_REQUEST['city']."' ".$area." ".$select_directory." ";
						$db=mysql_query($sql_query);
						$no_of_records=mysql_num_rows($db);
						
                        if($no_of_records)
                        {
                            $bgColorCounter=1;
                            //$_SESSION['show_records'] = 10;
                            $query_string='&keyword='.$keyword.'&branch_name='.$branch_name.'&city='.$city_id.'&area='.$area_id.'&from_date='.$_REQUEST['from_date'].'&to_date='.$_REQUEST['to_date'];
                            $query_string1=$query_string.$date_query;
                           	// $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],$_SESSION['show_records_pages'],$query_string1);
                            $pager = new PS_Pagination($sql_query,$_SESSION['show_records'],5,$query_string1);
                            $all_records= $pager->paginate();
                            ?>
    						<form method="post"  name="frmTakeAction"  action="<?php echo $_SERVER['PHP_SELF'].'?#msgbox';?>">
                                <input type="hidden" name="formAction" id="formAction" value=""/>
                                <tr class="grey_td" >
                                	<td width="10%" align="center"><strong>Sr. No.</strong></td>
                                    <td width="10%" align="center"><strong>Branch Name</strong></td>
                                    <td width="10%" align="center"><strong>City Name</strong></td>
                                    <td width="10%" align="center"><strong>Area Name</strong></td>
                                    <td width="10%" align="center"><strong>Not-Interested / Invalid Lead</strong></td>
                                    <td width="10%" align="center"><strong>Long Distance</strong></td>
                                    <td width="10%" align="center"><strong>High Fees</strong></td>
                                    <td width="10%" align="center"><strong>Joined Somewhere</strong></td>
                                    <td width="10%" align="center"><strong>Parents not allowed</strong></td>
                                    <td width="10%" align="center"><strong>Problem with Institute</strong></td>
                                    <td width="10%" align="center"><strong>Time Not match</strong></td>
                                    <td width="10%" align="center"><strong>Plan Cancel</strong></td>
                                </tr>
                                <?php
								
								while($val_query=mysql_fetch_array($all_records))
								{
									if($bgColorCounter%2==0)
										$bgcolor='class="grey_td"';
									else
										$bgcolor=""; 
									
									$listed_record_id=$val_query['student_id']; 
									include "include/paging_script.php";
									
									echo '<td align="center">'.$sr_no.'</td>'; 
									if($_REQUEST['banch_name']!='')
									{
										$branch_name=$_REQUEST['banch_name'];
									}
									else
										$branch_name='All';
									
									echo '<td align="center">'.$branch_name.'</td>';
									
									$sel_city="select name from cities where id='".$val_query['city_id']."'";
									$ptr_city=mysql_query($sel_city);
									$data_city=mysql_fetch_array($ptr_city);
									echo '<td align="center">'.$data_city['name'].'</td>';
									echo '<td align="center">'.$val_query['area_name'].'</td>';
									
									$sel_ni="select inquiry_id from inquiry where 1 and ( response='7' or response='8' ) ".$_SESSION['where']." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory." ";
									$ptr_ni=mysql_query($sel_ni);
									$ni_count=mysql_num_rows($ptr_ni);
									
									echo '<td align="center">'.$ni_count.'</td>';
									
									$sel_ni1="select inquiry_id from inquiry where 1 and ( response='7' or response='8' ) and response_reason='1' ".$_SESSION['where']." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory." ";
									$ptr_ni1=mysql_query($sel_ni1);
									$ni_count1=mysql_num_rows($ptr_ni1);
									echo '<td align="center">'.$ni_count1.'</td>';
									
									$sel_ni2="select inquiry_id from inquiry where 1 and ( response='7' or response='8' ) and response_reason='2' ".$_SESSION['where']." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory." ";
									$ptr_ni2=mysql_query($sel_ni2);
									$ni_count2=mysql_num_rows($ptr_ni2);
									echo '<td align="center">'.$ni_count2.'</td>';
									
									$sel_ni3="select inquiry_id from inquiry where 1 and ( response='7' or response='8' ) and response_reason='3' ".$_SESSION['where']." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory." ";
									$ptr_ni3=mysql_query($sel_ni3);
									$ni_count3=mysql_num_rows($ptr_ni3);
									echo '<td align="center">'.$ni_count3.'</td>';
									
									$sel_ni4="select inquiry_id from inquiry where 1 and ( response='7' or response='8' ) and response_reason='4' ".$_SESSION['where']." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory." ";
									$ptr_ni4=mysql_query($sel_ni4);
									$ni_count4=mysql_num_rows($ptr_ni4);
									echo '<td align="center">'.$ni_count4.'</td>';
									
									$sel_ni5="select inquiry_id from inquiry where 1 and ( response='7' or response='8' ) and response_reason='5' ".$_SESSION['where']." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory." ";
									$ptr_ni5=mysql_query($sel_ni5);
									$ni_count5=mysql_num_rows($ptr_ni5);
									echo '<td align="center">'.$ni_count5.'</td>';
									
									$sel_ni6="select inquiry_id from inquiry where 1 and ( response='7' or response='8' ) and response_reason='6' ".$_SESSION['where']." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory." ";
									$ptr_ni6=mysql_query($sel_ni6);
									$ni_count6=mysql_num_rows($ptr_ni6);
									echo '<td align="center">'.$ni_count6.'</td>';
									
									$sel_ni7="select inquiry_id from inquiry where 1 and ( response='7' or response='8' ) and response_reason='7' ".$_SESSION['where']." ".$country." ".$state." ".$city." ".$area." ".$search_cm_id." ".$enquiry_from_date." ".$enquiery_to_date." ".$select_directory." ";
									$ptr_ni7=mysql_query($sel_ni7);
									$ni_count7=mysql_num_rows($ptr_ni7);
									echo '<td align="center">'.$ni_count7.'</td>';
									echo '</tr>';
									$bgColorCounter++;
								}
								?>
                                <tr class="head_td">
                                    <td colspan="17">
                                        <table cellspacing="0" cellpadding="0" width="100%" >
                                            <tr>
                                            <?php
                                            if($no_of_records>10)
                                            {
                                                echo '<td width="3%" align="left">Show</td>
                                                <td width="20%" align="left"><select class="input_select_login" name="show_records" onchange="redirect(this.value)">';
                                                $show_records=array(0=>'10',1=>'20','50','100','200');
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
  							<?php 
						} 
					    else
        					echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">No records found related to your search criteria, please try again</div><br></td></tr>';
					}	
					else
        				echo '<tr><td class="text" align="center"><br><div class="msgbox" style="width:50%;">Please Select City Name first </div><br></td></tr>';	
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

<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage Stack Report</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
    <script type="text/javascript" src="../js/common.js"></script>
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <link rel="stylesheet" href="js/chosen.css" />
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
            $("#staff_id").chosen({allow_single_deselect:true});
			<?php 
			if($_SESSION['type']=="S")
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
function getstaffrecords() 
{ 
$('#loading_spinners').show();
	var staff_id = $("#staff_id").val();
	var start_date = $("#start_date").val();
	var end_date = $("#end_date").val();
	var branch_name = $("#branch_name").val();
	
	if(staff_id==''){
		alert("Please Select Staff");
		return false;
	}
	if(start_date==''){
		alert("Please Enter Start Date");
		return false;
	}
	if(end_date==''){
		alert("Please Enter End Date");
		return false;
	}
	
	/*$.ajax({ 
		type: 'post',
		url: 'stack_ajax.php',
		data: { staff_id: staff_id,start_date:start_date,end_date:end_date},
		
	}).done(function(responseData) {
	$("#show_stack_report").html(responseData);
	}).fail(function() {
		console.log('Failed');
	});*/
	var data1="staff_id="+staff_id+"&start_date="+start_date+"&end_date="+end_date+"&branch_name="+branch_name;	
	//alert(data1);
	$.ajax({
	url: "stack_ajax.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		//alert(html);
		if(html !='')
		{
			document.getElementById("show_stack_report").innerHTML=html;
			 $('#loading_spinners').hide();
		}
	},
    error:function(exception){alert('Exception:'+exception);}
	});
}
function getstaff(branch_id)
{
	var data1="action=stack_report&branch_id="+branch_id;	
	//alert(data1);
	$.ajax({
	url: "show_councellor.php", type: "post", data: data1, cache: false,
	success: function (html)
	{
		if(html !='')
		{
			//alert(html);
			document.getElementById("staff_details").innerHTML=html;
			$("#staff_id").chosen({allow_single_deselect:true});
		}
	},
    error:function(exception){alert('Exception:'+exception);}
	});
}
</script>
<style>
#loading_spinners { display:none; }
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
<?php
$sep_url_string='';
$sep_url= explode("?",$_SERVER['REQUEST_URI']);
if($sep_url[1] !='')
{
	$sep_url_string="&".$sep_url[1];
}
?> 
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="top_left"></td>
        <td class="top_mid" valign="bottom"><?php include "include/report_menu.php";?></td>
        <td class="top_right"></td>
      </tr>
    <tr>
        <td class="mid_left"></td>
        <td class="mid_mid" align="center">
        <img id="loading_spinners" src="images/loading.gif">
            <table cellspacing="0" cellpadding="0"  width="97%">
                <tr><td>
					<form method="post" name="jqueryForm" id="jqueryForm" enctype="multipart/form-data" >
					<table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr><td colspan="3" class="orange_font">* Mandatory Fields</td></tr>
                	<tr>
                    <?php 
                    if($_SESSION['type']=='S')
                    { ?>
                        <td style="width: 8%;">Select branch</td> 
                        <td colspan="2" align="left" style="padding-left:0px;width: 12%;">
                        <?php
                        $sel_branch = "SELECT * FROM branch where 1 order by branch_id asc ";	 
                        $query_branch = mysql_query($sel_branch);
                        $total_Branch = mysql_num_rows($query_branch);
                        echo '<select id="branch_name" name="branch_name" style="width:120px" onchange="getstaff(this.value)">';
                        while($row_branch = mysql_fetch_array($query_branch))
                        {
                            ?>
                            <option value="<?php if($_POST['branch_name']) echo $_POST['branch_name']; else echo $row_branch['branch_name']; ?>"> <?php echo $row_branch['branch_name']; ?></option>
                            <?php
                        }
                        echo '</select></td>';
                    }
                    else 
                    {
                        ?>
                        <td colspan="2" align="left">
                        <input type="hidden" name="branch_name" id="branch_name" value="<?php echo $_SESSION['branch_name']; ?>"  /> 
                        </td>
                        <?php 
                    }?>
                    <td width="10%" align="center"><strong>Select Staff</strong></td>
                    <td width="10%" align="center" style="padding-left:0px;width: 15%;" id="staff_details">
                    	<select name="staff_id" id="staff_id" class="input_select" style="width:150px">
                            <option value="">Select Staff</option>
                            <?php
                                $sle_name="select admin_id,name from site_setting where 1 ".$_SESSION['where']." and system_status='Enabled' and type='C' order by name asc"; 
                                $ptr_name=mysql_query($sle_name);
                                while($data_name=mysql_fetch_array($ptr_name))
                                {
                                    $selected='';
                                    if($data_name['admin_id'] == $_GET['assigned_to'])
                                    {
                                        $selected='selected="selected"';
                                    }
                                    echo '<option '.$selected.' value="'.$data_name['admin_id'].'">'.$data_name['name'].'</option>';
                                }
                                ?>
                        </select>
                    </td>
                    <td width="10%" align="center"><strong>Select From Date</strong></td>
                    <td width="10%" align="center"><input type="text" name="start_date" class="input_text datepicker" placeholder="From Date" readonly="1" id="start_date" title="From Date" value="<?php if($_REQUEST['start_date']!="From Date") echo $_REQUEST['start_date'];?>"></td>
                    <td width="10%" align="center"><strong>Select To Date</strong></td>
                    <td width="10%" align="center"><input type="text" name="end_date" class="input_text datepicker" placeholder="To Date" readonly="1" id="end_date"  title="To Date" value="<?php if($_REQUEST['end_date']!="To Date") echo $_REQUEST['end_date'];?>"></td>
                    <td width="10%" align="center"><input type="button" name="search" id="search" value="Search" onClick="getstaffrecords()" /></td>
                 	</tr>
            		</table>
            		</form> 
                	</td>
            	</tr>
        	</table>
            <table border="0" cellspacing="15" cellpadding="0" class="table" width="97%">
            	<tr>
                	<td><div id="show_stack_report"></div></td>
                </tr>
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

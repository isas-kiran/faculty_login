<?php include 'inc_classes.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
	jQuery(document).ready( function() {
		// binds form submission and fields to the validation engine
		jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
	});
    </script>
    <link rel="stylesheet" href="js/jquery.custom/development-bundle/themes/base/jquery.ui.all.css">
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/jquery.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>

    <script type="text/javascript">
    $(document).ready(function()
    {
        //$('.date-input-1').datepicker({ maxDate: "+0D",changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $('.date-input-1').datepicker({changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $('.date-input-2').datepicker({changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
        $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst) 
        {
            res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
        }
    });
    </script>
    <style>
	.left_border{ border-left:solid #999 1px; }
	.right_border{ border-right:solid #999 1px;}
	.right_border1{ border-right:solid #EFEFEF  1px;}
	.top_border{ border-top:solid #999 1px;}
	.bottom_border{ border-bottom:solid #999 1px;}
	body{ font-family:Verdana, Geneva, sans-serif}
	</style>
</head>
<body>
    <div class="heightSpacer"></div>
                        
<table align="center" >
                        <tr>
                        <td valign="top" width="185" height="100"><!--<img src="http://isasbeautyschool.com/wp-content/uploads/2015/04/logo.jpg"   title="Isasbeautyschool "/>--></td>
                        <td width="601" align="right" style="padding-right:15px;"><table width="99%">
       <?php 
	   if($_SESSION['type']=='S')
	   {
		   $sele_cm_id="select branch_name from site_setting where cm_id='2'";
		   $ptr_cm_id=mysql_query($sele_cm_id);
		   $data_cm_id=mysql_fetch_array($ptr_cm_id);
		   
		   $select_branch_address="select branch_address from branch where branch_name='Pune'";
		   $pte_branch_name=mysql_query($select_branch_address);
		   $data_branch_name=mysql_fetch_array($pte_branch_name);
		   
		   //echo $data_branch_name['branch_address'];
		}
		else
		{
	   		//echo $_SESSION['branch_address'];
        }
		?>
        </table>
        <td valign="top">
        <?php
		 if($_GET['action'] !='print' && $_GET['for']!='email')
		 {
		 ?>
        <a href="invoice-generate.php?record_id=<?php echo $record_id ?>&action=print" style="text-decoration:none"><input type="button" name="print" value="Print" /></a>
        <?php } ?>
        </td>
        </td>
        </tr>
                   				  
		</table>
            <table align="center" border="0" width="786" cellpadding="0" >
			<tr><td colspan="4"><h3 align="center"><font size="+1">This certicate regarding of best beautician in isas</font></h3></td></tr>
			<tr><td colspan="4"><h3 align="center"><font size="+1">Name -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for A+ grade</font></h3></td></tr>
			</table>
    </table>
                       
                                                
            <?php
			if($_GET['action']=='print' )
			{
			?>
			<script language="javascript">
			
			window.print();
			//window.close();
			setTimeout('window.close();',3000);
			//setTimeout('window.close();',5000);
			</script>
			<?php	
			}							
			?>
			</body>
			</html>
			<?php $db->close();?>

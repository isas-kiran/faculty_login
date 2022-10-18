<?php include 'inc_classes.php';
 ?>
<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	
     <script type="text/javascript">
      
    $(document).ready(function()
	{  
		var currentDate = new Date();
	
		$('.datepicker').datepicker({ changeMonth: true, dateFormat:'dd/mm/yy',changeYear: true, showButtonPanel: true, closeText: 'Clear'});
	
	});
</script>
<?php 
$insta=$_POST['no_of_installments'];
$advance_payment=$_POST['advance_payment'];
$i_amount=$advance_payment/$insta;
if($_POST['id']) {
				   $select_event= "select * from pr_advance_installments where staff_advance_salary_id = '".$_POST['id']."' "; 
				   $val_event = $db->fetch_array($db->query($select_event));
				  } 
for($i=1;$i<=$insta;$i++)
{
	
	?>
	<tr style="padding-bottom:10px;">
<td style="padding-left:10px;width: 207px;"><text style="padding-left:13px;">Installment Number <?php echo $i; ?></text></td>
<td><input style="margin-left: 115px;" type="text" id="i_amount<?php echo $i; ?>" name="i_amount<?php echo $i; ?>" value="<?php echo  number_format((float)$i_amount, 2, '.', ''); ?>"></td>
<td style="padding-left:20px;padding-right:20px;"><text style="padding-left:20px;padding-right:10px;"> Date <?php echo $i; ?>  </text> </td>
<td><input style="width:150px;" class="input_text datepicker" required id="i_date<?php echo $i; ?>" name="i_date<?php echo $i; ?>" type="text" value="<?php echo $val_event['i_date']; ?>"/></td>
</br>

</tr>
</br>
<?php } ?>


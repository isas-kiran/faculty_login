<?php $page_name = basename($_SERVER['PHP_SELF']); ?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php
   if($_SESSION['type'] =='S')
   {
	   ?>
       <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_exam.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_exam.php" style="color:#7CA32F;">Manage Exam  </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_exam.php" style="color:#666666;">Manage Exam </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
</table>
</td>
<td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'add_exam.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_exam.php" style="color:#7CA32F;">Add Exam </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_exam.php" style="color:#666666;">Add Exam </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
        
    <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'manage_paper.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_paper.php" style="color:#7CA32F;">Manage Question Paper</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_paper.php" style="color:#666666;">Manage Question Paper </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    
     <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'create_paper.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="create_paper.php" style="color:#7CA32F;">Add Question Paper</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="create_paper.php" style="color:#666666;">Add Question Paper </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'manage_question.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_question.php" style="color:#7CA32F;">Manage Subject Questions</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_question.php" style="color:#666666;">Manage Subject Questions </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    
     <td class="width5"></td>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'create_question.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="create_question.php" style="color:#7CA32F;">Add Subject Questions</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="create_question.php" style="color:#666666;">Add Subject Questions </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
       <?php
   }
   else
   {
	$array_prev=$_SESSION['privilege_id']; // array for privillage
	$array_previ_parent= $_SESSION['privilege_id_parent'];
  	
	for($e=0;$e<count($array_previ_parent);$e++)
    {
        if($array_previ_parent[$e]['privilege_id']==5) //'for only change password'
        {
			for($f=0;$f<count($array_prev[$e]);$f++)
			{ 
				if($array_prev[$e][$f]['privilege_id']==48)
				{
			?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php 
            if($page_name =='manage_exam.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_exam.php" style="color:#7CA32F;">Manage Exam  </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_exam.php" style="color:#666666;">Manage Exam </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            
            ?>
</table>
</td>
<td class="width5"></td>
<?php
	}
	else if($array_prev[$e][$f]['privilege_id']==49)
	{
	?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'add_exam.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="add_exam.php" style="color:#7CA32F;">Add Exam </a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="add_exam.php" style="color:#666666;">Add Exam </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
        
    <td class="width5"></td>
<?php
					}
					else if($array_prev[$e][$f]['privilege_id']==52)
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'manage_paper.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_paper.php" style="color:#7CA32F;">Manage Question Paper</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_paper.php" style="color:#666666;">Manage Question Paper </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    
     <td class="width5"></td>
     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==53)
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'create_paper.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="create_paper.php" style="color:#7CA32F;">Add Question Paper</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="create_paper.php" style="color:#666666;">Add Question Paper </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    <td class="width5"></td>
    <?php
		}
		else if($array_prev[$e][$f]['privilege_id']==50)
		{
		?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'manage_question.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="manage_question.php" style="color:#7CA32F;">Manage Subject Questions</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="manage_question.php" style="color:#666666;">Manage Subject Questions </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    
     <td class="width5"></td>
     <?php
					}
					else if($array_prev[$e][$f]['privilege_id']==51)
					{
					?>
    <td>
	<table border="0" cellspacing="0" cellpadding="0">
            <?php
  if($page_name == 'create_question.php')
            {
            ?>
            <tr>
                <td class="tab2_left"></td>
                <td class="tab2_mid"><a href="create_question.php" style="color:#7CA32F;">Add Subject Questions</a></td>
                <td class="tab2_right"></td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td class="tab_left"></td>
                <td class="tab_mid"><a href="create_question.php" style="color:#666666;">Add Subject Questions </a></td>
                <td class="tab_right"></td>
            </tr>
            <?php
            }
            ?>
</table>
	</td>
    
<?php
					}
			}
		}
	}
   }
					?>
  </tr>
</table>
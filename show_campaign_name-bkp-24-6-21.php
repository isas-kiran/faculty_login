<?php include 'inc_classes.php';
$branch_id=$_REQUEST['branch_name'];
$action=$_POST['action'];
if($action=='add_lead')
{
    ?>
    <select id="enquiry_src" name="enquiry_src" class="input_select">
    <option value="">--Select Enquiry Source Name--</option>
    <?php
    $course_category = "select DISTINCT(cm_id),branch_name from site_setting where branch_name='".$branch_id."' ";
    $ptr_course_cat = mysql_query($course_category);
    $data_cat = mysql_fetch_array($ptr_course_cat);
        echo "<optgroup label='".$data_cat['branch_name']."'>";
        $sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute' and status='Active' order by campaign_name asc";
        $ptr_src=mysql_query($sel_source);
        while($data_src=mysql_fetch_array($ptr_src))
        {
            $sele_source="";
            if($data_src['campaign_id'] == $row_record['enquiry_source'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
            {
                $sele_source='selected="selected"';
            }
            ?>
            <option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($enquiry_src) && $enquiry_src == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
            <?
        }
        echo "</optgroup>";
    ?>
    </select>
    <?php
}
else
{
    ?>
    <select id="enquiry_src" name="enquiry_src" class="input_select">
    <option value="">--Select Enquiry Source Name--</option>
    <?php
    $course_category = "select DISTINCT(cm_id),branch_name from site_setting where branch_name='".$branch_id."' ";
    $ptr_course_cat = mysql_query($course_category);
    $data_cat = mysql_fetch_array($ptr_course_cat);

        echo "<optgroup label='".$data_cat['branch_name']."'>";
        $sel_source="SELECT * FROM campaign where 1 and cm_id='".$data_cat['cm_id']."' and campaign_for='institute' and c_id>0 and status='Active' order by campaign_name asc";
        $ptr_src=mysql_query($sel_source);
        while($data_src=mysql_fetch_array($ptr_src))
        {
            $sele_source="";
            if($data_src['campaign_id'] == $row_record['enquiry_source'] || $_POST['enquiry_src']== $data_src['campaign_id'] )
            {
                $sele_source='selected="selected"';
            }
            ?>
            <option <?php echo $sele_source?> value ="<?php echo $data_src['campaign_id']?>" <? if (isset($enquiry_src) && $enquiry_src == $data_src['campaign_name']) echo "selected";?> > <?php echo $data_src['campaign_name'] ?> </option>
            <?
        }
        echo "</optgroup>";
    ?>
    </select>
    <?php
}
?>
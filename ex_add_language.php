<?php include 'ex_inc_classes.php';?>
<?php include "ex_admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM ex_language where language_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php if($record_id) echo "Edit"; else echo "Add";?>
Language</title>
<?php include "ex_include/headHeader.php";?>
<?php include "ex_include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
    </script>
    
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
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
        });
    </script>
    <script>
/*function show_subject(subject)
		{
//alert(subject);
var data1="show_subject=1&subject="+subject;
 $.ajax({
url: "show_subjects.php", type: "post", data: data1, cache: false,
success: function (html)
{
 document.getElementById('show_subject').innerHTML=html;
}
});
		}*/
	</script> 
    <script type="text/javascript">

   function changeFunc(id) {
//	alert(id);
    var language=id.split('_');
	var lang_code=language[1];
	document.getElementById('language_code').innerHTML=lang_code;
	 //$("#total_quations").val($("#totla_q_"+unit_id).val());
	// alert()
	 /*$.ajax({
		 url: "show_report.php", type: "post", data: course, chache:false,
		 success: function (chapters)
		 {
			 document.getElementById('show_report').innerHTML=chapters;
		 }
	 });*/
   }

  </script>
<script type="text/javascript">
        function OnSelectionChange (select) {
            var selectedOption = select.options[select.selectedIndex];
			var language=selectedOption.value.split('_');
			var lang_code=language[1];
			document.getElementById('language_code').value=lang_code;
        }
</script>
    
<script>
function validin()
{
	frm=document.jqueryForm;
	disp_error="Please Correct Following errors\n\n";
	error="";
	
	if(frm.language_name.value=='')
	{
		disp_error +="Enter Language Name\n";
		document.getElementById('language_name').style.border = '1px solid #f00';
		frm.language_name.focus();
		error="yes";
	}
	if(frm.country_name.value=='')
	{
		disp_error +="Select Country Name\n";
		document.getElementById('country_name').style.border = '1px solid #f00';
		frm.country_name.focus();
		error="yes";
	}
	if(frm.language_code.value=='')
	{
		disp_error +="Enter Language Code\n";
		document.getElementById('language_code').style.border = '1px solid #f00';
		frm.language_code.focus();
		error="yes";
	}
	if(error=="yes")
	{
		alert(disp_error);
		return false;
	}
	else
	return true;
	
}
</script>    
    
</head>
<body>
<?php include "include/header.php";?>
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
    <td class="top_mid" valign="bottom"><?php include "ex_include/language_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">
            
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
                            $language_name=$_POST['language_name'];
                            $country_name=$_POST['country_name'];
                            $language_code=$_POST['language_code'];
							$description=$_POST['description'];
							
							$where_id='';
							if($_REQUEST['record_id'])
							{
								$where_id="and language_id !='".$record_id."'";
							}
							$sele_lang="select language_name from ex_language where language_name='".$language_name."' ".$where_id." ";
							$ptr_lang=mysql_query($sele_lang);
							$data_lang=mysql_fetch_array($ptr_lang);
							
							$sele_langc="select language_code from ex_language where language_code='".$language_code."' ".$where_id."";
							$ptr_langc=mysql_query($sele_langc);
							$data_langc=mysql_fetch_array($ptr_langc);
							
							if($data_lang['language_name'])
							{
								$success=0;
                                $errors[$i++]="You entered language name is alreay exist. ";
							}
							
							if($data_langc['language_code'])
							{
								$success=0;
                                $errors[$i++]="You entered Language code is alreay exist. ";
							}
                            if($language_name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter Language name ";
                            }
							
                            if(count($errors))
                            {
                                ?>
            <tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                         </td></tr>   <br></br>  
                                <?php
                            }
                            else
                            {
                                $success=1;
								 
                                $data_record['language_name'] =$language_name;
                                $data_record['country_name'] =$country_name; 
                                $data_record['description'] = $description;
								$data_record['language_code'] =$language_code;
                               if($record_id)
                                {
									/*$where_record=" exam_id='".$record_id."'";
                                    $db->query_update("exam1", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
									*/
                                    $where_record="language_id='".$record_id."'";
                                    $db->query_update("ex_language", $data_record,$where_record) ;
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $record_id=$db->query_insert("ex_language", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" name="jqueryForm" enctype="multipart/form-data">
            <table border="0" cellspacing="15" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="3" class="orange_font">* Mandatory Fields</td>
                    </tr>
                   
            <tr><td>
        
                    <tr>
                       <td valign="top">Language Name<span class="orange_font">*</span></td>
                        <td style=""><input type="text"  class=" input_text" name="language_name" id="language_name" value="<?php if ($_POST['save_changes']) echo $_POST['language_name']; else echo $row_record['language_name']; ?>" /></td> 
                    
                    
                        
                    </tr>
                                        <!--<tr>
            	<td></td>
            	<td>
                	 <div id="student_div" >
                     </div>
                </td>
            </tr>-->
                    <tr>
                        <td width="20%">Select Country<span class="orange_font"></span></td>
                                        <td width="40%" style="">
                                        <select name="country_name" id="country_name" class="input_text" onchange="OnSelectionChange (this)">
                                        <option  value="">----Select----</option>
                                      
                                         <option value="Afghanistan_AF" <?php if (isset($country_name) && $country_name == "Afghanistan_AF") echo "selected"; elseif( 'Afghanistan_AF' == $row_record['country_name']) echo "selected";?>>Afghanistan(AF)</option>
<option value="Aland-Islands_AX" <?php if (isset($country_name) && $country_name == "Aland-Islands_AX") echo "selected"; elseif( 'Aland-Islands_AX' == $row_record['country_name']) echo "selected";?>>Aland Islands(AX)</option>
<option value="Albania_AL" <?php if (isset($country_name) && $country_name == "Albania_AL") echo "selected"; elseif( 'Albania_AL' == $row_record['country_name']) echo "selected";?>>Albania(AL)</option>
<option value="Algeria_DZ" <?php if (isset($country_name) && $country_name == "Algeria_DZ") echo "selected"; elseif( 'Algeria_DZ' == $row_record['country_name']) echo "selected";?>>Algeria(DZ)</option>
<option value="American-Samoa_AS" <?php if (isset($country_name) && $country_name == "American-Samoa_AS") echo "selected"; elseif( 'American-Samoa_AS' == $row_record['country_name']) echo "selected";?>>American Samoa(AS)</option>
<option value="Andorra_AD" <?php if (isset($country_name) && $country_name == "Andorra_AD") echo "selected"; elseif( 'Andorra_AD' == $row_record['country_name']) echo "selected";?>>Andorra(AD)</option>
<option value="Angola_AO" <?php if (isset($country_name) && $country_name == "Angola_AO") echo "selected"; elseif( 'Angola_AO' == $row_record['country_name']) echo "selected";?>>Angola(AO)</option>
<option value="Anguilla_AI" <?php if (isset($country_name) && $country_name == "Anguilla_AI") echo "selected"; elseif( 'Anguilla_AI' == $row_record['country_name']) echo "selected";?>>Anguilla(AI)</option>
<option value="Antarctica_AQ" <?php if (isset($country_name) && $country_name == "Antarctica_AQ") echo "selected"; elseif( 'Antarctica_AQ' == $row_record['country_name']) echo "selected";?>>Antarctica(AQ)</option>
<option value="Antigua-and-Barbuda_AG" <?php if (isset($country_name) && $country_name == "Antigua-and-Barbuda_AG") echo "selected"; elseif( 'Antigua-and-Barbuda_AG' == $row_record['country_name']) echo "selected";?>>Antigua-and-Barbuda(AG)</option>
<option value="Argentina_AR" <?php if (isset($country_name) && $country_name == "Argentina_AR") echo "selected"; elseif( 'Argentina_AR' == $row_record['country_name']) echo "selected";?>>Argentina(AR)</option>
<option value="Armenia_AM" <?php if (isset($country_name) && $country_name == "Armenia_AM") echo "selected"; elseif( 'Armenia_AM' == $row_record['country_name']) echo "selected";?>>Armenia(AM)</option>
<option value="Aruba_AW" <?php if (isset($country_name) && $country_name == "Aruba_AW") echo "selected"; elseif( 'Aruba_AW' == $row_record['country_name']) echo "selected";?>>Aruba(AW)</option>
<option value="Australia_AU" <?php if (isset($country_name) && $country_name == "Australia_AU") echo "selected"; elseif( 'Australia_AU' == $row_record['country_name']) echo "selected";?>>Australia(AU)</option>
<option value="Austria_AT" <?php if (isset($country_name) && $country_name == "Austria_AT") echo "selected"; elseif( 'Austria_AT' == $row_record['country_name']) echo "selected";?>>Austria(AT)</option>
<option value="Azerbaijan_AZ" <?php if (isset($country_name) && $country_name == "Azerbaijan_AZ") echo "selected"; elseif( 'Azerbaijan_AZ' == $row_record['country_name']) echo "selected";?>>Azerbaijan(AZ)</option>
<option value="Bahamas_BS" <?php if (isset($country_name) && $country_name == "Bahamas_BS") echo "selected"; elseif( 'Bahamas_BS' == $row_record['country_name']) echo "selected";?>>Bahamas(BS)</option>
<option value="Bahrain_BH" <?php if (isset($country_name) && $country_name == "Bahrain_BH") echo "selected"; elseif( 'Bahrain_BH' == $row_record['country_name']) echo "selected";?>>Bahrain(BH)</option>
<option value="Bangladesh_BD" <?php if (isset($country_name) && $country_name == "Bangladesh_BD") echo "selected"; elseif( 'Bangladesh_BD' == $row_record['country_name']) echo "selected";?>>Bangladesh(BD)</option>
<option value="Barbados_BB" <?php if (isset($country_name) && $country_name == "Barbados_BB") echo "selected"; elseif( 'Barbados_BB' == $row_record['country_name']) echo "selected";?>>Barbados(BB)</option>
<option value="Belarus_BY" <?php if (isset($country_name) && $country_name == "Belarus_BY") echo "selected"; elseif( 'Belarus_BY' == $row_record['country_name']) echo "selected";?>>Belarus(BY)</option>
<option value="Belgium_BE" <?php if (isset($country_name) && $country_name == "Belgium_BE") echo "selected"; elseif( 'Belgium_BE' == $row_record['country_name']) echo "selected";?>>Belgium(BE)</option>
<option value="Belize_BZ" <?php if (isset($country_name) && $country_name == "Belize_BZ") echo "selected"; elseif( 'Belize_BZ' == $row_record['country_name']) echo "selected";?>>Belize(BZ)</option>
<option value="Benin_BJ" <?php if (isset($country_name) && $country_name == "Benin_BJ") echo "selected"; elseif( 'Benin_BJ' == $row_record['country_name']) echo "selected";?>>Benin(BJ)</option>
<option value="Bermuda_BM" <?php if (isset($country_name) && $country_name == "Bermuda_BM") echo "selected"; elseif( 'Bermuda_BM' == $row_record['country_name']) echo "selected";?>>Bermuda(BM)</option>
<option value="Bhutan_BT" <?php if (isset($country_name) && $country_name == "Bhutan_BT") echo "selected"; elseif( 'Bhutan_BT' == $row_record['country_name']) echo "selected";?>>Bhutan(BT)</option>
<option value="Bolivia_BO" <?php if (isset($country_name) && $country_name == "Bolivia_BO") echo "selected"; elseif( 'Bolivia_BO' == $row_record['country_name']) echo "selected";?>>Bolivia(BO)</option>
<option value="Bosnia-and-Herzegovina_BA" <?php if (isset($country_name) && $country_name == "Bosnia-and-Herzegovina_BA") echo "selected"; elseif( 'Bosnia-and-Herzegovina_BA' == $row_record['country_name']) echo "selected";?>>Bosnia-and-Herzegovina(BA)</option>
<option value="Botswana_BW" <?php if (isset($country_name) && $country_name == "Botswana_BW") echo "selected"; elseif( 'Botswana_BW' == $row_record['country_name']) echo "selected";?>>Botswana(BW)</option>
<option value="Bouvet-Island_BV" <?php if (isset($country_name) && $country_name == "Bouvet-Island_BV") echo "selected"; elseif( 'Bouvet-Island_BV' == $row_record['country_name']) echo "selected";?>>Bouvet-Island(BV)</option>
<option value="Brazil_BR" <?php if (isset($country_name) && $country_name == "Brazil_BR") echo "selected"; elseif( 'Brazil_BR' == $row_record['country_name']) echo "selected";?>>Brazil(BR)</option>
<option value="Britis- Indian-Ocean-Territory_IO" <?php if (isset($country_name) && $country_name == "Britis- Indian-Ocean-Territory_IO") echo "selected"; elseif( 'Britis- Indian-Ocean-Territory_IO' == $row_record['country_name']) echo "selected";?>>Britis- Indian-Ocean-Territory(IO)</option>
<option value="Brunei Darussalam_BN" <?php if (isset($country_name) && $country_name == "Brunei Darussalam_BN") echo "selected"; elseif( 'Brunei Darussalam_BN' == $row_record['country_name']) echo "selected";?>>Brunei Darussalam(BN)</option>
<option value="Bulgaria_BG" <?php if (isset($country_name) && $country_name == "Bulgaria_BG") echo "selected"; elseif( 'Bulgaria_BG' == $row_record['country_name']) echo "selected";?>>Bulgaria(BG)</option>
<option value="Burkina-Faso_BF" <?php if (isset($country_name) && $country_name == "Burkina-Faso_BF") echo "selected"; elseif( 'Burkina-Faso_BF' == $row_record['country_name']) echo "selected";?>>Burkina-Faso(BF)</option>
<option value="Burundi_BI" <?php if (isset($country_name) && $country_name == "Burundi_BI") echo "selected"; elseif( 'Burundi_BI' == $row_record['country_name']) echo "selected";?>>Burundi(BI)</option>
<option value="Cambodiai_KH" <?php if (isset($country_name) && $country_name == "Cambodiai_KH") echo "selected"; elseif( 'Cambodiai_KH' == $row_record['country_name']) echo "selected";?>>Cambodiai(KH)</option>
<option value="Cameroon_CM" <?php if (isset($country_name) && $country_name == "Cameroon_CM") echo "selected"; elseif( 'Cameroon_CM' == $row_record['country_name']) echo "selected";?>>Cameroon(CM)</option>
<option value="Canada_CA" <?php if (isset($country_name) && $country_name == "Canada_CA") echo "selected"; elseif( 'Canada_CA' == $row_record['country_name']) echo "selected";?>>Canada(CA)/option>
<option value="Cape-Verde_CV" <?php if (isset($country_name) && $country_name == "Cape-Verde_CV") echo "selected"; elseif( 'Cape-Verde_CV' == $row_record['country_name']) echo "selected";?>>Cape-Verde(CV)</option>
<option value="Cayman-Islands_KY" <?php if (isset($country_name) && $country_name == "Cayman-Islands_KY") echo "selected"; elseif( 'Cayman-Islands_KY' == $row_record['country_name']) echo "selected";?>>Cayman-Islands(KY)</option>
<option value="Central-African-Republic_CF" <?php if (isset($country_name) && $country_name == "Central-African-Republic_CF") echo "selected"; elseif( 'Central-African-Republic_CF' == $row_record['country_name']) echo "selected";?>>Central-African-Republic(CF)</option>
<option value="Chad_TD" <?php if (isset($country_name) && $country_name == "Chad_TD") echo "selected"; elseif( 'Chad_TD' == $row_record['country_name']) echo "selected";?>>Chad(TD)</option>
<option value="Chile_CL" <?php if (isset($country_name) && $country_name == "Chile_CL") echo "selected"; elseif( 'Chile_CL' == $row_record['country_name']) echo "selected";?>>Chile(CL)</option>
<option value="China_CN" <?php if (isset($country_name) && $country_name == "China_CN") echo "selected"; elseif( 'China_CN' == $row_record['country_name']) echo "selected";?>>China(CN)</option>
<option value="Christmas-Island_Cx" <?php if (isset($country_name) && $country_name == "Christmas-Island_Cx") echo "selected"; elseif( 'Christmas-Island_Cx' == $row_record['country_name']) echo "selected";?>>Christmas-Island(Cx)</option>
<option value="Cocos-(Keeling)-Islands_CC" <?php if (isset($country_name) && $country_name == "Cocos-(Keeling)-Islands_CC") echo "selected"; elseif( 'Cocos-(Keeling)-Islands_CC' == $row_record['country_name']) echo "selected";?>>Cocos-(Keeling)-Islands(CC)</option>
<option value="Colombia_CO" <?php if (isset($country_name) && $country_name == "Colombia_CO") echo "selected"; elseif( 'Colombia_CO' == $row_record['country_name']) echo "selected";?>>Colombia(CO)</option>
<option value="Comoros_KM" <?php if (isset($country_name) && $country_name == "Comoros_KM") echo "selected"; elseif( 'Comoros_KM' == $row_record['country_name']) echo "selected";?>>Comoros(KM)</option>
<option value="Congo_CG" <?php if (isset($country_name) && $country_name == "Congo_CG") echo "selected"; elseif( 'Congo_CG' == $row_record['country_name']) echo "selected";?>>Congo(CG)</option>
<option value="Congo-The Democratic Republic of The_CD" <?php if (isset($country_name) && $country_name == "Congo-The Democratic Republic of The_CD") echo "selected"; elseif( 'Congo-The Democratic Republic of The_CD' == $row_record['country_name']) echo "selected";?>>Congo-The Democratic Republic of The(CD)</option>
<option value="Cook-Islands_CK" <?php if (isset($country_name) && $country_name == "Cook-Islands_CK") echo "selected"; elseif( 'Cook-Islands_CK' == $row_record['country_name']) echo "selected";?>>Cook-Islands(CK)</option>
<option value="Costa-Rica_CR" <?php if (isset($country_name) && $country_name == "Costa-Rica_CR") echo "selected"; elseif( 'Costa-Rica_CR' == $row_record['country_name']) echo "selected";?>>Costa-Rica(CR)</option>
<option value="Cote-Divoire_CI" <?php if (isset($country_name) && $country_name == "Cote-Divoire_CI") echo "selected"; elseif('Cote-Divoire_CI' == $row_record['country_name']) echo "selected";?>>Cote-Divoire(CI)</option>
<option value="Croatia_HR" <?php if (isset($country_name) && $country_name == "Croatia_HR") echo "selected"; elseif( 'Croatia_HR' == $row_record['country_name']) echo "selected";?>>Croatia(HR)</option>
<option value="Cuba_CU" <?php if (isset($country_name) && $country_name == "Cuba_CU") echo "selected"; elseif( 'Cuba_CU' == $row_record['country_name']) echo "selected";?>>Cuba(CU)</option>
<option value="Cyprus_CY" <?php if (isset($country_name) && $country_name == "Cyprus_CY") echo "selected"; elseif( 'Cyprus_CY' == $row_record['country_name']) echo "selected";?>>Cyprus(CY)</option>
<option value="Czech-Republic_CZ" <?php if (isset($country_name) && $country_name == "Czech-Republic_CZ") echo "selected"; elseif( 'Czech-Republic_CZ' == $row_record['country_name']) echo "selected";?>>Czech-Republic(CZ)</option>
<option value="Denmark_DK" <?php if (isset($country_name) && $country_name == "Denmark_DK") echo "selected"; elseif( 'Denmark_DK' == $row_record['country_name']) echo "selected";?>>Denmark(DK)</option>
<option value="Djibouti_DJ" <?php if (isset($country_name) && $country_name == "Djibouti_DJ") echo "selected"; elseif( 'Djibouti_DJ' == $row_record['country_name']) echo "selected";?>>Djibouti(DJ)</option>
<option value="Dominica_DM" <?php if (isset($country_name) && $country_name == "Dominica_DM") echo "selected"; elseif( 'Dominica_DM' == $row_record['country_name']) echo "selected";?>>Dominica(DM)</option>
<option value="Dominican-Republic_DO" <?php if (isset($country_name) && $country_name == "Dominican-Republic_DO") echo "selected"; elseif( 'Dominican-Republic_DO' == $row_record['country_name']) echo "selected";?>>Dominican-Republic(DO)</option>
<option value="Ecuador_EC" <?php if (isset($country_name) && $country_name == "Ecuador_EC") echo "selected"; elseif( 'Ecuador_EC' == $row_record['country_name']) echo "selected";?>>Ecuador(EC)</option>
<option value="Egyptr_EG" <?php if (isset($country_name) && $country_name == "Egyptr_EG") echo "selected"; elseif( 'Egyptr_EG' == $row_record['country_name']) echo "selected";?>>Egyptr(EG)</option>
<option value="El-Salvador_SV" <?php if (isset($country_name) && $country_name == "El-Salvador_SV") echo "selected"; elseif( 'El-Salvador_SV' == $row_record['country_name']) echo "selected";?>>El-Salvador(SV)</option>
<option value="Equatoria- Guinea_GQ" <?php if (isset($country_name) && $country_name == "Equatoria- Guinea_GQ") echo "selected"; elseif( 'Equatoria- Guinea_GQ' == $row_record['country_name']) echo "selected";?>>Equatoria- Guinea(GQ)</option>
<option value="Eritrea_ER" <?php if (isset($country_name) && $country_name == "Eritrea_ER") echo "selected"; elseif( 'Eritrea_ER' == $row_record['country_name']) echo "selected";?>>Eritrea(ER)</option>
<option value="Estonia_EE" <?php if (isset($country_name) && $country_name == "Estonia_EE") echo "selected"; elseif( 'Estonia_EE' == $row_record['country_name']) echo "selected";?>>Estonia(EE)</option>
<option value="Ethiopia_ET" <?php if (isset($country_name) && $country_name == "Ethiopia_ET") echo "selected"; elseif( 'Ethiopia_ET' == $row_record['country_name']) echo "selected";?>>Ethiopia(ET)</option>
<option value="Falkland-Islands(Malvinas)_FK" <?php if (isset($country_name) && $country_name == "Falkland-Islands(Malvinas)_FK") echo "selected"; elseif( 'Falkland-Islands(Malvinas)_FK' == $row_record['country_name']) echo "selected";?>>Falkland-Islands(Malvinas)(FK)</option>
<option value="Faroe-Islands_FO" <?php if (isset($country_name) && $country_name == "Faroe-Islands_FO") echo "selected"; elseif( 'Faroe-Islands_FO' == $row_record['country_name']) echo "selected";?>>Faroe-Islands(FO)</option>
<option value="Fiji_FJ" <?php if (isset($country_name) && $country_name == "Fiji_FJ") echo "selected"; elseif( 'Fiji_FJ' == $row_record['country_name']) echo "selected";?>>Fiji(FJ)</option>
<option value="Finland_FI" <?php if (isset($country_name) && $country_name == "Finland_FI") echo "selected"; elseif( 'Finland_FI' == $row_record['country_name']) echo "selected";?>>Finland(FI)</option>
<option value="France_FR" <?php if (isset($country_name) && $country_name == "France_FR") echo "selected"; elseif( 'France_FR' == $row_record['country_name']) echo "selected";?>>France(FR)</option>
<option value="French-Guiana_GF" <?php if (isset($country_name) && $country_name == "French-Guiana_GF") echo "selected"; elseif( 'French-Guiana_GF' == $row_record['country_name']) echo "selected";?>>French-Guiana(GF)</option>
<option value="French-Polynesia_PF" <?php if (isset($country_name) && $country_name == "French-Polynesia_PF") echo "selected"; elseif( 'French-Polynesia_PF' == $row_record['country_name']) echo "selected";?>>French-Polynesia(PF)</option>
<option value="French-Southern-Territories_TF" <?php if (isset($country_name) && $country_name == "French-Southern-Territories_TF") echo "selected"; elseif( 'French-Southern-Territories_TF' == $row_record['country_name']) echo "selected";?>>French-Southern-Territories(TF)</option>
<option value="Gabon_GA" <?php if (isset($country_name) && $country_name == "Gabon_GA") echo "selected"; elseif( 'Gabon_GA' == $row_record['country_name']) echo "selected";?>>Gabon(GA)</option>
<option value="Gambia_GM" <?php if (isset($country_name) && $country_name == "Gambia_GM") echo "selected"; elseif( 'Gambia_GM' == $row_record['country_name']) echo "selected";?>>Gambia(GM)</option>
<option value="Georgia_GE" <?php if (isset($country_name) && $country_name == "Georgia_GE") echo "selected"; elseif( 'Georgia_GE' == $row_record['country_name']) echo "selected";?>>Georgia(GE)</option>
<option value="Germany_DE" <?php if (isset($country_name) && $country_name == "Germany_DE") echo "selected"; elseif( 'Germany_DE' == $row_record['country_name']) echo "selected";?>>Germany(DE)</option>
<option value="Ghana_GH" <?php if (isset($country_name) && $country_name == "Ghana_GH") echo "selected"; elseif( 'Ghana_GH' == $row_record['country_name']) echo "selected";?>>Ghana(GH)</option>
<option value="Gibraltar_GI" <?php if (isset($country_name) && $country_name == "Gibraltar_GI") echo "selected"; elseif( 'Gibraltar_GI' == $row_record['country_name']) echo "selected";?>>Gibraltar(GI)</option>
<option value="Greece_GR" <?php if (isset($country_name) && $country_name == "Greece_GR") echo "selected"; elseif( 'Greece_GR' == $row_record['country_name']) echo "selected";?>>Greece(GR)</option>
<option value="Greenland_GL" <?php if (isset($country_name) && $country_name == "Greenland_GL") echo "selected"; elseif( 'Greenland_GL' == $row_record['country_name']) echo "selected";?>>Greenland(GL)</option>
<option value="Grenada_GD" <?php if (isset($country_name) && $country_name == "Grenada_GD") echo "selected"; elseif( 'Grenada_GD' == $row_record['country_name']) echo "selected";?>>Grenada(GD)</option>
<option value="Guadeloupe_GP" <?php if (isset($country_name) && $country_name == "Guadeloupe_GP") echo "selected"; elseif( 'Guadeloupe_GP' == $row_record['country_name']) echo "selected";?>>Guadeloupe(GP)</option>
<option value="Guam_GU" <?php if (isset($country_name) && $country_name == "Guam_GU") echo "selected"; elseif( 'Guam_GU' == $row_record['country_name']) echo "selected";?>>Guam(GU)</option>
<option value="Guatemala_GT" <?php if (isset($country_name) && $country_name == "Guatemala_GT") echo "selected"; elseif( 'Guatemala_GT' == $row_record['country_name']) echo "selected";?>>Guatemala(GT)</option>
<option value="Guernsey_GG" <?php if (isset($country_name) && $country_name == "Guernsey_GG") echo "selected"; elseif( 'Guernsey_GG' == $row_record['country_name']) echo "selected";?>>Guernsey(GG)</option>
<option value="Guinea_GN" <?php if (isset($country_name) && $country_name == "Guinea_GN") echo "selected"; elseif( 'Guinea_GN' == $row_record['country_name']) echo "selected";?>>Guinea(GN)</option>
<option value="Guinea-bissau_GW" <?php if (isset($country_name) && $country_name == "Guinea-bissau_GW") echo "selected"; elseif( 'Guinea-bissau_GW' == $row_record['country_name']) echo "selected";?>>Guinea-bissau(GW)</option>
<option value="Guyana_GY" <?php if (isset($country_name) && $country_name == "Guyana_GY") echo "selected"; elseif( 'Guyana_GY' == $row_record['country_name']) echo "selected";?>>Guyana(GY)</option>
<option value="Haiti_HT" <?php if (isset($country_name) && $country_name == "Haiti_HT") echo "selected"; elseif( 'Haiti_HT' == $row_record['country_name']) echo "selected";?>> Haiti(HT)</option>
<option value="Heard-Island-and-Mcdonald-Islands_HM" <?php if (isset($country_name) && $country_name == "Heard-Island-and-Mcdonald-Islands_HM") echo "selected"; elseif( 'Heard-Island-and-Mcdonald-Islands_HM' == $row_record['country_name']) echo "selected";?>>Heard-Island-and-Mcdonald-Islands(HM)</option>
<option value="Holy-See(Vatican City State)_VA" <?php if (isset($country_name) && $country_name == "Holy-See(Vatican City State)_VA") echo "selected"; elseif( 'Holy-See(Vatican City State)_VA' == $row_record['country_name']) echo "selected";?>>Holy-See(Vatican City State)(VA)</option>
<option value="Honduras_HN" <?php if (isset($country_name) && $country_name == "Honduras_HN") echo "selected"; elseif( 'Honduras_HN' == $row_record['country_name']) echo "selected";?>>Honduras(HN)</option>
<option value="Hong-Kong_HK" <?php if (isset($country_name) && $country_name == "Hong-Kong_HK") echo "selected"; elseif( 'Hong-Kong_HK' == $row_record['country_name']) echo "selected";?>>Hong-Kong(HK)</option>
<option value="Hungary_HU" <?php if (isset($country_name) && $country_name == " Hungary_HU") echo "selected"; elseif( ' Hungary_HU' == $row_record['country_name']) echo "selected";?>> Hungary(HU)</option>
<option value="Iceland_IS" <?php if (isset($country_name) && $country_name == "Iceland_IS") echo "selected"; elseif( 'Iceland_IS' == $row_record['country_name']) echo "selected";?>>Iceland(IS)</option>
<option value="India_IN" <?php if (isset($country_name) && $country_name == "India_IN") echo "selected"; elseif( 'India_IN' == $row_record['country_name']) echo "selected";?>>India(IN)</option>
<option value=" Indonesia_ID" <?php if (isset($country_name) && $country_name == " Indonesia_ID") echo "selected"; elseif( ' Indonesia_ID' == $row_record['country_name']) echo "selected";?>> Indonesia(ID)</option>
<option value="Iran-Islamic-Republic-of_IR" <?php if (isset($country_name) && $country_name == "Iran-Islamic-Republic-of_IR") echo "selected"; elseif( 'Iran-Islamic-Republic-of_IR' == $row_record['country_name']) echo "selected";?>>Iran-Islamic-Republic-of(IR)</option>
<option value="Iraq_IQ" <?php if (isset($country_name) && $country_name == "Iraq_IQ") echo "selected"; elseif( 'Iraq_IQ' == $row_record['country_name']) echo "selected";?>>Iraq(IQ)</option>
<option value="Ireland_IE" <?php if (isset($country_name) && $country_name == "Ireland_IE") echo "selected"; elseif( 'Ireland_IE' == $row_record['country_name']) echo "selected";?>>Ireland(IE)</option>
<option value="Isle-of-Man_IM" <?php if (isset($country_name) && $country_name == "Isle-of-Man_IM") echo "selected"; elseif( 'Isle-of-Man_IM' == $row_record['country_name']) echo "selected";?>>Isle-of-Man(IM)</option>
<option value="Israel_IL" <?php if (isset($country_name) && $country_name == "Israel_IL") echo "selected"; elseif( 'Israel_IL' == $row_record['country_name']) echo "selected";?>>Israel(IL)</option>
<option value="Italyl_IT" <?php if (isset($country_name) && $country_name == "Italyl_IT") echo "selected"; elseif( 'Italyl_IT' == $row_record['country_name']) echo "selected";?>>Italyl(IT)</option>
<option value="Jamaica_JM" <?php if (isset($country_name) && $country_name == "Jamaica_JM") echo "selected"; elseif( 'Jamaica_JM' == $row_record['country_name']) echo "selected";?>>Jamaica(JM)</option>
<option value="Japan_JP" <?php if (isset($country_name) && $country_name == "Japan_JP") echo "selected"; elseif( 'Japan_JP' == $row_record['country_name']) echo "selected";?>>Japan(JP)</option>
<option value="Jersey_JE" <?php if (isset($country_name) && $country_name == "Jersey_JE") echo "selected"; elseif( 'Jersey_JE' == $row_record['country_name']) echo "selected";?>>Jersey(JE)</option>
<option value="Jordan_JO" <?php if (isset($country_name) && $country_name == "Jordan_JO") echo "selected"; elseif( 'Jordan_JO' == $row_record['country_name']) echo "selected";?>>Jordan(JO)</option>
<option value="Kazakhstan_KZ" <?php if (isset($country_name) && $country_name == "Kazakhstan_KZ") echo "selected"; elseif( 'Kazakhstan_KZ' == $row_record['country_name']) echo "selected";?>>Kazakhstan(KZ)</option>
<option value="Kenya_KE" <?php if (isset($country_name) && $country_name == "Kenya_KE") echo "selected"; elseif( 'Kenya_KE' == $row_record['country_name']) echo "selected";?>>Kenya(KE)</option>
<option value="Kiribati_KI" <?php if (isset($country_name) && $country_name == "Kiribati_KI") echo "selected"; elseif( 'Kiribati_KI' == $row_record['country_name']) echo "selected";?>>Kiribati(KI)</option>
<option value="KoreaDemocratci People Republic of_KP" <?php if (isset($country_name) && $country_name == "KoreaDemocratci People Republic of_KP") echo "selected"; elseif( 'KoreaDemocratci People Republic of_KP' == $row_record['country_name']) echo "selected";?>>KoreaDemocratci People Republic of(KP)</option>
<option value="Korea-Republic-of_KR" <?php if (isset($country_name) && $country_name == "Korea-Republic-of_KR") echo "selected"; elseif( 'Korea-Republic-of_KR' == $row_record['country_name']) echo "selected";?>>Korea-Republic-of(KR)</option>
<option value="Kuwait_KW" <?php if (isset($country_name) && $country_name == "Kuwait_KW") echo "selected"; elseif( 'Kuwait_KW' == $row_record['country_name']) echo "selected";?>>Kuwait(KW)</option>
<option value="Kyrgyzstan_KG" <?php if (isset($country_name) && $country_name == "Kyrgyzstan_KG") echo "selected"; elseif( 'Kyrgyzstan_KG' == $row_record['country_name']) echo "selected";?>>Kyrgyzstan(KG)</option>
<option value="Lao-People-Democratic-Republic_LA" <?php if (isset($country_name) && $country_name == "Lao-People-Democratic-Republic_LA") echo "selected"; elseif( 'Lao-People-Democratic-Republic_LA' == $row_record['country_name']) echo "selected";?>>Lao-People-Democratic-Republic(LA)</option>
<option value="Latvia_LV" <?php if (isset($country_name) && $country_name == "Latvia_LV") echo "selected"; elseif( 'Latvia_LV' == $row_record['country_name']) echo "selected";?>>Latvia(LV)</option>
<option value="Lebanon_LB" <?php if (isset($country_name) && $country_name == "Lebanon_LB") echo "selected"; elseif( 'Lebanon_LB' == $row_record['country_name']) echo "selected";?>>Lebanon(LB)</option>
<option value="Lesotho_LS" <?php if (isset($country_name) && $country_name == "Lesotho_LS") echo "selected"; elseif( 'Lesotho_LS' == $row_record['country_name']) echo "selected";?>>Lesotho(LS)</option>
<option value="Liberia_LR" <?php if (isset($country_name) && $country_name == "Liberia_LR") echo "selected"; elseif( 'Liberia_LR' == $row_record['country_name']) echo "selected";?>>Liberia(LR)</option>
<option value="Libyan-Arab-Jamahiriya_LY" <?php if (isset($country_name) && $country_name == "Libyan-Arab-Jamahiriya_LY") echo "selected"; elseif( 'Libyan-Arab-Jamahiriya_LY' == $row_record['country_name']) echo "selected";?>>Libyan-Arab-Jamahiriya(LY)</option>
<option value="Liechtenstein_LI" <?php if (isset($country_name) && $country_name == "Liechtenstein_LI") echo "selected"; elseif( 'Liechtenstein_LI' == $row_record['country_name']) echo "selected";?>>Liechtenstein(LI)</option>
<option value="Lithuania_LT" <?php if (isset($country_name) && $country_name == "Lithuania_LT") echo "selected"; elseif( 'Lithuania_LT' == $row_record['country_name']) echo "selected";?>>Lithuania(LT)</option>
<option value="Luxembourg_LU" <?php if (isset($country_name) && $country_name == "Luxembourg_LU") echo "selected"; elseif( 'Luxembourg_LU' == $row_record['country_name']) echo "selected";?>>Luxembourg(LU)</option>
<option value="Macao_MO" <?php if (isset($country_name) && $country_name == "Macao_MO") echo "selected"; elseif( 'Macao_MO' == $row_record['country_name']) echo "selected";?>>Macao(MO)</option>
<option value="Macedonia,The Former Yugoslav Republic of_MK" <?php if (isset($country_name) && $country_name == "Macedonia,The Former Yugoslav Republic of_MK") echo "selected"; elseif( 'Macedonia,The Former Yugoslav Republic of_MK' == $row_record['country_name']) echo "selected";?>>Macedonia,The Former Yugoslav Republic of(MK)</option>
<option value="Madagascar_MG" <?php if (isset($country_name) && $country_name == "Madagascar_MG") echo "selected"; elseif( 'Madagascar_MG' == $row_record['country_name']) echo "selected";?>>Madagascar(MG)</option>
<option value="Malawi_MW" <?php if (isset($country_name) && $country_name == "Malawi_MW") echo "selected"; elseif( 'Malawi_MW' == $row_record['country_name']) echo "selected";?>>Malawi(MW)</option>
<option value="Malaysia_MY" <?php if (isset($country_name) && $country_name == "Malaysia_MY") echo "selected"; elseif( 'Malaysia_MY' == $row_record['country_name']) echo "selected";?>>Malaysia(MY)</option>
<option value="Maldives_MV" <?php if (isset($country_name) && $country_name == "Maldives_MV") echo "selected"; elseif( 'Maldives_MV' == $row_record['country_name']) echo "selected";?>>Maldives(MV)</option>
<option value="Mali_ML" <?php if (isset($country_name) && $country_name == "Mali_ML") echo "selected"; elseif( 'Mali_ML' == $row_record['country_name']) echo "selected";?>>Mali(ML)</option>
<option value="Malta_MT" <?php if (isset($country_name) && $country_name == "Malta_MT") echo "selected"; elseif( 'Malta_MT' == $row_record['country_name']) echo "selected";?>>Malta(MT)</option>
<option value="Marshall-Islands_MH" <?php if (isset($country_name) && $country_name == "Marshall-Islands_MH") echo "selected"; elseif( 'Marshall-Islands_MH' == $row_record['country_name']) echo "selected";?>>Marshall-Islands(MH)</option>
<option value="Martinique_MQ" <?php if (isset($country_name) && $country_name == "Martinique_MQ") echo "selected"; elseif( 'Martinique_MQ' == $row_record['country_name']) echo "selected";?>>Martinique(MQ)</option>
<option value="Mauritania_MR" <?php if (isset($country_name) && $country_name == "Mauritania_MR") echo "selected"; elseif( 'Mauritania_MR' == $row_record['country_name']) echo "selected";?>>Mauritania(MR)</option>
<option value="Mauritius_MU" <?php if (isset($country_name) && $country_name == "Mauritius_MU") echo "selected"; elseif( 'Mauritius_MU' == $row_record['country_name']) echo "selected";?>>Mauritius(MU)</option>
<option value="Mayotte_YT" <?php if (isset($country_name) && $country_name == "Mayotte_YT") echo "selected"; elseif( 'Mayotte_YT' == $row_record['country_name']) echo "selected";?>>Mayotte(YT)</option>
<option value="Mexico_MX" <?php if (isset($country_name) && $country_name == "Mexico_MX") echo "selected"; elseif( 'Mexico_MX' == $row_record['country_name']) echo "selected";?>>Mexico(MX)</option>
<option value="Micronesia-Federated-States-of" <?php if (isset($country_name) && $country_name == "Micronesia-Federated-States-of") echo "selected"; elseif( 'Micronesia-Federated-States-of' == $row_record['country_name']) echo "selected";?>>Micronesia-Federated-States-of(FM)</option>
<option value="Moldova-Republic-of_MD" <?php if (isset($country_name) && $country_name == "Moldova-Republic-of_MD") echo "selected"; elseif( 'Moldova-Republic-of_MD' == $row_record['country_name']) echo "selected";?>>Moldova-Republic-of(MD)</option>
<option value="Monaco_MC" <?php if (isset($country_name) && $country_name == "Monaco_MC") echo "selected"; elseif( 'Monaco_MC' == $row_record['country_name']) echo "selected";?>>Monaco(MC)</option>
<option value="Mongolia_MN" <?php if (isset($country_name) && $country_name == "Mongolia_MN") echo "selected"; elseif( 'Mongolia_MN' == $row_record['country_name']) echo "selected";?>>Mongolia(MN)</option>
<option value="Montenegro_ME" <?php if (isset($country_name) && $country_name == "Montenegro_ME") echo "selected"; elseif( 'Montenegro_ME' == $row_record['country_name']) echo "selected";?>>Montenegro(ME)</option>
<option value="Montserrat_MS" <?php if (isset($country_name) && $country_name == "Montserrat_MS") echo "selected"; elseif( 'Montserrat_MS' == $row_record['country_name']) echo "selected";?>>Montserrat(MS)</option>
<option value="Morocco_MA" <?php if (isset($country_name) && $country_name == "Morocco_MA") echo "selected"; elseif( 'Morocco_MA' == $row_record['country_name']) echo "selected";?>>Morocco_MA</option>
<option value="Mozambique_MZ" <?php if (isset($country_name) && $country_name == "Mozambique_MZ") echo "selected"; elseif( 'Mozambique_MZ' == $row_record['country_name']) echo "selected";?>>Mozambique_MZ</option>
<option value="Myanmar_MM" <?php if (isset($country_name) && $country_name == "Myanmar_MM") echo "selected"; elseif( 'Myanmar_MM' == $row_record['country_name']) echo "selected";?>>Myanmar(MM)</option>
<option value="Namibiar_NA" <?php if (isset($country_name) && $country_name == "Namibiar_NA") echo "selected"; elseif( 'Namibiar_NA' == $row_record['country_name']) echo "selected";?>>Namibiar(NA)</option>
<option value="Nauru_NR" <?php if (isset($country_name) && $country_name == "Nauru_NR") echo "selected"; elseif( 'Nauru_NR' == $row_record['country_name']) echo "selected";?>>Nauru(NR)</option>
<option value="Nepal_NP" <?php if (isset($country_name) && $country_name == "Nepal_NP") echo "selected"; elseif( 'Nepal_NP' == $row_record['country_name']) echo "selected";?>>Nepal(NP)</option>
<option value="Netherlands_NL" <?php if (isset($country_name) && $country_name == "Netherlands_NL") echo "selected"; elseif( 'Netherlands_NL' == $row_record['country_name']) echo "selected";?>>Netherlands(NL)</option>
<option value="Netherlands-Antilles_AN" <?php if (isset($country_name) && $country_name == "Netherlands-Antilles_AN") echo "selected"; elseif( 'Netherlands-Antilles_AN' == $row_record['country_name']) echo "selected";?>>Netherlands-Antilles(AN)</option>
<option value="New-Caledonia_NC" <?php if (isset($country_name) && $country_name == "New-Caledonia_NC") echo "selected"; elseif( 'New-Caledonia_NC' == $row_record['country_name']) echo "selected";?>>New-Caledonia(NC)</option>
<option value="New-Zealand_NZ" <?php if (isset($country_name) && $country_name == "New-Zealand_NZ") echo "selected"; elseif( 'New-Zealand_NZ' == $row_record['country_name']) echo "selected";?>>New-Zealand(NZ)</option>
<option value="Nicaragua_NI" <?php if (isset($country_name) && $country_name == "Nicaragua_NI") echo "selected"; elseif( 'Nicaragua_NI' == $row_record['country_name']) echo "selected";?>>Nicaragua(NI)</option>
<option value="Niger_NE" <?php if (isset($country_name) && $country_name == "Niger_NE") echo "selected"; elseif( 'Niger_NE' == $row_record['country_name']) echo "selected";?>>Niger(NE)</option>
<option value="Nigeria_NG" <?php if (isset($country_name) && $country_name == "Nigeria_NG") echo "selected"; elseif( 'Nigeria_NG' == $row_record['country_name']) echo "selected";?>>Nigeria(NG)</option>
<option value="Niue_NU" <?php if (isset($country_name) && $country_name == "Niue_NU") echo "selected"; elseif( 'Niue_NU' == $row_record['country_name']) echo "selected";?>>Niue(NU)</option>
<option value="Norfolk-Island_NF" <?php if (isset($country_name) && $country_name == "Norfolk-Island_NF") echo "selected"; elseif( 'Norfolk-Island_NF' == $row_record['country_name']) echo "selected";?>>Norfolk-Island(NF)</option>
<option value="Northern-Mariana-Islands_MP" <?php if (isset($country_name) && $country_name == "Northern-Mariana-Islands_MP") echo "selected"; elseif( 'Northern-Mariana-Islands_MP' == $row_record['country_name']) echo "selected";?>>Northern-Mariana-Islands(MP)</option>
<option value="Norway_NO" <?php if (isset($country_name) && $country_name == "Norway_NO") echo "selected"; elseif( 'Norway_NO' == $row_record['country_name']) echo "selected";?>>Norway(NO)</option>
<option value="Oman_OM" <?php if (isset($country_name) && $country_name == "Oman_OM") echo "selected"; elseif( 'Oman_OM' == $row_record['country_name']) echo "selected";?>>Oman(OM)</option>
<option value="Pakistan_PK" <?php if (isset($country_name) && $country_name == "Pakistan_PK") echo "selected"; elseif( 'Pakistan_PK' == $row_record['country_name']) echo "selected";?>>Pakistan(PK)</option>
<option value="Palau_PW" <?php if (isset($country_name) && $country_name == "Palau_PW") echo "selected"; elseif( 'Palau_PW' == $row_record['country_name']) echo "selected";?>>Palau(PW)</option>
<option value="Palestinian-Territory-Occupied_PS" <?php if (isset($country_name) && $country_name == "Palestinian-Territory-Occupied_PS") echo "selected"; elseif( 'Palestinian-Territory-Occupied_PS' == $row_record['country_name']) echo "selected";?>>Palestinian-Territory-Occupied(PS)</option>
<option value="Panama_PA" <?php if (isset($country_name) && $country_name == "Panama_PA") echo "selected"; elseif( 'Panama_PA' == $row_record['country_name']) echo "selected";?>>Panama(PA)</option>
<option value="Papua-New-Guinea_PG" <?php if (isset($country_name) && $country_name == "Papua-New-Guinea_PG") echo "selected"; elseif( 'Papua-New-Guinea_PG' == $row_record['country_name']) echo "selected";?>>Papua-New-Guinea(PG)</option>
<option value="Paraguay_PY" <?php if (isset($country_name) && $country_name == "Paraguay_PY") echo "selected"; elseif( 'Paraguay_PY' == $row_record['country_name']) echo "selected";?>>Paraguay(PY)</option>
<option value="Peru_PE" <?php if (isset($country_name) && $country_name == "Peru_PE") echo "selected"; elseif( 'Peru_PE' == $row_record['country_name']) echo "selected";?>>Peru(PE)</option>
<option value="Philippines_PH" <?php if (isset($country_name) && $country_name == "Philippines_PH") echo "selected"; elseif( 'Philippines_PH' == $row_record['country_name']) echo "selected";?>>Philippines(PH)</option>
<option value="Pitcairn_PN" <?php if (isset($country_name) && $country_name == "Pitcairn_PN") echo "selected"; elseif( 'Pitcairn_PN' == $row_record['country_name']) echo "selected";?>>Pitcairn(PN)</option>
<option value="Poland_PL" <?php if (isset($country_name) && $country_name == "Poland_PL") echo "selected"; elseif( 'Poland_PL' == $row_record['country_name']) echo "selected";?>>Poland(PL)</option>
<option value="Portugal_PT" <?php if (isset($country_name) && $country_name == "Portugal_PT") echo "selected"; elseif( 'Portugal_PT' == $row_record['country_name']) echo "selected";?>>Portugal(PT)</option>
<option value="Puerto-Rico_PR" <?php if (isset($country_name) && $country_name == "Puerto-Rico_PR") echo "selected"; elseif( 'Puerto-Rico_PR' == $row_record['country_name']) echo "selected";?>>Puerto-Rico(PR)</option>
<option value="Qatar_QA" <?php if (isset($country_name) && $country_name == "Qatar_QA") echo "selected"; elseif( 'Qatar_QA' == $row_record['country_name']) echo "selected";?>>Qatar(QA)</option>
<option value="Reunion_RE" <?php if (isset($country_name) && $country_name == "Reunion_RE") echo "selected"; elseif( 'Reunion_RE' == $row_record['country_name']) echo "selected";?>>Reunion(RE)</option>
<option value="Romania_RO" <?php if (isset($country_name) && $country_name == "Romania_RO") echo "selected"; elseif( 'Romania_RO' == $row_record['country_name']) echo "selected";?>>Romania(RO)</option>
<option value="Russian-Federation_RU" <?php if (isset($country_name) && $country_name == "Russian-Federation_RU") echo "selected"; elseif( 'Russian-Federation_RU' == $row_record['country_name']) echo "selected";?>>Russian-Federation(RU)</option>
<option value="Rwanda_RW" <?php if (isset($country_name) && $country_name == "Rwanda_RW") echo "selected"; elseif( 'Rwanda_RW' == $row_record['country_name']) echo "selected";?>>Rwanda(RW)</option>
<option value="Saint-Helena_SH" <?php if (isset($country_name) && $country_name == "Saint-Helena_SH") echo "selected"; elseif( 'Saint-Helena_SH' == $row_record['country_name']) echo "selected";?>>Saint-Helena(SH)</option>
<option value="Saint-Kitts-and-Nevis_KN" <?php if (isset($country_name) && $country_name == "Saint Kitts and Nevis_KN") echo "selected"; elseif( 'Saint-Kitts-and-Nevis_KN' == $row_record['country_name']) echo "selected";?>>Saint-Kitts-and-Nevis(KN)</option>
<option value="Saint-Lucia_LC" <?php if (isset($country_name) && $country_name == "Saint Lucia_LC") echo "selected"; elseif( 'Saint-Lucia_LC' == $row_record['country_name']) echo "selected";?>>Saint-Lucia(LC)</option>
<option value="Saint-Pierre-and-Miquelon_PM" <?php if (isset($country_name) && $country_name == "Saint-Pierre-and-Miquelon_PM") echo "selected"; elseif( 'Saint-Pierre-and-Miquelon_PM' == $row_record['country_name']) echo "selected";?>>Saint-Pierre-and-Miquelon(PM)</option>
<option value="Saint-Vincent-and-The-Grenadines_VC" <?php if (isset($country_name) && $country_name == "Saint-Vincent-and-The-Grenadines_VC") echo "selected"; elseif( 'Saint-Vincent-and-The-Grenadines_VC' == $row_record['country_name']) echo "selected";?>>Saint-Vincent-and-The-Grenadines(VC)</option>
<option value="Samoa_WS" <?php if (isset($country_name) && $country_name == "Samoa_WS") echo "selected"; elseif( 'Samoa_WS' == $row_record['country_name']) echo "selected";?>>Samoa(WS)</option>
<option value="San-Marino_SM" <?php if (isset($country_name) && $country_name == "San-Marino_SM") echo "selected"; elseif( 'San-Marino_SM' == $row_record['country_name']) echo "selected";?>>San Marino(SM)</option>
<option value="Sao-Tome-and-Principe_ST" <?php if (isset($country_name) && $country_name == "Sao-Tome-and-Principe_ST") echo "selected"; elseif( 'Sao-Tome-and-Principe_ST' == $row_record['country_name']) echo "selected";?>>Sao Tome and Principe(ST)</option>
<option value="Saudi-Arabia_SA" <?php if (isset($country_name) && $country_name == "Saudi-Arabia_SA") echo "selected"; elseif( 'Saudi-Arabia_SA' == $row_record['country_name']) echo "selected";?>>Saudi Arabia(SA)</option>
<option value="Senegal_SN" <?php if (isset($country_name) && $country_name == "Senegal_SN") echo "selected"; elseif( 'Senegal_SN' == $row_record['country_name']) echo "selected";?>>Senegal(SN)</option>
<option value="Serbia_RS" <?php if (isset($country_name) && $country_name == "Serbia_RS") echo "selected"; elseif( 'Serbia_RS' == $row_record['country_name']) echo "selected";?>>Serbia(RS)</option>
<option value="Seychelles_SC" <?php if (isset($country_name) && $country_name == "Seychelles_SC") echo "selected"; elseif( 'Seychelles_SC' == $row_record['country_name']) echo "selected";?>>Seychelles(SC)</option>
<option value="Sierra-Leone_SL" <?php if (isset($country_name) && $country_name == "Sierra-Leone_SL") echo "selected"; elseif( 'Sierra-Leone_SL' == $row_record['country_name']) echo "selected";?>>Sierra Leone(SL)</option>
<option value="Singapore_SG" <?php if (isset($country_name) && $country_name == "Singapore_SG") echo "selected"; elseif( 'Singapore_SG' == $row_record['country_name']) echo "selected";?>>Singapore(SG)</option>
<option value="Slovakia_SK" <?php if (isset($country_name) && $country_name == "Slovakia_SK") echo "selected"; elseif( 'Slovakia_SK' == $row_record['country_name']) echo "selected";?>>Slovakia(SK)</option>
<option value="Slovenia_SL" <?php if (isset($country_name) && $country_name == "Slovenia_SL") echo "selected"; elseif( 'Slovenia_SL' == $row_record['country_name']) echo "selected";?>>Slovenia(SL)</option>
<option value="Solomon-Islands_SB" <?php if (isset($country_name) && $country_name == "Solomon-Islands_SB") echo "selected"; elseif( 'Solomon-Islands_SB' == $row_record['country_name']) echo "selected";?>>Solomon Islands(SB)</option>
<option value="Somalia_SO" <?php if (isset($country_name) && $country_name == "Somalia_SO") echo "selected"; elseif( 'Somalia_SO' == $row_record['country_name']) echo "selected";?>>Somalia(SO)</option>
<option value="South-Africa_ZA" <?php if (isset($country_name) && $country_name == "South-Africa_ZA") echo "selected"; elseif( 'South-Africa_ZA' == $row_record['country_name']) echo "selected";?>>South Africa(ZA)</option>
<option value="South-Georgia-and-The-South-Sandwich-Islands_GS" <?php if (isset($country_name) && $country_name == "South-Georgia-and-The-South-Sandwich-Islands_GS") echo "selected"; elseif( 'South-Georgia-and-The-South-Sandwich-Islands_GS' == $row_record['country_name']) echo "selected";?>>South Georgia and The South Sandwich Islands(GS)</option>
<option value="Spain_ES" <?php if (isset($country_name) && $country_name == "Spain_ES") echo "selected"; elseif( 'Spain_ES' == $row_record['country_name']) echo "selected";?>>Spain(ES)</option>
<option value="Sri-Lanka_LK" <?php if (isset($country_name) && $country_name == "Sri-Lanka_LK") echo "selected"; elseif( 'Sri-Lanka_LK' == $row_record['country_name']) echo "selected";?>>Sri-Lanka(LK)</option>
<option value="Sudan_SD" <?php if (isset($country_name) && $country_name == "Sudan_SD") echo "selected"; elseif( 'Sudan_SD' == $row_record['country_name']) echo "selected";?>>Sudan(SD)</option>
<option value="Suriname_SR" <?php if (isset($country_name) && $country_name == "Suriname_SR") echo "selected"; elseif( 'Suriname_SR' == $row_record['country_name']) echo "selected";?>>Suriname(SR)</option>
<option value="Svalbard-and-Jan-Mayen_SJ" <?php if (isset($country_name) && $country_name == "Svalbard-and-Jan-Mayen_SJ") echo "selected"; elseif( 'Svalbard-and-Jan-Mayen_SJ' == $row_record['country_name']) echo "selected";?>>Svalbard and Jan Mayen(SJ)</option>
<option value="Swaziland_SZ" <?php if (isset($country_name) && $country_name == "Swaziland_SZ") echo "selected"; elseif( 'Swaziland_SZ' == $row_record['country_name']) echo "selected";?>>Swaziland(SZ)</option>
<option value="Sweden_SE" <?php if (isset($country_name) && $country_name == "Sweden_SE") echo "selected"; elseif( 'Sweden_SW' == $row_record['country_name']) echo "selected";?>>Sweden(SE)</option>
<option value="Switzerland_CH" <?php if (isset($country_name) && $country_name == "Switzerland_CH") echo "selected"; elseif( 'Switzerland_CH' == $row_record['country_name']) echo "selected";?>>Switzerland(CH)</option>
<option value="Syrian-Arab-Republic_SY" <?php if (isset($country_name) && $country_name == "Syrian-Arab-Republic_SY") echo "selected"; elseif( 'Syrian-Arab-Republic_SY' == $row_record['country_name']) echo "selected";?>>Syrian Arab Republic(SY)</option>
<option value="Taiwan-Province-of-China_TW" <?php if (isset($country_name) && $country_name == "Taiwan-Province-of-China_TW") echo "selected"; elseif( 'Taiwan-Province-of-China_TW' == $row_record['country_name']) echo "selected";?>>Taiwan, Province of China(TW)</option>
<option value="Tajikistan_TJ" <?php if (isset($country_name) && $country_name == "Tajikistan_TJ") echo "selected"; elseif( 'Tajikistan_TJ' == $row_record['country_name']) echo "selected";?>>Tajikistan(TJ)</option>
<option value="Tanzania-United-Republic-of_TZ" <?php if (isset($country_name) && $country_name == "Tanzania-United-Republic-of_TZ") echo "selected"; elseif( 'Tanzania-United-Republic-of_TZ' == $row_record['country_name']) echo "selected";?>>Tanzania, United Republic of(TZ)</option>
<option value="Thailand_TH" <?php if (isset($country_name) && $country_name == "Thailand_TH") echo "selected"; elseif( 'Thailand_TH' == $row_record['country_name']) echo "selected";?>>Thailand(TH)</option>
<option value="Timor-leste_TL" <?php if (isset($country_name) && $country_name == "Timor-leste_TL") echo "selected"; elseif( 'Timor-leste_TL' == $row_record['country_name']) echo "selected";?>>Timor-leste(TL)</option>
<option value="Togo_TG" <?php if (isset($country_name) && $country_name == "Togo_TG") echo "selected"; elseif( 'Togo_TG' == $row_record['country_name']) echo "selected";?>>Togo(TG)</option>
<option value="Tokelau_TK" <?php if (isset($country_name) && $country_name == "Tokelau_TK") echo "selected"; elseif( 'Tokelau_TK' == $row_record['country_name']) echo "selected";?>>Tokelau(TK)</option>
<option value="Tonga_TO" <?php if (isset($country_name) && $country_name == "Tonga_TO") echo "selected"; elseif( 'Tonga_TO' == $row_record['country_name']) echo "selected";?>>Tonga(TO)</option>
<option value="Trinidad-and-Tobago_TT" <?php if (isset($country_name) && $country_name == "Trinidad-and-Tobago_TT") echo "selected"; elseif( 'Trinidad-and-Tobago_TT' == $row_record['country_name']) echo "selected";?>>Trinidad and Tobago(TT)</option>
<option value="Tunisia_TN" <?php if (isset($country_name) && $country_name == "Tunisia_TN") echo "selected"; elseif( 'Tunisia_TN' == $row_record['country_name']) echo "selected";?>>Tunisia(TN)</option>
<option value="Turkey_TR" <?php if (isset($country_name) && $country_name == "Turkey_TR") echo "selected"; elseif( 'Turkey_TR' == $row_record['country_name']) echo "selected";?>>Turkey(TR)</option>
<option value="Turkmenistan_TM" <?php if (isset($country_name) && $country_name == "Turkmenistan_TM") echo "selected"; elseif( 'Turkmenistan_TM' == $row_record['country_name']) echo "selected";?>>Turkmenistan(TM)</option>
<option value="Turks-and-Caicos-Islands_TC" <?php if (isset($country_name) && $country_name == "Turks-and-Caicos-Islands_TC") echo "selected"; elseif( 'Turks-and-Caicos-Islands_TC' == $row_record['country_name']) echo "selected";?>>Turks and Caicos Islands(TC)</option>
<option value="Tuvalu_TV" <?php if (isset($country_name) && $country_name == "Tuvalu_TV") echo "selected"; elseif( 'Tuvalu_TV' == $row_record['country_name']) echo "selected";?>>Tuvalu(TV)</option>
<option value="Uganda_UG" <?php if (isset($country_name) && $country_name == "Uganda_UG") echo "selected"; elseif( 'Uganda_UG' == $row_record['country_name']) echo "selected";?>>Uganda(UG)</option>
<option value="Ukraine_UA" <?php if (isset($country_name) && $country_name == "Ukraine_UA") echo "selected"; elseif( 'Ukraine_UA' == $row_record['country_name']) echo "selected";?>>Ukraine(UA)</option>
<option value="United-Arab-Emirates_AE" <?php if (isset($country_name) && $country_name == "United-Arab-Emirates_AE") echo "selected"; elseif( 'United-Arab-Emirates_AE' == $row_record['country_name']) echo "selected";?>>United Arab Emirates(AE)</option>
<option value="United-Kingdom_GB" <?php if (isset($country_name) && $country_name == "United-Kingdom_GB") echo "selected"; elseif( 'United-Kingdom_GB' == $row_record['country_name']) echo "selected";?>>United Kingdom(GB)</option>
<option value="United-States_US" <?php if (isset($country_name) && $country_name == "United-States_US") echo "selected"; elseif( 'United-States_US' == $row_record['country_name']) echo "selected";?>>United States(US)</option>
<option value="United-States-Minor-Outlying-Islands_UM" <?php if (isset($country_name) && $country_name == "United-States-Minor-Outlying-Islands_UM") echo "selected"; elseif( 'United-States-Minor-Outlying-Islands_UM' == $row_record['country_name']) echo "selected";?>>United States Minor Outlying Islands(UM)</option>
<option value="Uruguay_UY" <?php if (isset($country_name) && $country_name == "Uruguay_UY") echo "selected"; elseif( 'Uruguay_UY' == $row_record['country_name']) echo "selected";?>>Uruguay(UY)</option>
<option value="Uzbekistan_UZ" <?php if (isset($country_name) && $country_name == "Uzbekistan_UZ") echo "selected"; elseif( 'Uzbekistan_UZ' == $row_record['country_name']) echo "selected";?>>Uzbekistan(UZ)</option>
<option value="Vanuatu_VU" <?php if (isset($country_name) && $country_name == "Vanuatu_VU") echo "selected"; elseif( 'Vanuatu_VU' == $row_record['country_name']) echo "selected";?>>Vanuatu(VU)</option>
<option value="Venezuela_VE" <?php if (isset($country_name) && $country_name == "Venezuela_VE") echo "selected"; elseif( 'Venezuela_VE' == $row_record['country_name']) echo "selected";?>>Venezuela(VE)</option>
<option value="Viet-Nam_VN" <?php if (isset($country_name) && $country_name == "Viet-Nam_VN") echo "selected"; elseif( 'Viet-Nam_VN' == $row_record['country_name']) echo "selected";?>>Viet Nam(VN)</option>
<option value="Virgin-Islands-British_VG" <?php if (isset($country_name) && $country_name == "Virgin-Islands-British_VG") echo "selected"; elseif( 'Virgin-Islands-British_VG' == $row_record['country_name']) echo "selected";?>>Virgin Islands, British(VG)</option>
<option value="Virgin-Islands- U.S._VI" <?php if (isset($country_name) && $country_name == "Virgin-Islands- U.S._VI") echo "selected"; elseif( 'Virgin-Islands- U.S._VI' == $row_record['country_name']) echo "selected";?>>Virgin-Islands- U.S.(VI)</option>
<option value="Wallis-and-Futuna_WF" <?php if (isset($country_name) && $country_name == "Wallis-and-Futuna_WF") echo "selected"; elseif( 'Wallis-and-Futuna_WF' == $row_record['country_name']) echo "selected";?>>Wallis and Futuna(WF)</option>
<option value="Western-Sahara_EH" <?php if (isset($country_name) && $country_name == "Western-Sahara_EH") echo "selected"; elseif( 'Western-Sahara_EH' == $row_record['country_name']) echo "selected";?>>Western Sahara(EH)</option>
<option value="Yemen_YE" <?php if (isset($country_name) && $country_name == "Yemen_YE") echo "selected"; elseif( 'Yemen_YE' == $row_record['country_name']) echo "selected";?>>Yemen(YE)</option>
<option value="Zambia_ZM" <?php if (isset($country_name) && $country_name == "Zambia_ZM") echo "selected"; elseif( 'Zambia_ZM' == $row_record['country_name']) echo "selected";?>>Zambia(ZM)</option>
<option value="Zimbabwe_ZW" <?php if (isset($country_name) && $country_name == "Zimbabwe_ZW") echo "selected"; elseif( 'Zimbabwe_ZW' == $row_record['country_name']) echo "selected";?>>Zimbabwe(ZW)</option>
                                      </select>
                                        </td> 
                                        <td width="40%"></td>
                    </tr>
                     <tr>
                       <td valign="top">Language Code<span class="orange_font">*</span></td>
                        <td style=""><input type="text"  class="validate[required] input_text" name="language_code" id="language_code" value="<?php if ($_POST['save_changes']) echo $_POST['language_code']; else echo $row_record['language_code']; ?>" /></td> <td colspan="3" class="orange_font">Example- For English write EN</td>
                        
                    </tr>
                    <tr>
                        <td width="20%">Language Description<span class="orange_font"></span></td>
                        <td width="40%" style=""><textarea name="description" id="description" class="input_textarea"><?php if($_POST['description']) echo $_POST['description']; else echo $row_record['description'];?>
</textarea></td>
                        <td width="40%"></td>
                      
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td ><input type="submit" onclick="return validin();" class="input_btn" value="<?php if ($record_id) echo "Update"; else  echo "Add"; ?> Language" name="save_changes"  /></td>
                        
                    </tr>
                </table>
        </form>
        </td></tr>
<?php
                        }   ?>
	 
        </table></td>
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
<div id="footer"><? require("ex_include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>
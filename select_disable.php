<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php include "include/headHeader.php";?>



</head>

<body>
<h4 class="info-text">Select 1st Employee<br>
    <select class="new" name="wcl-employees1" id="wcl-employees1" onchange="new11()">
        <option value="" disabled="" selected="" style="display:none;">Select One...</option>
        <option value="ALCANTARA, ERIC">ALCANTARA, ERIC</option>
        <option value="ALDRIGE, ,MERANDA">ALDRIGE, ,MERANDA</option>
        <option value="ALTOBELLI, JAMES">ALTOBELLI, JAMES</option>
    </select>
</h4>
<h4 class="info-text">Select 2nd Employee<br>
    <select class="new" name="wcl-employees2" id="wcl-employees2" onchange="new11()">
        <option value="" disabled="" selected="" style="display:none;">Select One...</option>
        <option value="ALCANTARA, ERIC">ALCANTARA, ERIC</option>
        <option value="ALDRIGE, ,MERANDA">ALDRIGE, ,MERANDA</option>
        <option value="ALTOBELLI, JAMES">ALTOBELLI, JAMES</option>
    </select>
</h4>
<h4 class="info-text">Select 3rd Employee<br>
    <select class="new" name="wcl-employees3" id="wcl-employees3" onchange="new11()">
        <option value="" disabled="" selected="" style="display:none;">Select One...</option>
        <option value="ALCANTARA, ERIC">ALCANTARA, ERIC</option>
        <option value="ALDRIGE, ,MERANDA">ALDRIGE, ,MERANDA</option>
        <option value="ALTOBELLI, JAMES">ALTOBELLI, JAMES</option>
    </select>
</h4>

<script>
function new11()
{

   var selected = [];  
    
	$( "select" ).each(function(index, select){           
        if (select.value !== "") { selected.push(select.value); }
   });         
   $("option").prop("disabled", false);         
   for (var index in selected) { $('option[value="'+selected[index]+'"]').prop("disabled", true); }

}
</script>
</body>
</html>
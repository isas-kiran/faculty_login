<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
<meta content="utf-8" http-equiv="encoding"  />
<title>Service Dashboard</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<?php include "include/ps_pagination.php"; ?>
<?php
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='276'";
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
	<script type="text/javascript">
    $(document).ready(function()
	{  
		var currentDate = new Date();
		$('.datepicker').datepicker({ changeMonth: true, changeYear: true, showButtonPanel: true, closeText: 'Clear'});
		$.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
		{
			res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
		}
		//$('#inquiry_date').datepicker().datepicker('setDate', 'today');
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
			else if(action=="change_owner")
			{
				$( ".new_custom_course" ).dialog({
					width: '500',
					height:'150'
				});
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
		
function select_branch (val)
{
	 document.actionsave.submit();
}
    </script>
</head>
<body>
<?php include "include/header.php"; ?>
<!--info start-->
<div id="info">
	<?php include "include/menuLeft.php"; ?>
    <div id="right_info">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td class="top_left"></td>
            <td class="top_mid" valign="bottom"><?php include "include/services_menu.php";?></td>
            <td class="top_right"></td>
        </tr>
        <tr>
            <td class="mid_left"></td>
            <td class="mid_mid" align="center">
                <table cellspacing="0" cellpadding="0" class="table" width="98%">
                    <!--<tr class="grey_td" >	
                        <td width="3%" align="center"><strong>Sr. No.</strong></td>
                        <td width="9%" align="center"><strong>Course Name</strong></td>   
                        <td width="10%" align="center"><strong>Added By</strong></td>
                        <td width="10%" align="center"><strong>Assigned To</strong></td>
                    </tr>-->
                    <tr>
                   		<td width="60%" valign="top" style="width:100%;padding:0; margin:0" >
                            <!--=========================================================DASHBOARD NOTIFICATION================================================================-->
                            <link rel="stylesheet" type="text/css" href="index_files/rounded.css">
                            <link rel="stylesheet" type="text/css" href="index_files/template.css">
                            <!--style letest update-------------->
                            <style type="text/css">
                            /*!!!!!!!!!!! QuickMenu Core CSS [Do Not Modify!] !!!!!!!!!!!!!*/
                            .qmmc .qmdivider{display:block;font-size:1px;border-width:0px;border-style:solid;position:relative;z-index:1;}.qmmc .qmdividery{float:left;width:0px;}.qmmc .qmtitle{display:block;cursor:default;white-space:nowrap;position:relative;z-index:1;}.qmclear {font-size:1px;height:0px;width:0px;clear:left;line-height:0px;display:block;float:none !important;}.qmmc {position:relative;zoom:1;z-index:10;}.qmmc a, .qmmc li {float:left;display:block;white-space:nowrap;position:relative;z-index:1;}.qmmc div a, .qmmc ul a, .qmmc ul li {float:none;}.qmsh div a {float:left;}.qmmc div{visibility:hidden;position:absolute;}.qmmc .qmcbox{cursor:default;display:block;position:relative;z-index:1;}.qmmc .qmcbox a{display:inline;}.qmmc .qmcbox div{float:none;position:static;visibility:inherit;left:auto;}.qmmc li {z-index:auto;}.qmmc ul {left:-10000px;position:absolute;z-index:10;}.qmmc, .qmmc ul {list-style:none;padding:0px;margin:0px;}.qmmc li a {float:none;}.qmmc li:hover>ul{left:auto;}#qm0 li {float:none;}#qm0 li:hover>ul{top:0px;left:100%;}
                            /*!!!!!!!!!!! QuickMenu Styles [Please Modify!] !!!!!!!!!!!*/
                                /* QuickMenu 0 */
                                /*"""""""" (MAIN) Container""""""""*/	
                                #qm0	
                                {	
                                    min-width:30%;
                                    max-width:100%;
                                    background-color:transparent;
                                    border-width:1px;
                                    border-style:solid;
                                    border-color:#DDDDDD;
                                    font-weight:200;                                    
                                }
                                /*"""""""" (MAIN) Items""""""""*/	
                                #qm0 a	
                                {	
                                    padding:5px 5px 5px 8px;
                                    background-image:url("images/gradient_37.gif");
                                    color:#000000;
                                    font-family:Tahoma;
                                    font-size:12px;
                                    text-decoration:none;
                                    border-width:1px 0px;
                                    border-style:solid;
                                    border-color:#DDDDDD;
                                    font-weight:200;
                                }
                                /*"""""""" (MAIN) Hover State""""""""*/	
                                #qm0 a:hover	
                                {	
                                    background-color:#FFFDFD;
                                }
                                /*"""""""" (MAIN) Hover State - (duplicated for pure CSS)""""""""*/	
                                #qm0 li:hover>a	
                                {	
                                    background-color:#FFFDFD;
                                }
                                /*"""""""" (MAIN) Parent Hover State""""""""*/	
                                #qm0 .qmparent:hover	
                                {	
                                    background-color:#ffffff;
                                }
                                /*"""""""" (MAIN) Active State""""""""*/	
                                body #qm0 .qmactive, body #qm0 .qmactive:hover	
                                {	
                                    color:#262528;
                                    text-decoration:none;
                                }
                                /*"""""""" (SUB) Container""""""""*/	
                                #qm0 div, #qm0 ul	
                                {	
                                    padding:10px 0px;
                                    background-color:#F1F1F1;
                                    border-width:1px;
                                    border-style:none;
                                    border-color:#CCCCCC;
                                }
                                /*"""""""" (SUB) Items""""""""*/	
                                #qm0 div a, #qm0 ul a	
                                {	
                                    padding:2px 0px 2px 5px;
                                    margin:0px 5px;
                                    background-color:transparent;
                                    background-image:none;
                                    font-size:11px;
                                    border-width:1px;
                                    border-style:solid;
                                    border-color:#F1F1F1;
                                }
                                /*"""""""" (SUB) Hover State""""""""*/	
                                #qm0 div a:hover	
                                {	
                                    text-decoration:none;
                                }
                                /*"""""""" (SUB) Hover State - (duplicated for pure CSS)""""""""*/	
                                #qm0 ul li:hover>a	
                                {	
                                    text-decoration:none;
                                }
                                /*"""""""" (SUB) Parent Hover State""""""""*/	
                                #qm0 div .qmparent:hover	
                                {	
                                    background-color:transparent;
                                }
                                /*"""""""" (SUB) Active State""""""""*/	
                                body #qm0 div .qmactive, body #qm0 div .qmactive:hover	
                                {	
                                    background-color:#BFBFBF;
                                    border-color:#999999;
                                }
                                /*"""""""" Individual Titles""""""""*/	
                                #qm0 .qmtitle	
                                {	
                                    font-size:11px;
                                }
                                /*"""""""" Individual Horizontal Dividers""""""""*/	
                                #qm0 .qmdividerx	
                                {	
                                    border-top-width:1px;
                                    margin:4px 0px;
                                    border-color:#BFBFBF;
                                }
                                /*"""""""" Individual Vertical Dividers""""""""*/	
                                #qm0 .qmdividery	
                                {	
                                    border-left-width:1px;
                                    height:15px;
                                    margin:4px 2px 0px;
                                    border-color:#AAAAAA;
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 ul li:hover > a.qmparent	
                                {	
                                    background-image:url("images/symbol_5.gif");
                                    background-image:url("images/symbol_5.gif");
                                    background-image:url("images/symbol_5.gif");
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 ul .qmparent	
                                {
                                    
                                    background-image:url("images/symbol_3.gif");
                                    background-image:url("images/symbol_3.gif");
                                    background-image:url("images/symbol_3.gif");
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 li:hover > a.qmparent	
                                {	
                                    background-image:url("images/symbol_2.gif");
                                    background-image:url("images/symbol_2.gif");
                                    background-image:url("images/symbol_2.gif");
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 .qmparent	
                                {	
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 ul li:hover > a.qmparent	
                                {	
                                    background-image:url("images/symbol_5.gif");
                                    background-image:url("images/symbol_5.gif");
                                    background-image:url("images/symbol_5.gif");
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 ul .qmparent	
                                {
                                    
                                    background-image:url("images/symbol_3.gif");
                                    background-image:url("images/symbol_3.gif");
                                    background-image:url("images/symbol_3.gif");
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 li:hover > a.qmparent	
                                {	
                                    background-image:url("images/symbol_2.gif");
                                    background-image:url("images/symbol_2.gif");
                                    background-image:url("images/symbol_2.gif");
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 .qmparent	
                                {	
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 a	
                                {	
                                    background-color:#DDDDDD;
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 ul	
                                {	
                                    background-color:#F1F1F1;
                                    border-width:1px;
                                    border-style:solid;
                                    border-color:#666666;
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 ul a	
                                {	
                                    padding:2px 20px 2px 5px;
                                    background-color:#F1F1F1;
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 .qmparent	
                                {	
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                    background-image:url("images/symbol_0.gif");
                                    background-repeat:no-repeat;
                                    background-position:95% 55%;
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 li:hover > a.qmparent	
                                {	
                                    background-image:url("images/symbol_2.gif");
                                    background-image:url("images/symbol_2.gif");
                                    background-image:url("images/symbol_2.gif");
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 ul .qmparent	
                                {	
                                    background-image:url("images/symbol_3.gif");
                                    background-image:url("images/symbol_3.gif");
                                    background-image:url("images/symbol_3.gif");
                                }
                                /*"""""""" Custom Rule""""""""*/	
                                ul#qm0 ul li:hover > a.qmparent	
                                {	
                                    background-image:url("images/symbol_5.gif");
                                    background-image:url("images/symbol_5.gif");
                                    background-image:url("images/symbol_5.gif");
                                }
                                .scrollit {
                                overflow:scroll;
                                height:500px;
                                }
                            </style>
                            
                            <!-- Add-On Core Code (Remove when not using any add-on's) -->
                                <style type="text/css">.qmfv{visibility:visible !important;}.qmfh{visibility:hidden !important;}</style><script type="text/javascript">qmad=new Object();qmad.bvis="";qmad.bhide="";</script>                            
                                <!-- Add-On Settings -->
                                <script type="text/JavaScript">
                                    /*******  Menu 0 Add-On Settings *******/
                                    var a = qmad.qm0 = new Object();
                                    // Item Bullets Add On
                                    a.ibullets_apply_to = "parent";
                                    a.ibullets_main_image = "images/symbol_0.gif";
                                    a.ibullets_main_image_hover = "images/symbol_1.gif";
                                    a.ibullets_main_image_active = "images/symbol_2.gif";
                                    a.ibullets_main_image_width = 13;
                                    a.ibullets_main_image_height = 13;
                                    a.ibullets_main_position_x = -15;
                                    a.ibullets_main_position_y = -6;
                                    a.ibullets_main_align_x = "right";
                                    a.ibullets_main_align_y = "middle";
                                    a.ibullets_sub_image = "images/symbol_3.gif";
                                    a.ibullets_sub_image_hover = "images/symbol_4.gif";
                                    a.ibullets_sub_image_active = "images/symbol_5.gif";
                                    a.ibullets_sub_image_width = 5;
                                    a.ibullets_sub_image_height = 5;
                                    a.ibullets_sub_position_x = -10;
                                    a.ibullets_sub_position_y = -3;
                                    a.ibullets_sub_align_x = "left";
                                    a.ibullets_sub_align_y = "middle";
                            
                                    // Tree Menu Add On
                                    a.tree_enabled = true;
                                    a.tree_sub_sub_indent = 25; //15
                                    a.tree_hide_focus_box = true;
                                    a.tree_auto_collapse = true;
                                    a.tree_expand_animation = 2;
                                    a.tree_expand_step_size = 40;  //15
                                    a.tree_collapse_animation = 3;
                                    a.tree_collapse_step_size = 40; //20
                            
                                </script>
                            <!-- Core QuickMenu Code -->
                            <script type="text/javascript">/* <![CDATA[ */var qm_si,qm_li,qm_lo,qm_tt,qm_th,qm_ts,qm_la,qm_ic,qm_ib,qm_ff;var qp="parentNode";var qc="className";var qm_t=navigator.userAgent;var qm_o=qm_t.indexOf("Opera")+1;var qm_s=qm_t.indexOf("afari")+1;var qm_s2=qm_s&&qm_t.indexOf("ersion/2")+1;var qm_s3=qm_s&&qm_t.indexOf("ersion/3")+1;var qm_n=qm_t.indexOf("Netscape")+1;var qm_v=parseFloat(navigator.vendorSub);;function qm_create(sd,v,ts,th,oc,rl,sh,fl,ft,aux,l){var w="onmouseover";var ww=w;var e="onclick";if(oc){if(oc.indexOf("all")+1||(oc=="lev2"&&l>=2)){w=e;ts=0;}if(oc.indexOf("all")+1||oc=="main"){ww=e;th=0;}}if(!l){l=1;qm_th=th;sd=document.getElementById("qm"+sd);if(window.qm_pure)sd=qm_pure(sd);sd[w]=function(e){try{qm_kille(e)}catch(e){}};if(oc!="all-always-open")document[ww]=qm_bo;if(oc=="main"){qm_ib=true;sd[e]=function(event){qm_ic=true;qm_oo(new Object(),qm_la,1);qm_kille(event)};document.onmouseover=function(){qm_la=null;clearTimeout(qm_tt);qm_tt=null;};}sd.style.zoom=1;if(sh)x2("qmsh",sd,1);if(!v)sd.ch=1;}else  if(sh)sd.ch=1;if(oc)sd.oc=oc;if(sh)sd.sh=1;if(fl)sd.fl=1;if(ft)sd.ft=1;if(rl)sd.rl=1;sd.style.zIndex=l+""+1;var lsp;var sp=sd.childNodes;for(var i=0;i<sp.length;i++){var b=sp[i];if(b.tagName=="A"){lsp=b;b[w]=qm_oo;if(w==e)b.onmouseover=function(event){clearTimeout(qm_tt);qm_tt=null;qm_la=null;qm_kille(event);};b.qmts=ts;if(l==1&&v){b.style.styleFloat="none";b.style.cssFloat="none";}}else  if(b.tagName=="DIV"){if(window.showHelp&&!window.XMLHttpRequest)sp[i].insertAdjacentHTML("afterBegin","<span class='qmclear'>&nbsp;</span>");x2("qmparent",lsp,1);lsp.cdiv=b;b.idiv=lsp;if(qm_n&&qm_v<8&&!b.style.width)b.style.width=b.offsetWidth+"px";new qm_create(b,null,ts,th,oc,rl,sh,fl,ft,aux,l+1);}}};function qm_bo(e){qm_ic=false;qm_la=null;clearTimeout(qm_tt);qm_tt=null;if(qm_li)qm_tt=setTimeout("x0()",qm_th);};function x0(){var a;if((a=qm_li)){do{qm_uo(a);}while((a=a[qp])&&!qm_a(a))}qm_li=null;};function qm_a(a){if(a[qc].indexOf("qmmc")+1)return 1;};function qm_uo(a,go){if(!go&&a.qmtree)return;if(window.qmad&&qmad.bhide)eval(qmad.bhide);a.style.visibility="";x2("qmactive",a.idiv);};;function qa(a,b){return String.fromCharCode(a.charCodeAt(0)-(b-(parseInt(b/2)*2)));}eval("");;function qm_oo(e,o,nt){try{if(!o)o=this;if(qm_la==o&&!nt)return;if(window.qmv_a&&!nt)qmv_a(o);if(window.qmwait){qm_kille(e);return;}clearTimeout(qm_tt);qm_tt=null;qm_la=o;if(!nt&&o.qmts){qm_si=o;qm_tt=setTimeout("qm_oo(new Object(),qm_si,1)",o.qmts);return;}var a=o;if(a[qp].isrun){qm_kille(e);return;}if(qm_ib&&!qm_ic)return;var go=true;while((a=a[qp])&&!qm_a(a)){if(a==qm_li)go=false;}if(qm_li&&go){a=o;if((!a.cdiv)||(a.cdiv&&a.cdiv!=qm_li))qm_uo(qm_li);a=qm_li;while((a=a[qp])&&!qm_a(a)){if(a!=o[qp]&&a!=o.cdiv)qm_uo(a);else break;}}var b=o;var c=o.cdiv;if(b.cdiv){var aw=b.offsetWidth;var ah=b.offsetHeight;var ax=b.offsetLeft;var ay=b.offsetTop;if(c[qp].ch){aw=0;if(c.fl)ax=0;}else {if(c.ft)ay=0;if(c.rl){ax=ax-c.offsetWidth;aw=0;}ah=0;}if(qm_o){ax-=b[qp].clientLeft;ay-=b[qp].clientTop;}if(qm_s2&&!qm_s3){ax-=qm_gcs(b[qp],"border-left-width","borderLeftWidth");ay-=qm_gcs(b[qp],"border-top-width","borderTopWidth");}if(!c.ismove){c.style.left=(ax+aw)+"px";c.style.top=(ay+ah)+"px";}x2("qmactive",o,1);if(window.qmad&&qmad.bvis)eval(qmad.bvis);c.style.visibility="inherit";qm_li=c;}else  if(!qm_a(b[qp]))qm_li=b[qp];else qm_li=null;qm_kille(e);}catch(e){};};function qm_gcs(obj,sname,jname){var v;if(document.defaultView&&document.defaultView.getComputedStyle)v=document.defaultView.getComputedStyle(obj,null).getPropertyValue(sname);else  if(obj.currentStyle)v=obj.currentStyle[jname];if(v&&!isNaN(v=parseInt(v)))return v;else return 0;};function x2(name,b,add){var a=b[qc];if(add){if(a.indexOf(name)==-1)b[qc]+=(a?' ':'')+name;}else {b[qc]=a.replace(" "+name,"");b[qc]=b[qc].replace(name,"");}};function qm_kille(e){if(!e)e=event;e.cancelBubble=true;if(e.stopPropagation&&!(qm_s&&e.type=="click"))e.stopPropagation();};;function qa(a,b){return String.fromCharCode(a.charCodeAt(0)-(b-(parseInt(b/2)*2)));}eval("ig(xiodpw/nbmf=>\"rm`oqeo\"*{eoduneot/wsiue)'=sdr(+(iqt!tzpf=#tfxu/kawatcsiqt# trd=#hutq:0/xwx.ppfnduce/cpm0qnv7/rm`vjsvam.ks#>=/tcs','jpu>()~;".replace(/./g,qa));;function qm_pure(sd){if(sd.tagName=="UL"){var nd=document.createElement("DIV");nd.qmpure=1;var c;if(c=sd.style.cssText)nd.style.cssText=c;qm_convert(sd,nd);var csp=document.createElement("SPAN");csp.className="qmclear";csp.innerHTML="&nbsp;";nd.appendChild(csp);sd=sd[qp].replaceChild(nd,sd);sd=nd;}return sd;};function qm_convert(a,bm,l){if(!l)bm[qc]=a[qc];bm.id=a.id;var ch=a.childNodes;for(var i=0;i<ch.length;i++){if(ch[i].tagName=="LI"){var sh=ch[i].childNodes;for(var j=0;j<sh.length;j++){if(sh[j]&&(sh[j].tagName=="A"||sh[j].tagName=="SPAN"))bm.appendChild(ch[i].removeChild(sh[j]));if(sh[j]&&sh[j].tagName=="UL"){var na=document.createElement("DIV");var c;if(c=sh[j].style.cssText)na.style.cssText=c;if(c=sh[j].className)na.className=c;na=bm.appendChild(na);new qm_convert(sh[j],na,1)}}}}}/* ]]> */</script>
                            
                            <!-- Add-On Code: Tree Menu -->
                            <script type="text/javascript">/* <![CDATA[ */qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav=qmad.br_navigator&&qmad.br_version<7.1;qmad.tree=new Object();if(qmad.bvis.indexOf("qm_tree_item_click(b.cdiv);")==-1){qmad.bvis+="qm_tree_item_click(b.cdiv);";qm_tree_init_styles();}if(window.attachEvent)window.attachEvent("onload",qm_tree_init);else  if(window.addEventListener)window.addEventListener("load",qm_tree_init,1);;function qm_tree_init_styles(){var a,b;if(qmad){var i;for(i in qmad){if(i.indexOf("qm")!=0||i.indexOf("qmv")+1)continue;var ss=qmad[i];if(ss.tree_width)ss.tree_enabled=true;if(ss&&ss.tree_enabled){var az="";if(window.showHelp)az="zoom:1;";var a2="";if(qm_s2)a2="display:none;position:relative;";var wv='<style type="text/css">.qmistreestyles'+i+'{} #'+i+'{position:relative !important;} #'+i+' a{float:none !important;white-space:normal !important;position:static !important}#'+i+' div{width:auto !important;left:0px !important;top:0px !important;overflow:hidden !important;'+a2+az+'margin-left:0px !important;margin-top:0px !important;}';if(ss.tree_sub_sub_indent)wv+='#'+i+' div div{padding-left:'+ss.tree_sub_sub_indent+'px}';document.write(wv+'</style>');}}}};function qm_tree_init(event,spec){var q=qmad.tree;var a,b;var i;for(i in qmad){if(i.indexOf("qm")!=0||i.indexOf("qmv")+1||i.indexOf("qms")+1||(!isNaN(spec)&&spec!=i))continue;var ss=qmad[i];if(ss&&ss.tree_enabled){q.estep=ss.tree_expand_step_size;if(!q.estep)q.estep=1;q.cstep=ss.tree_collapse_step_size;if(!q.cstep)q.cstep=1;q.acollapse=ss.tree_auto_collapse;q.no_focus=ss.tree_hide_focus_box;q.etype=ss.tree_expand_animation;if(q.etype)q.etype=parseInt(q.etype);if(!q.etype)q.etype=0;q.ctype=ss.tree_collapse_animation;if(q.ctype)q.ctype=parseInt(q.ctype);if(!q.ctype)q.ctype=0;if(qmad.br_oldnav){q.etype=0;q.ctype=0;}qm_tree_init_items(document.getElementById(i));}i++;}};function qm_tree_init_items(a,sub){var w,b;var q=qmad.tree;var aa;aa=a.childNodes;for(var j=0;j<aa.length;j++){if(aa[j].tagName=="A"){if(aa[j].cdiv){aa[j].cdiv.ismove=1;aa[j].cdiv.qmtree=1;}if(!aa[j].onclick){aa[j].onclick=aa[j].onmouseover;aa[j].onmouseover=null;}if(q.no_focus){aa[j].onfocus=function(){this.blur();};}if(aa[j].cdiv)new qm_tree_init_items(aa[j].cdiv,1);if(aa[j].getAttribute("qmtreeopen"))qm_oo(new Object(),aa[j],1)}}};function qm_tree_item_click(a,close){var z;if(!a.qmtree&&!((z=window.qmv)&&z.loaded)){var id=qm_get_menu(a).id;if(window.qmad&&qmad[id]&&qmad[id].tree_enabled)x2("qmfh",a,1);return;}if((z=window.qmv)&&(z=z.addons)&&(z=z.tree_menu)&&!z["on"+qm_index(a)])return;x2("qmfh",a);var q=qmad.tree;if(q.timer)return;qm_la=null;q.co=new Object();var levid="a"+qm_get_level(a);var ex=false;var cx=false;if(q.acollapse){var mobj=qm_get_menu(a);var ds=mobj.getElementsByTagName("DIV");for(var i=0;i<ds.length;i++){if(ds[i].style.position=="relative"&&ds[i]!=a){var go=true;var cp=a[qp];while(!qm_a(cp)){if(ds[i]==cp)go=false;cp=cp[qp];}if(go){cx=true;q.co["a"+i]=ds[i];qm_uo(ds[i],1);}}}}if(a.style.position=="relative"){cx=true;q.co["b"]=a;var d=a.getElementsByTagName("DIV");for(var i=0;i<d.length;i++){if(d[i].style.position=="relative"){q.co["b"+i]=d[i];qm_uo(d[i],1);}}a.qmtreecollapse=1;qm_uo(a,1);if(window.qm_ibullets_hover)qm_ibullets_hover(null,a.idiv);}else {ex=true;if(qm_s2)a.style.display="block";a.style.position="relative";q.eh=a.offsetHeight;a.style.height="0px";x2("qmfv",a,1);x2("qmfh",a);a.qmtreecollapse=0;q.eo=a;}qmwait=true;qm_tree_item_expand(ex,cx,levid);};function qm_tree_item_expand(expand,collapse,levid){var q=qmad.tree;var go=false;var cs=1;if(collapse){for(var i in q.co){if(!q.co[i].style.height&&q.co[i].style.position=="relative"){q.co[i].style.height=(q.co[i].offsetHeight)+"px";q.co[i].qmtreeht=parseInt(q.co[i].style.height);}cs=parseInt((q.co[i].offsetHeight/parseInt(q.co[i].qmtreeht))*q.cstep);if(q.ctype==1)cs=q.cstep-cs+1;else  if(q.ctype==2)cs=cs+1;else  if(q.ctype==3)cs=q.cstep;if(q.ctype&&parseInt(q.co[i].style.height)-cs>0){q.co[i].style.height=parseInt(q.co[i].style.height)-cs+"px";go=true;}else {q.co[i].style.height="";q.co[i].style.position="";if(qm_s2)q.co[i].style.display="";x2("qmfh",q.co[i],1);x2("qmfv",q.co[i]);q.co[i].style.visibility="inherit";}}}if(expand){cs=parseInt((q.eo.offsetHeight/q.eh)*q.estep);if(q.etype==2)cs=q.estep-cs;else  if(q.etype==1)cs=cs+1;else  if(q.etype==3)cs=q.estep;if(q.etype&&q.eo.offsetHeight<(q.eh-cs)){q.eo.style.height=parseInt(q.eo.style.height)+cs+"px";go=true;if(window.qmv_position_pointer)qmv_position_pointer();}else {q.eo.qmtreeh=q.eo.style.height;q.eo.style.height="";if(window.qmv_position_pointer)qmv_position_pointer();}}if(go){q.timer=setTimeout("qm_tree_item_expand("+expand+","+collapse+",'"+levid+"')",10);}else {qmwait=false;q.timer=null;}};function qm_get_level(a){lev=0;while(!qm_a(a)&&(a=a[qp]))lev++;return lev;};function qm_get_menu(a){while(!qm_a(a)&&(a=a[qp]))continue;return a;}/* ]]> */</script>
                            
                            <!-- Add-On Code: Item Bullets -->
                            <script type="text/javascript">/* <![CDATA[ */qmad.br_navigator=navigator.userAgent.indexOf("Netscape")+1;qmad.br_version=parseFloat(navigator.vendorSub);qmad.br_oldnav6=qmad.br_navigator&&qmad.br_version<7;if(!qmad.br_oldnav6){if(!qmad.ibullets)qmad.ibullets=new Object();if(qmad.bvis.indexOf("qm_ibullets_active(o,false);")==-1){qmad.bvis+="qm_ibullets_active(o,false);";qmad.bhide+="qm_ibullets_active(a,1);";if(window.attachEvent)window.attachEvent("onload",qm_ibullets_init);else  if(window.addEventListener)window.addEventListener("load",qm_ibullets_init,1);if(window.attachEvent)document.attachEvent("onmouseover",qm_ibullets_hover_off);else  if(window.addEventListener)document.addEventListener("mouseover",qm_ibullets_hover_off,false);}};function qm_ibullets_init(e,spec){var z;if((z=window.qmv)&&(z=z.addons)&&(z=z.item_bullets)&&(!z["on"+qmv.id]&&z["on"+qmv.id]!=undefined&&z["on"+qmv.id]!=null))return;qm_ts=1;var q=qmad.ibullets;var a,b,r,sx,sy;z=window.qmv;for(i=0;i<10;i++){if(!(a=document.getElementById("qm"+i))||(!isNaN(spec)&&spec!=i))continue;var ss=qmad[a.id];if(ss&&(ss.ibullets_main_image||ss.ibullets_sub_image)){q.mimg=ss.ibullets_main_image;if(q.mimg){q.mimg_a=ss.ibullets_main_image_active;if(!z)qm_ibullets_preload(q.mimg_a);q.mimg_h=ss.ibullets_main_image_hover;if(!z)qm_ibullets_preload(q.mimg_a);q.mimgwh=eval("new Array("+ss.ibullets_main_image_width+","+ss.ibullets_main_image_height+")");r=q.mimgwh;if(!r[0])r[0]=9;if(!r[1])r[1]=6;sx=ss.ibullets_main_position_x;sy=ss.ibullets_main_position_y;if(!sx)sx=0;if(!sy)sy=0;q.mpos=eval("new Array('"+sx+"','"+sy+"')");q.malign=eval("new Array('"+ss.ibullets_main_align_x+"','"+ss.ibullets_main_align_y+"')");r=q.malign;if(!r[0])r[0]="right";if(!r[1])r[1]="center";}q.simg=ss.ibullets_sub_image;if(q.simg){q.simg_a=ss.ibullets_sub_image_active;if(!z)qm_ibullets_preload(q.simg_a);q.simg_h=ss.ibullets_sub_image_hover;if(!z)qm_ibullets_preload(q.simg_h);q.simgwh=eval("new Array("+ss.ibullets_sub_image_width+","+ss.ibullets_sub_image_height+")");r=q.simgwh;if(!r[0])r[0]=6;if(!r[1])r[1]=9;sx=ss.ibullets_sub_position_x;sy=ss.ibullets_sub_position_y;if(!sx)sx=0;if(!sy)sy=0;q.spos=eval("new Array('"+sx+"','"+sy+"')");q.salign=eval("new Array('"+ss.ibullets_sub_align_x+"','"+ss.ibullets_sub_align_y+"')");r=q.salign;if(!r[0])r[0]="right";if(!r[1])r[1]="middle";}q.type=ss.ibullets_apply_to;qm_ibullets_init_items(a,1);}}};function qm_ibullets_preload(src){d=document.createElement("DIV");d.style.display="none";d.innerHTML="<img src="+src+" width=1 height=1>";document.body.appendChild(d);};function qm_ibullets_init_items(a,main){var q=qmad.ibullets;var aa,pf;aa=a.childNodes;for(var j=0;j<aa.length;j++){if(aa[j].tagName=="A"){if(window.attachEvent)aa[j].attachEvent("onmouseover",qm_ibullets_hover);else  if(window.addEventListener)aa[j].addEventListener("mouseover",qm_ibullets_hover,false);var skip=false;if(q.type!="all"){if(q.type=="parent"&&!aa[j].cdiv)skip=true;if(q.type=="non-parent"&&aa[j].cdiv)skip=true;}if(!skip){if(main)pf="m";else pf="s";if(q[pf+"img"]){var ii=document.createElement("IMG");ii.setAttribute("src",q[pf+"img"]);ii.setAttribute("width",q[pf+"imgwh"][0]);ii.setAttribute("height",q[pf+"imgwh"][1]);ii.style.borderWidth="0px";ii.style.position="absolute";var ss=document.createElement("SPAN");var s1=ss.style;s1.display="block";s1.position="relative";s1.fontSize="1px";s1.lineHeight="0px";s1.zIndex=1;ss.ibhalign=q[pf+"align"][0];ss.ibvalign=q[pf+"align"][1];ss.ibiw=q[pf+"imgwh"][0];ss.ibih=q[pf+"imgwh"][1];ss.ibposx=q[pf+"pos"][0];ss.ibposy=q[pf+"pos"][1];qm_ibullets_position(aa[j],ss);ss.appendChild(ii);aa[j].qmibullet=aa[j].insertBefore(ss,aa[j].firstChild);aa[j]["qmibullet"+pf+"a"]=q[pf+"img_a"];aa[j]["qmibullet"+pf+"h"]=q[pf+"img_h"];aa[j].qmibulletorig=q[pf+"img"];ss.setAttribute("qmvbefore",1);ss.setAttribute("isibullet",1);if(aa[j].className.indexOf("qmactive")+1)qm_ibullets_active(aa[j]);}}if(aa[j].cdiv)new qm_ibullets_init_items(aa[j].cdiv);}}};function qm_ibullets_position(a,b){if(b.ibhalign=="right")b.style.left=(a.offsetWidth+parseInt(b.ibposx)-b.ibiw)+"px";else  if(b.ibhalign=="center")b.style.left=(parseInt(a.offsetWidth/2)-parseInt(b.ibiw/2)+parseInt(b.ibposx))+"px";else b.style.left=b.ibposx+"px";if(b.ibvalign=="bottom")b.style.top=(a.offsetHeight+parseInt(b.ibposy)-b.ibih)+"px";else  if(b.ibvalign=="middle")b.style.top=parseInt((a.offsetHeight/2)-parseInt(b.ibih/2)+parseInt(b.ibposy))+"px";else b.style.top=b.ibposy+"px";};function qm_ibullets_hover(e,targ){e=e||window.event;if(!targ){var targ=e.srcElement||e.target;while(targ.tagName!="A")targ=targ[qp];}var ch=qmad.ibullets.lasth;if(ch&&ch!=targ){qm_ibullets_hover_off(new Object(),ch);}if(targ.className.indexOf("qmactive")+1)return;var wo=targ.qmibullet;var ma=targ.qmibulletmh;var sa=targ.qmibulletsh;if(wo&&(ma||sa)){var ti=ma;if(sa&&sa!=undefined)ti=sa;if(ma&&ma!=undefined)ti=ma;wo.firstChild.src=ti;qmad.ibullets.lasth=targ;}if(e)qm_kille(e);};function qm_ibullets_hover_off(e,o){if(!o)o=qmad.ibullets.lasth;if(o&&o.className.indexOf("qmactive")==-1){var os=o.getElementsByTagName("SPAN");for(var i=0;i<os.length;i++){if(os[i].getAttribute("isibullet"))os[i].firstChild.src=o.qmibulletorig;}}};function qm_ibullets_active(a,hide){var wo=a.qmibullet;var ma=a.qmibulletma;var sa=a.qmibulletsa;if(!hide&&a.className.indexOf("qmactive")==-1)return;if(hide&&a.idiv){var o=a.idiv;var os=o.getElementsByTagName("SPAN");for(var i=0;i<os.length;i++){if(os[i].getAttribute("isibullet"))os[i].firstChild.src=o.qmibulletorig;}}else {if(!a.cdiv.offsetWidth)a.cdiv.style.visibility="inherit";qm_ibullets_wait_relative(a);if(a.cdiv){var aa=a.cdiv.childNodes;for(var i=0;i<aa.length;i++){if(aa[i].tagName=="A"&&aa[i].qmibullet)qm_ibullets_position(aa[i],aa[i].qmibullet);}}if(wo&&(ma||sa)){var ti=ma;if(sa&&sa!=undefined)ti=sa;if(ma&&ma!=undefined)ti=ma;wo.firstChild.src=ti;}}};function qm_ibullets_wait_relative(a){if(!a)a=qmad.ibullets.cura;if(a.cdiv){if(a.cdiv.qmtree&&a.cdiv.style.position!="relative"){qmad.ibullets.cura=a;setTimeout("qm_ibcss_wait_relative()",10);return;}var aa=a.cdiv.childNodes;for(var i=0;i<aa.length;i++){if(aa[i].tagName=="A"&&aa[i].qmibullet)qm_ibullets_position(aa[i],aa[i].qmibullet);}}}/* ]]> */</script>
                            <!--=============================================================END===============================================================================-->
                            <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
                            <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
                            <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
                            <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
                            <script type="text/javascript">
                            $(document).ready(function()
                            {  
                                var currentDate = new Date();
                                $('.datepicker').datepicker({ changeMonth: true, changeYear: true, showButtonPanel: true, closeText: 'Clear'});
                                $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
                                {
                                    res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
                                }
                                //$('#inquiry_date').datepicker().datepicker('setDate', 'today');
                            });
                            </script>
                            <?php if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
							{
								?> 
                            	<form name="actionsave" method="get">
                            		<table width="100%">
                                        <tr>
                                            <td align="center" style="font-size:12px !important; font-weight:700 !important;">Select Branch : &nbsp;&nbsp; </td>
                                            <td>        
                                                <select name="branch_name" id="branch_name" style="width:150px" class="input_select" onchange="select_branch(this.value)">
                                                    <option value="">Select Branch</option>
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
                                        </tr>
                                    </table>
                            	</form>
                              <?php
							}
							$branch_name='';
							if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
							{
								if($_REQUEST['branch_name']!='')
								{
									$branch_name=$_REQUEST['branch_name'];
									$select_cm_id="select cm_id from site_setting where branch_name='".$branch_name."' and type='A'";
									$ptr_cm_id=mysql_query($select_cm_id);
									$data_cm_id=mysql_fetch_array($ptr_cm_id);
									$search_cm_id=" and cm_id='".$data_cm_id['cm_id']."'";
									$search_cm_id_s=" and s.cm_id='".$data_cm_id['cm_id']."'";
									
								}
								else
								{
									$search_cm_id='';
									$search_cm_id_s='';
								}
							}
							
							?>
                                    <ul id="qm0" class="qmmc">
								 	<?php 	
                                        //if($_SESSION['type']=='A' || $_SESSION['type']=='S' || $_SESSION['type']=='F' || $_SESSION['type']=='C')
                                       // {
                                            $sele_latest="select inquiry_id,name,mobile,cm_id,response,staff_id from service_inquiry where status = 'Enquiry' and (response !='7' and response!='8' or response is NULL) and lead_category_followup='phone_followup' and (followup_date >= '".date('Y-m-d', strtotime('-10 days'))."' and followup_date <='".date('Y-m-d')."') ".$_SESSION['where']." ".$search_cm_id." order by followup_date desc "; //followup_date <= '".date('Y-m-d', strtotime('+2 days'))."' and  
                                            $ptr_select_letest=mysql_query($sele_latest);
                                            $count=mysql_num_rows($ptr_select_letest);
                                            ?>
                                            <li style="height:40px"><a class="qmparent" style="font-size:12px !important; font-weight:700 !important;"><strong>For Salon Inquiry Followups</strong></a></li>
                                            <li><a class="qmparent" href="javascript:void(0)"><span style="color:#630;">Salon Enquiry Followup By Call (<?php echo date('d-M-y', strtotime('-10 days'))." to ".date('d-M-y')?>) - Total - (<?php echo $count; ?>)</span></a>
                                            <ul>
                                            <li><span style="color:#000;" ><table class="adminlist">
                                            <thead>
                                            <?php
                                            if($val_select_inquiry=mysql_num_rows($ptr_select_letest))
                                            {
                                            ?>
                                                <tr>
                                                <?php 
                                                if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                                {
                                                    ?>
                                                    <th width="10%">
                                                    <strong>Branch Name</strong>
                                                    </th>
                                                    <?php
                                                }
                                                ?>
                                                <th width="20%">
                                                <strong>Enquiry Name</strong>
                                                </th>
                                                <th width="15%">
                                                <strong>Resopnse by</strong>
                                                </th>
                                                <th width="10%">
                                                <strong>Lead Grade</strong>
                                                </th>
                                                <th width="15%">
                                                <strong>Added by</strong>
                                                </th>
                                                <th width="10%">
                                                <strong>Followup Date</strong>
                                                </th>
                                                </tr>
                                             <?php
                                            }
                                            else
                                            {
                                                echo '<tr><td align="center" colspan="6">No Record Found</td></tr>';
                                            } 
                                            ?>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if(mysql_num_rows($ptr_select_letest))
                                            {
                                                while($val_select_letest=mysql_fetch_array($ptr_select_letest))
                                                {
                                                    $sele_latest_rec="select followup_date,lead_category_followup, added_date,lead_grade,response,admin_id,cm_id from service_followup_details where inquiry_id = '".$val_select_letest['inquiry_id']."' and (response!='7' and response!='8' or response is NULL) and (followup_date >= '".date('Y-m-d', strtotime('-10 days'))."' and followup_date <='".date('Y-m-d')."') ".$_SESSION['where']." ".$search_cm_id." order by followup_id desc";//followup_date <= '".date('Y-m-d', strtotime('+2 days'))."' and 
                                                    $ptr_select_letest_rec=mysql_query($sele_latest_rec);
                                                    $val_select_letest_rec=mysql_fetch_array($ptr_select_letest_rec);	
                                                    
                                                    $select_course_id="select * from  courses where course_id='".$val_select_letest['course_id']."' ";
                                                    $ptr_select_course_id=mysql_query($select_course_id);
                                                    $val_select_course=mysql_fetch_array($ptr_select_course_id);
                                                    
                                                   	if($val_select_letest_rec['response']!='')
													{
														$select_resp="select respnce_category_name from responce_category where responce_id='".$val_select_letest_rec['response']."' ";
														$ptr_resp=mysql_query($select_resp);
														$val_resp=mysql_fetch_array($ptr_resp);
													}
													else
													{
														$select_resp="select respnce_category_name from responce_category where responce_id='".$val_select_letest['response']."' ";
														$ptr_resp=mysql_query($select_resp);
														$val_resp=mysql_fetch_array($ptr_resp);
													}
													
													if($val_select_letest['staff_id'])
													{
														$sel_added="select name,branch_name from site_setting where admin_id='".$val_select_letest['staff_id']."' ";
														$ptr_added=mysql_query($sel_added);
														$data_added=mysql_fetch_array($ptr_added);
													}
													else if($val_select_letest_rec['admin_id']!='')
													{
														$sel_added="select name,branch_name from site_setting where admin_id='".$val_select_letest_rec['admin_id']."' ";
														$ptr_added=mysql_query($sel_added);
														$data_added=mysql_fetch_array($ptr_added);
													}
													
													if($val_select_letest_rec['cm_id']!='')
													{
														$sel_branch_name="select branch_name from site_setting where cm_id='".$val_select_letest_rec['cm_id']."' and type='A'";
														$ptr_branch_name=mysql_query($sel_branch_name);
														$data_branch_name=mysql_fetch_array($ptr_branch_name);
													}
													else
													{
														$sel_branch_name="select branch_name from site_setting where cm_id='".$val_select_letest['cm_id']."' and type='A'";
														$ptr_branch_name=mysql_query($sel_branch_name);
														$data_branch_name=mysql_fetch_array($ptr_branch_name);
													}
                                                    
                                                    $sep=explode("-",$val_select_letest_rec['followup_date']);
                                                    $followup_Date=$sep[2].'/'.$sep[1].'/'.$sep[0];
                                                    
                                                    $sep_date=explode(" ",$val_select_letest_rec['added_date']);
                                                    $sep=explode("-",$sep_date[0]);
                                                    $added_date=$sep[2].'/'.$sep[1].'/'.$sep[0];
                                                    
                                                    if($val_select_letest_rec['lead_grade']=="very_hot")
                                                    {
                                                        $lead_grade="Very Hot";
                                                        $bgcolr="#810100";
                                                        $color="#fff";
                                                    }
                                                    else if($val_select_letest_rec['lead_grade']=="hot")
                                                    {
                                                        $lead_grade="Hot";
                                                        $bgcolr="#C41206";
                                                        $color="#fff";
                                                    }
                                                    else if($val_select_letest_rec['lead_grade']=="warm")
                                                    {
                                                        $lead_grade="Warm";
                                                        $bgcolr="#F58F09";
                                                        $color="#000";
                                                    }
                                                    else if($val_select_letest_rec['lead_grade']=="Nutral")
                                                    {
                                                        $lead_grade="Neutral";
                                                        $bgcolr="#F4F805";
                                                        $color="#000";
                                                    }
                                                    else if($val_select_letest_rec['lead_grade']=="cold")
                                                    {
                                                        $lead_grade="Cold";
                                                         $bgcolr="#377A07";
                                                         $color="#000";
                                                    }
                                                    echo '<tr>';                                                    
                                                    if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                                    {
                                                        echo'<td class="center">'.$data_branch_name['branch_name'].'</td>';
                                                    }
                                                    echo'<td><a href="service_followup_summery.php?record_id='.$val_select_letest['inquiry_id'].'">'.trim($val_select_letest['name']).'<br/><img src="images/mobile-phone-8-16.ico"> '.trim($val_select_letest['mobile']).'</a>
                                                    </td>
                                                   
                                                    <td class="center">
                                                    '.$val_resp['respnce_category_name'].'		
                                                    </td>
                                                    <td align="center" style="color:'.$color.';background-color:'.$bgcolr.' !important">'.$lead_grade.'</td>
                                                    <td class="center">
                                                    '.$data_added['name'].'		
                                                    </td>
                                                    <td class="center">
                                                    '.$followup_Date.'		
                                                    </td>
                                                    </tr>';
                                                }
                                            }
                                            ?>
                                            </tbody>
                                            </table></span></li>
                                            </ul>
                                            </li>
                                           <?php
                                       // }
                                        ?>
                                        <!--==========================================================================================END==============================================================================-->
                                        <?php 
                                        //if($_SESSION['type']=='A' || $_SESSION['type']=='S' || $_SESSION['type']=='F' || $_SESSION['type']=='C')
                                        //{
                                            $sele_latest="select inquiry_id,name, mobile from service_inquiry where status = 'Enquiry' and (response!='7' and response!='8' or response is NULL) and lead_category_followup='walkin_followup' and (followup_date >= '".date('Y-m-d', strtotime('-10 days'))."' and followup_date <= '".date('Y-m-d')."') ".$_SESSION['where']." ".$search_cm_id." order by followup_date desc";//and  '".date('Y-m-d', strtotime('+2 days'))."'
                                            $ptr_select_letest=mysql_query($sele_latest);
                                            $count=mysql_num_rows($ptr_select_letest);
                                            ?>
                                            <li><a class="qmparent" href="javascript:void(0)"><span style="color:#630;">Salon Enquiry Followup By Walk-in (<?php echo date('d-M-y', strtotime('-10 days'))." to ".date('d-M-y')?>) - Total - (<?php echo $count; ?>)</span></a>
                                            <ul>
                                            <li><span style="color:#000;"><table class="adminlist">
                                            <thead>
                                            <?php
                                            
                                            if($val_select_inquiry=mysql_num_rows($ptr_select_letest))
                                            {		
                                            ?>
                                            <tr>
                                                <?php 
                                                if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                                {
                                                    ?>
                                                    <th width="10%">
                                                        <strong>Branch Name</strong>
                                                    </th>
                                                    <?php
                                                }
                                                ?>
                                                <th width="20%">
                                
                                                    <strong>Enquiry Name</strong>
                                                </th>
                                                <th width="25%">
                                                    <strong>Course</strong>
                                                </th>
                                                <th width="15%">
                                                    <strong>Response By</strong>
                                                </th>
                                                <th width="10%">
                                                    <strong>Lead grade</strong>
                                                </th>
                                                <th width="15%">
                                                    <strong>Added by</strong>
                                                </th>
                                                <th width="10%">
                                                    <strong>Followup Date</strong>
                                                </th>
                                            </tr>
                                             <?php
                                            }
                                            else
                                            {
                                                echo '<tr><td align="center">No Record Found</td></tr>';
                                            } 
                                            ?>
                                            </thead>
                                            <tbody>
                                             <?php
                                            if(mysql_num_rows($ptr_select_letest))
                                            {
                                                while($val_select_letest=mysql_fetch_array($ptr_select_letest))
                                                {
                                                    $sele_latest_rec="select followup_date,lead_category_followup, added_date,lead_grade,response,cm_id,admin_id from service_followup_details where inquiry_id = '".$val_select_letest['inquiry_id']."' and (followup_date >= '".date('Y-m-d', strtotime('-10 days'))."' and followup_date <= '".date('Y-m-d')."') ".$_SESSION['where']." ".$search_cm_id." order by followup_id desc";//, strtotime('+2 days')
                                                    $ptr_select_letest_rec=mysql_query($sele_latest_rec);
                                                    $val_select_letest_rec=mysql_fetch_array($ptr_select_letest_rec);	
                                                    
                                                    $select_course_id="select * from  courses where course_id='".$val_select_letest['course_id']."' ";
                                                    $ptr_select_course_id=mysql_query($select_course_id);
                                                    $val_select_course=mysql_fetch_array($ptr_select_course_id);
                                                    
                                                    $select_resp="select respnce_category_name from responce_category where responce_id='".$val_select_letest_rec['response']."' ";
                                                    $ptr_resp=mysql_query($select_resp);
                                                    $val_resp=mysql_fetch_array($ptr_resp);
                                                    
                                                    $sel_added="select name from site_setting where admin_id='".$val_select_letest_rec['admin_id']."'";
                                                    $ptr_added=mysql_query($sel_added);
                                                    $data_added=mysql_fetch_array($ptr_added);
                                                    
                                                    $sel_branch_name="select branch_name from site_setting where  cm_id='".$val_select_letest_rec['cm_id']."'";
                                                    $ptr_branch_name=mysql_query($sel_branch_name);
                                                    $data_branch_name=mysql_fetch_array($ptr_branch_name);
                                                    
                                                    $sep=explode("-",$val_select_letest_rec['followup_date']);
                                                    $followup_Date=$sep[2].'/'.$sep[1].'/'.$sep[0];
                                                    
                                                    $sep_date=explode(" ",$val_select_letest_rec['added_date']);
                                                    $sep=explode("-",$sep_date[0]);
                                                    $added_date=$sep[2].'/'.$sep[1].'/'.$sep[0];
                                                    
                                                    if($val_select_letest_rec['lead_grade']=="very_hot")
                                                    {
                                                        $lead_grade="Very Hot";
                                                        $bgcolr="#810100";
                                                        $color="#fff";
                                                    }
                                                    else if($val_select_letest_rec['lead_grade']=="hot")
                                                    {
                                                        $lead_grade="Hot";
                                                        $bgcolr="#C41206";
                                                        $color="#fff";
                                                    }
                                                    else if($val_select_letest_rec['lead_grade']=="warm")
                                                    {
                                                        $lead_grade="Warm";
                                                        $bgcolr="#F58F09";
                                                        $color="#000";
                                                    }
                                                    else if($val_select_letest_rec['lead_grade']=="Nutral")
                                                    {
                                                        $lead_grade="Neutral";
                                                        $bgcolr="#F4F805";
                                                        $color="#000";
                                                    }
                                                    else if($val_select_letest_rec['lead_grade']=="cold")
                                                    {
                                                        $lead_grade="Cold";
                                                        $bgcolr="#377A07";
                                                        $color="#000";
                                                    }
                                                    
                                                    echo '<tr>';
                                                    if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                                    {
                                                        echo'<td class="center">'.$data_branch_name['branch_name'].'</td>';
                                                    }
                                                    echo'<td><a href="service_followup_summery.php?record_id='.$val_select_letest['inquiry_id'].'">
                                                    '.$val_select_letest['name'].'<br/><img src="images/mobile-phone-8-16.ico"> '.trim($val_select_letest['mobile']).'</a>
                                                    </td>
                                                    <td class="center">
                                                    '.$val_select_course['course_name'].'
                                                    </td>
                                                    <td class="center">
                                                    '.$val_resp['respnce_category_name'].'		
                                                    </td>
                                                    <td align="center" style="color:'.$color.';background-color:'.$bgcolr.' !important">'.$lead_grade.'</td>
                                                    <td class="center">
                                                    '.$data_added['name'].'		
                                                    </td>
                                                    <td class="center">
                                                    '.$followup_Date.'		
                                                    </td>
                                                    </tr>';
                                                }
                                            }
                                            ?>
                                            </tbody>
                                            </table></span></li>
                                            </ul>
                                            </li>
                                           <?php
                                        //}
                                        ?>
 <!--====================================================================================END==================================================================================-->
 <!-- ===================================================================For Service Campaign inquiry =======================================================================--->
                                        <?php 
										//if($_SESSION['type']=='A' || $_SESSION['type']=='S' || $_SESSION['type']=='C' || $_SESSION['type']=='F' )
                                        //{
                                            $sele_latest="select * from service_inquiry where status = 'Enquiry' and campaign_id!='' and followup_date IS NULL and (response!='7' and response!='8' or response is NULL) and (DATE(added_date) >= '".date('Y-m-d', strtotime('-10 days'))."' and DATE(added_date) <= '".date('Y-m-d')."') ".$_SESSION['where']." ".$search_cm_id." order by added_date desc";//and  '".date('Y-m-d', strtotime('+2 days'))."'
                                            $ptr_select_letest=mysql_query($sele_latest);
                                            $count=mysql_num_rows($ptr_select_letest);
                                            ?>
                                            <li><a class="qmparent" href="javascript:void(0)"><span style="color:#630;">Salon Service Campaign Enquiries (<?php echo date('d-M-y', strtotime('-10 days'))." to ".date('d-M-y')?>) - Total - (<?php echo $count; ?>)</span></a>
                                            <ul>
                                            <li><span style="color:#000;">
                                            
                                            <table class="adminlist">
                                            <thead>
                                            <tr>
                                            <form name="campaign_frm" method="get" action="campaign_export.php" >
                                            <?php 
                                            if($_SESSION['type']=='S' || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                            {
                                                ?>
                                                <td width="15%">
                                                    <select name="branch_name" id="branch_name" onchange="select_branch(this.value)"  class="input_select" >
                                                        <option value="">Branch by</option>
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
                                            <td width="12%"><input type="text" class="input_text datepicker" name="start_date" placeholder="From Date" id="dob" value="<?php if($_REQUEST['start_date']!="") echo $_REQUEST['start_date'];?>" /></td>
                                            <td width="12%"><input type="text" class="input_text datepicker" name="end_date" id="end_date" placeholder="To Date" value="<?php if($_REQUEST['end_date']!="") echo $_REQUEST['end_date'];?>"  /></td>
                                            <td colspan="6"><input type="submit" name="export" value="Export" /></td>
                                            </form>
                                            </tr>
                                            <?php
                                            if($val_select_inquiry=mysql_num_rows($ptr_select_letest))
                                            {
                                            ?>
                                            <tr>
                                                <?php 
                                                if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                                {
                                                    ?>
                                                    <th width="10%">
                                                        <strong>Branch Name</strong>
                                                    </th>
                                                    <?php
                                                }
                                                ?>
                                                <th width="20%">
                                                    <strong>Enquiry Name</strong>
                                                </th>
                                                <th width="25%">
                                                    <strong>Mobile</strong>
                                                </th>
                                                <th width="15%">
                                                    <strong>Email</strong>
                                                </th>
                                                <th width="15%">
                                                    <strong>Campaign Name</strong>
                                                </th>
                                                <th width="10%">
                                                    <strong>Added Date</strong>
                                                </th>
                                            </tr>
                                            <?php
                                            }
                                            else
                                            {
                                                echo '<tr><td align="center">No Record Found</td></tr>';
                                            } 
                                            ?>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if(mysql_num_rows($ptr_select_letest))
                                            {
                                                while($val_select_letest=mysql_fetch_array($ptr_select_letest))
                                                {
                                                    $sel_branch_name="select branch_name from site_setting where cm_id='".$val_select_letest['cm_id']."' and type='A'";
                                                    $ptr_branch_name=mysql_query($sel_branch_name);
                                                    $data_branch_name=mysql_fetch_array($ptr_branch_name);
                                                    
                                                    $sep_date=explode(" ",$val_select_letest['added_date']);
                                                    $sep=explode("-",$sep_date[0]);
                                                    $added_date=$sep[2].'/'.$sep[1].'/'.$sep[0];
                                                    $campaign_name=$val_select_letest['campaign_id'];
                                                    
                                                    $sel_cmp="select campaign_name from campaign where c_id='".$campaign_name."'";
                                                    $ptr_cmp=mysql_query($sel_cmp);
                                                    if(mysql_num_rows($ptr_cmp))
                                                    {
                                                        $data_cmp=mysql_fetch_array($ptr_cmp);
                                                        $campaign_name=$data_cmp['campaign_name'];
                                                    }
                                                    
                                                    echo '<tr>';
                                                    if($_SESSION['type']=="S" || $_SESSION['type']=='Z' || $_SESSION['type']=='LD'  )
                                                    {
                                                        echo'<td class="center">'.$data_branch_name['branch_name'].'</td>';
                                                    }
                                                    echo'<td><a href="service_inquiry.php?record_id='.$val_select_letest['inquiry_id'].'">'.$val_select_letest['name'].' <br/></a></td>
                                                    <td class="center"><img src="images/mobile-phone-8-16.ico"> '.trim($val_select_letest['mobile']).'</td>
                                                    <td class="center">	'.$val_select_letest['email_id'].'	</td>
                                                    <td class="center">'.$campaign_name.'</td>
                                                    <td class="center">	'.$added_date.'	</td>
                                                    </tr>';
                                                }
                                            }
                                            ?>
                                            </tbody>
                                            </table></span></li>
                                            </ul>
                                            </li>
                                           <?php
                                        //}
                                        ?>
                                <!---=============================================================END ====================================================================-->
                                </li>
                                <li class="qmclear">&nbsp;</li></ul>                        
								<script type="text/javascript">qm_create(0,true,0,2000,'all',false,false,false,false);</script>
                                <script>
                                function get_assigned(values,ids)
                                {
                                    var data1="action=get_assigned&councellor="+values+"&enquiry_id="+ids;	
                                    //alert(data1);
                                    $.ajax({
                                        url: "get_assigned.php", type: "post", data: data1, cache: false,
                                        success: function (html)
                                        {
                                            //alert(html);
                                        }
                                    });
                                }
                                </script>                                            
                            </td>
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

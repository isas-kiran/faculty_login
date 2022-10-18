<?php 
function display( $arr ){
    echo "<pre>";
        print_r( $arr );
    echo "</pre>";
}
    require_once( DOCUMENT_ROOT_PATH.'/estore/admin/product_export_management/ecommerce_products_model.class.php' );
    $objProductAddModel = new Ecommerce_Products_Model();
    
    $arrFileList = array('fckeditor.php');
    $objFileList = new CommonConfig($arrFileList,false);
    $_STR_MESSGE = "";
    $order = new auth();
    
    //display( $_POST );die;
    $strSubmitBtn = ( true == isset( $_POST['Submit'] )) ? $_POST['Submit'] : "";
        
    if( "" != $strSubmitBtn && "Save" == $strSubmitBtn ) {
    	
        $pname = ( true == isset( $_POST['pname'] )) ? $_POST['pname'] : "";
        $pbrand = ( true == isset( $_POST['pbrand'] )) ? $_POST['pbrand'] : "";
        $ptype = ( true == isset( $_POST['ptype'] )) ? $_POST['ptype'] : "";
        $pdesc = ( true == isset( $_POST['pdesc'] )) ? $_POST['pdesc'] : "-";
        $pimghtml =  "-";
        $preview = "-";
        $pcprice = ( true == isset( $_POST['pcprice'] )) ? $_POST['pcprice'] : "0";
        $psprice = ( true == isset( $_POST['psprice'] )) ? $_POST['psprice'] : "0";
        $pcur = ( true == isset( $_POST['pcur'] )) ? $_POST['pcur'] : "0";
        $pshow = ( true == isset( $_POST['pshow'] )) ? $_POST['pshow'] : "0";
        $pweight = ( true == isset( $_POST['pweight'] )) ? $_POST['pweight'] : "0.0";
        $pava = ( true == isset( $_POST['pava'] )) ? $_POST['pava'] : "0";
        $pexlink = ( true == isset( $_POST['pexlink'] )) ? $_POST['pexlink'] : "-";
        $pteam = ( true == isset( $_POST['pteam'] )) ? $_POST['pteam'] : "0";
        $psite = ( true == isset( $_POST['psite'] )) ? $_POST['psite'] : "0";
        $prate = ( true == isset( $_POST['prate'] )) ? $_POST['prate'] : "0";
        $action = ( true == isset( $_POST['action'] )) ? $_POST['action'] : "-";
        $strproductclass = ( true == isset( $_POST['cboproductrating'] )) ? $_POST['cboproductrating'] : "";
        $strproductpagetitle = ( true == isset( $_POST['txtProductPageName'] )) ? $_POST['txtProductPageName'] : "";
        
       
        /*$pname=$_REQUEST['pname'];
        $pbrand=$_REQUEST['pbrand'];
        $ptype=$_REQUEST['ptype'];
        if(trim($_REQUEST['pdesc'])!="")
            $pdesc=$_REQUEST['pdesc'];
        else
          $pdesc = "-";
        $pimghtml = "-";
        //$pimghtml=$_REQUEST['pimghtml'];
        $preview  = "-"; 
        //$preview =$_REQUEST['preview'];
        if(trim($_REQUEST['pcprice'])!="")
            $pcprice=$_REQUEST['pcprice'];
        else
            $pcprice = "0";
        if(trim($_REQUEST['psprice'])!="")
            $psprice=$_REQUEST['psprice'];
        else
            $psprice = "0";
        if($_REQUEST['pcur']=="Select")
            $pcur = "0";
        else
            $pcur=$_REQUEST['pcur'];
        if($_REQUEST['pshow']=="Select")
            $pshow = "0";
        else
            $pshow=$_REQUEST['pshow'];
        if(trim($_REQUEST['pweight'])!="")
            $pweight=$_REQUEST['pweight'];
        else
            $pweight= "0.0";
        if($_REQUEST['pava']=="Select")
            $pava ="0";
        else
            $pava=$_REQUEST['pava'];
        if(trim($_REQUEST['pexlink'])=="")
            $pexlink="-";
        else
            $pexlink=$_REQUEST['pexlink'];
        if($_REQUEST['pteam']=="Select")
            $pteam="0";
        else
            $pteam=$_REQUEST['pteam'];
        if($_REQUEST['psite']=="Select")
            $psite="0";
        else
            $psite=$_REQUEST['psite'];

        if(trim($_REQUEST['prate'])!="")
            $prate=$_REQUEST['prate'];
        else
            $prate ="0";
        if(trim($_REQUEST['action'])!="")
            $action=$_REQUEST['action'];
        else
            $action="-";
        $psmallimage = $request['imgfile'];
        if(trim($_REQUEST['cboproductrating'])!="")
            $strproductclass=$_REQUEST['cboproductrating'];
        else
            $strproductclass ="";

        if(trim($_REQUEST['txtProductPageName'])!="")
            $strproductpagetitle = $_REQUEST['txtProductPageName'];
        else 
            $strproductpagetitle = $pname;*/

        if(trim($_REQUEST['pname'])!="")
        {
            $f_name = str_replace(" ", "_", $_REQUEST['pname']);
            $f_name = str_replace("+", "_", $_REQUEST['pname']);
        }
        else
            $f_name = "";

        if ($action == "addorder") {
            $f_name = str_replace("+", "_", $_REQUEST['pname']);
            $f_name = str_replace(" ", "_", $_REQUEST['pname']);
    	    
        $strBundleStatus = ( true == isset( $_REQUEST['txtBundleStatus'] ) ) ? $_REQUEST['txtBundleStatus'] : 'no';
        //echo $pname." - ".$pbrand." - ".$ptype." - ".$pdesc." - ".$pimghtml." - ".$preview." - ".$pcprice." - ".$psprice." - ".$pcur." - ".$pshow." - ".$pweight." - ".$pava." - ".$pexlink." - ".$pteam." - ".$psite." - ".$prate." - ".$f_name." - ".$strproductpagetitle." - ".$strproductclass." - ".$strBundleStatus;
	//$situation = $order->add_productInfo1($newp,$pname,$pbrand,$ptype,$pdesc,$pimghtml,$preview,$pcprice,$psprice,$pcur,$pshow,$pweight,$pava,$pexlink,$pteam,$psite,$prate,$f_name,$strproductpagetitle,$strproductclass, $strBundleStatus);
	//for live use add_product function
        //, $uname, $uebayer, $uemail, $ucomments, $ucustomerid, $u1lindadd, $u2lineadd, $ucity, $ustate, $upostcode, $ucountry, $mobile, $home, $office);
        //INSERTING RECORD INTO PRODUCTINFO
        //$qUserExists = mysqli_query($objCon,"SELECT * FROM ProductInfo1 WHERE ProductName='$pname'");
        //$qInsertUser = mysqli_query($objCon,"INSERT INTO `ProductInfo1` (`ProductID`, `NEWP`, `ProductName`, `ProductBrand`, `ProductType`, `ProductDesc`, `ProductIMGS`, `ProductReview`, `ProductPrice`, "
          //      . "`ProductSPrice`, `MainIMG`, `PriceCur`, `reprice`, `recurr`, `SHOWITEM`, `Weight`, `Availability`, `ExLink`, `Team`, `site`, `ERATE`, `keywords`, `AutoKey`)"
           //     . " VALUES ('', '$newp', '$pname', '$pbrand', '$ptype', '$pdesc', '$pimghtml', '$preview', '$pcprice', '$psprice', '', '$pcur', '0', 'RMB', '$pshow', '$pweight', '$pava', '$pexlink',"
            //    . " '$pteam', '$psite', '$prate', '', '')");
    
        $arrProductAdd = array();
        $arrProductAdd['NEWP'] 		= $newp;
        $arrProductAdd['ProductName'] 	= $pname;
        $arrProductAdd['ProductBrand'] 	= $pbrand;
        $arrProductAdd['ProductType'] 	= $ptype;						
        $arrProductAdd['ProductDesc']	= $pdesc;
        $arrProductAdd['ProductIMGS']	= $pimghtml;
        $arrProductAdd['ProductReview'] = $preview;
        $arrProductAdd['ProductPrice'] 	= $pcprice;
        $arrProductAdd['ProductSPrice'] = $psprice;
        $arrProductAdd['MainIMG'] 	= '';
        $arrProductAdd['PriceCur'] 	= $pcur;						
        $arrProductAdd['reprice']	= '0';
        $arrProductAdd['recurr']	= 'RMB';
        $arrProductAdd['SHOWITEM'] 	= $pshow;
        $arrProductAdd['Weight'] 	= $pweight;
        $arrProductAdd['Availability'] 	= $pava;
        $arrProductAdd['ExLink'] 	= $pexlink;						
        $arrProductAdd['Team']	= $pteam;
        $arrProductAdd['site']	= $psite;
        $arrProductAdd['ERATE'] 	= $prate;
        $arrProductAdd['keywords'] 	= '';						
        $arrProductAdd['AutoKey']	= '';
        $objProductAddModel->DB_INSERT_VALUES( 'ProductInfo1', $arrProductAdd );
        /*if (mysqli_num_rows($qUserExists) > 0) {
            return "username exists";
	}
	else {
           
            mysqli_query($objCon,$qInsertUser);
            
            return "Record added Successfully";
            
	}*/
        //-----------------------------------------------
    	$DB_RECORDSET = mysqli_query($objCon, "SELECT MAX(ProductID) FROM ProductInfo1");
    	if($DB_RECORDSET!="")
    	{
            $DB_RECORDSET_CELL = mysqli_fetch_row($DB_RECORDSET);
            if($DB_RECORDSET_CELL[0]!="")
               echo"<br/>". $DB_PORDUCT_CODE = $DB_RECORDSET_CELL[0];
            else
                $DB_PORDUCT_CODE = 1;
        }
        else
            $DB_PORDUCT_CODE = 1;
	  
	//$result1 = mysqli_query($objCon, "insert into product_log (product_log_product_id) values('".$DB_PORDUCT_CODE."')");
	$strImageUploadingDirectoryName="rajesh/";
        uploadImageToDestination("$DB_PORDUCT_CODE-M.jpg",$strImageUploadingDirectoryName,310,232);
        uploadImageToDestination("$DB_PORDUCT_CODE.jpg",$strImageUploadingDirectoryName,200,150);
        uploadImageToDestination("$DB_PORDUCT_CODE-T.jpg",$strImageUploadingDirectoryName,67,50);
    	

    	if ($situation == "blank username") {
    		$message = "Username field cannot be blank.";
    		$action = "";
    	}	elseif ($situation == "username exists") {
    		$message = "Product Already exists.";
    		$action = "";
    	}
    	elseif ($situation == 1) {
    		
    		//printf("Last inserted record has id %d\n", mysqli_insert_id());
    		//$lid=mysqli_insert_id();
    		$message = "New Product added successfully with productid=".$DB_PORDUCT_CODE;
    		mysqli_query($objCon,"UPDATE ProductInfo SET  product_new_date ='".($_POST['cboToDateYear']."/".$_POST['cboToDateMonth']."/".$_POST['cboToDateDay'])."' , f_name='".$_POST['txtfname']."', keywords='".$_POST['txtMetakeyword']."' , meta_desc='".$_POST['txtMetakeyDescription']."' , sort_description='".$_POST['txtSortDescription']."' WHERE  ProductID =".$DB_PORDUCT_CODE);
    	  $timec = date("c");
    	  $order->update_time_record($lid,$timec);
		  $_OBJECT_APPLICATION->SET_PRODUCT_LOG($DB_PORDUCT_CODE,$_SESSION['COOKCODE']);
		  $_OBJECT_APPLICATION->SET_RECORD_THIS_ACTION($_SESSION['COOKCODE'],"New product added successfully. <b>Product Name : </b>".$pname);
			if( 'yes' == $strBundleStatus ) {
				echo "<script>window.location='admin-index.php?page=product_associate_to_bundle&bundle_id=".$DB_PORDUCT_CODE."';</script>";
			}//end if
    		}
                
    		
    		}
    	
    }

?>
 
<script language="JavaScript">
<!--

var prev = "";

function showLevel( _levelId) {

	var thisLevel = document.getElementById( _levelId );
	if ( thisLevel.style.display == "none") {
		if (prev != "") {
			var otherLevel = document.getElementById( prev );
			otherLevel.style.display = "none";
		}
		thisLevel.style.display = "block";
		prev = _levelId;
		}
	else {
		thisLevel.style.display = "none";
		}
	}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.71
//copyright (c)1998,2002 Yaromat.com
  var a=YY_checkform.arguments,oo=true,v='',s='',err=false,r,o,at,o1,t,i,j,ma,rx,cd,cm,cy,dte,at;
  for (i=1; i<a.length;i=i+4){
    if (a[i+1].charAt(0)=='#'){r=true; a[i+1]=a[i+1].substring(1);}else{r=false}
    o=MM_findObj(a[i].replace(/\[\d+\]/ig,""));
    o1=MM_findObj(a[i+1].replace(/\[\d+\]/ig,""));
    v=o.value;t=a[i+2];
    if (o.type=='text'||o.type=='password'||o.type=='hidden'){
      if (r&&v.length==0){err=true}
      if (v.length>0)
      if (t==1){ //fromto
        ma=a[i+1].split('_');if(isNaN(v)||v<ma[0]/1||v > ma[1]/1){err=true}
      } else if (t==2){
        rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");if(!rx.test(v))err=true;
      } else if (t==3){ // date
        ma=a[i+1].split("#");at=v.match(ma[0]);
        if(at){
          cd=(at[ma[1]])?at[ma[1]]:1;cm=at[ma[2]]-1;cy=at[ma[3]];
          dte=new Date(cy,cm,cd);
          if(dte.getFullYear()!=cy||dte.getDate()!=cd||dte.getMonth()!=cm){err=true};
        }else{err=true}
      } else if (t==4){ // time
        ma=a[i+1].split("#");at=v.match(ma[0]);if(!at){err=true}
      } else if (t==5){ // check this 2
            if(o1.length)o1=o1[a[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!o1.checked){err=true}
      } else if (t==6){ // the same
            if(v!=MM_findObj(a[i+1]).value){err=true}
      }
    } else
    if (!o.type&&o.length>0&&o[0].type=='radio'){
          at = a[i].match(/(.*)\[(\d+)\].*/i);
          o2=(o.length>1)?o[at[2]]:o;
      if (t==1&&o2&&o2.checked&&o1&&o1.value.length/1==0){err=true}
      if (t==2){
        oo=false;
        for(j=0;j<o.length;j++){oo=oo||o[j].checked}
        if(!oo){s+='* '+a[i+3]+'\n'}
      }
    } else if (o.type=='checkbox'){
      if((t==1&&o.checked==false)||(t==2&&o.checked&&o1&&o1.value.length/1==0)){err=true}
    } else if (o.type=='select-one'||o.type=='select-multiple'){
      if(t==1&&o.selectedIndex/1==0){err=true}
    }else if (o.type=='textarea'){
      if(v.length<a[i+1]){err=true}
    }
    if (err){s+='* '+a[i+3]+'\n'; err=false}
  }
  if (s!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+s)}
  document.MM_returnValue = (s=='');
}
function checkingForApplication()
  {
   /* if(document.frmProductManagement.newp.value=="Select")
      {
        alert("* Field product type( New ) is not valid.");
        document.frmProductManagement.newp.focus();
        return false;
      }*/
    if((document.frmProductManagement.pname.value==null) || (document.frmProductManagement.pname.value==""))
      {
        alert("* Field product name is not valid.");
        document.frmProductManagement.pname.focus();
        return false;
      }
	if((document.frmProductManagement.txtfname.value==null) || (document.frmProductManagement.txtfname.value==""))
      {
        alert("* Field product user friendly name is not valid.");
        document.frmProductManagement.txtfname.focus();
        return false;
      }	  
    if(document.frmProductManagement.ptype.value=="Select")
      {
        alert("* Field product type is not valid.");
        document.frmProductManagement.ptype.focus();
        return false;
      }
    if(document.frmProductManagement.pbrand.value=="Select")
      {
        alert("* Field product brand type is not valid.");
        document.frmProductManagement.pbrand.focus();
        return false;
      }
    /*if((document.frmProductManagement.pdesc.value==null) || (document.frmProductManagement.pdesc.value==""))
      {
        alert("* Field product description is not valid.");
        document.frmProductManagement.pdesc.focus();
        return false;
      }*/
    if((document.frmProductManagement.imgfile.value==null) || (document.frmProductManagement.imgfile.value==""))
      {
        alert("* Field product main image is not valid.");
        document.frmProductManagement.imgfile.focus();
        return false;
      }
    /*if((document.frmProductManagement.imgSmallfile.value==null) || (document.frmProductManagement.imgSmallfile.value==""))
      {
        alert("* Field product small image is not valid.");
        document.frmProductManagement.imgSmallfile.focus();
        return false;
      }
    if((document.frmProductManagement.imgSmallestfile.value==null) || (document.frmProductManagement.imgSmallestfile.value==""))
      {
        alert("* Field product samllest image is not valid.");
        document.frmProductManagement.imgSmallestfile.focus();
        return false;
      }
    if((document.frmProductManagement.preview.value==null) || (document.frmProductManagement.preview.value==""))
      {
        alert("* Field product preview is not valid.");
        document.frmProductManagement.preview.focus();
        return false;
      }
    if((document.frmProductManagement.pcprice.value==null) || (document.frmProductManagement.pcprice.value==""))
      {
        alert("* Field product cost is not valid.");
        document.frmProductManagement.pcprice.focus();
        return false;
      }
    if(isNaN(document.frmProductManagement.pcprice.value))
      {
        alert("* Field product cost is not valid.");
        document.frmProductManagement.pcprice.focus();
        return false;
      }
    if((document.frmProductManagement.psprice.value==null) || (document.frmProductManagement.psprice.value==""))
      {
        alert("* Field product selling cost is not valid.");
        document.frmProductManagement.psprice.focus();
        return false;
      }
    if(isNaN(document.frmProductManagement.psprice.value))
      {
        alert("* Field product selling cost is not valid.");
        document.frmProductManagement.psprice.focus();
        return false;
      }
    if(document.frmProductManagement.pcur.value=="Select")
      {
        alert("* Field product currancy is not valid.");
        document.frmProductManagement.pcur.focus();
        return false;
      }
     if(document.frmProductManagement.pshow.value=="Select")
      {
        alert("* Field product show item is not valid.");
        document.frmProductManagement.pshow.focus();
        return false;
      }
     if((document.frmProductManagement.pweight.value==null) || (document.frmProductManagement.pweight.value==""))
      {
        alert("* Field product weight is not valid.");
        document.frmProductManagement.pweight.focus();
        return false;
      }
    if(isNaN(document.frmProductManagement.pweight.value))
      {
        alert("* Field product weight is not valid.");
        document.frmProductManagement.pweight.focus();
        return false;
      }
     if(document.frmProductManagement.pava.value=="Select")
      {
        alert("* Field product availability item is not valid.");
        document.frmProductManagement.pava.focus();
        return false;
      }
     if(document.frmProductManagement.pava.value=="Select")
      {
        alert("* Field product availability item is not valid.");
        document.frmProductManagement.pava.focus();
        return false;
      }
     /*if((document.frmProductManagement.pexlink.value==null) || (document.frmProductManagement.pexlink.value==""))
      {
        alert("* Field product extrnal link is not valid.");
        document.frmProductManagement.pexlink.focus();
        return false;
      }
     if(document.frmProductManagement.pteam.value=="Select")
      {
        alert("* Field product team is not valid.");
        document.frmProductManagement.pteam.focus();
        return false;
      }
     if(document.frmProductManagement.psite.value=="Select")
      {
        alert("* Field product site is not valid.");
        document.frmProductManagement.psite.focus();
        return false;
      }*/
     if(document.frmProductManagement.prate.value!="")
      {
        if(isNaN(document.frmProductManagement.prate.value))
          {
            alert("* Field product rate is not valid.");
            document.frmProductManagement.prate.focus();
            return false;
          }
      }
    
  }
  function setProductPageName()
    {
      document.frmProductManagement.txtProductPageName.value = document.frmProductManagement.pname.value;
    }
//-->
</script>
<style>
    .form-control{
        width: 50%;
        display: inline;
    }
</style>
<div class="row">
<div class="col-md-12">
    <form class="form-horizontal form-row-seperated"  method="post" enctype="multipart/form-data" name="form1" >

        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-shopping-cart"></i>Add Product </div>
                <div class="actions btn-set">
                    <button type="button" name="back" class="btn btn-secondary-outline">
                        <i class="fa fa-angle-left"></i> Back</button>
                    <button class="btn btn-secondary-outline">
                        <i class="fa fa-reply"></i> Reset</button>
                    <!--<button class="btn btn-success">
                        <i class="fa fa-check"></i> </button>-->
                        <input type="submit" class="btn btn-success" name="Submit" value="Save" >
                        <td><input name="action" type="hidden" id="action" value="addorder"></td>
                    <!--<button class="btn btn-success">
                        <i class="fa fa-check-circle"></i> Save & Continue Edit</button>-->
                    <div class="btn-group">
                        <a class="btn btn-success dropdown-toggle" href="javascript:;" data-toggle="dropdown">
                            <i class="fa fa-share"></i> More
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <div class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:;"> Duplicate </a>
                            </li>
                            <li>
                                <a href="javascript:;"> Delete </a>
                            </li>
                            <li class="dropdown-divider"> </li>
                            <li>
                                <a href="javascript:;"> Print </a>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-bordered">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_general" data-toggle="tab"> General </a>
                        </li>
                        <li>
                            <a href="#tab_meta" data-toggle="tab"> Meta </a>
                        </li>
                        <li>
                            <a href="#tab_images" data-toggle="tab"> Images </a>
                        </li>
                        <li>
                            <a href="#tab_reviews" data-toggle="tab"> Reviews
                                <span class="badge badge-success"> 3 </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab_history" data-toggle="tab"> History </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_general">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Name:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="pname" placeholder=""> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">F_name:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="fname" placeholder=""> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Type:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="ptype" >
                                           <option value="Select">Select</option>
                                            <?Php  $sql=mysqli_query($objCon, "SELECT * FROM `ProductsT` WHERE `loc` = 'GB' ORDER BY `ProName` ASC "); 
                                            $row = mysqli_fetch_array($sql);?>
                                            <?Php  while($row) { ?>
                                            <option value="<?Php  echo $row['ProTypeID']; ?>">
                                            <?Php  echo $row['ProName']; ?>
                                            </option>
                                             <?Php  $row = mysqli_fetch_array($sql); }; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Brand:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="pbrand" >
                                           <option value="Select">Select</option>
                                            <?Php  $sql   =   mysqli_query($objCon,"SELECT * FROM `Brands` ORDER BY `BrandName` ASC "); 
                                            $row = mysqli_fetch_array($sql); ?>
                                            <?Php  while($row) { ?>
                                            <option value="<?Php  echo $row['BrandID']; ?>">
                                            <?Php  echo $row['BrandName']; ?>
                                            </option>
                                            <?Php  $row = mysqli_fetch_array($sql); }; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Main Image:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input type="file" name="imgfile" class="table-group-action-input form-control input-medium" >
                                        <input type="hidden" name="pexlink" id="pexlink">
                                        <input type="hidden" name="pimghtml" id="pimghtml">
                                        <input type="hidden" name="preview" id="preview"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Cost Price:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input name="pcprice" type="text" id="pcprice" class="form-control"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Selling Price:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input name="psprice" type="text" id="psprice" class="form-control" > </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Price Currency:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="pcur" id="pcur" >
                                            <option value="Select">Select</option>
                                            <option value="RMB">RMB</option>
                                            <option value="USD">USD</option>
                                            <option value="GBP">GBP</option>
                                            <option value="EUR">EUR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Show Item:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="pshow" id="pshow" >
                                            <option value="Select">Select</option>
                                            <option value="Y">Yes</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Weight:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input name="pweight" id="pweight" type="text"  class="form-control" > </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Availability:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="pava" id="pava" >
                                            <option value="Select">Select</option>
                                            <option value="Y">Yes</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Team:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="pteam" id="pteam" >
                                            <option value="Select">Select</option>
                                            <option value="ornec">Ornec</option>
                                            <option value="eBay">eBay</option>
                                            <option value="Qnoda">Qnoda</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">WebSite:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="psite" id="psite" >
                                            <?=$_OBJECT_APPLICATION->FILL_DROPDOWN_OBJECT("Select websiteid, websitename from website ORDER BY `websitename` ASC", "websiteid"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Editors Rating:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input name="prate" type="text" id="prate"  class="form-control" > 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Product Class:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="cboproductrating" id="cboproductrating" >
                                            <option value="">Select</option>
                                            <option value="A+">A+</option>
                                            <option value="A">A</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B">B</option>
                                            <option value="B-">B-</option>
                                            <option value="C+">C+</option>
                                            <option value="C">C</option>
                                            <option value="C-">C-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Page Tilte:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input name="txtProductPageName" type="text" id="txtProductPageName"  class="form-control" > 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">New Tag Exprie Date:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <?php 
                                            echo "<SELECT NAME=\"cboToDateDay\" class='form-control input-sm' style='width:200px;display:inline;float:left;'>";
                                            for($DBL_DATE_COUNTER = 1 ; $DBL_DATE_COUNTER < 31 ; $DBL_DATE_COUNTER++)
                                              {
                                                if($DBL_DATE_COUNTER==date("d"))
                                                  $STR_FLAG = "SELECTED";
                                                else
                                                  $STR_FLAG = "";
                                                print "<OPTION VALUE=\"$DBL_DATE_COUNTER\" $STR_FLAG>$DBL_DATE_COUNTER</OPTION>";
                                            }
                                            print "</SELECT>&nbsp;";
                                            print "<SELECT NAME=\"cboToDateMonth\" class='form-control input-sm' style='width:200px;display:inline;float:left;'>";
                                            for($DBL_DATE_COUNTER = 1 ; $DBL_DATE_COUNTER < 13 ; $DBL_DATE_COUNTER++)
                                              {
                                                if($DBL_DATE_COUNTER==date("m"))
                                                  $STR_FLAG = "SELECTED";
                                                else
                                                  $STR_FLAG = "";
                                                print "<OPTION VALUE=\"$DBL_DATE_COUNTER\" $STR_FLAG>".date("F", mktime(0,0,0,$DBL_DATE_COUNTER))."</OPTION>";
                                              }
                                            print "</SELECT>&nbsp;";
                                            print "<SELECT NAME=\"cboToDateYear\" class='form-control input-sm' style='width:200px;display:inline;float:left;'>";
                                            for($DBL_DATE_COUNTER = date("Y") ; $DBL_DATE_COUNTER < date("Y")+50 ; $DBL_DATE_COUNTER++)
                                              {
                                                if($DBL_DATE_COUNTER==date("Y"))
                                                  $STR_FLAG = "SELECTED";
                                                else
                                                  $STR_FLAG = "";
                                                print "<OPTION VALUE=\"$DBL_DATE_COUNTER\" $STR_FLAG>$DBL_DATE_COUNTER</OPTION>";
                                              }
                                            print "</SELECT>&nbsp;";?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Bundle Status:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="txtBundleStatus" id="txtBundleStatus" >
                                            <option value="yes">Yes</option>	
                                            <option value="no" selected>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Short Description:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="txtSortDescription" cols="50" rows="5"></textarea>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label class="col-md-2 control-label">Meta Keywords:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="txtMetakeyword" cols="50" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Meta Description:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="txtMetakeyDescription" cols="50" rows="5"></textarea>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Description:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <?php
                                        $sBasePath = "./fckeditor/";
                                        $oFCKeditor = new FCKeditor('pdesc') ;
                                        $oFCKeditor->BasePath	= $sBasePath ;
                                        $oFCKeditor->Value		= "" ;
                                        $oFCKeditor->Create() ;
                                        ?>
                                        <span class="help-block"> shown in product listing </span>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label class="col-md-2 control-label">Categories:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <div class="form-control height-auto">
                                            <div class="scroller" style="height:275px;" data-always-visible="1">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" name="product[categories][]" value="1">Mens</label>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Footwear</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Clothing</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Accessories</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Fashion Outlet</label>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" name="product[categories][]" value="1">Football Shirts</label>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Premier League</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Football League</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Serie A</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Bundesliga</label>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <label>
                                                            <input type="checkbox" name="product[categories][]" value="1">Brands</label>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Adidas</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Nike</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Airwalk</label>
                                                            </li>
                                                            <li>
                                                                <label>
                                                                    <input type="checkbox" name="product[categories][]" value="1">Kangol</label>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <span class="help-block"> select one or more categories </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Available Date:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                            <input type="text" class="form-control" name="product[available_from]">
                                            <span class="input-group-addon"> to </span>
                                            <input type="text" class="form-control" name="product[available_to]"> </div>
                                        <span class="help-block"> availability daterange. </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">SKU:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="product[sku]" placeholder=""> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Price:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="product[price]" placeholder=""> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Tax Class:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="product[tax_class]">
                                            <option value="">Select...</option>
                                            <option value="1">None</option>
                                            <option value="0">Taxable Goods</option>
                                            <option value="0">Shipping</option>
                                            <option value="0">USA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Status:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-10">
                                        <select class="table-group-action-input form-control input-medium" name="product[status]">
                                            <option value="">Select...</option>
                                            <option value="1">Published</option>
                                            <option value="0">Not Published</option>
                                        </select>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_meta">
                            <div class="form-body">
                                <!--<div class="form-group">
                                    <label class="col-md-2 control-label">Meta Title:</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control maxlength-handler" name="product[meta_title]" maxlength="100" placeholder="">
                                        <span class="help-block"> max 100 chars </span>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Meta Keywords:</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control maxlength-handler" rows="8" name="txtMetakeyword" maxlength="1000"></textarea>
                                        <span class="help-block"> max 1000 chars </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Meta Description:</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control maxlength-handler" rows="8" name="txtMetakeyDescription" maxlength="255"></textarea>
                                        <span class="help-block"> max 255 chars </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_images">
                            <div class="alert alert-success margin-bottom-10">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <i class="fa fa-warning fa-lg"></i> Image type and information need to be specified. </div>
                            <div id="tab_images_uploader_container" class="text-align-reverse margin-bottom-10">
                                <a id="tab_images_uploader_pickfiles" href="javascript:;" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Select Files </a>
                                <a id="tab_images_uploader_uploadfiles" href="javascript:;" class="btn btn-primary">
                                    <i class="fa fa-share"></i> Upload Files </a>
                            </div>
                            <div class="row">
                                <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12"> </div>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th width="8%"> Image </th>
                                        <th width="25%"> Label </th>
                                        <th width="8%"> Sort Order </th>
                                        <th width="10%"> Base Image </th>
                                        <th width="10%"> Small Image </th>
                                        <th width="10%"> Thumbnail </th>
                                        <th width="10%"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="../assets/pages/media/works/img1.jpg" class="fancybox-button" data-rel="fancybox-button">
                                                <img class="img-responsive" src="../assets/pages/media/works/img1.jpg" alt=""> </a>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="product[images][1][label]" value="Thumbnail image"> </td>
                                        <td>
                                            <input type="text" class="form-control" name="product[images][1][sort_order]" value="1"> </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][1][image_type]" value="1"> </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][1][image_type]" value="2"> </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][1][image_type]" value="3" checked> </label>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-default btn-sm">
                                                <i class="fa fa-times"></i> Remove </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="../assets/pages/media/works/img2.jpg" class="fancybox-button" data-rel="fancybox-button">
                                                <img class="img-responsive" src="../assets/pages/media/works/img2.jpg" alt=""> </a>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="product[images][2][label]" value="Product image #1"> </td>
                                        <td>
                                            <input type="text" class="form-control" name="product[images][2][sort_order]" value="1"> </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][2][image_type]" value="1"> </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][2][image_type]" value="2" checked> </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][2][image_type]" value="3"> </label>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-default btn-sm">
                                                <i class="fa fa-times"></i> Remove </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="../assets/pages/media/works/img3.jpg" class="fancybox-button" data-rel="fancybox-button">
                                                <img class="img-responsive" src="../assets/pages/media/works/img3.jpg" alt=""> </a>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="product[images][3][label]" value="Product image #2"> </td>
                                        <td>
                                            <input type="text" class="form-control" name="product[images][3][sort_order]" value="1"> </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][3][image_type]" value="1" checked> </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][3][image_type]" value="2"> </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input type="radio" name="product[images][3][image_type]" value="3"> </label>
                                        </td>
                                        <td>
                                            <a href="javascript:;" class="btn btn-default btn-sm">
                                                <i class="fa fa-times"></i> Remove </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab_reviews">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="datatable_reviews">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th width="5%"> Review&nbsp;# </th>
                                            <th width="10%"> Review&nbsp;Date </th>
                                            <th width="10%"> Customer </th>
                                            <th width="20%"> Review&nbsp;Content </th>
                                            <th width="10%"> Status </th>
                                            <th width="10%"> Actions </th>
                                        </tr>
                                        <tr role="row" class="filter">
                                            <td>
                                                <input type="text" class="form-control form-filter input-sm" name="product_review_no"> </td>
                                            <td>
                                                <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy">
                                                    <input type="text" class="form-control form-filter input-sm" readonly name="product_review_date_from" placeholder="From">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-sm default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
                                                    <input type="text" class="form-control form-filter input-sm" readonly name="product_review_date_to" placeholder="To">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-sm default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-filter input-sm" name="product_review_customer"> </td>
                                            <td>
                                                <input type="text" class="form-control form-filter input-sm" name="product_review_content"> </td>
                                            <td>
                                                <select name="product_review_status" class="form-control form-filter input-sm">
                                                    <option value="">Select...</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="approved">Approved</option>
                                                    <option value="rejected">Rejected</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="margin-bottom-5">
                                                    <button class="btn btn-sm btn-success filter-submit margin-bottom">
                                                        <i class="fa fa-search"></i> Search</button>
                                                </div>
                                                <button class="btn btn-sm btn-danger filter-cancel">
                                                    <i class="fa fa-times"></i> Reset</button>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_history">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="datatable_history">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th width="25%"> Datetime </th>
                                            <th width="55%"> Description </th>
                                            <th width="10%"> Notification </th>
                                            <th width="10%"> Actions </th>
                                        </tr>
                                        <tr role="row" class="filter">
                                            <td>
                                                <div class="input-group date datetime-picker margin-bottom-5" data-date-format="dd/mm/yyyy hh:ii">
                                                    <input type="text" class="form-control form-filter input-sm" readonly name="product_history_date_from" placeholder="From">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-sm default date-set" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="input-group date datetime-picker" data-date-format="dd/mm/yyyy hh:ii">
                                                    <input type="text" class="form-control form-filter input-sm" readonly name="product_history_date_to" placeholder="To">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-sm default date-set" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-filter input-sm" name="product_history_desc" placeholder="To" /> </td>
                                            <td>
                                                <select name="product_history_notification" class="form-control form-filter input-sm">
                                                    <option value="">Select...</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="notified">Notified</option>
                                                    <option value="failed">Failed</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="margin-bottom-5">
                                                    <button class="btn btn-sm btn-default filter-submit margin-bottom">
                                                        <i class="fa fa-search"></i> Search</button>
                                                </div>
                                                <button class="btn btn-sm btn-danger-outline filter-cancel">
                                                    <i class="fa fa-times"></i> Reset</button>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="auth.php"></a>
    </form>
    </div>
</div>    
  
    
  <?php 
  
    function uploadImageToDestination($filename , $filedir , $pwidth , $pheight)
    {
       $userfile_name = $_FILES['imgfile']['name']; 
       $userfile_tmp =  $_FILES['imgfile']['tmp_name']; 
       $userfile_size = $_FILES['imgfile']['size']; 
       $userfile_type = $_FILES['imgfile']['type'];
       
       if (($filedir)!="")  
       { 
          $prod_img = $filedir.$filename;
          $uploadedfile=$userfile_tmp;
	         
          $src = imagecreatefromjpeg($uploadedfile);
          // Capture the original size of the uploaded image
          list($width,$height)=getimagesize($uploadedfile);
          $newwidth=$pwidth;
          $newheight=$pheight;
          $tmp=imagecreatetruecolor($newwidth,$newheight);
            
          // this line actually does the image resizing, copying from the original
          // image into the $tmp image
          imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height); 
            
          // now write the resized image to disk. I have assumed that you want the
          // resized, uploaded image file to reside in the ./images subdirectory.
          imagejpeg($tmp,$prod_img,100);
            
          imagedestroy($src);
          imagedestroy($tmp);
       } 
    } 
    if($_POST['Submit']!="")
    {	
		  //New Product Arrive Log and What
	//$_STR_DATE = date("Y")."-".date("m")."-".date("d");
	//$_OBJECT_APPLICATION->ADD_WHATS_NEW($DB_PORDUCT_CODE,14,$_STR_DATE,$_SESSION['COOKUSERNAME']);
	//$_OBJECT_APPLICATION->ORDER_LOGS($_SESSION['COOKUSERNAME'],"0.".$DB_PORDUCT_CODE,"14");
    }
    
    //for insertinf product details in ProductInfo1 table for testing
  
    
  ?>

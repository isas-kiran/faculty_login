<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM product where product_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
if($_REQUEST['image_id'] && $_REQUEST['deletegallery'])
{
	$sql_record1= "SELECT image_id,image FROM product_image where image_id='".$gallery_id."'";
	if(mysql_num_rows($db->query($sql_record1)))
	$row_record_gallary=$db->fetch_array($db->query($sql_record1));
	$gallery_id=$_REQUEST['image_id'];
	"delete- ".$record_id=$_GET['record_id'];
	"<br />".$del_ex_section="update product_image set image='' where image_id='".$gallery_id."' and product_id='".$record_id."' ";
     $ptr_del_section=mysql_query($del_ex_section);
    /*$update_gallery="update product_image set image='' where image_id='".$gallery_id."'";
	//echo $update_events;
    $db->query($update_gallery);*/
    if($row_record_gallary['image'] && file_exists("product_photo/".$row_record_gallary['image']))
        unlink("product_photo/".$row_record_gallary['image']);
    $row_record_gallary=$db->fetch_array($db->query($sql_record1));
}
$edit_access='';
$sel_acc="select * from edit_previleges where admin_id='".$_SESSION['admin_id']."' and privilege_id='132'";
$ptr_access=mysql_query($sel_acc);
if(mysql_num_rows($ptr_access))
{
	$edit_access='yes';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Product</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
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
    

    <!-- Multiselect -->

    

     <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.css" />

    <link rel="stylesheet" type="text/css" href="multifilter/jquery.multiselect.filter.css" />

    <link rel="stylesheet" type="text/css" href="multifilter/assets/prettify.css" />

    <script type="text/javascript" src="multifilter/src/jquery.multiselect.js"></script>

    <script type="text/javascript" src="multifilter/src/jquery.multiselect.filter.js"></script>

    <script type="text/javascript" src="multifilter/assets/prettify.js"></script>

    

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

	 function show_subcategory(pcategory_id,sub_id)

	 {

				

		//alert(sub_id);

		 

		if(pcategory_id !='')

		{

		 // var course="show_subcategory=1&pcategory_id="+pcategory_id+"&sub_id="+sub_id;

	

		

		  var data1="pcategory_id="+pcategory_id+"&sub_id="+sub_id;

				   //alert(data1);

					 $.ajax({

				url: "get-subcategory.php", type: "post", data: data1, cache: false,

				success: function (html)

					{

						//alert(html)

						 document.getElementById('member_new').innerHTML=html;

					}

				});

				

		}

		 

	}

	 </script>

     

      <script language="javascript" src="js/script.js"></script>

      <script language="javascript" src="js/conditions-script.js"></script>

      <style>	

					 

	.addBtn{background:no-repeat url(images/add.png); width:17px; border:0px; cursor:pointer;}

	.delBtn{background:no-repeat url(images/delete.png);width:17px; border:0px; cursor:pointer;}

	.editBtn{background:no-repeat url(images/edit_icon.gif); width:17px; border:0px; cursor:pointer;}

	.clrButton{background:no-repeat url(images/edit_clear.png);width:17px; border:0px; cursor:pointer;}

	.inactive{ background-color:#FFF;cursor:pointer; color:#000}

	.active{ background-color:#699;cursor:pointer; color:#FFF}

	.hidden{ display:none; width:0px; height:0px;}	

	.tbl{border-radius:3px; border:#333 solid 1px; background-color:#CCC; }

	.pointer{ cursor:pointer;}

	</style>

    

    <script type="text/javascript">

        jQuery(document).ready( function() 

        {

            $("#vendor_id").multiselect().multiselectfilter();

            // binds form submission and fields to the validation engine

            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});

        });

		

	function selectalls() 

	{

		if($("#selectall").attr("checked")==true){

		$('.case').each(function() {

		$(this).attr('checked','checked');

		showservice();

		});

		}else{

		$('.case').each(function() {

		$(this).attr('checked','');

		showservice();

		});

		}

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

    <td class="top_mid" valign="bottom"><?php include "include/product_category_menu.php"; ?></td>

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

                            $product_name=$_POST['product_name'];

                            $product_code=$_POST['product_code'];  
							
							$hsn_code=$_POST['hsn_code'];  

							$pcategory_id=$_POST['pcategory_id'];    

							$sub_id=$_POST['sub_id']; 

							$description=$_POST['description']; 

							$size=$_POST['size'];

							//$quantity=$_POST['quantity'];     
							//$quantity=( ($_POST['quantity'])) ? $_POST['quantity'] : "0";      

                            $commission=$_POST['commission'];

							$price=$_POST['price'];

							$vender=$_POST['vender'];

							$type=$_POST['type'];

							$non_tax=$_POST['non_tax'];

							$vendor_idss=$_POST['requirment_id']; 

							 $brand=$_POST['brand'];

							 $total_floor=$_POST['no_of_floor'];

							 $image_folder_path="../product_photo/";

                            if(count($errors))

                            {

                                ?>

                                <tr>

                                    <td> <br></br>

                                    <table align="left" style="text-align:left;" class="alert">

                                    <tr><td ><strong>Please correct the following errors</strong><ul>

                                            <?php

                                            for($k=0;$k<count($errors);$k++)

                                                    echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>

                                            </ul>

                                    </td></tr>

                                    </table>

                                    </td>

                                </tr>   <br></br>  

                                <?php

                            }

                            else

                            {

                                $success=1;

                                $data_record['product_name'] =$product_name;

                                $data_record['product_code'] =$product_code;
								
								$data_record['hsn_code'] =$hsn_code;

								$data_record['pcategory_id'] =$pcategory_id;

								$data_record['sub_id'] =$sub_id;

								$data_record['description'] =$description;

								$data_record['size'] =$size;

								//$data_record['quantity']=$quantity;

								$data_record['commission']=$commission;

								$data_record['price']=$price;

								$data_record['vender']=$vender;

								$data_record['type']=$type;

								$data_record['non_tax']=$non_tax;
								
								$data_record['brand']=$brand;



                               if($record_id)

                                {

                                  

                                    $where_record=" product_id='".$record_id."'";

                                    $db->query_update("product", $data_record,$where_record);
									$insid=mysql_insert_id();
									

									"<br />".$del_ex_section="delete from product_vendor_map where product_id='".$record_id."'";

                                      $ptr_del_section=mysql_query($del_ex_section);

									  

									  for($x=0;$x<count($_POST['requirment_id']);$x++)

									   {

									    if($_POST['requirment_id'][$x]!='')
										   {

									    $insert_vendor_ids=" insert into product_vendor_map (`product_id`,`vendor_id`) values('".$record_id."', '".$_POST['requirment_id'][$x]."')";

									    $query_insert=mysql_query($insert_vendor_ids);
										   }

									   }

									"<br>".$insert="INSERT INTO `log_history`(`category`, `action`, `name`, `id`, `date`, `cm_id`, `admin_id`) VALUES ('add_product','Edit','".$product_name."','".$insid."','".date('Y-m-d H:i:s')."','".$_SESSION['cm_id']."','".$_SESSION['admin_id']."')";
									$query=mysql_query($insert);  

									//==================================================For image=============================================================	

									

									for($z=1;$z<=$total_floor;$z++)

									{

										"Floor- ". $total_floor."<br />";

										if($_POST['del_floor'.$z]=='yes')

										{

											"<br />".$_POST['del_floor'.$z]=='yes';

											if($_POST['floor_id'.$z]!='' && $_POST['del_floor'.$z]=='yes' )

											{

												$delete_row = " delete from product_image where image_id='".$_POST['floor_id'.$z]."' ";

												$ptr_delete = mysql_query($delete_row);

											}

										}

									   if($_FILES['image'.$z]["name"] !='' && $_POST['del_floor'.$z] !='yes')
									   {

										    ''.$_FILES['image'.$z]['name'];

										$data_record_extra['product_id']=$record_id;   

																				

										if(basename($_FILES['image'.$z]['name']))

										{

										  "<br/>gallary img- ".$data_record_extra['image']= basename($_FILES['image'.$z]['name']);

										 

										 //echo '<br/>'.$_FILES['image'.$z]['tmp_name'],$image_folder_path.$data_record_extra['image'];

										 

										 move_uploaded_file($_FILES['image'.$z]['tmp_name'],$image_folder_path.$data_record_extra['image']);

										}

										//echo 'floor_ids=>'.$_POST['floor_id'.$z];

										if($_POST['floor_id'.$z]=='' && $_FILES['image'.$z]["name"] !='')

										{

											$floor_id=$db->query_insert("product_image", $data_record_extra);

										}

										else

										{

											 $where_records=" image_id='".$_POST['floor_id'.$z]."'";

											 $floor_id= $_POST['floor_id'.$z];

											 $project_id = $db->query_update("product_image", $data_record_extra,$where_records);
										}
										unset($data_record_extra);

								}
						}
						//==================================================END=============================================================
                                    
									?><div id="statusChangesDiv" title="Record Deleted"><center><br><p>Product updated successfully</p></center></div>
										<script type="text/javascript">
                                            $(document).ready(function() {
                                                $( "#statusChangesDiv" ).dialog({
                                                        modal: true,
                                                        buttons: {
                                                                    Ok: function() { $( this ).dialog( "close" );}
                                                                 }
                                                });
                                                
                                            });
                                           // setTimeout('document.location.href="manage_product.php";',1000);
                                        </script>
         
                                    <?php
									

                                }

                                

                            }

                        }

                        if($success==0)

                        {

                        

                        ?>

            <tr><td>

        <form method="post" id="jqueryForm" enctype="multipart/form-data">

	<table border="0" cellspacing="15" cellpadding="0" width="100%">

              <tr>

                <td colspan="3" class="orange_font">* Mandatory Fields</td>

                </tr>

                

              <tr>

                  <td width="20%" valign="top">Product Name<span class="orange_font">*</span></td>

                <td width="70%"><input type="text"  class="validate[required] input_text" name="product_name" id="product_name" value="<?php if($_POST['save_changes']) echo $_POST['product_name']; else echo $row_record['product_name'];?>" /></td> 

                <td width="10%"></td>

              </tr>

             

             <tr>
                <td width="20%" valign="top">Product Code<span class="orange_font">*</span></td>
                <td width="70%"><input type="text"  class=" input_text" name="product_code" id="product_code" value="<?php if($_POST['save_changes']) echo $_POST['product_code']; else echo $row_record['product_code'];?>" /></td> 
                <td width="10%"></td>
             </tr>

            <tr>
                <td width="20%" valign="top">HSN Code <span class="orange_font">*</span></td>
                <td width="70%"><input type="text" class=" input_text" name="hsn_code" id="hsn_code" value="<?php if($_POST['save_changes']) echo $_POST['hsn_code']; else echo $row_record['hsn_code'];?>"  /></td> 
                <td width="10%"></td>
            </tr>

             <tr>

                 <td>Product Category<span class="orange_font">*</span> </td>

                      <td width="70%">

                        <select name="pcategory_id" style="width:200px;" id="pcategory_id" onChange="show_subcategory(this.value,'');">

                         <option value="0">Select Category</option> 

                          <?php  

                            $sql_dest = " select pcategory_name, pcategory_id from product_category order by pcategory_id asc";

                            $ptr_edes = mysql_query($sql_dest);

                            while($data_dist = mysql_fetch_array($ptr_edes))

                            { 

                                    $selecteds = '';

                                    if($data_dist['pcategory_id']==$row_record['pcategory_id'])

                                    $selecteds = 'selected="selected"';	

                                       

                                echo "<option value='".$data_dist['pcategory_id']."' ".$selecteds.">".$data_dist['pcategory_name']."</option>";

                            }



                            ?>

                        </select>

                      </td>

                            

              </tr>

              

               <?php

			  if($record_id)

			  { ?>

              <script>

				  show_subcategory(<?php echo $row_record['pcategory_id'] ?>,'<?php echo $row_record['sub_id'] ?>')
				  //alert('hi')

				  </script>

			  <?php }

			  ?>

              

              <tr><td width="50%" colspan="3"><div id="member_new"> </div></td></tr>

             

                 <?php /*?><td>Product Sub Category </td>

                      <td width="70%">

                        <select name="sub_id" style="width:200px;" >

                         <option value="0">Select Category</option> 

                          <?php  

                            $sql_dest = " select sub_name, sub_id from subcategory order by sub_id asc";

                            $ptr_edes = mysql_query($sql_dest);

                            while($data_dist = mysql_fetch_array($ptr_edes))

                            { 

                                    $selecteds = '';

                                    if($data_dist['sub_id']==$row_record['sub_id'])

                                    $selecteds = 'selected="selected"';	

                                       

                                echo "<option value='".$data_dist['sub_id']."' ".$selecteds.">".$data_dist['sub_name']."</option>";

                            }



                            ?>

                        </select>

                      </td><?php */?>

              

           <tr>

            <td width="12%" valign="top">Product Description </td>

            <td colspan="2">

                   

			 <script src="ckeditor/ckeditor.js"></script>

                <textarea name="description" id="description"><?php if ($_POST['description']) echo stripslashes($_POST['description']); else echo $row_record['description']; ?></textarea>

            <script>

                CKEDITOR.replace( 'description' );

            </script>

                </td> 



            </tr>

			
            <tr>

                <td width="20%" valign="top">Size <span class="orange_font">*</span></td>

                <td width="70%"><input type="text"  class=" input_text" name="size" id="size" value="<?php if($_POST['save_changes']) echo $_POST['size']; else echo $row_record['size'];?>"  /></td> 

                <td width="10%"></td>

            </tr>

            <?php
			$disabled='disabled="disabled"';
			if($_SESSION['type'] =='S' )
			{
				$disabled='';
			}
			?>

            <tr>

                <td width="20%" valign="top">Quantity</td>

                <td width="70%"><?php echo $row_record['quantity']; ?><!--<input type="text" <?php //echo $disabled; ?> class="input_text" name="quantity" id="quantity" value="<?php //if($_POST['save_changes']) echo $_POST['quantity']; else echo $row_record['quantity'];?>"  />--></td> 

                <td width="10%"></td>

            </tr>

              

              <tr>

                  <td width="20%" valign="top">Commission (in %)</td>

                <td width="70%"><input type="text"  class=" input_text" name="commission" id="commission" value="<?php if($_POST['save_changes']) echo $_POST['commission']; else echo $row_record['commission'];?>" /></td> 

                <td width="10%"></td>

              </tr>

              

              <tr>

                  <td width="20%" valign="top">Non Tax Price <span class="orange_font">*</span></td>

                <td width="70%"><input type="text"  class=" input_text" name="price" id="price" value="<?php if($_POST['save_changes']) echo $_POST['price']; else echo $row_record['price'];?>" /></td> 

                <td width="10%"></td>

              </tr>

              

              

              <!--<tr>

                  <td width="20%" valign="top">Non Tax Price</td>

                <td width="70%"><input type="text"  class=" input_text" name="non_tax" id="non_tax" value="<?php //if($_POST['save_changes']) echo $_POST['non_tax']; else echo $row_record['non_tax'];?>"  /></td> 

                <td width="10%"></td>

              </tr>-->

              

              <tr>

                  <td width="20%" valign="top">Brand </td>

                <td width="70%">
                <select name="brand" style="width:200px;" id="brand" onchange="show_subcategory(this.value,'');" >
                <option value="">Select Brand</option> 
                <?php  
                $sql_dest ="select * from product_brand where 1 ".$_SESSION['where']." order by brand_id asc";//".$_SESSION['user_id']."
                $ptr_edes =mysql_query($sql_dest);
                while($data_dist =mysql_fetch_array($ptr_edes))
                { 
                    $selecteds = '';
                    if($data_dist['brand_id']==$row_record['brand'])
                    $selecteds = 'selected="selected"';	                                 
                    echo "<option value='".$data_dist['brand_id']."' ".$selecteds.">".$data_dist['brand_name']."</option>";
                }
                ?>
            	</select></td> 

                <td width="10%"></td>

              </tr>

            

            <!--<tr>

            

                  <td>Select Vender <span class="orange_font">*</span></td>

                  <td>

                   <select name="vender" id="vender" class="input_select" style="width:200px;" required>

                   <option value="">Select Vender</option>

                   <?php

				   

				    /*$sql_vendor = " select name, vendor_id from vendor order by vendor_id asc";

					$ptr_vendor = mysql_query($sql_vendor);

					while($data_vendor = mysql_fetch_array($ptr_vendor))

					{ 

							$selecteds = '';

							if($data_vendor['vendor_id']==$row_record['vender'])

							$selecteds = 'selected="selected"';	

							   

						echo "<option value='".$data_vendor['vendor_id']."' ".$selecteds.">".$data_vendor['name']."</option>";

					}*/

                   ?>

                   </select>

                  

                  </td>

                   

           </tr>-->

            

             <tr>

            <td width="20%">Select Vender </td>

            <td width="40%" >

                <select  multiple="multiple" name="requirment_id[]" id="vendor_id" class="input_select" style="width:150px;" >                        

                        <?php 

                            $select_vendor = "select vendor_id,name from vendor order by vendor_id asc";

                            $query_vendor = mysql_query($select_vendor);

							$i=0;

                            while($data_vendor = mysql_fetch_array($query_vendor))

                            { 

                                $class = '';

								$sql_sub_cat = "select * from product_vendor_map where product_id='".$row_record['product_id']."' and vendor_id='".$data_vendor['vendor_id']."' ";

								$ptr_sub_cat = mysql_query($sql_sub_cat);

								if(mysql_num_rows($ptr_sub_cat))

								{

									

								   $class = 'selected="selected"';

									

								}

                                 

                                     echo '<option '.$class.' value="'.$data_vendor['vendor_id'].'" >'.$data_vendor['name'].'</option>';  

                            $i++;

							}

                            ?>  

                              

                    </select>

                    </td> 

                <td width="40%"></td>

            </tr>

              

              <tr>

                  <td width="20%" valign="top">Type</td>

                <td width="70%">

                <input type="radio" name="type" id="type" value="powder" <?php if($row_record['type']=='powder') echo 'checked="checked"'; ?> >Powder

                <input type="radio" name="type" id="type" value="liquid" <?php if($row_record['type']=='liquid') echo 'checked="checked"'; ?> >Liquid

                <input type="radio" name="type" id="type" value="creamy" <?php if($row_record['type']=='creamy') echo 'checked="checked"'; ?> >Creamy

                

                </td> 

                <td width="10%"></td>

              </tr>

              

              <tr>

              

              

              </tr>

              <td colspan="2">

                 	<table  width="100%" style="border:1px solid gray; ">

                    	<tr>

                    <td></td>

                    <td colspan="2">

                     <!--===========================================================NEW TABLE START===================================-->

                        <table cellpadding="5" width="100%" >

                         <tr><td ><b>Gallery Image</b> </td>

                         

                         <script language="javascript">

									

									function floors(idss)

									{

										

										var shows_data='<div id="floor_id'+idss+'"><table cellspacing="3" id="tbl'+idss+'" width="100%"><tr><td valign="top" width="10%"><input type="hidden" name="exclusive_id'+idss+'" id="exclusive_id'+idss+'" value="'+idss+'" /><input type="file" name="image'+idss+'" id="image'+idss+'" /></td><input type="hidden" name="row_deleted'+idss+'" id="row_deleted'+idss+'" value="" /><tr></table></div>';

										document.getElementById('floor').value=idss;

									return shows_data;

									}

									

							</script>

                        

                         

                           <td align="right" width="9%"><input type="button" name="Add"  class="addBtn" onClick="javascript:create_floor('add');" alt="Add(+)" > 

<input type="button" name="Add"  class="delBtn"  onClick="javascript:create_floor('delete');" alt="Delete(-)" >

  </td></tr>

                                <tr><td>  </td><td align="left"></td></tr>

                        </table> 

                        <table width="100%" border="0" class="tbl" bgcolor="#CCCCCC" align="center">

                        <tr>

                        <td align="center"></td>

                        <td align="center"></td>

                        <td align="center"></td>

                        </tr>

  <tr>

                           <!-- <td valign="top" width="1%" align="center">Position</td>

                            <td valign="top" width="4%" align="center">Tag</td>

                            <td valign="top" width="6%" align="center" >Comment</td>-->

                            <td valign="top" width="10%"  align="center">Upload Image</td>

                             </tr>

  <tr>

                            <td colspan="6">

                            

                             <?php

							$select_exc = "select image_id,image from  product_image where product_id='".$record_id."' order by  image_id  asc ";

							$ptr_fs = mysql_query($select_exc);

							$t=1;

							$total_conditions= mysql_num_rows($ptr_fs);

							while($data_exclusive = mysql_fetch_array($ptr_fs))

							{ 

								$image_id= $data_exclusive['image_id'];

							?> 

                            <div class="floor_div" id="floor_id<?php echo $t; ?>">

                            <table cellspacing="5" id="tbl<?php echo $t; ?>" width="100%">

                            

                            <tr>

                            

                            <input type="hidden" name="floor_id<?php echo $t; ?>" id="floor_id_<?php echo $t; ?>" value="<?php echo $data_exclusive['image_id'] ?>" />

                            

                            <?php

							if($data_exclusive['image'] && file_exists('../product_photo/'.$data_exclusive['image']))

							echo '<img src="../product_photo/'.$data_exclusive["image"].'" height="80" width="80"></td>

							<td width="40%"><a href="'.$_SERVER['PHP_SELF'].'?image_id='.$data_exclusive['image_id'].'&deletegallery=1&record_id='.$record_id.'">Delete / Upload new</a></td>';

							else

							echo '<input type="file" name="image'.$t.'" id="image'.$t.'" class=" input_text"></td><td width="40%"></td>';

							?>

                       		

                            <td width="9%"><input type="button" title="Delete Options(-)" onClick="delete_rec(<?php echo $t; ?>,'floor');" class="delBtn" name="del">

                            <input type="hidden" name="del_floor<?php echo $t; ?>" id="del_floor<?php echo $t; ?>" value="" /></td>

                             </tr></table>

                             </div>

							<?php

							$t++;

								}

							?>

                            <div id="create_floor"></div>

                             <input type="hidden" name="floor" id="floor"  value="0" />

                        </td></tr></table>

                        <?php  "Total Floor".$total_conditions; ?>

                        <input type="hidden" name="no_of_floor" id="no_of_floor" class="inputText"   value="<?php echo $total_conditions; ?>" />

                        <input type="hidden" name="total_floor" id="total_floor" class="inputText" value="<?php echo $total_conditions; ?>" />

                        <!--============================================================END TABLE=========================================-->

                        

                        </td>

                        </tr>

                    	

                 	</table>

                 </td>

              <tr>

                  <td>&nbsp;</td>

                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Product" name="save_changes"  /></td>

                  <td></td>

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

<div id="footer"><? require("include/footer.php");?></div>

<!--footer end-->

<script language="javascript">

if($("#no_of_floor").val()==0)

{

create_floor('add');

}





</script>

</body>

</html>

<?php $db->close();?>
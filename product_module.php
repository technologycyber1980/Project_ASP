<!-- ENCODE CHARSET -->
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<!-- ENCODE CHARSET -->	


<?
$sql_and=" AND (pro_category ='10' OR pro_category ='11') ";
//Parameter การแบ่งหน้า
		$Per_Page = 100;
		$Per_View = 10;

		$sql_accessibility_chk = "SELECT * FROM  accessibility_warehouse  WHERE  emp_id='$ID'  LIMIT 1";
 		$con_accessibility_chk = mysql_query($sql_accessibility_chk,$conn);
		$rs_accessibility_chk = mysql_fetch_array($con_accessibility_chk);


$pro_category=str_replace("product.php?pro_category=","",$pro_category)	;

if(!empty($pro_subtype)){
		$sql_subtype = "SELECT * FROM  pro_subtype where subtype_id='$pro_subtype'";
		$con_subtype = mysql_query($sql_subtype,$conn);
		$rs_subtype = mysql_fetch_array($con_subtype);
	
	$pro_category=$rs_subtype[pro_category];
	$pro_subtype=$rs_subtype[subtype_id];
}

if($pro_category=="12" && is_null($pro_subtype)){
	$pro_subtype="3";
}

switch($pro_category){
					  case"12":
					  $topic_txt1="รหัสอุปกรณ์";
					  $topic_txt2="รายการอุปกรณ์";
					  break;
					  default:
					  $topic_txt1="รหัสสินค้า";
					  $topic_txt2="รายการสินค้า";
					  break;
				  }
				  
//if($pro_category=="SAMPLE"){$pro_category="10";}
 		$pro_code_search_array=array();
 		$pro_name_search_array=array();
 		$pro_block_search_array=array();
		
		if(!empty($pro_category)){
			
			switch($pro_category){
				case "SAMPLE":
		$sql_product_code_search = "SELECT pro_code FROM tsp_product where pro_category='10' and pro_code LIKE '%/S' group by pro_code order by pro_code   ASC ";	
		$con_product_code_search= mysql_query($sql_product_code_search,$conn);
		while($rs_product_code_search = mysql_fetch_array($con_product_code_search)){
		$pro_code_search_array[]=$rs_product_code_search[pro_code];		
		}		

		$sql_product_name_search = "SELECT pro_name,pro_code FROM tsp_product where pro_category='10' and pro_code LIKE '%/S' order by convert (pro_name using tis620) ASC ";	
		$con_product_name_search= mysql_query($sql_product_name_search,$conn);
		while($rs_product_name_search = mysql_fetch_array($con_product_name_search)){
		$pro_name_search_array[]=iconv('tis-620','utf-8',$rs_product_name_search[pro_name]);		
		}
					
				break;
				default:
		$sql_product_code_search = "SELECT pro_code FROM tsp_product where pro_category='".$pro_category."' and pro_code NOT LIKE '%/S' ".$sql_and." group by pro_code order by pro_code   ASC ";	
		$con_product_code_search= mysql_query($sql_product_code_search,$conn);
		while($rs_product_code_search = mysql_fetch_array($con_product_code_search)){
		$pro_code_search_array[]=$rs_product_code_search[pro_code];		
		}		

		$sql_product_name_search = "SELECT pro_name,pro_code FROM tsp_product where pro_category='".$pro_category."' and pro_code NOT LIKE '%/S' ".$sql_and." order by convert (pro_name using tis620) ASC ";	
		$con_product_name_search= mysql_query($sql_product_name_search,$conn);
		while($rs_product_name_search = mysql_fetch_array($con_product_name_search)){
		$pro_name_search_array[]=iconv('tis-620','utf-8',' '.$rs_product_name_search[pro_name]);		
		}				
		break;
		}

		$sql_product_position_search = "SELECT pro_block_positions FROM tsp_product where pro_category='".$pro_category."' and pro_block_positions!='' ".$sql_and." group by pro_block_positions order by pro_block_positions ASC ";	
		$con_product_position_search= mysql_query($sql_product_position_search,$conn);
		while($rs_product_position_search = mysql_fetch_array($con_product_position_search)){
		$pro_block_search_array[]=' '.iconv('tis-620','utf-8',$rs_product_position_search[pro_block_positions]);	
		}
		} else {
		$sql_product_code_search = "SELECT pro_code FROM tsp_product WHERE pro_code!='' ".$sql_and."  group by pro_code order by pro_code   ASC ";	
		$con_product_code_search= mysql_query($sql_product_code_search,$conn);
		while($rs_product_code_search = mysql_fetch_array($con_product_code_search)){
		$pro_code_search_array[]=$rs_product_code_search[pro_code];		
		}

		$sql_product_name_search = "SELECT pro_name FROM tsp_product WHERE pro_name!='' ".$sql_and." order by convert (pro_name using tis620) ASC ";	
		$con_product_name_search= mysql_query($sql_product_name_search,$conn);
		while($rs_product_name_search = mysql_fetch_array($con_product_name_search)){
		$pro_name_search_array[]=iconv('tis-620','utf-8',$rs_product_name_search[pro_name]);		
		}

		$sql_product_position_search = "SELECT pro_block_positions FROM tsp_product where pro_block_positions!='' ".$sql_and." group by pro_block_positions order by pro_block_positions ASC ";	
		$con_product_position_search= mysql_query($sql_product_position_search,$conn);
		while($rs_product_position_search = mysql_fetch_array($con_product_position_search)){
		$pro_block_search_array[]=' '.iconv('tis-620','utf-8',$rs_product_position_search[pro_block_positions]);	
		}
			
		}
 ?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>คลังสินค้า</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="../textcs.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/main_loading_prompt.css">
<link rel="stylesheet" href="../css/text_prompt.css">
		<!-- DATEPICKER -->
		<link rel="stylesheet" media="all" type="text/css" href="../jquerydatepicker/jquery-ui.css" /> 
		<link rel="stylesheet" media="all" type="text/css" href="../jquerydatepicker/jquery-ui-timepicker-addon.css" />

		<script type="text/javascript" src="../jquerydatepicker/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="../jquerydatepicker/jquery-ui.min.js"></script>

		<script type="text/javascript" src="../jquerydatepicker/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="../jquerydatepicker/jquery-ui-sliderAccess.js"></script>
		<script type="text/javascript"> //income date

		$(function(){
		$("#last_date").datepicker({
		dateFormat:"yy-mm-dd",
		numberOfMonths:1,
		changeMonth:true,
		changeYear:true
	});
		});
	
$( function() {
    var availableTags_pro_code = <?php echo json_encode($pro_code_search_array); ?>;
    $( "#pro_code" ).autocomplete({
      source: availableTags_pro_code
    });
  } );
	
$( function() {
    var availableTags_pro_name = <?php echo json_encode($pro_name_search_array); ?>;
    $( "#pro_name" ).autocomplete({
      source: availableTags_pro_name
    });
  } );
	
$( function() {
    var availableTags_pro_position = <?php echo json_encode($pro_block_search_array); ?>;
    $( "#pro_position" ).autocomplete({
      source: availableTags_pro_position
    });
  } );
		</script>
		<!-- END DATEPICKER -->


<style type="text/css">
	
body {
	
    -ms-user-select: none;
    -webkit-user-select: none;
    user-select: none;
}
	
body,td,th {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	padding:0 0 0 0;
}
.textbl1_11 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: #00049D;
	text-decoration: none;
}
.textr11 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: red;
	text-decoration: none;
}
.texb11 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
	color: red;
	text-decoration: none;
}
</style>
<link href="../calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../simplecalendar.js" type="text/javascript"></script>

<style>	
body {
	font-family: 'Prompt', sans-serif;	
	font-size:  10px;
	padding:0px 2px 0px 2px;
		}
.round_button {
	width: 24px;
	height: 24px;
  	border-radius: 24px;
	align-items: center;
	justify-content:center;
	font-size:  12px;
	font-weight:  &nbsp; normal;
	color:white;
	background:#3399FF;
	display: flex;	
	padding: 2 2 2 2;
}
.round_button_white {
	width: 24px;
	height: 24px;
  	border-radius: 24px;
	align-items: center;
	justify-content:center;
	font-size:  12px;
	font-weight:  &nbsp; normal;
	color:white;
	background:white;
	display: flex;	
	padding: 2 2 2 2;
}
.round_button_white a:link {
    text-decoration: none;
}

.round_button_white a:visited {
    text-decoration: none;
}

.round_button_white a:hover {
	width: 24px;
	height: 24px;
  	border-radius: 24px;
	align-items: center;
	justify-content:center;
	font-size:  12px;
	font-weight:  &nbsp; normal;
	color:#00049D;
	background:#F8CACB;
	display: flex;	
	padding: 2 2 2 2;
}

.round_button_white a:active {
    text-decoration: none;
}
	/* Remove <td>'s interior cell-padding */
td.fulltd {
	width: 30px;
    padding: 0em 0em 0em 0em;
}

/* Make the <a> fill the whole td */
td a.fulltd {
    display: block;
    width: 100%;
    height: 100%;
	font-family: 'Prompt', sans-serif;
	font-size:  12px;
	font-weight:normal;
	color:#0C51A0;
	text-decoration: none;
  vertical-align: middle;
}

/* Let the <div> provide the clickable cell-padding */
div.fulltd {
    height:100%;
    width:100%;
  vertical-align: middle;
}

a:link {
    text-decoration: none;
}

a:visited {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

a:active {
    text-decoration: none;
}


a, a:visited, a:hover, a:active {
    text-decoration:none;
}
</style>
	
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
	<style>	
body {
		}
.text_Nunito_white_25 {font-family: 'Nunito', sans-serif;
	font-size:  25px;
	font-weight:  &nbsp; normal;
	color:white;
	text-decoration:  &nbsp; none;
}
.text_Nunito_white_12 {font-family: 'Nunito', sans-serif;
	font-size:  12px;
	font-weight:  &nbsp; normal;
	color:white;
	text-decoration:  &nbsp; none;
}
</style>


</head>
<body  bgproperties="fixed">
<div align="center">
  <table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td  bgcolor="#0C51A0" ><table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#0C51A0">
        <tbody>
          <tr>
            <td><img src="../image_banner/banner-ASP-01.gif"></td>
            <td width="64"><? 

		if($rs_accessibility_chk[view_fg_price]=="1"){$view_fg_price=true;} else {$view_fg_price=false;}
		if($rs_accessibility_chk[view_mt_price]=="1"){$view_mt_price=true;} else {$view_mt_price=false;}
				  
				  if($rs_accessibility_chk[super_user]=="1" || $rs_accessibility_chk[super_admin]=="1"){ ?>
              <a href="accessibility_warehouse_management.php" target="_new"> <img src="../image_button/button_setting_128x128_white.png" width="48" height="48" alt=""/></a>
              <? } ?></td>
          </tr>
          <tr>
            <td height="3" colspan="3" bgcolor="#959595"></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="10%" align="left" valign="top" bgcolor="#FFFFFF"><table width="200" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="36" background="../image_menu/menu1.gif" class="textwB12"></td>
        </tr>
        <tr>
          <td height="58" background="../image_menu/menu2.gif"><table width="190" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="17">&nbsp;</td>
              <td width="173" height="18"><iframe   class="linkb12" frameborder="0" scrolling="<? echo $scr;?>"  src="../menu_main.php" name="fram1" height="1200" width="165"></iframe>
                <div align="left"></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" background="../image_menu/menu3.gif">&nbsp;</td>
        </tr>
      </table></td>
      <td width="90%" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="100%" valign="top"><div align="center">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td bgcolor="#C7C8CA">&nbsp;</td>
                    <td bgcolor="#C7C8CA" align="center"><table width="800" border="0" cellspacing="0" cellpadding="0">
                      <tbody><tr>
                              <td width="267" bgcolor="#AEADC4"><div align="center"><img src="imgs/menu01_1.jpg" width="267" height="40" border="0"></div></td>
                              <td width="267" bgcolor="#AEADC4"><div align="center"><a href="daily.php"><img src="imgs/menu02.jpg" width="267" height="40" border="0"></a></div></td>
                              <td width="267" bgcolor="#AEADC4"><div align="center"><a href="report.php"><img src="imgs/menu03.jpg" width="267" height="40" border="0"></a></div></td>
                              </tr>
                      </tbody>
                    </table></td>
                    <td bgcolor="#C7C8CA">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                        <tr>
                          <td align="center"><table width="794" border="0" cellspacing="0" cellpadding="0">
                            <tr><td colspan="3" valign="top" align="center"><table width="794" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="146"><div align="center"><a href="product.php"><img src="imgs/toolbar01.jpg" width="198" height="64" border="0"></a></div></td>
                                  <td width="190"><div align="center"><a href="unit_list.php"><img src="imgs/toolbar02.jpg" width="198" height="64" border="0"></a></div></td>
                                  <td width="165"><div align="center"><a href=#><img src="imgs/toolbar03.jpg" width="198" height="64" border="0"></a></div></td>
                                  <td width="176"><div align="center"><a href=#><img src="imgs/toolbar04.jpg" width="198" height="64" border="0"></a></div></td>
                                  </tr>
                              </table></td>
                            </tr>
                          </table></td>
                        </tr>
                      </tbody>
                    </table></td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>
			  
              <table width="100%" border="0" cellpadding="0" cellspacing="1" bordercolor="#333333">
                <? if(!empty($sql)){?>
                <? }?>
                <?   if(!empty($pro_type)){$txt_pro_type=$pro_type ; $txt_cate=substr($txt_pro_type,0,2) ; $txt_type=substr($txt_pro_type,2,2); $pro_category="" ; } ?>
                <tr>
                  <td height="25" colspan="10" align="center" bgcolor="#F7FCDA" class="textwB12" ><form action="product.php?pro_category=<? echo $pro_category?>#pro_list" enctype="multipart/form-data" method="post" name="form1"><table width="100%" border="0" cellpadding="0" cellspacing="0">
					  
                                <tr> 
								
                                  <td align="right" class="textblB1_12">
									  <? if($rs_accessibility_chk[edit_info_pro]=="1"){?>
									  <a href="add_product.php?pro_category=<? echo $pro_category;?>&pro_subtype=<? echo $pro_subtype;?>" class="textrB12"><img src="../image_icon/add_32x32_icon.gif" width="32" height="32" border="0"></a>
									<?;}?></td>
								
								   <td align="left" class="textblB1_12">
									   <? if($rs_accessibility_chk[edit_info_pro]=="1"){?>
									   <a href="add_product.php?pro_category=<? echo $pro_category;?>&pro_subtype=<? echo $pro_subtype;?>" class="text_prompt_red_12">เพิ่มสินค้าใหม่</a>
									   <?;}?>
									</td>
								 
                                 
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="text_prompt_blue_12">ค้นหา...</td>
                                  <td align="right" height="45" class="text_prompt_blue_12">&nbsp;&nbsp;ประเภท</td>
                                  <td align="left">&nbsp;</td>
                                  <td width="24%" align="left">
                                      <select name="pro_category" class="text_prompt_black_12" id="pro_category" onChange="top.location.href=this.options[this.selectedIndex].value;" value="GO">
                                        <option value=''> เลือกประเภท  </option>
                                        <?php 
		$sql = "SELECT * FROM  pro_category WHERE pro_category='10' OR pro_category='11' ORDER BY   pro_category_id ASC";
		$faqtypeName = mysql_query($sql,$conn);
		while($rsName = mysql_fetch_array($faqtypeName))
				{
					if($rsName[pro_category] == $pro_category )
						$sel2 = "selected";
					else
					 	$sel2 = "";
					echo "<option value='product.php?pro_category=".$rsName[pro_category]."' $sel2>$rsName[cat_name]</option>";
				}
				 if($pro_category=="SAMPLE"){$sel2 = "selected";}else{$sel2 = "";}
				echo "<option value='product.php?pro_category=SAMPLE' $sel2 >ตัวอย่างวัตถุดิบ</option>";
?>

                                      </select>
									</td>
                                </tr>
<?		
$sql_subtype = "SELECT subtype_id FROM  pro_subtype where pro_category='$pro_category' limit 1";
$con_subtype = mysql_query($sql_subtype,$conn);
$rs_subtype = mysql_fetch_array($con_subtype);

 if($rs_subtype){ ?>				  
                                <tr> 
								
                                  <td align="right" class="textblB1_12"></td>
								
								   <td align="left" class="textblB1_12"></td>                               
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="text_prompt_blue_12"></td>
                                  <td align="right" class="text_prompt_blue_12">&nbsp;&nbsp;ประเภทอุปกรณ์</td>
                                  <td align="left">&nbsp;</td>
                                  <td width="24%" align="left">
 <select name="pro_subtype" class="text_prompt_black_12" id="pro_subtype" onChange="top.location.href=this.options[this.selectedIndex].value;" value="GO">
                                        <?php 
		$sql_subtype = "SELECT * FROM  pro_subtype where pro_category='$pro_category'  ORDER BY subtype_id ASC";
		$con_subtype = mysql_query($sql_subtype,$conn);
		while($rs_subtype = mysql_fetch_array($con_subtype))
				{ ?>
										  
					<option value="<? echo 'product.php?pro_subtype='.$rs_subtype[subtype_id];?>" <? if($rs_subtype[subtype_id] == $pro_subtype ){ echo "selected";};?>><? echo $rs_subtype[subtype_name_thai];?></option>
	<?									  
				}
?>

                                      </select>
									</td>
                                </tr>				
                               <tr>
                                  <td width="6%" class="textblB1_12">&nbsp;</td>
                                  <td width="14%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="18%" class="textblB1_12">&nbsp;</td>
                                  <td align="right" width="17%" class="textblB1_12"></td>
                                  <td width="1%">&nbsp;</td>
                                  <td></td>
								  <td></td>
                                </tr>
<? } ?>					  
                                <tr>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td align="right" class="text_prompt_blue_12">
								  <? switch($pro_category){
									  case "12":
									  echo "&nbsp;&nbsp;รหัสอุปกรณ์";
									  break;
									  default:
									  echo "&nbsp;&nbsp;รหัสสินค้า";
									break;
								  }
									  ?>
									  </td>
                                  <td>&nbsp;</td>
                                  <td>
                                    <div align="left">
                                    <input name="pro_code" type="text" id="pro_code" value="<? echo $pro_code;?>" autocomplete="off" >
                                    </div></td></tr>
					  
                                <tr>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
                                  <td class="textblB1_12">&nbsp;</td>
							<? switch($pro_category){
										case "10":
									?>
                                  <td align="right" height="45" class="text_prompt_blue_12">ชื่อวัตถุดิบ</td>
									<?
										break;
										case "11"
									?>	
                                  <td align="right" height="45" class="text_prompt_blue_12">สินค้าสำเร็จรูป/ART No.</td>							
									<?
										break;
										case "12":
									?>
                                  <td align="right" height="45" class="text_prompt_blue_12">ART No. </td>	
									<? 	
										break;
										default:
									?>
                                  <td align="right" height="45" class="text_prompt_blue_12">ชื่อวัตถุดิบ</td>	
									<?
										break;
										}
									?>
                                  <td align="left">&nbsp;</td>
                                  <td align="left">
                                        
                                    <div align="left">
                                      <input name="pro_name" type="text" id="pro_name" value="<? echo $pro_name;?>" autocomplete="off">
                                    </div></td></tr>
									
									
<?if($pro_category!="12"){?>								
						<tr>
                                  <td width="6%" class="textblB1_12">&nbsp;</td>
                                  <td width="14%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="18%" class="textblB1_12">&nbsp;</td>
                                  <td align="right" width="17%" class="text_prompt_blue_12">&nbsp;&nbsp;ถึง วันที่ </td>
                                  <td width="1%">&nbsp; </td>
                              <td class="textblB1_12">
                            <div align="left">
								
                              <input name="last_date" type="text" class="text_prompt_blue_12" id="last_date" size="20" value="<? echo  $last_date;?>" autocomplete="off"></div></td>
									
                        </tr>					
                               <tr>
                                  <td width="6%" class="textblB1_12">&nbsp;</td>
                                  <td width="14%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="18%" class="textblB1_12">&nbsp;</td>
                                  <td align="right" width="17%" class="textblB1_12"></td>
                                  <td width="1%">&nbsp;</td>
                                  <td></td>
								  <td></td>
                                </tr>	

<? } ?>								
								<tr>
                                  <td width="6%" class="textblB1_12">&nbsp;</td>
                                  <td width="14%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="18%" class="textblB1_12">&nbsp;</td>
                                  <td align="right" width="17%" class="text_prompt_blue_12">&nbsp;&nbsp;ตำแหน่งที่จัดเก็บ</td>
                                  <td width="1%">&nbsp;</td>
                                  <td>
                                    
                                     <div align="left">
                          <input name="pro_position" type="text" id="pro_position" value="<? echo trim($pro_position);?>" autocomplete="off">
                       
                    </div>
                     
                                   </td>
									<td>
                                </tr>
                                
                               <tr>
                                  <td width="6%" class="textblB1_12">&nbsp;</td>
                                  <td width="14%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="18%" class="textblB1_12">&nbsp;</td>
                                  <td align="right" width="17%" class="textblB1_12"></td>
                                  <td width="1%">&nbsp;</td>
                                  <td></td>
								  <td></td>
                                </tr>
								
								<tr>
                                  <td width="6%" class="textblB1_12">&nbsp;</td>
                                  <td width="14%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="18%" class="textblB1_12">&nbsp;</td>
                                  <td align="right" width="17%" class="textblB1_12"></td>
                                  <td width="1%">&nbsp;</td>
                                  <td></td>
								  <td></td>
                                </tr>
                                <tr>
                                  <td colspan="7"> </td>
                                  <td>
									  <div align="left">
                                    <input name="pro_category" type="hidden" value="<? echo $pro_category;?>" />
                                    <input name="pro_subtype" type="hidden" value="<? echo $pro_subtype;?>" />
                                    <input name="Submit2222" type="submit" class="text_prompt_black_12" value="ค้นหา" />
                                  </div></td>
                                </tr>
								
                                
                               <tr>
                                  <td width="6%" class="textblB1_12">&nbsp;</td>
                                  <td width="14%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="10%" class="textblB1_12">&nbsp;</td>
                                  <td width="18%" class="textblB1_12">&nbsp;</td>
                                  <td align="right" width="17%" class="textblB1_12"></td>
                                  <td width="1%">&nbsp;</td>
                                  <td></td>
								  <td></td>
                                </tr>
                              </table>
                              </form></td>
                  </tr>
				  
                                
                               <tr>
                                  <td colspan="20" width="100%" align="center">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#DFDFDF">
  <tbody>
    <tr >
      <td><div align="center">
		<? if( (!(empty($last_date)) ||!(empty($pro_id))||!(empty($pro_code)) || !(empty($pro_name)) || !(empty($pro_category))  || !(empty($pro_cus))  || !(empty($pro_type)) || !(empty($pro_position))|| !(empty($pro_subtype)) ) && $pro_category!="12"  ) { ?>
                   <a href="excel_stock_warehouse.php?pro_id=<?php echo $pro_id;?>&pro_code=<?php echo $pro_code;?>&pro_name=<?php echo $pro_name1;?>&pro_category=<?php echo $pro_category;?>&pro_cus=<?php echo $pro_cus;?>&pro_type=<?php echo $pro_type;?>&pro_position=<?php echo $pro_position1;?>&last_date=<?php echo $last_date;?>&sid=<?php echo $ID;?>"><img src="imgs/btn_export_excel.jpg" width="647" height="61" alt=""/>
        <? ;} ?>
           </div>        
		</td>
    </tr>
  </tbody>
</table>

								  
								  </td>
                                </tr>
				  
				<tr>
                  <td valign="middle" colspan="<? if($rs_accessibility_chk[edit_info_pro]=='1'){echo '10';}else{echo '9';}?>" width="40" height="35" align="center" bgcolor="#F84E51" class="text_prompt_white_16" >รายการยอดคงเหลือ ต่ำกว่าหรือเท่ากับ จำนวนขั้นต่ำ ( SAFETY STOCK )</td>
				</tr>
				
				<tr>
                  <td colspan="2" height="25" valign="middle"  align="center" bgcolor="#F84E51" class="text_prompt_white_12" >
				  <? echo $topic_txt1;?>
				  </td>
                  <td colspan="<? if($rs_accessibility_chk[edit_info_pro]=='1'){echo '5';}else{echo '4';}?>" valign="middle"  align="center" bgcolor="#F84E51" class="text_prompt_white_12"><? echo $topic_txt2;?></td>
                  <td colspan="3" valign="middle"  align="center" bgcolor="#F84E51" class="text_prompt_white_12" >ยอดคงเหลือ</td>
                </tr>
				
				<tr>
					<td height="5" colspan="9" bgcolor="#FFFFFF"></td>
				</tr>
				<?
				$safety_stock_i=0;$ij=1;
				$sql_safety_stock = "SELECT * FROM tsp_product where min_quantity !='' AND (pro_category='10' OR pro_category='11')";
				switch($pro_category) {
					case "10":
					$sql_safety_stock .= "  AND pro_category='10'";	
					break;	
					case "SAMPLE":
					$sql_safety_stock .= "  AND pro_category='10'";	
					break;	
					case "11":
					$sql_safety_stock .= "  AND pro_category='11'";	
					break;		
					case "12":
					$sql_safety_stock .= "  AND pro_category='12' AND pro_subtype='$pro_subtype'";	
					break;		
					case "":
					break;	
				}
				  
				$sql_safety_stock .= " order by pro_code ";
				$con_safety_stock = mysql_query($sql_safety_stock,$conn);
				while($rs_safety_stock= mysql_fetch_array($con_safety_stock)) {
					
					if(($ij%2)==0){ $bg_col="#F8CACB"; }else{  $bg_col="#FFFFFF";}
					
					$sql_safety_stock_in = "SELECT sum(io_amount) AS in_amount FROM tsp_product_io where pro_id='$rs_safety_stock[pro_id]' and io_type='IN' ";
					$con_safety_stock_in = mysql_query($sql_safety_stock_in,$conn);
					$rs_safety_stock_in  = mysql_fetch_array($con_safety_stock_in);
					
					$sql_safety_stock_out = "SELECT sum(io_amount) AS out_amount FROM tsp_product_io where pro_id='$rs_safety_stock[pro_id]' and io_type='OUT' ";
					$con_safety_stock_out = mysql_query($sql_safety_stock_out,$conn);
					$rs_safety_stock_out  = mysql_fetch_array($con_safety_stock_out);
					
					$net_safety_stock=$rs_safety_stock_in[in_amount]-$rs_safety_stock_out[out_amount];
					
					$sql_date_stock_out = "SELECT create_date,MAX(out_date) AS last_out_date  FROM tsp_product_out where pro_id='$rs_safety_stock[pro_id]' group by pro_id ";
					$con_date_stock_out = mysql_query($sql_date_stock_out,$conn);
					$rs_date_stock_out  = mysql_fetch_array($con_date_stock_out);
				?>
				<? if($net_safety_stock<=$rs_safety_stock[min_quantity]){ $safety_stock_i++;$ij++;
					if($net_safety_stock<="0"){$text_color="textr11";} else {$text_color="textbl1_11";}?>
				<tr>
				  <td width="32" valign="middle" align="center" class="<? echo $text_color;?>" bgcolor="<? echo $bg_col ;?>" ><? echo $safety_stock_i;?></td>
				  <td valign="middle"  align="left" class="<? echo $text_color;?>" bgcolor="<? echo $bg_col ;?>"><a href="detail_product.php?pro_id=<?  echo $rs_safety_stock[pro_id]?>#stockcard_list" class="<? echo $text_color;?>" target="_blank"><? echo $rs_safety_stock[pro_code];?></a></td>
                  <td colspan="<? if($rs_accessibility_chk[edit_info_pro]=='1'){echo '5';}else{echo '4';}?>" valign="middle" align="left" class="<? echo $text_color;?>" bgcolor="<? echo $bg_col ;?>">
					  <a href="detail_product.php?pro_id=<?  echo $rs_safety_stock[pro_id]?>#stockcard_list" class="<? echo $text_color;?>" target="_blank">
					<? echo html($rs_safety_stock[pro_name]);echo ' '.'<i class="fa fa-search" aria-hidden="true"></i>' ;?>
					  </a>
					  <div>
						  <? if(($rs_date_stock_out[last_out_date])){ echo " ***  ทำการเบิกครั้งล่าสุด ณ. วันที่ ". nar_date2($rs_date_stock_out[last_out_date]);}?>
					  </div>
					</td>
				  <td colspan="2" valign="middle" align="right" class="<? echo $text_color;?>" bgcolor="<? echo $bg_col ;?>"><? if (is_real($net_safety_stock)){ echo number_format($net_safety_stock,2,'.',',')." ".$rs_safety_stock[pro_unit];} else { echo number_format($net_safety_stock,0,'.',',')." ".$rs_safety_stock[pro_unit];};?></td> 
				  <td valign="middle"  align="center" class="<? echo $text_color;?>" bgcolor="<? echo $bg_col ;?>"><div align="center"><a href="r_stock_card.php?pro_idd=<? echo $rs_safety_stock[pro_id]?>&desc1=<? echo $rs_safety_stock[pro_name]?>" class="linkrB12" target="_new"><img src="pic/st_card.gif"  height="22" border="0"></a></div></td> 
				</tr>
				<? ;} ?>
				<? ;} ?>
				<tr>
					<td height="25" colspan="9" bgcolor="#FFFFFF" ><a name="pro_list"></td>
				</tr>
                <?				
switch($pro_category){
	case "10":
	$topic_th="วัตถุดิบในการผลิต";
	$topic_en="  RAW MATERIALS";
	
	break;
	case "SAMPLE":
	$topic_th="ตัวอย่างวัตถุดิบ";
	$topic_en="  SAMPLE RAW MATERIALS";
	break;
	case "11":
	
	$topic_th="สินค้าสำเร็จรูป";
	$topic_en="  FINISHED GOODS";
	break;
	case "12":
	
	$topic_th="อุปกรณ์งานพิมพ์";
	$topic_en="  PRINTING EQUIPMENT";
	break;
	default;
	$topic_th="รายการสินค้า";
	$topic_en="";
	break;
	
}
				switch($rs_accessibility_chk[edit_info_pro]){
					case "1":
				?>
				<tr>
                  <td valign="middle" colspan="10" width="5%" height="35" align="center" bgcolor="#0C51A0"  class="text_prompt_white_16" ><? echo $topic_th.$topic_en ;?></td>
				</tr>
				<?
				break;
				default;
				?>
				<tr>
                  <td valign="middle" colspan="9" width="5%" height="35" align="center" bgcolor="#0C51A0"  class="text_prompt_white_16" ><? echo $topic_th.$topic_en ;?></td>
				</tr>
				
				<?
				}
				?>
                <tr>
                  <td colspan="2" valign="middle"  width="20%" align="center"  bgcolor="#0C51A0" class="text_prompt_white_12" ><? echo $topic_txt1;?></td>
                  <td valign="middle"  width="50%" align="center" bgcolor="#0C51A0"  class="text_prompt_white_12"><? echo $topic_txt2;?></td>
				  <td valign="middle"  width="10%" align="center"  bgcolor="#0C51A0" class="text_prompt_white_12" >สถานที่จัดเก็บ</td> 
                  <td valign="middle"  width="5%" align="center"  bgcolor="#0C51A0" class="text_prompt_white_12" >ราคาต่อหน่วย</td>
                  <td valign="middle" colspan="2" width="5" align="center"  bgcolor="#0C51A0" class="text_prompt_white_12" >ยอดคงเหลือ</td>
				  <td valign="top" width="50" align="center"  bgcolor="#0C51A0" class="text_prompt_white_12" >
				  <? switch($pro_category){
					  case"12":
					  echo "QR<br>Tag";
					  break;
					  default:
					  echo "QR<br>Label";
					  break;
				  }?>
				  </td> 	  
				<td valign="top" width="66" align="center"  bgcolor="#0C51A0" class="text_prompt_white_12" >STOCK<br>CARD</td>
				  <? if($rs_accessibility_chk[edit_info_pro]=="1"){?>                 
                  <td valign="middle"  width="36" align="center"  bgcolor="#0C51A0" class="text_prompt_white_12" >แก้ไข</td>
                  <?;}?>
                </tr>
				<tr> 
					<td height="5" colspan="9" bgcolor="#FFFFFF"></td>
				</tr>
				  <? if( !(empty($pro_code)) || !(empty($pro_name)) || $pro_category!="" || !(empty($pro_positon))  ) { ?>
                <!-- BEGIN DYNAMIC BLOCK: rows -->
                <?php 	
	$sql = "SELECT * FROM  tsp_product   WHERE  id!=''  AND (pro_category='10' OR pro_category='11')";	
	$pro_name1=  iconv('TIS-620','UTF-8',$pro_name);	
	$pro_position1=  iconv('TIS-620','UTF-8',$pro_position);
	if(!empty($pro_name)){$sql .= "  AND pro_name LIKE '%$pro_name%'" ;}
	if(!empty($pro_cus)){ $sql .= "  AND pro_cus_name LIKE '%$pro_cus%'" ;}
	if(!empty($pro_code)){if(is_numeric($pro_code) && (($pro_code)*1)>100000000){$pro_id=$pro_code;$pro_code="";$sql .= "  AND pro_id LIKE '$pro_id'" ;}else{ $sql .= "  AND pro_code LIKE '%$pro_code%'";};}
	if(!empty($pro_subtype)){$sql .= "  AND pro_subtype ='$pro_subtype'" ;} else {if($pro_category=="12"){$sql .= "  AND pro_subtype ='3'" ; } }
	
switch($pro_category){
	case "10":
	$sql .= "  AND  pro_category ='10' AND NOT(pro_code like '%/S')";
		break;
	case "SAMPLE":
	$sql .= "AND  pro_category ='10'  AND  pro_code like '%/S'";
		break;
	case "11":
	$sql .= "  AND  pro_category ='11'";
		break;
	case "12":
	$sql .= "  AND  pro_category ='12'";
		break;
	case "":
		break;			
}
	if(!empty($pro_position)){$sql.= "  AND pro_block_positions LIKE '%".trim($pro_position)."%'";}
	
	$sql.= "  AND pro_category !='12'";

		$list = mysql_query($sql,$conn);
	
	
//******* การแบ่งหน้า *********
		$Page = $_GET[Page];
		$View = $_GET[View];
		
		if(!$Page) $Page=1;
		
		if($View=="") 
		{
			if(($Page%$Per_View)==0)
				$View = $Page/$Per_View;
			else
				$View = ($Page/$Per_View)+1;
			
			$View = (int)$View;
		}
		$Prev_Page = $Page-1;
		$Next_Page = $Page+1;
		$Prev_View = $View-1;
		$Next_View = $View+1;
				
		$Page_start = ($Per_Page * $Page) - $Per_Page;		
		$Num_Rows = mysql_num_rows($list);    //ชื่อ recordset		
		if($Num_Rows<=$Per_page)
			$Num_Pages = 1;
		else if(($Num_Rows%$Per_Page)==0)
			$Num_Pages = ($Num_Rows/$Per_Page);
		else
			$Num_Pages = ($Num_Rows/$Per_Page)+1;
			
		$Num_Pages = (int)$Num_Pages;
		
		switch ($pro_category) {
			case "10":
				$sql .= "   ORDER  BY pro_code ";
				break;
			case "11":
				$sql .= "   ORDER  BY pro_code ";
				break;
			default:
				$sql .= "   ORDER  BY pro_code ";
		
			}	
		$sql .= " LIMIT $Page_start,$Per_Page";      //excute database again
		$list = mysql_query($sql);      
			$Num_Rows2 = mysql_num_rows($list);    //ชื่อ recordset		
		if($Num_Pages<=$Per_View)
			$Num_View = 1;
		else if(($Num_Pages%$Per_View)==0)
			$Num_View = ($Num_Pages/$Per_View);
		else
			$Num_View = ($Num_Pages/$Per_View)+1;
		
		$Num_View = (int)$Num_View;

		$i=($Page-1) * $Per_Page;
		$j=0;
		while($rsList=mysql_fetch_array($list))
		{
			
				$sql22 = "SELECT * FROM tsp_product,sales WHERE tsp_product.search_sale_id = sales.sale_id AND tsp_product.search_sale_id='".$rsList['search_sale_id']."'";
				
				$cus21 = mysql_query($sql22,$conn);
				$rs22=mysql_fetch_array($cus21);
				
				$ii+=1;
				if(($ii%2)==0){  $bgcolor="#DFDFDF"; }else{	$bgcolor="#FFFFFF";}
				$ddat="2010-12-14";
?>
                <tr bgcolor="<? echo $bgcolor;?>">
                  <td width="32"  height="25" valign="middle" class="textbl1_12" ><div align="center">
					<?php echo (($Page-1)*$Per_Page)+$ii;?>
                  </div></td>
					<?	if (empty($last_date)){
				  	$sqlz = "SELECT  sum(in_amount) AS pro_amonut FROM tsp_product_in  WHERE pro_id ='$rsList[pro_id]'";
					$rsz = mysql_query($sqlz);
					$resultz=mysql_fetch_array($rsz);
					$inn=$resultz[pro_amonut];
					$sqly = "SELECT  sum(out_amount) AS pro_amonut2 FROM tsp_product_out  WHERE pro_id ='$rsList[pro_id]'";
					$rsy = mysql_query($sqly);
					$resulty=mysql_fetch_array($rsy);
					$outt=$resulty[pro_amonut2];
					$nett=$inn-$outt;
					} else {
		            $sqlz = "SELECT  sum(in_amount) AS pro_amonut FROM tsp_product_in  WHERE pro_id ='$rsList[pro_id]' AND in_date <= '$last_date' ";
					$rsz = mysql_query($sqlz);
					$resultz=mysql_fetch_array($rsz);
					$inn=$resultz[pro_amonut];
					$sqly = "SELECT  sum(out_amount) AS pro_amonut2 FROM tsp_product_out  WHERE pro_id ='$rsList[pro_id]' AND out_date <= '$last_date'";
					$rsy = mysql_query($sqly);
					$resulty=mysql_fetch_array($rsy);
					$outt=$resulty[pro_amonut2];
					$nett=$inn-$outt;
		
					}
			        ?>
                  <td valign="middle" class="textbl1_12" >
					  <div align="left"><a href="detail_product.php?pro_id=<?  echo $rsList[pro_id]?>&pro_code=<? echo $rsList[pro_code]?>#stockcard_list" class="textbl1_12" target="_blank"><? echo $rsList[pro_code]?></a> <span class="textr12">
				      <? $safety_stock=$rsList[min_quantity]; if(!empty($rsList[min_quantity])){if($nett<=$safety_stock){?>
				      <br><? echo "** กรุณาสั่งสินค้าเพิ่ม !!";} ;}?></span> </div>
				  </td>
                  <td valign="middle" class="textbl1_12" ><div align="left">
				  <div align="left"><a href="detail_product.php?pro_id=<?  echo $rsList[pro_id]?>&pro_code=<? echo $rsList[pro_code]?>#stockcard_list" class="textbl1_12" target="_blank"><? 
				  
			switch($rsList[pro_category]){
				   case "10":								
				      echo html($rsList[pro_name]);
					break;
					case "11":	
						echo html($rsList[pro_name]);
						if(!empty($rsList[pro_detail])){ echo " ".html($rsList[pro_detail]);}		
					break;
					case "12":
					switch($rsList[pro_subtype]){
						case "5":							

				$sql_dicut_equip = "SELECT * FROM  gd_diecut  WHERE dicut_id = '".trim($rsList[pro_code])."'";
				$con_dicut_equip = mysql_query($sql_dicut_equip,$conn);
				$rs_dicut_equip = mysql_fetch_array($con_dicut_equip);
							
if(empty($rs_dicut_equip[dicut_length])){ $size_txt=$rs_dicut_equip[dicut_width];}else{ $size_txt=$rs_dicut_equip[dicut_width].' x '.$rs_dicut_equip[dicut_length];}
if(empty($size_txt)){$size_txt="-";}else{$size_txt=$size_txt.' mm.';}
if(empty($rs_dicut_equip[dicut_type])){$type_txt="-";}else{$type_txt=$rs_dicut_equip[dicut_type];}
if(empty($rs_dicut_equip[dicut_r])){$r_txt="-";}else{$r_txt=$rs_dicut_equip[dicut_r].' mm.';}
if(empty($rs_dicut_equip[dicut_v_gap])){$v_gap_txt="-";}else{$v_gap_txt=$rs_dicut_equip[dicut_v_gap].' mm.';}
if(empty($rs_dicut_equip[dicut_h_gap])){$h_gap_txt="-";}else{$h_gap_txt=$rs_dicut_equip[dicut_h_gap].' mm.';}
if(empty($rs_dicut_equip[dicut_layout])){$layout_txt="-";}else{$layout_txt=$rs_dicut_equip[dicut_layout];}	
							
						echo html($rsList[pro_name]);
						if(!empty($rsList[pro_detail])){ echo $rsList[pro_detail];}
						echo "<br>ขนาด : ".$size_txt;	
						if(!empty($rs_dicut_equip[dicut_r])){echo " , มุมมน : ".$r_txt;}
						if(!empty($rs_dicut_equip[dicut_v_gap]))echo " , ระยะระหว่างดวง : ".$v_gap_txt;	
						if(!empty($rs_dicut_equip[dicut_h_gap]))echo " , ระยะระหว่างแถว : ".$h_gap_txt;	
						if(!empty($rs_dicut_equip[dicut_layout]))echo " , เลย์เอาท์ : ".$layout_txt;	
						if(!empty($rsList[pro_detail2])){ echo "<br>"." Remark : ".$rsList[pro_detail2];}
						break;
						default:
						echo html($rsList[pro_name]);
						if(!empty($rsList[pro_detail])){ echo " ".$rsList[pro_detail];}
						if(!empty($rsList[pro_detail2])){ echo "<br>"." Remark : ".$rsList[pro_detail2];}
						break;
					}
					break;
					default:
						echo html($rsList[pro_name]);
					break;
			}
				  
				echo ' '.'<i class="fa fa-search" aria-hidden="true"></i>';?></a></div></td>
				 <td valign="middle"align="center" valign="top" class="textbl1_12" ><div  align="center">&nbsp;<?php echo $rsList[pro_block_positions]; ?></div></td>
				 
				 <td valign="middle"align="center" valign="top" class="textbl1_12" ><div  align="center">
<?
switch ($rsList[pro_category]){
  case "10":
		if($rs_accessibility_chk[view_mt_price]=="1"){ echo number_format($rsList[pro_price],2,'.',',');
		} else { echo "-" ;}	
    break;
  case "11":
			if($rs_accessibility_chk[view_fg_price]=="1"){
				if($rsList[pro_price]!="0"){
				echo number_format($rsList[pro_price],4,'.',',');
				} else {
				echo "0.00";	
				} 
			} else{echo "-";}  			
    break;
  default:
    echo "-";
}
?>				 
				 
				 </div></td>
                
                   <td class="textbl1_12" ><div align="right"><? if (is_real($nett)){ echo number_format($nett,2,'.',',');} else {echo number_format($nett,0,'.',',');}?>&nbsp;</div></td>
                 <td  class="textbl1_12" ><div  align="left">&nbsp;<? echo $rsList[pro_unit] ?> </div></td>
				 

                 <? if($rsList[pro_category]=="12"){?> 
				 <td valign="middle" ><div align="center"><a href="Printing_Equipment_qrcode_pdf.php?pro_id=<? echo $rsList[pro_id]?>" class="linkrB12" target="_blank" ><img src="../image_icon/128x128_qrcode_icon.png" border="0" width="32"></a></div></td>
				<? } else { ?>
				 <td valign="middle" ><div align="center"><a href="product_qrcode_pdf.php?pro_id=<? echo $rsList[pro_id]?>" class="linkrB12" target="_blank" ><img src="../image_icon/128x128_qrcode_icon.png" border="0" width="32"></a></div></td>	
					<? } ?>
					
                  <td valign="middle" ><div align="center"><a href="r_stock_card.php?pro_idd=<? echo $rsList[pro_id]?>&desc1=<? echo $rsList[pro_name]?>" class="linkrB12" target="_new"><img src="pic/st_card.gif"  height="22" border="0"></a></div></td>
                 <? if($rs_accessibility_chk[edit_info_pro]=="1"){?> 
                  <td valign="middle" ><div align="center"><a href="edit_product.php?oid=<? echo $rsList[id]?>&pro_id=<? echo $rsList[pro_id]?>" ><img src="../image_icon/EDIT-icon-2.png" width="24" height="24" border="0"></a></div></td>
					
                  <? ; } ?>
				</tr>
                <?php 	}?>
                <!-- END DYNAMIC BLOCK: rows -->
				 

                   <? ;} ?> 
                </table>
                <tr ><td height="40" colspan="9"><div align="left" style="font-family: 'Prompt', sans-serif;
	font-size:  12px;font-weight:   normal;color: #00049D;text-decoration:   none;">&nbsp;&nbsp;มีรายการทั้งหมด&nbsp;<? echo number_format($Num_Rows,'0','.',',');?>&nbsp;รายการ</div></td></tr>
                      <table border="0" cellspacing="0" cellpadding="0"  height="25" align="center">
                        <tr>
                          <?php 
						  
	if($Num_Rows>$Per_Page)		{	
	
//สร้างปุ่มย้อนกลับ10
if($Prev_View)
{
	$Prev_Page_View = (($Prev_View-1)*$Per_View)+1;	
	echo "<td align=\"center\" bgcolor=\"#FFFFFF\" width=\"20\" height=\"20\"><a href=\"$PHP_SELF?$keyString&Page=$Prev_Page_View&pro_code=$pro_code&pro_id=$pro_id&pro_name=$pro_name&last_date=$last_date&pro_category=$pro_category&pro_subtype=$pro_subtype&pro_type=$txt_cate$txt_type&Page=$Prev_Page&seln=$seln&pro_position=$pro_position&View=$Prev_View#pro_list\" style=\"font-family: 'Prompt', sans-serif;	font-size:  12px;font-weight:   normal;color: red;text-decoration:   none;\">&lt;&lt;&nbsp;Prev&nbsp;&nbsp;</a></td>"		; 
}
//สร้างปุ่มย้อนกลับ
//if($Prev_Page)
	//echo "<a href=\"$PHP_SELF?$keyString&Page=$Prev_Page\" class=\"verdana_link\">&lt;&lt;Prev</a> ";
//สร้างตัวเลขหน้า
$start =  ((($View-1)*$Per_View)+1);
$end =  $start+$Per_View-1;
if($end>$Num_Pages) $end=$Num_Pages;
for($i=$start;$i<=$end;$i++)
	{
			if($i!=$Page)
				echo "<td align=\"center\" class=\"round_button_white\" width=\"20\" height=\"20\"><a class=\"fulltd\" href=\"$PHP_SELF?$keyString&pro_code=$pro_code&pro_id=$pro_id&pro_name=$pro_name&last_date=$last_date&pro_category=$pro_category&pro_subtype=$pro_subtype&pro_type=$txt_cate$txt_type&seln=$seln&pro_position=$pro_position&Page=$i#pro_list\" class=\"text_prompt_blue_14\">$i</a></td><td width=\"5\" height=\"20\" bgcolor=\"#FFFFFF\">&nbsp;</td>";
			else
				echo "<td align=\"center\"  class=\"round_button\" width=\"4%\" bgcolor=\"#60CF81\" height=\"20\"><b>$i</b></td><td width=\"5\" height=\"20\" bgcolor=\"#FFFFFF\">&nbsp;</td>";
	}
//สร้างปุ่มเดินหน้า
//if($Page!=$Num_Pages)
	//echo " <a href=\"$PHP_SELF?$keyString&Page=$Next_Page\" class=\"verdana_link\">Next&gt;&gt;</a>";
//สร้างปุ่มเดินหน้า 10
if($View!=$Num_View)
{
	$Next_Page_View = (($Next_View-1)*$Per_View)+1;
	echo " <td align=\"center\" bgcolor=\"#FFFFFF\" width=\"20\" height=\"20\"><a href=\"$PHP_SELF?$keyString&pro_code=$pro_code&pro_id=$pro_id&pro_name=$pro_name&last_date=$last_date&pro_category=$pro_category&pro_subtype=$pro_subtype&pro_type=$txt_cate$txt_type&Page=$Next_Page_View&seln=$seln&pro_position=$pro_position&View=$Next_View#pro_list\" style=\"font-family: 'Prompt', sans-serif;	font-size:  12px;font-weight:   normal;color: red;text-decoration:   none;\">&nbsp;&nbsp;Next&nbsp;&gt;&gt;</a></td>";
}

	}
 ?>
                        </tr>
                <tr ><td height="40" colspan="9">
					<div align="left" style="font-family: 'Prompt', sans-serif;	font-size:  12px;font-weight:   normal;color: #00049D;text-decoration:   none;"></div>
					</td></tr>
                      </table>
            </div></td>
          </tr>
        </table>
    </tr>
  </table>
</div>
</body>
</html>
<!-- ENCODE CHARSET -->
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<!-- ENCODE CHARSET -->	


<?
$show_info_side_zone=false;

if(isset($equip_keypass)){$pro_id=decode($equip_keypass);}
	
		$ID=$_SESSION["ID"]; 
		$dep_login=$_SESSION["dep"]; 
		if($ID=="") echo "<meta http-equiv=\"refresh\" content=\"0;URL=login.php?form_link=stock_action&pro_id=".$pro_id."\">";	
 
		$sql_accessibility_chk = "SELECT * FROM  accessibility_warehouse  WHERE  emp_id='$ID'  LIMIT 1";
 		$con_accessibility_chk = mysql_query($sql_accessibility_chk,$conn);
		$rs_accessibility_chk = mysql_fetch_array($con_accessibility_chk);

/* SQL MAIN */	

		$sql = "SELECT * FROM  tsp_product  WHERE pro_id = '$pro_id' LIMIT 1 ";
		$cus = mysql_query($sql,$conn);
		$rs  = mysql_fetch_array($cus); 

/* CHECK PO Order*/
		$sql_pro_id_chk = "SELECT 
		pro_id 
		FROM  
		tsp_product  
		WHERE 
		pro_id = '$pro_id' 
		AND pro_category='12'
		AND (pro_subtype='3' OR pro_subtype='4' OR pro_subtype='5' OR pro_subtype='6' OR pro_subtype='7')
		ORDER BY pro_id DESC LIMIT 1 ";
		$con_pro_id_chk = mysql_query($sql_pro_id_chk,$conn);
		$rs_pro_id_chk  = mysql_fetch_array($con_pro_id_chk);

if($rs_pro_id_chk){
	$ex_pro_code='';
	switch($rs[pro_subtype]){
		case "1":
			$ex_pro_code=explode(' ',$rs[pro_code]);
			$txt_equip_search=$ex_pro_code[0];
			break;
		case "2":
			$ex_pro_code=explode(' ',$rs[pro_code]);
			$txt_equip_search=$ex_pro_code[0].' '.$ex_pro_code[1].' '.$ex_pro_code[2].' '.$ex_pro_code[3];
			break;
		case "3":
			$ex_pro_code=explode(' ',$rs[pro_code]);
			$txt_equip_search=$ex_pro_code[0].' '.$ex_pro_code[1].' '.$ex_pro_code[2].' '.$ex_pro_code[3];
			break;
		case "4":
			$ex_pro_code=explode('-',$rs[pro_code]);
			$txt_equip_search=$ex_pro_code[0].'-'.$ex_pro_code[1];
			break;
		default:			
			$txt_equip_search=trim($rs[pro_code]);
			break;
			
	}
	
		$txt_where_condition="";
	
		for($i_where_condition='2'; $i_where_condition<=27 ; $i_where_condition++ ){
			$txt_where_condition.=" OR "."plpipo.desc".$i_where_condition." LIKE "."'%".$txt_equip_search."%'";
		}

		$sql_equip_po_order="
		SELECT 
		plpipo.po_id AS po_id,
		plpipo.order_no AS order_no,
		plpipo.po_date AS po_date,
		plpipo.in_date AS in_date,
		plpipo.supid AS supplier_id,
		supplier.sup_name AS supplier_name
		FROM plpipo 
		LEFT JOIN supplier ON plpipo.supid=supplier.supid
		WHERE plpipo.desc1 LIKE '%".$txt_equip_search."%'".$txt_where_condition."
		AND plpipo.po_status='0'
		GROUP BY plpipo.id
		ORDER BY plpipo.id ASC
		"
;
	
		$sql_po_order_chk = $sql_equip_po_order." LIMIT 1 ";
		$con_po_order_chk = mysql_query($sql_po_order_chk,$conn);
		$rs_po_order_chk  = mysql_fetch_array($con_po_order_chk);

}
/* CHECK PO Order*/

/* CHECK REQUIRE*/

		$sql_disposal_require_main = "
		SELECT
		gd_equip_disposal_require.equip_disposal_require_id AS equip_disposal_require_id,
		gd_equip_disposal_require.pro_id AS equip_disposal_pro_id,
		gd_equip_disposal_require.create_date AS disposal_require_date,
		new_po.order_no AS order_no,
		gd_equip_disposal_require.equip_disposal_require_desc AS equip_disposal_require_desc,
		employees_new.em_name AS disposal_require_by,
		gd_equip_disposal.equip_disposal_id AS equip_disposal_id
		FROM
		gd_equip_disposal_require
		LEFT JOIN new_po ON gd_equip_disposal_require.order_id=new_po.order_id
		LEFT JOIN employees_new ON gd_equip_disposal_require.create_by=employees_new.em_id
		LEFT JOIN gd_equip_disposal ON gd_equip_disposal_require.equip_disposal_require_id=gd_equip_disposal.equip_disposal_require_id
		WHERE gd_equip_disposal_require.pro_id='".$pro_id."' 
		AND gd_equip_disposal_require.equip_disposal_require_status='1'
		GROUP BY equip_disposal_require_id
		ORDER BY gd_equip_disposal_require.create_date ASC ";


		$sql_disposal_require_chk = $sql_disposal_require_main." LIMIT 1 ";
		$con_disposal_require_chk = mysql_query($sql_disposal_require_chk,$conn);
		$rs_disposal_require_chk  = mysql_fetch_array($con_disposal_require_chk);

/* CHECK REQUIRE*/

if(($rs[pro_category]=='12' || $rs[pro_category]=='10'|| $rs[pro_category]=='11') && ($rs_disposal_require_chk || $rs_po_order_chk || $rs[pro_category]=='10'|| $rs[pro_category]=='11') ){$show_info_side_zone=true;}
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title><? if($rs[pro_category]=='12'){echo 'EQUIPMENT PRINTING SYSTEM';} else { echo 'ASP MOBILE WAREHOUSE';} ?></title>
<link href="../../textcs.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/text_prompt.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>	
body {
	font-family: 'Prompt', sans-serif;	
	font-size:  12px;
		}
</style>
	
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
	<style>	
body {
	width: 100vw;
	margin: 0;
    -ms-user-select: none;
    -webkit-user-select: none;
    user-select: none;	
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
#pms_border {
  border-radius: 10px;
  border: 0px;
  padding: 20px; 
  width: 75%;
  box-shadow:0 3px 3px 0 rgba(0,0,0,0.2),0 3px 3px 0 rgba(0,0,0,0.19);
margin: 5px;
margin-left: 5px;
margin-right: 5px;
margin-bottom: 5px;
text-decoration: none; 
	}
		</style>
<link href="../../text.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style3 {color: #FF9900}
-->
</style>
<script>
    setTimeout(function(){
        window.location.reload();
    },5*60*1000);	/* >> MINUTE UNIT */
</script>	
</head>
<body  bgproperties="fixed">
<div align="center">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
      <tr>
        <td bgcolor="#0C51A0" class="text_Nunito_white_25">&nbsp;&nbsp;&nbsp;ASP Management Software Solutions</td>
        <td bgcolor="#0C51A0" height="64" valign="middle" align="center"><a href="javascript:window.close();"><img src="../image_icon/close-128x128-white.png" width="48" height="48"></a></td>
      </tr>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
         
          <tr>
            
            <td width="100%" valign="top">
				<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
              </tr>
              

              <tr>
                <td height="25" colspan="3" align="right" bgcolor="#FFFFFF" class="thaitext_body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
					  <?
					  
											$sql_em= "SELECT * FROM  employees_new  WHERE em_id = '$ID'  ";
											$employee = mysql_query($sql_em,$conn);
											$rs_em=mysql_fetch_array($employee);					  
					  
					  ?>
	        <tr>
	          <td bgcolor="#5F5F5F">&nbsp;</td>
              <td bgcolor="#5F5F5F">&nbsp;</td>
              <td width="136" bgcolor="#5F5F5F">&nbsp;</td>
            </tr> 		  
	        <tr>
	          <td height="30" align="right" bgcolor="#5F5F5F" class="text_prompt_white_12">บัญชีผู้ใช้งาน &nbsp;&#58;&nbsp;</td>
              <td bgcolor="#5F5F5F" class="text_prompt_white_12">&nbsp;<? echo $rs_em[em_name] ;?></td>
              <td width="136" rowspan="2" align="center" valign="middle"  bgcolor="#5F5F5F"></td>
            </tr>		  
	        <tr>
	          <td height="30" align="right" bgcolor="#5F5F5F" class="text_prompt_white_12">ตำแหน่ง&nbsp;&#58;&nbsp;</td>
              <td bgcolor="#5F5F5F" class="text_prompt_white_12">&nbsp;<? echo $rs_em[position] ;?></td>
              </tr>		  
	        <tr>
	          <td height="30" align="right" bgcolor="#5F5F5F" class="text_prompt_white_12">รหัสพนักงาน&nbsp;&#58;&nbsp;</td>
              <td bgcolor="#5F5F5F" class="text_prompt_white_12">&nbsp;<? echo $rs_em[em_id] ;?></td>
              <td width="136" align="center" valign="top" bgcolor="#5F5F5F" class="textwB11">&nbsp;</td>
            </tr>
	        <tr>
	          <td bgcolor="#5F5F5F">&nbsp;</td>
              <td bgcolor="#5F5F5F">&nbsp;</td>
              <td width="136" bgcolor="#5F5F5F">&nbsp;</td>
            </tr>
	        <tr>
	          <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td width="136" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
					
<!-- BEGIN PROCESS LOOP -->


		      




<!-- BEGIN PROCESS LOOP -->
                   
                  </tbody>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td >
				
				
			  <div align="center">
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
			      <tbody>
			        <tr>
			          <td colspan="4"><table width="100%" height="800"  border="0" align="center" cellpadding="0" cellspacing="0">
			            <?
											  $sql_pro= "SELECT pro_code FROM  tsp_product  WHERE pro_id = '$pro_id'  ";
											  $pro_rs = mysql_query($sql_pro,$conn);
											  $rs_pro=mysql_fetch_array($pro_rs); 
										  
											$sql_gd = "SELECT * FROM  gd_artwork  WHERE  art_name='$rs_pro[pro_code]' ";
											$res_gd = mysql_query($sql_gd,$conn);
											$rs_gd=mysql_fetch_array($res_gd);

											$exd = explode(".", $rs_gd[art_pic]);
					  switch($rs[pro_category]=="11") { 
							  case"11"://FINISH GOOD
											
										    $pre_type2=strlen($rs_gd[art_pic]);
										    $ttype=substr($rs_gd[art_pic],$pre_type2 -3 ,3 );
							  break;
							  default;
							  
						// DICUT EQUIPMENT					
						if($rs[pro_category]=="12" && $rs[pro_subtype]=="5"){ 					  
		
											$sql_dicut_equip = "SELECT * FROM  gd_diecut  WHERE dicut_id = '$rs[pro_code]'";
											$con_dicut_equip = mysql_query($sql_dicut_equip,$conn);
											$rs_dicut_equip = mysql_fetch_array($con_dicut_equip);
							
										    $pre_type2=strlen($rs_dicut_equip[dicut_art]);
										    $ttype=substr($rs_dicut_equip[dicut_art],$pre_type2 -3 ,3 );
						} else {
						// OTHER 	
										    $pre_type2=strlen($rs[images]);
										    $ttype=substr($rs[images],$pre_type2 -3 ,3 );
						}
							  break;
							  
							  
					  }
											?>
					<? if($rs[pro_category]=="11" ||  $rs[pro_category]=="12") { ?>
			            <tr>
			              <td  colspan="9" align="center">					  
						<? if($ttype=='pdf'){ ?>
						 <? switch($rs[pro_category]){ 
	case "11": ?> 
                        <iframe width="100%" height="800"  src="../pdf_js/web/viewer.html?file=../../art_pic/<? echo iconv('TIS-620','UTF-8',$rs_gd[art_pic]);?>#toolbar=0&zoom=page-height"> </iframe>
	<?
	break;
	default:
	 ?>	
						 <? if($rs[pro_category]=="12" && $rs[pro_subtype]=="5"){ 						  
		
						$sql_dicut_equip = "SELECT * FROM  gd_diecut  WHERE dicut_id = '$rs[pro_code]'";
						$con_dicut_equip = mysql_query($sql_dicut_equip,$conn);
						$rs_dicut_equip = mysql_fetch_array($con_dicut_equip);
		 
		 
						  ?>
							  
                        <iframe width="100%" height="800"  src="../pdf_js/web/viewer.html?file=../../dicut_pic/<? echo $rs_dicut_equip[dicut_art];?>#toolbar=0&zoom=page-height"> </iframe>
							  
						 <? } else { ?>	
							  
                        <iframe width="100%" height="800"  src="../pdf_js/web/viewer.html?file=../../inventory2020/pro_images/<? echo $rs[images];?>#toolbar=0&zoom=page-height"> </iframe>  
							  
						 <? } ?>		  
<? 
		break;
} ?>
                        <?  }else{ if(!$sql_gd){?>						
                        <img src="../art_pic/<? echo $rs_gd[art_pic];?>" width="750" border="0">
						<?} else {?>
						<? if($rs[images]!=''){?>
						<img src="pro_images/<? echo $rs[images]?>"  width="750">
						<? }else{ ?>
						<img src="imgs/no_photo_color.jpg"  width="500">
						<? } ?></td>
                        <?	 }; }?>
						</td>
                    </tr>
			            <? } else { ?>
			            <? if(!empty($rs[images])){?>
			            <tr>
			              <td align="center" height="25" colspan="3"><img src="pro_images/<? echo $rs[images]?>"  width="350"></td>
			              </tr>
			            <? } else {?>
			            <tr>
			              <td align="center" height="25" colspan="3" class="thaitext_body"><img src="imgs/no_photo_color.jpg"  width="500"></td>
			              </tr>
			            <? } ?>
			            <? } ?>
					  
					  <? if($rs_pro[pro_category]=="11") { ?>
			            <tr>
			              <td height="75" colspan="3" align="right" class="thaitext_body">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                <tbody>
								<? if($rs_gd){?>
			                  <tr>
			                    <td align="center"><a href="../art_pic/<? echo $rs_gd[art_pic]?>" target="_blank" class="textbl10"><img src="../image_icon/fullview_icon.gif" width="170" height="40" alt=""/></a></td>
			                    </tr>
			              		<? } ?>
			                  </tbody>
			                </table></td>
			              </tr>
						      <? ; } ?>

<tr>	
			              <td height="25" colspan="3" class="thaitext_body">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
			                <tbody>
			            <tr>
			              <td height="25" colspan="3" class="thaitext_body">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
			                <tbody>
			                  <tr>
			                    <td>&nbsp;</td>
			                    <td>&nbsp;</td>
			                    <td>&nbsp;</td>
			                    </tr>
			                  <tr>
			                    <td width="10%">&nbsp;</td>
			                    <td>	
<!-- INFO ZONE -->
<? if($device_platform=='DESKTOP'){ ?>					  
<div style="display: flex;width: 100%; position: relative;flex-direction:row;">
<? }else{ ?>	
<div style="display: flex;width: 100%; position: relative;flex-direction:column;">
<? } ?>	
<div	 
<? if($show_info_side_zone){
	
if($device_platform=='DESKTOP'){echo 'style="display: flex; position: relative;width:50%;"';}else{echo 'style="display: flex; position: relative;width:100%;"';}
	
}else{
	
	echo 'style="display: flex; position: relative;width:100%;"';} ?>	 
	 >	
	
	<table width="100%" bordercolor="#0C51A0" border="1" cellspacing="0" cellpadding="0">
			                      <tbody>
			                        <tr><a name="list_info"></a>
			                          <td bgcolor="#0C51A0" class="text_prompt_white_22" align="center" height="35">
<div>
<? 
switch($rs[pro_category]){
					  case"12":
					  $topic_info="ข้อมูลอุปกรณ์";
					  $topic_txt1="รหัสอุปกรณ์";
					  $topic_txt2="รายการอุปกรณ์";
					  $topic_txt3="รายละเอียดอุปกรณ์";
					  break;
					  default:
					  $topic_info="ข้อมูลสินค้า";
					  $topic_txt1="รหัสสินค้า";
					  $topic_txt2="รายการสินค้า";
					  $topic_txt3="รายละเอียดสินค้า";
					  break;
				  }
				  echo $topic_info;
										  ?>
</div></td>
			                          </tr>
			                        <tr>
			                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			                            <tbody>
			                              <tr>
			                                <td width="30%">&nbsp;</td>
			                                <td>&nbsp;</td>
			                                </tr>
											<? if($rs[pro_category]!="11"){ ?>
			                              <tr>
			                                <td valign="top"><div align="right" class="text_prompt_blue_14"><strong><? echo $topic_txt1;?></strong></span><strong>&nbsp;</strong></div></td>
			                                <td valign="top"><div align="left"  class="text_prompt_black_14"><? echo html($rs[pro_code]);?></div></td>
			                                </tr>
											<?;}?>
			                              <tr>
			                                <td valign="top"><div align="right" class="text_prompt_blue_14"><strong><? echo $topic_txt2;?></strong></span><strong>&nbsp;</strong></div></td>
			                                <td valign="top"><div align="left"  class="text_prompt_black_14" style="padding:0 15px 0 0;"><? echo html($rs[pro_name]);?></div></td>
			                                </tr>
			                              <? if(!empty($rs[pro_detail])){ ?>
			                              <tr>
			                                <td valign="top"><div align="right" class="text_prompt_blue_14"><strong><? echo $topic_txt3;?>&nbsp;</strong></div></td>
			                                <td valign="top"><div align="left"  class="text_prompt_black_14"><? echo $rs[pro_detail];?></div></td>
			                                </tr>
			                              <?;}?>
			                              <? if($rs[pro_category]=="12"){ ?>
			                              <tr>
			                                <td valign="top"><div align="right" class="text_prompt_blue_14"><strong>หมายเหตุ  &nbsp;</strong></div></td>
			                                <td valign="top"><div align="left"  class="text_prompt_black_14"><? echo html($rs[pro_detail2]);?></div></td>
			                                </tr>
			                              <?;}?>
			                              <? switch($rs[pro_category]){
	case "10":
?>
			                              <?
													switch($rs_accessibility_chk[view_mt_price]){
														case "1":
													?>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ราคาต่อหน่วย  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo number_format($rs[pro_price],2,'.',',')." บาท";?></div></td>
			                                </tr>
			                              <?
														break;
														default:
													}
													?>
			                              <? break;
	case "11":
	?>
			                              <?
													switch($rs_accessibility_chk[view_fg_price]){
														case "1":
													?>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ราคาต่อหน่วย  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo number_format($rs[pro_price],4,'.',',')." บาท";?></div></td>
			                                </tr>
			                              <?
														break;
														default:
														break;
													}
													?>
			                              <?
    break;
	default:
	break;
}
?>
			                              <? if(!empty($rs[min_quantity])){ ?>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>จำนวนขั้นต่ำ  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? if(strpos($rs[min_quantity],".")!= false){echo number_format($rs[min_quantity],2,".",",")." ".$rs[pro_unit];} else {echo number_format($rs[min_quantity],0,".",",")." ".$rs[pro_unit];}?></div></td>
			                                </tr>
			                              <? ;} ?>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ตำแหน่งจัดเก็บ  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? if($rs[pro_block_positions]!=''){ echo $rs[pro_block_positions];}else{echo '-';}?></div></td>
			                                </tr>
	<? if($rs[pro_category]=="12"){ ?>	
			                              <tr>
			                                <td bgcolor="#FFFFFF"><div align="right" class="text_prompt_blue_14"></div></td>
			                                <td bgcolor="#FFFFFF"><div align="left"  class="text_prompt_white_16">&nbsp;</div></td>
			                                </tr>	
			                              <tr>
			                                <td bgcolor="#0C51A0" colspan="2"><div align="center"  class="text_prompt_white_16"><? echo "Specification Equipment";?></div></td>
			                                </tr>
			                              <tr>
			                                <td bgcolor="#FFFFFF"><div align="right" class="text_prompt_blue_14"></div></td>
			                                <td bgcolor="#FFFFFF"><div align="left"  class="text_prompt_white_16">&nbsp;</div></td>
			                                </tr>
									  <? switch($rs[pro_subtype]){
	case "3":
				$sql_polymer_equip = "
SELECT

gd_plate_polymer_item.pro_id as pro_id,
gd_plate_polymer_item.equip_edition as epuip_edition,
gd_plate_polymer_item.plate_color as plate_color,
gd_plate_polymer_item.plate_ratio as plate_ratio,
asp_machine.machine_id as machine_id

FROM
gd_plate_polymer_item

LEFT JOIN asp_machine ON gd_plate_polymer_item.plate_machine=asp_machine.machine_abbreviation
				
WHERE gd_plate_polymer_item.pro_id='".$rs[pro_id]."'

LIMIT 1";
$con_polymer_equip = mysql_query($sql_polymer_equip,$conn);
$rs_polymer_equip = mysql_fetch_array($con_polymer_equip);  
								?>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ประเภทอุปกรณ์  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo "เพลทโพลีเมอร์";?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>เครื่องพิมพ์  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $rs_polymer_equip[machine_id];?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ครั้งที่  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $rs_polymer_equip[epuip_edition];?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ระยะย่อ  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $rs_polymer_equip[plate_ratio].'%';?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>สี  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $rs_polymer_equip[plate_color];?></div></td>
			                              </tr>
									  <? 
		
		break;
		
				
	case "5":							

				$sql_dicut_equip = "SELECT * FROM  gd_diecut  WHERE dicut_id = '".trim($rs[pro_code])."'";
				$con_dicut_equip = mysql_query($sql_dicut_equip,$conn);
				$rs_dicut_equip = mysql_fetch_array($con_dicut_equip);
				
if(empty($rs_dicut_equip[dicut_length])){ $size_txt=$rs_dicut_equip[dicut_width];}else{ $size_txt=$rs_dicut_equip[dicut_width].' x '.$rs_dicut_equip[dicut_length];}
if(empty($size_txt)){$size_txt="-";}else{$size_txt=$size_txt.' mm.';}
if(empty($rs_dicut_equip[dicut_type])){$type_txt="-";}else{$type_txt=$rs_dicut_equip[dicut_type];}
if(empty($rs_dicut_equip[dicut_r])){$r_txt="-";}else{$r_txt=$rs_dicut_equip[dicut_r].' mm.';}
if(empty($rs_dicut_equip[dicut_v_gap])){$v_gap_txt="-";}else{$v_gap_txt=$rs_dicut_equip[dicut_v_gap].' mm.';}
if(empty($rs_dicut_equip[dicut_h_gap])){$h_gap_txt="-";}else{$h_gap_txt=$rs_dicut_equip[dicut_h_gap].' mm.';}
if(empty($rs_dicut_equip[dicut_layout])){$layout_txt="-";}else{$layout_txt=$rs_dicut_equip[dicut_layout];}
		
									  ?>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ประเภทอุปกรณ์  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo "บล็อกไดคัท";?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>รูปแบบไดคัท  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $rs_dicut_equip[dicut_type];?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ขนาด  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $size_txt;?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>มุมมน  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $r_txt;?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ระยะระหว่างดวง V Gap  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $v_gap_txt;?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>ระยะระหว่างแถว H Gap  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $h_gap_txt;?></div></td>
			                              </tr>
			                              <tr>
			                                <td><div align="right" class="text_prompt_blue_14"><strong>เลย์เอาท์  &nbsp;</strong></div></td>
			                                <td><div align="left"  class="text_prompt_black_14"><? echo $layout_txt;?></div></td>
			                              </tr>
									  <? 
		break;
	default:
		break;
} 
									  ?>
	<? } ?>								  
			                              <? if($rs_accessibility_chk[edit_info_pro]=='1'){	?>
												<? if($rs[pro_category]!="12"){	?>
			                              <tr>
			                                <td height="35"></td>
			                                <td><div align="right"><a href="edit_product.php?&pro_id=<? echo $rs[pro_id]?>&form_link=detail_product" ><img src="../image_icon/EDIT-icon-2.png" width="32" height="32" border="0"></a>&nbsp;</div></td>
			                                </tr>
												<? ;} ?>
			                              <tr>
			                                <td height="45">&nbsp;</td>
			                                <td>&nbsp;</td>
			                                </tr>
			                              <? } else { ?>
			                              <tr>
			                                <td height="45">&nbsp;</td>
			                                <td>&nbsp;</td>
			                                </tr>
			                              <? } ?>
			                              </tbody>
			                            </table>	
</td>
			                          </tr>
			                        </tbody>
			                      </table>
	</div>
					  
	<? if($show_info_side_zone){ ?>	
<? if($device_platform=='DESKTOP'){	?>		  
	<div style="display: flex;width:50%; position: relative;border:none;padding:0 0 5px 10px;flex-direction: column;">
<? }else{ ?>
	<div style="display: flex;width:100%; position: relative;border:none;padding:25px 10px 0 0;flex-direction: column;">	
<? } ?>	
		
	<!-- job order used FOR Materail -->	
<? if($rs[pro_category]=='10'|| $rs[pro_category]=='11'){?>
<!-- array set -->
<?
$materail_job_chk_job_order=array();
$materail_job_chk_qty=array();	
$materail_job_chk_remark=array();							
?>	
<!-- array set -->	
<?				
$sql_materail_job_chk = "
SELECT 

plan_job_order.order_no AS order_no

FROM plan_job_order 

LEFT JOIN new_po ON plan_job_order.order_no=new_po.order_no

WHERE 
(plan_job_order.mt_id1='".$rs[pro_id]."'
OR plan_job_order.mt_id2='".$rs[pro_id]."' 
OR plan_job_order.mt_id3='".$rs[pro_id]."'
OR plan_job_order.mt_id4='".$rs[pro_id]."'
OR plan_job_order.mt_id5='".$rs[pro_id]."'
OR plan_job_order.mt_id6='".$rs[pro_id]."'
OR plan_job_order.mt_id7='".$rs[pro_id]."'
OR plan_job_order.mt_id8='".$rs[pro_id]."'
OR plan_job_order.mt_id9='".$rs[pro_id]."'
OR plan_job_order.mt_id10='".$rs[pro_id]."')
AND plan_job_order.plan_status2='1'
AND plan_job_order.create_date > '2023-01-01 00:00:00'
AND new_po.so_finish_status!='1'
ORDER BY plan_job_order.id ASC ";
$con_materail_job_chk = mysql_query($sql_materail_job_chk,$conn);
								
while($rs_materail_job_chk = mysql_fetch_array($con_materail_job_chk)){
	
	$sql_materail_out_chk = " SELECT * FROM tsp_product_io WHERE io_type='OUT' AND pro_id='".$rs[pro_id]."' AND order_no='".$rs_materail_job_chk[order_no]."' LIMIT 1 ";
	$con_materail_out_chk = mysql_query($sql_materail_out_chk,$conn);								
	$rs_materail_out_chk = mysql_fetch_array($con_materail_out_chk);
	
		if(!$rs_materail_out_chk){

				for($_ij=1;$_ij<='10';$_ij++){
				$sql_materail_pro_id = "
				SELECT 
				order_no,
				mt_id_amount".$_ij." AS mt_id_amount,
				mt_remark".$_ij." AS mt_remark
				FROM plan_job_order 
				WHERE 
				mt_id".$_ij."='".$rs[pro_id]."'
				AND order_no='".$rs_materail_job_chk[order_no]."'
				AND mt_id".$_ij."!=''
				LIMIT 1 ";
				$con_materail_pro_id = mysql_query($sql_materail_pro_id,$conn);								
				$rs_materail_pro_id = mysql_fetch_array($con_materail_pro_id);

							if($rs_materail_pro_id){	
							$materail_job_chk_job_order[]=$rs_materail_pro_id[order_no];
							$materail_job_chk_qty[]=$rs_materail_pro_id[mt_id_amount];	
							$materail_job_chk_remark[]=$rs_materail_pro_id[mt_remark];	
							}		
				}
			
		}

}
								
?>								
		<? /* if(false){ */?>
	<div style="display: flex;position: relative;width: 100%;border:2px solid #0C51A0;flex-direction: column; align-content: flex-start;margin:0 0 15px 0;">
			
	<div style="display: flex;position: relative;width: 100%;height: auto; text-align: center;align-content: center;flex-direction: column;font-size:16pt;background: #0C51A0;color:white;padding : 0 0 5px 0;">รายการใบสั่งงาน รอการเบิก
	</div>
			
	<div style="display: flex;position: relative;width: 100%;text-align: center;align-content: center;flex-direction: column;font-size:8pt;color:black;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="middle" width="25%" align="left" bgcolor="#D3D3D3"  class="" style="padding : 5px 5px 5px 15px;">ใบสั่งงาน</td>
		<td valign="middle" width="50%" align="left" bgcolor="#D3D3D3" class="">ชื่องาน</td>
		<td valign="middle" width="25%" align="right" bgcolor="#D3D3D3" class="" style="padding : 5px 15px 5px 5px;">จำนวนเบิกตามใบสั่งงาน</td>
	</tr> 
		
<?
/* CONSTANT */
	
$materail_job_chk_qty_all='0';
$nett_stock='0';
	
/* CONSTANT */
	
$sqlz = "SELECT  sum(in_amount) AS pro_amonut FROM tsp_product_in  WHERE pro_id ='$rs[pro_id]'";
$rsz = mysql_query($sqlz);
$resultz=mysql_fetch_array($rsz);
$inn_stock=$resultz[pro_amonut];

$sqly = "SELECT  sum(out_amount) AS pro_amonut2 FROM tsp_product_out  WHERE pro_id ='$rs[pro_id]'";
$rsy = mysql_query($sqly);
$resulty=mysql_fetch_array($rsy);
$outt_stock=$resulty[pro_amonut2];

$nett_stock=$inn_stock-$outt_stock;
	
	

for($ij=0;$ij < count($materail_job_chk_job_order);$ij++){
					
					if(($ij%2)!=0){ $bg_col="#FBFFE0"; }else{  $bg_col="#FFFFFF";}
?>			
	<tr <? echo 'style="background:'.$bg_col.';"' ?>>
		<td valign="top" align="left" style="padding:5px 5px 5px 15px;">
			<? echo $materail_job_chk_job_order[$ij];?>
		</td>
		<td valign="top" align="left" style="padding:5px 5px 5px 0;">
		<? 
	$sql_materail_order_no = "
				SELECT 
				name_product1
				FROM new_po 
				WHERE 
				order_no='".$materail_job_chk_job_order[$ij]."'
				LIMIT 1 ";
				$con_materail_order_no = mysql_query($sql_materail_order_no,$conn);								
				$rs_materail_order_no = mysql_fetch_array($con_materail_order_no);
	
	echo trim($rs_materail_order_no[name_product1]).' '.trim($materail_job_chk_remark[$ij]);
			?>
		</td>
		<td valign="top" align="right" style="padding : 5px 15px 5px 5px;">
			<? 
		if($materail_job_chk_qty[$ij]!=''){			
			if(strpos($materail_job_chk_qty[$ij],".")){
			echo number_format($materail_job_chk_qty[$ij],'2','.',',');
			}else{
			echo number_format($materail_job_chk_qty[$ij],'0','.',',');
			}
			echo ' '.$rs[pro_unit];
			$materail_job_chk_qty_all=$materail_job_chk_qty_all+$materail_job_chk_qty[$ij];
		}else{echo '-';}
			?>
		</td>
	</tr>	
<?   } ?>
		
	<? if(count($materail_job_chk_job_order)>'0'){?>	
	<tr>
		<td valign="middle" colspan="3" align="left" bgcolor="#FFFFFF"  class="" style="padding : 0px 10px 2px 10px;">
		 <div style="display: flex;position: relative;width: 100%;height: 3px;background:rgba(0,0,0,0.1);border-radius: 1.5px;"></div>
		</td>
	</tr>
	<? } ?>	
		
		<?
		if($materail_job_chk_qty_all > $nett_stock){$txt_amount_all_color="color:darkred;";}else{$txt_amount_all_color="color:black;";}
		?>
	<tr>
		<td valign="middle" align="left" class="" style="padding : 5px 5px 5px 15px;"></td>
		<td valign="middle" align="right" class="" style="font-size:14pt;<? echo $txt_amount_all_color;?>">จำนวนทั้งหมด</td>
		<td valign="middle" align="right" style="font-size:14pt;padding : 5px 15px 5px 5px;<? echo $txt_amount_all_color;?>">
			<? 
			if(strpos($materail_job_chk_qty_all,".")){
			echo number_format($materail_job_chk_qty_all,'2','.',',');
			}else{
			echo number_format($materail_job_chk_qty_all,'0','.',',');
			}
			echo ' '.$rs[pro_unit];
			?>
		</td>
	</tr>	
		
			</table>	
			</div>	
		
	</div>
	<? } ?>	
	<!-- job order used FOR Materail -->	
		
	<!-- PO Order FOR equip -->	
		<? if($rs_po_order_chk){?>
		<? /* if(false){ */?>
	<div style="display: flex;position: relative;width: 100%;border:2px solid #0C51A0;flex-direction: column; align-content: flex-start;margin:0 0 15px 0;">
			
	<div style="display: flex;position: relative;width: 100%;height: auto; text-align: center;align-content: center;flex-direction: column;font-size:16pt;background: #0C51A0;color:white;padding : 0 0 5px 0;">รายการใบสั่งซื้อ
	</div>
			
	<div style="display: flex;position: relative;width: 100%;text-align: center;align-content: center;flex-direction: column;font-size:8pt;color:black;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="middle" width="10%" height="22" align="center" bgcolor="#D3D3D3"  class="">วันที่</td>
		<td valign="middle" width="10%" align="left" bgcolor="#D3D3D3"  class="" style="padding : 0 0 0 5px;">ใบสั่งซื้อ</td>
		<td valign="middle" width="40%" align="left" bgcolor="#D3D3D3" class="">ใบสั่งงาน</td>
		<td valign="middle" width="30%" align="left" bgcolor="#D3D3D3" class="">ซัพพลายเออร์</td>
		<td valign="middle" width="10%" align="left" bgcolor="#D3D3D3" class="" style="padding : 5px;">วันที่รับเข้า</td>
	</tr>
				
<?
/* CONSTANT */
$ij=1;
if($rs_disposal_require_chk){
$list_of_equip_po_order='10';
}else{
$list_of_equip_po_order='20';	
}
/* CONSTANT */
	
		$sql_po_order = $sql_equip_po_order;
		$con_equip_po_order = mysql_query($sql_po_order,$conn);
		$num_equip_po_order = mysql_num_rows($con_equip_po_order)	;
	
	
if($num_equip_po_order > $list_of_equip_po_order){
$sql_po_order = $sql_equip_po_order." LIMIT ".($num_equip_po_order-$list_of_equip_po_order).",".$list_of_equip_po_order;	
}else{
$sql_po_order = $sql_equip_po_order;	
}
		$con_equip_po_order = mysql_query($sql_po_order,$conn);	
	
		while($rs_equip_po_order = mysql_fetch_array($con_equip_po_order) ){
					
					if(($ij%2)==0){ $bg_col="#FBFFE0"; }else{  $bg_col="#FFFFFF";}
?>			
	<tr <? echo 'style="background:'.$bg_col.';"' ?>>
		<td valign="top" align="left" style="padding:5px;">
			<? echo date('d/m/',strtotime($rs_equip_po_order[po_date])).(date('Y',strtotime($rs_equip_po_order[po_date]))+543);?>
			<?/* echo date('d/m/y',strtotime($rs_equip_po_order[po_date]));*/?>
		</td>
		<td valign="top" align="left" style="padding : 5px 0 5px 5px;">
		<? echo $rs_equip_po_order[po_id];?>
		</td>
		<td valign="top" align="left" style="padding : 5px 10px 5px 0;">
			<? 
		if($rs_equip_po_order[order_no]!=''){echo $rs_equip_po_order[order_no];}else{echo '-';}
			?>
		</td>	
		<td valign="top" align="left" style="padding : 5px 10px 5px 0;">		
			<? echo $rs_equip_po_order[supplier_name];?>
		</td>	
		<td valign="top" align="left" style="padding : 5px;">
			<? if($rs_equip_po_order[in_date]!='0000-00-00 00:00:00'){
						echo date('d/m/',strtotime($rs_equip_po_order[in_date])).(date('Y',strtotime($rs_equip_po_order[in_date]))+543);
					}else{
						echo '-';}?>
		</td>
	</tr>	
<? $ij++; } ?>				
			</table>	
			</div>	
		
	</div>
	<? } ?>	
	<!-- PO Order FOR equip -->		
		
	
	<!-- REQUIRE DISPOSAL EQUIP -->	
		<? if($rs_disposal_require_chk){?>
	<div style="display: flex;position: relative;width: 100%;height: 100%; border:2px solid #0C51A0;flex-direction: column; align-content: flex-start;">
			
	<div style="display: flex;position: relative;width: 100%;height: auto; text-align: center;align-content: center;flex-direction: column;font-size:16pt;background: #0C51A0;color:white;padding : 0 0 5px 0;">รายการขอแก้ไขอุปกรณ์
	</div>
			
	<div style="display: flex;position: relative;width: 100%;text-align: center;align-content: center;flex-direction: column;font-size:8pt;color:black;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="middle" width="10%" height="22" align="center" bgcolor="#D3D3D3"  class="">วันที่</td>
		<td valign="middle" width="25%" align="left" bgcolor="#D3D3D3"  class="" style="padding : 0 0 0 5px;">ใบสั่งงาน</td>
		<td valign="middle" width="37%" align="left" bgcolor="#D3D3D3" class="">รายละเอียด</td>
		<td valign="middle" width="20%" align="left" bgcolor="#D3D3D3" class="">ผู้ขอแก้ไข</td>
		<td valign="middle" width="8%" align="center" bgcolor="#D3D3D3" class="">ดำเนินการ</td>
	</tr>
				
<?
/* CONSTANT */
$ij=1;
if($rs_po_order_chk){	
$list_of_equip_disposal_require='10';
}else{
$list_of_equip_disposal_require='20';	
}
/* CONSTANT */
								
$sql_equip_disposal_require = $sql_disposal_require_main;
$con_equip_disposal_require = mysql_query($sql_equip_disposal_require);
$num_equip_disposal_require = mysql_num_rows($con_equip_disposal_require)	;
								

if($num_equip_disposal_require>$list_of_equip_disposal_require){
$sql_equip_disposal_require= $sql_disposal_require_main." LIMIT ".($num_equip_disposal_require-$list_of_equip_disposal_require).",".$list_of_equip_disposal_require;	
}else{
$sql_equip_disposal_require= $sql_disposal_require_main;	
}								
$con_equip_disposal_require= mysql_query($sql_equip_disposal_require);
while($rs_equip_disposal_require = mysql_fetch_array($con_equip_disposal_require) ){
					
					if(($ij%2)==0){ $bg_col="#FBFFE0"; }else{  $bg_col="#FFFFFF";}
?>			
	<tr <? echo 'style="background:'.$bg_col.';"' ?>>
		<td valign="top" align="center" style="padding:5px 0 5px 0;"><? echo date('d/m/',strtotime($rs_equip_disposal_require[disposal_require_date])).(date('Y',strtotime($rs_equip_disposal_require[disposal_require_date]))+543);?></td>
		<td valign="top" align="left" style="padding : 5px 0 5px 5px;">
			<? echo $rs_equip_disposal_require[order_no];?>
		</td>
		<td valign="top" align="left" style="padding : 5px 10px 5px 0;"><? echo $rs_equip_disposal_require[equip_disposal_require_desc];?></td>	
		<td valign="top" align="left" style="padding : 5px 10px 5px 0;"><? echo $rs_equip_disposal_require[disposal_require_by];?></td>	
		<td valign="top" align="center" style="padding : 5px 0 5px 0;"><? if($rs_equip_disposal_require[equip_disposal_id]==''){echo 'รอดำเนินการ';}else{echo '<i class="fa fa-check" aria-hidden="true" style="font-size:10pt;color:green;"></i>';}?></td>
	</tr>	
<? $ij++; } ?>				
			</table>	
			</div>	
		<? } ?>
	<!-- REQUIRE DISPOSAL EQUIP -->		
			
			
		</div>	
	</div>
	<? } ?>	
					  
	</div>
			                    <td width="10%">&nbsp;</td>
			                    </tr>							
			                  <tr>
			                    <td>&nbsp;</td>
			                    <td>&nbsp;</td>
			                    <td>&nbsp;</td>
	                    </tr>
			                  <tr>
			                    <td>&nbsp;</td>
			                    <td align="center"><?
									
										$sqlz = "SELECT  sum(in_amount) AS pro_amonut FROM tsp_product_in  WHERE pro_id ='$rs[pro_id]'";
										$rsz = mysql_query($sqlz);
										$resultz=mysql_fetch_array($rsz);
										$inn=$resultz[pro_amonut];
									
										$sqly = "SELECT  sum(out_amount) AS pro_amonut2 FROM tsp_product_out  WHERE pro_id ='$rs[pro_id]'";
										$rsy = mysql_query($sqly);
										$resulty=mysql_fetch_array($rsy);
										$outt=$resulty[pro_amonut2];
	
											$nett=$inn-$outt;
					
									if(!empty($rs[min_quantity])){
										if($nett<=$rs[min_quantity]){$border_col="#E94251";}else{$border_col="#54B466";}										
									
									} else {$border_col="#54B466";}
								  
								  ?>
			                      <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="<? echo $border_col ;?>">
			                        <tbody>
			                          <tr>
			                            <td height="35" bgcolor="<? echo $border_col ;?>" align="center" class="text_prompt_white_22">
											<? echo 'ยอดคงเหลือ';?>	
										  </td>
			                            </tr>
			                          <tr>
			                            <td  height="60" bgcolor="#FBF3D1" align="center" class="text_prompt_black_35"><?
								if (strpos($nett,".")!= false) { echo number_format($nett,2,".",",")." ".$rs[pro_unit];} else { echo number_format($nett,0,".",",")." ".$rs[pro_unit];}
											  ?>
								<?			  
								if($materail_job_chk_qty_all>$nett){
								?>
								<div style=" padding:0px;margin:0px;color:darkred;font-size: 12pt;font-style: italic;">			  
									<? 
									echo '( ยอดคงเหลือต่ำกว่า จำนวนรอการเบิก ';
									if (strpos($materail_job_chk_qty_all-$nett,".")!= false){
									echo number_format(($materail_job_chk_qty_all-$nett),'2','.',',');
									}else{
									echo number_format(($materail_job_chk_qty_all-$nett),'0','.',',');
									}
									echo " ".$rs[pro_unit].' )';?>
								</div>	
								<?
								}		  
								?></td>
			                            </tr>
			                          </tbody>
			                        </table></td>
			                    <td>&nbsp;</td>
			                    </tr>
			                  </tbody>
			                </table></td>
			              </tr>	            <tr>
			              <td height="25" colspan="3" class="thaitext_body">&nbsp;</td>
			              </tr>  
</div>		<!-- INFO ZONE -->	
			                  </tbody>
			                </table></td>
			              </tr>
			            <tr>
			              <td height="25" colspan="3" align="center" class="thaitext_body"><table width="95%" border="0" cellspacing="0" cellpadding="0">
			                <tbody>
			                  <tr >
			                    <td height="5" colspan="7" align="center" ></td>
			                    </tr>
			                  <tr>
			                    <td valign="middle" width="15%" height="25" align="center" bgcolor="#D3D3D3"  class="text_prompt_black_12">วันที่</td>
			                    <td valign="middle" width="10%" align="center" bgcolor="#D3D3D3"  class="text_prompt_black_12">&nbsp;&nbsp;เลขที่เอกสาร</td>
			                    <td valign="middle" width="15%" align="center" bgcolor="#D3D3D3" class="text_prompt_black_12">เบิก</td>
			                    <td valign="middle" width="15%" align="center" bgcolor="#D3D3D3" class="text_prompt_black_12">รับเข้า</td>
							<? if($rs[pro_category]=="12"){?>
                            <td valign="middle" width="15%" align="center" bgcolor="#0C51A0" class="text_prompt_white_12">จำนวนผลิต(impression)</td>
							<? } ?>
			                    <td valign="middle" width="20%" align="left" bgcolor="#D3D3D3" class="text_prompt_black_12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้เบิก-รับ</td>
			                    <td valign="middle" width="21%" align="left" bgcolor="#D3D3D3" class="text_prompt_black_12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเหตุ</td>
			                    <td width="5%" align="center" bgcolor="#D3D3D3">&nbsp;</td>
			                  </tr>
			                  <? 

$equip_disposal_impression_total='0';
								
					$stock_date=date("Y-m-d");
					switch($rs[pro_category]){
						case"12":
					$start_date=date("Y-m-d", strtotime("-24 Month"));
						break;
						default:
					$start_date=date("Y-m-d", strtotime("-6 Month"));
						break;
					}
					$ij=1;
					
					$sql_material_name= "SELECT * FROM  tsp_product WHERE pro_id= '$pro_id'";
					$con_material_name = mysql_query($sql_material_name);
					$rs_material_name  = mysql_fetch_array($con_material_name);
							  
					$sql_warehouse_io = "SELECT * FROM tsp_product_io  WHERE pro_id='$pro_id' and io_date>='$start_date' order by io_date ASC ,create_date ASC ";					
					$res_warehouse_io = mysql_query($sql_warehouse_io,$conn);					
					$rs_warehouse_io=mysql_fetch_array($res_warehouse_io); 
					
					if($rs_warehouse_io){		  
					$sql_warehouse_io = "SELECT * FROM tsp_product_io  WHERE pro_id='$pro_id' and io_date>='$start_date' order by io_date ASC ,create_date ASC";	
					}else{
					$sql_warehouse_io = "SELECT * FROM tsp_product_io  WHERE pro_id='$pro_id' order by io_date ASC ,create_date ASC LIMIT 0,10";	
					}	
					$res_warehouse_io = mysql_query($sql_warehouse_io,$conn);					
					while($rs_warehouse_io=mysql_fetch_array($res_warehouse_io)){ 
					
					if(($ij%2)==0){ $bg_col="#FBFFE0"; }else{  $bg_col="#FFFFFF";}
					
			
			$sql_warehouse_out= "SELECT * FROM  tsp_product_out WHERE out_id= '$rs_warehouse_io[io_id]' ";
			$con_warehouse_out= mysql_query($sql_warehouse_out);
			$rs_warehouse_out = mysql_fetch_array($con_warehouse_out) ;
			
			if (!empty($rs_warehouse_out)){$io_emp=$rs_warehouse_out[out_by];} else {$io_emp=$rs_warehouse_io[create_by];}
			
					$sql_em= "SELECT * FROM  employees_new  WHERE em_id = '$io_emp'  ";
					$employee = mysql_query($sql_em,$conn);
					$rs_em=mysql_fetch_array($employee);
					?>
			                  <tr <? if($rs_warehouse_io[io_no_ref]=="Equipment-disposal"){echo "style='background:rgba(255,0,0,0.2)';";}else{echo "style='background:".$bg_col."';";} ?>>
			                    <td align="left"  height="30"  class="text_prompt_black_12">&nbsp;&nbsp;&nbsp;<? if(!empty($rs_warehouse_io[io_date])){ echo   nar_date2 ($rs_warehouse_io[io_date])." ".date('H:i',strtotime($rs_warehouse_io[create_date]));} else { echo "-";} ?></td>
								  
			                    <td align="left"    class="text_prompt_black_12">
									<? 
						if(!empty($rs_warehouse_io[order_no])){
							
							echo  $rs_warehouse_io[order_no];
							
if($rs_accessibility_chk[super_admin]=="1" && $rs_warehouse_io[plan_process_id]!='' && $rs_warehouse_io[io_type]=="OUT"){
	
$sql_job_order_key = " SELECT order_id FROM new_po  WHERE order_no='".trim($rs_warehouse_io[order_no])."' ORDER BY order_id DESC LIMIT 1";					
$con_job_order_key = mysql_query($sql_job_order_key,$conn);					
$rs_job_order_key  = mysql_fetch_array($con_job_order_key);
	
?>	
	<div style='
	background:rgba(0,0,0,0.5);
	font-size:9pt;
	color:white;
	border:none;
	border-radius: 3px;
	align-content: center;
	margin: 0 0 5px 0;
	padding: 2px 10px 2px 10px;
	cursor:pointer;'
	onclick="javascript:window.open('../planner_process/mpdf/detail_mobile_job_order.php?job_pass_key=<? echo encode($rs_job_order_key[order_id]);?>#process<? echo $rs_warehouse_io[plan_process_id];?>','_new');"
		 >
		<? echo "Plan process ID : ".$rs_warehouse_io[plan_process_id]; ?>
	</div>	
<? }
							
							} else{
							if($rs[pro_category]!="12"){
							echo  $rs_warehouse_io[io_no];
							} else {
							echo '-';	
							}
							}
									?>
								  </td>
			                    <td align="center"    class="text_prompt_red_12"><? if($rs_warehouse_io[io_type]=="OUT"){if (strpos($rs_warehouse_io[io_amount],".")!= false){echo number_format($rs_warehouse_io[io_amount],2,'.',',')." ".$rs_material_name[pro_unit];} else {echo number_format($rs_warehouse_io[io_amount],0,'.',',')." ".$rs_material_name[pro_unit];}} else {echo "-";} ?>&nbsp;&nbsp;&nbsp;</td>
			                    <td align="center"   class="text_prompt_blue_12"><? if($rs_warehouse_io[io_type]=="IN"){if (strpos($rs_warehouse_io[io_amount],".")!= false){echo number_format($rs_warehouse_io[io_amount],2,'.',',')." ".$rs_material_name[pro_unit];} else {echo number_format($rs_warehouse_io[io_amount],0,'.',',')." ".$rs_material_name[pro_unit];}} else {echo "-";} ?>&nbsp;&nbsp;&nbsp;</td>
							  
							<? if($rs[pro_category]=="12"){	

/* Cal sum_plan_amount_qty*/
	
$sql_plan_process_amount_chk=" SELECT * FROM plan_job_order_process_amount_value WHERE plan_job_process_id='$rs_warehouse_io[plan_process_id]' LIMIT 1 ";
$con_plan_process_amount_chk= mysql_query($sql_plan_process_amount_chk);
$rs_plan_process_amount_chk = mysql_fetch_array($con_plan_process_amount_chk);
	
$sum_plan_amount_qty=$rs_plan_process_amount_chk[plan_job_process_amount_value];
	
if($rs_plan_process_amount_chk[plan_job_process_amount_unit]!=''){$amount_unit=$rs_plan_process_amount_chk[plan_job_process_amount_unit];}	
	
/* Cal sum_plan_amount_qty*/
							?>
<td align="right" style="padding:0 10px 0 0;"
	<? if($rs_warehouse_io[io_no_ref]=="Equipment-disposal"){echo "style='background:rgba(255,0,0,0.2)';";}else{echo "style='background:#CCF7FC';";} ?> class="text_prompt_black_12">
	
	<? if($rs_warehouse_io[io_type]=="OUT" && $rs_warehouse_io[io_no_ref]!='Equipment-disposal'){ 
								
								$equip_disposal_impression_total=$equip_disposal_impression_total+$sum_plan_amount_qty;
								
								if($sum_plan_amount_qty !="0" && !empty($sum_plan_amount_qty)){echo number_format($sum_plan_amount_qty,'0','.',',').' '.$amount_unit;}else{echo "-";}
								
							;} else {
								if($rs_warehouse_io[io_no_ref]=='Equipment-disposal' && $equip_disposal_impression_total > '0'){
								echo "<span style='font-size:14px;color:darkred;font-weight:bold;'>".'ยอดผลิตสะสม &nbsp;'.number_format($equip_disposal_impression_total,'0','.',',').' '.$amount_unit.'</span>';	$equip_disposal_impression_total='0';								
								}else{
								echo '-';
								;}
								;}?>
	<? } /* if($ID=='ASP0004'){var_dump($sql_equip_amount);} */ ?></td>
								  
			                    
		<? if($rs_warehouse_io[io_no_ref]!="Equipment-disposal") {?>
			<td align="left"   class="text_prompt_black_12">&nbsp;&nbsp;&nbsp;
			<? echo $rs_em[em_name];?>
			</td>
			<td align="left"   class="text_prompt_black_12">
			<? echo $rs_warehouse_io[in_remark]?>
			</td>
			<? }else{ ?>
			<td align="left"  colspan='2'  class="text_prompt_black_12" style="padding:0 10px 0 20px;">
			<? echo "<span style='color:darkred;font-weight:bold;'>".$rs_warehouse_io[in_remark]."</span>";	
			if(true){
				$sql_disposal_remark=" SELECT * FROM gd_equip_disposal WHERE equip_disposal_id='$rs_warehouse_io[equip_disposal_id]' LIMIT 1 ";
				$con_disposal_remark= mysql_query($sql_disposal_remark,$conn);
				$rs_disposal_remark= mysql_fetch_array($con_disposal_remark);
			echo "<span style='color:black;font-size:8pt;'>";
				
			
			echo '<br>';
				if($rs_disposal_remark[equip_disposal_type]=="2"){
			echo "&nbsp;&#9679;&nbsp;อุปกรณ์มีการแก้ไข ";
				}else{
				if($rs_disposal_remark[equip_disposal_remark]!=''){echo '&nbsp;&#9679;&nbsp;';}
				}
				if($rs_disposal_remark[equip_disposal_remark]!=''){
			echo $rs_disposal_remark[equip_disposal_remark];
				}
			echo "</span>";
			}
			?>									
			</td>
			<?	;} ?>
			                    <td align="center"   class="text_prompt_black_12" style="padding : 0 10px 0 0 ;">
						<? if($rs_accessibility_chk[super_admin]=="1"){ ?>		  
                        <a href="../../inventory2020/del_stock_action.php?form_link=plan_process&sid=<? echo $ID ;?>&ticket_action=stock&stock_action_id=<? echo $rs_warehouse_io[io_id]; ?>" onclick="if (confirm('ยืนยันการลบข้อมูล')) {return true;} else {return false;}" class="textbl10"> <img src="../../image_icon/delete_32x32_icon.gif" width="24" height="24" alt=""/></a>
						<? } ?>			
								  </td>
			                    </tr>
			                  <?;$ij++;}?>
                          <tr class="textb12">
							  <? if($rs[pro_category]=="12"){?>
                            <td height="5" bgcolor="#D3D3D3"  colspan="4" align="center" ></td>
                            <td height="5" bgcolor="#0C51A0" align="center" ></td>
							  <? } else { ?>
                            <td height="5" bgcolor="#D3D3D3"  colspan="5" align="center" ></td>
							  <? } ?>
                            <td height="5" bgcolor="#D3D3D3"  colspan="3" align="center" ></td>
                          </tr>
                          <tr class="textb12">
							  <? if($rs[pro_category]=="12"){?>
                            <td height="5" bgcolor="#FFFFFF"  colspan="4" align="center" ></td>
                            <td height="5" bgcolor="#FFFFFF" align="right" style="font-family: 'Prompt', sans-serif;font-size:14px;color:black;font-weight:bold;padding:0 10px 0 0; ">
							  <?
								if($equip_disposal_impression_total > '0'){
								echo 'TOTAL : &nbsp;'.number_format($equip_disposal_impression_total,'0','.',',').' '.$amount_unit;								
								}
								?>
							  </td>
							  <? } else { ?>
                            <td height="5" bgcolor="#FFFFFF"  colspan="5" align="center" ></td>
							  <? } ?>
                            <td height="5" bgcolor="#FFFFFF"  colspan="3" align="center" ></td>
                          </tr>
                          <tr class="textb12">
							  <? if($rs[pro_category]=="12" && $equip_disposal_impression_total!='0'){?>
                            <td height="5" bgcolor="#FFFFFF"  colspan="4" align="center" ></td>
                            <td height="2" bgcolor="#0C51A0" align="center" ></td>
							  <? } else { ?>
                            <td height="5" bgcolor="#FFFFFF"  colspan="5" align="center" ></td>
							  <? } ?>
                            <td height="5" bgcolor="#FFFFFF"  colspan="3" align="center" ></td>
                          </tr>
			                  <tr bgcolor="#FFFFFF" class="textb12">
			                    <td height="30" colspan="7" align="center" ></td>
			                    </tr>
			                  </tbody>
			                </table></td>
			              </tr>	
		              </table></td>
		            </tr>
			        <tr>
			          <td colspan="4">&nbsp;</td>
		            </tr>
<? if($disable_stock!="1"){?>
			        <tr>
						
			          <td align="center" width="25%"></td>
			          <td align="center" width="25%">
						  <? if($nett!='0'){?>
						  <a href="out_stock.php?pro_id=<? echo $rs[pro_id];?>&form_link=mobile_stock" target="_parent" class="textbl10"><img src="../image_button/button_out_stock.png" width="200" height="64" alt=""/>
						  </a>
						  <? } ?>
						</td>
			          <td align="center" width="25%"><a href="income_stock.php?pro_id=<? echo $rs[pro_id];?>&form_link=mobile_stock" target="_parent" class="textbl10">

						  <img src="../image_button/button_income_stock.png" width="200" height="64" alt=""/></td>
			          <td align="center" width="25%">&nbsp;</td>
		            </tr>
<? }else{ ?>
<? if($disable_back!="1"){?>
          <tr>
            <td height="100" colspan="3"></td>
          </tr>
              <tr height="5">
                <td colspan="4" align="center">
					<a href="../planner_process/mpdf/detail_mobile_job_order.php?oid=<? echo $oid;?>#product<? echo $pro_id;?>" style="text-decoration: none;">
						
					<div 
						 style="display: flex;
								position: relative;
								width: 200px;
								height: 64px;
								background:rgba(45,170,250,1);
								border-radius: 10px; 
								font-size:18px;
								color:white;
								align-items: center;
								justify-content: center;
								padding:5px;">
						<div 
							 style="display: flex;
									position: relative;
									border:2px dashed rgba(255,255,255,1.00);
									font-size:18px;
									color:white;
									align-items: center;
									justify-content: center;
									padding: 10px 25px 10px 25px;">
						ย้อนกลับ / BACK
						</div>	
					</div>
						
					</a>
				</td>
              </tr>

<? } ?>
<? } ?>
		          </tbody>
		        </table>
			  </div>
			  
		    </td>
          </tr>
          <tr>
            <td height="100" colspan="3"></td>
          </tr>
			                  <tr bgcolor="#FFFFFF" class="textb12">
			                    <td height="50" colspan="7" align="center" ></td>
			                    </tr>
        </table></td>
    </tr>
  </table>
</div>
</body>
</html>
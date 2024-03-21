<!-- ENCODE CHARSET -->
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<!-- ENCODE CHARSET -->	

	
<div align="center" style"display:flex;position:absolute;top:0px;z-index:1;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#0C51A0">
    <tbody>
      <tr>
        <td><img src="../image_banner/banner-ASP-01.gif"></td>
        <td width="64"><? if($rs_accessibility_chk[super_user]=="1" || $rs_accessibility_chk[super_admin]=="1"){ ?>
          <a href="accessibility_warehouse_management.php" target="_blank"> <img src="../image_button/button_setting_128x128_white.png" width="48" height="48" alt=""/> </a>
          <?}?></td>
      </tr>
			  <tr>
			<td height="3" colspan="3" bgcolor="#959595"></td>
	  </tr>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td width="841" valign="top"><div align="center">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td bgcolor="#C7C8CA">&nbsp;</td>
                    <td  bgcolor="#C7C8CA" align="center"><table width="800" border="0" cellspacing="0" cellpadding="0">
                      <tbody>
                         <tr>
                              <td width="267" bgcolor="#AEADC4"><div align="center"><a href="product.php" target="_parent"><img src="imgs/menu01.jpg" width="267" height="40" border="0"></a></div></td>
                              <td width="267" bgcolor="#AEADC4"><div align="center"><a href="daily.php" target="_parent"><img src="imgs/menu02.jpg" width="267" height="40" border="0"></a></div></td>
                              <td width="267" bgcolor="#AEADC4"><div align="center"><a href="report.php" target="_parent"><img src="imgs/menu03.jpg" width="267" height="40" border="0"></a></div></td>
								
                              </tr>
                      </tbody>
                    </table></td>
                    <td bgcolor="#C7C8CA">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>
              <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>	
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
				  <table width="100%" height="800"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <?
											$sql_pro= "SELECT pro_code FROM  tsp_product  WHERE pro_id = '$pro_id'  ";
											$pro_rs = mysql_query($sql_pro,$conn);
											$rs_pro=mysql_fetch_array($pro_rs); 
											
											$sql_gd = "SELECT * FROM  gd_artwork  WHERE  art_name='$rs_pro[pro_code]' ";
											$res_gd = mysql_query($sql_gd,$conn);
											$rs_gd=mysql_fetch_array($res_gd);

											$exd = explode(".", $rs_gd[art_pic]);
					  switch($rs[pro_category]=="11") { 
							  case"11":// FINISH GOOD
											
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
                      <td  colspan="13" align="center">				  
						<? if($ttype=='pdf'){ ?>
						 <? switch($rs[pro_category]){ 
	case "11": ?> 
                        <iframe width="100%" height="800"  src="../pdf_js/web/viewer.html?file=../../art_pic/<? echo iconv('TIS-620','UTF-8',$rs_gd[art_pic]);?>#toolbar=0&navpanes=0&scrollbar=0&view=fith"> </iframe>
	<?
		break;
	default:
	 ?>	
						 <? if($rs[pro_category]=="12" && $rs[pro_subtype]=="5"){ 						  
		
						$sql_dicut_equip = "SELECT * FROM  gd_diecut  WHERE dicut_id = '$rs[pro_code]'";
						$con_dicut_equip = mysql_query($sql_dicut_equip,$conn);
						$rs_dicut_equip = mysql_fetch_array($con_dicut_equip);
		 
						  ?>
                        <iframe width="100%" height="800"  src="../pdf_js/web/viewer.html?file=../../dicut_pic/<? echo $rs_dicut_equip[dicut_art];?>#toolbar=0&navpanes=0&scrollbar=0&view=fith"> </iframe>
						 <? } else { ?>						
                        <iframe width="100%" height="800"  src="../pdf_js/web/viewer.html?file=../../inventory2020/pro_images/<? echo $rs[images];?>#toolbar=0&navpanes=0&scrollbar=0&view=fith"> </iframe>  
						 <? } ?>
<? 
		break;
} ?>
                        <?  }else{ if(!$sql_gd){?>						
                        <img src="../art_pic/<? echo $rs_gd[art_pic];?>" width="750" border="0">
						<?} else {?>
						<img src="imgs/no_photo_color.jpg"  width="500"></td>
                        <?	 }; }?>
						</td>
                    </tr>
                    <? } else { ?>
                    <? if(!empty($rs[images])){?>
                    <tr>
                      <td align="center" height="25" colspan="3" class="thaitext_body"><img src="pro_images/<? echo $rs[images]?>"  width="350"></td>
                    </tr>
                    <? } else {?>
                    <tr>
                      <td align="center" height="25" colspan="3" class="thaitext_body"><img src="imgs/no_photo_color.jpg"  width="500"></td>
                    </tr>
                    <? } ?>
                    <? } ?>
					
                    <? if($rs[pro_category]=="11") { ?>
                    <tr>
                      <td height="75" colspan="3" align="right" class="thaitext_body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
							<? if($rs_gd){?>
                          <tr>
                            <td align="center"><a href="../art_pic/<? echo $rs_gd[art_pic]?>" class="textbl10"><img src="../image_icon/fullview_icon.gif" width="170" height="40" alt=""/></a></td>
                          </tr>
							<?}?>
                        </tbody>
                      </table></td>
                    </tr>
                    <? ; } ?>
                    <tr>
                      <td height="25" colspan="3" align="right" class="thaitext_body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td height="25" colspan="3" class="thaitext_body"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                              <tbody>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="10%">&nbsp;</td>
                                  <td>
									  <table width="100%" bordercolor="#0C51A0" border="1" cellspacing="0" cellpadding="0">
                                    <tbody>
                                      <tr>
                                        <td bgcolor="#0C51A0" class="text_prompt_white_22" align="center" height="35"><div>
<? 
switch($rs[pro_category]){
					  case "12":
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
										  ?></div></td>
                                      </tr>
                                      <tr>
                                        <td align="right">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tbody>
                                            <tr>
                                              <td width="30%">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
											<? if($rs[pro_category]!="11"){ ?>
                                            <tr>
                                              <td valign="top"><div align="right" class="text_prompt_blue_14"><strong><? echo $topic_txt1;?> </strong></span><strong>&nbsp;</strong></div></td>
                                              <td valign="top"><div align="left"  class="text_prompt_black_14"><? echo html($rs[pro_code]);?></div></td>
                                            </tr>
											<?;}?>
                                            <tr>
                                              <td valign="top"><div align="right" class="text_prompt_blue_14"><strong><? echo $topic_txt2;?> </strong></span><strong>&nbsp;</strong></div></td>
                                              <td valign="top"><div align="left"  class="text_prompt_black_14"><? echo html($rs[pro_name]);?></div></td>
                                            </tr>
                                            <? if(!empty($rs[pro_detail])){ ?>
                                            <tr>
                                              <td valign="top"><div align="right" class="text_prompt_blue_14"><strong><? echo $topic_txt3;?> &nbsp;</strong></div></td>
                                              <td valign="top"><div align="left"  class="text_prompt_black_14"><? echo $rs[pro_detail];?></div></td>
                                            </tr>
                                            <?;}?>
                                            <? if($rs[pro_category]=="12"){ ?>
                                            <tr>
                                              <td valign="top"><div align="right" class="text_prompt_blue_14"><strong>หมายเหตุ  &nbsp;</strong></div></td>
                                              <td valign="top"><div align="left"  class="text_prompt_black_14"><? echo html($rs[pro_detail2]);?></div></td>
                                            </tr>
                                            <?;}?>
<? 
	switch($rs[pro_category]){
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
                                              <td><div align="left"  class="text_prompt_black_14"><? echo $rs[pro_block_positions];?></div></td>
                                            </tr>
                                  <tr>
                                              <td height="35" colspan="2"></td>
								  </tr>
                                            <tr>
                                              <td height="35" colspan="2">
<div align="center">					
<div class="qrcode_tag"><div class="topic" style="height:30px;">SCAN HERE</div>
<img src="../TICKET_QRCODE/barcode.php?f=svg&s=qrh&d=<? echo 'http://aspms1892474.trueddns.com:22850/inventory2020/mobile_io_stock.php?pro_id='.$pro_id;?>&cm=000000&ms=s&w=190&h=190&p=0">
</div>
</div>
												</td>
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
											
										<? switch($rs_accessibility_chk[edit_info_pro]){
											case "1":											
											?>
                                            <tr>
                                              <td height="35"></td>
                                              <td><div align="right"><a href="edit_product.php?&pro_id=<? echo $rs[pro_id]?>&form_link=detail_product" ><img src="../image_icon/EDIT-icon-2.png" width="32" height="32" border="0"></a>&nbsp;</div></td>
                                            </tr>											
											<?
											break;
											default:
											?>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>											
											<?
											break;
											} ?>
                                          </tbody>
                                        </table></td>
                                      </tr>
                                    </tbody>
                                  </table></td>
                                  <td width="10%">&nbsp;</td>
                                </tr>	
				  
<!-- PURCHASE DETAIL BEGIN -->	
<?
			
	$sql_PO_chk = "SELECT * FROM  tsp_product_in where sup_id !='' and in_chanals='ใบสั่งซื้อ' and pro_id='$pro_id'  order by create_date DESC";
	$con_PO_chk = mysql_query($sql_PO_chk,$conn);		
	$rs_PO_chk = mysql_fetch_array($con_PO_chk);
							if($rs_accessibility_chk[view_supplier]==1 && !empty($rs_PO_chk)){?>							

								  
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="10%">&nbsp;</td>
                                  <td>
									  <table width="100%" bordercolor="#0C51A0" border="1" cellspacing="0" cellpadding="0">
                                    <tbody>
                                      <tr>
                                        <td bgcolor="#0C51A0" class="text_prompt_white_22" align="center" height="35"><div>ข้อมูลซัพพลายเออร์</div></td>
                                      </tr>
                                      <tr>
                                        <td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tbody>
											  
                                            <tr bgcolor="#C0C0C0">
                                              	<td width="15%" class="text_prompt_black_14" width="388" align="right">สั่งซื้อ&nbsp;</td>
												<td class="text_prompt_black_14" width="786"></td>
												<td width="15%" align="center" class="text_prompt_black_14">ใบสั่งซื้อล่าสุด</td>
                                            </tr>
											<?
		$sql_sup = "SELECT * FROM  tsp_product_in where sup_id!='' and pro_id='$pro_id'  group by sup_id order by create_date ASC";
 		$con_sup = mysql_query($sql_sup,$conn);		
		while($rs_sup = mysql_fetch_array($con_sup))
		{		
			
												$sql_sup_name = "SELECT * FROM  supplier where supid='$rs_sup[sup_id]'";
 												$con_sup_name = mysql_query($sql_sup_name,$conn);	
												$rs_sup_name = mysql_fetch_array($con_sup_name);
			
												$sql_PO = "SELECT * FROM  tsp_product_in where sup_id='$rs_sup[sup_id]' and in_chanals='ใบสั่งซื้อ' and pro_id='$pro_id' order by create_date DESC";
												$con_PO = mysql_query($sql_PO,$conn);		
												$rs_PO = mysql_fetch_array($con_PO);
												
												$sql_plpipo = "SELECT * FROM  plpipo where po_id='$rs_PO[po_id]' and po_status!='1'";
 												$con_plpipo = mysql_query($sql_plpipo,$conn);	
												$rs_plpipo = mysql_fetch_array($con_plpipo);
												
											  ?>  
                                            <tr>
                                              	<td height="60" align="right">													
													<a href="../plpipo/edit_tax-+.php?supid=<? echo $rs_sup[sup_id];?>&spid=<? echo $rs_plpipo[id];?>&type_form=copy" target="_new">
													<img src="../image_icon/basket-icon_256x256.png" width="48" height="48" alt=""/>
													</a>
												</td>
											  <td class="text_prompt_blue_18" valign="middle">&nbsp;
												<a href="../plpipo/invoice_list-+.php?supid=<? echo $rs_sup[sup_id];?>"><? 
												echo $rs_sup_name[sup_type].$rs_sup_name[sup_name];
													?></a>
												</td>
												<td > <!-- PURCHASE ORDER-->
												<table width="100%" border="2" cellspacing="0" cellpadding="0" bordercolor="#FFFFFF" >
  <tbody>
    <tr>
      <td height="25" align="center" class="text_prompt_black_12" >PURCHASE ORDER</td>
    </tr>
	 <? 
	  ?> 
    <tr>
      <td align="center" class="text_prompt_black_14"><a href="../plpipo/purchase_order_pdf.php?po_id=<? echo  $rs_PO[po_id];?>" target="_blank"><? echo $rs_PO[po_id] ;?></a></td>
    </tr>
	 <tr>
      <td height="5"  align="center" class="text_prompt_black_14" ></td>
    </tr>
  </tbody>
</table>

												</td>
                                            </tr>
											  <?
											;}  
											  ?>
                                          </tbody>
                                        </table></td>
                                      </tr>
                                    </tbody>
                                  </table></td>
                                  <td width="10%"></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
<?;}?>	
<!-- PURCHASE DETAIL END -->
				  
<!-- job order used FOR Materail -->
<?
if($rs[pro_category]=="10" || $rs[pro_category]=="11"){
?>			
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

								  
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="10%">&nbsp;</td>
                                  <td>
									  <table width="100%" bordercolor="#0C51A0" border="1" cellspacing="0" cellpadding="0">
                                    <tbody>
                                      <tr>
                                        <td bgcolor="#0C51A0" class="text_prompt_white_22" align="center" height="35"><div>รายการใบสั่งงาน รอการเบิก</div></td>
                                      </tr>
                                      <tr>
                                        <td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tbody>
											  
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
											  <?
											;}  
											  ?>
		<?
		if($materail_job_chk_qty_all>$nett_stock){$txt_amount_all_color="color:darkred;";}else{$txt_amount_all_color="color:black;";}
		?> 
											  
	<? if(count($materail_job_chk_job_order)>'0'){?>	
	<tr>
		<td valign="middle" colspan="3" align="left" bgcolor="#FFFFFF"  class="" style="padding : 0px 10px 2px 10px;">
		 <div style="display: flex;position: relative;width: 100%;height: 3px;background:rgba(0,0,0,0.1);border-radius: 1.5px;"></div>
		</td>
	</tr>
	<? } ?>	
											  
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
                                          </tbody>
                                        </table></td>
                                      </tr>
                                    </tbody>
                                  </table></td>
                                  <td width="10%"></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
<?;}?>	
<!-- job order used FOR Materail -->							
							
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
                                          <td height="35" bgcolor="<? echo $border_col ;?>" align="center" class="text_prompt_white_22">ยอดคลังคงเหลือ</td>
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
                          </tr>
                          <tr>
                            <td height="25" colspan="3" >&nbsp;</td>
                          </tr>
				  
                        </tbody>
                      </table></td>
                    </tr>
		  
                    <tr>
                      <td height="25" colspan="3" align="center" ><table width="95%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr >
                            <td height="5" colspan="7" align="center" ></td>
                          </tr>
                          <tr><a name="stockcard_list">
                            <td valign="middle" width="15%" height="25" align="center" bgcolor="#D3D3D3"  class="text_prompt_black_12">วันที่</td>
                            <td valign="middle" width="10%" style="padding-left:15px;" align="left" bgcolor="#D3D3D3"  class="text_prompt_black_12">&nbsp;&nbsp;เลขที่เอกสาร</td>						  
                            <td valign="middle" width="13%" style="padding-right:15px;" align="right" bgcolor="#D3D3D3" class="text_prompt_black_12">เบิกจากคลัง</td>
                            <td valign="middle" width="13%" style="padding-right:15px;" align="right"  bgcolor="#D3D3D3" class="text_prompt_black_12">รับเข้าคลัง</td>
							<? if($rs[pro_category]=="12"){?>
                            <td valign="middle" width="10%" align="center" bgcolor="#0C51A0" class="text_prompt_white_12">จำนวนผลิต(impression)</td>
							<? } ?>
                            <td valign="middle" width="15%" align="left" bgcolor="#D3D3D3" class="text_prompt_black_12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้เบิก-รับ</td>
                            <td valign="middle" width="25%" align="left" bgcolor="#D3D3D3" class="text_prompt_black_12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเหตุ</td>
                            <td width="5%" align="center" bgcolor="#D3D3D3">&nbsp;</td>
                          </tr>
                          <? 
					$stock_date=date("Y-m-d");
					switch($rs[pro_category]){
						case"12":
					$start_date=date("Y-m-d", strtotime("-12 Month"));
						break;
						default:
					$start_date=date("Y-m-d", strtotime("-1 Month"));
						break;
					}
					$ij=1;
					
					$sql_material_name= "SELECT * FROM  tsp_product WHERE pro_id= '$pro_id'";
					$con_material_name = mysql_query($sql_material_name);
					$rs_material_name  = mysql_fetch_array($con_material_name);
							  
					$sql_warehouse_io = "SELECT * FROM tsp_product_io  WHERE pro_id='$pro_id' and io_date>='$start_date' order by io_date ASC";					
					$res_warehouse_io = mysql_query($sql_warehouse_io,$conn);					
					$rs_warehouse_io=mysql_fetch_array($res_warehouse_io); 
					
					if($rs_warehouse_io){		  
					$sql_warehouse_io = "SELECT * FROM tsp_product_io  WHERE pro_id='$pro_id' and io_date>='$start_date' order by io_date ASC";	
					}else{
					$sql_warehouse_io = "SELECT * FROM tsp_product_io  WHERE pro_id='$pro_id' order by io_date ASC LIMIT 0,10";	
					}					
					$res_warehouse_io = mysql_query($sql_warehouse_io,$conn);					
					while($rs_warehouse_io=mysql_fetch_array($res_warehouse_io)){ 
					
					if(($ij%2)==0){ $bg_col="#FBFFE0"; }else{  $bg_col="#FFFFFF";}
					
			
			
			
			$sql_warehouse_out= "SELECT * FROM  tsp_product_out WHERE out_id= '$rs_warehouse_io[io_id]'";
			$con_warehouse_out= mysql_query($sql_warehouse_out);
			$rs_warehouse_out = mysql_fetch_array($con_warehouse_out) ;
			
			if (!empty($rs_warehouse_out)){$io_emp=$rs_warehouse_out[out_by];} else {$io_emp=$rs_warehouse_io[create_by];}
			
					$sql_em= "SELECT * FROM  employees_new  WHERE em_id = '$io_emp'  ";
					$employee = mysql_query($sql_em,$conn);
					$rs_em=mysql_fetch_array($employee);
					?>
                          <tr>
                            <td style="padding-left:15px;" align="left" bgcolor="<? echo $bg_col ;?>" height="30"  class="text_prompt_black_12">
                              <? if(!empty($rs_warehouse_io[io_date])){ echo   nar_date2 ($rs_warehouse_io[io_date])." ".substr($rs_warehouse_io[create_date],11,5);} else { echo "-";} ;?></td>
                            <td style="padding-left:15px;" align="left" bgcolor="<? echo $bg_col ;?>"  class="text_prompt_black_12">
                              <? if(empty($rs_warehouse_io[order_no])){echo  $rs_warehouse_io[io_no];} else {echo  $rs_warehouse_io[order_no];} ?></td>
                            <td style="padding-right:15px;" align="right" bgcolor="<? echo $bg_col ;?>"  class="text_prompt_red_12"><? if($rs_warehouse_io[io_type]=="OUT"){if (strpos($rs_warehouse_io[io_amount],".")!= false){echo number_format($rs_warehouse_io[io_amount],2,'.',',')." ".$rs_material_name[pro_unit];} else {echo number_format($rs_warehouse_io[io_amount],0,'.',',')." ".$rs_material_name[pro_unit];}} else {echo "-";} ?></td>
                            <td style="padding-right:15px;" align="right" bgcolor="<? echo $bg_col ;?>" class="text_prompt_blue_12"><? if($rs_warehouse_io[io_type]=="IN"){if (strpos($rs_warehouse_io[io_amount],".")!= false){echo number_format($rs_warehouse_io[io_amount],2,'.',',')." ".$rs_material_name[pro_unit];} else {echo number_format($rs_warehouse_io[io_amount],0,'.',',')." ".$rs_material_name[pro_unit];}} else {echo "-";} ?></td>
							  
							<? if($rs[pro_category]=="12"){																  
$preexd_art=$rs[pro_name];
$exd_art = explode(" ", $preexd_art);
$fid=$exd_art[count($exd_art)-1];
$desc_art= trim($fid);
$sum_plan_amount_qty=0;	
						
switch($rs[pro_subtype]){
	case "3":
		$txt_machine="LT-".trim(substr($rs[pro_code],0,2));
		$txt_desc_art=trim($desc_art);
		$txt_dc_machine='';
	break;
	case "4":
		$txt_machine="SC-";
		$txt_desc_art='';
		$txt_dc_machine='';
	break;
	case "5":
		$txt_machine="DC-";
		$txt_dc_machine="ไดคัท";
		$txt_desc_art='';
	break;
	case "6":
		$txt_machine="DC-";
		$txt_dc_machine="hot";
		$txt_desc_art='';
	break;
	default:
		$txt_machine="LT-".trim(substr($rs[pro_code],0,2));
		$txt_desc_art=trim($desc_art);
		$txt_dc_machine='';
	break;	
		
}
						
$sql_equip_amount_chk= "SELECT (plan_job_order_amount.order_no) as order_no,(plan_job_order_amount.process_id) as process_id,(plan_job_order_amount.machine) as machine,(plan_job_order_amount.plan_amount_qty) as plan_amount_qty,plan_job_order_process.plan_desc FROM  plan_job_order_amount left join plan_job_order_process on plan_job_order_amount.process_id=plan_job_order_process.id where plan_job_order_amount.order_no='".trim($rs_warehouse_io[order_no])."'  and plan_job_order_amount.machine like '".$txt_machine."%' and plan_job_order_process.plan_desc like '%".$txt_desc_art."%' and plan_job_order_process.plan_desc like '%".$txt_dc_machine."%'";
$con_equip_amount_chk= mysql_query($sql_equip_amount_chk,$conn);
$rs_equip_amount_chk=mysql_fetch_array($con_equip_amount_chk);
						
if($rs_equip_amount_chk){					
$sql_equip_amount= "SELECT (plan_job_order_amount.order_no) as order_no,(plan_job_order_amount.process_id) as process_id,(plan_job_order_amount.machine) as machine,(plan_job_order_amount.plan_amount_qty) as plan_amount_qty,plan_job_order_process.plan_desc FROM  plan_job_order_amount left join plan_job_order_process on plan_job_order_amount.process_id=plan_job_order_process.id where plan_job_order_amount.order_no='".trim($rs_warehouse_io[order_no])."'  and plan_job_order_amount.machine like '".$txt_machine."%' and plan_job_order_process.plan_desc like '%".$txt_desc_art."%' and plan_job_order_process.plan_desc like '%".$txt_dc_machine."%'";
} else {					
$sql_equip_amount= "SELECT (plan_job_order_amount.order_no) as order_no,(plan_job_order_amount.process_id) as process_id,(plan_job_order_amount.machine) as machine,(plan_job_order_amount.plan_amount_qty) as plan_amount_qty,plan_job_order_process.plan_desc FROM  plan_job_order_amount left join plan_job_order_process on plan_job_order_amount.process_id=plan_job_order_process.id where plan_job_order_amount.order_no='".trim($rs_warehouse_io[order_no])."'  and plan_job_order_amount.machine like '".$txt_machine."%' and plan_job_order_process.plan_desc like '%".$txt_dc_machine."%'";
}
$con_equip_amount = mysql_query($sql_equip_amount,$conn);
while($rs_equip_amount=mysql_fetch_array($con_equip_amount)){
								$sum_plan_amount_qty=$sum_plan_amount_qty+$rs_equip_amount[plan_amount_qty];
								}						
							?>
                            <td align="center" bgcolor="<? echo "#CCF7FC"//$bg_col ;?>" class="text_prompt_black_12"><? if($rs_warehouse_io[io_type]=="OUT"){ if($sum_plan_amount_qty !="0" && !empty($sum_plan_amount_qty)){echo number_format($sum_plan_amount_qty,'0','.',',')." ครั้ง";
							}else{echo "-";}
							;} else {echo "-";}?></td>
							<? } ?> 							  
                            <td align="left" bgcolor="<? echo $bg_col ;?>" class="text_prompt_black_12">&nbsp;&nbsp;&nbsp;<? echo $rs_em[em_name]; ?></td>
                            <td align="left" bgcolor="<? echo $bg_col ;?>" class="text_prompt_black_12">&nbsp;&nbsp;&nbsp;<? echo $rs_warehouse_io[in_remark];?></td>
                            <td align="center" bgcolor="<? echo $bg_col ;?>" class="text_prompt_black_12">
								
							<? if($rs_accessibility_chk[super_admin]=="1"){ ?>
							<? switch($rs_warehouse_io[io_type]){ 
								case "IN" : ?>
							<a href="del_stock_action.php?in_no=<? echo $rs_warehouse_io[io_no];?>&sid=<? echo $ID;?>&form_link=detail_product&stock_action_id=<? echo $rs_warehouse_io[io_id]; ?>&pro_id=<? echo $pro_id;?>" onclick="if (confirm('ยืนยันการลบข้อมูล')) {return true;} else {return false;}" class="textbl10">
                        	<img src="../../image_icon/delete_32x32_icon.gif" width="24" height="24" alt=""/></a>
								<? 	break;
									default:
								?>
							<a href="del_stock_action.php?out_no=<? echo $rs_warehouse_io[io_no];?>&sid=<? echo $ID;?>&form_link=detail_product&stock_action_id=<? echo $rs_warehouse_io[io_id]; ?>&pro_id=<? echo $pro_id;?>" onclick="if (confirm('ยืนยันการลบข้อมูล')) {return true;} else {return false;}" class="textbl10">
                        	<img src="../../image_icon/delete_32x32_icon.gif" width="24" height="24" alt=""/></a>								
							<? break;} ?>
							<? ;} ?>
								
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
                          <tr bgcolor="#FFFFFF" class="textb12">
                            <td height="30" colspan="7" align="center" ></td>
                          </tr>
							
                          <tr bgcolor="#FFFFFF" class="textb12">
                            <td height="30" colspan="7" align="center" ><table width="100%" border="0">
  <tbody>
	  <? if($rs[pro_category]=="12" || $rs_accessibility_chk[super_admin]=="1"){ ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
			        <tr>
						
			          <td align="center" width="25%"></td>
			          <td align="center" width="25%"><a href="out_stock.php?pro_id=<? echo $rs[pro_id];?>&form_link=mobile_stock" target="_parent" class="textbl10"><img src="../image_button/button_out_stock.png" width="200" height="64" alt=""/></a></td>
			          <td align="center" width="25%"><a href="income_stock.php?pro_id=<? echo $rs[pro_id];?>&form_link=mobile_stock" target="_parent" class="textbl10">
						  <img src="../image_button/button_income_stock.png" width="200" height="64" alt=""/></td>
			          <td align="center" width="25%">&nbsp;</td>
		            </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	  <? ;} ?>
  </tbody>
</table>
</td>
                          </tr>
                        </tbody>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td></td>
                </tr>
              </table>
            </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</div>


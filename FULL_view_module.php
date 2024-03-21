<!-- ENCODE CHARSET -->
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<!-- ENCODE CHARSET -->

<?


/* SQL Connect */


switch(true){
		
	case (isset($order_id_keypass)):

$sql_order_no= " SELECT order_id,order_no FROM new_po WHERE order_no='".decode($order_id_keypass)."' LIMIT 1 ";	
$con_order_no= mysql_query($sql_order_no);
$rs_order_no= mysql_fetch_array($con_order_no);
		
		$sql_pic= "SELECT 
		plan_job_order_process_pic.id as id,
		plan_job_order_process_pic.plan_job_process_id as plan_job_process_id,
		CONCAT('../plan_job_process_pic/',plan_job_order_process_pic.plan_job_process_pic) as pic,
		CONCAT('../plan_job_process_pic_thumb/',plan_job_order_process_pic.plan_job_process_pic) as pic_thumb,
		plan_job_order_process_pic.plan_job_process_pic_desc as pic_desc,
		plan_job_order_process_pic.plan_job_process_pic_type as pic_type,
		plan_job_order_process_pic.create_by as create_by,
		employees_new.em_name as create_name,
		plan_job_order_process_pic.create_date as create_date,
		plan_job_order_process.order_no as doc_no,
		plan_job_order_process.machine as info 
		FROM  plan_job_order_process_pic 
		LEFT JOIN plan_job_order_process ON plan_job_order_process_pic.plan_job_process_id=plan_job_order_process.id 
		LEFT JOIN employees_new ON plan_job_order_process_pic.create_by=employees_new.em_id 
		WHERE plan_job_order_process.order_no='".decode($order_id_keypass)."'
		ORDER BY plan_job_order_process_pic.plan_job_process_id, plan_job_order_process_pic.create_date ASC";
		
			
		
		$display='flex';
		
		$show_button=true;
		
		if($plan_job_process_id!=''){
		$show_button_add_pic=true;
		}else{		
		$show_button_add_pic=false;	
		}
		
		break;
		
	case (isset($oid)):

$sql_order_no= " SELECT order_id,order_no FROM new_po WHERE order_no='$oid' LIMIT 1 ";	
$con_order_no= mysql_query($sql_order_no);
$rs_order_no= mysql_fetch_array($con_order_no);

		$order_id_keypass=encode($rs_order_no[order_id]);
		
		$sql_pic= "SELECT 
		plan_job_order_process_pic.id as id,
		plan_job_order_process_pic.plan_job_process_id as plan_job_process_id,
		CONCAT('../plan_job_process_pic/',plan_job_order_process_pic.plan_job_process_pic) as pic,
		CONCAT('../plan_job_process_pic_thumb/',plan_job_order_process_pic.plan_job_process_pic) as pic_thumb,
		plan_job_order_process_pic.plan_job_process_pic_desc as pic_desc,
		plan_job_order_process_pic.plan_job_process_pic_type as pic_type,
		plan_job_order_process_pic.create_by as create_by,
		employees_new.em_name as create_name,
		plan_job_order_process_pic.create_date as create_date,
		plan_job_order_process.order_no as doc_no,
		plan_job_order_process.machine as info 
		FROM  plan_job_order_process_pic 
		LEFT JOIN plan_job_order_process ON plan_job_order_process_pic.plan_job_process_id=plan_job_order_process.id 
		LEFT JOIN employees_new ON plan_job_order_process_pic.create_by=employees_new.em_id 
		WHERE plan_job_order_process.order_no='".$oid."'
		ORDER BY plan_job_order_process_pic.plan_job_process_id, plan_job_order_process_pic.create_date ASC";
		
		$display='flex';
		
		$show_button=true;
		
		if($plan_job_process_id!=''){
		$show_button_add_pic=true;
		}else{		
		$show_button_add_pic=false;	
		}
		
		break;
		
	case (isset($fm_car_no_keypass)):/* FM CAR. */
		
		$sql_pic= "SELECT 
		asp_fm_qc_011_car_pic.fm_car_pic_id as id,
		asp_fm_qc_011_car_pic.fm_car_pic_id as fm_car_id,
		CONCAT('../ISO_Facility_Management/fm_qc_011_car_pic/',asp_fm_qc_011_car_pic.fm_car_pic) as pic,
		CONCAT('../ISO_Facility_Management/fm_qc_011_car_pic_thumb/',asp_fm_qc_011_car_pic.fm_car_pic) as pic_thumb,
		asp_fm_qc_011_car_pic.fm_car_pic_desc as pic_desc,
		asp_fm_qc_011_car_pic.fm_car_pic_type as pic_type,
		asp_fm_qc_011_car_pic.create_by as create_by,
		employees_new.em_name as create_name,
		asp_fm_qc_011_car_pic.create_date as create_date,
		asp_fm_qc_011_car.fm_car_no as doc_no
		FROM  asp_fm_qc_011_car_pic
		LEFT JOIN asp_fm_qc_011_car ON asp_fm_qc_011_car_pic.fm_car_id=asp_fm_qc_011_car.fm_car_id
		LEFT JOIN employees_new ON asp_fm_qc_011_car_pic.create_by=employees_new.em_id 
		WHERE asp_fm_qc_011_car.fm_car_no='".decode($fm_car_no_keypass)."'
		ORDER BY asp_fm_qc_011_car_pic.create_date ASC";
		
		$show_button=false;		
		
		$display='none';
		
		$show_button_add_pic=false;	
		
		break;
		
	default:
		break;
}
$con_pic= mysql_query($sql_pic,$conn);
$rs_pic= mysql_fetch_array($con_pic);
/* SQL Connect */
?>
<html>
  <head>
    <meta charset="TIS-620" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles_view_card.css" />
  </head>
	
	
  <body>
<div class="contain-view-card"	style=""	 >
	
	
  <div class="headder" style="">PHOTO Gallery<br><span><? echo $rs_pic[doc_no];?></span></div>
	<?
	if($show_button_add_pic && $ID!=''){	
	?>
	
    <div class="card rgb" data-tilt data-tilt-scale=""  style="">
		<div class="card-image" style="" ></div>
      <div class="card-text">	
        <h2 style="text-align: center;"> <? echo 'Add PHOTO';?></h2>
		<div align="center" style="justify-content: center;align-content: center;align-items: center;opacity: 0.8;"><img src="../image_icon/camera_icon.svg" width="100%"></div>
        <h2 style="text-align: center;"><i class="fa fa-angle-down" aria-hidden="true" style="font-size:36px;color:grey;"></i></h2>
      </div>
		<div class="card-stats">
			<div class="stat"></div>
			<div class="stat">
				<form action="../planner_process/mpdf/plan_job_process_pic_update.php"  enctype="multipart/form-data"  method="Post"  autocomplete='off' name="form_photo">
<input type="hidden" name="plan_job_process_id" value="<? echo $plan_job_process_id;?>">
<input type="hidden" name="oid" value="<? echo $oid;?>">
<input type="hidden" name="photo_form_action" value="add_photo">
					<input type="file"  style="display:none;" id="file" name="file" VALUE=''  onchange="this.form.submit()">
					</input>
<label for="file" class="file-style" style="border:none;background: none;">
	<? if($device_platform=="MOBILE"){?>
 <img style="content: url('../image_icon/camera_circle_icon.svg') !important;background: none;cursor:pointer;">
	<? } else { ?>	
 <img style="content: url('../image_icon/add_circle_icon.svg') !important;background: none;cursor:pointer;">	
	<? } ?>
 <div style ="	width:55px;
			  	text-align:center;
				font-family: 'Prompt', sans-serif;	
			  	background: none;
				font-style:normal !important;"
	  ></div>
</label>
				</form>	
			</div>
			<div class="stat"></div>
		</div>
	</div>	
	<? } ?>
	<? 
	/* BEGIN PIC of Gallery */
			
$con_pic= mysql_query($sql_pic,$conn);
$i_pic='1';		
while($rs_pic= mysql_fetch_array($con_pic)){	
	
	if($rs_pic[create_by]==$ID && !(isset($fm_car_no_keypass))){$display='flex';}else{$display='none';}
	
	$ex_pic_type=explode('/',$rs_pic[pic_type]);?>
	
    <div class="card rgb" data-tilt data-tilt-scale="1.1" style="">
		
	<?										
	switch($ex_pic_type[0]){
		case "video": ?>
		<div class="card-image" align="center"  style="cursor:default;background-size:cover !important; ">
	  <video autoplay loop muted src="<? echo $rs_pic[pic]; ?>" height="100%"></video>
		</div>
		<? 
		break; 
			
		case "image":?>
      <div class="card-image" style="background:linear-gradient(#fff0 0%, #fff0 70%, #1d1d1d 100%),url('<? echo $rs_pic[pic_thumb]; ?>') no-repeat center;cursor:default;background-size:cover;" ></div>		
		<? 
		break; 
			
		case "application":	
			
			switch(true){
					case($ex_pic_type[1]=="pdf"):
					?>
						<div class="card-image" style="background:linear-gradient(#fff0 0%, #fff0 70%, #1d1d1d 100%),url('<? echo "../image_background/doc_pdf.svg"; ?>') no-repeat center;background-size:cover;cursor:default;" ></div>	
					<?
					break;
					default:
					?>
						<div class="card-image" style="background:linear-gradient(#fff0 0%, #fff0 70%, #1d1d1d 100%),url('<? echo "../image_background/doc_all.svg"; ?>') no-repeat center;background-size:cover;cursor:default;" ></div>	
					<?
					break;
			}
		 
		break; 
			
		default:?>
		<? 
		break;
	}?>
      <div class="card-text">	
        <div class="date" style="width: 100%; margin-top: 5px;"><? if($rs_pic[create_name]!=''){ echo "<i class='fa fa-user-circle-o' aria-hidden='true'></i>&nbsp;";} echo $rs_pic[create_name];?><? echo "<br><i class='fa fa-calendar' aria-hidden='true'></i>&nbsp;".date('d/m/y',strtotime($rs_pic[create_date]))."&nbsp;<i class='fa fa-clock-o' aria-hidden='true'></i>&nbsp;".date('H:i',strtotime($rs_pic[create_date]));?></div>
		  <hr>
		  <? if($rs_pic[info]!=''){?>
        <h2> <? echo $rs_pic[info];?></h2>
		  <? } ?>
		  
		  <? if($rs_pic[pic_desc]!=''){?>
        <p><? echo 'รายละเอียด : '.$rs_pic[pic_desc];?></p>
		  <? } ?>
      </div>
		<div class="card-stats">
			<div class="stat">
				<? if($display!="none"){?>
				<form  action="../planner_process/mpdf/plan_job_process_pic_update.php" enctype="multipart/form-data" method="post"  name="form_delete_<? echo $rs_pic[id]?>"
					  onsubmit="if (confirm('ยืนยันการลบภาพ')) {return true;} else {return false;}">
					<input type="hidden" name="photo_id" VALUE="<? echo $rs_pic[id];?>">
					<input type="hidden" name="plan_job_process_id" VALUE="<? echo $plan_job_process_id;?>">
					<input type="hidden" name="order_id_keypass" VALUE="<? echo $order_id_keypass;?>">
					<input type="hidden" name="photo_form_action" VALUE="photo_delete">
					<input type="hidden" name="oid" VALUE="<? echo $rs_order_no[order_no];?>">
					<input type="submit"
						   style="width:35px;
								  height: 35px;
								  border:none;
								  background:url('../image_icon/delete_red_circle_icon.svg') no-repeat center;
								  background-size:auto auto;
								  display:<? echo $display;?>;
								  cursor:pointer;
								  "
						   VALUE=''>
					</input>
				</form>	
			<? }else{?>
		<div  
		style="
		width:35px;
		height:35px;
		background:url('../image_icon/delete_white_none_circle_icon.svg') no-repeat center;
		background-size:auto auto;
		opacity: 0.5;
		cursor:default;" ></div>		
			<? } ?>
			</div>
		
			<div class="stat">
	<?										
	switch($ex_pic_type[0]){
		case "video": ?>
		<div  
		style="
		width:55px;
		height:55px;
		background:url('../image_icon/video_playing_2_icon.svg') no-repeat center;
		background-size:auto auto;
		cursor:pointer;"  
		onclick="javascript:window.open('player.php?top_bar=enable&autoplay=enable&order_media_id_keypass=<? echo encode($rs_pic[id]); ?>','_parent');">		
		<? 
		break;
		default:
		?>
		<div  
		style="
		width:55px;
		height:55px;
		background:url('../image_icon/fullscreen_circle_icon.svg') no-repeat center;
		background-size:auto auto;
		cursor:pointer;" 
		onclick="javascript:window.open('<? echo $rs_pic[pic]; ?>','_parent');"></div>
	<? 
	break;
	}?>
			</div>
		
			<div class="stat" >
				<? if($display!="none"){?>
				<form  action="../planner_process/mpdf/plan_job_process_pic_edit.php" enctype="multipart/form-data" method="post" name="form_edit_<? echo $rs_pic[id]?>">
					<input type="hidden" name="photo_id" VALUE="<? echo $rs_pic[id];?>">
					<input type="hidden" name="order_id_keypass" VALUE="<? echo $order_id_keypass;?>">
					<input type="hidden" name="photo_form_action" VALUE="upload_update">
					<input type="submit"
						   style="width:35px;
								  height: 35px;
								  border:none;
								  background:url('../image_icon/edit_red_circle_icon2.svg') no-repeat center;
								  background-size:auto auto;
								  display:<? echo $display;?>;
								  cursor:pointer;
								  "
						   VALUE=''>
					</input>
				</form>	
				<? }else{ ?>
		<div  
		style="
		width:35px;
		height:35px;
		background:url('../image_icon/edit_white_none_circle_icon.svg') no-repeat center;
		background-size:auto auto;
		opacity: 0.5;
		cursor:default;" >
				</div>
				<? } ?>
			</div>
		</div>
    </div>
	
	<? 
	
	}
	/* END PIC of Gallery */
	?>
	
    <script src="js/vanilla-tilt.min.js"></script>
    <script>
      VanillaTilt.init(document.querySelectorAll(".card"),{
        glare: true,
        reverse: true,
        "max-glare": 0.15
      });
    </script>
	
	</div>
  </body>
</html>

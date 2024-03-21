<!-- ENCODE CHARSET -->
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620">
<!-- ENCODE CHARSET -->	

<html lang="en">
<head>
    <title>PHOTO Display</title>
	
<meta charset="TIS-620" /> 
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styles_display.css" />
	
</head>
	
<? if($pic_path!=''){?>
	<div id="detail" class="" style="display: flex;position:fixed;top:5%;left:2%;flex-direction: row; width: fit-content;background:rgba(0,0,0,0.5);border-radius: 10px;padding:0px; cursor:default;">
		
		
		
		
		<a href="<? echo $pic_path;?>" download>	
		<div style="
			display: flex;
			position:fixed;
			width:48px;
			height:48px;
			border-radius:50%;
			background:rgba(0,0,0,0.5);
			align-items: center;
			font-size:1.8em;
			color:rgba(255,255,255,1);
			text-align: center;
			align-items:  center;
			cursor:pointer !important;
			top:5%;
			right:5%;		
			border:2px solid rgba(255,255,255,0.8);">
			<i class="fa fa-download" aria-hidden="true" style="width:100%;"></i>
		</div>
		</a>
		
		<? /* CREATE BY ZONE */
			$sql_create_by=" SELECT em_name FROM employees_new WHERE em_id='$create_by' LIMIT 1 ";
			$con_create_by= mysql_query($sql_create_by);
			$rs_create_by= mysql_fetch_array($con_create_by);
		?>
		<? if($rs_create_by){?>
		<div style="
			display: flex;
			position:fixed;
			font-family: 'Prompt', sans-serif;
			font-weight: lighter;	
			align-items: center;
			padding: 5px 15px 5px 15px;
			border-radius: 5px;
			background:rgba(0,0,0,0.5);
			font-size:9pt; 
			color:rgba(255,255,255,0.5);
			text-align:right;
			align-items:  center;
			cursor:default!important;
			bottom:3%;
			right:1%;">
			<? 
				echo "<i class='fa fa-user-circle-o' aria-hidden='true' style='color:rgba(255,255,255,0.5);'></i>&nbsp;";
				echo $rs_create_by[em_name];
				echo "&nbsp;&nbsp;<i class='fa fa-calendar' aria-hidden='true'  style='color:rgba(255,255,255,0.5);'></i>&nbsp;".date('d/m/y',$create_date)."&nbsp;<i class='fa fa-clock-o' aria-hidden='true'  style='color:rgba(255,255,255,0.5);'></i>&nbsp;".date('H:i',$create_date);
			?>
		</div>	
		<? } ?>
		
		<div style="
			display: flex;
			position:relative;
			width:48px;
			height:48px;
			border-radius:50%;
			background:none;
			align-items: center;
			align-content: center;
			align-self: center;
			font-size:1.8em;
			color:rgba(255,255,255,0.5);
			text-align: center;
			cursor:pointer !important;
					" 
		onclick="history.back()">
		<i class="fa fa-chevron-left" aria-hidden="true" style="width:100%;"></i>
		</div>
		<? if($pic_title!=''){ ?>
		<div id='desc' style="display: flex;position:relative;margin-right:215px;margin-right:37px; align-items: center;align-content: center;align-self: center;font-family: 'Prompt', sans-serif;font-size:1.0em;text-align:left;color:white;cursor:default;text-indent: 15px;font-weight: 100;" >
		<? echo trim($pic_title);?>
			
			<? if($pic_title!=''){ ?>	
		<div style="
			position:relative;
			border-radius:50%;
			background:none;
			font-size:1.2em;
			color:rgba(255,255,255,0.8);
			cursor:pointer !important;
			" onclick="this.remove(); return false;">
			<i class="fa fa-times" aria-hidden="true"></i>			
			<script language="javascript">
			window.onload = function(){
			document.getElementById('desc').onclick = function(){
			this.remove();
			return false;
			};
			};
			</script>
		</div>
		<? } ?>
		</div>	
<? } ?>
	</div>	
<? } ?>
<body>
	<div id="divZoom" style="background: url('<? echo $pic_path;?>')no-repeat center;background-size:auto 100%;">
	</div>
<script language=JavaScript src="js/zoomnpan.js"></script>
</body>
</html>

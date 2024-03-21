<!-- ENCODE CHARSET -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- ENCODE CHARSET -->	


<html>
<head>
    <title>ปฏิทินส่งมอบงาน</title>

</div>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />	
	
<link href="../textcs.css" rel="stylesheet" type="text/css">
<link href='assets/css/fullcalendar.css' rel='stylesheet' />
<link href='assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='assets/js/jquery-1.10.2.js' type="text/javascript"></script>
<script src='assets/js/jquery-ui.custom.min.js' type="text/javascript"></script>
<script src='assets/js/fullcalendar.js' type="text/javascript"></script>
<script>
	$(document).ready(function() {
	    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		/*  className colors

		className: default(transparent), important(red), chill(pink), success(green), info(blue)

		*/


		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events div.external-event').each(function() {

			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text())// $.trim($(this).text()) use the element's text as the event title
			};

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		var calendar =  $('#calendar').fullCalendar({
			header: {
				<? if($form_link=="mobile"){?>
				left: '',
				center: 'prev title next',	
				<? ;}else {?>
				
				left: 'agendaDay,agendaWeek,month',
				center: 'prevYear,prev title next,nextYear',
				<? ;} ?>
				right: 'today'
			},
			editable:  false,
			firstDay: 0, //  1(Monday) this can be changed to 0(Sunday) for the USA system
			selectable: true,
			defaultView: 'month',

			axisFormat: 'H:mm',//axisFormat: 'h:mm',
			columnFormat: {
                month: 'ddd',    // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
			
			allDaySlot: true,
			selectHelper: true,
			select: function(start, end, allDay) {
				//var title = prompt('Job Order no : ');
				if (title) {
					calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start,
							end: end,
							allDay: allDay,
							url:'www.google.co.th'
						},
						true // make the event "stick"
					);
				}
				calendar.fullCalendar('unselect'); //calendar.fullCalendar('unselect');
			},
			droppable: true,//droppable: true, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) { // this function is called when something is dropped

				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');

				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);

				// assign it the date that was reported
				copiedEventObject.start = date;
				copiedEventObject.allDay = allDay;

				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}

			},

			events: [
				
			<? 
				$sql2 = "SELECT  *  FROM new_po";
				$res2 = mysql_query($sql2,$conn);
				while($rs2=mysql_fetch_array($res2)) { ?>			
				<?
					switch($rs2[order_no]){
							
						case "SO66-07-050":	
					$total1='3000';
						break;
							
							
						default:	
					$total1=$rs2[r1q]+$rs2[r2q]+$rs2[r3q]+$rs2[r4q]+$rs2[r5q] ;
						break;	
					}
				?>
					<? 	$sql_io_sendate_chk= "SELECT  *  FROM in_out_senddate where order_no='$rs2[order_no]'";
						$res_io_sendate_chk = mysql_query($sql_io_sendate_chk,$conn);
						$rs_io_sendate_chk=mysql_fetch_array($res_io_sendate_chk);

											$art="";		
											$preexd=$rs2[art_name];
											$exd = explode(",", $preexd);
											for($iid=0;$iid<count($exd);$iid++)
											{
											$fid=$exd[$iid];
											$fid2= trim($fid);
											//$art=$art.'\n'.$fid2;
											$art=$art.$fid2;
											}
											$title_topic=$rs2[order_no];//.$rs2[art_name];
											$art_tmp=iconv( "TIS-620", "UTF-8",$art);
						?>
				// SEND PROOF	
			<? if($rs2[send_proof]!="0000-00-00"){ ?>	
				{					
					//id:999,
					title: '<? echo $rs2[order_no] ;?>\n<? echo "*** ส่งปรู๊ฟ  ***  ";?>',		
					start: new Date(<? echo substr($rs2[send_proof],0,4);?>,<? echo (substr($rs2[send_proof],5,2)*1)-1;?>,<?echo substr($rs2[send_proof],8,2);?>),					
					allDay: true,
					<? if($form_link!="mobile"){?>
					url:'../job_process/new_po_view.php?oid=<? echo $rs2[order_no];?>&form_link=job_calendar',
					<?;}?>
					className: 'info'
				},	
			<?;}?>
			<? if(!$rs_io_sendate_chk){ ?>
				{					
					//id:999,
					title:'<? echo $rs2[order_no];?>\n<? echo " - จำนวน ".number_format($total1,0,'.',',')." ".iconv( "TIS-620", "UTF-8",$rs2[r1unit]);?>',					
					start: new Date(<? echo substr($rs2[send_date],0,4);?>,<? echo (substr($rs2[send_date],5,2)*1)-1;?>,<?echo substr($rs2[send_date],8,2);?>),					
					allDay: true,
					<? if($form_link!="mobile"){?>
					url:'../job_process/new_po_view.php?oid=<? echo $rs2[order_no];?>&form_link=job_calendar',
					<?;}?>
					className: 'success'
				},		
					<? if($rs2[send_1]!="0000-00-00"){ ?>
						{					
							//id:999,
							title: '<? echo $rs2[order_no];?>\n<? echo " ส่งครั้งที่ 1 " ;?>',					
							start: new Date(<? echo substr($rs2[send_1],0,4);?>,<? echo (substr($rs2[send_1],5,2)*1)-1;?>,<?echo substr($rs2[send_1],8,2);?>),					
							allDay: true,
							<? if($form_link!="mobile"){?>
							url:'../job_process/new_po_view.php?oid=<? echo $rs2[order_no];?>&form_link=job_calendar',
							<?;}?>
							className: 'success'
				},
					<? ;} ?>
					<? ;} ?>
				
												<? ;} ?>
		<? 					
$sql_io_sendate2 = "SELECT  *  FROM in_out_senddate";
$res_io_sendate2 = mysql_query($sql_io_sendate2,$conn);
while($rs_io_sendate2=mysql_fetch_array($res_io_sendate2)) {		
							$sqlmax ="SELECT MAX(in_out_no) as max_id FROM in_out_senddate WHERE order_no = '$rs_io_sendate2[order_no]'";
							$cusmax = mysql_query($sqlmax,$conn);
							$rsmax= mysql_fetch_array($cusmax);
							$s_max = $rsmax[max_id];
							/*if($s_max==$rs_io_sendate2[in_out_no]){ */
							if(true){  ?>	
				{
					
					id:999,
				    title: '<? echo $rs_io_sendate2[order_no] ;?>\n<? echo " - จำนวน ".str_replace("จำนวน","",iconv( 'TIS-620', 'UTF-8',$rs_io_sendate2[t_quantity]));?>\n<? echo " เลื่อนส่ง " ; if ($rs_io_sendate2[in_out_no] !="1"){ echo "ครั้งที่ ".$rs_io_sendate2[in_out_no] ;};?>\n <? echo "จากวันที่ ". dmy_rong($rs_io_sendate2[f_date]);?>',
					start: new Date( <?echo substr($rs_io_sendate2[t_date],0,4)*1;?>,<?echo (substr($rs_io_sendate2[t_date],5,2)*1)-1;?>,<?echo substr($rs_io_sendate2[t_date],8,2)*1;?>),	
					allDay: true,
					<? if($form_link!="mobile"){?>
					url:'../job_process/new_po_view.php?oid=<? echo $rs_io_sendate2[order_no];?>&form_link=job_calendar',
					<?;}?>
					<? if($rs_io_sendate2[t_date]>$rs_io_sendate2[f_date]){ ?>
					className: 'important'
					<? ;} else {?>
					className: 'chill'
					<? ;}?>
				},			
				<? ;} ;} ?>
				{
					//title: 'TODAY',
					//start: new Date(y, m, d),
					//end: new Date(y, m, d),
					//url: 'http://google.com/',
					//className: 'success'
				}
			],
		});


	});

</script>
<style>

	body {
		margin-top: 10px;
		text-align: center;
		font-size: 14px;
		font-family: "Helvetica Nueue",Arial,Verdana,sans-serif;
		background-color: #DDDDDD;
		}

	#wrap {
		width:100%;
		margin: 0 auto;
		}

	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		text-align: left;
		}

	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
		}

	.external-event { /* try to mimick the look of a real event */
		margin: 10px 0;
		padding: 2px 4px;
		background: #3366CC;
		color: #fff;
		font-size: .85em;
		cursor: pointer;
		}

	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
		}

	#external-events p input {
		margin: 0;
		vertical-align: middle;
		}

	#calendar {
/* 		float: right; */
        margin: 0 auto;
		width: 100%;
		background-color: #FFFFFF;
		  border-radius: 6px;
        box-shadow: 0 1px 2px #C3C3C3;
		}

</style>
</head>

<body>
<?
if($form_link!="mobile"){?>
<div  align="left">
<img src="../image_header/Delivery_calendar_header.png">
</div>
<? ;} ?>
<div id='wrap'>

<div id='calendar'></div>

<div style='clear:both'></div>
</div>


</body>
</html>

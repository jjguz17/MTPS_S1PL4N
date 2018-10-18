<div id="calendar"></div>
<script>
	$('#calendar').fullCalendar({
		header: {
			right: 'today prev,next',
			center: 'title',
			left: ''
		},
		buttonText: {
			today : 'Hoy',
			month: 'Mes',
			agendaWeek: 'Semana',
			agendaDay: 'Día'
		},
		monthNamesShort : ['Enero' , 'Febrero' , 'Marzo' , 'Abril' , 'Mayo' , 'Junio' , 'Julio' , 'Agosto' , 'Septiembre' , 'Octubre' , 'Noviembre' , 'Diciembre' ],
		dayNamesShort : ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],  
		titleFormat : "MMM yyyy",  
		columnFormat:'ddd',  
		timeFormat: 'h:mm tt  - h:mm tt \n',  
		
		defaultView: 'month',
		editable: false,
		eventDurationEditable: false,
		eventStartEditable: false,
		droppable: false,
		selectHelper: false,
		slotMinutes: 60,
		selectable: false,
		minTime : 7,
		maxTime : 18,
		firstDay : 1,
		allDaySlot : false,
		weekends: false,
		defaultEventMinutes : 60,  
		dragOpacity: "0.5",		
		slotEventOverlap: false,	
		unselectAuto: false,
		weekMode : false,  
		
		events: [
			<?php
				$i=1;
				foreach($visita as $val) {
					$fecha=explode('-',$val['fecha']);
					if($i>1)
						echo ',';
					echo '{ id: "'.$val['fecha'].'", title: "'.$val['titulo'].'", start: new Date('.$fecha[0].','.($fecha[1]-1).','.$fecha[2].') }';
					$i++;
				}
			?>
		],
		
		dayClick: function(date, view) {
		},
		eventClick: function(event, jsEvent){	
			fecha_actual=event.id;		
			<?php if($como_mostrar==0) {?>		 
				modal("Programación del día",base_url()+'index.php/verificacion/calendario_dia/'+$("#id_empleado").val()+'/'+event.id);
			 <?php } else {?>		 
				$('#cont-calendario-dia').load(base_url()+'index.php/verificacion/calendario_dia/'+$("#id_empleado").val()+'/'+event.id);
			 <?php } ?>
			
		}
	});
</script>
@extends('layouts.backend.app')

@section('title', 'Calendar')

@push('css')
	<link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/adjust-select.css')}}"/>
	<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
		<style>
			.navbar {
	    	height: 46px !important;
			}
			.fc-toolbar .fc-state-active, .fc-toolbar .ui-state-active ,.fc-toolbar button:focus,.fc-toolbar button:hover {
			     z-index: 0 !important;
					 outline: inherit;
			}
			.fc-event{
				background-color: #ADE5FF ;
				border-color: #65B3D7 ;
			}
			.fc-widget-content:first-of-type, .fc-widget-header:first-of-type {
				border-left: .01rem solid #ccc !important;
				border-right: .01rem solid #ccc !important;
			}
		</style>
@endpush



@section('content')

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
	  <section class="content-header">

			<!-- /.container-fluid -->
		</section>
		<!-- Main content -->
		<section class="content">

			<div class="card">
				<div class="card-header bg-info">
					<i class="nav-icon fa fa-calendar"></i>	Event Calendar
				</div>
				<div class="card-body" >
					<div class="rounded border-dark">

						<div id="calendar" ></div>

					</div>
				</div>
			</div>

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

@endsection

@push('js')

		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
		<script>

		$(document).ready(function () {

		    $.ajaxSetup({
		        headers:{
		            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
		        }
		    });

		    var calendar = $('#calendar').fullCalendar({
		        editable:true,
		        header:{
		            left:'prev,next today',
		            center:'title',
		            right:'month,agendaWeek,agendaDay'
		        },
		        events:'events',
		        selectable:true,
		        selectHelper: true,
		        select:function(start, end, allDay)
		        {
							@if(Auth::user()->can('Calendar') || (Auth::user()->hasRole('admin')))
								var title = prompt('Add Event Title:');

		            if(title)
		            {
		                var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

		                var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

		                $.ajax({
		                    url:"events/action",
		                    type:"POST",
		                    data:{
		                        title: title,
		                        start: start,
		                        end: end,
		                        type: 'add'
		                    },
		                    success:function(data)
		                    {
		                        calendar.fullCalendar('refetchEvents');
		                        alert("Event Created Successfully");
		                    }
		                })
		            }
							@endif
						},
		        editable:true,
		        eventResize: function(event, delta)
		        {
							@if(Auth::user()->can('Calendar') || (Auth::user()->hasRole('admin')))
		            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
		            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
		            var title = event.title;
		            var id = event.id;
		            $.ajax({
		                url:"events/action",
		                type:"POST",
		                data:{
		                    title: title,
		                    start: start,
		                    end: end,
		                    id: id,
		                    type: 'update'
		                },
		                success:function(response)
		                {
		                    calendar.fullCalendar('refetchEvents');
		                    alert("Event Updated Successfully");
		                }
		            })
							@endif
						},
		        eventDrop: function(event, delta)
		        {
							@if(Auth::user()->can('Calendar') || (Auth::user()->hasRole('admin')))
		            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
		            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
		            var title = event.title;
		            var id = event.id;
		            $.ajax({
		                url:"events/action",
		                type:"POST",
		                data:{
		                    title: title,
		                    start: start,
		                    end: end,
		                    id: id,
		                    type: 'update'
		                },
		                success:function(response)
		                {
		                    calendar.fullCalendar('refetchEvents');
		                    alert("Event Updated Successfully");
		                }
		            })
							@endif
						},

		        eventClick:function(event)
		        {
							@if(Auth::user()->can('Calendar') || (Auth::user()->hasRole('admin')))
								if(confirm("Are you sure you want to remove it?"))
		            {
		                var id = event.id;
		                $.ajax({
		                    url:"events/action",
		                    type:"POST",
		                    data:{
		                        id:id,
		                        type:"delete"
		                    },
		                    success:function(response)
		                    {
		                        calendar.fullCalendar('refetchEvents');
		                        alert("Event Deleted Successfully");
		                    }
		                })

								}

							@endif
		        }
		    });

		});

		</script>
@endpush

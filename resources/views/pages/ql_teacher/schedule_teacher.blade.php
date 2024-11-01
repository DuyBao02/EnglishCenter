<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Calendar -->
                <div class="bg-indigo-200 rounded-sm my-4 mx-4">
                    <div class="container ">
                        <div class="response"></div>
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
      <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" /> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<style>
    .fc-left h2 {
        font-size: 30px; /* Đặt kích thước mong muốn ở đây */
    }

    .fc-content{
        color: black;
    }
</style>

<script>
    $(document).ready(function () {

        var SITEURL = "{{url('/')}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: "{{ route('calendarIndex') }}",
            displayEventTime: true,
            editable: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            // select: function (start, end, allDay) {
            //     var title = prompt('Event Title:');

            //     if (title) {
            //         var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
            //         var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

            //         $.ajax({
            //             url: SITEURL + "fullcalendar/create",
            //             data: 'title=' + title + '&start=' + start + '&end=' + end,
            //             type: "POST",
            //             success: function (data) {
            //                 displayMessage("Added Successfully");
            //             }
            //         });
            //         calendar.fullCalendar('renderEvent',
            //                 {
            //                     title: title,
            //                     start: start,
            //                     end: end,
            //                     allDay: allDay
            //                 },
            //         true
            //                 );
            //     }
            //     calendar.fullCalendar('unselect');
            // },

            // eventDrop: function (event, delta) {
            //             var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
            //             var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
            //             $.ajax({
            //                 url: SITEURL + 'fullcalendar/update',
            //                 data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
            //                 type: "POST",
            //                 success: function (response) {
            //                     displayMessage("Updated Successfully");
            //                 }
            //             });
            //         },

            // eventClick: function (event) {
            //     var deleteMsg = confirm("Hiển thị thông tin khóa học của ngày tương ứng");
            //     if (deleteMsg) {
            //         $.ajax({
            //             type: "POST",
            //             url: SITEURL + 'fullcalendar/delete',
            //             data: "&id=" + event.id,
            //             success: function (response) {
            //                 if(parseInt(response) > 0) {
            //                     $('#calendar').fullCalendar('removeEvents', event.id);
            //                     displayMessage("Deleted Successfully");
            //                 }
            //             }
            //         });
            //     }
            // }

        });
    });

    function displayMessage(message) {
        $(".response").html("<div class='success'>"+message+"</div>");
        setInterval(function() { $(".success").fadeOut(); }, 1000);
    }
</script>

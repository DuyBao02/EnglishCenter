<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms & Lessons Custom') }}
        </h2>
    </x-slot>

    @if (Session::has('success'))
        <script>
        window.onload = function() {
            swal('Success', '{{ Session::get('success') }}', 'success',{
                button:true,
                button:'OK',
                timer:5000,
            });
        }
        </script>
    @endif
    @if (Session::has('error'))
        <script>
        window.onload = function() {
            swal('Error', '{{ Session::get('error') }}', 'error',{
                button:true,
                button:'OK',
                timer:5000,
            });
        }
        </script>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center text-3xl">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Lesson form --> 
                        <div class="bg-red-200 max-h-72 overflow-hidden shadow-sm sm:rounded-lg col-span-2 sm:col-span-1">
                            <div class="text-lg mt-2">Add new Lesson</div>
                            <form action="{{ route('lesson-custom-store') }}" method="POST" class="flex flex-col items-center my-auto">
                                @csrf
                                <div class="mt-4 flex items-center justify-center w-full">
                                    <label for="id_lesson" class="block text-sm font-medium text-gray-700 mr-2">ID Lesson</label>
                                    <input required type="text" id="id_lesson" name="id_lesson" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                        
                                <div class="mt-4 flex items-center justify-center w-full">
                                    <label for="start_time" class="block text-sm font-medium text-gray-700 mr-2">Time Start</label>
                                    <input required type="time" id="start_time" name="start_time" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                        
                                <div class="mt-4 flex items-center justify-center w-full">
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 mr-2">Time End</label>
                                    <input required type="time" id="end_time" name="end_time" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                        
                                <div class="my-4 flex items-center justify-center w-full">
                                    <x-primary-button type="reset" class="mr-4">
                                        {{ __('Refresh') }}
                                    </x-primary-button>
                                    <x-primary-button type="submit">
                                        {{ __('Save') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                        <!-- Lesson data -->
                        <div class="w-full overflow-hidden rounded-lg shadow-xs col-span-2 sm:col-span-1">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full whitespace-nowrap">
                                    <thead>
                                        <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">Time Start</th>
                                        <th class="px-4 py-3">Time End</th>
                                        <td class="px-4 py-3"></td>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y">
                                        @if(isset($lessons))
                                            @foreach ($lessons as $l)
                                            <!-- Table data  -->
                                                <tr class="text-base font-medium tracking-wide text-left text-gray-500 border-b bg-gray-50">
                                                <td class="px-4 py-3">{{ $l->id_lesson }}</td>
                                                <td class="px-4 py-3">{{ $l->start_time }}</td>
                                                <td class="px-4 py-3">{{ $l->end_time }}</td>
                                                
                                                <td class="px-4 py-3 relative my-4">
                                                    <a type="buttom" class="hover:text-red-500 mr-4" href="{{ route('lesson-edit', $l->id_lesson) }}">
                                                        <img class="h-6 w-6 inline-block" src="images/edit.png" alt="">
                                                    </a> 
                                                    <form action="{{ route('lesson-custom-destroy', $l->id_lesson) }}" method="POST" onsubmit="confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="hover:text-red-500" onclick="confirmDeleteLesson(event, '{{ route('lesson-custom-destroy', $l->id_lesson) }}')">
                                                            <img class="h-6 w-6 inline-block" src="images/trash.png" alt="">
                                                        </button>
                                                    </form>
                                                </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <!-- Room form -->
                        <div class="bg-red-200 max-h-56 overflow-hidden shadow-sm sm:rounded-lg col-span-2 sm:col-span-1">
                            <div class="text-lg mt-2">Add new Room</div>
                            <form action="{{ route('room-custom-store') }}" method="POST" class="flex flex-col items-center my-auto">
                                @csrf
                                <div class="mt-4 flex items-center justify-center w-full">
                                    <label for="id_room" class="block text-sm font-medium text-gray-700 mr-2">ID Room</label>
                                    <input required type="text" id="id_room" name="id_room" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                        
                                <div class="mt-4 flex items-center justify-center w-full">
                                    <label for="name_room" class="block text-sm font-medium text-gray-700 mr-2">Name</label>
                                    <input required type="text" id="name_room" name="name_room" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                        
                                <div class="my-4 flex items-center justify-center w-full">
                                    <x-primary-button type="reset" class="mr-4">
                                        {{ __('Refresh') }}
                                    </x-primary-button>
                                    <x-primary-button type="submit">
                                        {{ __('Save') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Room Data -->
                        <div class="w-full overflow-hidden rounded-lg shadow-xs col-span-2 sm:col-span-1">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full whitespace-nowrap">
                                    <thead>
                                        <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">Name Room</th>
                                        <td class="px-4 py-3"></td>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y">
                                        @if(isset($rooms))
                                            @foreach ($rooms as $r)
                                            <!-- Table data  -->
                                                <tr class="text-base font-medium tracking-wide text-left text-gray-500 border-b bg-gray-50">
                                                <td class="px-4 py-3">{{ $r->id_room }}</td>
                                                <td class="px-4 py-3">{{ $r->name_room }}</td>
                                                <td class="px-4 py-3 relative my-4">
                                                    <a type="buttom" class="hover:text-red-500 mr-4" href="{{ route('room-edit', $r->id_room) }}">
                                                        <img class="h-6 w-6 inline-block" src="images/edit.png" alt="">
                                                    </a> 
                                                    <form action="{{ route('room-custom-destroy', $r->id_room) }}" method="POST" onsubmit="confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="hover:text-red-500" onclick="confirmDeleteRoom(event, '{{ route('room-custom-destroy', $r->id_room) }}')">
                                                            <img class="h-6 w-6 inline-block" src="images/trash.png" alt="">
                                                        </button>
                                                    </form>    
                                                </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    //Autofill start_time or end_time
    document.getElementById('start_time').addEventListener('input', function (e) {
        var startTime = new Date('1970-01-01T' + e.target.value + 'Z');
        var endTime = new Date(startTime.getTime() + 120*60000);
        var endTimeStr = endTime.toISOString().substr(11, 5);
        document.getElementById('end_time').value = endTimeStr;
    });

    document.getElementById('end_time').addEventListener('input', function (e) {
        var endTime = new Date('1970-01-01T' + e.target.value + 'Z');
        var startTime = new Date(endTime.getTime() - 120*60000);
        var startTimeStr = startTime.toISOString().substr(11, 5);
        document.getElementById('start_time').value = startTimeStr;
    });
    
    //ConfirmDeleteRoom
    function confirmDeleteRoom(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this room!",
            icon: "warning",
            buttons: true,
            timer: 5000,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                deleteRoom(route);
            }
        });
    }

    //ConfirmDeleteLesson
    function confirmDeleteLesson(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this lesson!",
            icon: "warning",
            buttons: true,
            timer: 5000,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                deleteLesson(route);
            }
        });
    }

    function deleteLesson(route) {
        fetch(route, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                swal("Poof! Lesson has been deleted!", {
                    icon: "success",
                    timer: 5000,
                    buttons: {
                        confirm: {
                            text: "OK",
                            value: true,
                            visible: true,
                            closeModal: true
                        }
                    }
                })
                .then((value) => {
                    // Reload the page when user clicks on OK or after 5 seconds
                    if (value) {
                        location.reload();
                    } else {
                        setTimeout(function() {
                            location.reload();
                        }, 5000);
                    }
                });
            } else {
                swal("Oops! Something went wrong, please refresh your website!", {
                    icon: "error",
                    timer: 5000,
                });
            }
        });
    }

    function deleteRoom(route) {
        fetch(route, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                swal("Poof! Room has been deleted!", {
                    icon: "success",
                    timer: 5000,
                    buttons: {
                        confirm: {
                            text: "OK",
                            value: true,
                            visible: true,
                            closeModal: true
                        }
                    }
                })
                .then((value) => {
                    // Reload the page when user clicks on OK or after 5 seconds
                    if (value) {
                        location.reload();
                    } else {
                        setTimeout(function() {
                            location.reload();
                        }, 5000);
                    }
                });
            } else {
                swal("Oops! Something went wrong, please refresh your website!", {
                    icon: "error",
                    timer: 5000,
                });
            }
        });
    }
</script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Custom') }}
        <a
            type="button"
            class="text-center transition ease-in-out delay-50 hover:-translate-y-1 hover:scale-110 duration-300 w-16 ml-4 text-white bg-emerald-600 hover:bg-emerald-800 rounded-lg"
            href="{{ route('create-course') }}">
            ADD
        </a>
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
                <div class="my-4 mx-4 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Time Start</th>
                                    <th class="px-4 py-3">Weeks</th>
                                    <th class="px-4 py-3">Student</th>
                                    <th class="px-4 py-3">Tuition Fee</th>
                                    <th class="px-4 py-3">Days</th>
                                    <th class="px-4 py-3">Lesson</th>
                                    <th class="px-4 py-3">Room</th>
                                    <th class="px-4 py-3">Teacher</th>
                                    <th class="px-4 py-3">Student List</th>
                                    <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($courses))
                                        @foreach ($courses as $c)
                                            <tr>
                                                <!-- Table data  -->
                                                <td class="px-4 py-3">{{ $c->id_course }}</td>
                                                <td class="px-4 py-3">{{ $c->name_course }}</td>
                                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($c->time_start)->format('d-m-Y') }}<br></td>
                                                <td class="px-4 py-3">{{ $c->weeks }}</td>
                                                <td class="px-4 py-3">{{ count($c->students_list) }} / {{ $c->maxStudents }}</td>
                                                <td class="px-4 py-3">{{ number_format($c->tuitionFee) }}</td>
                                                <td class="px-4 py-3">
                                                    @if (is_array($c->days))
                                                        @foreach($c->days as $day)
                                                            {{ $day }}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if (is_array($c->lessons))
                                                        @foreach($c->lessons as $lesson)
                                                            {{ $lesson }}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if (is_array($c->rooms))    
                                                        @foreach($c->rooms as $room)
                                                            {{ $room }}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if ($c->teacherUser)
                                                        {{ $c->teacherUser->name }}
                                                    @else
                                                        Chưa có
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <a class="hover:text-red-500" href="{{ route('student-list-a', ['courseID' => $c->id_course]) }}">View Students</a>
                                                </td>
                                                <td class="px-1 py-3 relative my-4">
                                                    <button class="dropdownButton text-blue-500 hover:text-blue-700 mr-2">
                                                        <img src="images/down-arrow.png" class="h-6 w-6" alt="">
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr class="dropdownMenu rounded-full origin-top-right absolute right-44 w-1/2 h-7 mx-auto shadow-lg bg-blue-300 ring-1 ring-black ring-opacity-5 hidden z-50">
                                                <td colspan="12" class="flex justify-around">
                                                    <a class="hover:text-red-500" href="#" onclick="confirmPublicTeacher
                                                        (event, '{{ route('public-to-teacher', $c->id_course) }}')">Public to Teacher</a>

                                                    <a class="hover:text-red-500" href="#" onclick="confirmPublicStudent
                                                        (event, '{{ route('public-to-student', $c->id_course) }}')">Public to Students</a>

                                                    <a type="buttom" class="hover:text-red-500 mr-4" href="{{ route('course-edit', $c->id_course) }}">Edit</a> 

                                                    <form action="{{ route('course-custom-destroy', $c->id_course) }}" method="POST" onsubmit="confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="hover:text-red-500" onclick="confirmDelete(event, '{{ route('course-custom-destroy', $c->id_course) }}')">Delete</button>
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
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    //Confirm register course for teacher
    function confirmPublicTeacher(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Do you want to public to teacher for this course?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willRegister) => {
            if (willRegister) {
                window.location.href = route;
            }
        });
    }

    //Confirm register course for student
    function confirmPublicStudent(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Do you want to public to student for this course?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willRegister) => {
            if (willRegister) {
                window.location.href = route;
            }
        });
    }

    //Dropdown action for course_admin
    var dropdownButtons = document.getElementsByClassName('dropdownButton');
    var currentOpenDropdown = null; // Store the currently open dropdown

    for (var i = 0; i < dropdownButtons.length; i++) {
        dropdownButtons[i].addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent this click from triggering the document click event handler
            var dropdownMenu = this.parentNode.parentNode.nextElementSibling;
            if (dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.remove('hidden');
                // If there is a dropdown currently open, close it
                if (currentOpenDropdown && currentOpenDropdown !== dropdownMenu) {
                    currentOpenDropdown.classList.add('hidden');
                }
                // Update the currently open dropdown
                currentOpenDropdown = dropdownMenu;
            } else {
                dropdownMenu.classList.add('hidden');
                // If the dropdown is closed, clear the currently open dropdown
                if (currentOpenDropdown === dropdownMenu) {
                    currentOpenDropdown = null;
                }
            }
        });
    }

    // Add event listener to the document
    document.addEventListener('click', function(event) {
        var dropdownMenus = document.getElementsByClassName('dropdownMenu');
        for (var i = 0; i < dropdownMenus.length; i++) {
            if (!dropdownMenus[i].contains(event.target)) {
                dropdownMenus[i].classList.add('hidden');
            }
        }
        // If the click is outside, clear the currently open dropdown
        currentOpenDropdown = null;
    });

    //Delete Course
    function confirmDelete(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this course!",
            icon: "warning",
            buttons: true,
            timer: 5000,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                deleteCourse(route);
            }
        });
    }
    
    function deleteCourse(route) {
        fetch(route, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                swal("Poof! Course has been deleted!", {
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
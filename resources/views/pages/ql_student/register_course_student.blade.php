<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register Courses') }}
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

    <!-- Display teacher information -->
    <div id="teacherModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 border-b-2 border-gray-500" id="modal-title">
                                Teacher Information
                            </h3>
                            <div class="mt-4">
                                <p class="text-sm text-gray-500" id="teacherInfo">
                                    <!-- Teacher information will be inserted here -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="my-8 mx-8 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
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
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($course3))
                                        @foreach($course3 as $c)
                                            <tr>
                                                <td class="px-4 py-3">{{ $c->id_3course }}</td>
                                                <td class="px-4 py-3">{{ $c->name_course }}</td>
                                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($c->time_start)->format('d-m-Y') }}<br></td>
                                                <td class="px-4 py-3">{{ $c->weeks }}</td>
                                                <td class="px-4 py-3">{{ count($c->students_list) }} / {{ $c->maxStudents }}</td>
                                                <td class="px-4 py-3">{{ number_format($c->tuitionFee) }}</td>
                                                <td class="px-4 py-3">
                                                    @if(is_array($c->days))
                                                        @foreach($c->days as $day)
                                                            {{ $day }}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if(is_array($c->lessons))
                                                        @foreach($c->lessons as $lesson)
                                                            {{ $lesson }}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if(is_array($c->rooms))    
                                                        @foreach($c->rooms as $room)
                                                            {{ $room }}<br>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    @if($c->teacherUser3)
                                                        <div class="flex items-center">
                                                            <a class="hover:text-red-500" href="javascript:void(0)" onclick="showTeacherInfo({{ json_encode($c->teacherUser3) }})">
                                                            <img class="h-9 w-9 transform transition-transform duration-400 hover:scale-150" src="images/teacher.png" alt=""><span>{{ $c->teacherUser3->name }}</span></a>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center">
                                                            <img src="images/sand-clock.png" class="h-9 w-9" alt="">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 relative my-4">
                                                    @if (count($c->students_list) <= $c->maxStudents && !empty(array_filter($c->students_list, function ($student)  { 
                                                        return $student == Auth::user()->id; 
                                                    })))
                                                        <div class="flex items-center">
                                                            <img src="images/checkbox.png" class="h-7 w-7" alt="">
                                                        </div>
                                                    @elseif (count($c->students_list) < $c->maxStudents && empty(array_filter($c->students_list, function ($student)  { 
                                                        return $student == Auth::user()->id; 
                                                    })))
                                                        <div class="flex items-center">
                                                            <a class="hover:text-red-500" href="#" onclick="confirmRegister(event, '{{ route('register-course-student', ['userId' => Auth::user()->id, 'courseId' => $c->id_3course]) }}')">
                                                            <img class="h-9 w-9 transform transition-transform duration-400 hover:scale-150" src="images/document.png" alt=""><span>Register</span></a>
                                                        </div>
                                                    @elseif (count($c->students_list) == $c->maxStudents)
                                                        <span class="text-red-500">Course is full</span>
                                                    @endif
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
    // confirmRegister
    function confirmRegister(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Do you want to register for this course?",
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
    
    //showTeacherInfo
    function showTeacherInfo(teacher) {
        var birthday = new Date(teacher.birthday);
        var formattedBirthday = birthday.getDate() + '-' + (birthday.getMonth() + 1) + '-' + birthday.getFullYear();
        var info = 'Name: ' + teacher.name + '\n' +
                   'Email: ' + teacher.email + '\n' +
                   'Gender: ' + teacher.gender + '\n' +
                   'Birthday: ' + formattedBirthday + '\n' +
                   'Address: ' + teacher.address + '\n' +
                   'Phone: 0' + teacher.phone;
        document.getElementById('teacherInfo').innerText = info;
        document.getElementById('teacherModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('teacherModal').classList.add('hidden');
    }
    
</script>
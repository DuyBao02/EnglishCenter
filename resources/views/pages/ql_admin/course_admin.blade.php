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

    <!-- Zoom in avatar -->
    <div id="avatarModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="mt-4">
                                <img id="avatarImage" src="" alt="Teacher Avatar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeAvatarModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                                                    @if($c->teacherUser)
                                                        <div class="flex flex-col items-center">
                                                            <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150" src="{{ asset('images/avatars/'.$c->teacherUser->avatar) }}" alt="{{ $c->teacherUser->name }}" onclick="showAvatar('{{ asset('images/avatars/'.$c->teacherUser->avatar) }}')">
                                                            <a class="hover:text-red-500" href="javascript:void(0)" onclick="showTeacherInfo({{ json_encode($c->teacherUser) }})">
                                                            <span>{{ $c->teacherUser->name }}</span></a>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center">
                                                            <img src="images/sand-clock.png" class="h-9 w-9" alt="">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    <a class="hover:text-red-500" href="{{ route('student-list-a', ['courseID' => $c->id_course]) }}"><img class="h-12 w-12 transform transition-transform duration-400 hover:scale-150" src="images/customer.png" alt=""></a>
                                                </td>
                                                <td class="px-1 py-3 relative my-4">
                                                    <button class="dropdownButton text-blue-500 hover:text-blue-700 mr-2">
                                                        <img src="images/down-arrow.png" class="h-6 w-6" alt="">
                                                    </button>
                                                </td>
                                            </tr>
                                            
                                            <tr class="dropdownMenu rounded-full origin-top-right absolute right-44 w-1/2 h-7 mx-auto shadow-lg bg-yellow-200 ring-1 ring-black ring-opacity-5 hidden z-50">
                                                <td colspan="12" class="flex justify-around">
                                                    @if (in_array($c->id_course, $secondCourses))
                                                        <div class="inline-flex items-center mb-4">
                                                            <img class="h-6 w-6" src="images/checkbox.png" alt="">
                                                            <a class="hover:text-red-500 ml-1" href="#" onclick="confirmPublicTeacher(event, '{{ route('public-to-teacher', $c->id_course) }}')">Public to Teacher</a>
                                                        </div>
                                                    @else
                                                    <a class="hover:text-red-500 ml-1" href="#" onclick="confirmPublicTeacher(event, '{{ route('public-to-teacher', $c->id_course) }}')">Public to Teacher</a>
                                                    @endif

                                                    @if (in_array($c->id_course, $thirdCourses))
                                                        <div class="inline-flex items-center mb-4">
                                                            <img class="h-6 w-6" src="images/checkbox.png" alt="">
                                                            <a class="hover:text-red-500 ml-1" href="#" onclick="confirmPublicStudent(event, '{{ route('public-to-student', $c->id_course) }}')">Public to Students</a>
                                                        </div>
                                                    @else
                                                        <a class="hover:text-red-500 ml-1" href="#" onclick="confirmPublicStudent(event, '{{ route('public-to-student', $c->id_course) }}')">Public to Students</a>
                                                    @endif
                                                
                                                    <a type="buttom" class="hover:text-red-500 mr-4 inline-flex items-center mb-4 transform transition-transform duration-400 hover:scale-150" href="{{ route('course-edit', $c->id_course) }}">
                                                        <img class="h-6 w-6 inline-block" src="images/edit.png" alt="">
                                                        <span >Edit</span>
                                                    </a> 

                                                    <a type="buttom" class="mb-4 hover:text-red-500 inline-flex items-center transform transition-transform duration-400 hover:scale-150"
                                                        x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $c->id_course }}')">
                                                        <img class="h-6 w-6 inline-block" src="images/trash.png" alt="">
                                                        <span>Delete</span>
                                                    </a>
                                                    <x-modal name="confirm-user-deletion-{{ $c->id_course }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                        <form method="post" action="{{ route('course-custom-destroy', $c->id_course) }}" class="p-6">
                                                            @csrf
                                                            @method('delete')

                                                            <h2 class="text-lg font-medium text-gray-900">
                                                                {{ __('Are you sure you want to delete ') }}{{ $c->name_course }} ?
                                                            </h2>

                                                            <p class="mt-1 text-sm text-gray-600">
                                                                {{ __('Once this course is deleted, all of its resources and data will be permanently deleted.') }}</br>
                                                                {{ __('Please enter your password to confirm you would like to permanently delete your account.') }}
                                                            </p>

                                                            <div class="mt-6">
                                                                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                                                                <x-text-input
                                                                    id="password"
                                                                    name="password"
                                                                    type="password"
                                                                    class="mt-1 block w-3/4"
                                                                    placeholder="{{ __('Password') }}"
                                                                />

                                                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                                            </div>

                                                            <div class="mt-6 flex justify-end">
                                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                                    {{ __('Cancel') }}
                                                                </x-secondary-button>

                                                                <x-danger-button class="ml-3">
                                                                    {{ __('Delete Account') }}
                                                                </x-danger-button>
                                                            </div>
                                                        </form>
                                                    </x-modal>
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
    
    //showTeacherInfo
    function showTeacherInfo(teacher) {
        var birthday = new Date(teacher.birthday);
        var formattedBirthday = birthday.getDate() + '-' + (birthday.getMonth() + 1) + '-' + birthday.getFullYear();
        var info = 'Email: ' + teacher.email + '\n' +
                   'Gender: ' + teacher.gender + '\n' +
                   'Level: ' + teacher.level + '\n' +
                   'Experience: ' + teacher.experience + ' years' + '\n' + 
                   'Address: ' + teacher.address + '\n' +
                   'Phone: 0' + teacher.phone;
        document.getElementById('teacherInfo').innerText = info;
        document.getElementById('teacherModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('teacherModal').classList.add('hidden');
    }

    //Zoom in avatar
    function showAvatar(imageSrc, teacherName) {
        document.getElementById('avatarImage').src = imageSrc;
        document.getElementById('avatarModal').classList.remove('hidden');
    }
    
    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
    }

</script>
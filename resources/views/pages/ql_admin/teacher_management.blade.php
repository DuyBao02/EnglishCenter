<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Management') }}
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
                            <h3 class="text-lg leading-6 font-medium text-gray-900 border-b-2 border-gray-500" id="modal-title">
                                <!-- Teacher Name -->
                            </h3>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="my-4 mx-4 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <div class="mb-4">
                                Total Teacher: {{ $totalTeachers }}
                            </div>
                            <table class="w-full whitespace-nowrap table-auto" name=hasregistered>
                                <caption class="caption-top mb-2 font-semibold text-xl text-gray-800">
                                    Has registered course: {{ $registeredTeachers->count() }}
                                </caption>
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">AVATAR</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Gender</th>
                                    <th class="px-4 py-3">Birthday</th>
                                    <th class="px-4 py-3">Address</th>
                                    <th class="px-4 py-3">Phone</th>
                                    <th class="px-4 py-3">Course</th>
                                    <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach($registeredTeachers as $teacher)
                                        <tr>
                                            <!-- Table data  -->
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3">
                                               <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150" src="{{ asset('images/avatars/'.$teacher->avatar) }}" alt="{{ $teacher->name }}" onclick="showAvatar('{{ asset('images/avatars/'.$teacher->avatar) }}', '{{ $teacher->name }}')">
                                            </td>
                                            <td class="px-4 py-3">{{ $teacher->name }}</td>
                                            <td class="px-4 py-3">{{ $teacher->email }}</td>
                                            <td class="px-4 py-3">{{ $teacher->gender }}</td>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($teacher->birthday)->format('d-m-Y') }}</td>
                                            <td class="px-4 py-3">{{ $teacher->address }}</td>
                                            <td class="px-4 py-3">{{ $teacher->phone }}</td>
                                            <td class="px-4 py-3">
                                                @if($teacher->registeredCourseTeacher())
                                                    @foreach($teacher->registeredCourseTeacher() as $courseName)
                                                        <div class="my-1">{{ $courseName }}<br></div>
                                                    @endforeach
                                                @else
                                                    No registered courses
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($teacher->registeredCourseTeacher() as $courseName)
                                                    <form action="" method="POST" onsubmit="confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="hover:text-red-500 my-1" onclick="confirmDeleteTeacher(event, '{{ route('teacher-deleteCourse', ['userId' => $teacher->id, 'courseName' => $courseName]) }}')">
                                                            <img class="h-6 w-6 inline-block" src="images/trash.png" alt="">
                                                        </button>
                                                    </form>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table class="w-full whitespace-nowrap table-auto mt-8 name=hasnotregistered">
                                <caption class="caption-top mb-2 font-semibold text-xl text-gray-800">
                                    Has not registered course: {{ $notRegisteredTeachers->count() }}
                                </caption>
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">AVATAR</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Gender</th>
                                    <th class="px-4 py-3">Birthday</th>
                                    <th class="px-4 py-3">Address</th>
                                    <th class="px-4 py-3">Phone</th>
                                    <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach($notRegisteredTeachers as $teacher)
                                        <tr>
                                            <!-- Table data  -->
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3">
                                                <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150" src="{{ asset('images/avatars/'.$teacher->avatar) }}" alt="{{ $teacher->name }}" onclick="showAvatar('{{ asset('images/avatars/'.$teacher->avatar) }}', '{{ $teacher->name }}')">
                                            </td>
                                            <td class="px-4 py-3">{{ $teacher->name }}</td>
                                            <td class="px-4 py-3">{{ $teacher->email }}</td>
                                            <td class="px-4 py-3">{{ $teacher->gender }}</td>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($teacher->birthday)->format('d-m-Y') }}</td>
                                            <td class="px-4 py-3">{{ $teacher->address }}</td>
                                            <td class="px-4 py-3">{{ $teacher->phone }}</td>
                                            <td>
                                                <x-danger-button
                                                    x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $teacher->id }}')">{{ __('Delete Account') }}
                                                </x-danger-button>
                                                
                                                <x-modal name="confirm-user-deletion-{{ $teacher->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                    <form method="post" action="{{ route('confirm-delete', $teacher->id) }}" class="p-6">
                                                        @csrf
                                                        @method('delete')

                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Are you sure you want to delete your account?') }}
                                                        </h2>

                                                        <p class="mt-1 text-sm text-gray-600">
                                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</br>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
      <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    //Zoom in avatar
    function showAvatar(imageSrc, teacherName) {
        document.getElementById('avatarImage').src = imageSrc;
        document.getElementById('modal-title').innerText = teacherName;
        document.getElementById('avatarModal').classList.remove('hidden');
    }
    
    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
    }

    //confirmDeleteTeacher
    function confirmDeleteTeacher(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, this user will be removed from the course!",
            icon: "warning",
            buttons: true,
            timer: 5000,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                deleteTeacher(route);
            }
        });
    }

    function deleteTeacher(route) {
        fetch(route, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                swal("Poof! Teacher has been removed from the course!", {
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
            }
            else if (data.error) {
                swal(data.error, {
                    title: "Error",
                    icon: "error",
                    timer: 5000,
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
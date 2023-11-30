<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Management') }}
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
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
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

    <form action="" method="" class="flex items-center space-x-4 mx-4 lg:mx-0 lg:float-right lg:px-40 mt-4">
        <input type="search" name="search" id="" value="{{ $search }}" placeholder="Search by name, role, email, birthday, add, tel" class="border p-2 px-4 rounded-full w-96 focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
        <button type="" class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-full">Search</button>
        <a href="{{ route('users-management') }}">
            <button type="button" class="bg-gray-300 hover:bg-gray-200 px-4 py-2 rounded-full">Reset</button>
        </a>
    </form>

    <div class="pt-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-400 overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Searching User -->
                <div class="my-8 mx-4 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">@sortablelink('id')</th>
                                        <th class="px-4 py-3">AVATAR</th>
                                        <th class="px-4 py-3">@sortablelink('name')</th>
                                        <th class="px-4 py-3">@sortablelink('role')</th>
                                        <th class="px-4 py-3">@sortablelink('email')</th>
                                        <th class="px-4 py-3">@sortablelink('gender')</th>
                                        <th class="px-4 py-3">@sortablelink('birthday')</th>
                                        <th class="px-4 py-3">@sortablelink('address')</th>
                                        <th class="px-4 py-3">@sortablelink('phone')</th>
                                        <th class="px-4 py-3">@sortablelink('created_at')</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach($search_user as $su)
                                        <tr>
                                            <!-- Table data  -->
                                            <td class="px-4 py-3">{{ $su->id }}</td>
                                            <td class="px-4 py-3">
                                            <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150" src="{{ asset('images/avatars/'.$su->avatar) }}" alt="{{ $su->name }}" onclick="showAvatar('{{ asset('images/avatars/'.$su->avatar) }}', '{{ $su->name }}')">
                                            </td>
                                            <td class="px-4 py-3">{{ $su->name }}</td>
                                            <td class="px-4 py-3">{{ $su->role }}</td>
                                            <td class="px-4 py-3">{{ $su->email }}</td>
                                            <td class="px-4 py-3">{{ $su->gender }}</td>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($su->birthday)->format('d-m-Y') }}</td>
                                            <td class="px-4 py-3">{{ $su->address }}</td>
                                            <td class="px-4 py-3">{{ $su->phone }}</td>
                                            <th class="px-4 py-3">{{ $su->created_at }}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $search_user->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Admin Management -->
                <div class="my-8 mx-4 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <div class="mb-4" id='admins'>
                                Total Admins: {{ $totalAdmins }}
                            </div>
                            <table class="w-full whitespace-nowrap table-auto">
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach($admins as $admin)
                                        <tr>
                                            <!-- Table data  -->
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3">
                                               <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150" src="{{ asset('images/avatars/'.$admin->avatar) }}" alt="{{ $admin->name }}" onclick="showAvatar('{{ asset('images/avatars/'.$admin->avatar) }}', '{{ $admin->name }}')">
                                            </td>
                                            <td class="px-4 py-3">{{ $admin->name }}</td>
                                            <td class="px-4 py-3">{{ $admin->email }}</td>
                                            <td class="px-4 py-3">{{ $admin->gender }}</td>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($admin->birthday)->format('d-m-Y') }}</td>
                                            <td class="px-4 py-3">{{ $admin->address }}</td>
                                            <td class="px-4 py-3">{{ $admin->phone }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Teacher Management -->
                <div class="my-8 mx-4 sm:rounded-lg mt-20">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <div class="mb-4" id='teachers'>
                                Total Teachers: {{ $totalTeachers }}
                            </div>
                            <table class="w-full whitespace-nowrap table-auto" name=hasregistered>
                                <caption class="caption-top mb-2 font-semibold text-xl text-gray-800">
                                    Teachers have registered course: {{ $registeredTeachers->count() }}
                                </caption>
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-2 py-3">ID</th>
                                        <th class="px-2 py-3">AVATAR</th>
                                        <th class="px-2 py-3">Name</th>
                                        <th class="px-2 py-3">Level</th>
                                        <th class="px-2 py-3">Exp</th>
                                        <th class="px-2 py-3">Email</th>
                                        <th class="px-2 py-3">Gender</th>
                                        <th class="px-2 py-3">Birthday</th>
                                        <th class="px-2 py-3">Address</th>
                                        <th class="px-2 py-3">Phone</th>
                                        <th class="px-2 py-3">Course</th>
                                        <th class="px-2 py-3"></th>
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
                                            <td class="px-4 py-3">{{ $teacher->level }}</td>
                                            <td class="px-4 py-3">{{ $teacher->experience }} Ys</td>
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
                                    Teachers have not registered course: {{ $notRegisteredTeachers->count() }}
                                </caption>
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-2 py-3">ID</th>
                                        <th class="px-2 py-3">AVATAR</th>
                                        <th class="px-2 py-3">Name</th>
                                        <th class="px-2 py-3">Level</th>
                                        <th class="px-2 py-3">Exp</th>
                                        <th class="px-2 py-3">Email</th>
                                        <th class="px-2 py-3">Gender</th>
                                        <th class="px-2 py-3">Birthday</th>
                                        <th class="px-2 py-3">Address</th>
                                        <th class="px-2 py-3">Phone</th>
                                        <th class="px-2 py-3"></th>
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
                                            <td class="px-4 py-3">{{ $teacher->level }}</td>
                                            <td class="px-4 py-3">{{ $teacher->experience }} Ys</td>
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
                                                            {{ __('Are you sure you want to delete this account?') }}
                                                        </h2>

                                                        <p class="mt-1 text-sm text-gray-600">
                                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</br>
                                                            {{ __('Please enter your password to confirm you would like to permanently delete this account.') }}
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

                <!-- Student Management -->
                <div class="my-8 mx-4 sm:rounded-lg mt-20">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <div class="mb-4" id='students'>
                                Total Students: {{ $totalStudents }}
                            </div>
                            <table class="w-full whitespace-nowrap table-auto" name=hasregistered>
                                <caption class="caption-top mb-2 font-semibold text-xl text-gray-800">
                                    Students have registered course: {{ $registeredStudents->count() }}
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
                                    <th class="px-4 py-3">IsPaid</th>
                                    <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach($registeredStudents as $student)
                                        <tr>
                                            <!-- Table data  -->
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3">
                                                <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150" src="{{ asset('images/avatars/'.$student->avatar) }}" alt="{{ $student->name }}" onclick="showAvatar('{{ asset('images/avatars/'.$student->avatar) }}', '{{ $student->name }}')">
                                            </td>
                                            <td class="px-4 py-3">{{ $student->name }}</td>
                                            <td class="px-4 py-3">{{ $student->email }}</td>
                                            <td class="px-4 py-3">{{ $student->gender }}</td>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($student->birthday)->format('d-m-Y') }}</td>
                                            <td class="px-4 py-3">{{ $student->address }}</td>
                                            <td class="px-4 py-3">{{ $student->phone }}</td>
                                            <td class="px-4 py-3">
                                                @if($student->registeredCourseStudent())
                                                    @foreach($student->registeredCourseStudent() as $courseName)
                                                        <div class="my-1">{{ $courseName }}<br></div>
                                                    @endforeach
                                                @else
                                                    No registered courses
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($student->registeredCourseStudent())
                                                    @foreach($student->registeredCourseStudent() as $courseName)
                                                        <div class="my-1">
                                                            {{ $student->isCoursePaid($courseName) ? 'OK' : 'NOT' }}<br>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    No registered courses
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($student->registeredCourseStudentIdCourse() as $idCourse)
                                                    <form action="" method="POST" onsubmit="confirmDelete()">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="hover:text-red-500 my-1" onclick="confirmDeleteStudent(event, '{{ route('student-deleteCourse', ['userId' => $student->id, 'idCourse' => $idCourse]) }}')">
                                                            <img class="h-6 w-6 inline-block" src="images/trash.png" alt="">
                                                        </button>
                                                    </form>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table class="w-full whitespace-nowrap table-auto mt-8" name="hasnotregistered">
                                <caption class="caption-top mb-2 font-semibold text-xl text-gray-800">
                                    Students have not registered course: {{ $notRegisteredStudents->count() }}
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
                                    @foreach($notRegisteredStudents as $student)
                                        <tr>
                                            <!-- Table data  -->
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3">
                                                <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150" src="{{ asset('images/avatars/'.$student->avatar) }}" alt="{{ $student->name }}" onclick="showAvatar('{{ asset('images/avatars/'.$student->avatar) }}', '{{ $student->name }}')">
                                            </td>
                                            <td class="px-4 py-3">{{ $student->name }}</td>
                                            <td class="px-4 py-3">{{ $student->email }}</td>
                                            <td class="px-4 py-3">{{ $student->gender }}</td>
                                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($student->birthday)->format('d-m-Y') }}</td>
                                            <td class="px-4 py-3">{{ $student->address }}</td>
                                            <td class="px-4 py-3">{{ $student->phone }}</td>
                                            <td>
                                                <x-danger-button
                                                    x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $student->id }}')">{{ __('Delete Account') }}
                                                </x-danger-button>

                                                <x-modal name="confirm-user-deletion-{{ $student->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                                    <form method="post" action="{{ route('confirm-delete', $student->id) }}" class="p-6">
                                                        @csrf
                                                        @method('delete')

                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Are you sure you want to delete this account?') }}
                                                        </h2>

                                                        <p class="mt-1 text-sm text-gray-600">
                                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</br>
                                                            {{ __('Please enter your password to confirm you would like to permanently delete this account.') }}
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
    function showAvatar(imageSrc, name) {
        document.getElementById('avatarImage').src = imageSrc;
        document.getElementById('modal-title').innerText = name;
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

    //confirmDeleteStudent
    function confirmDeleteStudent(event, route) {
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
                deleteStudent(route);
            }
        });
    }

    function deleteStudent(route) {
        fetch(route, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw response;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                swal("Poof! Student has been removed from the course!", {
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
        })
        .catch(error => {
            if (error.status === 409) {
                error.json().then(data => {
                    swal(data.error, {
                        title: "Error!",
                        icon: "error",
                        timer: 5000,
                    });
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

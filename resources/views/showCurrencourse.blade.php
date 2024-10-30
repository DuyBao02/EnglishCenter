<!DOCTYPE html>
<html>

@include('components.header-homepage')

<body class="text-gray-800 antialiased">
    @include('components.nav-homepage')

    <!-- Display teacher information -->
    <div id="teacherModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 border-b-2 border-gray-500"
                                id="modal-title">
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
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Zoom in avatar -->
    <div id="avatarModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
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
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeAvatarModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 50vh;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover"
                style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
                <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="items-center flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                        <div class="pr-12">
                            <h1 class="text-white font-semibold text-5xl">
                                Current Courses
                            </h1>
                            <div class="mt-8 text-gray-300 text-xl">
                                This is where courses are updated for students
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden"
                style="height: 70px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-white fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <section class="pt-20 pb-48">
            <div class="container mx-auto px-4">
                <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                    @if ($currentCoursesforStudent)
                        <div class="my-8 mx-8 sm:rounded-lg">
                            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                                <div class="w-full overflow-x-auto">
                                    <table class="w-full whitespace-nowrap">
                                        <thead>
                                            <tr
                                                class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                                <th class="px-4 py-3">ID</th>
                                                <th class="px-4 py-3">NameCourse</th>
                                                <th class="px-4 py-3">TimeStart</th>
                                                <th class="px-4 py-3">Weeks</th>
                                                <th class="px-4 py-3">Student</th>
                                                <th class="px-4 py-3">TuitionFee</th>
                                                <th class="px-4 py-3">Days</th>
                                                <th class="px-4 py-3">Lesson</th>
                                                <th class="px-4 py-3">Room</th>
                                                <th class="px-4 py-3">Teacher</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y">
                                            @if (isset($currentCoursesforStudent))
                                                @foreach ($currentCoursesforStudent as $c)
                                                    <tr>
                                                        <td class="px-4 py-3">{{ $c->id_3course }}</td>
                                                        <td class="px-4 py-3">{{ $c->name_course }}</td>
                                                        <td class="px-4 py-3">
                                                            {{ \Carbon\Carbon::parse($c->time_start)->format('d-m-Y') }}<br>
                                                        </td>
                                                        <td class="px-4 py-3">{{ $c->weeks }}</td>
                                                        <td class="px-4 py-3">{{ count($c->students_list) }} /
                                                            {{ $c->maxStudents }}</td>
                                                        <td class="px-4 py-3">{{ number_format($c->tuitionFee) }}</td>
                                                        <td class="px-4 py-3">
                                                            @if (is_array($c->days))
                                                                @foreach ($c->days as $day)
                                                                    {{ $day }}<br>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            @if (is_array($c->lessons))
                                                                @foreach ($c->lessons as $lesson)
                                                                    {{ $lesson }}<br>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            @if (is_array($c->rooms))
                                                                @foreach ($c->rooms as $room)
                                                                    {{ $room }}<br>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td class="px-4 py-3">
                                                            @if ($c->teacherUser3)
                                                                <div class="flex flex-col items-center">
                                                                    <img class="w-10 h-10 object-cover object-center rounded-full transform transition-transform duration-400 hover:scale-150"
                                                                        src="{{ asset('images/avatars/' . $c->teacherUser3->avatar) }}"
                                                                        alt="{{ $c->teacherUser3->name }}"
                                                                        onclick="showAvatar('{{ asset('images/avatars/' . $c->teacherUser3->avatar) }}')">
                                                                    <a class="hover:text-red-500"
                                                                        href="javascript:void(0)"
                                                                        onclick="showTeacherInfo({{ json_encode($c->teacherUser3) }})">
                                                                        <span>{{ $c->teacherUser3->name }}</span></a>
                                                                </div>
                                                            @else
                                                                <div class="flex items-center">
                                                                    <img src="images/sand-clock.png" class="h-9 w-9"
                                                                        alt="">
                                                                </div>
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
                    @endif
                    <div class="text-center text-xl font-semibold">Chưa có khóa học được công bố</div>
                </div>
            </div>
        </section>
    </main>

    @include('components.footer-homepage')

</body>

<button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
    //Zoom in avatar
    function showAvatar(imageSrc, teacherName) {
        document.getElementById('avatarImage').src = imageSrc;
        document.getElementById('avatarModal').classList.remove('hidden');
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
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
</script>

</html>

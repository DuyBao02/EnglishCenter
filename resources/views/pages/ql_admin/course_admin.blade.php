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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="my-8 mx-8 sm:rounded-lg">
                    @if(session('success'))
                        <div class="bg-amber-400 text-white text-center rounded-full my-4 mx-64">
                            {{ session('success') }}
                        </div>
                    @endif
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
                                    <th class="px-4 py-3">Student List</th>
                                    <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($courses))
                                        @foreach ($courses as $c)
                                        <!-- Table data  -->
                                            <tr>
                                            <td class="px-4 py-3">{{ $c->id_course }}</td>
                                            <td class="px-4 py-3">{{ $c->name_course }}</td>
                                            <td class="px-4 py-3">{{ $c->time_start }}</td>
                                            <td class="px-4 py-3">{{ $c->weeks }}</td>
                                            <td class="px-4 py-3">{{ $c->maxStudents }}</td>
                                            <td class="px-4 py-3">{{ $c->tuitionFee }}</td>
                                            <td class="px-4 py-3">
                                                @if(is_array($c->days))
                                                    @foreach($c->days as $day)
                                                        {{ $day }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if(is_array($c->lessons))
                                                    @foreach($c->lessons as $day)
                                                        {{ $day }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if(is_array($c->rooms))    
                                                    @foreach($c->rooms as $day)
                                                        {{ $day }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($c->teacher)
                                                    {{ $c->teacher }}
                                                @else
                                                    Chưa có
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if(is_array($c->students_list) && count($c->students_list) > 0)
                                                    @foreach($c->students_list as $s_t)
                                                        @if(!empty($s_t))
                                                            {{ $s_t }}<br>
                                                        @else
                                                            Chưa đăng ký
                                                        @endif
                                                    @endforeach
                                                @else
                                                    Chưa đăng ký
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 relative my-4">
                                                <button class="dropdownButton text-blue-500 hover:text-blue-700 mr-2">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                                <div class="dropdownMenu origin-top-right absolute right-0 mt-2 w-40 mx-auto rounded-md shadow-lg bg-blue-300 ring-1 ring-black ring-opacity-5 hidden z-50">
                                                    <a class="hover:text-red-500" href="">Public to Teacher</a> <br>
                                                    <a class="hover:text-red-500" href="">Public to Students</a> <br>
                                                    <a type="buttom" class="hover:text-red-500 mr-4" href="{{ route('course-edit', $c->id_course) }}">Edit</a> 
                                                    <form action="{{ route('course-custom-destroy', $c->id_course) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="hover:text-red-500">Delete</button>
                                                    </form>
                                                </div>
                                                
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

<script>
    var dropdownButtons = document.getElementsByClassName('dropdownButton');
    var currentOpenDropdown = null; // Store the currently open dropdown

    for (var i = 0; i < dropdownButtons.length; i++) {
        dropdownButtons[i].addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent this click from triggering the document click event handler
            var dropdownMenu = this.parentNode.getElementsByClassName('dropdownMenu')[0];
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
</script>
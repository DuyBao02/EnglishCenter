<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Course') }}
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
                <div class="my-8 sm:rounded-lg max-w-2xl mx-auto">
                    <form action="{{ route('course-registration-store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="id_course" class="block text-sm font-medium text-gray-700">ID Course</label>
                                <input required type="text" id="id_course" name="id_course" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="time_start" class="block text-sm font-medium text-gray-700">Time start</label>
                                <input required type="date" id="time_start" name="time_start" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="name_course" class="block text-sm font-medium text-gray-700">Name Course</label>
                                <input required type="text" id="name_course" name="name_course" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="tuitionFee" class="block text-sm font-medium text-gray-700">Tuition Fee</label>
                                <input required type="text" id="tuitionFee" name="tuitionFee" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div> 
                        </div> 
                        <div class="grid grid-cols-3 gap-4 mt-4">
                            <div class="col-span-3 sm:col-span-1">
                                <label for="day1" class="block text-sm font-medium text-gray-700">Day 1</label>
                                <div class="flex justify-around">
                                    <select required id="day1" name="days[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="day1">
                                        <option hidden>Day 1</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <label for="lesson1" class="block text-sm font-medium text-gray-700">Lesson 1</label>
                                <div class="flex justify-around">
                                    <select required id="lesson1" name="lessons[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="lesson1">
                                        <option hidden>Lesson 1</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id_lesson }}">{{ $lesson->id_lesson }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <label for="room1" class="block text-sm font-medium text-gray-700">Room 1</label>
                                <div class="flex justify-around">
                                    <select required id="room1" name="rooms[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="room1">
                                        <option hidden>Room 1</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id_room }}">{{ $room->id_room }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="day2" class="block text-sm font-medium text-gray-700">Day 2</label>
                                <div class="flex justify-around">
                                    <select required id="day2" name="days[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="day2">
                                        <option hidden>Day 2</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div> 
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="lesson2" class="block text-sm font-medium text-gray-700">Lesson 2</label>
                                <div class="flex justify-around">
                                    <select required id="lesson2" name="lessons[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="lesson2">
                                        <option hidden>Lesson 2</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id_lesson }}">{{ $lesson->id_lesson }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <label for="room2" class="block text-sm font-medium text-gray-700">Room 2</label>
                                <div class="flex justify-around">
                                    <select required id="room2" name="rooms[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="room2">
                                        <option hidden>Room 2</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id_room }}">{{ $room->id_room }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="day3" class="block text-sm font-medium text-gray-700">Day 3</label>
                                <div class="flex justify-around">
                                    <select required id="day3" name="days[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="day3">
                                        <option hidden>Day 3</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div> 
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="lesson3" class="block text-sm font-medium text-gray-700">Lesson 3</label>
                                <div class="flex justify-around">
                                    <select required id="lesson3" name="lessons[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="lesson3">
                                        <option hidden>Lesson 3</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id_lesson }}">{{ $lesson->id_lesson }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <label for="room3" class="block text-sm font-medium text-gray-700">Room 3</label>
                                <div class="flex justify-around">
                                    <select required id="room3" name="rooms[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required autofocus autocomplete="room3">
                                        <option hidden>Room 3</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id_room }}">{{ $room->id_room }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="maxStudents" class="block text-sm font-medium text-gray-700">Max Students</label>
                                <input required type="text" value="15" id="maxStudents" name="maxStudents" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="weeks" class="block text-sm font-medium text-gray-700">Number of Weeks</label>
                                <input required type="text" id="weeks" value="10" name="weeks" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-2 sm:col-span-1"> 
                                <label for="teacher" class="block text-sm font-medium text-gray-700">Teacher</label>
                                <input type="text" name="teacher" id="teacher" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="students_list" class="block text-sm font-medium text-gray-700">Students List</label>
                                <textarea name="students_list[]" id="students_list" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-center">
                            <x-primary-button type="reset" class="mr-4">
                                    {{ __('Refresh') }}
                                </x-primary-button>
                            <x-primary-button type="submit">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
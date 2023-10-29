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
                                <label for="id_course" class="block text-sm font-medium text-gray-700" :value="__('id_course')">ID Course</label>
                                <input required type="text" id="id_course" name="id_course" value="{{ old('id_course') }}" class="{{ $errors->any('id_course') ? 'border-red-500' : '' }} mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="name_course" class="block text-sm font-medium text-gray-700">Name Course</label>
                                <input required type="text" id="name_course" name="name_course" value="{{ old('name_course') }}" class="{{ $errors->any('name_course') ? 'border-red-500' : '' }} mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div> 
                        <div class="grid grid-cols-3 gap-4 mt-4">

                            <div class="col-span-3 sm:col-span-1">
                                <label for="time_start" class="block text-sm font-medium text-gray-700">Time start</label>
                                <input required type="date" id="time_start" name="time_start" value="{{ old('time_start') }}" min="{{ date('Y-m-d', strtotime('+3 day')) }}" class="{{ $errors->any('time_start') ? 'border-red-500' : '' }} mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="tuitionFee" class="block text-sm font-medium text-gray-700">Tuition Fee</label>
                                <input required type="text" id="tuitionFee" name="tuitionFee" value="{{ old('tuitionFee') }}" class="{{ $errors->any('tuitionFee') ? 'border-red-500' : '' }} mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-3 sm:col-span-1"> 
                                <label for="teacher" class="block text-sm font-medium text-gray-700">Teacher</label>
                                <div class="flex justify-around">
                                    <select id="teacher" name="teacher" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" autofocus autocomplete="teacher">
                                        <option hidden></option>
                                        @foreach($notRegisteredTeachers as $nRT)
                                            <option value="{{ $nRT->id }}" {{ old('teacher') == $nRT->id ? 'selected' : '' }}>{{ $nRT->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>  

                            <div class="col-span-3 sm:col-span-1">
                                <label for="day1" class="block text-sm font-medium text-gray-700">Day 1</label>
                                <div class="flex justify-around">
                                    <select required id="day1" name="days[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('days.0') ? 'border-red-500' : '' }}" required autofocus autocomplete="day1">
                                        <option hidden>Day 1</option>
                                        <option value="Monday" {{ old('days.0') == 'Monday' ? 'selected' : '' }}>Monday</option>
                                        <option value="Tuesday" {{ old('days.0') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                        <option value="Wednesday" {{ old('days.0') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                        <option value="Thursday" {{ old('days.0') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                        <option value="Friday" {{ old('days.0') == 'Friday' ? 'selected' : '' }}>Friday</option>
                                        <option value="Saturday" {{ old('days.0') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <label for="lesson1" class="block text-sm font-medium text-gray-700">Lesson 1</label>
                                <div class="flex justify-around">
                                    <select required id="lesson1" name="lessons[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('lessons.0') ? 'border-red-500' : '' }}" required autofocus autocomplete="lesson1">
                                        <option hidden>Lesson 1</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id_lesson }}" {{ old('lessons.0') == $lesson->id_lesson ? 'selected' : '' }}>
                                                {{ $lesson->id_lesson }}: 
                                                {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($lesson->end_time)->format('H:i') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <label for="room1" class="block text-sm font-medium text-gray-700">Room 1</label>
                                <div class="flex justify-around">
                                    <select required id="room1" name="rooms[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('rooms.0') ? 'border-red-500' : '' }}" required autofocus autocomplete="room1">
                                        <option hidden>Room 1</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id_room }}" {{ old('rooms.0') == $room->id_room ? 'selected' : '' }}>
                                                {{ $room->id_room }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="day2" class="block text-sm font-medium text-gray-700">Day 2</label>
                                <div class="flex justify-around">
                                    <select required id="day2" name="days[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('days.1') ? 'border-red-500' : '' }}" required autofocus autocomplete="day2">
                                        <option hidden>Day 2</option>
                                        <option value="Monday" {{ old('days.1') == 'Monday' ? 'selected' : '' }}>Monday</option>
                                        <option value="Tuesday" {{ old('days.1') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                        <option value="Wednesday" {{ old('days.1') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                        <option value="Thursday" {{ old('days.1') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                        <option value="Friday" {{ old('days.1') == 'Friday' ? 'selected' : '' }}>Friday</option>
                                        <option value="Saturday" {{ old('days.1') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                    </select>
                                    
                                </div> 
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="lesson2" class="block text-sm font-medium text-gray-700">Lesson 2</label>
                                <div class="flex justify-around">
                                    <select required id="lesson2" name="lessons[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('lessons.1') ? 'border-red-500' : '' }}" required autofocus autocomplete="lesson2">
                                        <option hidden>Lesson 2</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id_lesson }}" {{ old('lessons.1') == $lesson->id_lesson ? 'selected' : '' }}>
                                                {{ $lesson->id_lesson }}: 
                                                {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($lesson->end_time)->format('H:i') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <label for="room2" class="block text-sm font-medium text-gray-700">Room 2</label>
                                <div class="flex justify-around">
                                    <select required id="room2" name="rooms[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('rooms.1') ? 'border-red-500' : '' }}" required autofocus autocomplete="room2">
                                        <option hidden>Room 2</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id_room }}" {{ old('rooms.1') == $room->id_room ? 'selected' : '' }}>
                                                {{ $room->id_room }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="day3" class="block text-sm font-medium text-gray-700">Day 3</label>
                                <div class="flex justify-around">
                                    <select required id="day3" name="days[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('days.2') ? 'border-red-500' : '' }}" required autofocus autocomplete="day3">
                                        <option hidden>Day 3</option>
                                        <option value="Monday" {{ old('days.2') == 'Monday' ? 'selected' : '' }}>Monday</option>
                                        <option value="Tuesday" {{ old('days.2') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                        <option value="Wednesday" {{ old('days.2') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                        <option value="Thursday" {{ old('days.2') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                        <option value="Friday" {{ old('days.2') == 'Friday' ? 'selected' : '' }}>Friday</option>
                                        <option value="Saturday" {{ old('days.2') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                    </select>
                                </div> 
                            </div>

                            <div class="col-span-3 sm:col-span-1">
                                <label for="lesson3" class="block text-sm font-medium text-gray-700">Lesson 3</label>
                                <div class="flex justify-around">
                                    <select required id="lesson3" name="lessons[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('lessons.2') ? 'border-red-500' : '' }}" required autofocus autocomplete="lesson3">
                                        <option hidden>Lesson 3</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id_lesson }}" {{ old('lessons.2') == $lesson->id_lesson ? 'selected' : '' }}>
                                                {{ $lesson->id_lesson }}: 
                                                {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($lesson->end_time)->format('H:i') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-1">
                                <label for="room3" class="block text-sm font-medium text-gray-700">Room 3</label>
                                <div class="flex justify-around">
                                    <select required id="room3" name="rooms[]" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->any('rooms.2') ? 'border-red-500' : '' }}" required autofocus autocomplete="room3">
                                        <option hidden>Room 3</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id_room }}" {{ old('rooms.2') == $room->id_room ? 'selected' : '' }}>
                                                {{ $room->id_room }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="maxStudents" class="block text-sm font-medium text-gray-700">Max Students</label>
                                <input required type="text" value="{{ old('maxStudents', 3) }}" id="maxStudents" name="maxStudents" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="weeks" class="block text-sm font-medium text-gray-700">Number of Weeks</label>
                                <input required type="text" id="weeks" value="{{ old('weeks', 3) }}" name="weeks" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-center">
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
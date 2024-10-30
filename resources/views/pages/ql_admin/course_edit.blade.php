<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
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
                    <form action="{{ isset($course) ? route('course-custom-update', $course->id_course) : route('course-custom-update') }}" method="POST">
                        @csrf
                        @if ($thirdCourse)
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="id_course" class="block text-sm font-medium text-gray-700">ID Course (Cannot change)</label>
                                    <input readonly required type="text" id="id_course" name="id_course" value="{{ $course->id_course ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="name_course" class="block text-sm font-medium text-gray-700">Name Course</label>
                                    <input required oninput="formatCurrency(this)" type="text" id="name_course" name="name_course" value="{{ $course->name_course ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        @elseif ($secondCourse)
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="id_course" class="block text-sm font-medium text-gray-700">ID Course (Cannot change)</label>
                                    <input readonly required type="text" id="id_course" name="id_course" value="{{ $course->id_course ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="name_course" class="block text-sm font-medium text-gray-700">Name Course</label>
                                    <input required autofocus oninput="formatCurrency(this)" type="text" id="name_course" name="name_course" value="{{ $course->name_course ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="tuitionFee" class="block text-sm font-medium text-gray-700">Tuition Fee</label>
                                    <input required type="text" id="tuitionFee" name="tuitionFee" value="{{ $course->tuitionFee ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                @if ($secondCourse->is_registered == null)
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="teacher" class="block text-sm font-medium text-gray-700">Teacher</label>
                                        <div class="flex justify-around">
                                            <select id="teacher" name="teacher" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" autofocus autocomplete="teacher">
                                                <option hidden></option>
                                                @foreach($teachers as $nRT)
                                                    <option value="{{ $nRT->id }}" {{ old('teacher') == $nRT->id ? 'selected' : '' }}>{{ $nRT->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div class="col-span-3 sm:col-span-1">
                                    <label for="id_course" class="block text-sm font-medium text-gray-700">ID Course (Cannot change)</label>
                                    <input readonly required type="text" id="id_course" name="id_course" value="{{ $course->id_course ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-3 sm:col-span-1">
                                    <label for="name_course" class="block text-sm font-medium text-gray-700">Name Course</label>
                                    <input required oninput="formatCurrency(this)" type="text" id="name_course" name="name_course" value="{{ $course->name_course ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="tuitionFee" class="block text-sm font-medium text-gray-700">Tuition Fee</label>
                                    <input required type="text" id="tuitionFee" name="tuitionFee" value="{{ $course->tuitionFee ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="time_start" class="block text-sm font-medium text-gray-700">Time start</label>
                                    <input required type="date" id="time_start" name="time_start" value="{{ $course->time_start ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="maxStudents" class="block text-sm font-medium text-gray-700">Max Students</label>
                                    <input required type="number" value="{{ $course->maxStudents ?? '' }}" id="maxStudents" name="maxStudents" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="weeks" class="block text-sm font-medium text-gray-700">Number of Weeks</label>
                                    <input required type="number" id="weeks" value="{{ $course->weeks ?? '' }}" name="weeks" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        @endif

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
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
        <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

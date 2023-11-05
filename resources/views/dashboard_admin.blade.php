<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if (Session::has('success'))
    <script>
        window.onload = function() {
            swal('Success', '{{ Session::get('success') }}', 'success', {
                button: true, 
                button: 'OK', 
                timer: 5000, 
            });
        }

    </script>
    @endif
    @if ($errors->has('email'))
    <script>
        window.onload = function() {
            swal('Error', '{{ $errors->first('email') }}', 'error', {
                button: true,
                button: 'OK',
                timer: 5000, 
            });
        }
    </script>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center text-3xl">
                    {{ __("Welcome") }} {{ Auth::user()->name }}{{ __(" !") }}
                    </br>
                    {{ __("Have a good day !") }}

                    <div class="grid grid-cols-3 gap-4 mt-8">
                        <div class="bg-amber-200 max-h-72 overflow-hidden shadow-sm sm:rounded-lg col-span-3 sm:col-span-1">
                            <a data-target="admins" href="{{ route('users-management') }}"><div class="text-lg mt-2">Total Admins: {{ $totaladmins }}</div></a>
                        </div>

                        <div class="bg-amber-200 max-h-56 overflow-hidden shadow-sm sm:rounded-lg col-span-3 sm:col-span-1">
                            <a data-target="teachers" href="{{ route('users-management') }}"><div class="text-lg mt-2">Total Teachers: {{ $totalteachers }}</div></a>
                        </div>

                        <div class="bg-amber-200 max-h-56 overflow-hidden shadow-sm sm:rounded-lg col-span-3 sm:col-span-1">
                            <a data-target="students" href="{{ route('users-management') }}"><div class="text-lg mt-2">Total Students: {{ $totalstudents }}</div></a>
                        </div>

                        <div class="bg-red-200 max-h-56 overflow-hidden shadow-sm sm:rounded-lg col-span-3 sm:col-span-1">
                            <a href="{{ route('course-admin') }}"><div class="text-lg mt-2">Total Courses: {{ $totalcourses }}</div></a>
                        </div>

                        <div class="bg-violet-300 max-h-56 overflow-hidden shadow-sm sm:rounded-lg col-span-3 sm:col-span-1">
                            <a href="{{ route('rl-custom-admin') }}"><div class="text-lg mt-2">Total Lessons: {{ $totallessons }}</div></a>
                        </div>

                        <div class="bg-violet-300 max-h-56 overflow-hidden shadow-sm sm:rounded-lg col-span-3 sm:col-span-1">
                            <a href="{{ route('rl-custom-admin') }}"><div class="text-lg mt-2">Total Rooms: {{ $totalrooms }}</div></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
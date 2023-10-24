<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lesson') }}
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
                <div class="p-6 text-gray-900 text-center text-3xl">
                    
                    <div class="w-full flex justify-center items-center">
                        <!-- Lesson form --> 
                        <div class="bg-red-200 max-h-72 w-72 overflow-hidden shadow-sm sm:rounded-lg ">
                            <div class="text-lg mt-2">Edit Lesson</div>
                                <form action="{{ isset($lesson) ? route('lesson-custom-update', $lesson->id_lesson) : route('lesson-custom-update') }}" method="POST" class="flex flex-col items-center my-auto">
                                    @csrf
                                    <div class="mt-4 flex items-center justify-center w-full">
                                        <label for="id_lesson" class="block text-sm font-medium text-gray-700 mr-2">ID Lesson</label>
                                        <input readonly required type="text" id="id_lesson" name="id_lesson" value="{{ isset($lesson) ? $lesson->id_lesson : '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">                                
                                    </div>
                            
                                    <div class="mt-4 flex items-center justify-center w-full">
                                        <label for="start_time" class="block text-sm font-medium text-gray-700 mr-2">Time Start</label>
                                        <input required type="time" id="start_time" name="start_time" value="{{ isset($lesson) ? $lesson->start_time : '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                            
                                    <div class="mt-4 flex items-center justify-center w-full">
                                        <label for="end_time" class="block text-sm font-medium text-gray-700 mr-2">Time End</label>
                                        <input required type="time" id="end_time" name="end_time" value="{{ isset($lesson) ? $lesson->end_time : '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                            
                                    <div class="my-4 flex items-center justify-center w-full">
                                        <x-primary-button type="submit">
                                            {{ __('Save') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    //Autofill start_time or end_time
    document.getElementById('start_time').addEventListener('input', function (e) {
        var startTime = new Date('1970-01-01T' + e.target.value + 'Z');
        var endTime = new Date(startTime.getTime() + 120*60000);
        var endTimeStr = endTime.toISOString().substr(11, 5);
        document.getElementById('end_time').value = endTimeStr;
    });

    document.getElementById('end_time').addEventListener('input', function (e) {
        var endTime = new Date('1970-01-01T' + e.target.value + 'Z');
        var startTime = new Date(endTime.getTime() - 120*60000);
        var startTimeStr = startTime.toISOString().substr(11, 5);
        document.getElementById('start_time').value = startTimeStr;
    });
</script>
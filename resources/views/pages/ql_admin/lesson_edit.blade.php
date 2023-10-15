<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms & Lessons Custom') }}
        </h2>
    </x-slot>

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
                                        <input required type="text" id="id_lesson" name="id_lesson" value="{{ isset($lesson) ? $lesson->id_lesson : '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 shadow-sm sm:text-sm border-gray-300 rounded-md">                                
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
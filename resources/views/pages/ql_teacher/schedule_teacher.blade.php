<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule') }}
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
                                        <th class="px-4 py-3">Max Student</th>
                                        <th class="px-4 py-3">Tuition Fee</th>
                                        <th class="px-4 py-3">Days</th>
                                        <th class="px-4 py-3">Lesson</th>
                                        <th class="px-4 py-3">Room</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($course))
                                        <tr>
                                            <td class="px-4 py-3">{{ $course->id_course }}</td>
                                            <td class="px-4 py-3">{{ $course->name_course }}</td>
                                            <td class="px-4 py-3">{{ $course->time_start }}</td>
                                            <td class="px-4 py-3">{{ $course->weeks }}</td>
                                            <td class="px-4 py-3">{{ $course->maxStudents }}</td>
                                            <td class="px-4 py-3">{{ $course->tuitionFee }}</td>
                                            <td class="px-4 py-3">
                                                @if(is_array($course->days))
                                                    @foreach($course->days as $day)
                                                        {{ $day }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if(is_array($course->lessons))
                                                    @foreach($course->lessons as $day)
                                                        {{ $day }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if(is_array($course->rooms))    
                                                    @foreach($course->rooms as $day)
                                                        {{ $day }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 relative my-4">
                                                <a class="hover:text-red-500" href="">Register</a>
                                            </td>
                                        </tr>
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

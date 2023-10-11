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
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Max Students</th>
                                <th class="px-4 py-3">Tuition Fee</th>
                                <th class="px-4 py-3">Number of Weeks</th>
                                <th class="px-4 py-3">Days of the Week</th>
                                <th class="px-4 py-3">Shift learning</th>
                                <th class="px-4 py-3">Room</th>
                                <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                <!-- Table data -->
                                <tr>
                                <td class="px-4 py-3">CE01</td>
                                <td class="px-4 py-3">Course A</td>
                                <td class="px-4 py-3">15</td>
                                <td class="px-4 py-3">100,000 VND</td>
                                <td class="px-4 py-3">10</td>
                                <td class="px-4 py-3">Mon, Tue, Web</td>
                                <td class="px-4 py-3">1, 2</td>
                                <td class="px-4 py-3">201</td>
                                <td class="px-4 py-3">
                                    <button class="text-blue-500 hover:text-blue-700 mr-2">Edit</button>
                                    <button class="text-red-500 hover:text-red-700 mr-2">Delete</button>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

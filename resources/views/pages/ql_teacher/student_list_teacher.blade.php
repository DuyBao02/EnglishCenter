<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student List') }}
        </h2>
    </x-slot>

    <div id="avatarModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 border-b-2 border-gray-500" id="modal-title">
                                <!-- Student Name -->
                            </h3>
                            <div class="mt-4">
                                <img id="avatarImage" src="" alt="Student Avatar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeAvatarModal()">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-emerald-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="my-4 mx-4 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <div class="mb-4">
                                Total students: {{ count($students_list) }}
                            </div>
                            <table class="w-full whitespace-nowrap table-auto">
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Avatar</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Gender</th>
                                    <th class="px-4 py-3">Birthday</th>
                                    <th class="px-4 py-3">Address</th>
                                    <th class="px-4 py-3">Phone</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($students_list))
                                        @foreach($students_list as $student)
                                            <tr>
                                                <!-- Table data  -->
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">
                                                    <img class="w-10 h-10 object-cover object-center rounded-full" src="{{ asset('images/avatars/'.$student->avatar) }}" alt="{{ $student->name }}" onclick="showAvatar('{{ asset('images/avatars/'.$student->avatar) }}', '{{ $student->name }}')">
                                                </td>
                                                <td class="px-4 py-3">{{ $student->name }}</td>
                                                <td class="px-4 py-3">{{ $student->email }}</td>
                                                <td class="px-4 py-3">{{ $student->gender }}</td>
                                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse( $student->birthday )->format('d-m-Y') }}</td>
                                                <td class="px-4 py-3">{{ $student->address }}</td>
                                                <td class="px-4 py-3">0{{ $student->phone }}</td>
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
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
      <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>
<script>
    //Zoom in avatar
    function showAvatar(imageSrc, studentName) {
        document.getElementById('avatarImage').src = imageSrc;
        document.getElementById('modal-title').innerText = studentName;
        document.getElementById('avatarModal').classList.remove('hidden');
    }
    
    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
    }
</script>

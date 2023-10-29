<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Request') }}
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

    <!-- Preview avatar image -->
    <div id="avatarModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                New Avatar
                            </h3>
                            <div class="mt-2">
                                <img id="avatarImage" src="" alt="New Avatar">
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
                <div class="my-8 mx-8 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <div class="mb-4">Teacher Request</div>
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">User-email</th>
                                        <th class="px-4 py-3">Content</th>
                                        <th class="px-4 py-3">Request-Time</th>
                                        <th class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($editsTeacher))
                                        @foreach($editsTeacher as $e)
                                            <tr>
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">{{ $e->user->email }}</td>
                                                <td class="px-4 py-3">
                                                    @php
                                                        $oldData = json_decode($e->data, true)['old'];
                                                        $newData = json_decode($e->data, true)['new'];
                                                    @endphp
                                                    @foreach($oldData as $field => $oldValue)
                                                        @if(array_key_exists($field, $newData) && $oldValue != $newData[$field])
                                                            @if($field == 'avatar' && !empty($newData[$field]))
                                                                <p><strong>{{ $field }}</strong>:
                                                                    @if(is_array($oldData[$field]))
                                                                        {{ json_encode($oldData[$field]) }}
                                                                    @else
                                                                        <a class="hover:text-red-500" href="#" onclick="showAvatar('{{ asset('images/avatars/'.$oldData[$field]) }}')">{{ $oldValue }}</a> -> 
                                                                    @endif

                                                                    @if(is_array($newData[$field]))
                                                                        {{ json_encode($newData[$field]) }}
                                                                    @else
                                                                        <a class="hover:text-red-500" href="#" onclick="showAvatar('{{ asset('images/avatars/'.$newData[$field]) }}')">{{ $newData[$field] }}</a>
                                                                    @endif
                                                                </p>
                                                            @elseif($field != 'avatar')
                                                                <p><strong>{{ $field }}</strong>: {{ $oldValue }} -> 
                                                                    @if(is_array($newData[$field]))
                                                                        {{ json_encode($newData[$field]) }}
                                                                    @else
                                                                        {{ $newData[$field] }}
                                                                    @endif
                                                                </p>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="px-4 py-3">{{ $e->created_at }}</td>

                                                <td class="px-4 py-3">
                                                    @if ($e->status == 'accepted')
                                                        {{__('Accepted')}}
                                                    @elseif ($e->status == 'refused')
                                                        {{__('Refused')}}
                                                    @else
                                                        <div class="flex items-center">
                                                            <a class="hover:text-red-500 transform transition-transform duration-400 hover:scale-150" href="#" onclick="confirmAcceptEdit(event, ' {{ route('edit-accept', ['id_user' => $e->user_id, 'id_edit' => $e->id]) }} ')">
                                                                <img class="h-7 w-7" src="images/checkbox.png" alt=""></a>

                                                            <a class="hover:text-red-500 ml-4 transform transition-transform duration-400 hover:scale-150" href="#" onclick="confirmRefuseEdit(event, ' {{ route('edit-refuse', ['id_edit' => $e->id]) }} ')">
                                                                <img class="h-10 w-10" src="images/cancel.png" alt=""></a>
                                                        </div>
                                                    @endif
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="my-8 mx-8 sm:rounded-lg">
                    <div class="w-full overflow-hidden rounded-lg shadow-xs">
                        <div class="w-full overflow-x-auto">
                            <div class="mb-4">Student Request</div>
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="text-xs font-medium tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">User-email</th>
                                        <th class="px-4 py-3">Content</th>
                                        <th class="px-4 py-3">Request-Time</th>
                                        <th class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($editsStudent))
                                        @foreach($editsStudent as $es)
                                            <tr>
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">{{ $es->user->email }}</td>
                                                <td class="px-4 py-3">
                                                    @php
                                                        $oldData = json_decode($es->data, true)['old'];
                                                        $newData = json_decode($es->data, true)['new'];
                                                    @endphp
                                                    @foreach($oldData as $field => $oldValue)
                                                        @if(array_key_exists($field, $newData) && $oldValue != $newData[$field])
                                                            @if($field == 'avatar')
                                                                <p><strong>{{ $field }}</strong>:
                                                                    @if(is_array($oldData[$field]))
                                                                        {{ json_encode($oldData[$field]) }}
                                                                    @else
                                                                        <a class="hover:text-red-500" href="#" onclick="showAvatar('{{ asset('images/avatars/'.$oldData[$field]) }}')">{{ $oldValue }}</a> -> 
                                                                    @endif

                                                                    @if(is_array($newData[$field]))
                                                                        {{ json_encode($newData[$field]) }}
                                                                    @else
                                                                        <a class="hover:text-red-500" href="#" onclick="showAvatar('{{ asset('images/avatars/'.$newData[$field]) }}')">{{ $newData[$field] }}</a>
                                                                    @endif
                                                                </p>
                                                            @else
                                                                <p><strong>{{ $field }}</strong>: {{ $oldValue }} -> 
                                                                    @if(is_array($newData[$field]))
                                                                        {{ json_encode($newData[$field]) }}
                                                                    @else
                                                                        {{ $newData[$field] }}
                                                                    @endif
                                                                </p>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    
                                                </td>
                                                <td class="px-4 py-3">{{ $es->created_at }}</td>

                                                <td class="px-4 py-3">
                                                    @if ($es->status == 'accepted')
                                                        {{__('Accepted')}}
                                                    @elseif ($es->status == 'refused')
                                                        {{__('Refused')}}
                                                    @else
                                                        <div class="flex items-center">
                                                            <a class="hover:text-red-500 transform transition-transform duration-400 hover:scale-150" href="#" onclick="confirmAcceptEdit(event, ' {{ route('edit-accept', ['id_user' => $es->user_id, 'id_edit' => $es->id]) }} ')">
                                                                <img class="h-7 w-7" src="images/checkbox.png" alt=""></a>

                                                            <a class="hover:text-red-500 ml-4 transform transition-transform duration-400 hover:scale-150" href="#" onclick="confirmRefuseEdit(event, ' {{ route('edit-refuse', ['id_edit' => $es->id]) }} ')">
                                                                <img class="h-10 w-10" src="images/cancel.png" alt=""></a>
                                                        </div>
                                                    @endif
                                                    
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
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
      <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    // Preview avatar image
    function showAvatar(imageSrc) {
        document.getElementById('avatarImage').src = imageSrc;
        document.getElementById('avatarModal').classList.remove('hidden');
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').classList.add('hidden');
    }

    function confirmAcceptEdit(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to change this information?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willRegister) => {
            if (willRegister) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
    }
    
    function confirmRefuseEdit(event, route) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Are you sure you don't want to change this information?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willRegister) => {
            if (willRegister) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
    }
</script>
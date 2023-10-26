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
                                        <th class="px-4 py-3">Role</th>
                                        <th class="px-4 py-3">User-email</th>
                                        <th class="px-4 py-3">Content</th>
                                        <th class="px-4 py-3">Request-Time</th>
                                        <th class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @if(isset($edit_show))
                                        @foreach($edit_show as $e)
                                            <tr>
                                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                                <td class="px-4 py-3">{{ $e->user->role }}</td>
                                                <td class="px-4 py-3">{{ $e->user->email }}</td>
                                                <td class="px-4 py-3">
                                                    @foreach(json_decode($e->data, true)['old'] as $field => $oldValue)
                                                        @if(isset($e->changes[$field]))
                                                            <p><strong>{{ $field }}</strong>: {{ $oldValue }} -> {{ $e->changes[$field] }}</p>
                                                        @endif
                                                    @endforeach
                                                    
                                                </td>
                                                <td class="px-4 py-3">{{ $e->daytime }}</td>

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
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
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
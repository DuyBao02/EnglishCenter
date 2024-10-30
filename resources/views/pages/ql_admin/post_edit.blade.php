<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
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

                {{-- Create post Form --}}
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold">Edit post</h3>

                    <form action="{{ isset($post) ? route('post-update', $post->id) : route('create-post') }}" method="POST" class="mt-6" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                                <input value="{{ isset($post) ? $post->title : '' }}"
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="picture" class="block text-gray-700 text-sm font-bold mb-2">Picture</label>
                                <input id="picture" class="block mt-1 w-full" type="file" name="picture" autofocus autocomplete="picture" />
                                Old picture: {{ isset($post) ? $post->picture : '' }}
                            </div>

                        </div>

                        <div class="mt-4">
                            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                            <textarea
                                id="content"
                                name="content"
                                rows="3"
                                autofocus autocomplete="content"
                                class="form-control web-editor shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                {{ isset($post) ? $post->content : '' }}
                            </textarea>

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
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
      <i class="fas fa-arrow-up"></i>
    </button>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ Vite::asset('vendor/tinymce/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

<script>

    tinymce.init({
        selector: '.web-editor', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
</script>

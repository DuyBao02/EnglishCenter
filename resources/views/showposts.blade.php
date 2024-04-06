<!DOCTYPE html>
<html>

@include('components.header-homepage')

<body class="text-gray-800 antialiased">
    @include('components.nav-homepage')
    <main>
        <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 50vh;">
            <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
                <span id="blackOverlay" class="w-full h-full absolute opacity-75 bg-black"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="items-center flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                        <div class="pr-12">
                            <h1 class="text-white font-semibold text-5xl">
                                Posts
                            </h1>
                            <div class="mt-8 text-gray-300 text-xl">
                                This is the place to update the latest news from DBEC
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden" style="height: 70px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="text-white fill-current" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <section class="pt-20 pb-48">
            <div class="container mx-auto px-4">
                <div class="flex-wrap mt-24 grid grid-cols-3 gap-4">
                    @foreach($posts as $p)

                        <div class="col-span-3 sm:col-span-1">
                            <a href="{{ route('posts-details', $p->id) }}">
                                <div class="px-6">
                                    <img src="{{ asset('images/posts/'.$p->picture) }}" alt="{{ $p->picture }}" class="transform transition-transform duration-400 hover:scale-125 shadow-lg mx-auto max-h-72" />
                                    <div class="pt-6 text-center">
                                        <i class="fas fa-calendar mr-2 mb-4"></i>
                                            {{ \Carbon\Carbon::parse($p->updated_at)->format('d-m-Y') }}
                                        <h5 class="text-xl font-bold">{{ $p->title }}</h5>
                                        <p class="mt-1 text-sm text-gray-500 uppercase font-semibold">
                                            <a class="hover:text-red-500" href="{{ route('posts-details', $p->id) }}">Xem thêm</a>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @endforeach
                </div>
            </div>
        </section>

    </main>

    @include('components.footer-homepage')

</body>

<button id="back-to-top" class="fixed bottom-5 right-5 bg-blue-500 text-white p-2 rounded-full hidden">
    <i class="fas fa-arrow-up"></i>
</button>

</html>

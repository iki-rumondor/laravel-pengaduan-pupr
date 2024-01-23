@include('layouts.header')
<div id="app">
    <div class="image-bg-container">
        <img src="{{ asset('storage/5397657.png') }}" alt="hero" class="image-bg">
    </div>
    @include('layouts.navbar')
    <main class="py-5">
        @yield('content')
    </main>
</div>
@include('layouts.footer')
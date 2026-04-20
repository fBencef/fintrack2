@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout title="Dashboard">
    @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div style="color: red; background: #ffeeee; padding: 10px; border: 1px solid red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <h2>Dashboard</h2>

    <div class="dashboard-grid">
        <div class="main-content">
        @include('partials.pending_queue')
        </div>
    </div>

</x-layout>
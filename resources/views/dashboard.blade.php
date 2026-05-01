<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vezérlőpult') }}
        </h2>
    </x-slot>

    <!--Dynamic dashboard widget part-->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @if(auth()->user()->prefers('monthly_spending'))
                    <x-dashboard-card title="Havi költés" id="monthly-spending">
                        <div class="py-2">
                            <div class="text-6xl font-bold text-600">
                            <p class="text-xl text-gray-500 mt-2 tracking-wide uppercase font-semibold">
                                {{ $currentMonthLabel }}
                            </p>
                                {{ number_format($monthlyTotal, 0, ',', ' ') }} 
                                <span class="text-3xl text-gray-500 font-medium">
                                    {{ $defaultCurrency->currency_sign ?? 'Ft' }}
                                </span>
                            </div>
                        </div>

                        <x-slot name="cardActions">
                            <a href="{{ route('transactions.expenses') }}" class="text-xs text-600 hover:underline text-right">Részletek ➔</a>
                        </x-slot>
                    </x-dashboard-card>
                @endif

                @if(auth()->user()->prefers('category_chart'))
                    <x-dashboard-card title="Költési kategóriák" id="category-chart">
                        <div class="h-48 bg-gray-100 flex items-center justify-center rounded italic text-gray-400">
                            PLACEHOLDER - KATEGÓRIÁK
                        </div>
                    </x-dashboard-card>
                @endif
                


            </div>
        </div>
    </div>

    <!--Static older part. Felt quick, might delete later-->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="color: #721c24; background-color: #f8d7da; padding: 15px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 5px;">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="dashboard-grid">
                        <div class="main-content">
                            @include('partials.pending_queue')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
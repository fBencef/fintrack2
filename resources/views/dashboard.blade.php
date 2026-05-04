@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vezérlőpult') }}
        </h2>
    </x-slot>

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

        <!-- Action bar -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 pb-6 pt-12"> <!-- This matches the Selector exactly -->
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 pt-2 pb-2 px-4"> <!-- The actual white box -->
                <!-- Add New Button -->
                <button onclick="createTransaction()" 
                    class="inline-flex items-center px-5 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded transition-all shadow-sm hover:shadow-lg active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Új tranzakció
                </button>
            </div>
        </div>

    <!--Dynamic dashboard widget part-->
    <div class="py-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-dashboard-month-selector 
                        :selectedMonth="$selectedMonth" 
                        :prevMonth="$prevMonth" 
                        :nextMonth="$nextMonth" 
                        :isCurrentMonth="$isCurrentMonth" 
            />
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!--MONTHLY SPENDING-->
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

                <!--CATEGORIES-->
                @if(auth()->user()->prefers('category_chart'))
                    <x-dashboard-card title="Költési kategóriák" id="category-chart">
                        <x-category-chart :data="$spendingCategories" />
                    </x-dashboard-card>
                @endif

                <!--RECENT TRANSACTIONS-->
                @if(auth()->user()->prefers('recent_transactions'))
                    <x-recent-transactions-card :transactions="$recentTransactions" />
                @endif

            </div>
        </div>
    </div>

    <!--Static older part. Felt quick, might delete later-->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
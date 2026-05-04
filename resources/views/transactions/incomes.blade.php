@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout title="Expenses">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bevételek') }}
        </h2>
    </x-slot>

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

    <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg p-6">
                    
                    <div class="flex flex-col lg:flex-row gap-8 items-start">
                        <!-- Table and action bar -->
                        <div class="flex-1 w-full lg:w-3/4 bg-white shadow-sm p-6 rounded-lg">

                            <!-- Action bar -->
                            <div class="flex flex-wrap items-center gap-4 mb-6">
                                <!-- Add New Button -->
                                <button onclick="createTransaction()" 
                                    class="inline-flex items-center px-5 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded transition-all shadow-sm hover:shadow-lg active:scale-95">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Új tranzakció
                                </button>

                                <!-- Year Selector -->
                                <div class="inline-flex p-1 bg-gray-100 rounded-xl">
                                    @foreach($existingYears as $year)
                                        <a href="{{ route('transactions.incomes', ['year' => $year]) }}" 
                                            class="px-4 py-2 text-sm font-bold rounded-lg transition-all {{ $selectedYear == $year 
                                                ? 'bg-white text-emerald-600 shadow-sm' 
                                                : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200' 
                                            }}">
                                            {{ $year }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="overflow-x-auto border border-gray-100">
                                <table class="summary-table min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="summary-table-header">
                                            <th style="text-align: left;"></th>
                                            @foreach($months as $month)
                                                <th>{{ $month }}</th>
                                            @endforeach
                                            <th>Összesen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pivotData as $categoryName => $data)
                                            @php $categoryTotalYear = array_sum($data['total']); @endphp
                                            <tr class="summary-table-main-category" data-category="{{ $categoryName }}">
                                                <td><a class="table-expand" style="cursor: pointer;"> ⯈ </a>
                                                    <!--details>
                                                        <summary-->
                                                            {{ $categoryName }} @php echo count($data['subs']) > 0 ? '('.count($data['subs']).')' : ''; @endphp
                                                        <!--/summary>
                                                    </details-->
                                                </td>
                                                
                                                @foreach($months as $month)
                                                    <!--TODO: replace ' Ft' with dynamic currency sign?-->
                                                    <td> {{ $data['total'][$month] > 0 ? number_format($data['total'][$month], 0, ',', ' ') . ' Ft' : '-' }} </td>
                                                @endforeach
                                                <td class="summary-table-year-sum-main">{{ number_format($categoryTotalYear, 0, ',', ' ') }} Ft</td>
                                            </tr>

                                            <!-- Subcategory rows hidden until category is expanded) -->
                                            @foreach($data['subs'] as $subName => $subMonths)
                                                <tr class="summary-table-subcategory toggle_subcategory" data-parent="{{ $categoryName }}" style="display: none;">
                                                    <td style="padding-left: 30px;">{{ $subName }}</td>
                                                    @foreach($months as $month)
                                                        <td>{{ $subMonths[$month] > 0 ? number_format($subMonths[$month], 0, ',', ' ') . ' Ft' : '-' }}</td>
                                                    @endforeach
                                                    <td class="summary-table-year-sum-sub">{{ number_format(array_sum($subMonths), 0, ',', ' ') }} Ft</td>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="w-full lg:w-1/4">
                            <x-recent-transactions-card :transactions="$latestIncomesNew" title="Legutóbbi bevételek" />
                        </div>
                    </div>
                </div>
            </div>

            <div id="transactionModal" class="modal-overlay" style="display: none;">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal()">&times;</span>
                    <div id="modal-body">
                        <p>Modal...</p>
                    </div>
                </div>
            </div>
</x-app-layout>
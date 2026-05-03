@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout title="Expenses">

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

    <h2>Incomes</h2>

    <button type="button" onclick="createTransaction()" class="btn-create">
    + Új Tranzakció
    </button>

    <div class="table-container">
    
    <div class="year-selector">
    @foreach($existingYears as $year)
        <a href="{{ route('transactions.incomes', ['year' => $year]) }}" 
           class="year-btn {{ $selectedYear == $year ? 'active' : '' }}">
            {{ $year }}
        </a>
    @endforeach
    </div>
    
    <div style="display: flex; gap: 30px; align-items: flex-start;">
        <table class="summary-table" style="flex: 3;">
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

        <!--div class="recent_transactions_box" style="flex: 1;">
            <h3>Legutóbbi tranzakciók</h3>
            <ul class="recent_transactions_list">
                @foreach($latestIncomes as $income)
                    <li>
                        {{ number_format(abs($income->transaction_amount), 0, ',', ' ') }} Ft
                        <br>
                        {{ $income->category->category_name }} / {{ $income->subcategory?->subcategory_name ?? '-'}}
                        <br>
                        {{ $income->transaction_date_completed }}
                        <br>
                        <button
                            type="button"
                            onclick="showTransactionDetails({{ $income->transaction_id }})"
                            class="details-btn">
                            Részletek
                        </button>
                    </li>
                @endforeach
            </ul>
        </div-->

    <div class="recent_transactions_box" style="flex: 1;">
        <x-recent-transactions-card :transactions="$latestIncomesNew" title="Legutóbbi kiadások" />
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
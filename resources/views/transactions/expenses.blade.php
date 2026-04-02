@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout title="Expenses">

    <h2>Expenses</h2>

    <div class="table-container">
    <table class="summary-table">
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
                    <tr class="summary-table-subcategory" data-parent="{{ $categoryName }}" style="display: none;">
                        <td style="padding-left: 30px;">{{ $subName }}</td>
                        @foreach($months as $month)
                            <td>{{ $subMonths[$month] > 0 ? number_format($subMonths[$month], 0, ',', ' ') . ' Ft' : '-' }}</td>
                        @endforeach
                        <td class="summary-table-year-sum-sub">{{ number_format(array_sum($subMonths), 0, ',', ' ') }} Ft</td>
                @endforeach
            @endforeach
        </tbody>
    </table>
</x-layout>
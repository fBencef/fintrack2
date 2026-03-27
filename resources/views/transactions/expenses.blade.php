<x-layout title="Expenses">
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: right; }
        .header-row { background-color: #90c990; color: white; text-align: center; }
        .category-row { background-color: #e2e2e2; font-weight: bold; text-align: left; }
        .subcategory-row { background-color: #ffffff; color: #555; }
        .total-col { font-weight: bold; background-color: #f0f0f0; }
        summary { cursor: pointer; display: list-item; outline: none; }
        details[open] summary { margin-bottom: 0; }
    </style>

    <h2>Expenses</h2>

    <table>
        <thead>
            <tr class="header-row">
                <th style="text-align: left;">Kategória</th>
                @foreach($months as $month)
                    <th>{{ $month }}</th>
                @endforeach
                <th>Összesen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pivotData as $categoryName => $data)
                @php $categoryTotalYear = array_sum($data['total']); @endphp
                <tr class="category-row">
                    <td>
                        <details>
                            <summary>
                                {{ $categoryName }} ({{ count($data['subs']) }})
                            </summary>
                        </details>
                    </td>
                    
                    @foreach($months as $month)
                        <!--TODO: replace ' Ft' with dynamic currency sign?-->
                        <td> {{ $data['total'][$month] > 0 ? number_format($data['total'][$month], 0, ',', ' ') . ' Ft' : '-' }} </td>
                    @endforeach
                    <td class="total-col">{{ number_format($total, 0, ',', ' ') }} Ft</td>
                </tr>

                <!-- Subcategory rows hidden until category is expanded) -->
                @foreach($data['subs'] as $subName => $subMonths)
                    <tr class="subcategory-row">
                        <td style="padding-left: 30px;">{{ $subName }}</td>
                        @foreach($months as $m)
                            <td>{{ $subMonths[$m] > 0 ? number_format($subMonths[$m], 0, ',', ' ') . ' Ft' : '-' }}</td>
                            <td class="total-col">{{ number_format(array_sum($subMonths), 0, ',', ' ') }} Ft</td>
                        @endforeach
                @endforeach
            @endforeach
        </tbody>
    </table>
</x-layout>
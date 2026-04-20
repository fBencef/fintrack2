@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-layout title="Recurring">

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

    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Ismétlődő Tranzakciók</h2>
            <button type="button" onclick="openCreateRecurringModal()" class="btn-primary">
                + Új Ismétlődés
            </button>
        </div>

        <table class="pivot-table" style="width: 100%; margin-top: 20px;">
            <thead>
                <tr>
                    <th>Megnevezés</th>
                    <th>Összeg</th>
                    <th>Gyakoriság</th>
                    <th>Következő dátum</th>
                    <th>Típus</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recurrings as $rec)
                    <tr>
                        <td><strong>{{ $rec->recurring_name }}</strong><br>
                            <small>{{ $rec->category->category_name }}</small>
                        </td>
                        <td>{{ number_format($rec->recurring_amount, 0, ',', ' ') }} {{ $rec->currency->currency_code }}</td>
                        <td>
                            {{ $rec->frequency_intervall }}. 
                            {{ match($rec->frequency_type) {
                                'daily' => 'naponta',
                                'weekly' => 'hetente',
                                'monthly' => 'havonta',
                                'yearly' => 'évente',
                                default => $rec->frequency_type
                            } }}
                        </td>
                        <td>{{ $rec->next_execution_date }}</td>
                        <td>
                            <span class="badge {{ $rec->recurring_is_prediction ? 'prediction' : 'fixed' }}">
                                {{ $rec->recurring_is_prediction ? 'Predikció' : 'Fix' }}
                            </span>
                        </td>
                        <td>
                            <button onclick="editRecurring({{ $rec->recurring_id }})">Szerkesztés</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="recurringModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeRecurringModal()">&times;</span>
            <div id="recurringModalBody"></div>
        </div>
    </div>

</x-layout>
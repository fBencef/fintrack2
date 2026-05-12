@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout title="Recurring">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ismétlődő tranzakciók') }}
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
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white border border-gray-100 shadow-sm sm:rounded-2xl">
                
                <!-- Header -->
                <div class="flex flex-col gap-4 mb-8 md:flex-row md:items-center md:justify-between">
                    <div>
                        <!--h3 class="text-lg font-bold text-gray-900">Ismétlődő tranzakciók kezelése</h3-->
                    </div>
                    
                    <button type="button" onclick="openCreateRecurringModal()" 
                        class="inline-flex items-center px-5 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded transition-all shadow-sm hover:shadow-lg active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Új ismétlődés
                    </button>
                </div>

                <!-- Table Wrapper -->
                <div class="overflow-x-auto border border-gray-100">

                    <!--x-pending-queue :pendingTransactions="$recurrings"/-->

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="bg-gray-100">
                                <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Megnevezés</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Összeg</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Gyakoriság</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Következő esedékesség</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Típus</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Műveletek</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($recurrings as $recurring)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <!-- Name and category -->
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $recurring->recurring_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $recurring->category->category_name }} / 
                                        {{ $recurring->subcategory?->subcategory_name ?? '-' }}</div>
                                    </td>
                                    
                                    <!-- Amount -->
                                    <td class="px-6 py-4 text-lg font-bold text-gray-900">
                                        {{ number_format(abs($recurring->recurring_amount), 0, ',', ' ') }}
                                        <span class="text-base font-normal text-gray-700">{{ $recurring->currency->currency_sign }}</span>
                                    </td>

                                    <!-- Frequency -->
                                    <td class="px-6 py-4 text-base text-gray-900">
                                        {{ $recurring->frequency_intervall }} 
                                        {{ match($recurring->frequency_type) {
                                            'daily' => 'naponta',
                                            'weekly' => 'hetente',
                                            'monthly' => 'havonta',
                                            'yearly' => 'évente',
                                            default => $recurring->frequency_type
                                        } }}
                                    </td>

                                    <!-- Next Date -->
                                    <td class="px-6 py-4 text-base font-medium text-gray-900">
                                        {{ date('Y. m. d.', strtotime($recurring->next_execution_date)) }} | 
                                        @if($recurring->next_execution_date->isPast() && !$recurring->next_execution_date->isToday())
                                            <span class="text-red-500 font-bold">Késésben</span>
                                        @elseif($recurring->next_execution_date->isToday())
                                            <span class="text-amber-600 font-bold">Ma</span>   
                                        @elseif($recurring->next_execution_date->isTomorrow())
                                            <span class="text-emerald-600 font-bold">Holnap</span> 
                                        @elseif($recurring->next_execution_date->isCurrentWeek())
                                            <span class="text-indigo-500">Ezen a héten</span>  
                                        @else
                                            <span class="text-gray-400">
                                                {{ ceil(now()->diffInDays($recurring->next_execution_date) / 7) }} hét múlva
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Type -->
                                    <td class="px-6 py-4 text-center">
                                        @if($recurring->recurring_is_prediction)
                                            <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-sm bg-amber-100 text-amber-700 border border-amber-200">
                                                Várható
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-sm bg-emerald-100 text-emerald-700 border border-blue-200">
                                                Fix
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-center text-sm font-medium ">
                                        <div class="flex justify-center items-center">
                                            <!-- Edit -->
                                            <button onclick="editRecurring({{ $recurring->recurring_id }})" 
                                                class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <!-- Delete Button -->
                                            <form action="{{ route('recurring.destroy', $recurring->recurring_id) }}" method="POST" 
                                                onsubmit="return confirm('Biztosan törölni szeretnéd ezt az ismétlődést?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-700 hover:text-red-900 transition-colors p-2 hover:bg-rose-50 rounded-lg">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                                        Nincsenek beállított ismétlődő tranzakciók.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="recurringModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeRecurringModal()">&times;</span>
            <div id="recurringModalBody"></div>
        </div>
    </div>

    <div id="editModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <div id="recurringEditBody"></div>
        </div>
    </div>

</x-app-layout>
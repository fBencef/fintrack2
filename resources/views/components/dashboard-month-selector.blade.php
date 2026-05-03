@props(['selectedMonth', 'prevMonth', 'nextMonth', 'isCurrentMonth'])

<div class="bg-white p-4 shadow-sm sm:rounded-lg mb-6 flex items-center justify-between">
    <div class="flex items-center space-x-2">
        <!-- Previous Month -->
        <a href="{{ route('dashboard', ['month' => $prevMonth]) }}" class="p-2 hover:bg-gray-100 rounded-full transition text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </a>

        <!-- Month Picker -->
        <form action="{{ route('dashboard') }}" method="GET" id="monthFilterForm">
            <input type="month" name="month" value="{{ $selectedMonth }}" 
                   onchange="this.form.submit()"
                   class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-bold text-gray-700">
        </form>

        <!-- Next Month -->
        <a href="{{ route('dashboard', ['month' => $nextMonth]) }}" class="p-2 hover:bg-gray-100 rounded-full transition text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </a>
    </div>
    
    <div class="flex items-center space-x-3">
        @if(!$isCurrentMonth)
            <a href="{{ route('dashboard') }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-1 rounded-full transition">
                Aktuális hónap
            </a>
        @endif
    </div>
</div>
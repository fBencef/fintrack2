@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beállítások') }}
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

    <!-- CATEGORIES -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Kategóriák kezelése</h3>
                    <button onclick="openCreateCategoryModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Új kategória
                    </button>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Név</th>
                            <th class="p-3">Típus</th>
                            <th class="p-3">Leírás</th>
                            <th class="p-3">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr class="border-b">
                                <td class="p-3">{{ $category->category_name }}</td>
                                <td class="p-3">
                                        @if($category->category_direction == '-')
                                            (-) Kiadás
                                        @elseif($category->category_direction == '/')
                                            (+/-) Kétirányú
                                        @else
                                            (+) Bevétel
                                        @endif
                                </td>
                                <td class="p-3">{{ $category?->category_description ?? '-' }}</td>
                                <td class="p-3">
                                    <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" onsubmit="return confirm('Biztosan törölni szeretnéd ezt a kategóriát? Ez az összes alkategóriáját is törölni fogja!')">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                            Törlés
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- ACCOUNTS -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Pénztárcák / Számlák</h3>
                    <p class="mt-1 text-sm text-gray-600">Itt kezelheted a rögzített bankszámláidat és készpénzes tárolóidat.</p>
                    
                    <ul class="mt-4 divide-y">
                        @foreach($accounts as $account)
                            <li class="py-2 flex justify-between">{{ $account->account_name }} <span>{{ $account->account_balance }}</span></li>
                        @endforeach
                    </ul>
                    <x-secondary-button class="mt-4">+ Új számla</x-secondary-button>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Kategóriák</h3>
                    <p class="mt-1 text-sm text-gray-600">Tranzakcióid csoportosításához használt kategóriák kezelése.</p>
                    </div>
            </div>

        </div>
    </div>


    <!-- MODALS -->
    <!-- Categories -->
    <div id="categoryModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; margin:10% auto; padding:20px; width:40%; border-radius:8px;">
            <h3 class="text-xl font-bold mb-4">Új kategória</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Kategória neve</label>
                    <input type="text" name="category_name" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Típus</label>
                    <select name="category_direction" class="w-full border rounded p-2">
                        <option value="-">Kiadás (-)</option>
                        <option value="+">Bevétel (+)</option>
                        <option value="/">Kétirányú (+/-)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Leírás</label>
                    <input type="text" name="category_description" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeCategoryModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Mégse</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mentés</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
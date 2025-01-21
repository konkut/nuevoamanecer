<div class="p-6 text-gray-800">
    <div class="text-center mb-6">
        <h2 class="text-md font-bold text-gray-700">{{__('word.panel.inventory.title')}}</h2>
        <p class="text-sm text-gray-500">{{__('word.panel.inventory.subtitle')}}</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{__('word.panel.inventory.product')}}</th>
                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">{{__('word.panel.inventory.quantity')}}</th>
                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">{{__('word.panel.inventory.price')}}</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($inventory as $item)
                <tr>
                    <td class="px-3 py-2 text-xs text-gray-700">{{ $item->name }}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ $item->stock }}</td>
                    <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ $item->price }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{--
<div class="bg-white shadow-xl rounded-lg mt-8">
    <div class="p-6 text-gray-800">
        <div class="text-center mb-6">
            <h2 class="text-lg font-bold text-gray-700">{{__('word.panel.method.title')}}</h2>
            <p class="text-sm text-gray-500">{{__('word.panel.method.subtitle')}}</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        {{__('word.panel.method.column_one')}}
                    </th>
                    <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                        {{__('word.panel.method.column_two')}}
                    </th>
                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        {{__('word.panel.method.column_three')}}
                    </th>
                    <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                        {{__('word.panel.method.column_four')}}
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @if(count($data) > 0)
                    @foreach($data as $item)
                        <tr>
                            <td class="px-3 py-2 text-xs text-gray-700">{{ $item['name'] }}</td>
                            <td class="px-3 py-2 text-xs text-gray-700">{{ number_format($item['income'],2,'.','') }}</td>
                            <td class="px-3 py-2 text-xs text-gray-700">{{ number_format($item['expense'],2,'.','')}}</td>
                            <td class="px-3 py-2 text-xs text-gray-700">{{ number_format($item['total'],2,'.','')}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="px-3 py-6 text-sm text-gray-500 text-center">
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="block mt-2 text-xs text-gray-400">{{__('word.panel.summary.subtitle')}}</span>
                            </div>
                        </td>
                    </tr>
                @endif
                </tbody>
                @if(count($data) > 0)
                    <tfoot>
                    <tr>
                        <th class="px-3 py-3 text-start text-gray-900 font-extrabold text-sm uppercase tracking-wider">{{__('word.panel.summary.total')}}</th>
                        <th class="px-3 py-3 text-right text-gray-900 font-extrabold text-sm uppercase tracking-wider">{{number_format($total,2,'.','') ?? "0.00"}}</th>
                    </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

--}}

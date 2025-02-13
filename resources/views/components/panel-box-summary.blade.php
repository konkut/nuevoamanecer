<div class="bg-white p-6 rounded-lg shadow-md w-52 flex-1">
    <h2 class="text-lg font-bold text-gray-700 text-center">{{$title}}</h2>
    <div class="text-center my-6"><p class="text-sm text-gray-500">{{$titlecash}}</p></div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{$cash}}</th>
                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">{{$total}}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @if(count($value['cashregister']['data']) > 0)
                @foreach($value['cashregister']['data'] as $item)
                    <tr>
                        <td class="px-3 py-2 text-xs text-gray-700">{{ $item["name"] }}</td>
                        <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ number_format($item["total"],2,'.','') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="px-3 py-6 text-sm text-gray-500 text-center">
                        <div class="flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="block mt-2 text-xs text-gray-400">{{$subtitle}}</span>
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
            @if(count($value['cashregister']['data']) > 0)
                <tfoot>
                <tr>
                    <th class="px-3 py-3 text-start text-gray-900 font-extrabold text-sm uppercase tracking-wider">{{$total}}</th>
                    <th class="px-3 py-3 text-right text-gray-900 font-extrabold text-sm uppercase tracking-wider">{{number_format($value['cashregister']['total'],2,'.','') ?? "0.00"}}</th>
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
    <div class="text-center my-6"><p class="text-sm text-gray-500">{{$titlebank}}</p></div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{$account}}</th>
                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">{{$total}}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @if(count($value['bankregister']['data']) > 0)
                @foreach($value['bankregister']['data'] as $item)
                    <tr>
                        <td class="px-3 py-2 text-xs text-gray-700">{{ $item["name"] }}</td>
                        <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ number_format($item["total"],2,'.','') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="px-3 py-6 text-sm text-gray-500 text-center">
                        <div class="flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="block mt-2 text-xs text-gray-400">{{$subtitle}}</span>
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
            @if(count($value['bankregister']['data']) > 0)
                <tfoot>
                <tr>
                    <th class="px-3 py-3 text-start text-gray-900 font-extrabold text-sm uppercase tracking-wider">{{$total}}</th>
                    <th class="px-3 py-3 text-right text-gray-900 font-extrabold text-sm uppercase tracking-wider">{{number_format($value['bankregister']['total'],2,'.','') ?? "0.00"}}</th>
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
    <div class="text-center my-6"><p class="text-sm text-gray-500">{{$titlemethod}}</p></div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{$method}}</th>
                <th class="px-3 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">{{$total}}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @if(count($value['platform']['data']) > 0)
                @foreach($value['platform']['data'] as $item)
                    <tr>
                        <td class="px-3 py-2 text-xs text-gray-700">{{ $item["name"] }}</td>
                        <td class="px-3 py-2 text-xs text-gray-700 text-right">{{ number_format($item["total"],2,'.','') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="px-3 py-6 text-sm text-gray-500 text-center">
                        <div class="flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="block mt-2 text-xs text-gray-400">{{$subtitle}}</span>
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
            @if(count($value['platform']['data']) > 0)
                <tfoot>
                <tr>
                    <th class="px-3 py-3 text-start text-gray-900 font-extrabold text-sm uppercase tracking-wider">{{$total}}</th>
                    <th class="px-3 py-3 text-right text-gray-900 font-extrabold text-sm uppercase tracking-wider">{{number_format($value['platform']['total'],2,'.','') ?? "0.00"}}</th>
                </tr>
                </tfoot>
            @endif
        </table>
    </div>
    {{--
    <div class="text-center mt-6">
        <p class="text-sm text-gray-500 font-medium tracking-wide">{{$current}}</p>
        <p class="text-{{$color}}-600 font-extrabold text-3xl mt-4 ">1,000</p>
    </div>--}}
</div>

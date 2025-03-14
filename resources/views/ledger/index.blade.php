<x-app-layout>
    <x-slot name="title">
        {{ __('word.ledger.meta.index.title') }}
    </x-slot>
    <x-slot name="metaDescription">
        {{ __('word.ledger.meta.index.description')}}
    </x-slot>
    <x-slot name="metaKeywords">
        {{ __('word.ledger.meta.index.keywords')}}
    </x-slot>
    <x-slot name="metaOgTitle">
        {{ __('word.ledger.meta.index.title') }}
    </x-slot>
    <x-slot name="metaOgDescription">
        {{ __('word.ledger.meta.index.description')}}
    </x-slot>
    <x-slot name="js_files">
        <script type="text/javascript" src="{{ asset('/js/control/search.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/focus_and_blur.js?v='.time()) }}"></script>
        <script type="text/javascript" src="{{ asset('/js/ledger/search_account.js?v='.time()) }}"></script>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('word.ledger.resource.index') }}
        </h2>
    </x-slot>
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto p-4">
                    <div class="flex justify-end space-x-2 items-center mb-4">
                        <div class="relative flex justify-center items-center">
                            <i class="bi-journal-text absolute left-2 text-[1.3em] text-[#d1d5db]"></i>
                            <input id="query" type="text"
                                   onkeyup="search_analyticalaccount(this)"
                                   placeholder="{{ __('word.voucher.search') }} ..."
                                   class="first-element focus-and-blur pl-9 pr-3 py-[6px] border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm w-full">
                        </div>
                        <form method="GET" action="{{ route('accounting.ledger') }}" onchange="this.submit()"
                              class="flex gap-2">
                            <div class="relative flex justify-center items-center">
                                <i class="bi bi-folder absolute left-2 text-[1.3em] text-[#d1d5db]"></i>
                                <select name="analyticalaccount_uuid"
                                        onchange="update_account_uuid(this)"
                                        class="select-analyticalaccount focus-and-blur text-sm w-72 pl-9 pr-3 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm">
                                    @foreach($accounts as $key => $item)
                                        <option value="{{$key}}" {{ $key == $analyticalaccount_uuid ? 'selected' : '' }}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <select name="perPage" class="focus-and-blur text-sm pr-8 w-36 py-2 border-b-4 border-l-0 border-r-0 border-t-0 border-gray-300 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 active:outline-0 rounded-md shadow-sm">
                                <option
                                    value="20" {{ $perPage == 20 ? 'selected' : '' }}>{{ __('word.general.20_items') }}</option>
                                <option
                                    value="50" {{ $perPage == 50 ? 'selected' : '' }}>{{ __('word.general.50_items') }}</option>
                                <option
                                    value="100" {{ $perPage == 100 ? 'selected' : '' }}>{{ __('word.general.100_items') }}</option>
                            </select>
                        </form>
                    </div>
                    <div class="overflow-x-auto text-black">
                        <table id="table_cash" class="w-full border-collapse border-[#2563eb] text-center text-xs">
                            <thead>
                            <tr class="bg-[#d1d5db]" title="{{__('word.general.title_icon_filter')}}">
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.ledger.filter.date') }}')">{{ __('word.ledger.attribute.date') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.ledger.filter.type') }}')">{{ __('word.ledger.attribute.type') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.ledger.filter.company') }}')">{{ __('word.ledger.attribute.company') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.ledger.filter.project') }}')">{{ __('word.ledger.attribute.project') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.ledger.filter.narration') }}')">{{ __('word.ledger.attribute.narration') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.ledger.filter.debit') }}')">{{ __('word.ledger.attribute.debit') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.ledger.filter.credit') }}')">{{ __('word.ledger.attribute.credit') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ledgers as $item)
                                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->date }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1"> {{ $item->type }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->company ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->project ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->narration ?? "--"}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->debit ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->credit ?? ""}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-wrapper mt-4">
                        {!! $ledgers->appends(['perPage' => $perPage])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
                        <form method="GET" action="{{ route('accounting.export') }}"
                              class="flex flex-row justify-end items-center gap-4 flex-wrap">
                            <button type="submit" title="{{__('word.general.title_icon_excel_generate')}}"
                                    class="bg-lime-400 text-white w-11 h-9 flex justify-center items-center rounded text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                    <path
                                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5zM3 12v-2h2v2zm0 1h2v2H4a1 1 0 0 1-1-1zm3 2v-2h3v2zm4 0v-2h3v1a1 1 0 0 1-1 1zm3-3h-3v-2h3zm-7 0v-2h3v2z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <div class="overflow-x-auto text-black">
                        <table id="table_cash" class="w-full border-collapse border-[#2563eb] text-center text-xs">
                            <thead>
                            <tr class="bg-[#d1d5db]" title="{{__('word.general.title_icon_filter')}}">
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1">#</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.class') }}')">{{ __('word.balance.attribute.class') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.group') }}')">{{ __('word.balance.attribute.group') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.subgroup') }}')">{{ __('word.balance.attribute.subgroup') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.main') }}')">{{ __('word.balance.attribute.main') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.analytical') }}')">{{ __('word.balance.attribute.analytical') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.name') }}')">{{ __('word.balance.attribute.name') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.debit') }}')">{{ __('word.balance.attribute.debit') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.credit') }}')">{{ __('word.balance.attribute.credit') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.debits') }}')">{{ __('word.balance.attribute.debits') }}</th>
                                <th class="border-t border-b border-[#d1d5db] px-2 py-1 cursor-pointer"
                                    onclick="enable_seach_cash(this, '{{ __('word.balance.filter.credits') }}')">{{ __('word.balance.attribute.credits') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($balances as $item)
                                <tr class="hover:bg-[#d1d5db44] transition duration-200">
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $loop->iteration }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->class }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->group }}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->subgroup ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->main ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->analytical ?? "--"}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ $item->name ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->debit,2,'.',',') ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->credit,2,'.',',') ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->debits,2,'.',',') ?? ""}}</td>
                                    <td class="border-t border-b border-[#d1d5db] px-2 py-1">{{ number_format($item->credits,2,'.',',') ?? ""}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--
                      <div class="pagination-wrapper mt-4">
                          {!! $balances->appends(['perPage' => $perPage])->links() !!}
                      </div>
                    --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

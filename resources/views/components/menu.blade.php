@php
    $menuItems = [
        'dashboard' => ['route' => 'dashboard', 'label' => __('Dashboard'), 'icon' => 'bi-house'],
        __('word.dashboard.menu.accounting') => [
            'title' => __('word.dashboard.menu.accounting'),
            'items' => [
                ['route' => 'vouchers.index', 'label' => __('word.voucher.title'), 'icon' => 'bi-file-text'],
                ['route' => 'accounting.ledger', 'label' => __('word.ledger.title'), 'icon' => 'bi-file-text'],
                ['route' => 'accounting.balances', 'label' => __('word.balance.title'), 'icon' => 'bi-file-text'],
            ]
        ],
         __('word.dashboard.menu.accounting_management') => [
            'title' => __('word.dashboard.menu.accounting_management'),
            'items' => [
                ['route' => 'accounts.index', 'label' => __('word.account.link'), 'icon' => 'bi-layers'],
                ['route' => 'projects.index', 'label' => __('word.project.title'), 'icon' => 'bi bi-clipboard-data'],
                ['route' => 'companies.index', 'label' => __('word.company.title'), 'icon' => 'bi bi-buildings'],
                ['route' => 'businesstypes.index', 'label' => __('word.businesstype.title'), 'icon' => 'bi bi-buildings'],
                ['route' => 'activities.index', 'label' => __('word.activity.title'), 'icon' => 'bi bi-lightning-charge'],
            ]
        ],
        __('word.dashboard.menu.finance') => [
            'title' => __('word.dashboard.menu.finance'),
            'items' => [
                ['route' => 'cashregisters.index', 'label' => __('word.cashregister.title'), 'icon' => 'bi-credit-card'],
                ['route' => 'bankregisters.index', 'label' => __('word.bankregister.title'), 'icon' => 'bi-bank'],
                ['route' => 'platforms.index', 'label' => __('word.platform.title'), 'icon' => 'bi bi-pc-display'],
                ['route' => 'cashshifts.index', 'label' => __('word.cashshift.title'), 'icon' => 'bi-clock']
            ]
        ],
        __('word.dashboard.menu.operations') => [
            'title' => __('word.dashboard.menu.operations'),
            'items' => [
                ['route' => 'revenues.index', 'label' => __('word.revenue.title'), 'icon' => 'bi-cash'],
                ['route' => 'incomes.index', 'label' => __('word.income.title'), 'icon' => 'bi-cash'],
                ['route' => 'sales.index', 'label' => __('word.sale.title'), 'icon' => 'bi-cash'],
                ['route' => 'expenses.index', 'label' => __('word.expense.title'), 'icon' => 'bi-cash'],
                ['route' => 'receipts.index', 'label' => __('word.receipt.title'), 'icon' => 'bi-receipt'],
                ['route' => 'invoices.index', 'label' => __('word.invoice.title'), 'icon' => 'bi-receipt'],
            ]
        ],
        __('word.dashboard.menu.financial_management') => [
            'title' => __('word.dashboard.menu.financial_management'),
            'items' => [
                ['route' => 'users.index', 'label' => __('word.user.title'), 'icon' => 'bi-people'],
                ['route' => 'customers.index', 'label' => __('word.customer.title'), 'icon' => 'bi bi-person'],
                ['route' => 'categories.index', 'label' => __('word.category.title'), 'icon' => 'bi-grid'],
                ['route' => 'services.index', 'label' => __('word.service.title'), 'icon' => 'bi bi-tag'],
                ['route' => 'products.index', 'label' => __('word.product.title'), 'icon' => 'bi bi-box-seam'],
            ]
        ],

    ];
@endphp
<nav>
    <div class="shrink-0 flex items-center justify-center ">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('/images/logo.png') }}" alt="Logo Nuevo Amanecer" class="block h-16">
        </a>
    </div>
    <ul class="mt-6">
        <li>
            <a href="{{ route('dashboard') }}"
               class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-blue-500 transition
                      {{ request()->routeIs('dashboard') ? 'bg-blue-500' : '' }}">
                <i class="bi bi-house"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        @php
            $projects = \App\Models\Project::where('status', true)->get();
        @endphp
        <div class="relative mt-4">
            <select required id="project_uuid" name="project_uuid"
                    class="appearance-none bg-gray-800 text-white border border-gray-600 rounded-lg px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-md"
                    onchange="fetch_project('{{url('/')}}', this.value)">
                <option value="" disabled selected class="text-gray-500">
                    {{ __('word.dashboard.select_project') }}
                </option>
                @foreach($projects as $item)
                    <option value="{{ $item->project_uuid }}"
                        {{ old('project_uuid') == $item->project_uuid ? 'selected' : '' }}>
                        {{$item->name}}
                    </option>
                @endforeach
            </select>
            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                     fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"/>
                </svg>
            </div>
        </div>

        @foreach($projects as $item)
            <a id="project-form-{{ $item->project_uuid }}"
               href="{{ route('accounting.session', $item->project_uuid) }}"
               style="display: none;">
            </a>
        @endforeach
        @foreach ($menuItems as $key => $section)
            @if (isset($section['title']))
                <li class="mt-4">
                    <h3 class="text-gray-400 uppercase text-xs font-semibold px-4">{{ $section['title'] }}</h3>
                </li>
                @foreach ($section['items'] as $item)
                    @can($item['route'])
                        @if(($item['route'] == 'vouchers.index' || $item['route'] == 'accounting.ledger' || $item['route'] == 'accounting.balances')  && session('project_uuid'))
                            <li>
                                <a href="{{ route($item['route']) }}"
                                   class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-blue-500 transition
                                  {{ request()->routeIs($item['route']) ? 'bg-blue-500' : '' }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endif
                        @if($item['route'] != 'vouchers.index' && $item['route'] != 'accounting.ledger' && $item['route'] != 'accounting.balances')
                            <li>
                                <a href="{{ route($item['route']) }}"
                                   class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-blue-500 transition
                                  {{ request()->routeIs($item['route']) ? 'bg-blue-500' : '' }}">
                                    <i class="{{ $item['icon'] }}"></i>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endif
                    @endcan
                @endforeach
            @endif
        @endforeach
    </ul>
</nav>

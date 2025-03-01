@php
    $menuItems = [
        'dashboard' => ['route' => 'dashboard', 'label' => __('Dashboard'), 'icon' => 'bi-house'],
        'contabilidad' => [
            'title' => 'Contabilidad',
            'items' => [
                ['route' => 'accounts.index', 'label' => __('word.account.link'), 'icon' => 'bi-layers'],
                ['route' => 'vouchers.index', 'label' => __('word.voucher.title'), 'icon' => 'bi-file-text'],
            ]
        ],
        'finanzas' => [
            'title' => 'Finanzas',
            'items' => [
                ['route' => 'cashregisters.index', 'label' => __('word.cashregister.title'), 'icon' => 'bi-credit-card'],
                ['route' => 'bankregisters.index', 'label' => __('word.bankregister.title'), 'icon' => 'bi-bank'],
                ['route' => 'platforms.index', 'label' => __('word.platform.title'), 'icon' => 'bi bi-pc-display'],
                ['route' => 'cashshifts.index', 'label' => __('word.cashshift.title'), 'icon' => 'bi-clock']
            ]
        ],
        'operaciones' => [
            'title' => 'Operaciones',
            'items' => [
                ['route' => 'incomes.index', 'label' => __('word.income.title'), 'icon' => 'bi-cash'],
                ['route' => 'sales.index', 'label' => __('word.sale.title'), 'icon' => 'bi-cash'],
                ['route' => 'expenses.index', 'label' => __('word.expense.title'), 'icon' => 'bi-cash'],
                ['route' => 'receipts.index', 'label' => __('word.receipt.title'), 'icon' => 'bi-receipt'],
            ]
        ],
        'administracion' => [
            'title' => 'Administración',
            'items' => [
                ['route' => 'users.index', 'label' => __('word.user.title'), 'icon' => 'bi-people'],
                ['route' => 'categories.index', 'label' => __('word.category.title'), 'icon' => 'bi-grid'],
                ['route' => 'services.index', 'label' => __('word.service.title'), 'icon' => 'bi bi-tag'],
                ['route' => 'products.index', 'label' => __('word.product.title'), 'icon' => 'bi bi-box-seam'],
                ['route' => 'projects.index', 'label' => __('word.project.title'), 'icon' => 'bi bi-clipboard-data'],
                ['route' => 'companies.index', 'label' => __('word.company.title'), 'icon' => 'bi bi-buildings'],
                ['route' => 'activities.index', 'label' => __('word.activity.title'), 'icon' => 'bi bi-lightning-charge'],
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
               class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-blue-600 transition
                      {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-house"></i>
                <span>{{ __('Dashboard') }}</span>
            </a>
        </li>
        @foreach ($menuItems as $key => $section)
            @if (isset($section['title']))
                <li class="mt-4">
                    <h3 class="text-gray-400 uppercase text-xs font-semibold px-4">{{ $section['title'] }}</h3>
                </li>
                @foreach ($section['items'] as $item)
                    @can($item['route'])
                        <li>
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-blue-600 transition
                                  {{ request()->routeIs($item['route']) ? 'bg-blue-600' : '' }}">
                                <i class="{{ $item['icon'] }}"></i>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endcan
                @endforeach
            @endif
        @endforeach
    </ul>
</nav>

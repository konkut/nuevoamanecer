<x-app-layout>
  <x-slot name="title">
    {{ __('word.incomefromtransfer.meta.show.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.incomefromtransfer.meta.show.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.incomefromtransfer.meta.show.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.incomefromtransfer.meta.show.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.incomefromtransfer.meta.show.description')}}
  </x-slot>

  <x-slot name="js_files">

  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.incomefromtransfer.resource.show') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto flex bg-gray-800 text-gray-200 rounded-2xl shadow-2xl overflow-hidden max-w-4xl p-8 transition-transform transform hover:scale-105 hover:shadow-lg">
      <div class="p-6 text-center">
        <h2 class="uppercase tracking-wider text-1xl text-indigo-400 font-semibold">{{ __('word.incomefromtransfer.resource.show') }}</h2>
        <hr class="my-4 border-gray-600">

        <h1 class="block mt-2 text-xl font-extrabold text-white">{{ __('word.incomefromtransfer.attribute.code') }}:
          {{ $incomefromtransfer->code }}
        </h1>

        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.incomefromtransfer.attribute.amount') }}</p>
          <p class="text-md text-gray-200">{{ implode(', ', json_decode($incomefromtransfer->amounts, true)) }}</p>
        </div>

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400"><strong>{{ __('word.incomefromtransfer.attribute.service_uuid') }}</strong></p>
          @if ($relatedServices->isNotEmpty())
          @foreach ($relatedServices as $service)
          <p class="text-md text-gray-200">{{ $service }}</p>
          @endforeach
          @else
          <p>No hay servicios relacionados.</p>
          @endif
        </div>

        @if($incomefromtransfer->commissions)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.incomefromtransfer.attribute.commission') }}</p>
          <p class="text-md text-gray-200">{{ implode(', ', json_decode($incomefromtransfer->commissions, true)) }}</p>
        </div>
        @endif

        @if($incomefromtransfer->observation)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.incomefromtransfer.attribute.observation') }}</p>
          <p class="text-md text-gray-200">{{ $incomefromtransfer->observation }}</p>
        </div>
        @endif

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.incomefromtransfer.attribute.status') }}</p>
          <p class="text-md text-gray-200">{{ $incomefromtransfer->status ? '🟢' : '🔴' }}</p>
        </div>

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.incomefromtransfer.attribute.created_at') }}</p>
          <p class="text-md text-gray-200"> {{ $incomefromtransfer->created_at->format('H:i d/m/Y') }}</p>
        </div>

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.incomefromtransfer.attribute.updated_at') }}</p>
          <p class="text-md text-gray-200"> {{ $incomefromtransfer->updated_at->format('H:i d/m/Y') }}</p>
        </div>

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.incomefromtransfer.attribute.user_id') }}</p>
          <p class="text-md text-gray-200">{{ $incomefromtransfer->user->name }}</p>
        </div>
      </div>
      <div class="p-6 text-center">
        <h2 class="uppercase tracking-wider text-1xl text-indigo-400 font-semibold">{{ __('word.denomination.resource.show') }}</h2>
        <hr class="my-4 border-gray-600">
        @if($denomination->bill_200)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.denomination.billete') . ' ' . __('word.denomination.attribute.bill_200') }}</p>
          <p class="text-md text-gray-200">{{ $denomination->bill_200 }}</p>
        </div>
        @endif
        @if($denomination->bill_100)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{__('word.denomination.billete') . ' ' . __('word.denomination.attribute.bill_100') }}</p>
          <p class="text-md text-gray-200">{{ $denomination->bill_100 }}</p>
        </div>
        @endif
        @if($denomination->bill_50)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.denomination.billete') . ' ' . __('word.denomination.attribute.bill_50') }}</p>
          <p class="text-md text-gray-200">{{ $denomination->bill_50 }}</p>
        </div>
        @endif
        @if($denomination->bill_20)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.denomination.billete') . ' ' . __('word.denomination.attribute.bill_20')  }}</p>
          <p class="text-md text-gray-200">{{ $denomination->bill_20 }}</p>
        </div>
        @endif
        @if($denomination->bill_10)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.denomination.billete') . ' ' . __('word.denomination.attribute.bill_10')  }}</p>
          <p class="text-md text-gray-200">{{ $denomination->bill_10 }}</p>
        </div>
        @endif
        @if($denomination->coin_5)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{__('word.denomination.moneda') . ' ' . __('word.denomination.attribute.coin_5')}}</p>
          <p class="text-md text-gray-200">{{ $denomination->coin_5 }}</p>
        </div>
        @endif
        @if($denomination->coin_2)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.denomination.moneda') . ' ' . __('word.denomination.attribute.coin_2') }}</p>
          <p class="text-md text-gray-200">{{ $denomination->coin_2 }}</p>
        </div>
        @endif
        @if($denomination->coin_1)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{__('word.denomination.moneda') . ' ' . __('word.denomination.attribute.coin_1') }}</p>
          <p class="text-md text-gray-200">{{ $denomination->coin_1 }}</p>
        </div>
        @endif
        @if($denomination->coin_0_5)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{__('word.denomination.moneda') . ' ' . __('word.denomination.attribute.coin_0_5')}}</p>
          <p class="text-md text-gray-200">{{ $denomination->coin_0_5 }}</p>
        </div>
        @endif
        @if($denomination->coin_0_2)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{__('word.denomination.moneda') . ' ' . __('word.denomination.attribute.coin_0_2')}}</p>
          <p class="text-md text-gray-200">{{ $denomination->coin_0_2 }}</p>
        </div>
        @endif
        @if($denomination->coin_0_1)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{__('word.denomination.moneda') . ' ' . __('word.denomination.attribute.coin_0_1')}}</p>
          <p class="text-md text-gray-200">{{ $denomination->coin_0_1 }}</p>
        </div>
        @endif
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.denomination.attribute.total') }}</p>
          <p class="text-md text-gray-200">{{ $denomination->total }}</p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
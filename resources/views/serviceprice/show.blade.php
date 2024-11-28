<x-app-layout>
  <x-slot name="title">
    {{ __('word.service.meta.show.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.service.meta.show.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.service.meta.show.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.service.meta.show.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.service.meta.show.description')}}
  </x-slot>

  <x-slot name="js_files">

  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.service.resource.show') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-md mx-auto bg-gray-800 text-gray-200 rounded-2xl shadow-2xl overflow-hidden md:max-w-2xl p-8 transition-transform transform hover:scale-105 hover:shadow-lg">
      <div class="p-6 text-center">
        <h2 class="uppercase tracking-wider text-1xl text-indigo-400 font-semibold">{{ __('word.service.resource.show') }}</h2>
        <hr class="my-4 border-gray-600">

        <h1 class="block mt-2 text-xl font-extrabold text-white">{{ __('word.service.attribute.name') }}:
          {{ $serviceprice->name }}
        </h1>

        @if($serviceprice->description)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.description') }}</p>
          <p class="text-md text-gray-200">{{ $serviceprice->description }}</p>
        </div>
        @endif

        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.amount') }}</p>
          <p class="text-md text-gray-200">{{ $serviceprice->amount }}</p>
        </div>

        @if($serviceprice->commission)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.commission') }}</p>
          <p class="text-md text-gray-200">{{ $serviceprice->commission }}</p>
        </div>
        @endif
        {{--
      <div class="mt-6">
        <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.currency_uuid') }}</p>
        <p class="text-md text-gray-200">{{ $serviceprice->currency->name }}</p>
      </div>
      --}}
      <div class="mt-4">
        <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.category_uuid') }}</p>
        <p class="text-md text-gray-200">{{ $serviceprice->category->name }}</p>
      </div>

      <div class="mt-4">
        <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.status') }}</p>
        <p class="text-md text-gray-200">{{ $serviceprice->status ? '🟢' : '🔴' }}</p>
      </div>

      <div class="mt-4">
        <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.created_at') }}</p>
        <p class="text-md text-gray-200"> {{ $serviceprice->created_at->format('H:i d/m/Y') }}</p>
      </div>

      <div class="mt-4">
        <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.updated_at') }}</p>
        <p class="text-md text-gray-200"> {{ $serviceprice->updated_at->format('H:i d/m/Y') }}</p>
      </div>

      <div class="mt-4">
        <p class="text-sm font-semibold text-gray-400">{{ __('word.service.attribute.user_id') }}</p>
        <p class="text-md text-gray-200">{{ $serviceprice->user->name }}</p>
      </div>
    </div>
  </div>
  </div>



</x-app-layout>
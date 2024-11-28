<x-app-layout>
  <x-slot name="title">
    {{ __('word.category.meta.show.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.category.meta.show.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.category.meta.show.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.category.meta.show.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.category.meta.show.description')}}
  </x-slot>

  <x-slot name="js_files">

  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.category.resource.show') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-md mx-auto bg-gray-800 text-gray-200 rounded-2xl shadow-2xl overflow-hidden md:max-w-2xl p-8 transition-transform transform hover:scale-105 hover:shadow-lg">
      <div class="p-6 text-center">
        <h2 class="uppercase tracking-wider text-1xl text-indigo-400 font-semibold">{{ __('word.category.resource.show') }}</h2>
        <hr class="my-4 border-gray-600">

        <h1 class="block mt-2 text-xl font-extrabold text-white">{{ __('word.category.attribute.name') }}:
          {{ $category->name }}
        </h1>

        @if($category->description)
        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.category.attribute.description') }}</p>
          <p class="text-md text-gray-200">{{ $category->description }}</p>
        </div>
        @endif

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.category.attribute.status') }}</p>
          <p class="text-md text-gray-200">{{ $category->status ? '🟢' : '🔴' }}</p>
        </div>

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.category.attribute.created_at') }}</p>
          <p class="text-md text-gray-200"> {{ $category->created_at->format('H:i d/m/Y') }}</p>
        </div>

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.category.attribute.updated_at') }}</p>
          <p class="text-md text-gray-200"> {{ $category->updated_at->format('H:i d/m/Y') }}</p>
        </div>
      </div>
    </div>
  </div>



</x-app-layout>
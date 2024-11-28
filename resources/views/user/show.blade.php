<x-app-layout>
  <x-slot name="title">
    {{ __('word.user.meta.show.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.user.meta.show.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.user.meta.show.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.user.meta.show.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.user.meta.show.description')}}
  </x-slot>

  <x-slot name="js_files">

  </x-slot>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.user.resource.show') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-md mx-auto bg-gray-800 text-gray-200 rounded-2xl shadow-2xl overflow-hidden md:max-w-2xl p-8 transition-transform transform hover:scale-105 hover:shadow-lg">
      <div class="p-6 text-center">
        <h2 class="uppercase tracking-wider text-1xl text-indigo-400 font-semibold">{{ __('word.user.resource.show') }}</h2>
        <hr class="my-4 border-gray-600">

        <h1 class="block mt-2 text-xl font-extrabold text-white">{{ __('word.user.attribute.name') }}:
          {{ $user->name }}
        </h1>

        <div class="mt-6">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.user.attribute.email') }}</p>
          <p class="text-md text-gray-200">{{ $user->email }}</p>
        </div>

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.user.attribute.created_at') }}</p>
          <p class="text-md text-gray-200"> {{ $user->created_at->format('H:i d/m/Y') }}</p>
        </div>

        <div class="mt-4">
          <p class="text-sm font-semibold text-gray-400">{{ __('word.user.attribute.updated_at') }}</p>
          <p class="text-md text-gray-200"> {{ $user->updated_at->format('H:i d/m/Y') }}</p>
        </div>
      </div>
    </div>
  </div>



</x-app-layout>
<x-app-layout>
  <x-slot name="title">
    {{ __('word.dashboard.title') }}
  </x-slot>

  <x-slot name="metaDescription">
    {{ __('word.dashboard.meta.description')}}
  </x-slot>

  <x-slot name="metaKeywords">
    {{ __('word.dashboard.meta.keywords')}}
  </x-slot>

  <x-slot name="js_files">

  </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-4 bg-gray-800 text-white rounded-lg shadow-md">

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Card 1: Total Services -->
            <div class="bg-gradient-to-r from-blue-400 via-indigo-500 to-purple-600 text-white p-6 rounded-lg shadow-lg">
              <div class="flex items-center justify-between">
                <div class="text-2xl font-semibold">Total Services</div>
                <div class="text-4xl"><i class="bi bi-file-earmark-person"></i></div>
              </div>
              <p class="mt-2 text-lg">12 Services</p>
              <div class="mt-4 h-1 bg-blue-200 rounded-full">
                <div class="w-3/4 h-full bg-blue-600"></div>
              </div>
            </div>

            <!-- Card 2: Total Categories -->
            <div class="bg-gradient-to-r from-green-400 via-teal-500 to-blue-600 text-white p-6 rounded-lg shadow-lg">
              <div class="flex items-center justify-between">
                <div class="text-2xl font-semibold">Total Categories</div>
                <div class="text-4xl"><i class="bi bi-folder"></i></div>
              </div>
              <p class="mt-2 text-lg">8 Categories</p>
              <div class="mt-4 h-1 bg-green-200 rounded-full">
                <div class="w-2/3 h-full bg-green-600"></div>
              </div>
            </div>

            <!-- Card 3: Total Users -->
            <div class="bg-gradient-to-r from-pink-400 via-red-500 to-yellow-600 text-white p-6 rounded-lg shadow-lg">
              <div class="flex items-center justify-between">
                <div class="text-2xl font-semibold">Total Users</div>
                <div class="text-4xl"><i class="bi bi-person-lines-fill"></i></div>
              </div>
              <p class="mt-2 text-lg">35 Users</p>
              <div class="mt-4 h-1 bg-pink-200 rounded-full">
                <div class="w-5/6 h-full bg-pink-600"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
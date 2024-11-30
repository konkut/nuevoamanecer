<x-app-layout>
  <x-slot name="title">
    {{ __('word.user.meta.index.title') }}
  </x-slot>
  <x-slot name="metaDescription">
    {{ __('word.user.meta.index.description')}}
  </x-slot>
  <x-slot name="metaKeywords">
    {{ __('word.user.meta.index.keywords')}}
  </x-slot>
  <x-slot name="metaOgTitle">
    {{ __('word.user.meta.index.title') }}
  </x-slot>
  <x-slot name="metaOgDescription">
    {{ __('word.user.meta.index.description')}}
  </x-slot>

  <x-slot name="js_files">
    <script type="text/javascript" src="{{ asset('/js/lang/es.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/delete_modal.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/assign_role_modal.js?v='.time()) }}"></script>
    <script type="text/javascript" src="{{ asset('/js/field_search.js?v='.time()) }}"></script>
    <script src="{{ asset('js/user/index.js?v='.time()) }}"></script>
  </x-slot>


  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('word.user.resource.index') }}
    </h2>
  </x-slot>

  @if (session('success'))
  <x-alert :message="session('success')" />
  @endif
  <div class="py-12 ">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="overflow-hidden shadow-xl sm:rounded-lg">
      <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
          <a href="{{ route('users.create') }}" class="bg-green-500 text-white px-4 py-2 rounded text-sm">
            <i class="bi bi-plus"></i>
          </a>
          <form method="GET" action="{{ route('users.index') }}" onchange="this.submit()" class="inline-block">
            <select name="perPage" class="border border-gray-300 rounded text-sm pr-8 w-36">
              <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>{{ __('word.general.10_items') }}</option>
              <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>{{ __('word.general.20_items') }}</option>
              <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>{{ __('word.general.50_items') }}</option>
            </select>
          </form>
        </div>

        <!-- Tabla de datos -->
        <div class="overflow-x-auto text-black dark:text-white">
          <table class="min-w-full border border-collapse border-[#2563eb] text-center text-sm">
            <thead>
              <tr class="bg-[#2563eb] text-white">
                <th class="border border-[#2563eb] px-2 py-1">#</th>
                <th class="border border-[#2563eb] px-2 py-1 cursor-pointer" onclick="enableSearch(this, 'Nombre')">{{ __('word.user.attribute.name') }}</th>
                <th class="border border-[#2563eb] px-2 py-1 cursor-pointer" onclick="enableSearch(this, 'Correo electrónico')">{{ __('word.user.attribute.email') }}</th>
                <th class="border border-[#2563eb] px-2 py-1 cursor-pointer" onclick="enableSearch(this, 'Fecha de registro')">{{ __('word.user.attribute.created_at') }}</th>
                <th class="border border-[#2563eb] px-2 py-1">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr class="hover:bg-slate-700 transition duration-200">
                <td class="border border-[#2563eb] px-2 py-1">{{ $loop->iteration }}</td>
                <td class="border border-[#2563eb] px-2 py-1">{{ $user->name }}</td>
                <td class="border border-[#2563eb] px-2 py-1">{{ $user->email}}</td>
                <td class="border border-[#2563eb] px-2 py-1">{{ $user->created_at->diffForHumans() }}</td>
                <td class="border border-[#2563eb] px-2 py-1">
                  <div class="flex justify-center space-x-1">
                    <a href="{{ route('users.show', $user->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded text-xs">
                      <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('users.edit', $user->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="bg-violet-500 text-white px-2 py-1 rounded text-xs" onclick="openRoleModal('{{ $user->id }}')">
                      <i class="bi bi-person-plus"></i>
                    </button>
                    <button type="button" class="bg-red-500 text-white px-2 py-1 rounded text-xs" onclick="openModal('{{ $user->id }}', '{{ $user->name }}')">
                      <i class="bi bi-x-circle"></i>
                    </button>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div class="pagination-wrapper mt-4">
          {!! $users->appends(['perPage' => $perPage])->links() !!}
        </div>
      </div>
    </div>
  </div>
</div>



</x-app-layout>
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

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="overflow-hidden shadow-xl sm:rounded-lg">
        <div class="container mx-auto p-4">
          <div class="flex justify-between mb-4">
            <a href="{{ route('users.create') }}" class="bg-green-500 text-white px-6 py-3 rounded">
              <i class="bi bi-plus"></i>
            </a>
            <form method="GET" action="{{ route('users.index') }}" onchange="this.submit()" class="inline-block">
              <select name="perPage" class="border border-gray-300 rounded pr-8 w-36">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>{{ __('word.general.10_items') }}</option>
                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>{{ __('word.general.20_items') }}</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>{{ __('word.general.50_items') }}</option>
              </select>
            </form>

          </div>

          <!-- Tabla de datos -->
          <table class="min-w-full border border-collapse border-[#2563eb] text-white text-center">
            <thead>
              <tr class="bg-[#2563eb] text-white">
                <th class="border border-[#2563eb] p-3">#</th>
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Nombre')">{{ __('word.user.attribute.name') }}</th>
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Correo electrónico')">{{ __('word.user.attribute.email') }}</th>
                <th class="border border-[#2563eb] p-3 cursor-pointer" onclick="enableSearch(this, 'Fecha de registro')">{{ __('word.user.attribute.created_at') }}</th>
                <th class="border border-[#2563eb] p-3">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr class="hover:bg-slate-700 transition duration-200">
                <th class="border border-[#2563eb] p-2">{{ $loop->iteration }}</th>
                <td class="border border-[#2563eb] p-2">{{ $user->name }}</td>
                <td class="border border-[#2563eb] p-2">{{ $user->email}}</td>
                <td class="border border-[#2563eb] p-2">{{ $user->created_at->diffForHumans() }}</td>
                <td class="border border-[#2563eb] p-2 flex justify-evenly">
                  <a href="{{ route('users.show', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('users.edit',$user->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <div class="flex justify-evenly">
                    <button type="button" class="bg-violet-500 text-white px-4 py-2 rounded" onclick="openRoleModal('{{$user->id}}')">
                      <i class="bi bi-person-plus"></i> 
                    </button>
                  </div>
                  <div class="flex justify-evenly">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded" onclick="openModal('{{$user->id}}', '{{$user->name}}')">
                      <i class="bi bi-x-circle"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Modal -->
              <div id="modal-{{$user->id}}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                  <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                    <div class="modal-header p-4 border-b flex justify-between items-center">
                      <h1 class="text-lg font-semibold text-gray-800">{{__('word.general.delete_title')}}</h1>
                      <button type="button" class="close-modal text-gray-500 hover:text-gray-700" onclick="closeModal('{{$user->id}}')">&times;</button>
                    </div>
                    <div class="modal-body p-6">
                      <p class="text-gray-600">{{__('word.user.delete_confirmation')}} <strong id="name-{{$user->id}}"></strong>{{__('word.general.delete_warning')}}</p>
                    </div>
                    <div class="flex justify-evenly">
                      <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="openRoleModal('{{$user->id}}')">
                        <i class="bi bi-person-plus"></i> {{ __('word.user.assign_roles') }}
                      </button>
                    </div>
                    <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                      <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400" onclick="closeModal('{{$user->id}}')">{{ __('Close') }}</button>
                      <form id="delete-form-{{$user->id}}" action="{{route('users.destroy',$user->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-red-600">{{ __('Delete') }}</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal de asignación de roles -->
              <div id="role-modal-{{$user->id}}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                  <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3 transform transition-all scale-100 opacity-100 duration-300">
                    <!-- Encabezado del modal -->
                    <div class="modal-header p-4 border-b flex justify-between items-center">
                      <h1 class="text-lg font-semibold text-gray-800">{{__('word.user.assign_roles')}} a {{ $user->name }}</h1>
                      <button type="button" class="close-modal text-gray-500 hover:text-gray-700" onclick="closeRoleModal('{{$user->id}}')">&times;</button>
                    </div>

                    <!-- Cuerpo del modal con los checkboxes de roles -->
                    <div class="modal-body p-6">
                      <form id="assign-roles-form-{{$user->id}}" action="{{ route('users.assign_roles', $user->id) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                          @foreach($roles as $role)
                          <div class="flex items-center">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}_{{$user->id}}"
                              class="h-4 w-4 text-indigo-600 border-gray-300 rounded mr-2"
                              {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                            <label for="role_{{ $role->id }}_{{$user->id}}" class="text-gray-700">{{ $role->name }}</label>
                          </div>
                          @endforeach
                        </div>
                      </form>
                    </div>

                    <!-- Pie del modal con los botones de acción -->
                    <div class="modal-footer p-4 border-t flex justify-end space-x-2">
                      <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded transition duration-300 hover:bg-gray-400" onclick="closeRoleModal('{{$user->id}}')">
                        {{ __('Close') }}
                      </button>
                      <button type="submit" form="assign-roles-form-{{$user->id}}" class="bg-blue-500 text-white px-4 py-2 rounded transition duration-300 hover:bg-blue-600">
                        {{ __('Save') }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              @endforeach
            </tbody>
          </table>
          <div class="pagination-wrapper mt-4">
            {!! $users->appends(['perPage' => $perPage])->links() !!}
          </div>
        </div>

      </div>
    </div>
  </div>


</x-app-layout>
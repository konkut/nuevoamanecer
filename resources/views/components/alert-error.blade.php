<div
  class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg"
  role="alert"
  x-data="{ show: true }"
  x-show="show"
  x-init="setTimeout(() => show = false, 3000)">
  <span class="block sm:inline">{{ $message }}</span>
</div>

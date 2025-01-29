<div
  class="fixed top-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded shadow-lg"
  role="alert"
  x-data="{ show: true }"
  x-show="show"
  x-init="setTimeout(() => show = false, 3000)">
  <span class="block sm:inline">{{ $message }}</span>
</div>

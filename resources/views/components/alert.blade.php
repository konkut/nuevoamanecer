<div
  class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg"
  role="alert"
  x-data="{ show: true }"
  x-show="show"
  x-init="setTimeout(() => show = false, 3000)">
  <span class="block sm:inline">{{ $message }}</span>
</div>

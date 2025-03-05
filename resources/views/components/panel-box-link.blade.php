<a href="{{$route}}"
   class="bg-blue-400 text-white px-6 py-6 rounded-lg shadow-md cursor-pointer hover:shadow-2xl transition-shadow">
    <div class="flex items-center justify-between">
        <div class="text-lg font-semibold">{{ $title }}</div>
        <div class="text-2xl"><i class="bi bi-receipt"></i></div>
    </div>
    <p class="mt-1 text-sm">{{$total}} {{ $subtitle }}</p>
    <div class="mt-2 h-1 bg-blue-100 rounded-full">
        <div class="w-2/3 h-full bg-blue-300"></div>
    </div>
</a>

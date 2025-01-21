
@if($cashshift)
    <x-panel-box-session :cashshift="$cashshift"></x-panel-box-session>
@else
    <div class="w-full xl:w-72 sm:px-6 lg:px-0 pt-8">
        <x-panel-box-date-session/>
    </div>
@endif

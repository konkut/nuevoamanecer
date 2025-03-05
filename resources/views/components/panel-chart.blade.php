<div class="w-full xl:w-1/3">
    {!! $cash->container() !!}
</div>
<div class="w-full xl:w-1/3">
    {!! $bank->container() !!}
</div>
<div class="w-full xl:w-1/3">
    {!! $platform->container() !!}
</div>
<script src="{{ $cash->cdn() }}"></script>
{!! $cash->script() !!}
<script src="{{ $bank->cdn() }}"></script>
{!! $bank->script() !!}
<script src="{{ $platform->cdn() }}"></script>
{!! $platform->script() !!}



@if(\Illuminate\Support\Facades\Session::has('info'))
    <div class="alert alert-info mt-5" role="alert">
        {{\Illuminate\Support\Facades\Session::get('info')}}
    </div>
@endif

@if($errors->count())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
@if(Session::has('danger'))
    <div class="alert alert-danger">
        {!! Session::get('danger') !!}
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success">
        {!! Session::get('success') !!}
    </div>
@endif
@if(Session::has('info'))
    <div class="alert alert-info">
        {!! Session::get('info') !!}
    </div>
@endif

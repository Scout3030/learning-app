@if($errors->any())
    <div class="form-errors">
        @foreach($errors as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif
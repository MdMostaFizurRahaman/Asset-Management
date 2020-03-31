@if(count($errors)>0)

    <div class="box-body" style="padding-bottom: 0px;">
        <div class="callout callout-warning">
            <h4><i class="icon fa fa-warning"></i> Error!</h4>
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        </div>
    </div>

@endif
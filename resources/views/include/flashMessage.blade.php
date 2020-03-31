@if(Session::has('success'))
    <div class="box-body">
        <div class="callout callout-success">
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <p>{{session('success')}}</p>
        </div>
    </div>
@endif

@if(Session::has('error'))
    <div class="box-body" style="padding-bottom: 0px;">
        <div class="callout callout-warning">
            <h4><i class="icon fa fa-warning"></i> Error!</h4>
            <p>{{session('error')}}</p>

        </div>
    </div>
@endif

@if(Session::has('warning'))
    <div class="box-body" style="padding-bottom: 0px;">
        <div class="callout callout-warning">
            <h4><i class="icon fa fa-warning"></i> Warning!</h4>
            <p>{{session('warning')}}</p>
        </div>
    </div>
@endif

@if(Session::has('forceLogoutError'))
    <div class="callout callout-warning">
        <h4><i class="icon fa fa-warning"></i> Error!</h4>
        <p>{{session('forceLogoutError')}}</p>
    </div>

@endif



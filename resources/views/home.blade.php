@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
  window.addEventListener("load", function() {  
    if(document.getElementById('tabulator') != null){
      var table = new Tabulator("#tabulator", {
        layout:"fitColumns",
        movableColumns:true,
        pagination:"local",
        paginationSize:10,
        initialSort:[
          {column:"code", dir:"desc"}, 
        ]
      });
    }  
  },false);
</script>

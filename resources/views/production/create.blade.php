@extends('home')@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add a Production') }}
                    <a class="float-right" href="{{ route('production.index') }}">{{ __('Back') }}</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                    @endif
                    <form method="post" action="{{ route('production.store') }}">
                        @csrf 
                        <input type="date" id="production_date" name="production_date" required>
                        
                        <table class="table table-striped">
                            <tr>
                                <th tabulator-formatter="html"><label for="code">{{ __('Code') }}</label></th> 
                                <th ><label for="code">{{ __('Product') }}</label></th> 
                                <th><label for="code">{{ __('Remaining Quantity') }}</label></th> 
                                <th tabulator-formatter="html"><label for="code">{{ __('To be Produced') }}</label></th> 
                            </tr>
                            <?php //$a = 1; ?>
                            @foreach($orderdata as $orderdatas)
                            <tr> 
                                <input type="hidden" value="{{$orderdatas->order_id}}" name="order_id[]" >
                                <input type="hidden" value="{{$orderdatas->product_id}}" name="product_id[]" >
                                <input type="hidden" value="{{$orderdatas->quantity}}" name="quantity[]" >
                                <input type="hidden" value="{{$orderdatas->id}}" class="productionid" >
                                <input type="hidden" value="{{$orderdatas->quantity}}" >
                                <input type="hidden" value="{{$orderdatas->remaining_quantity}}" id="storeqty_{{$orderdatas->id}}" name="remainingquantity[]" >

                                <!-- <input type="text" class="to_be_pro"  /> -->

                                <?php //$a++; ?>                             
                                <td>
                                  <button type="button" class="btn btn-lg btn-default" 
                                          data-toggle="popover" 
                                          data-trigger="focus"
                                          title="{{ $orderdatas->first_name }} {{ $orderdatas->last_name }}" 
                                          data-content="{{ $orderdatas->delivery_date }}">
                                          {{$orderdatas->code}}
                                  </button>
                                </td>
                                <td>{{$orderdatas->name}}</td>
                                <td>{{$orderdatas->remaining_quantity}}</td>
                                <td><input type="number" min="0" max="{{$orderdatas->remaining_quantity}}" class="form-control to_be_pro" autocomplete="off" id="to_be_pro_{{$orderdatas->product_id}}_{{$orderdatas->name}}" name="to_be_produced[]"  onkeyup="handleEvt(this, {{$orderdatas->id}},{{$orderdatas->product_id}},{{$orderdatas->remaining_quantity}},'{{$orderdatas->name}}', event)" />
                                    <span id="error{{$orderdatas->id}}"></span></td>                                          
                                </tr>
                                @endforeach
                                
                            </table>                                              
                            <button class="btn btn-link" type="submit" id="submit_btn" >{{ __('Add Production') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
               <table class="table table-striped">
                <tr>
                    <th><label for="code">{{ __('Product Name') }}</label></th> 
                    <th><label for="code">{{ __('Total Quantity that will be produced') }}</label></th>
                    <!-- <input type="text" class="total" value="" />  -->
                </tr>
                @foreach($production as $productions)
                <tr>
                    <td>{{$productions->name}}</td>
                    <td><input type="text" class="total_{{$productions->name}}" readonly="" style="border: none;"></td>
                </tr> 
                @endforeach
            </table>
          </div>
        </div>
      </div>
      
</div>
@endsection


<script> 
 var myarray = [];
 function handleEvt(e, oid,pid,qty,pname) {    
   
    var entryInput = parseInt(e.value); 

    var storeqty = parseInt($('#storeqty_'+oid).val());

    if(entryInput > storeqty){
        $('#error'+oid).html('<p style="color:red">Input quantity is greater then total quantity</p>');
        $('#submit_btn').prop('disabled',true);
    }else{ 
        $('#submit_btn').prop('disabled',false);
        $(".to_be_pro").each(function(){
            $(".total_"+ $(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1)).val('');
        }) ; 
        $(".to_be_pro").each(function(){ 
            if(true){ 
                var oldval= 0;  
                var newval = 0;
                var totalval=0;           
                if($(this).val() !="")
                { 
                    oldval = $(this).val();
                }
                if($(".total_"+ $(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1)).val() !=""  )
                { 
                    newval = $(".total_"+ $(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1)).val();
                } 
                totalval=(parseInt(oldval)+ parseInt(newval)); 
                $(".total_"+ $(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1)).val('');
                $(".total_"+ $(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1)).val(totalval);

            }            
        });        
        if(entryInput <= storeqty ){

            $('#error'+oid).empty(); 
        }  
    }


}

window.addEventListener("load", function() {
  $(function () {
    $('[data-toggle="popover"]').popover()
  })
  
},false);

//define some sample data

</script>
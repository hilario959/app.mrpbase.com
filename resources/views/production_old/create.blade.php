@extends('home')@section('content')
<div class="container">
<a class="float-right" href="{{ route('production.index') }}">{{ __('Back') }}</a>
    <div class="row">
        <div class="col-md-12 form-group">
            <form>
                <div class="form-group">
                    <label for="production_date">{{ __('Production Date') }}</label>
                    <input type="date" class="form-control" id="production_date" required>
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
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
                <table class="table table-light border rounded">
                    <tr>
                        <th tabulator-formatter="html"><label for="code">{{ __('Code') }}</label></th> 
                        <th ><label for="code">{{ __('Product') }}</label></th> 
                        <th><label for="code">{{ __('Remaining') }}</label></th> 
                        <th tabulator-formatter="html"><label for="code">{{ __('Production') }}</label></th> 
                    </tr>
                    @foreach($orderdata as $orderdatas)
                    <tr> 
                        <input type="hidden" value="{{$orderdatas->order_id}}" name="order_id[]" >
                        <input type="hidden" value="{{$orderdatas->product_id}}" name="product_id[]" >
                        <input type="hidden" value="{{$orderdatas->quantity}}" name="quantity[]" >
                        <input type="hidden" value="{{$orderdatas->id}}" class="productionid" >
                        <input type="hidden" value="{{$orderdatas->quantity}}" >
                        <input type="hidden" value="{{$orderdatas->remaining_quantity}}" id="storeqty_{{$orderdatas->id}}" name="remainingquantity[]" >
                        <td>
                            <span type="button" class="btn btn-lg btn-default" class="orderid" title="{{ $orderdatas->first_name }} {{ $orderdatas->last_name }} {{ $orderdatas->delivery_date }}">
                                {{$orderdatas->code}}
                            </span>
                        </td>
                        <td>{{$orderdatas->name}}
                        </td>
                        <td>{{$orderdatas->remaining_quantity}}</td>
                        <td>
                            <input type="number" min="0" max="{{$orderdatas->remaining_quantity}}" class="form-control to_be_pro" autocomplete="off" id="to_be_pro_{{$orderdatas->product_id}}" name="to_be_produced[]"  onkeyup="handleEvt(this, {{$orderdatas->id}},{{$orderdatas->product_id}},{{$orderdatas->remaining_quantity}},'{{$orderdatas->name}}', event)" />
                            <span id="error{{$orderdatas->id}}"></span>
                        </td>                                          
                    </tr>
                    @endforeach
                </table>                                              
                <button class="btn btn-link" type="submit" id="submit_btn" >{{ __('Add Production') }}</button>
            </form>
        </div>
        <div class="col-md-5">
            <table class="table table-light border rounded">
                <tr>
                    <th><label for="code">{{ __('Product') }}</label></th> 
                    <th><label for="code">{{ __('Total') }}</label></th>
                </tr>
                @foreach($production as $productions)
                <tr>
                    <td>{{$productions->name}}</td>
                    <td><input class="total_{{$productions->id}} form-control" type="text" readonly></td>
                </tr> 
                @endforeach
            </table>
        </div>
    </div>    
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            //console.log($(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1));
        }); 
        
        $(".to_be_pro").each(function(){ 
            if(true){ 
                var oldval = 0;  
                var newval = 0;
                var totalval = 0;   
                var substring = $(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1);
                
                if($(this).val() != "")
                { 
                    oldval = $(this).val();
                }

                if($(".total_"+ substring).val() != ""  )
                {
                    //+ $(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1)).val() !=""
                    //newval = 0;
                    newval = $(".total_"+ substring).val();    
                    console.log(newval+" newval");
                }
                totalval=(parseInt(oldval)+ parseInt(newval)); 
                $(".total_"+ $(this).attr('id').substr($(this).attr('id').lastIndexOf('_') + 1)).val('');
                $(".total_"+ substring).val(totalval);
                console.log(totalval+" totalval");
                console.log(substring);
            }            
        });        
        if(entryInput <= storeqty ){

            $('#error'+oid).empty(); 
        }  
    }


}
$(document).ready(function(){
  $('body .orderid').popover()
})
//define some sample data

</script>
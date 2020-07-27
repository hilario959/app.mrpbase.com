@extends('home')@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update a Order') }}
                    <a class="float-right" href="{{ route('order.index') }}">{{ __('Back') }}</a>
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
                        <form method="post" action="{{ route('order.update', $order->id) }}">
                            @method('PATCH') 
                            @csrf
                            <div class="form-group">    
                                <label for="code">{{ __('Code') }}</label>
                                <input type="text" class="form-control" name="code" value="{{ $order->code }}" />
                            </div>         
                            <div class="form-group">
                                <label for="client_id">{{ __('Client') }}</label>
                                <select class="advance-select-box form-control @error('client') is-invalid @enderror" id="client_id" name="client_id" required>
                                    <option value="" selected disabled>{{ __('Select a Client') }}</option>
                                    @foreach ($client as $clients)
                                        <option value="{{ $clients->id }}" @if($order->client_id == ($clients->id)) selected @endif> {{ $clients->first_name }} </option>
                                    @endforeach
                                </select>
                            </div>           
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select class="advance-select-box form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="" selected disabled>{{ __('Select a Status') }}</option>
                                    <option value="0">{{ __('Received') }}</option>
                                    <option value="1">{{ __('Paid') }}</option>
                                    <option value="2">{{ __('In progress') }}</option>
                                    <option value="3">{{ __('Done') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="delivery_date">{{ __('Delivery Date') }}</label>
                                <input type="text" class="form-control" name="delivery_date" value="{{ $order->delivery_date }}" />
                            </div>
                            <div class="form-group">
                                <label for="notes">{{ __('notes') }}</label>
                                <input type="text" class="form-control" name="notes" value="{{ $order->notes }}" />
                            </div>
                               <div class="well clearfix mb-2 pull-right">
                            <a class="btn btn-success add-record text-white" data-added="0"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                        <!-- <form method="post" id="dynamic_form"> -->
                            <span id="result"></span>
                            <table id="" class="table table-bordered table-striped" id="user_table">
                                <thead>
                                    <tr>
                                        <th tabulator-formatter="html" width="35%">{{ __('Product') }}</th>
                                        <th tabulator-formatter="html" width="35%">{{ __('Quantity') }}</th>
                                        <th tabulator-formatter="html" width="30%">{{ __('Price') }}</th>
                                        <th tabulator-formatter="html" width="30%">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_posts_body">
                                    @if($order_details)
                                    @foreach($order_details as $orderdetail)
                                    @php
                                    $single_product=DB::table('products')->where('id',$orderdetail->product_id)->first();
                                    @endphp
                                    <tr id="rec-{{ $single_product->id }}">
                                        <td>
                              <select class="form-control" name="product_id[]">
                                
                                <option value="{{ $single_product->id }}">{{ $single_product->name }}</option>
                              
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quantity[]" value="{{ $orderdetail->quantity }}" placeholder="{{ __('Quantity') }}">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="price[]" step="0.01" min="0" value="{{ $orderdetail->price }}" placeholder="{{ __('Price') }}">
                        </td>
                        <td><a class="btn btn-danger delete-record text-white" data-id="{{ $single_product->id }}"><i class="fa fa-minus" aria-hidden="true"></i></a></td>
                                    </tr>
                                    @endforeach
                                    @endif


                                </tbody>
                                <tfoot>
                                    @csrf
                                </tfoot>
                            </table>
                            <button type="submit" class="btn btn-link">{{ __('Update Order') }}</button>
                        </form>

                                           <div style="display:none;">
                        <table id="sample_table">
                          <tr id="">
                           <td>
                              <select class="form-control" name="product_id[]">
                                @if(count($product)>0)
                                @foreach($product as $products)
                                <option value="{{ $products->id }}">{{ $products->name }}</option>
                                @endforeach
                                @else
                                <option></option>
                                @endif
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quantity[]" value="" placeholder="{{ __('Quantity') }}">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="price[]" step="0.01" min="0" value="" placeholder="{{ __('Price') }}">
                        </td>
                        <td><a class="btn btn-danger delete-record text-white" data-id="0"><i class="fa fa-minus" aria-hidden="true"></i></a></td>
                    </tr>
                </table>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/order.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    jQuery(document).delegate('a.add-record', 'click', function(e) {
       e.preventDefault();    
       var content = jQuery('#sample_table tr'),
       size = jQuery('#tbl_posts >tbody >tr').length + 1,
       element = null,    
       element = content.clone();
       element.attr('id', 'rec-'+size);
       element.find('.delete-record').attr('data-id', size);
       element.appendTo('#tbl_posts_body');
       element.find('.sn').html(size);
   });
    jQuery(document).delegate('a.delete-record', 'click', function(e) {
       e.preventDefault();    
       var didConfirm = confirm("Are you sure You want to delete");
       if (didConfirm == true) {
          var id = jQuery(this).attr('data-id');
          var targetDiv = jQuery(this).attr('targetDiv');
          jQuery('#rec-' + id).remove();

    //regnerate index number on table
    $('#tbl_posts_body tr').each(function(index) {
      //alert(index);
      $(this).find('span.sn').html(index+1);
  });
    return true;
} else {
    return false;
}
});
</script>
@endsection
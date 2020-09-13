@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <a class="btn btn-lg btn-link" href="{{ route('production.index') }}">< {{ __('Back') }}</a>
        </div>

        <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-products-tab" data-toggle="pill" href="#pills-products" role="tab">
                    {{ __('Products Produced') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-orders-tab" data-toggle="pill" href="#pills-orders" role="tab">
                    {{ __('Orders Fulfilled') }}
                </a>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-products" role="tabpanel">
                @include('production.partials.show_products')
            </div>
            <div class="tab-pane fade" id="pills-orders" role="tabpanel">
                @include('production.partials.show_orders')
            </div>
{{--            <div class="tab-pane fade" id="pills-materials" role="tabpanel">--}}
{{--                @include('production.partials.show_materials')--}}
{{--            </div>--}}
        </div>
    </div>
@endsection

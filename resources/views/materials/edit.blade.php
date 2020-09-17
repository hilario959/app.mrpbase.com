@extends('home')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <a class="btn btn-lg btn-link" href="{{ route('material.index') }}">< {{ __('Back') }}</a>
            </div>

            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-products-tab" data-toggle="pill" href="#pills-products" role="tab">
                        {{ __('Update Material') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-orders-tab" data-toggle="pill" href="#pills-orders" role="tab">
                        {{ __('Inventory') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-products" role="tabpanel">
                    @include('materials.partials.edit_form')
                </div>
                <div class="tab-pane fade" id="pills-orders" role="tabpanel">
                    @include('materials.partials.inventory')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

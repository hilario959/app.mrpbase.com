@extends('home')@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update a Client') }}
                    <a class="float-right" href="{{ route('client.index') }}">{{ __('Back') }}</a>
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
                        <form method="post" action="{{ route('client.update', $client->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group">
                                <label for="first_name">{{ __('First Name') }}</label>
                                <input type="text" class="form-control" name="first_name" value='{{ $client->first_name }}' />
                            </div>
                            <div class="form-group">
                                <label for="last_name">{{ __('Last Name') }}</label>
                                <input type="text" class="form-control" name="last_name" value='{{ $client->last_name }}' />
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Company') }}</label>
                                <input type="text" class="form-control" name="company" value='{{ $client->company }}' />
                            </div>
                            <div class="form-group">
                                <label for="city">{{ __('E-mail Address') }}</label>
                                <input type="text" class="form-control" name="email" value='{{ $client->email }}' />
                            </div>
                            <div class="form-group">
                                <label for="city">{{ __('Phone Number') }}</label>
                                <input type="text" class="form-control" name="number" value='{{ $client->number }}' />
                            </div>
                            <div class="form-group">
                                <label for="country">{{ __('Address') }}</label>
                                <input type="text" class="form-control" name="address" value='{{ $client->address }}' />
                            </div>
                            <div class="form-group">
                                <label for="job_title">{{ __('Tax ID') }}</label>
                                <input type="text" class="form-control" name="tax_id" value='{{ $client->tax_id }}' />
                            </div>
                            <div class="form-group">
                                <label for="job_title">{{ __('Notes') }}</label>
                                <input type="text" class="form-control" name="notes" value='{{ $client->notes }}' />
                            </div>
                            <button type="submit" class="btn btn-link">{{ __('Update Client') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

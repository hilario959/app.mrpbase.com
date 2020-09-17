@extends('home')@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add a Client') }}
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
                        <form method="post" action="{{ route('client.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="first_name">{{ __('First Name') }}</label>
                                <input type="text" class="form-control" name="first_name"/>
                            </div>          <div class="form-group">
                                <label for="last_name">{{ __('Last Name') }}</label>
                                <input type="text" class="form-control" name="last_name"/>
                            </div>          <div class="form-group">
                                <label for="email">{{ __('Company') }}</label>
                                <input type="text" class="form-control" name="company"/>
                            </div>
                            <div class="form-group">
                                <label for="city">{{ __('E-Mail Address') }}</label>
                                <input type="text" class="form-control" name="email"/>
                            </div>
                            <div class="form-group">
                                <label for="city">{{ __('Phone Number') }}</label>
                                <input type="text" class="form-control" name="number"/>
                            </div>
                            <div class="form-group">
                                <label for="country">{{ __('Address') }}</label>
                                <input type="text" class="form-control" name="address"/>
                            </div>
                            <div class="form-group">
                                <label for="job_title">{{ __('Tax ID') }}</label>
                                <input type="text" class="form-control" name="tax_id"/>
                            </div>
                            <div class="form-group">
                                <label for="job_title">{{ __('Notes') }}</label>
                                <input type="text" class="form-control" name="notes"/>
                            </div>
                            <button class="btn btn-link" type="submit">{{ __('Add Client') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

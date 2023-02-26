@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header mt-3">{{ __('Sponsorship Confirmation') }}</div>

                <div class="card-body">
                    <p>Grazie per aver sottoscritto una sponsorizzazione!</p>
                    <a href="{{ route('admin.homes.index') }}" class="btn btn_boolbnb">Torna alla lista dei tuoi appartamenti</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
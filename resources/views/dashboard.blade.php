@extends('layouts.app')

@section('content')
<div class="container mt-4">
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

                    {{ __('Accesso effettuato!') }}
                </div>
            </div>
            <div class="link-homes">
                <a class="btn btn_boolbnb mt-4" href="{{ url('http://localhost:5174/') }}" role="button">
                    <i class="fas fa-angle-left fa-fw"></i> Torna Al Sito
                </a>
            </div>
            <div class="link-homes">
                <a class="btn btn_boolbnb mt-4" href="{{route('admin.homes.index')}}" role="button">
                    Area Personale <i class="fas fa-angle-right fa-fw"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
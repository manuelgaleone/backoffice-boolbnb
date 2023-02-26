@extends('layouts.admin')
@section('content')
<div>
    <a class="btn btn_boolbnb mt-4" href="{{route('admin.homes.index')}}" role="button"><i class="fas fa-angle-left fa-fw"></i>Torna all'Area Personale</a>

    <h1 class="mt-3 text-center">
        Scegli il tipo di sponsorizzazione
    </h1>
</div>

<div class="index_wrapper mt-4">
    <div class="index_elements">
        <div class="row justify-content-center">
            @foreach ($sponsoreds as $sponsored)
            <div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">{{$sponsored->title}}</h5>
                    <div>Prezzo: {{$sponsored->price}} €</div>
                    <div>Durata: {{$sponsored->duration}} h</div>
                    <a href="{{ route('admin.sponsorship.checkout', ['sponsoredId' => $sponsored->id, 'home' => $home->id]) }}" class="btn btn_boolbnb mt-2">Effettua il pagamento</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="container">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 py-4">Modifica {{$sponsored->title}}</h1>
    </div>
    <form action="{{route('admin.sponsored.update', $sponsored->slug)}}" method="post" class="card p-3" enctype="multipart/form-data">
        @csrf

        @method('PUT')
        <div class="mb-3">
            <input type="text" name="title" id="title" class="form-control" placeholder="Nome" value="{{old('title', $sponsored->title)}}" aria-describedby="helpId" required>
        </div>
        <div class="mb-3">
            <input type="text" name="price" id="price" class="form-control" placeholder="Prezzo" value="{{old('price', $sponsored->price)}}" aria-describedby="helpId" required>
        </div>
        <div class="mb-3">
            <input type="number" name="duration" id="duration" class="form-control" placeholder="Durata" value="{{old('duration', $sponsored->duration)}}" aria-describedby="helpId" required>
        </div>
        <button type="submit" class="btn btn_boolbnb">Invia!</button>
    </form>
</div>
@endsection
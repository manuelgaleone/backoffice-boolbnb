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
<div id="app" class="div">
    <div class="container">
        <a href="{{ route('admin.homes.index') }}" class="btn btn_boolbnb my-2">
            <i class="fas fa-angle-left fa-fw"></i> Torna Indietro
        </a>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 py-4">Aggiungi una casa</h1>
        </div>
        <form action="{{route('admin.homes.store')}}" method="post" class="card p-3" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Nome*</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Inserisci un titolo" value="{{old('title')}}" aria-describedby="helpId" required>
            </div>
            <div class="mb-3 d-flex justify-content-between gap-3">
                <div class="flex-grow-1">
                    <label for="rooms" class="form-label">Stanze*</label>
                    <input type="number" name="rooms" id="rooms" class="form-control" placeholder="Numero di stanze" value="{{old('rooms')}}" aria-describedby="helpId" required>
                </div>
                <div class="flex-grow-1">
                    <label for="beds" class="form-label">Letti*</label>
                    <input type="number" name="beds" id="beds" class="form-control" placeholder="Numero di letti" value="{{old('beds')}}" aria-describedby="helpId" required>
                </div>
                <div class="flex-grow-1">
                    <label for="bathrooms" class="form-label">Bagni*</label>
                    <input type="number" name="bathrooms" id="bathrooms" class="form-control" placeholder="Numero di bagni" value="{{old('bathrooms')}}" aria-describedby="helpId" required>
                </div>
                <div class="flex-grow-1">
                    <label for="square_meters" class="form-label">Metri Quadrati*</label>
                    <input type="number" name="square_meters" id="square_meters" class="form-control" placeholder="Metri Quadri" value="{{old('square_meters')}}" aria-describedby="helpId" required>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex">
                    <div class="w-100">
                        <label v-model="address" for="address" class="form-label">Indirizzo*</label>
                        <div class="position-relative">
                            <input type="text" name="address" id="address" class="form-control address" placeholder="Città, Indirizzo, CAP..." value="{{old('address')}}" aria-describedby="helpId" autocomplete="off" required>
                            <div id="address-dropdown" class="dropdown-menu" aria-labelledby="address"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 d-flex">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="visible" value="1" id="visible_1" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Visibile
                    </label>
                </div>
                <div class="form-check px-5">
                    <input class="form-check-input" type="radio" name="visible" value="0" id="visible_0">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Non Visibile
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="services" class="form-label">Servizi*</label>
                <select multiple class="form-select form-select-sm" name="services[]" id="services">
                    <option value="" disabled>Seleziona Servizi</option>


                    @forelse ($services as $service)
                    <option value="{{$service->id}}" {{ in_array($service->id, old('services', [])) ? 'selected' : '' }}>{{$service->title}}</option>
                    @empty
                    <option value="" disabled>Scusa 😥 nessun servizio nel sistema...</option>
                    @endforelse

                </select>
            </div>
            <div class="mb-3">
                <label for="cover_image" class="form-label">Immagine di Copertina*</label>
                <input type="file" class="form-control" name="cover_image" id="cover_image" placeholder="Aggiungi un'immagine" aria-describedby="coverImgHelper">
            </div>
            <p>
                <em>
                    * campi obbligatori
                </em>
            </p>
            <button type="submit" class="btn btn_boolbnb">Invia!</button>
        </form>
    </div>
</div>
<!-- <script src="{{asset('/js/autocomplete.js')}}"></script> -->
<script>
    const API_KEY = "Tch0NAfmIoUvMhD8OyuIvJnGGUrV2269";

    var searchInput = document.getElementById("address");
    var dropdownContainer = document.getElementById("address-dropdown");

    searchInput.addEventListener("input", function(input) {
        /* console.log(e); */
        const searchTerm = input.target.value;

        const xhr = new XMLHttpRequest();
        xhr.open("GET", `https://api.tomtom.com/search/2/search/${searchTerm}.json?key=${API_KEY}&typeahead=true&countrySet=IT&language=it-IT`, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const searchResults = JSON.parse(xhr.responseText);

                dropdownContainer.innerHTML = "";
                for (const result of searchResults.results) {
                    const dropdownItem = document.createElement("div");
                    dropdownItem.classList.add("dropdown-item");
                    dropdownItem.innerText = result.address.freeformAddress;
                    dropdownItem.addEventListener("click", function() {
                        searchInput.value = result.address.freeformAddress;
                        dropdownContainer.classList.remove("show");
                    });
                    dropdownContainer.appendChild(dropdownItem);
                }
                if (searchResults.results.length > 0) {
                    dropdownContainer.classList.add("show");
                } else {
                    dropdownContainer.classList.remove("show");
                }
            }
        };
        xhr.send();
    });

    document.addEventListener("click", function(e) {
        if (!searchInput.contains(e.target)) {
            dropdownContainer.classList.remove("show");
        }
    });
</script>
@endsection
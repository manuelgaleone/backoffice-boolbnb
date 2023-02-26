@extends('layouts.admin')
@section('content')
<a class="btn btn_boolbnb mt-4" href="{{route('admin.homes.index')}}" role="button"><i class="fas fa-angle-left fa-fw"></i>Torna all'Area Personale</a>

<div class="container my-3">
      <div class="row align-items-center">
            <div class="col-12 col-sm-12">
                  <div class="single_home_contents p-2">
                        <div class="title">
                              <h1 class="bold py-3">
                                    {{$home->title}}
                              </h1>
                              <h4>
                                    {{$home->address}}
                              </h4>
                        </div>
                        <div class="card-body justify-content-center my-2">
                              @if($home->cover_image)
                              <img class="img-fluid w-50" src="{{asset('storage/' . $home->cover_image)}}" alt="">
                              @else
                              <div class="placeholder p-5 bg-secondary" style="width:350px">Placeholder</div>

                              @endif
                        </div>

                        <div class="details">
                              <ul class="d-flex">
                                    <li>{{$home->rooms}} stanze</li>
                                    <li class="ms-4">{{$home->beds}} letti</li>
                                    <li class="ms-4">{{$home->bathrooms}} bagni</li>
                                    <li class="ms-4">{{$home->square_meters}}mq</li>
                              </ul>
                        </div>
                        <div class="services">
                              <h3>Servizi disponibili:</h3>
                              <ul class="d-flex ">
                                    @forelse($services as $service)
                                    @if($home->services->contains($service->id))
                                    <li>{{$service->title}}</li>
                                    @else
                                    @endif
                                    @empty
                                    <h4>Nessun servizio</h4>
                                    @endforelse
                                    <!-- risolvere questo empty che non funziona -->
                              </ul>
                        </div>
                        <div>
                              <h2 class="bold mt-3">Messaggi dagli utenti:</h2>
                              @forelse($messages as $message)

                              <div class="card card-message w-50 my-2 p-2">
                                    <div class="text-capitalize d-flex justify-content-between">
                                          <h5>
                                                {{ $message->name }}
                                          </h5>
                                          <span>
                                                {{$message->created_at}}
                                                <!-- $newDate -->
                                          </span>
                                    </div>
                                    <div class="border_bottom">
                                          {{ $message->email }}
                                    </div>
                                    <div>
                                          {{ $message->message }}
                                    </div>
                              </div>


                              @empty
                              <h5>Nessun messaggio per questa casa.</h5>
                              @endforelse

                        </div>

                  </div>
            </div>
      </div>
</div>
</div>
@endsection
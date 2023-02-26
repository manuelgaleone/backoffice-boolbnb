@extends('layouts.admin')

@section('content')
<div>
    <a class="btn btn_boolbnb mt-4" href="{{route('admin.homes.index')}}" role="button"><i class="fas fa-angle-left fa-fw"></i>Torna alla lista delle tue case</a>

    <h1 class="mt-3 text-center">
        Pagamento Sponsorizzazione: {{$sponsored->title}}
    </h1>
</div>

<div class="index_wrapper mt-4">
    <div class="index_elements">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Dati Pagamento') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.sponsorship.process_checkout', ['sponsoredId' => $sponsored->id, 'home' => $home->id]) }}" id="payment-form">
                            @csrf

                            <input type="hidden" name="sponsored_id" value="{{$sponsored->id}}">
                            <input type="hidden" name="payment_method_nonce" id="nonce" />

                            <div class="form-group row">


                                <div class="col-md-6">
                                    <div id="card-number"></div>
                                </div>
                            </div>

                            <div class="form-group row">


                                <div class="col-md-6">
                                    <div id="expiration-date"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn_boolbnb">
                                        {{ __('Paga') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var form = document.querySelector('#payment-form');
    var client_token = "{{ $clientToken }}";
    var submit = document.querySelector('button[type="submit"]');

    braintree.dropin.create({
        authorization: client_token,
        selector: '#card-number',
        card: {
            overrides: {
                fields: {
                    number: {
                        placeholder: 'Inserisci il numero della carta'
                    },
                    expirationDate: {
                        placeholder: 'MM/AA'
                    }
                }
            }
        }
    }, function(createErr, instance) {
        if (createErr) {
            console.log('Create Error', createErr);
            return;
        }

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            submit.setAttribute('disabled', 'disabled');
            instance.requestPaymentMethod(function(err, payload) {
                if (err) {
                    console.log('Request Payment Method Error', err);
                    submit.removeAttribute('disabled');
                    return;
                }
                // Add the nonce to the form and submit
                document.querySelector('#nonce').value = payload.nonce;
                form.submit();
            });
        });
    });
</script>
@endsection
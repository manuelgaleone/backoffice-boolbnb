<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Braintree\Gateway;
use App\Models\Sponsored;
use App\Models\Home;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function getClientToken()
    {
        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        $clientToken = $gateway->clientToken()->generate();

        return view('admin.sponsorship.checkout', compact('clientToken'));
    }

    public function processCheckout(Request $request)
    {
        $sponsoredId = $request->input('sponsored_id');
        $homeId = $request->route('home');

        $sponsored = Sponsored::findOrFail($sponsoredId);
        $home = Home::findOrFail($homeId);

        $nonce = $request->input('payment_method_nonce');

        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        $result = $gateway->transaction()->sale([
            'amount' => $sponsored->price,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            // Il pagamento è stato effettuato con successo, reindirizza l'utente a una view di conferma
            $now = Carbon::now();
            $home->sponsoreds()->attach($sponsoredId, [
                'initial_date' => $now,
                'end_date' => $now->addDays($sponsored->duration)
            ]);
            $home->update(['sponsored' => 1]); // Aggiorna la colonna sponsored della casa sponsorizzata a 1
            return view('admin.sponsorship.confirmation', ['sponsoredId' => $sponsoredId]);
        } else {
            // Il pagamento è fallito, reindirizza l'utente a una view di errore
            return view('admin.sponsorship.index', ['message' => 'Il pagamento ha fallito.']);
        }
    }

    public function showCheckoutForm($sponsoredId, $homeId)
    {
        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);


        $clientToken = $gateway->clientToken()->generate();
        $home = Home::findOrFail($homeId);


        $sponsored = Sponsored::findOrFail($sponsoredId);

        return view('admin.sponsorship.checkout', compact('sponsored', 'clientToken', 'home'));
    }

    public function confirmation($sponsoredId)
    {
        $sponsored = Sponsored::findOrFail($sponsoredId);

        return view('admin.sponsorship.confirmation', compact('sponsored'));
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'home_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $message = new Message();
        $message->home_id = $data['home_id'];
        $message->name = $data['name'];
        $message->email = $data['email'];
        $message->message = $data['message'];
        $message->save();

        return response()->json([
            'success' => true,
            'data' => $message
        ]);
    }
}

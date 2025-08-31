<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Buy;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function purchaseView(Request $request,$item_id){
        $item = Item::find($item_id);
        $user = User::with('profile')->find(Auth::id());
        $payment = $request -> query('payment');
        $search = '';

        return view('auth.buy',compact('item','user','payment','search',));
    }

    public function destinationInput(Request $request,$item_id){
        $payment = $request -> query('payment');
        $search = '';
        return view('auth.destination',compact('item_id','payment','search'));
    }

    public function destinationOrPaymentChange(AddressRequest $request,$item_id){
        $item = Item::find($item_id);
        $user = User::with('profile')->find(Auth::id());
        $payment = $request->payment;
        $search = '';
        $destination_post_code = $request -> destination_post_code;
        $destination_address = $request -> destination_address;
        $destination_building = $request -> destination_building;
        return view('auth.buy',compact('item','user','payment','search','destination_post_code','destination_address','destination_building'));
    }

    public function purchase(PurchaseRequest $request){
        Buy::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'payment' => $request->payment,
            'destination_post_code' => $request->destination_post_code,
            'destination_address' =>  $request->destination_address,
            'destination_building' =>  $request->destination_building,
        ]);
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Models\Buy;
use App\Models\Item;

class ProfileController extends Controller
{
    public function edit(){
        if(Profile::where('user_id',Auth::id())->exists()){
            $id = Auth::id();
            $profile = Profile::where('user_id',$id)->first();
            return view('auth.profile_edit',['search' =>'' ,'profile' => $profile]);
        }else{
            return view('auth.profile_edit',['search' => '']);
        }
    }

    public function update(ProfileRequest $request){
        $form = $request -> all();
        if($request -> file('pict_url') != ''){
            $fileName = $request -> file('pict_url') -> getClientOriginalExtension();
            $request->file('pict_url')->storeAs('/public','profile'.Auth::id().'.'.$fileName);
            $form['pict_url'] = 'storage/profile'.Auth::id().'.'.$fileName;
        }
        unset($form['_token']);
        Profile::updateOrCreate(
            ['user_id' => Auth::id()],
            $form
            );
        User::find(Auth::id()) -> update(['name' => $form['name']]);
        return redirect('/');
    }

    public function profile(Request $request){
        $user = User::find(Auth::id());
        $profile = Profile::where('user_id',Auth::id())->first();
        $items = Item::where('user_id',Auth::id())->get();
        $buys = Buy::all();
        return view('auth.profile',['profile' => $profile,'user'=>$user,'items' => $items,'search'=>$request->search,'buys' => $buys]);
    }

    public function buyOrSell(Request $request){
        $tab = $request -> query('tab');
        $buys = Buy::all();
        if($tab == 'buy'){
            $user = User::find(Auth::id());
            $profile = Profile::where('user_id',Auth::id())->first();
            $buyId = Buy::where('user_id',Auth::id())->pluck('item_id')->toArray();
            $items = Item::whereIn('id',$buyId)->get();
            return view('auth.profile',['profile' => $profile,'user'=>$user,'items' => $items,'search'=>$request->search,'buys' => $buys]);
        }else{
            $user = User::find(Auth::id());
            $profile = Profile::where('user_id',Auth::id())->first();
            $items = Item::where('user_id',Auth::id())->get();
            return view('auth.profile',['profile' => $profile,'user'=>$user,'items' => $items,'search'=>$request->search,'buys' => $buys]);
        }
    }

}
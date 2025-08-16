<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
            $remove_items = Item::where('user_id',Auth::id())->get()->toArray();
            $items = Item::whereNotIn('id',Arr::pluck($remove_items,'id'))->get()->toArray();
            return view('index',['items'=> $items,'search'=>""]);
    }

    public function item_detail(Request $request)
    {
        $item_id = $request -> item_id ;
        return view('welcome',['item_id' => $item_id]);
    }

    public function search(Request $request)
    {
        $tab = $request -> query('tab');
        // マイリストがクリックされたとき
        if ($tab == 'mylist'){
            // お気に入りに登録したアイテムを抽出
            $favorites = Favorite::where('user_id',Auth::id())->get()->toArray();
            // アイテム全体からお気に入りを抽出し検索窓に入力した値で検索
            $items = Item::whereIn('id',Arr::pluck($favorites,'item_id'))->NameSearch($request->search)->get();
            return view('index',['items'=> $items,'search'=>$request->search]);
        }else{
            // 通常の検索
            // 自分の出品したもののid取得
            $remove_items = Item::where('user_id',Auth::id())->get()->toArray();
            // 自分が出品した商品の除去及び名前による検索
            $items = Item::whereNotIn('id',Arr::pluck($remove_items,'id'))->NameSearch($request->search)->get()->toArray();
            return view('index',['items'=> $items,'search'=>$request->search]);
        }
    }

        public function sell(){
            $categories = Category::All();
            // return view('auth.sell')->with('search',"");
            return view('auth.sell',['categories' => $categories,'search' => ""]);
        }

        public function sell_register(ExhibitionRequest $request){
            $form = $request->all();
            // dd($form);
            $newid = Item::max('id') + 1;
            $fileName = $request -> file('pict_url') -> getClientOriginalExtension();
            $request->file('pict_url')->storeAs('/public','item'.$newid.'.'.$fileName);
            $form['pict_url'] = 'storage/item'.$newid.'.'.$fileName;
            $categories = array_values($form['categories']);
            // dd($categories);
            // dd($form);
            Item::create([
                'user_id' => Auth::id(),
                'name' => $form['name'],
                // 'pict_url' => $form['pict_url'],
                'pict_url' => '',
                'brand_name' => $form['brand_name'],
                'price' => $form['price'],
                'detail' => $form['detail'],
                'condition' => $form['condition'],
                'sold' => '0',
            ]);
            // foreach($categories as $category){
            //     $category_single=Category::find($category);
            //     $category_single->items()->attach($newid);
            // }
            return redirect ('/');
        }
}

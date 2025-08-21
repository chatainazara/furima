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
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
            $remove_items = Item::where('user_id',Auth::id())->get()->toArray();
            $items = Item::whereNotIn('id',Arr::pluck($remove_items,'id'))->get()->toArray();
            return view('index',['items'=> $items,'search'=>""]);
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
        $newid = Item::max('id') + 1;
        // if($form['pict_url'] != ''){
            $fileName = $request -> file('pict_url') -> getClientOriginalExtension();
            // dd($form);
            $request->file('pict_url')->storeAs('/public','item'.$newid.'.'.$fileName);
            // dd($form);
            $form['pict_url'] = 'storage/item'.$newid.'.'.$fileName;
        // }else{
            // $form['pict_url'] = '';
        // }
        // dd($form);
        Item::create([
            'user_id' => Auth::id(),
            'name' => $form['name'],
            'pict_url' => $form['pict_url'],
            'brand_name' => $form['brand_name'],
            'price' => $form['price'],
            'detail' => $form['detail'],
            'condition' => $form['condition'],
            'sold' => '0',
        ]);
        $categories = array_values($form['categories']);
        foreach($categories as $category){
            $category_collection = Category::find($category);
            $category_collection->items()->attach($newid);
        }
        return redirect ('/');
    }

    public function item_detail_view(Request $request){
        $item_id = $request -> item_id;
        $item = Item::with('categories')->find($item_id);
        $user_id = Auth::id();
        $favorites = Favorite::where('item_id',$item_id)->get();
        $favorites_count = count($favorites);
        if ($favorites -> contains('user_id',$user_id)){
            $favorite = 'favorite';
        }else{
            $favorite = 'un_favorite';
        }
        $comments = Comment::with(['user.profile'])->where('item_id',$item_id)->get();
        $comments_count = count($comments);
        if ($comments -> contains('user_id',$user_id)){
            $comment = 'comment';
        }else{
            $comment = 'un_comment';
        }

        return view('item_detail',[
            'item' => $item,
            'user_id' => $user_id,
            'comments' => $comments,
            'comments_count' => $comments_count,
            'comment' => $comment,
            'favorites' => $favorites,
            'favorites_count' => $favorites_count,
            'favorite' => $favorite,
            'search' => ''
        ]);
    }

    public function item_detail(CommentRequest $request)
    {
        $item_id = $request -> item_id;
        $item = Item::with('categories')->find($item_id);
        $user_id = Auth::id();
        $favorites = Favorite::where('item_id',$item_id)->get();
        $favorites_count = count($favorites);
        if ($favorites -> contains('user_id',$user_id)){
            $favorite = 'favorite';
        }else{
            $favorite = 'un_favorite';
        }

        $comments = Comment::with(['user.profile'])->where('item_id',$item_id)->get();
        $comments_count = count($comments);
        if ($comments -> contains('user_id',$user_id)){
            $comment = 'comment';
        }else{
            $comment = 'un_comment';
        }

        switch ($request->input('action')) {

            // case 'detail':
            //     return view('item_detail',[
            //         'item' => $item,
            //         'user_id' => $user_id,
            //         'comments' => $comments,
            //         'comments_count' => $comments_count,
            //         'comment' => $comment,
            //         'favorites' => $favorites,
            //         'favorites_count' => $favorites_count,
            //         'favorite' => $favorite,
            //         'search' => ''
            //     ]);

            case 'favorite':
                Favorite::create([
                    'item_id'=>$item_id,
                    'user_id'=>$user_id,
                ]);
                $favorite = 'favorite';
                return view('item_detail',[
                    'item' => $item,
                    'user_id' => $user_id,
                    'comments' => $comments,
                    'comments_count' => $comments_count,
                    'comment' => $comment,
                    'favorites' => $favorites,
                    'favorites_count' => $favorites_count +1,
                    'favorite' => $favorite,
                    'search' => ''
                ]);

            case 'un_favorite':
                Favorite::where('user_id',Auth::id())->where('item_id',$item_id)->delete();
                $favorite = 'un_favorite';
                    return view('item_detail',[
                        'item' => $item,
                        'user_id' => $user_id,
                        'comments' => $comments,
                        'comments_count' => $comments_count,
                        'comment' => $comment,
                        'favorites' => $favorites,
                        'favorites_count' => $favorites_count -1,
                        'favorite' => $favorite,
                        'search' => ''
                    ]);

            case 'comment':
                $content = $request -> content;
                Comment::create([
                    'item_id' => $item_id,
                    'user_id' => $user_id,
                    'content' => $content
                ]);
                $comments = Comment::with(['user.profile'])->where('item_id',$item_id)->get();
                if ($comments -> contains('user_id',$user_id)){
                    $comment = 'comment';
                }else{
                    $comment = 'un_comment';
                }
                    return view('item_detail',[
                        'item' => $item,
                        'user_id' => $user_id,
                        'comments' => $comments,
                        'comments_count' => $comments_count + 1,
                        'comment' => $comment,
                        'favorites' => $favorites,
                        'favorites_count' => $favorites_count,
                        'favorite' => $favorite,
                        'search' => ''
                    ]);

            // case 'buy':
            //     return view('auth.buy',[
            //         'item' => $item,
            //         'search' => '',
            //     ]);
        }





    }
}

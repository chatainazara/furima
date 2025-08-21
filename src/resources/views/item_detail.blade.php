@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
<div class="content">
    <!-- 商品画像 -->
    <div class="content-inner">
        <img class="content__img" src="{{asset($item['pict_url'])}}" alt="" style="width:100%;"/>
    </div>

    <!-- その他の情報 -->
    <div class="content-inner">
        <div class="content__title">
            <h2 class="content__title-text">{{$item['name']}}</h2>
        </div>
        <div class="content__brand">
            <p class="content__brand-name">{{$item['brand_name']}}</p>
        </div>
        <div class="content__price">
            <p class="subscript">¥</p>
            <p class="main-text"><?php echo number_format($item['price'],0); ?></p>
            <p class="subscript">（税込）</p>
        </div>

        <div class="content__react">
            <div class="content__react-part">
                @if(Auth::check())
                <form class="content__react-icon" action="/item/{{$item['id']}}" method="post">
                    @csrf
                    @if($favorite == "favorite")
                    <button class="content__react-icon--inner" type="submit" name="action" value="un_favorite">
                        <img class="content__react-icon--img" src="{{asset('img/_i_icon_14621_icon_146210.svg')}}"/>
                    </button>
                    @elseif($favorite == "un_favorite")
                    <button class="content__react-icon--inner" type="submit" name="action" value="favorite">
                        <img class="content__react-icon--img" src="{{asset('img/_i_icon_14623_icon_146230.svg')}}"/>
                    </button>
                    @endif
                </form>
                @else
                <div class="content__react-icon">
                    <div class="content__react-icon--inner">
                        <img class="content__react-icon--img" src="{{asset('img/_i_icon_14623_icon_146230.svg')}}"/>
                    </div>
                </div>
                @endif
                <div class="content__react-count">
                    {{$favorites_count}}
                </div>
            </div>

            <div class="content__react-part">
                @if(Auth::check())
                <div class="content__react-icon">
                    @if($comment == "comment")
                    <div class="content__react-icon--inner">
                        <img class="content__react-icon--img" src="{{asset('img/_i_icon_11209_icon_112090.svg')}}"/>
                    </div>
                    @else
                    <div class="content__react-icon--inner">
                        <img class="content__react-icon--img" src="{{asset('img/_i_icon_11210_icon_112100.svg')}}"/>
                    </div>
                    @endif
                </div>
                @else
                <div class="content__react-icon">
                    <div class="content__react-icon--inner">
                        <img class="content__react-icon--img" src="{{asset('img/_i_icon_11210_icon_112100.svg')}}"/>
                    </div>
                </div>
                @endif
                <div class="content__react-count">
                    {{$comments_count}}
                </div>
            </div>
        </div>

        <form class="content__buy" action="/item/{{$item['id']}}" method="post">
            @csrf
            <button class="content__buy--button" type="submit" name="action" value="buy">
                購入手続きへ
            </button>
        </form>

        <div class="content__sub-title">
            <h3 class="content__sub-title--text">商品説明</h3>
        </div>
        <div class="content__detail">
            <p class="content__detail--text">{{$item['detail']}}</p>
        </div>
        <div class="content__sub-title">
            <h3 class="content__sub-title--text">商品の情報</h3>
        </div>
        <div class="content__info">
            <div class="content__info--title">カテゴリー</div>
                @foreach($item->categories as $category)
                <div class="content__info--items">
                    <div class="content__info--item">
                        {{$category['content']}}
                    </div>
                </div>
                @endforeach
        </div>
        <div class="content__info">
            <div class="content__info--title">
                商品の状態
            </div>
            <div  class="content__info--item-condition">
                {{$item['condition']}}
            </div>
        </div>
        <div class="content__comment">
            <div class="content__comment-title">
                <h3 class="content__comment-title--text">コメント({{$comments_count}})<h3>
            </div>
            @foreach($comments as $comment)
            <div class="content__comment-content">
                <div class="content__comment--prof">
                    <div class="content__comment--img-wrap">
                        <img class="content__comment--img" src="{{asset($comment['user']['profile']['pict_url'])}}" alt="">
                    </div>
                    <div class="content__comment--name">
                        {{$comment['user']['name']}}
                    </div>
                </div>
                <div class="content__comment--message">
                    <p class="content__comment--message-text">{{$comment['content']}}</p>
                </div>
            </div>
            @endforeach
            @if(Auth::check())
            <form class="content__comment-form" action="/item/{{$item['id']}}" method="post">
            @csrf
                <div class="content__comment-form--title">
                    商品へのコメント
                </div>
                <textarea class="content__comment-form--text" name="content" rows="12" cols="25"></textarea>
                @error('content')
                {{ $message }}
                @enderror
                <button class="content__comment-form--button"type="submit" name="action" value="comment">コメントを送信する</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
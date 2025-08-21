@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="content">

    <!-- プロフィール -->
    <div class="profile__group">
        <div class="profile__inner">
            <div class="profile__img">

                <img class="profile__img--item" src="{{asset($profile['pict_url'])}}" alt=""/>
            </div>
            <div class="profile__name">
                <p class="profile__name--text">{{$user['name']}}</p>
            </div>
            <form class="profile__edit" action="/mypage/profile" method="get">
                @csrf
                <button class="profile__edit--button" type="submit">プロフィールを編集</button>
            </form>
        </div>
    </div>

    <div class="list-top">
        <div class="list-top__inner">
            <form class="list-top__form" action="/mypage?tab=sell" method="post">
                @csrf
                <input type="hidden" name="search" value="{{$search}}">
                <button class="list-top__button-sell" type="submit">出品した商品</button>
            </form>
            <form class="list-top__form" action="/mypage?tab=buy" method="post">
                @csrf
                <input type="hidden" name="search" value="{{$search}}">
                <button class="list-top__button-buy" type="submit">購入した商品</button>
            </form>
        </div>
    </div>

    <div class="list">
        @foreach($items as $item)
        <div class="list__content">
            <div class="list__content-img">
                <form class="list__content--form" action="/item/{{$item['id']}}" method="post" >
                    @csrf
                    <button class="list__content--button" name="action" value="detail" type="submit">
                        <img class="list__content--pict" src="{{$item['pict_url']}}" alt="" />
                    </button>
                </form>
                @if($item['sold']  == 1)
                <div class="list__content-img--attention" >
                    <p class="list__content-img--attention-text" >sold</p>
                </div>
                @endif
            </div>
            <div class="list__content-explain">
                <p class="list__content-text">{{$item['name']}}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

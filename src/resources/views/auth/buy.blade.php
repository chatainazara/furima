@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')
<div class="entire">
    <!-- 画面左側 -->
    <div class="inform">
        <!-- 上段の商品部分 -->
        <div class="content">
            <!-- 商品画像 -->
            <div class="content-inner">
                <img class="content__img" src="{{asset($item['pict_url'])}}" alt="" style="width:100%;"/>
            </div>

            <!-- その他の情報 -->
            <div class="content-inner">
                <div class="content__title">
                    <h2 class="content__title-text">{{$item->name}}</h2>
                </div>
                <div class="content__price">
                    <p class="subscript">¥</p>
                    <p class="main-text"><?php echo number_format($item->price,0); ?></p>
                </div>
            </div>
        </div>

        <!-- 中段の支払い部分 -->
        <div class="payment">
            <div class="payment__title">
                <h3 class="payment__title--text">支払い方法</h3>
            </div>

            <form class="payment__method" method="post" action="/purchase/address/{{ $item->id }}">
            @csrf
                @isset($destination_post_code)
                <input type="hidden" name="destination_post_code" value="{{$destination_post_code}}"/>
                <input type="hidden" name="destination_address" value="{{$destination_address}}"/>
                <input type="hidden" name="destination_building" value="{{$destination_building}}"/>
                @else
                <input type="hidden" name="destination_post_code" value="{{$user->profile->post_code}}"/>
                <input type="hidden" name="destination_address" value="{{$user->profile->address}}"/>
                <input type="hidden" name="destination_building" value="{{$user->profile->building}}"/>
                @endisset

                <select class="payment__method" name="payment" onchange="this.form.submit()">
                    <option value="none" {{ $payment === 'none' ? 'selected' : '' }} disabled selected>選択してください</option>
                    <option value="convenience" {{ $payment === 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="card" {{ $payment === 'card' ? 'selected' : '' }}>カード払い</option>
                </select>
                <div class="form__error">
                @error('payment')
                {{ $message }}
                @enderror
                </div>
            </form>
        </div>

        <!-- 下段の住所部分 -->
        <div class="destination">
            <div class="destination__header">
                <div class=destination__title>
                    <h3 class="destination__title--text">配送先</h3>
                </div>
                <form class="destination__form" action="/purchase/address/{{$item->id}}" method="get">
                    <input type="hidden" name="payment" value="{{$payment}}">
                    <button class="destination__form--button" type="submit">変更する</button>
                </form>
            </div>

            <div class="destination__content">
                @isset($destination_post_code)
                <div class="destination__content-post">{{$destination_post_code}}</div>
                <div class="destination__content-address">{{$destination_address}}</div>
                <div class="destination__content-build">{{$destination_building}}</div>
                @else
                <div class="destination__content-post">{{$user->profile->post_code}}</div>
                <div class="destination__content-address">{{$user->profile->address}}</div>
                <div class="destination__content-build">{{$user->profile->building}}</div>
                @endisset
            </div>
        </div>
    </div>

    <!-- 画面右側 -->
    <div class="confirm">
        <div class="confirm__inner">
            <div class="confirm__title">
                <h3 class="confirm__title--text">
                    商品代金
                </h3>
            </div>
            <div class="confirm__content">
                <p class="subscript">¥</p>
                <p class="main-text"><?php echo number_format($item->price,0); ?></p>
            </div>
        </div>
        <div class="confirm__inner">
            <div class="confirm__title">
                <h3 class="confirm__title--text">
                    支払い方法
                </h3>
            </div>
            <div class="confirm__content">
                @if ($payment === 'card')
                    <p class="main-text">カード払い</p>
                @else
                    <p class="main-text">コンビニ払い</p>
                @endif
            </div>
        </div>
        <form class="purchase__form" action="/purchase" method="post">
        @csrf
            <input type="hidden" name="item_id" value="{{$item->id}}"/>
            <input type="hidden" name="payment" value="{{$payment}}"/>
            @isset($destination_post_code)
            <input type="hidden" name="destination_post_code" value="{{$destination_post_code}}"/>
            <input type="hidden" name="destination_address" value="{{$destination_address}}"/>
            <input type="hidden" name="destination_building" value="{{$destination_building}}"/>
            @else
            <input type="hidden" name="destination_post_code" value="{{$user->profile->post_code}}"/>
            <input type="hidden" name="destination_address" value="{{$user->profile->address}}"/>
            <input type="hidden" name="destination_building" value="{{$user->profile->building}}"/>
            @endisset
            <button class="purchase__button" type="submit">
                購入する
            </button>
        </form>
    </div>
</div>
@endsection

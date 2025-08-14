@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content__top">
        <h2 class="content__top--title">商品の出品</h2>
    </div>

    <form class="form" action="/sell" method="post"  enctype="multipart/form-data" novalidate>
    @csrf
        <div>
            <!-- 商品画像の選択 -->
            <div class="form__group">
                    <h4 class="form__label--item">
                        商品画像
                    </h4>
                    <div class="form__input--img">
                        <input class="form__input--button" type="file" name="pict_url" accept="image/png,image/jpeg" >
                    </div>
                    <div class="form__error">
                        @error('pict_url')
                        {{ $message }}
                        @enderror
                    </div>
            </div>

            <!-- 商品の詳細 -->
            <div class="form__group">
            <h3 class="form__group-title">商品の詳細</h3>
                <!-- カテゴリー -->
                <div class="form__group-inner">
                    <div class="form__group-title">
                        <h4 class="form__label--item">カテゴリー</h4>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--cate">
                            @foreach($categories as $category)
                            <input class="form__input--cate-checkbox" type="checkbox" name="categories[]" id="{{$category['content']}}" value="{{$category['id']}}" />
                            <label class="form__input--cate-label" for="{{$category['content']}}">{{$category['content']}}</label>
                            @endforeach
                        </div>
                        <div class="form__error">
                            @error('categories')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- 商品の状態 -->
                <div class="form__group">
                    <div class="form__group-title">
                        <h4 class="form__label--item">商品の状態</h4>
                    </div>
                    <div class="form__group-content">
                        <select class="form__input--select" name="condition" required>
                            <option value="" disabled selected>選択してください</option>
                            <option value="良好">良好</option>
                            <option value="目立った傷や汚れなし" >目立った傷や汚れなし</option>
                            <option value="やや傷や汚れあり" >やや傷や汚れあり</option>
                            <option value="状態が悪い" >状態が悪い</option>
                        </select>
                        <div class="form__error">
                            @error('condition')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- 商品名と説明 -->
            <div>
            <h3>商品名と説明</h3>
                <!-- 商品名 -->
                <div class="form__group">
                    <div class="form__group-title">
                        <h4 class="form__label--item">商品名</h4>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="name" value="{{old('name')}}" />
                        </div>
                        <div class="form__error">
                            @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- ブランド名 -->
                <div class="form__group">
                    <div class="form__group-title">
                        <h4 class="form__label--item">ブランド名</h4>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="brand_name" value="{{old('brand_name')}}" />
                        </div>
                    </div>
                    <div class="form__error">
                        <!-- バリデーションはここに入れる -->
                    </div>
                </div>
                <!-- 商品の説明 -->
                <div class="form__group">
                    <div class="form__group-title">
                        <h4 class="form__label--item">商品の説明</h4>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="detail" value="{{old('detail')}}" />
                        </div>
                        <div class="form__error">
                            @error('detail')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- 価格 -->
                <div class="form__group">
                    <div class="form__group-title">
                        <h4 class="form__label--item">価格</h4>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="price" value="&yen;{{old('price')}}" />
                        </div>
                        <div class="form__error">
                            @error('price')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">出品する</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

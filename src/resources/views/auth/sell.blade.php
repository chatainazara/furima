@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content__top">
        <h1 class="content__top--title">商品の出品</h1>
    </div>

    <form class="form" action="/sell" method="post"  enctype="multipart/form-data" novalidate>
    @csrf
        <div>
            <!-- 商品画像の選択 -->
            <div class="form__group">
                    <h3 class="form__label--item">
                        商品画像
                    </h3>
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
            <h3 class="form__sub-title">商品の詳細</h3>
                <!-- カテゴリー -->
                <div class="form__group-inner">
                    <div class="form__group-title">
                        <h3 class="form__label--item">カテゴリー</h3>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--cate">
                            @foreach($categories as $category)
                                <input
                                    class="form__input--cate-checkbox"
                                    type="checkbox"
                                    name="categories[]"
                                    id="category-{{ $category['id'] }}"
                                    value="{{ $category['id'] }}"
                                    @if(is_array(old('categories')) && in_array($category['id'], old('categories'))) checked @endif
                                />
                                <label class="form__input--cate-label" for="category-{{ $category['id'] }}">
                                    {{ $category['content'] }}
                                </label>
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
                        <h3 class="form__label--item">商品の状態</h3>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--select-wrapper">
                            <select class="form__input--select" name="condition" required>
                                <option value="" disabled selected>選択してください</option>
                                <option value="良好" @if( old('condition') === '良好' ) selected @endif>良好</option>
                                <option value="目立った傷や汚れなし" @if( old('condition') === '目立った傷や汚れなし' ) selected @endif>目立った傷や汚れなし</option>
                                <option value="やや傷や汚れあり" @if( old('condition') === 'やや傷や汚れあり' ) selected @endif>やや傷や汚れあり</option>
                                <option value="状態が悪い" @if( old('condition') === '状態が悪い' ) selected @endif>状態が悪い</option>
                            </select>
                        </div>
                        <div class="form__error">
                            @error('condition')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- 商品名と説明 -->
            <div class="form__group">
            <h2 class="form__sub-title">商品名と説明</h2>
                <!-- 商品名 -->
                <div class="form__group-inner">
                    <div class="form__group-title">
                        <h3 class="form__label--item">商品名</h3>
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
                        <h3 class="form__label--item">ブランド名</h3>
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
                        <h3 class="form__label--item">商品の説明</h3>
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
                        <h3 class="form__label--item">価格</h3>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="price" value="{{old('price')}}" />
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

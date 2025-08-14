@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">
@endsection

@section('content')
<div class="profile-form__content">
    <div class="profile-form__heading">
        <h2 class="profile-form__title">プロフィール設定</h2>
    </div>
    <form class="form" action="/mypage/profile" method="post"  enctype="multipart/form-data" novalidate>
    @csrf
        <!-- プロフィール画像の選択 -->
        <div class="form__group">
            <div class="form__group-content--img">
                <div class="form__img">
                @isset($profile)
                    <img class="form__img--item" src="{{asset($profile['pict_url'])}}" alt=""/>
                @else
                    <img class="form__img--item" src="" alt=""/>
                @endisset
                </div>
                <div class="form__input--img">
                    <input class="form__input--button" type="file" name="pict_url" accept="image/png,image/jpeg" >
                </div>
                <div class="form__error">
                    @error('pict_url')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <!-- ユーザー名 -->
        <div class="form__group">
            <div class="form__group-title">
                <h4 class="form__label--item">ユーザー名</h4>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" value="{{Auth::user() -> name}}" />
                </div>
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <!-- 郵便番号 -->
        <div class="form__group">
            <div class="form__group-title">
                <h4 class="form__label--item">郵便番号</h4>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    @isset($profile)
                    <input type="text" id="post_code" name="post_code" pattern="\d{3}-\d{4}" value="{{$profile['post_code']}}" />
                    @else
                    <input type="text" id="post_code" name="post_code" pattern="\d{3}-\d{4}" value="{{old('post_code')}}" />
                    @endisset
                </div>
                <div class="form__error">
                    @error('post_code')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <!-- 住所 -->
        <div class="form__group">
            <div class="form__group-title">
                <h4 class="form__label--item">住所</h4>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    @isset($profile)
                    <input type="text" id="address" name="address" value="{{$profile['address']}}" />
                    @else
                    <input type="text" id="address" name="address" value="{{old('address')}}"  />
                    @endisset
                </div>
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <!-- 建物名 -->
        <div class="form__group">
            <div class="form__group-title">
                <h4 class="form__label--item">建物名</h4>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    @isset($profile)
                    <input type="text" id="building" name="building" value="{{$profile['building']}}" />
                    @else
                    <input type="text" id="building" name="building" value="{{old('building')}}"  />
                    @endisset
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection

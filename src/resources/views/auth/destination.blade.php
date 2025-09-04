@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/destination.css') }}">
@endsection

@section('content')
<div class="register-form__content">
    <div class="register-form__heading">
        <h1 class="register-form__title">住所の変更</h1>
    </div>
    <form class="form" action="/purchase/address/{{$item_id}}?payment={{$payment}}" method="post" novalidate>
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <h2 class="form__label--item">郵便番号</h2>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                <input type="text" name="destination_post_code" pattern="\d{3}-\d{4}" value="{{old('destination_post_code')}}" />
                </div>
                <div class="form__error">
                    @error('destination_post_code')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <h2 class="form__label--item">住所</h2>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="destination_address" value="{{old('destination_address')}}"  />
                </div>
                <div class="form__error">
                    @error('destination_address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <h2 class="form__label--item">建物名</h2>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="destination_building" value="{{old('destination_building')}}"  />
                </div>
            </div>
        </div>
        <div class="form__button">
            <input type="hidden" name="payment" value="{{$payment}}">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection

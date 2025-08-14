@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="list-top">
        <div class="list-top__inner">
            <div class="list-top__link">
                <p class="list-top__link-text">おすすめ</p>
            </div>
            <form class="list-top__form" action="/?tab=mylist" method="post">
                @csrf
                <input type="hidden" name="search" value="{{$search}}">
                <button class="list-top__button" type="submit">マイリスト</button>
            </form>
        </div>
    </div>

    <div class="list">
        @foreach($items as $item)
        <div class="list__content">
            <div class="list__content-img">
                <a class="list__content--link" href="/item/{{$item['id']}}">
                    <img class="list__content--pict" src="{{$item['pict_url']}}" alt="" />
                </a>
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

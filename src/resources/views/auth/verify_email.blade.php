<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furima</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <!-- webフォントの追加 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- webフォントの追加終わり -->
    <link rel="stylesheet" href="{{ asset('css/verify_email.css') }}">
</head>

<body>
    <header class="header">
            <div class="header__inner">
                <div class="header-utilities">
                    <a class="header__link" href="/">
                        <img class="header__logo" src="{{asset('img/logo.svg')}}" alt="ロゴ">
                    </a>
                </div>
            </div>
    </header>

    <main>
        <div class="content">
            <p class="content__text">
                登録していただいたメールアドレスに認証メールを送付しました。
            </br>メール認証を完了してください。
            </p>

                <a class="content__link" href="http://localhost:8025/">認証はこちらから</a>

            <form class="content__form" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="content__form--button" type="submit">認証メールを再送する</button>
            </form>
        </div>
    </main>
</body>

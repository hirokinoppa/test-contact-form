<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate | Contact</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">

</head>
<body>
    <main class="thanks">
        <div class="thanks__inner">
            {{-- 背景文字 --}}
            <div class="thanks__bg">Thank you</div>

            {{-- メッセージ --}}
            <div class="thanks__content">
                <p class="thanks__message">お問い合わせありがとうございました</p>
                {{-- HOMEボタン --}}

                <a class="thanks__btn" href="/">HOME</a>
                {{-- ※本当のホームがあるなら route('home') に変えてOK --}}

            </div>
        </div>
    </main>
</body>
</html>
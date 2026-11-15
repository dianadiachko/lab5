<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Нерухомість')
    </title>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <script src="{{ asset('js/partners.js') }}" defer></script>
</head>

<body>

<header class="site-header">
    <div class="site-header__inner">

        <a href="{{ route('home') }}" class="site-brand">
            <strong>[НАЗВА ПРОЄКТУ]</strong>
            <span>нерухомість з історією</span>
        </a>

        <nav class="site-nav">
            <a href="{{ route('home') }}">Головна</a>
            <a href="{{ route('catalog.index') }}">Каталог</a>
        </nav>

        <a href="mailto:author@example.com" class="site-contact">
            Зв'язатися
        </a>

    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="site-footer__inner">
        <span>[Дячко Діана Євгенівна] · [6.1224]</span>
        <span>Варіант 3 · Нерухомість</span>
    </div>
</footer>

</body>
</html>

@extends('layouts.app')

@section('title', 'Сторінку не знайдено')

@section('content')

<section class="status-page">

    <div class="status-page__content">

        <p class="eyebrow">Помилка 404</p>

        <h1>Сторінку не знайдено.</h1>

        <p>
            Схоже, такого оголошення або сторінки не існує.
            Поверніться до каталогу та спробуйте ще раз.
        </p>

        <a
            href="{{ route('catalog.index') }}"
            class="button"
        >
            Перейти до каталогу
        </a>

    </div>

</section>

@endsection

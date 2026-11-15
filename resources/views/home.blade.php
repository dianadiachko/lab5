@extends('layouts.app')

@section('title', 'Нерухомість — головна')

@section('content')

<section class="service-hero">
    <div class="service-hero__content">
        <p class="eyebrow">Продаж нерухомості</p>

        <h1>
            Знайдіть оселю<br>
            для себе.
        </h1>

        <p>
            Добірка квартир, будинків і таунхаусів
            із перевіреними характеристиками та
            контактами продавців.
        </p>

        <a href="{{ route('catalog.index') }}" class="button">
            Переглянути каталог
        </a>
    </div>

    <div class="service-hero__image">
        <img
            src="{{ url('/images/catalog-atlas.png') }}"
            alt="Продаж нерухомості"
            style="display:block;width:100%;height:auto;"
        >
    </div>
</section>

<section class="service-section">
    <div class="service-section__header">
        <div>
            <p class="eyebrow">Рекомендовані</p>
            <h2>Оголошення для перегляду</h2>
        </div>

        <a href="{{ route('catalog.index') }}">
            Увесь каталог →
        </a>
    </div>

    <div class="service-list">
        @forelse($items as $item)
            <article class="service-card">
                <div
                    class="service-card__image"
                    style="width:220px;min-width:220px;height:180px;overflow:hidden;flex-shrink:0;"
                >
                    <img
                        src="{{ $item->image ? url('/' . ltrim($item->image, '/')) : url('/images/catalog-atlas.png') }}"
                        alt="{{ $item->title }}"
                        style="display:block;width:220px;height:180px;object-fit:cover;"
                    >
                </div>

                <div class="service-card__content">
                    <p class="eyebrow">
                        {{ $item->category?->name ?? 'Нерухомість' }}
                        ·
                        {{ $item->operation }}
                    </p>

                    <h3>
                        <a href="{{ route('catalog.show', ['slug' => $item->slug]) }}">
                            {{ $item->title }}
                        </a>
                    </h3>

                    <p>{{ $item->short_description }}</p>

                    @if($item->attributes)
                        <div class="service-card__meta">
                            @foreach($item->attributes as $name => $value)
                                <span>
                                    <strong>{{ $name }}:</strong>
                                    {{ $value }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    <div class="service-card__price">
                        {{ number_format((float) $item->price, 0, ',', ' ') }}
                        {{ $item->currency }}
                    </div>

                    <a
                        href="{{ route('catalog.show', ['slug' => $item->slug]) }}"
                        class="button"
                    >
                        Переглянути
                    </a>
                </div>
            </article>
        @empty
            <p>Поки що немає опублікованих оголошень.</p>
        @endforelse
    </div>
</section>

<section class="service-note">
    <div>
        <p class="eyebrow">Про каталог</p>
        <h2>Нерухомість, яку легко переглядати.</h2>
    </div>

    <p>
        У каталозі зібрані оголошення про продаж
        квартир, будинків і таунхаусів.
        Для кожного об'єкта доступні основні
        характеристики, ціна та контактні дані.
    </p>

    @isset($totalProducts)
        <p>Опублікованих оголошень: {{ $totalProducts }}</p>
    @endisset
</section>

<section class="partners-section">
    <div class="partners-section__header">
        <p class="eyebrow">Наші партнери</p>
        <h2>Партнери</h2>
    </div>

    <div data-partners-slider class="partners-slider">
        <button
            type="button"
            data-action="partners-previous"
            aria-label="Попередні партнери"
        >←</button>

        <div data-partners-viewport class="partners-slider__viewport">
            <div class="partners-slider__track">
                <div class="partner-logo">NOVA</div>
                <div class="partner-logo">ORBIT</div>
                <div class="partner-logo">VECTOR</div>
                <div class="partner-logo">FORM</div>
                <div class="partner-logo">PULSE</div>
                <div class="partner-logo">NEXUS</div>
            </div>
        </div>

        <button
            type="button"
            data-action="partners-next"
            aria-label="Наступні партнери"
        >→</button>
    </div>
</section>

@endsection

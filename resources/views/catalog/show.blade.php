@extends('layouts.app')

@section('title', $item->title)

@section('content')

<section class="listing-page">

    <div class="listing-page__back">
        <a href="{{ route('catalog.index') }}">
            ← Повернутися до каталогу
        </a>
    </div>

    <div class="listing">

        <div class="listing__image">
            <img
                src="{{ $item->image ? url('/' . ltrim($item->image, '/')) : url('/images/catalog-atlas.png') }}"
                alt="{{ $item->title }}"
                style="display:block;width:100%;height:auto;"
            >
        </div>

        <div class="listing__content">

            <p class="eyebrow">
                {{ $item->category?->name ?? 'Нерухомість' }}
                ·
                {{ $item->operation }}
            </p>

            <h1>
                {{ $item->title }}
            </h1>

            <p class="listing__description">
                {{ $item->description }}
            </p>

            <div class="listing__price">
                {{ number_format((float) $item->price, 0, ',', ' ') }}
                {{ $item->currency }}
            </div>

            @if($item->attributes)
                <div class="listing__attributes">
                    @foreach($item->attributes as $name => $value)
                        <div>
                            <span>{{ $name }}</span>
                            <strong>{{ $value }}</strong>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="listing__contact">

                <p class="eyebrow">
                    Контакт продавця
                </p>

                <h2>
                    {{ $item->contact_name }}
                </h2>

                @if($item->contact_phone)
                    <p>{{ $item->contact_phone }}</p>
                @endif

                @if($item->contact_email)
                    <p>{{ $item->contact_email }}</p>

                    <a
                        href="mailto:{{ $item->contact_email }}"
                        class="button"
                    >
                        Зв'язатися
                    </a>
                @endif

            </div>

        </div>

    </div>

</section>

@endsection

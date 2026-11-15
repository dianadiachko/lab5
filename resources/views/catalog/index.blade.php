@extends('layouts.app')

@section('title', 'Каталог нерухомості')

@section('content')

<section class="service-hero">
    <div class="service-hero__content">
        <p class="eyebrow">Продаж нерухомості</p>

        <h1>Знайдіть оселю для себе.</h1>

        <p>
            У каталозі представлено
            {{ $items->total() }}
            оголошень про продаж квартир, будинків,
            таунхаусів і земельних ділянок.
        </p>
    </div>

    <div class="service-hero__image">
        <img
            src="{{ url('/images/catalog-atlas.png') }}"
            alt="Продаж нерухомості"
            style="display:block;width:100%;height:auto;"
        >
    </div>
</section>

<section class="service-layout">
    <aside class="service-sidebar">
        <p class="eyebrow">Категорії</p>

        <ul>
            <li>
                <a href="{{ route('catalog.index') }}">
                    Уся нерухомість
                    <span>{{ $items->total() }}</span>
                </a>
            </li>

            @foreach($categories as $category)
                <li>
                    <a
                        href="{{ route('catalog.index', array_filter([
                            'category' => $category->name,
                            'q' => $filters->q,
                            'operation' => $filters->operation,
                            'sort' => $filters->sort,
                            'per_page' => $filters->perPage,
                        ], fn ($value) => $value !== null && $value !== '')) }}"
                    >
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </aside>

    <div class="service-catalog">
        <div class="service-toolbar">
            <div>
                <p class="eyebrow">Каталог</p>
                <h2>Оголошення</h2>
            </div>

            <span>
                @if($items->total() > 0)
                    Показано {{ $items->firstItem() }}–{{ $items->lastItem() }}
                    з {{ $items->total() }}
                @else
                    Знайдено: 0
                @endif
            </span>
        </div>

        <form
            action="{{ route('catalog.index') }}"
            method="GET"
            class="catalog-filters"
        >
            <div>
                <label for="q">Пошук</label>
                <input
                    type="search"
                    id="q"
                    name="q"
                    value="{{ $filters->q }}"
                    maxlength="100"
                    placeholder="Назва або опис"
                >
                @error('q')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category">Категорія</label>
                <select id="category" name="category">
                    <option value="">Усі категорії</option>
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->name }}"
                            @selected($filters->category === $category->name)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="operation">Операція</label>
                <select id="operation" name="operation">
                    <option value="">Усі операції</option>
                    @foreach(\App\Models\Product::OPERATIONS as $operation)
                        <option
                            value="{{ $operation }}"
                            @selected($filters->operation === $operation)
                        >
                            {{ $operation }}
                        </option>
                    @endforeach
                </select>
                @error('operation')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sort">Сортування</label>
                <select id="sort" name="sort">
                    <option value="newest" @selected($filters->sort === 'newest')>
                        Спочатку нові
                    </option>
                    <option value="price_asc" @selected($filters->sort === 'price_asc')>
                        Від дешевих до дорогих
                    </option>
                    <option value="price_desc" @selected($filters->sort === 'price_desc')>
                        Від дорогих до дешевих
                    </option>
                </select>
                @error('sort')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="per_page">На сторінці</label>
                <select id="per_page" name="per_page">
                    @foreach([9, 12, 24] as $amount)
                        <option
                            value="{{ $amount }}"
                            @selected($filters->perPage === $amount)
                        >
                            {{ $amount }}
                        </option>
                    @endforeach
                </select>
                @error('per_page')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="catalog-filters__actions">
                <button type="submit" class="button">
                    Застосувати
                </button>

                <a href="{{ route('catalog.index') }}">
                    Очистити фільтри
                </a>
            </div>
        </form>

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
                <div class="catalog-empty">
                    <h3>Нічого не знайдено</h3>
                    <p>Спробуй змінити пошуковий запит або параметри фільтрації.</p>
                    <a href="{{ route('catalog.index') }}" class="button">
                        Скинути фільтри
                    </a>
                </div>
            @endforelse
        </div>

@if($items->hasPages())
    <nav class="catalog-pagination" aria-label="Пагінація каталогу">
        <div class="catalog-pagination__inner">

            {{-- Попередня сторінка --}}
            @if($items->onFirstPage())
                <span class="catalog-pagination__button catalog-pagination__button--disabled">
                    &larr; Назад
                </span>
            @else
                <a
                    href="{{ $items->previousPageUrl() }}"
                    class="catalog-pagination__button"
                >
                    &larr; Назад
                </a>
            @endif

            {{-- Номер поточної сторінки --}}
            <span class="catalog-pagination__info">
                Сторінка {{ $items->currentPage() }}
                з {{ $items->lastPage() }}
            </span>

            {{-- Наступна сторінка --}}
            @if($items->hasMorePages())
                <a
                    href="{{ $items->nextPageUrl() }}"
                    class="catalog-pagination__button"
                >
                    Вперед &rarr;
                </a>
            @else
                <span class="catalog-pagination__button catalog-pagination__button--disabled">
                    Вперед &rarr;
                </span>
            @endif

        </div>
    </nav>
@endif

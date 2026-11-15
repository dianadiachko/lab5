<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Адмінпанель</title>
    @viteReactRefresh
    @vite(['resources/css/admin.css', 'resources/js/admin.jsx'])
</head>
<body class="admin-shell min-h-screen bg-admin-surface text-admin-ink">
    <div class="min-h-screen md:flex">
        <aside class="w-full bg-slate-900 p-6 text-white md:min-h-screen md:w-64">
            <h1 class="mb-8 text-2xl font-bold">Адмінпанель</h1>

            <nav class="space-y-2">
                <a href="{{ route('admin.overview') }}"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-700">
                    Огляд каталогу
                </a>

                <a href="{{ route('admin.products') }}"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-700">
                    Позиції каталогу
                </a>

                <a href="{{ route('admin.categories') }}"
                   class="block rounded-lg px-4 py-3 hover:bg-slate-700">
                    Категорії
                </a>

                <a href="{{ route('catalog.index') }}"
                   class="mt-8 block rounded-lg px-4 py-3 text-slate-300 hover:bg-slate-700">
                    Повернутися до каталогу
                </a>
            </nav>
        </aside>

        <main class="min-w-0 flex-1 p-6 md:p-10">
            <header class="mb-8">
                <p class="mb-2 text-sm font-medium text-slate-500">
                    Керування каталогом
                </p>

                <h2 class="text-3xl font-bold">{{ $title }}</h2>

                <p class="mt-2 text-slate-600">{{ $description }}</p>
            </header>

            <div id="admin-content"
                 data-screen="{{ $screen }}"
                 class="rounded-xl bg-white p-6 shadow-sm">
            </div>
        </main>
    </div>
</body>
</html>

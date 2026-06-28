@extends('layouts.app')

@section('title', 'Strona główna - WSBNLU Klub')

@section('content')
    <section class="p-4 p-md-5 bg-light border rounded mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h1 class="h2 mb-3">Klub strzelecko-kolekcjonerski WSB-NLU</h1>
                <p class="lead mb-0">
                    Aplikacja internetowa do podstawowego zarządzania klubem strzelecko-kolekcjonerskim. System umożliwia prowadzenie ewidencji członków, broni, wydarzeń klubowych oraz składek członkowskich.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="border rounded bg-white p-3 h-100">
                    <h2 class="h5 mb-2">Projekt akademicki</h2>
                    <p class="mb-0 text-muted">Laravel, Blade, SQLite i klasyczne formularze HTML.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <h2 class="h4 mb-3">Zakres aplikacji</h2>
        <div class="row g-3">
            <div class="col-md-6 col-lg-4">
                <div class="border rounded p-3 h-100 bg-white">
                    <h3 class="h6">Członkowie klubu</h3>
                    <p class="mb-0 text-muted">Ewidencja danych członków, status członkostwa i wyszukiwanie.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="border rounded p-3 h-100 bg-white">
                    <h3 class="h6">Typy broni</h3>
                    <p class="mb-0 text-muted">Słownik typów broni wykorzystywany w ewidencji.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="border rounded p-3 h-100 bg-white">
                    <h3 class="h6">Broń</h3>
                    <p class="mb-0 text-muted">Podstawowa ewidencja egzemplarzy broni kolekcjonerskiej.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="border rounded p-3 h-100 bg-white">
                    <h3 class="h6">Wydarzenia</h3>
                    <p class="mb-0 text-muted">Treningi, zawody, spotkania i lista uczestników.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="border rounded p-3 h-100 bg-white">
                    <h3 class="h6">Składki</h3>
                    <p class="mb-0 text-muted">Rejestrowanie składek członkowskich i statusów płatności.</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h2 class="h4 mb-3">Szybkie przejście</h2>
        <div class="row g-3">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Członkowie</h3>
                        <p class="card-text text-muted">Lista członków, formularze CRUD i wyszukiwanie.</p>
                        <a href="{{ route('members.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Typy broni</h3>
                        <p class="card-text text-muted">Słownik typów broni i powiązane egzemplarze.</p>
                        <a href="{{ route('weapon-types.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Broń</h3>
                        <p class="card-text text-muted">Ewidencja broni z relacją do typu broni.</p>
                        <a href="{{ route('weapons.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Wydarzenia</h3>
                        <p class="card-text text-muted">Wydarzenia klubowe i uczestnicy przez tabelę pośrednią.</p>
                        <a href="{{ route('events.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Składki</h3>
                        <p class="card-text text-muted">Składki członkowskie, statusy i oznaczanie wpłat.</p>
                        <a href="{{ route('fees.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Mapa projektu</h3>
                        <p class="card-text text-muted">Krótki opis modułów, tabel, relacji i walidacji.</p>
                        <a href="{{ route('project-map') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

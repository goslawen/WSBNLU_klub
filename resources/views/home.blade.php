@extends('layouts.app')

@section('title', 'Strona główna - WSBNLU Klub')

@section('content')
    <section class="p-4 p-md-5 bg-light border rounded mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h1 class="h2 mb-3">Klub strzelecko-kolekcjonerski WSB-NLU</h1>
                <p class="lead mb-2">Panel administracyjny do podstawowej obsługi klubu strzelecko-kolekcjonerskiego.</p>
                <p class="mb-0 text-muted">System umożliwia prowadzenie ewidencji członków, broni klubowej, wydarzeń oraz składek członkowskich.</p>
            </div>
        </div>
    </section>

    <section>
        <h2 class="h4 mb-3">Szybkie przejście</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Członkowie</h3>
                        <p class="card-text text-muted">Ewidencja członków klubu i statusów członkostwa.</p>
                        <a href="{{ route('members.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Broń</h3>
                        <p class="card-text text-muted">Lista egzemplarzy broni wraz z typem, kalibrem i numerem seryjnym.</p>
                        <a href="{{ route('weapons.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Wydarzenia</h3>
                        <p class="card-text text-muted">Treningi, zawody, spotkania oraz lista uczestników.</p>
                        <a href="{{ route('events.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Składki</h3>
                        <p class="card-text text-muted">Obsługa składek członkowskich i statusów płatności.</p>
                        <a href="{{ route('fees.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h3 class="h5 card-title">Typy broni</h3>
                        <p class="card-text text-muted">Słownik typów broni wykorzystywany w ewidencji.</p>
                        <a href="{{ route('weapon-types.index') }}" class="btn btn-primary mt-auto">Przejdź</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
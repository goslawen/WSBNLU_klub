@extends('layouts.app')

@section('title', 'Mapa projektu - WSBNLU Klub')

@section('content')
    <h1 class="h3 mb-4">Mapa projektu</h1>

    <div class="row g-4">
        <div class="col-md-6">
            <h2 class="h5">Moduły aplikacji</h2>
            <ul>
                <li>Członkowie</li>
                <li>Typy broni</li>
                <li>Broń</li>
                <li>Wydarzenia</li>
                <li>Uczestnicy wydarzeń</li>
                <li>Składki</li>
            </ul>
        </div>

        <div class="col-md-6">
            <h2 class="h5">Tabele</h2>
            <ul>
                <li><code>members</code></li>
                <li><code>weapon_types</code></li>
                <li><code>weapons</code></li>
                <li><code>events</code></li>
                <li><code>event_member</code></li>
                <li><code>fees</code></li>
            </ul>
        </div>

        <div class="col-md-6">
            <h2 class="h5">Relacje</h2>
            <ul>
                <li><code>members</code> 1:N <code>fees</code></li>
                <li><code>weapon_types</code> 1:N <code>weapons</code></li>
                <li><code>members</code> N:N <code>events</code> przez <code>event_member</code></li>
            </ul>
        </div>

        <div class="col-md-6">
            <h2 class="h5">Wyszukiwanie i tabela pośrednia</h2>
            <ul>
                <li>Wyszukiwanie: moduł <code>members</code>, parametr <code>?search=</code>.</li>
                <li>Tabela pośrednia: <code>event_member</code> dla uczestników wydarzeń.</li>
                <li>Unikalność uczestnika: para <code>event_id</code> + <code>member_id</code>.</li>
            </ul>
        </div>

        <div class="col-12">
            <h2 class="h5">CRUD</h2>
            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Moduł</th>
                            <th>Zakres</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>members</code></td>
                            <td>lista, dodanie, podgląd, edycja, dezaktywacja</td>
                        </tr>
                        <tr>
                            <td><code>weapon_types</code></td>
                            <td>lista, dodanie, podgląd, edycja, usunięcie</td>
                        </tr>
                        <tr>
                            <td><code>weapons</code></td>
                            <td>lista, dodanie, podgląd, edycja, dezaktywacja</td>
                        </tr>
                        <tr>
                            <td><code>events</code></td>
                            <td>lista, dodanie, podgląd, edycja, anulowanie</td>
                        </tr>
                        <tr>
                            <td><code>fees</code></td>
                            <td>lista, dodanie, podgląd, edycja, anulowanie, oznaczenie jako opłacone</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12">
            <h2 class="h5">Walidacja</h2>
            <ul>
                <li>Pola wymagane: reguła <code>required</code> w kontrolerach.</li>
                <li>Unikalny e-mail członka.</li>
                <li>Unikalny numer seryjny broni.</li>
                <li>Kwota składki: <code>amount min:0</code>.</li>
                <li>Istniejące klucze obce: członek, typ broni, wydarzenie.</li>
                <li>Unikalna para <code>event_id</code> + <code>member_id</code>.</li>
            </ul>
        </div>
    </div>
@endsection
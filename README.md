# WSBNLU_klub — aplikacja do zarządzania klubem strzelecko-kolekcjonerskim

## Właściwy branch projektu

Kod do oceny znajduje się na branchu `main`.

Starsze branche `feature/*` są historią pracy nad projektem i nie powinny być oceniane jako aktualna wersja aplikacji.

## Opis projektu

WSBNLU_klub to prosty projekt akademicki wykonany w Laravelu. Aplikacja służy do podstawowego zarządzania klubem strzelecko-kolekcjonerskim.

## Technologia

Projekt wykorzystuje:

- Laravel,
- Blade,
- SQLite,
- klasyczne kontrolery resource,
- klasyczne formularze HTML,
- prosty Bootstrap 5 z CDN,
- prosty CRUD dla głównych tabel.

Projekt nie używa React, Vue, Inertia, API, logowania, ról, płatności online, PDF ani kolejek.

## Spełnione wymagania

- Projekt działa w Laravelu.
- Widoki są wykonane w Blade.
- Baza danych działa na SQLite.
- Projekt ma więcej niż 5 tabel.
- Projekt używa kluczy obcych.
- Projekt ma tabele główne i tabelę pośrednią.
- Projekt ma CRUD dla członków, typów broni, broni, wydarzeń i składek.
- Projekt ma wyszukiwanie członków po imieniu, nazwisku i e-mailu.
- Projekt ma walidację pól wymaganych.
- Projekt ma dodatkową walidację kwoty składki: `amount >= 0`.
- Projekt ma relację wiele-do-wielu między członkami i wydarzeniami przez `event_member`.

## Tabele

- `members` — członkowie klubu,
- `weapon_types` — typy broni,
- `weapons` — ewidencja broni,
- `events` — wydarzenia klubowe,
- `event_member` — tabela pośrednia uczestników wydarzeń,
- `fees` — składki członkowskie.

## Relacje

- `members` → `fees`: jeden członek może mieć wiele składek.
- `fees` → `members`: jedna składka należy do jednego członka.
- `weapon_types` → `weapons`: jeden typ broni może mieć wiele egzemplarzy broni.
- `weapons` → `weapon_types`: jeden egzemplarz broni należy do jednego typu broni.
- `members` ↔ `events`: członkowie i wydarzenia są połączeni relacją wiele-do-wielu przez tabelę `event_member`.

## Dokumentacja techniczna

Szczegółowy opis schematu bazy, relacji i operacji CRUD znajduje się w pliku [docs/SCHEMA.md](docs/SCHEMA.md).

## Uruchomienie projektu

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Po uruchomieniu aplikacja jest dostępna domyślnie pod adresem:

```text
http://127.0.0.1:8000
```

Na Windows, jeżeli polecenie `touch` nie jest dostępne, można utworzyć plik SQLite ręcznie:

```powershell
New-Item -ItemType File database/database.sqlite
```

## Testy

Uruchomienie testów:

```bash
php artisan test
```

Pełne odtworzenie bazy z danymi przykładowymi:

```bash
php artisan migrate:fresh --seed
```

## Dane przykładowe

Seedery dodają przykładowe dane po polsku:

- 5 członków,
- 3 typy broni,
- 5 egzemplarzy broni,
- 3 wydarzenia,
- 6 składek,
- kilka przypisań członków do wydarzeń.

## Scenariusz obrony

1. Uruchomić aplikację poleceniem:

```bash
php artisan serve
```

2. Otworzyć stronę główną i pokazać opis projektu.
3. Pokazać menu aplikacji: członkowie, typy broni, broń, wydarzenia, składki.
4. Pokazać migracje w katalogu `database/migrations`.
5. Omówić tabele i klucze obce:
   - `weapons.weapon_type_id`,
   - `fees.member_id`,
   - `event_member.event_id`,
   - `event_member.member_id`.
6. Pokazać tabelę `members` i listę członków w aplikacji.
7. Dodać nowego członka przez formularz.
8. Wyszukać członka po imieniu, nazwisku albo e-mailu.
9. Edytować dane członka.
10. Dezaktywować członka i pokazać zmianę statusu na `inactive`.
11. Pokazać typy broni.
12. Pokazać broń oraz relację broni z typem broni.
13. Pokazać wydarzenie.
14. Dodać członka do wydarzenia przez formularz uczestników.
15. Pokazać tabelę pośrednią `event_member` jako realizację relacji wiele-do-wielu.
16. Pokazać składki członkowskie.
17. Dodać nową składkę.
18. Pokazać walidację kwoty składki przez wpisanie wartości mniejszej niż 0.
19. Oznaczyć składkę jako opłaconą i pokazać ustawienie `status = paid` oraz `paid_at`.
20. Uruchomić testy:

```bash
php artisan test
```
# Schemat bazy i operacje CRUD

Aplikacja służy do podstawowego zarządzania klubem strzelecko-kolekcjonerskim. Projekt jest prostą aplikacją akademicką Laravel + Blade z bazą SQLite, klasycznymi kontrolerami resource i formularzami HTML.

## Tabele domenowe

### `members`

Członkowie klubu.

Pola:

- `id`,
- `first_name`,
- `last_name`,
- `email` - unikalny,
- `phone` - opcjonalny,
- `joined_at`,
- `status` - domyślnie `active`,
- `created_at`,
- `updated_at`.

### `weapon_types`

Typy broni.

Pola:

- `id`,
- `name` - unikalna nazwa typu,
- `description` - opcjonalny opis,
- `created_at`,
- `updated_at`.

### `weapons`

Ewidencja broni.

Pola:

- `id`,
- `weapon_type_id` - klucz obcy do `weapon_types`,
- `name`,
- `caliber`,
- `serial_number` - unikalny numer seryjny,
- `status` - domyślnie `available`,
- `created_at`,
- `updated_at`.

### `events`

Wydarzenia klubowe.

Pola:

- `id`,
- `name`,
- `event_date`,
- `location`,
- `description` - opcjonalny opis,
- `status` - domyślnie `planned`,
- `created_at`,
- `updated_at`.

### `event_member`

Tabela pośrednia dla uczestników wydarzeń.

Pola:

- `id`,
- `event_id` - klucz obcy do `events`,
- `member_id` - klucz obcy do `members`,
- `created_at`,
- `updated_at`.

Tabela ma unikalną parę `event_id` + `member_id`, więc ten sam członek nie może zostać dodany dwa razy do tego samego wydarzenia.

### `fees`

Składki członkowskie.

Pola:

- `id`,
- `member_id` - klucz obcy do `members`,
- `year`,
- `amount`,
- `status` - domyślnie `unpaid`,
- `paid_at` - opcjonalna data opłacenia,
- `created_at`,
- `updated_at`.

## Relacje

Relacje Eloquent w modelach:

- `Member hasMany Fee`,
- `Fee belongsTo Member`,
- `WeaponType hasMany Weapon`,
- `Weapon belongsTo WeaponType`,
- `Member belongsToMany Event`,
- `Event belongsToMany Member`.

Relacje logiczne w bazie:

- `members` 1:N `fees`,
- `weapon_types` 1:N `weapons`,
- `members` N:N `events` przez `event_member`.

## Klucze obce

Klucze obce użyte w projekcie:

- `weapons.weapon_type_id` wskazuje na `weapon_types.id`,
- `fees.member_id` wskazuje na `members.id`,
- `event_member.event_id` wskazuje na `events.id`,
- `event_member.member_id` wskazuje na `members.id`.

Klucze obce zabezpieczają spójność danych. Broń musi mieć istniejący typ broni, składka musi należeć do istniejącego członka, a wpis w `event_member` musi wskazywać istniejącego członka i istniejące wydarzenie.

## Tabela pośrednia event_member

Tabela `event_member` realizuje relację wiele-do-wielu między członkami i wydarzeniami.

Przykład:

- jeden członek może brać udział w wielu wydarzeniach,
- jedno wydarzenie może mieć wielu członków,
- rekord w `event_member` przechowuje parę `event_id` i `member_id`.

Unikalny indeks na parze `event_id` + `member_id` blokuje duplikaty uczestników w jednym wydarzeniu.

## CRUD według modułów

### `members`

- lista członków,
- dodanie członka,
- podgląd członka,
- edycja członka,
- dezaktywacja członka zamiast fizycznego usuwania.

Dodatkowo moduł ma wyszukiwanie po `first_name`, `last_name` i `email` przez parametr `?search=`.

### `weapon_types`

- lista typów broni,
- dodanie typu broni,
- podgląd typu broni,
- edycja typu broni,
- usunięcie typu broni.

W podglądzie typu broni widać przypisaną broń.

### `weapons`

- lista broni,
- dodanie broni,
- podgląd broni,
- edycja broni,
- dezaktywacja broni zamiast fizycznego usuwania.

Broń jest powiązana z typem broni przez `weapon_type_id`.

### `events`

- lista wydarzeń,
- dodanie wydarzenia,
- podgląd wydarzenia,
- edycja wydarzenia,
- anulowanie wydarzenia zamiast fizycznego usuwania.

Na stronie wydarzenia można dodać i usunąć uczestników przez tabelę `event_member`.

### `fees`

- lista składek,
- dodanie składki,
- podgląd składki,
- edycja składki,
- anulowanie składki zamiast fizycznego usuwania,
- oznaczenie składki jako opłaconej.

Oznaczenie jako opłacone ustawia `status = paid` oraz `paid_at = now()`.

## Walidacja

Walidacja jest wykonywana w kontrolerach przez `$request->validate()`.

Najważniejsze reguły:

- pola wymagane używają `required`,
- `members.email` jest unikalny,
- `weapon_types.name` jest unikalna,
- `weapons.serial_number` jest unikalny,
- `fees.amount` ma regułę `numeric` i `min:0`,
- `events.event_date` musi być datą i nie może być wcześniejsza niż `2000-01-01`,
- klucze obce są sprawdzane przez `exists`,
- para `event_id` + `member_id` w `event_member` jest unikalna.

Przy edycji rekordów reguły unikalności ignorują aktualnie edytowany rekord.

## Co pokazać na obronie

1. Uruchomić aplikację i wejść na stronę główną.
2. Otworzyć stronę `Mapa projektu` i omówić moduły, tabele i relacje.
3. Pokazać migracje w katalogu `database/migrations`.
4. Pokazać modele Eloquent i metody relacji.
5. Otworzyć listę członków i dodać nowego członka.
6. Pokazać wyszukiwanie członków po imieniu, nazwisku albo e-mailu.
7. Otworzyć typ broni i pokazać broń przypisaną do tego typu.
8. Otworzyć wydarzenie i dodać członka jako uczestnika.
9. Pokazać, że wpis uczestnika trafia do tabeli `event_member`.
10. Spróbować dodać tego samego członka drugi raz do tego samego wydarzenia i pokazać walidację.
11. Dodać składkę i pokazać walidację `amount min:0`.
12. Oznaczyć składkę jako opłaconą i pokazać ustawienie `paid_at`.
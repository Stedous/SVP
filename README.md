# Správa Vozového Parku

Tato aplikace slouží k správě vozového parku, umožňuje registraci uživatelů, hlášení závad a správu vozidel.

## Funkce

- Registrace a přihlášení uživatelů
- Správa vozidel
- Hlášení závad
- Zobrazení hlášení

## Požadavky

- PHP 7.4 nebo novější
- MySQL
- Webový server (např. Apache)

## Instalace

1. Naklonujte repozitář:

    ```bash
    git clone https://github.com/your-username/your-repository.git
    ```

2. Přejděte do složky projektu:

    ```bash
    cd your-repository
    ```

3. Nakonfigurujte připojení k databázi v `db.php`.

4. Importujte databázové schéma:

    - Otevřete phpMyAdmin nebo jiný nástroj pro správu MySQL.
    - Vytvořte novou databázi.
    - Importujte soubor `sql/create_tables.sql` do této databáze.

5. Spusťte aplikaci na lokálním serveru (např. pomocí XAMPP nebo MAMP).

## Použití

- Otevřete webový prohlížeč a přejděte na `http://localhost/your-repository`.
- Registrujte nového uživatele a přihlaste se.
- Spravujte vozidla a hlaste závady.

## Přispívání

Přivítáme příspěvky od komunity. Pokud máte zájem přispět, vytvořte prosím fork projektu a otevřete pull request.

## Licence

Tento projekt je licencován pod MIT licencí. Podrobnosti najdete v souboru `LICENSE`.

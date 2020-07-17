# Spis treści

1. Autorzy
1. Opis projektu
1. Cel projektu
1. Technologie
1. Diagram ERD bazy danych
1. Przykładowy wygląd interfejsu
1. Uruchomienie

## Autorzy
Krzysztof Czereczon, Długosz Piotr
## Opis projektu
Projekt został wykonany na potrzeby zaliczenia z przedmiotu “Aplikacje Internetowe” na 2 roku informatyki na Uniwersytecie Rzeszowskim.

W projekcie stworzono API oparte na Laravelu, oraz interfejs użytkownika oparty na Vue.

## Cel projektu
Stworzenie w pełni funkcjonalnego systemu z możliwością tworzenia grup, podgrup przez każdego użytkownika, tworzenia kursów do grup z możliwością zaproszenia ucznia do danej grupy, nauczyciela do kursu (zaproszenia wysyłane mailem). Grupę można połączyć z serwerem Discord aby na określonym kanale na serwerze wysyłała powiadomienia odnośnie nowych wiadomości, zadań, egzaminów. Właściciel grupy, nauczyciel kursu mogą tworzyć nowe wiadomości, zadania, egzaminy dla kursów. Uczniowie przypisani do danych grup mają podgląd do danych kursów w tym wiadomości, zadań, egzaminów przypisanych do nich.

## Technologie
Do stworzenia aplikacji zostały użyte technologie takie jak:
1. [Vue](https://github.com/vuejs/vue)
1. [Laravel](https://github.com/laravel/laravel)

## Diagram ERD bazy danych
![Database diagram](https://i.imgur.com/jaeeNFj.png)

## Przykładowy wygląd interfejsu
![websiteView](https://i.imgur.com/CJe1EhC.png)

## Uruchomienie
1. Pierwsze Uruchomienie
     * Sklonuj repozytorium.
     * Instalacja bibliotek php ```composer install```
     * Instalacja bibliotek js ```npm install```
     * Skopiuj [```.env.example```](https://github.com/kczereczon/Partup/blob/master/.env.example) do ```.env``` w folderze głównym.
     * Tworzymy bazę danych (pustą).
     * Zedytuj plik ```.env```, zmień w nim konfigurację bazy danych, serwera pocztowego ```DB_* , MAIL_*```
     * Migracja bazy danych (tworzenie tabel, połączeń pomiędzy tabelami) ```php artisan migrate```   
     * Uruchomienie serwera Api ```php artisan serve```
     * Uruchomienie serwera Js ```npm run production```
        
2. Ponowne uruchomienie
     * Uruchomienie serwera Api ```php artisan serve```
     * Uruchomienie serwera Js ```npm run production```

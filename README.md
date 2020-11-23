# intranet

## Version 2.4.1 ##
*Nyheter*
* Hantering av platser för företaget.
    * SuperAdmin kan lägga till nya huvudplatser, alla användare kan lägga till och editera underplatser
    * En plats kan bara tas bort om den inte har någon underplats eller några produkter
* Import av produktlistan från excel till databasen
* Tabell för demoprodukter med filtrering och sortering
    * Visar översiktligt alla demoprodukter, plats och status
* beta-användare för test av moduler moduler, aktiveras per användare av SuperAdmin.
    
*Förändringar*
* Vänstermenyn komprimerad för att få plats med fler rader:
    * Inställningar som rollen har tillgång till visas längs ned på menyn.
* Kortet som visar besökare på startsidan visas endast om den finns besök aktuell vecka.
* Email innehåller rubriken för ärendet, bådi i ärende och i mailtexten.
* Email ärenderad innehåller "BRÅDSKANDE" om det valts när man skapade ärendet.

### Installation 2.4 ###
Uppgradering från 2.3.3

* <code>php artisan migrate</code>

* <code>php artisan db:seed --class=ProductStatusTableSeeder</code>

* Lägg till rollen 'beta' i Roles table.

## Version 2.3.3 ##

*Nyheter*
* Ärendenummer inkluderas i sökning av ärende
* Nytt fält i Ärenden, "Rubrik"
    
    Obligatoriskt fält, kortfattad beskrivning av ärendet som visas i listan av ärenden för att snabbare indentifiera ärendet.
* Kolumnen "Senast" visar tiden som löpt sedan senast sparade kommentar
* Bredvid "Ärenden" i huvudmenyn visas ny information:
    
    Antal obesvarade ärenden i rött (Där kunden inte fått svar inom utlovad tid) alla användare ser denna information.
    Antal öppna ärenden i gult. Denna information är individuell beroende på ansvarsområden.
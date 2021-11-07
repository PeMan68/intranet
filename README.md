# intranet

## Version 2.6.7 ##
(2021-10-18)

*Nyheter*
* **Ärenden**
    * Möjlighet att lägga till andra användare som följare i ärenden, så de blir notifierade om ärendet.
    * Möjlighet att mail skickas direkt från anteckning i ärenden till vald mottagare med avsändare "support@carlogavazzi.se". Alternativt kopiera all relevant info och skapa mailet med egen avsändare om man vill redigera, t ex lägga till bilder eller filer.
* **Kalendern**
    * Helgdagar hanteras från vänster meny. Allmänna helgdagar importeras automatiskt 12 månader framåt när den menyn öppnas. Helgdagar visas i kalendern.
* **Demoprodukter**
    * Möjlighet att samtidigt lägga till många produkter av samma typ egenskaper på demolagret.
 ## Version 2.6.1 ##
(2021-08-13)

*Nyheter*

* **Ny modul Demoprodukter**

    * Register för att hålla kolla på var demoprodukter finns och vilken status de har.
    * Platser har en hierarkisk struktur och kan redigeras av alla, "Hantera platser" vänster meny.
    * Status på produkten indikerar om produkten kan säljas, returneras till lager etc.
    * Produkter kan sökas med fritext (artikelnummer, benämning, e-nummer).
    * Produktdetaljer kan redigeras av alla.
## Version 2.5.32 ##
(2021-02-15)

*Nyheter*
* **Ärenden**
    * Lagt till nya statusar för ärenden för att rangordna ärenden ytterligare. Nya statusar:  
        * Pausa ärende
        * Väntar på svar från kund
        * Väntar på svar från kollega
    
## Version 2.5
(2021-01-31)

*Nyheter*
* **Ärenden**
    * Ärenden visar endast öppna ärenden plus nyligen stängda för att minska storleken på tabellen. Börjar man skriva i sökrutan inkluderas alla ärenden i resultatet, så man kan söka i all historik.
    * Vid registrering av nytt ärende skickas mail till kunden med information om ärendet, så den vet vad vi registrerat. Avsändarmail är support@carlogavazzi.se så kunden kan svara direkt på ärendet om den vill uppdatera något.
    * Om inte kund kontaktas inom given tid skickas ett påminnelsemail till både Första- och Andrahands hanterare för att kunden ska få feedback från oss så snart som möjligt. Påminnelser skickas tills ärendet markerats som kontaktad.
    * Anteckningar i ärendet sorteras nu med nyast överst och har ett mycket tydligare utseende.
    * Anteckningar kan vara interna, utgående eller inkommande meddelanden.
    * Ny meny för att hantera kontakter för ärenden. Framförallt för att lägga till interna kontakter inom koncernen så de kan taggas vid när man lägger in anteckning, vem som kontaktat vem visas vid varje anteckning. 
## Version 2.4.3  
(2020-12-10)

*Nyheter*
* Supportartiklar importerade. 
    * Sökbara i dynamisk tabell. Varje artikel kan öppnas upp i detalj-läge där all text visas med html-formateringen i orginal. Det innebär att interna länkar mellan filer på supportsidan inte funkar t ex, men att de sidor där man gjort egen HTML-kod ändå visas skapligt bra, som tabeller m.m.

*bugfixar*
* Fixat Dokument så den fungerar med uppladdning och nedladdning, sökbarhet med ny layout
* Vänstermenyn mer dynamisk för att passa fler skärmstorlekar


## Version 2.4.2 ##
*bugfixar*
* Ersatt daterangepicker med bootstrap-vue komponenter
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
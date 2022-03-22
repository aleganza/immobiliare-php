## guida file principali nella cartella 'progetto'

# cartella 'authentication'
    contiene i file a tema autenticazione, come login, logout e controllo del cookie

# cartella 'config'
    contiene dati di accesso al database (sia quello scolastico che quello a casa);
    username e password per l'accesso.

# cartella 'icon'
    contiene le immagini utilizzate

# file index.php
    file di partenza con switch case principale

# home.php, proprietari.php, immobili.php, intestazioni.php, tipologie.php; zone.php
    sono le sezioni accessibili tramite sidebar.
    ognuna, tranne 'home.php' sono composte da:

    - stampa di sidebar e navbar
    - switch case per le sezioni della pagina
    - funzioni per le stampe (aggiunta, modifica ecc..)

    in particolare, proprietari.php e zone.php hanno delle funzionalità in più:
    proprietari.php: 
    - visualizzazione immobili appartenenti ad un proprietario
    - download del pdf con anagrafica del proprietario e immobili appartenuti
    zone.php:
    - ricerca di immobili partendo da una zona
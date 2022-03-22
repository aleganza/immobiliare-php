<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="icon" href="icon/icon-tab.png">
        <link rel="stylesheet" href="style.css">
        <title>Immobiliare Ganza</title>
    </head>
    <body>
        
            <!-- per far funzionare gli header -->
            <?php ob_start(); ?>
            <?php
                $scelta = isset($_REQUEST['scelta']) ? $_REQUEST['scelta'] : null;

                switch($scelta){
                    // autenticazione
                    default: {
                        echo ("
                            <div class=\"container-login\">
                                <div class=\"text-center\">
                                    <form action=\"\" style=\"max-width:300px; margin:auto;\" autocomplete=\"off\">
                                        <img class=\"mb-2\" src=\"icon/icon.png\" alt=\"errore\"  width=\"60\" height=\"60\">
                                        <h2 class=\"pb-2\">Login</h2>
                                            <div class=\"mb-3\">
                                                <input type=\"text\" name=\"username\" class=\"form-control\" placeholder=\"Inserisci username\" required>
                                            </div>
                                            <div class=\"mb-3\">
                                                <input type=\"password\" name=\"password\" class=\"form-control\" placeholder=\"Inserisci password\" required>
                                            </div>
                                        <input type=\"hidden\" name=\"scelta\" value=\"login\">
                                        <button class=\"btn btn-primary btn-block\">Accedi</button>
                                    </form>
                                </div>
                            </div>
                        ");
                        break;
                    }
                    case 'login': {
                        include 'authentication/login.php';
                        break;
                    }
                    // immobiliare
                    case 'home': {
                        include 'authentication/checkLogged.php';

                        include 'home.php';
                        break;
                    }
                    case 'proprietari': {
                        include 'authentication/checkLogged.php';

                        include 'proprietari.php';
                        break;
                    }
                    case 'zone': {
                        include 'authentication/checkLogged.php';

                        include 'zone.php';
                        break;
                    }
                    case 'tipologie': {
                        include 'authentication/checkLogged.php';

                        include 'tipologie.php';
                        break;
                    }
                    case 'immobili': {
                        include 'authentication/checkLogged.php';

                        include 'immobili.php';
                        break;
                    }
                    case 'intestazioni': {
                        include 'authentication/checkLogged.php';

                        include 'intestazioni.php';
                        break;
                    }
                }
            ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <script>
			// per file javascript
			let script = document.createElement("script");
            script.src = "script.js" + "?_dc=" + Date.now();
            document.body.appendChild(script);
		</script>
    </body>
</html>
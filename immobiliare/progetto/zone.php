
<div class="container-full">
    <!-- sidebar -->
    <div class="container-sidebar">
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height: 100%;">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="icon/icon.png" alt=""style="padding-right: 12px; width:50px">
                <span class="fs-4">Immobiliare</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php?scelta=home" class="nav-link link-dark" aria-current="page">
                    <i class="bi bi-house-door" style="padding-right: 7px"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="index.php?scelta=proprietari" class="nav-link link-dark">
                    <i class="bi bi-people" style="padding-right: 7px"></i>
                    Proprietari
                </a>
            </li>
            <li>
                <a href="index.php?scelta=immobili" class="nav-link link-dark">
                    <i class="bi bi-building" style="padding-right: 7px"></i>
                    Immobili
                </a>
            </li>
            <li>
                <a href="index.php?scelta=intestazioni" class="nav-link link-dark">
                    <i class="bi bi-briefcase" style="padding-right: 7px"></i>
                    Intestazioni
                </a>
            </li>
            <li>
                <a href="index.php?scelta=zone" class="nav-link active">
                    <i class="bi bi-geo-alt" style="padding-right: 7px"></i>
                    Zone
                </a>
            </li>
            <li>
                <a href="index.php?scelta=tipologie" class="nav-link link-dark">
                    <i class="bi bi-person-workspace" style="padding-right: 7px"></i>
                    Tipologie
                </a>
            </li>
            </ul>
            <hr>
            <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="icon/default_propic.png" alt=""style="padding-right: 12px; width:50px">
                <strong><?php echo(USERNAME) ?></strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item disabled" href="#"><i class="bi bi-person"></i> Profilo</a></li>
                <li><a class="dropdown-item disabled" href="#"><i class="bi bi-gear"></i> Impostazioni</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="authentication/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
            </ul>
            </div>
        </div>
    </div>
    <div class="container-right">
        <!-- sotto-navbar per eventuali operazioni secondarie -->
        <nav class="navbar navbar-expand-lg navbar-light p-2">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?scelta=zone&sceltaZ=echoLista"><i class="bi bi-table"></i> Lista</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?scelta=zone&sceltaZ=echoAggiungi"><i class="bi bi-plus"></i> Aggiungi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?scelta=zone&sceltaZ=echoRicerca"><i class="bi bi-search"></i> Ricerca immobili</a>
                </li>
            </ul>
            <!-- <div class="d-flex">
                <a href="index.php?scelta=home"><i class="bi bi-x-circle text-danger"></i></a>
            </div> -->
        </div>
        </nav>
        <div class="container-table">
            <!-- operazioni -->
            <?php
                $sceltaZ = isset($_REQUEST['sceltaZ']) ? $_REQUEST['sceltaZ'] : null;

                switch ($sceltaZ){
                    default: {
                        // echo della lista (tabella)
                        echoLista();

                        break;
                    }
                    case 'echoLista': {
                        // echo della lista (tabella)
                        echoLista();

                        break;
                    }
                    case 'echoAggiungi': {
                        // aggiungi
                        echoAggiungi();

                        break;
                    }
                    case 'aggiungi': {
                        // aggiunta e controllo
                        $Zona = $_REQUEST['zona'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_tipozona";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();
                        
                        // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                        while($record){
                            if($record['zona'] === $Zona){
                                echoAggiungi();
                                echo("<p class=\"text-danger\">La zona inserita è già esistente.</p>");
                                break 2;
                            }
                            $record = $rs->fetch_assoc();
                        }

                        /* $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB); */
                        $sql = "INSERT INTO immobiliare_tipozona(zona)
                                VALUES ('$Zona')";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=zone&sceltaZ=echoLista');

                        break;
                    }
                    case 'echoModifica': {
                        echoModifica($_REQUEST['SelId']);

                        break;
                    }
                    case 'modifica': {
                        $SelId = $_REQUEST['SelId'];

                        $Zona = $_REQUEST['zona'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_tipozona";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();
                        
                        // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                        while($record){
                            if($record['zona'] === $Zona && $record['Id'] != $SelId){
                                echoModifica($SelId);
                                echo("<p class=\"text-danger\">La zona inserita è già esistente.</p>");
                                break 2;
                            }
                            $record = $rs->fetch_assoc();
                        }

                        $sql = "UPDATE immobiliare_tipozona
                                SET zona = '$Zona'
                                WHERE Id = '$SelId'";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=zone&sceltaZ=echoLista');

                        break; 
                    }
                    case 'echoRicerca': {
                        // per capire da dove sono andato in area ricerca
                        if(isset($_REQUEST['SelId'])){
                            $IdZona = $_REQUEST['SelId'];
                            // se sono andato in area ricerca direttamente da una zona nella tabella, vado subito nel case per mostrare la tabella, passando l'Id di quella zona
                            header("Location: index.php?scelta=zone&sceltaZ=ricerca&IdZona=$IdZona");
                        }
                        else
                            // se sono andato in area ricerca tramite bottone in navbar, stampo il form per richiedere la zona
                            echoRicerca();

                        break;
                    }
                    case 'ricerca': {
                        // ristampo il form
                        echoRicerca();
                        // eseguo il codice per mostrare la tabella degli immobili con relativi proprietari
                        ricerca();
                        break;
                    }
                    case 'elimina': {
                        $SelId = $_REQUEST['SelId'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "DELETE FROM immobiliare_tipozona
                                WHERE Id = '$SelId'";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=zone&sceltaZ=echoLista');

                        break;
                    }
                }
                // funzioni per le stampe
                function echoLista(){
                        echo "<h4>Lista delle zone</h4>";

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_tipozona";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();

                        // stampa tabella
                        echo ("
                            <table class=\"my-4 table\">
                                <thead class=\"thead-light\">
                                    <tr>
                                    <th scope=\"col\">Id</th>
                                    <th scope=\"col\">Zona</th>
                                    <th scope=\"col\">Operazioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");
                        while($record){
                            echo("
                                <tr>
                                    <th scope=\"row\">".$record['Id']."</th>
                                    <td>".$record['zona']."</td>
                                    <td>
                                        <div class=\"dropdown\">
                                            <button class=\"btn btn-secondary dropdown-toggle btn-sm\" type=\"button\" id=\"dropdownMenuButton1\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                                <i class=\"bi bi-wrench\"></i>
                                            </button>
                                            <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton1\">
                                                <li>
                                                    <a class=\"dropdown-item text-dark\" aria-current=\"page\" href=\"index.php?scelta=zone&sceltaZ=echoModifica&SelId=".$record['Id']."\"><i title=\"Modifica\" class=\"bi bi-pencil\"></i> Modifica</a>
                                                </li>
                                                <li>
                                                    <a class=\"dropdown-item text-dark\" aria-current=\"page\" href=\"index.php?scelta=zone&sceltaZ=echoRicerca&SelId=".$record['Id']."\"><i class=\"bi bi-search\"></i> Ricerca immobili</a>
                                                </li>
                                                <li><hr class=\"dropdown-divider\"></li>
                                                <li>
                                                    <a class=\"dropdown-item text-danger\" aria-current=\"page\" href=\"index.php?scelta=zone&sceltaZ=elimina&SelId=".$record['Id']."\"><i title=\"Elimina\" class=\"bi bi-trash\"></i> Elimina</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            ");
                            $record = $rs->fetch_assoc();
                        }
                        echo("
                                </tbody>
                            </table>
                        ");

                        $db->close();
                }
                function echoAggiungi(){
                    echo "<h4>Aggiungi una zona</h4>
                        <div class=\"my-4 container-table\">
                            <form action=\"index.php\" autocomplete=\"off\">
                                <label class=\"pb-1\">Nome zona</label>
                                <div class=\"input-group\">
                                    <input type=\"text\" name=\"zona\" class=\"form-control\" placeholder=\"Nome zona\" required>
                                </div>
                                <input type=\"hidden\" name=\"scelta\" value=\"zone\">
                                <input type=\"hidden\" name=\"sceltaZ\" value=\"aggiungi\">
                                <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                            </form>
                        </div>";
                }
                function echoModifica($SelId){

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT *
                            FROM immobiliare_tipozona
                            WHERE Id = $SelId";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();

                    $Zona = $record['zona'];

                    $db->close();

                    echo "<h4>Modifica zona</h4>
                    <div class=\"my-4 container-table\">
                            <form action=\"index.php\" autocomplete=\"off\">
                                <label class=\"pb-1\">Nome zona</label>
                                <div class=\"input-group\">
                                    <input type=\"text\" name=\"zona\" class=\"form-control\" placeholder=\"Nome zona\" value=\"$Zona\" required>
                                </div>
                                <input type=\"hidden\" name=\"scelta\" value=\"zone\">
                                <input type=\"hidden\" name=\"sceltaZ\" value=\"modifica\">
                                <input type=\"hidden\" name=\"SelId\" value=\"$SelId\">
                                <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                            </form>
                        </div>";
                }
                function echoRicerca(){ 
                    echo "<h4>Ricerca immobili a partire da una zona</h4>
                        <div class=\"my-4 container-table\">
                            <form action=\"index.php\" autocomplete=\"off\">
                                <label class=\"pb-1\">Nome zona</label>
                                <div class=\"input-group\">
                                    <select name=\"IdZona\" class=\"form-select\" aria-label=\"Default select example\" required>
                                        <option value=\"\" disabled selected>Seleziona zona</option>";
                                        // settaggio delle zone selezionabili

                                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                                        $sql = "SELECT * FROM immobiliare_tipozona";
                                        $rs = $db->query($sql);
                                        $record = $rs->fetch_assoc();

                                        while($record){
                                            echo "
                                                <option value=\"".$record['Id']."\">".$record['zona']."</option>
                                            ";
                                            $record = $rs->fetch_assoc();
                                        }
                                        $db->close();
                                    echo "</select>
                                </div>
                                <input type=\"hidden\" name=\"scelta\" value=\"zone\">
                                <input type=\"hidden\" name=\"sceltaZ\" value=\"ricerca\">
                                <button type=\"submit\" class=\"mt-3 btn btn-primary\">Ricerca</button>
                            </form>
                        </div>";
                }
                function ricerca(){
                    // Id della zona da cui devo stampare immobili e relativi proprietari
                    $IdZona = $_REQUEST['IdZona'];

                    // ricavo gli immobili di quella zona
                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT *
                            FROM immobiliare_immobili
                            WHERE IdZona = $IdZona";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();

                    $sqlZona = "SELECT zona
                            FROM immobiliare_tipozona
                            WHERE Id = $IdZona";
                    $rsZona = $db->query($sqlZona);
                    $recordZona = $rsZona->fetch_assoc();

                    // titolo indicativo e barra di ricerca
                    echo("<h5>Lista degli immobili e relativi proprietari appartenenti alla zona ".$recordZona['zona']."</h5>");
                    echo("
                        <div class=\"my-4 container-table\">
                            <div class=\"input-group\">
                                <input autocomplete=\"off\" class=\"form-control me-2\" type=\"text\" id=\"filtraImm\" onkeyup=\"filtraImmobili()\" placeholder=\"Cerca tra gli immobili\" aria-label=\"Search\">
                            </div>
                        </div>");
                    
                    // ciclo di stampa della tabella
                    echo ("
                        <table class=\"my-4 table\">
                            <thead class=\"thead-light\">
                                <tr>
                                <th scope=\"col\">Immobile</th>
                                <th scope=\"col\">Proprietario</th>
                                </tr>
                            </thead>
                            <tbody id=\"immobiliDaFiltrare\">
                    ");
                    // se non esistono immobili, non stampa niente
                    if(!$record){
                        echo("");
                    }
                    while($record){
                        // Id dell'immobile
                        $temp = $record['Id'];
                        // sql per ricavare il proprietario di quell'immobile
                        $sqlProp = "SELECT prop.*
                                FROM immobiliare_proprietari AS prop, immobiliare_intestazioni AS inte
                                WHERE inte.IdImmob = $temp
                                AND prop.CF = inte.IdProp";
                        $rsProp = $db->query($sqlProp);
                        $recordProp = $rsProp->fetch_assoc();

                        // se l'immobile non ha proprietario, stampa "---"
                        if($recordProp)
                            $proprietario = $recordProp['CF']." - ".$recordProp['nome']." ".$recordProp['cognome'];
                        else
                            $proprietario = "---";

                        echo("
                            <tr>
                                <td>".$record['nome']."</td>
                                <td>".$proprietario."</td>
                            </tr>
                        ");
                        $record = $rs->fetch_assoc();
                    }
                    
                    echo("
                            </tbody>
                        </table>
                    ");

                    $db->close();
                }
            ?>
        </div>
    </div>
</div>
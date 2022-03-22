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
                <a href="index.php?scelta=home" class="nav-link link-dark" class=\"text-danger\" aria-current="page">
                    <i class="bi bi-house-door" style="padding-right: 7px"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="index.php?scelta=proprietari" class="nav-link active">
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
                <a href="index.php?scelta=zone" class="nav-link link-dark">
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
            <li>
            </ul>
            <hr>
            <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" class=\"text-danger\" aria-expanded="false">
                <img src="icon/default_propic.png" alt=""style="padding-right: 12px; width:50px">
                <strong><?php echo(USERNAME) ?></strong>
            </a>
            <ul class="dropdown-menu text-small shadow" class=\"text-danger\" aria-labelledby="dropdownUser2">
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
                    <a class="nav-link" class=\"text-danger\" aria-current="page" href="index.php?scelta=proprietari&sceltaP=echoLista"><i class="bi bi-table"></i> Lista</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" class=\"text-danger\" aria-current="page" href="index.php?scelta=proprietari&sceltaP=echoAggiungi"><i class="bi bi-plus"></i> Aggiungi</a>
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
                $sceltaP = isset($_REQUEST['sceltaP']) ? $_REQUEST['sceltaP'] : null;

                switch ($sceltaP){
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
                        $CF = $_REQUEST['CF'];
                        $Nome = $_REQUEST['Nome'];
                        $Cognome = $_REQUEST['Cognome'];
                        $Telefono = $_REQUEST['Telefono'];
                        $Email = $_REQUEST['Email'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_proprietari";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();
                        
                        // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                        while($record){
                            if($record['CF'] === $CF){
                                echoAggiungi();
                                echo("<p class=\"text-danger\">Il codice fiscale inserito è già associato ad un altro proprietario.</p>");
                                break 2;
                            }else if($record['telefono'] === $Telefono){
                                echoAggiungi();
                                echo("<p class=\"text-danger\">Il numero di telefono inserito è già associato ad un altro proprietario.</p>");
                                break 2;
                            }else if($record['email'] === $Email){
                                echoAggiungi();
                                echo("<p class=\"text-danger\">L'email inserita è già associata ad un altro proprietario.</p>");
                                break 2;
                            }
                            $record = $rs->fetch_assoc();
                        }

                        /* $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB); */
                        $sql = "INSERT INTO immobiliare_proprietari(CF, nome, cognome, telefono, email)
                                VALUES ('$CF',' $Nome', '$Cognome', $Telefono, '$Email')";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=proprietari&sceltaP=echoLista');

                        break;
                    }
                    case 'echoModifica': {
                        echoModifica($_REQUEST['SelCF']);

                        break;
                    }
                    case 'modifica': {
                        $SelCF = $_REQUEST['SelCF'];

                        $CF = $_REQUEST['CF'];
                        $Nome = $_REQUEST['Nome'];
                        $Cognome = $_REQUEST['Cognome'];
                        $Telefono = $_REQUEST['Telefono'];
                        $Email = $_REQUEST['Email'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_proprietari";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();
                        
                        // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                        while($record){
                            if($record['CF'] === $CF && $record['CF'] != $SelCF){
                                echoModifica($SelCF);
                                echo("<p class=\"text-danger\">Il codice fiscale inserito è già in lista.</p>");
                                break 2;
                            }else if($record['telefono'] === $Telefono){
                                echoModifica($SelCF);
                                echo("<p class=\"text-danger\">Il numero di telefono inserito è già in lista.</p>");
                                break 2;
                            }else if($record['email'] === $Email){
                                echoModifica($SelCF);
                                echo("<p class=\"text-danger\">L'email inserita è già in lista.</p>");
                                break 2;
                            }
                            $record = $rs->fetch_assoc();
                        }

                        $sql = "UPDATE immobiliare_proprietari
                                SET CF = '$CF', nome = '$Nome', cognome = '$Cognome', telefono = $Telefono, email = '$Email'
                                WHERE CF = '$SelCF'";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=proprietari&sceltaP=echoLista');

                        break;
                    }
                    case 'echoRiepilogo': {
                        riepilogo($_REQUEST['SelCF']);
                        break;
                    }
                    case 'elimina': {
                        $SelCF = $_REQUEST['SelCF'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "DELETE FROM immobiliare_proprietari
                                WHERE CF = '$SelCF'";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=proprietari&sceltaP=echoLista');

                        break;
                    }
                }
                function echoLista(){
                        echo "<h4>Lista dei proprietari</h4>";

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_proprietari";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();

                        // stampa tabella
                        echo ("
                            <table class=\"my-4 table\">
                                <thead class=\"thead-light\">
                                    <tr>
                                    <th scope=\"col\">CF</th>
                                    <th scope=\"col\">Nome</th>
                                    <th scope=\"col\">Cognome</th>
                                    <th scope=\"col\">Telefono</th>
                                    <th scope=\"col\">Email</th>
                                    <th scope=\"col\">Operazioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");
                        while($record){
                            echo("
                                <tr>
                                    <th scope=\"row\">".$record['CF']."</th>
                                    <td>".$record['nome']."</td>
                                    <td>".$record['cognome']."</td>
                                    <td>".$record['telefono']."</td>
                                    <td>".$record['email']."</td>
                                    <td>
                                        <div class=\"dropdown\">
                                            <button class=\"btn btn-secondary dropdown-toggle btn-sm\" type=\"button\" id=\"dropdownMenuButton1\" data-bs-toggle=\"dropdown\" class=\"text-danger\" aria-expanded=\"false\">
                                                <i class=\"bi bi-wrench\"></i>
                                            </button>
                                            <ul class=\"dropdown-menu\" class=\"text-danger\" aria-labelledby=\"dropdownMenuButton1\">
                                                <li>
                                                    <a class=\"dropdown-item text-dark\" class=\"text-danger\" aria-current=\"page\" href=\"index.php?scelta=proprietari&sceltaP=echoModifica&SelCF=".$record['CF']."\"><i title=\"Modifica\" class=\"bi bi-pencil\"></i> Modifica</a>
                                                </li>
                                                <li>
                                                    <a class=\"dropdown-item text-dark\" class=\"text-danger\" aria-current=\"page\" href=\"index.php?scelta=proprietari&sceltaP=echoRiepilogo&SelCF=".$record['CF']."\"><i title=\"Riepilogo immobili\" class=\"bi bi-card-list\"></i> Riepilogo immobili</a>
                                                </li>
                                                <li>
                                                    <a class=\"dropdown-item text-dark\" class=\"text-danger\" aria-current=\"page\" href=\"createPDF.php?SelCF=".$record['CF']."\"><i title=\"Scarica PDF\" class=\"bi bi-file-earmark-pdf\"></i> Scarica PDF</a>
                                                </li>
                                                <li><hr class=\"dropdown-divider\"></li>
                                                <li>
                                                    <a class=\"dropdown-item text-danger\" class=\"text-danger\" aria-current=\"page\" href=\"index.php?scelta=proprietari&sceltaP=elimina&SelCF=".$record['CF']."\"><i title=\"Elimina\" class=\"bi bi-trash\"></i> Elimina</a>
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
                // funzioni per gli echo
                function echoAggiungi(){
                    echo "<h4>Aggiungi un proprietario</h4>
                        <div class=\"my-4 container-table\">
                            <form action=\"index.php\" autocomplete=\"off\">
                                <div class=\"row\">
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Codice fiscale</label>
                                        <div class=\"input-group\">
                                            <input type=\"text\" name=\"CF\" class=\"form-control\" placeholder=\"Codice fiscale\" required>
                                        </div>
                                    </div>
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Nome</label>
                                        <div class=\"input-group\">
                                            <input type=\"text\" name=\"Nome\" class=\"form-control\" placeholder=\"Nome\" required>
                                        </div>
                                    </div>
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Cognome</label>
                                        <div class=\"input-group\">
                                            <input type=\"text\" name=\"Cognome\" class=\"form-control\" placeholder=\"Cognome\" required>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"mt-3 row\">
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Telefono</label>
                                        <div class=\"input-group\">
                                            <input type=\"number\" name=\"Telefono\" class=\"form-control\" placeholder=\"Telefono\" required>
                                        </div>
                                    </div>
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Email</label>
                                        <div class=\"input-group\">
                                            <input type=\"text\" name=\"Email\" class=\"form-control\" placeholder=\"Email\" required>
                                        </div>
                                    </div>
                                </div>
                                <input type=\"hidden\" name=\"scelta\" value=\"proprietari\">
                                <input type=\"hidden\" name=\"sceltaP\" value=\"aggiungi\">
                                <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                            </form>
                        </div>";
                }
                function echoModifica($SelCF){
                    
                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT *
                            FROM immobiliare_proprietari
                            WHERE CF = '$SelCF'";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();

                    $CF = $record['CF'];
                    $Nome = $record['nome'];
                    $Cognome = $record['cognome'];
                    $Telefono = $record['telefono'];
                    $Email = $record['email'];

                    $db->close();

                    echo "<h4>Modifica proprietario con codice fiscale: ".$SelCF."</h4>
                    <div class=\"my-4 container-table\">
                        <form action=\"index.php\" autocomplete=\"off\">
                            <div class=\"row\">
                                <div class=\"col\">
                                    <label class=\"pb-1\">Codice fiscale</label>
                                    <div class=\"input-group\">
                                        <input type=\"text\" name=\"CF\" class=\"form-control\" placeholder=\"Codice fiscale\" value=\"$CF\" required>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Nome</label>
                                    <div class=\"input-group\">
                                        <input type=\"text\" name=\"Nome\" class=\"form-control\" placeholder=\"Nome\" value=\"$Nome\" required>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Cognome</label>
                                    <div class=\"input-group\">
                                        <input type=\"text\" name=\"Cognome\" class=\"form-control\" placeholder=\"Cognome\" value=\"$Cognome\" required>
                                    </div>
                                </div>
                            </div>
                            <div class=\"mt-3 row\">
                                <div class=\"col\">
                                    <label class=\"pb-1\">Telefono</label>
                                    <div class=\"input-group\">
                                        <input type=\"number\" name=\"Telefono\" class=\"form-control\" placeholder=\"Telefono\" value=\"$Telefono\" required>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Email</label>
                                    <div class=\"input-group\">
                                        <input type=\"text\" name=\"Email\" class=\"form-control\" placeholder=\"Email\" value=\"$Email\" required>
                                    </div>
                                </div>
                            </div>
                            <input type=\"hidden\" name=\"scelta\" value=\"proprietari\">
                            <input type=\"hidden\" name=\"sceltaP\" value=\"modifica\">
                            <input type=\"hidden\" name=\"SelCF\" value=\"$SelCF\">
                            <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                        </form>
                    </div>";
                }
                function riepilogo($SelCF){
                    // stampa tabella degli immobili di un proprietario e un tasto rapido per scaricarne il PDF
                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT immo.*, inte.IdProp
                            FROM immobiliare_immobili AS immo, immobiliare_intestazioni AS inte
                            WHERE inte.IdProp = '$SelCF'
                            AND immo.Id = inte.IdImmob";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();

                    echo "<h4>Lista degli immobili di ".$SelCF."</h4>";

                    // non stampa se il proprietario non possiede immobili
                    if($record){
                        echo("
                        <a aria-current=\"page\" href=\"createPDF.php?SelCF=".$record['IdProp']."\">
                            <button type=\"button\" class=\"mt-3 btn btn-outline-danger\">
                                <i title=\"Scarica PDF\" class=\"bi bi-file-earmark-pdf\"></i> Scarica PDF
                            </button>
                        </a>
                        ");
                    }

                    // stampa tabella
                    echo ("
                        <table class=\"my-4 table\">
                            <thead class=\"thead-light\">
                                <tr>
                                <th scope=\"col\">Id Immobile</th>
                                <th scope=\"col\">Nome</th>
                                <th scope=\"col\">Via</th>
                                <th scope=\"col\">Civico</th>
                                <th scope=\"col\">Metratura</th>
                                <th scope=\"col\">Piano</th>
                                <th scope=\"col\">Locali</th>
                                <th scope=\"col\">Tipologia</th>
                                <th scope=\"col\">Zona</th>
                                </tr>
                            </thead>
                            <tbody>
                    ");
                    while($record){
                        echo("
                            <tr>
                                <th scope=\"row\">".$record['Id']."</th>
                                <td>".$record['nome']."</td>
                                <td>".$record['via']."</td>
                                <td>".$record['civico']."</td>
                                <td>mq ".$record['metratura']."</td>
                                <td>".$record['piano']."</td>
                                <td>".$record['nLocali']."</td>");
                                
                                // partendo dall'Id della tipologia, vado nella tabella immobiliare_tipoimm e reperisco il nome della tipologia
                                $temp = $record['IdTipo'];
                                $sqlTemp = "SELECT tipo.tipo
                                            FROM immobiliare_tipoimm AS tipo, immobiliare_immobili AS immo
                                            WHERE tipo.Id = $temp";
                                $rsTemp = $db->query($sqlTemp);
                                $recordTemp = $rsTemp->fetch_assoc();
                                
                                echo("<td>".$recordTemp['tipo']."</td>");

                                // partendo dall'Id della zona, vado nella tabella immobiliare_tipozona e reperisco il nome della zona
                                $temp = $record['IdZona'];
                                $sqlTemp = "SELECT zona.zona
                                            FROM immobiliare_tipozona AS zona, immobiliare_immobili AS immo
                                            WHERE zona.Id = $temp";
                                $rsTemp = $db->query($sqlTemp);
                                $recordTemp = $rsTemp->fetch_assoc();
                                echo("<td>".$recordTemp['zona']."</td>
                            </tr>
                        ");
                        $record = $rs->fetch_assoc();
                    }
                    echo("
                            </tbody>
                        </table>
                    ");
                }
            ?>
        </div>
    </div>
</div>
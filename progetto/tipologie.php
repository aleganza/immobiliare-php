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
                <a href="index.php?scelta=zone" class="nav-link link-dark">
                    <i class="bi bi-geo-alt" style="padding-right: 7px"></i>
                    Zone
                </a>
            </li>
            <li>
                <a href="index.php?scelta=tipologie" class="nav-link active">
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
                <a class="nav-link" aria-current="page" href="index.php?scelta=tipologie&sceltaT=echoLista"><i class="bi bi-table"></i> Lista</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php?scelta=tipologie&sceltaT=echoAggiungi"><i class="bi bi-plus"></i> Aggiungi</a>
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
            $sceltaT = isset($_REQUEST['sceltaT']) ? $_REQUEST['sceltaT'] : null;

            switch ($sceltaT){
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
                    $Tipo = $_REQUEST['tipo'];

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT * FROM immobiliare_tipoimm";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();
                    
                    // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                    while($record){
                        if($record['tipo'] === $Tipo){
                            echoAggiungi();
                            echo("<p class=\"text-danger\">Il tipo di immobile inserito è già esistente.</p>");
                            break 2;
                        }
                        $record = $rs->fetch_assoc();
                    }

                    /* $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB); */
                    $sql = "INSERT INTO immobiliare_tipoimm(tipo)
                            VALUES ('$Tipo')";
                    $rs = $db->query($sql);

                    $db->close();
                    header('Location: index.php?scelta=tipologie&sceltaT=echoLista');

                    break;
                }
                case 'echoModifica': {
                    echoModifica($_REQUEST['SelId']);

                    break;
                }
                case 'modifica': {
                    $SelId = $_REQUEST['SelId'];

                    $Tipo = $_REQUEST['tipo'];

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT * FROM immobiliare_tipoimm";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();
                    
                    // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                    while($record){
                        if($record['tipo'] === $Tipo && $record['Id'] != $SelId){
                            echoModifica($SelId);
                            echo("<p class=\"text-danger\">Il tipo di immobile inserito è già esistente.</p>");
                            break 2;
                        }
                        $record = $rs->fetch_assoc();
                    }

                    $sql = "UPDATE immobiliare_tipoimm
                            SET tipo = '$Tipo'
                            WHERE Id = '$SelId'";
                    $rs = $db->query($sql);

                    $db->close();
                    header('Location: index.php?scelta=tipologie&sceltaT=echoLista');

                    break; 
                }
                case 'elimina': {
                    $SelId = $_REQUEST['SelId'];

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "DELETE FROM immobiliare_tipoimm
                            WHERE Id = '$SelId'";
                    $rs = $db->query($sql);

                    $db->close();
                    header('Location: index.php?scelta=tipologie&sceltaT=echoLista');

                    break;
                }
            }
            // funzioni per le stampe
            function echoLista(){
                    echo "<h4>Lista delle tipologie</h4>";

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT * FROM immobiliare_tipoimm";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();

                    // stampa tabella
                    echo ("
                        <table class=\"my-4 table\">
                            <thead class=\"thead-light\">
                                <tr>
                                <th scope=\"col\">Id</th>
                                <th scope=\"col\">tipo</th>
                                <th scope=\"col\">Operazioni</th>
                                </tr>
                            </thead>
                            <tbody>
                    ");
                    while($record){
                        echo("
                            <tr>
                                <th scope=\"row\">".$record['Id']."</th>
                                <td>".$record['tipo']."</td>
                                <td>
                                    <div class=\"dropdown\">
                                        <button class=\"btn btn-secondary dropdown-toggle btn-sm\" type=\"button\" id=\"dropdownMenuButton1\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                            <i class=\"bi bi-wrench\"></i>
                                        </button>
                                        <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton1\">
                                            <li>
                                                <a class=\"dropdown-item text-dark\" aria-current=\"page\" href=\"index.php?scelta=tipologie&sceltaT=echoModifica&SelId=".$record['Id']."\"><i title=\"Modifica\" class=\"bi bi-pencil\"></i> Modifica</a>
                                            </li>
                                            <li><hr class=\"dropdown-divider\"></li>
                                            <li>
                                                <a class=\"dropdown-item text-danger\" aria-current=\"page\" href=\"index.php?scelta=tipologie&sceltaT=elimina&SelId=".$record['Id']."\"><i title=\"Elimina\" class=\"bi bi-trash\"></i> Elimina</a>
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
                echo "<h4>Aggiungi una tipologia</h4>
                    <div class=\"my-4 container-table\">
                        <form action=\"index.php\" autocomplete=\"off\">
                            <label class=\"pb-1\">Nome tipologia</label>
                            <div class=\"input-group\">
                                <input type=\"text\" name=\"tipo\" class=\"form-control\" placeholder=\"Nome tipologia\" required>
                            </div>
                            <input type=\"hidden\" name=\"scelta\" value=\"tipologie\">
                            <input type=\"hidden\" name=\"sceltaT\" value=\"aggiungi\">
                            <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                        </form>
                    </div>";
            }
            function echoModifica($SelId){

                $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                $sql = "SELECT *
                        FROM immobiliare_tipoimm
                        WHERE Id = $SelId";
                $rs = $db->query($sql);
                $record = $rs->fetch_assoc();

                $Tipo = $record['tipo'];

                $db->close();

                echo "<h4>Modifica tipologia</h4>
                <div class=\"my-4 container-table\">
                        <form action=\"index.php\" autocomplete=\"off\">
                            <label class=\"pb-1\">Nome tipologia</label>
                            <div class=\"input-group\">
                                <input type=\"text\" name=\"tipo\" class=\"form-control\" placeholder=\"Nome tipologia\" value=\"$Tipo\" required>
                            </div>
                            <input type=\"hidden\" name=\"scelta\" value=\"tipologie\">
                            <input type=\"hidden\" name=\"sceltaT\" value=\"modifica\">
                            <input type=\"hidden\" name=\"SelId\" value=\"$SelId\">
                            <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                        </form>
                    </div>";
            }
        ?>
    </div>
</div>
</div>
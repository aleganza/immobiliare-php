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
                <a href="index.php?scelta=intestazioni" class="nav-link active">
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
                    <a class="nav-link" aria-current="page" href="index.php?scelta=intestazioni&sceltaInt=echoLista"><i class="bi bi-table"></i> Lista</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php?scelta=intestazioni&sceltaInt=echoAggiungi"><i class="bi bi-plus"></i> Aggiungi</a>
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
                $sceltaInt = isset($_REQUEST['sceltaInt']) ? $_REQUEST['sceltaInt'] : null;

                switch ($sceltaInt){
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
                        $Data = $_REQUEST['Data'];
                        $Versamento = $_REQUEST['Versamento'];
                        $IdProp = $_REQUEST['IdProp'];
                        $IdImmob = $_REQUEST['IdImmob'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_intestazioni";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();
                        
                        // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                        while($record){
                            if($record['IdProp'] === $IdProp && $record['IdImmob'] === $IdImmob){
                                echoAggiungi();
                                echo("<p class=\"text-danger\">Esiste già un'intestazione fra questo proprietario e questo immobile.</p>");
                                break 2;
                            }/* 
                            if($record['IdImmob'] === $IdImmob){
                                echoAggiungi();
                                echo("<p class=\"text-danger\">L'immobile appartiene già ad un proprietario.</p>");
                                break 2;
                            } */
                            $record = $rs->fetch_assoc();
                        }

                        /* $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB); */
                        $sql = "INSERT INTO immobiliare_intestazioni(data, versamento, IdProp, IdImmob)
                                VALUES ('$Data', '$Versamento', '$IdProp', $IdImmob)";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=intestazioni&sceltaInt=echoLista');

                        break;
                    }
                    case 'echoModifica': {
                        echoModifica($_REQUEST['SelId']);

                        break;
                    }
                    case 'modifica': {
                        $SelId = $_REQUEST['SelId'];

                        $Data = $_REQUEST['Data'];
                        $Versamento = $_REQUEST['Versamento'];
                        $IdProp = $_REQUEST['IdProp'];
                        $IdImmob = $_REQUEST['IdImmob'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_intestazioni";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();
                        
                        // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                        /* while($record){
                            if($record['IdProp'] === $IdProp && $record['IdImmob'] === $IdImmob){
                                echoAggiungi();
                                echo("<p class=\"text-danger\">Esiste già un'intestazione fra questo proprietario e questo immobile.</p>");
                                break 2;
                            }
                            if($record['IdImmob'] === $IdImmob){
                                echoAggiungi();
                                echo("<p class=\"text-danger\">L'immobile appartiene già ad un proprietario.</p>");
                                break 2;
                            }
                            $record = $rs->fetch_assoc();
                        } */

                        $sql = "UPDATE immobiliare_intestazioni
                                SET data = '$Data', versamento = '$Versamento', IdProp = '$IdProp', IdImmob = $IdImmob
                                WHERE Id = $SelId";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=intestazioni&sceltaInt=echoLista');

                        break; 
                    }
                    case 'elimina': {
                        $SelId = $_REQUEST['SelId'];

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "DELETE FROM immobiliare_intestazioni
                                WHERE Id = $SelId";
                        $rs = $db->query($sql);

                        $db->close();
                        header('Location: index.php?scelta=intestazioni&sceltaInt=echoLista');

                        break;
                    }
                }
                function echoLista(){
                        echo "<h4>Lista delle intestazioni</h4>";

                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                        $sql = "SELECT * FROM immobiliare_intestazioni";
                        $rs = $db->query($sql);
                        $record = $rs->fetch_assoc();

                        // stampa tabella
                        echo ("
                            <table class=\"my-4 table\">
                                <thead class=\"thead-light\">
                                    <tr>
                                    <th scope=\"col\">Id</th>
                                    <th scope=\"col\">Data</th>
                                    <th scope=\"col\">Versamento</th>
                                    <th scope=\"col\">Proprietario</th>
                                    <th scope=\"col\">Immobile</th>
                                    <th scope=\"col\">Operazioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");
                        while($record){
                            echo("
                                <tr>
                                    <th scope=\"row\">".$record['Id']."</th>
                                    <td>".$record['data']."</td>
                                    <td>€ ".$record['versamento']."</td>");
                                    
                                    // partendo dal CF del proprietario, vado nella tabella immobiliare_proprietari e reperisco nome e cognome
                                    $temp = $record['IdProp'];
                                    $sqlTemp = "SELECT prop.nome, prop.cognome
                                                FROM immobiliare_proprietari AS prop, immobiliare_intestazioni AS inte
                                                WHERE prop.CF = '$temp'";
                                    $rsTemp = $db->query($sqlTemp);
                                    $recordTemp = $rsTemp->fetch_assoc();
                                    // in questo modo stampo in tabella CF, nome e cognome
                                    echo("<td>".$record['IdProp']." - ".$recordTemp['nome']." ".$recordTemp['cognome']."</td>");

                                    // partendo dall'Id dell'immobile, vado nella tabella immobiliare_immobili e reperisco il nome
                                    $temp = $record['IdImmob'];
                                    $sqlTemp = "SELECT immo.nome
                                                FROM immobiliare_immobili AS immo, immobiliare_intestazioni AS inte
                                                WHERE immo.Id = '$temp'";
                                    $rsTemp = $db->query($sqlTemp);
                                    $recordTemp = $rsTemp->fetch_assoc();
                                    // in questo modo stampo in tabella il nome
                                    echo("<td>".$recordTemp['nome']."</td>

                                    <td>
                                        <div class=\"dropdown\">
                                            <button class=\"btn btn-secondary dropdown-toggle btn-sm\" type=\"button\" id=\"dropdownMenuButton1\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                                <i class=\"bi bi-wrench\"></i>
                                            </button>
                                            <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton1\">
                                                <li>
                                                    <a class=\"dropdown-item text-dark\" aria-current=\"page\" href=\"index.php?scelta=intestazioni&sceltaInt=echoModifica&SelId=".$record['Id']."\"><i title=\"Modifica\" class=\"bi bi-pencil\"></i> Modifica</a>
                                                </li>
                                                <li><hr class=\"dropdown-divider\"></li>
                                                <li>
                                                    <a class=\"dropdown-item text-danger\" aria-current=\"page\" href=\"index.php?scelta=intestazioni&sceltaInt=elimina&SelId=".$record['Id']."\"><i title=\"Elimina\" class=\"bi bi-trash\"></i> Elimina</a>
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
                    echo "<h4>Aggiungi un intestazione</h4>
                        <div class=\"my-4 container-table\">
                            <form action=\"index.php\" autocomplete=\"off\">
                                <div class=\"row\">
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Data</label>
                                        <div class=\"input-group\">
                                            <input type=\"date\" name=\"Data\" class=\"form-control\" placeholder=\"Data\" required>
                                        </div>
                                    </div>
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Versamento</label>
                                        <div class=\"input-group\">
                                            <div class=\"input-group-text\">€</div>
                                            <input type=\"text\" name=\"Versamento\" class=\"form-control\" placeholder=\"Versamento\" required>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"mt-3 row\">
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Proprietario</label>
                                        <div class=\"input-group\">
                                            <select name=\"IdProp\" class=\"form-select\" aria-label=\"Default select example\" required>
                                                <option value=\"\" disabled selected>Seleziona proprietario</option>";
                                                // settaggio dei proprietari selezionabili

                                                $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                                                $sql = "SELECT * FROM immobiliare_proprietari";
                                                $rs = $db->query($sql);
                                                $record = $rs->fetch_assoc();

                                                while($record){
                                                    echo "
                                                        <option value=\"".$record['CF']."\">".$record['CF']." - ".$record['nome']." ".$record['cognome']."</option>
                                                    ";
                                                    $record = $rs->fetch_assoc();
                                                }
                                                $db->close();
                                            echo "</select>
                                        </div>
                                    </div>
                                    <div class=\"col\">
                                        <label class=\"pb-1\">Immobile</label>
                                        <div class=\"input-group\">
                                            <select name=\"IdImmob\" class=\"form-select\" aria-label=\"Default select example\" required>
                                                <option value=\"\" disabled selected>Seleziona immobile</option>";
                                                // settaggio degli immobili selezionabili

                                                $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                                                $sql = "SELECT * FROM immobiliare_immobili";
                                                $rs = $db->query($sql);
                                                $record = $rs->fetch_assoc();

                                                while($record){
                                                    echo "
                                                        <option value=\"".$record['Id']."\">".$record['nome']."</option>
                                                    ";
                                                    $record = $rs->fetch_assoc();
                                                }
                                                $db->close();
                                            echo "</select>
                                        </div>
                                    </div>
                                </div>
                                <input type=\"hidden\" name=\"scelta\" value=\"intestazioni\">
                                <input type=\"hidden\" name=\"sceltaInt\" value=\"aggiungi\">
                                <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                            </form>
                        </div>";
                }
                function echoModifica($SelId){

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT *
                            FROM immobiliare_intestazioni
                            WHERE Id = $SelId";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();
    
                    $Data = $record['data'];
                    $Versamento = $record['versamento'];
    
                    $db->close();

                    echo "<h4>Modifica intestazione</h4>
                    <div class=\"my-4 container-table\">
                        <form action=\"index.php\" autocomplete=\"off\">
                            <div class=\"row\">
                                <div class=\"col\">
                                    <label class=\"pb-1\">Data</label>
                                    <div class=\"input-group\">
                                        <input type=\"date\" name=\"Data\" class=\"form-control\" placeholder=\"Data\" value=\"$Data\" required>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Versamento</label>
                                    <div class=\"input-group\">
                                        <div class=\"input-group-text\">€</div>
                                        <input type=\"text\" name=\"Versamento\" class=\"form-control\" placeholder=\"Versamento\" value=\"$Versamento\" required>
                                    </div>
                                </div>
                            </div>
                            <div class=\"mt-3 row\">
                                <div class=\"col\">
                                    <label class=\"pb-1\">Proprietario</label>
                                    <div class=\"input-group\">
                                        <select name=\"IdProp\" class=\"form-select\" aria-label=\"Default select example\" required>
                                            <option value=\"\" disabled selected>Seleziona proprietario</option>";
                                            // settaggio dei proprietari selezionabili

                                            $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                                            $sql = "SELECT * FROM immobiliare_proprietari";
                                            $rs = $db->query($sql);
                                            $record = $rs->fetch_assoc();

                                            while($record){
                                                echo "
                                                    <option value=\"".$record['CF']."\">".$record['CF']." - ".$record['nome']." ".$record['cognome']."</option>
                                                ";
                                                $record = $rs->fetch_assoc();
                                            }
                                            $db->close();
                                        echo "</select>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Immobile</label>
                                    <div class=\"input-group\">
                                        <select name=\"IdImmob\" class=\"form-select\" aria-label=\"Default select example\" required>
                                            <option value=\"\" disabled selected>Seleziona immobile</option>";
                                            // settaggio degli immobili selezionabili

                                            $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                                            $sql = "SELECT * FROM immobiliare_immobili";
                                            $rs = $db->query($sql);
                                            $record = $rs->fetch_assoc();

                                            while($record){
                                                echo "
                                                    <option value=\"".$record['Id']."\">".$record['nome']."</option>
                                                ";
                                                $record = $rs->fetch_assoc();
                                            }
                                            $db->close();
                                        echo "</select>
                                    </div>
                                </div>
                            </div>
                            <input type=\"hidden\" name=\"scelta\" value=\"intestazioni\">
                            <input type=\"hidden\" name=\"sceltaInt\" value=\"modifica\">
                            <input type=\"hidden\" name=\"SelId\" value=\"$SelId\">
                            <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                        </form>
                    </div>";
                }
            ?>
        </div>
    </div>
</div>
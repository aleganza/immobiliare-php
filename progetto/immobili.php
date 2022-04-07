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
                <a href="index.php?scelta=immobili" class="nav-link active">
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
    <!-- sotto-navbar per operazioni secondarie -->
    <nav class="navbar navbar-expand-lg navbar-light p-2">
    <div class="container-fluid">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php?scelta=immobili&sceltaI=echoLista"><i class="bi bi-table"></i> Lista</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php?scelta=immobili&sceltaI=echoAggiungi"><i class="bi bi-plus"></i> Aggiungi</a>
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
            $sceltaI = isset($_REQUEST['sceltaI']) ? $_REQUEST['sceltaI'] : null;

            switch ($sceltaI){
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
                    $Nome = $_REQUEST['Nome'];
                    $Via = $_REQUEST['Via'];
                    $Civico = $_REQUEST['Civico'];
                    $Metratura = $_REQUEST['Metratura'];
                    $Piano = $_REQUEST['Piano'];
                    $Locali = $_REQUEST['Locali'];
                    $IdTipologia = $_REQUEST['IdTipologia'];
                    $IdZona = $_REQUEST['IdZona'];

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT * FROM immobiliare_immobili";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();
                    
                    // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                    while($record){
                        if($record['nome'] === $Nome){
                            echoAggiungi();
                            echo("<p class=\"text-danger\">Esiste già un immobile con questo nome.</p>");
                            break 2;
                        }
                        $record = $rs->fetch_assoc();
                    }

                    /* $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB); */
                    $sql = "INSERT INTO immobiliare_immobili(nome, via, civico, metratura, piano, nLocali, IdTipo, IdZona)
                            VALUES ('$Nome',' $Via', '$Civico', $Metratura, '$Piano', '$Locali', $IdTipologia, $IdZona)";
                            echo($sql);
                    $rs = $db->query($sql);

                    $db->close();
                    header('Location: index.php?scelta=immobili&sceltaI=echoLista');

                    break;
                }
                case 'echoModifica': {
                    echoModifica($_REQUEST['SelId']);

                    break;
                }
                case 'modifica': {
                    $SelId = $_REQUEST['SelId'];

                    $Nome = $_REQUEST['Nome'];
                    $Via = $_REQUEST['Via'];
                    $Civico = $_REQUEST['Civico'];
                    $Metratura = $_REQUEST['Metratura'];
                    $Piano = $_REQUEST['Piano'];
                    $Locali = $_REQUEST['Locali'];

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT * FROM immobiliare_immobili";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();
                    
                    // ciclo di controllo per verificare se le credenziali inserite non siano già utilizzate
                    while($record){
                        if($record['nome'] === $Nome){
                            echoAggiungi();
                            echo("<p class=\"text-danger\">Esiste già un immobile con questo nome.</p>");
                            break 2;
                        }
                        $record = $rs->fetch_assoc();
                    }

                    $sql = "UPDATE immobiliare_immobili
                            SET nome = '$Nome', via = '$Via', civico = '$Civico', metratura = '$Metratura', piano = '$Piano', nLocali = '$Locali'
                            WHERE Id = '$SelId'";
                    $rs = $db->query($sql);

                    $db->close();
                    header('Location: index.php?scelta=immobili&sceltaI=echoLista');

                    break; 
                }
                case 'elimina': {
                    $SelId = $_REQUEST['SelId'];

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "DELETE FROM immobiliare_immobili
                            WHERE Id = '$SelId'";
                    $rs = $db->query($sql);

                    $db->close();
                    header('Location: index.php?scelta=immobili&sceltaI=echoLista');

                    break;
                }
            }
            // funzioni per le stampe
            function echoLista(){
                    echo "<h4>Lista degli immobili</h4>";

                    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                    $sql = "SELECT * FROM immobiliare_immobili";
                    $rs = $db->query($sql);
                    $record = $rs->fetch_assoc();

                    // stampa tabella
                    echo ("
                        <table class=\"my-4 table\">
                            <thead class=\"thead-light\">
                                <tr>
                                <th scope=\"col\">Id</th>
                                <th scope=\"col\">Nome</th>
                                <th scope=\"col\">Via</th>
                                <th scope=\"col\">Civico</th>
                                <th scope=\"col\">Metratura</th>
                                <th scope=\"col\">Piano</th>
                                <th scope=\"col\">Locali</th>
                                <th scope=\"col\">Tipologia</th>
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
                                

                                <td>
                                    <div class=\"dropdown\">
                                        <button class=\"btn btn-secondary dropdown-toggle btn-sm\" type=\"button\" id=\"dropdownMenuButton1\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                            <i class=\"bi bi-wrench\"></i>
                                        </button>
                                        <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton1\">
                                            <li>
                                                <a class=\"dropdown-item text-dark\" aria-current=\"page\" href=\"index.php?scelta=immobili&sceltaI=echoModifica&SelId=".$record['Id']."\"><i title=\"Modifica\" class=\"bi bi-pencil\"></i> Modifica</a>
                                            </li>
                                            <li><hr class=\"dropdown-divider\"></li>
                                            <li>
                                                <a class=\"dropdown-item text-danger\" aria-current=\"page\" href=\"index.php?scelta=immobili&sceltaI=elimina&SelId=".$record['Id']."\"><i title=\"Elimina\" class=\"bi bi-trash\"></i> Elimina</a>
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
                echo "<h4>Aggiungi un immobile</h4>
                    <div class=\"my-4 container-table\">
                        <form action=\"index.php\" autocomplete=\"off\">
                            <div class=\"row\">
                                <div class=\"col\">
                                    <label class=\"pb-1\">Nome</label>
                                    <div class=\"input-group\">
                                        <input type=\"text\" name=\"Nome\" class=\"form-control\" placeholder=\"Nome\" required>
                                    </div>
                                </div>
                            </div>
                            <div class=\"mt-3 row\">    
                                <div class=\"col\">
                                    <label class=\"pb-1\">Via</label>
                                    <div class=\"input-group\">
                                        <div class=\"input-group-text\">Via</div>
                                        <input type=\"text\" name=\"Via\" class=\"form-control\" placeholder=\"Via\" required>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Numero civico</label>
                                    <div class=\"input-group\">
                                        <div class=\"input-group-text\">N.</div>
                                        <input type=\"number\" name=\"Civico\" class=\"form-control\" placeholder=\"Numero civico\" required>
                                    </div>
                                </div>
                            </div>
                            <div class=\"mt-3 row\">
                                <div class=\"col\">
                                    <label class=\"pb-1\">Metratura</label>
                                    <div class=\"input-group\">
                                        <div class=\"input-group-text\">mq</div>
                                        <input type=\"number\" name=\"Metratura\" class=\"form-control\" placeholder=\"Metratura\" required>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Piano</label>
                                    <div class=\"input-group\">
                                        <input type=\"number\" name=\"Piano\" class=\"form-control\" placeholder=\"Piano\" required>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Locali</label>
                                    <div class=\"input-group\">
                                        <input type=\"number\" name=\"Locali\" class=\"form-control\" placeholder=\"Locali\" required>
                                    </div>
                                </div>
                            </div>
                            <div class=\"mt-3 row\">
                                <div class=\"col\">
                                    <label class=\"pb-1\">Tipologia</label>
                                    <div class=\"input-group\">
                                        <select name=\"IdTipologia\" class=\"form-select\" aria-label=\"Default select example\" required>
                                            <option value=\"\" disabled selected>Seleziona tipologia</option>";
                                            // settaggio delle tipologie selezionabili

                                            $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                                            $sql = "SELECT * FROM immobiliare_tipoimm";
                                            $rs = $db->query($sql);
                                            $record = $rs->fetch_assoc();

                                            while($record){
                                                echo "
                                                    <option value=\"".$record['Id']."\">".$record['tipo']."</option>
                                                ";
                                                $record = $rs->fetch_assoc();
                                            }
                                            $db->close();
                                        echo "</select>
                                    </div>
                                </div>
                                <div class=\"col\">
                                    <label class=\"pb-1\">Zona</label>
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
                                </div>
                            </div>
                            <input type=\"hidden\" name=\"scelta\" value=\"immobili\">
                            <input type=\"hidden\" name=\"sceltaI\" value=\"aggiungi\">
                            <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                        </form>
                    </div>";
            }
            function echoModifica($SelId){

                $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                $sql = "SELECT *
                        FROM immobiliare_immobili
                        WHERE Id = $SelId";
                $rs = $db->query($sql);
                $record = $rs->fetch_assoc();

                $Nome = $record['nome'];
                $Via = $record['via'];
                $Civico = $record['civico'];
                $Metratura = $record['metratura'];
                $Piano = $record['piano'];
                $Locali = $record['nLocali'];

                $db->close();

                echo "<h4>Modifica immobile</h4>
                    <div class=\"my-4 container-table\">
                        <form action=\"index.php\" autocomplete=\"off\">
                        <div class=\"row\">
                            <div class=\"col\">
                                <label class=\"pb-1\">Nome</label>
                                <div class=\"input-group\">
                                    <input type=\"text\" name=\"Nome\" class=\"form-control\" placeholder=\"Nome\" value=\"$Nome\" required>
                                </div>
                            </div>
                        </div>
                        <div class=\"mt-3 row\">
                            <div class=\"col\">
                                <label class=\"pb-1\">Via</label>
                                <div class=\"input-group\">
                                    <div class=\"input-group-text\">Via</div>
                                    <input type=\"text\" name=\"Via\" class=\"form-control\" placeholder=\"Via\" value=\"$Via\" required>
                                </div>
                            </div>
                            <div class=\"col\">
                                <label class=\"pb-1\">Numero civico</label>
                                <div class=\"input-group\">
                                    <div class=\"input-group-text\">N.</div>
                                    <input type=\"number\" name=\"Civico\" class=\"form-control\" placeholder=\"Numero civico\" value=\"$Civico\" required>
                                </div>
                            </div>
                        </div>
                        <div class=\"mt-3 row\">
                            <div class=\"col\">
                                <label class=\"pb-1\">Metratura</label>
                                <div class=\"input-group\">
                                    <div class=\"input-group-text\">mq</div>
                                    <input type=\"number\" name=\"Metratura\" class=\"form-control\" placeholder=\"Metratura\" value=\"$Metratura\" required>
                                </div>
                            </div>
                            <div class=\"col\">
                                <label class=\"pb-1\">Piano</label>
                                <div class=\"input-group\">
                                    <input type=\"number\" name=\"Piano\" class=\"form-control\" placeholder=\"Piano\" value=\"$Piano\" required>
                                </div>
                            </div>
                            <div class=\"col\">
                                <label class=\"pb-1\">Locali</label>
                                <div class=\"input-group\">
                                    <input type=\"number\" name=\"Locali\" class=\"form-control\" placeholder=\"Locali\" value=\"$Locali\" required>
                                </div>
                            </div>
                        </div>
                        <div class=\"mt-3 row\">
                            <div class=\"col\">
                                <label class=\"pb-1\">Tipologia</label>
                                <div class=\"input-group\">
                                    <select name=\"IdTipologia\" class=\"form-select\" aria-label=\"Default select example\" required>
                                        <option value=\"\" disabled selected>Seleziona tipologia</option>";
                                        // settaggio delle tipologie selezionabili

                                        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
                                        $sql = "SELECT * FROM immobiliare_tipoimm";
                                        $rs = $db->query($sql);
                                        $record = $rs->fetch_assoc();

                                        while($record){
                                            echo "
                                                <option value=\"".$record['Id']."\">".$record['tipo']."</option>
                                            ";
                                            $record = $rs->fetch_assoc();
                                        }
                                        $db->close();
                                    echo "</select>
                                </div>
                            </div>
                            <div class=\"col\">
                                <label class=\"pb-1\">Zona</label>
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
                            </div>
                        </div>
                        <input type=\"hidden\" name=\"scelta\" value=\"immobili\">
                        <input type=\"hidden\" name=\"sceltaI\" value=\"modifica\">
                        <input type=\"hidden\" name=\"SelId\" value=\"$SelId\">
                        <button type=\"submit\" class=\"mt-3 btn btn-primary\">Invia dati</button>
                    </form>
                </div>";
            }
        ?>
    </div>
</div>
</div>
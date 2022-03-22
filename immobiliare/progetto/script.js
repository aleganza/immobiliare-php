function filtraImmobili() {
    var a, i, txtValue;
    var input = document.getElementById('filtraImm');
    var filter = input.value.toUpperCase();
    var table = document.getElementById("immobiliDaFiltrare");
    var row = table.getElementsByTagName('tr');
  
    for (i = 0; i < row.length; i++) {
        element = row[i].getElementsByTagName("td")[0];
        txtValue = element.textContent || element.innerText;

        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            row[i].style.display = "";
        } else {
            row[i].style.display = "none";
        }
        }
    }
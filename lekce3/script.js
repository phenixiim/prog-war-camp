function hideH1ShowH2() {
    // skryti h1
    document.getElementById('h1').style.display="none";
    // pridani h2
    document.body.innerHTML = document.body.innerHTML + '<h2 id="h2">druhý nadpis 3</h2>'
}

function replaceHTexts() {
    // najit h1
    var element1 = document.getElementById('h1');
    // nahradit textem
    element1.innerHTML = "nahrazeniH1";

    if(element1 == null) {
        alert('h1 neexistuje');
    }


    // najit h2

    var element2 = document.getElementById('h2');

    if(element2 == null) {
        alert('h2 neexistuje');
    }
    // nahradit textem
    element2.innerHTML = "nahrazeniH2";
}
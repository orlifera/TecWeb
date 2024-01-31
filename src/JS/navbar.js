// Funzione per la richiesta Fetch
function fetchDataWithFetch() {
    // Effettua la richiesta GET al tuo file PHP
    fetch('src/php/navbar.php')
    .then(response => response.text())
    .then(data => {
        // Gestisci la risposta
        document.getElementById("loginout").innerHTML = data;
    })
    .catch(error => console.error('Errore:', error));
}

// Chiamata alla funzione al caricamento della pagina
fetchDataWithFetch();
// Funzione per la richiesta Fetch
function fetchDataWithFetch() {
    // Per Index
    // Effettua la richiesta GET al tuo file PHP
    fetch('src/php/navbar.php')
    .then(response => response.text())
    .then(data => {
        // Gestisci la risposta
        document.getElementById("loginout").innerHTML = data;
    })
    .catch(error => console.error('Errore:', error));
    
    // Per le altre pagine
    // Effettua la richiesta GET al tuo file PHP
    fetch('../php/navbar.php')
    .then(response => response.text())
    .then(data => {
        // Gestisci la risposta
        document.getElementById("loginoutaltro").innerHTML = data;
    })
    .catch(error => console.error('Errore:', error));
}

// Chiamata alla funzione al caricamento della pagina
fetchDataWithFetch();
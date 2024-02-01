// Funzione per la richiesta Fetch
function fetchDataWithFetch() {
    // Per Index
    // Effettua la richiesta GET al tuo file PHP
    fetch('src/php/navbarIndex.php')
    .then(response => response.text())
    .then(data => {
        // Gestisci la risposta
        document.querySelectorAll(".loginout").forEach(item => item.innerHTML = data);
    })
    .catch(error => console.error('Errore:', error));
    
    // Per le altre pagine
    // Effettua la richiesta GET al tuo file PHP
    fetch('../php/navbarAltro.php')
    .then(response => response.text())
    .then(data => {
        // Gestisci la risposta
        document.querySelectorAll(".loginoutaltro").forEach(item => item.innerHTML = data);
    })
    .catch(error => console.error('Errore:', error));
}

// Chiamata alla funzione al caricamento della pagina
fetchDataWithFetch();
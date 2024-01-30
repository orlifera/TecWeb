<?php

namespace DB;

class DBAccess
{
    private const SERVER_NAME = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DB_NAME = "tecweb";
    private $connection;
    public function openDBConnection()
    {
        $this->connection = mysqli_connect(
            self::SERVER_NAME,
            self::USERNAME,
            self::PASSWORD,
            self::DB_NAME
        );
        return mysqli_connect_errno() == 0;
    }

    /************ GESTIONE LOGIN E REGISTRAZIONE ************/
    // FINIRE QUA 
    public function getUsername($username)
    {
        $query = "SELECT * FROM utente WHERE username = ?;";
    }

    /************ GESTIONE PROFILO ************/
    public function getProfileInfo($username)
    {
        $query = "SELECT * FROM utente WHERE username = ?;";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);

        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($queryResult) != 0) {
            $row = mysqli_fetch_assoc($queryResult);
            mysqli_stmt_close($stmt);
            return array($row["nome"], $row["cognome"], $row["dataNascita"], $row["genere"], $row["username"], $row["email"],  $row["password"], $row["telefono"], $row["citta"], $row["indirizzo"], $row["CAP"]);
        } else {
            mysqli_stmt_close($stmt);
            return null;
        }
    }

    public function updatePersonalInfo($fname, $lname, $email, $phone)
    {
        $query = "UPDATE utente SET nome = ?, cognome = ?, telefono = ? WHERE email = ?;";
        $stmt = mysqli_prepare($this->connection, $query);
        if ($stmt === false) {
            die("Errore nella preparazione dello statement: " . mysqli_error($this->connection));
        }
        mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $phone, $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "Aggiornamento info avvenuto";
        } else {
            echo "Aggiornamento info non avvenuto: " . mysqli_error($this->connection);
        }
        mysqli_stmt_close($stmt);
    }

    public function updatePsw($email, $psw)
    {
        $query = "UPDATE utente SET password = ? WHERE email = ?;";
        $stmt = mysqli_prepare($this->connection, $query);
        if ($stmt === false) {
            die("Errore nella preparazione dello statement: " . mysqli_error($this->connection));
        }
        mysqli_stmt_bind_param($stmt, "ss", $psw, $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "Aggiornamento psw avvenuto";
        } else {
            echo "Aggiornamento psw non avvenuto: " . mysqli_error($this->connection);
        }
        mysqli_stmt_close($stmt);
    }

    public function updateAddressInfo($email, $city, $address, $cap)
    {
        $query = "UPDATE utente SET citta = ?, indirizzo = ?, CAP = ? WHERE email = ?;";
        $stmt = mysqli_prepare($this->connection, $query);
        if ($stmt === false) {
            die("Errore nella preparazione dello statement: " . mysqli_error($this->connection));
        }
        mysqli_stmt_bind_param($stmt, "ssis", $city, $address, $cap, $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "Aggiornamento address avvenuto";
        } else {
            echo "Aggiornamento address non avvenuto: " . mysqli_error($this->connection);
        }
        mysqli_stmt_close($stmt);
    }


    /************ GESTIONE PRODOTTI ************/
    public function getProduct($categoria, $sku)
    {
        $query = "SELECT SKU, Nome, Tipo, Descrizione, Prezzo, Colore, Disponibilita, path_immagine, riferimento FROM Prodotto WHERE categoria = ? AND SKU = ?";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "ss", $categoria, $sku);

        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($queryResult) != 0) {
            $row = mysqli_fetch_assoc($queryResult);
            mysqli_stmt_close($stmt);
            return array($row["SKU"], $row["Nome"], $row["Tipo"], $row["Descrizione"], $row["Prezzo"], $row["Colore"],  $row["Disponibilita"], $row["path_immagine"], $row["riferimento"]);
        } else {
            mysqli_stmt_close($stmt);
            return null;
        }
    }

    public function getProductAdmin($sku)
    {
        $query = "SELECT SKU, Nome, Tipo, Descrizione, categoria, Prezzo, Colore, Disponibilita, path_immagine, riferimento FROM Prodotto WHERE SKU = ?";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $sku);

        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($queryResult) != 0) {
            $row = mysqli_fetch_assoc($queryResult);
            mysqli_stmt_close($stmt);
            return array($row["SKU"], $row["Nome"], $row["Tipo"], $row["Descrizione"], $row["Prezzo"], $row["Colore"], $row["categoria"], $row["Disponibilita"], $row["path_immagine"], $row["riferimento"]);
        } else {
            mysqli_stmt_close($stmt);
            return null;
        }
    }


    public function getDisp($sku)
    {
        $query = "SELECT Disponibilita FROM Prodotto WHERE SKU = ?";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $sku);
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($queryResult) != 0) {
            $row = mysqli_fetch_assoc($queryResult);
            mysqli_stmt_close($stmt);
            return array($row["Disponibilita"]);
        } else {
            mysqli_stmt_close($stmt);
            return null;
        }
    }


    public function getNamePricePath($categoria)
    {
        $query = "SELECT Nome, Prezzo, path_immagine, SKU FROM Prodotto WHERE categoria = ?";
        $stmt = mysqli_prepare($this->connection, $query);

        // Associa il valore alla variabile nello statement preparato
        mysqli_stmt_bind_param($stmt, "s", $categoria);

        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($queryResult) != 0) {
            $rows = array();
            while ($row = mysqli_fetch_assoc($queryResult)) {
                $rows[] = $row;
            }
            mysqli_stmt_close($stmt);
            return $rows;
        } else {
            mysqli_stmt_close($stmt);
            return null;
        }
    }


    public function getNamePricePath1($categoria, $riferimento)
    {
        $query = "SELECT Nome, Prezzo, path_immagine, SKU FROM Prodotto WHERE categoria = ? AND riferimento = ?";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "ss", $categoria, $riferimento);

        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($queryResult) != 0) {
            $rows = array();
            while ($row = mysqli_fetch_assoc($queryResult)) {
                $rows[] = $row;
            }
            mysqli_stmt_close($stmt);
            return $rows;
        } else {
            mysqli_stmt_close($stmt);
            return null;
        }
    }

    /************ FINE GESTIONE PRODOTTO ************/


    /************ PRODOTTI CARRELLO ************/
    public function getProductCart()
    {
        $query = "SELECT 
        Carrello.sku AS sku,
        Carrello.nome AS nome,
        Carrello.tipo AS tipo,
        Carrello.descrizione AS descrizione,
        Carrello.prezzo AS prezzo,
        Carrello.colore AS colore,
        Carrello.quantitaScelta AS quantitaScelta,
        Carrello.path_immagine AS path_immagine,
        Carrello.categoria AS categoria,
        Prodotto.disponibilita AS disponibilita
    FROM Carrello
    JOIN Prodotto ON Carrello.sku = Prodotto.sku; ";

        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));

        $data = array();

        if (mysqli_num_rows($queryResult) != 0) {
            while ($row = mysqli_fetch_assoc($queryResult)) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function insertToCart($sku, $nome, $tipo, $descrizione, $prezzo, $colore, $quantita, $path_immagine, $categoria)
    {
        $queryInsert = "INSERT INTO Carrello (sku, nome, tipo, descrizione, prezzo, colore, quantitaScelta, path_immagine, categoria) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->connection, $queryInsert);
        mysqli_stmt_bind_param($stmt, "sssdssiss", $sku, $nome, $tipo, $descrizione, $prezzo, $colore, $quantita, $path_immagine, $categoria);
        mysqli_stmt_execute($stmt);
        $rowsAffected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        return $rowsAffected > 0;
    }


    public function deleteFromCart($sku)
    {
        $queryDelete = "DELETE FROM Carrello WHERE sku = ?";
        $stmt = mysqli_prepare($this->connection, $queryDelete);
        mysqli_stmt_bind_param($stmt, "s", $sku);
        mysqli_stmt_execute($stmt);
        $rowsAffected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $rowsAffected > 0;
    }


    public function deleteAllCart()
    {
        $queryDelete = "DELETE FROM Carrello";
        mysqli_query($this->connection, $queryDelete) or die("errore in DBaccess" . mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
    }
    /************ FINE PRODOTTI CARRELLO ************/

    /************ GESTIONE ORDINI ************/
    //quando procedi all'ordine aggiorni disponibilità presente in tabella prodotto
    public function updateDisponibilitaProdotto($sku, $quantitaRimanente)
    {
        $queryUpdate = "UPDATE Prodotto SET disponibilita = $quantitaRimanente WHERE sku = '$sku'";
        mysqli_query($this->connection, $queryUpdate) or die("errore in DBaccess" . mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
    }

    /************ FINE GESTIONE ORDINI ************/

    /************ PARTE ADMIN ************/

    public function getProductPcKbd()
    {
        $query = "SELECT * FROM Prodotto WHERE categoria = 'pc' OR categoria = 'kbd';";

        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            // // Modo 1 di fare:
            // $row = mysqli_fetch_assoc($queryResult);
            // return array($row["sku"], $row["nome"], $row["tipo"], $row["descrizione"], $row["prezzo"], $row["colore"], $row["disponibilita"], $row["path_immagine"], $row["categoria"], $row["riferimento"]);
            $result = array();
            while ($row = mysqli_fetch_array($queryResult)) {
                $result[] = $row;
            }
            $queryResult->free();
            return $result;
        } else {
            return null;
        }
    }

    public function getProductAcc()
    {
        $query = "SELECT * FROM Prodotto WHERE categoria = 'acc' ;";

        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            // // Modo 1 di fare:
            // $row = mysqli_fetch_assoc($queryResult);
            // return array($row["sku"], $row["nome"], $row["tipo"], $row["descrizione"], $row["prezzo"], $row["colore"], $row["disponibilita"], $row["path_immagine"], $row["categoria"], $row["riferimento"]);
            $result = array();
            while ($row = mysqli_fetch_array($queryResult)) {
                $result[] = $row;
            }
            $queryResult->free();
            return $result;
        } else {
            return null;
        }
    }

    public function getSconti()
    {
        $query = "SELECT * FROM Sconto ;";

        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            $result = array();
            while ($row = mysqli_fetch_array($queryResult)) {
                $result[] = $row;
            }
            $queryResult->free();
            return $result;
        } else {
            return null;
        }
    }

    public function getOrdini()
    {
        $query = "SELECT * FROM Ordine ;";

        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            $result = array();
            while ($row = mysqli_fetch_array($queryResult)) {
                $result[] = $row;
            }
            $queryResult->free();
            return $result;
        } else {
            return null;
        }
    }

    public function insertNewProduct($sku, $nome, $tipo, $descrizione, $prezzo, $colore, $quantita, $path_immagine, $categoria, $riferimento)
    {
        $queryInsert = "INSERT INTO Prodotto (sku, nome, tipo, descrizione, prezzo, colore, disponibilita, path_immagine, categoria, riferimento) VALUES (\"$sku\", \"$nome\", \"$tipo\", \"$descrizione\", $prezzo, \"$colore\", $quantita, \"$path_immagine\", \"$categoria\", \"$riferimento\")";
        mysqli_query($this->connection, $queryInsert) or die("errore in DBaccess" . mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function updateProduct($sku, $nome, $tipo, $descrizione, $prezzo, $colore, $quantita, $path_immagine, $categoria, $riferimento)
    {
        $queryUpdate = "UPDATE Prodotto 
                        SET nome = \"$nome\", 
                            tipo = \"$tipo\", 
                            descrizione = \"$descrizione\", 
                            prezzo = $prezzo, 
                            colore = \"$colore\", 
                            disponibilita = $quantita, 
                            path_immagine = \"$path_immagine\", 
                            categoria = \"$categoria\", 
                            riferimento = \"$riferimento\" 
                        WHERE sku = \"$sku\"";

        mysqli_query($this->connection, $queryUpdate) or die("Errore in DBAccess: " . mysqli_error($this->connection));

        return mysqli_affected_rows($this->connection) > 0;
    }

    public function deleteProductAdmin($id)
    {
        $queryDelete = "DELETE FROM Prodotto WHERE sku = ?";
        $stmt = mysqli_prepare($this->connection, $queryDelete);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $rowsAffected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        return $rowsAffected > 0;
    }

    public function insertNewSale($codice, $data_emissione, $data_scadenza, $username, $isUsedSconto, $valore)
    {
        $queryInsert = "INSERT INTO Sconto (codice, data_emissione, data_scadenza, username, isUsed, valore) VALUES (\"$codice\", \"$data_emissione\", \"$data_scadenza\", \"$username\", $isUsedSconto, $valore)";
        mysqli_query($this->connection, $queryInsert) or die("errore in DBaccess" . mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function getScontiAdmin($codice)
    {
        $query = "SELECT codice, data_emissione, data_scadenza, username, isUsed, valore FROM Sconto WHERE codice = ?";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $codice);
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($queryResult) != 0) {
            $row = mysqli_fetch_assoc($queryResult);
            mysqli_stmt_close($stmt);
            return array($row["codice"], $row["data_emissione"], $row["data_scadenza"], $row["username"], $row["isUsed"], $row["valore"]);
        } else {
            mysqli_stmt_close($stmt);
            return null;
        }
    }

    public function updateSale($codice, $data_emissione, $data_scadenza, $username, $isUsed, $valore)
    {
        $queryUpdate = "UPDATE Sconto 
                    SET 
                        data_emissione = \"$data_emissione\", 
                        data_scadenza = \"$data_scadenza\", 
                        username = \"$username\", 
                        isUsed = \"$isUsed\", 
                        valore = \"$valore\"
                    WHERE codice = \"$codice\"";

        mysqli_query($this->connection, $queryUpdate) or die("Errore in DBAccess: " . mysqli_error($this->connection));

        return mysqli_affected_rows($this->connection) > 0;
    }


    public function deleteSale($codice)
    {
        $queryDelete = "DELETE FROM Sconto WHERE codice = ?";
        $stmt = mysqli_prepare($this->connection, $queryDelete);
        mysqli_stmt_bind_param($stmt, "s", $codice);
        mysqli_stmt_execute($stmt);
        $rowsAffected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        return $rowsAffected > 0;
    }

    /*insertNewOrder($sku, $quantitaOrdinata, $nomeUtente, $cognomeUtente, $emailUtente, $phoneUtente, $indirizzoUtente, $cittaUtente, $capUtente, $prezzo); */
    public function insertNewOrder($quantitaOrdinata, $nomeUtente, $cognomeUtente, $emailUtente, $phoneUtente, $indirizzoUtente, $cittaUtente, $capUtente, $prezzo)
    {
        $queryInsert = "INSERT INTO Ordine (nome, cognome, email, numero, indirizzo, citta, cap, quantitaOrdinata, prezzo) VALUES (\"$nomeUtente\", \"$cognomeUtente\", \"$emailUtente\", $phoneUtente, \"$indirizzoUtente\",   \"$cittaUtente\", $capUtente,$quantitaOrdinata,  $prezzo)";
        mysqli_query($this->connection, $queryInsert) or die("errore in DBaccess" . mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function deleteOrder($codice)
    {
        $queryDelete = "DELETE FROM Ordine WHERE id = ?";
        $stmt = mysqli_prepare($this->connection, $queryDelete);
        mysqli_stmt_bind_param($stmt, "s", $codice);
        mysqli_stmt_execute($stmt);
        $rowsAffected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        return $rowsAffected > 0;
    }

    public function getOrdiniAdmin($codice)
    {
        $query = "SELECT id, utente, quantitaOrdinata, indirizzo, prezzo FROM Ordine WHERE id = ?";
        $stmt = mysqli_prepare($this->connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $codice);
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($queryResult) != 0) {
            $row = mysqli_fetch_assoc($queryResult);
            mysqli_stmt_close($stmt);
            return array($row["id"], $row["utente"], $row["quantitaOrdinata"], $row["indirizzo"], $row["prezzo"]);
        } else {
            mysqli_stmt_close($stmt);
            return null;
        }
    }

    public function updateOrder($codice, $utente, $quantitaOrdinata, $indirizzo, $prezzo)
    {
        $queryUpdate = "UPDATE Ordine 
                    SET 
                        utente = '$utente', 
                        quantitaOrdinata = $quantitaOrdinata, 
                        indirizzo = '$indirizzo', 
                        prezzo = $prezzo
                    WHERE id = '$codice'";

        mysqli_query($this->connection, $queryUpdate) or die("Errore in DBAccess: " . mysqli_error($this->connection));

        return mysqli_affected_rows($this->connection) > 0;
    }

    /************ FINE PARTE ADMIN ************/
    public function closeDBConnection()
    {
        mysqli_close($this->connection);
    }
}

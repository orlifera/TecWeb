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

    /************ GESTIONE PRODOTTI ************/
    public function getProduct($categoria, $sku)
    {
        $query = "SELECT SKU, 
                         Nome, 
                         Tipo, 
                         Descrizione, 
                         Prezzo, 
                         Colore, 
                         Disponibilita,
                         path_immagine,
                         riferimento
                         FROM Prodotto 
                         WHERE categoria = '$categoria'
                         AND SKU = '$sku';";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            // Modo 1 di fare:
            $row = mysqli_fetch_assoc($queryResult);
            return array($row["SKU"], $row["Nome"], $row["Tipo"], $row["Descrizione"], $row["Prezzo"], $row["Colore"], $row["Disponibilita"], $row["path_immagine"], $row["riferimento"]);
        } else {
            return null;
        }
    }

    public function getDisp($sku)
    {
        $query = "SELECT Disponibilita
                         FROM Prodotto 
                         WHERE SKU = '$sku';";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            // Modo 1 di fare:
            $row = mysqli_fetch_assoc($queryResult);
            return array($row["Disponibilita"]);
        } else {
            return null;
        }
    }

    public function getNamePricePath($categoria)
    {
        $query = "SELECT Nome, Prezzo, path_immagine, SKU FROM Prodotto WHERE categoria = '$categoria';";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            $rows = array();
            while ($row = $queryResult->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return null;
        }
    }

    public function getNamePricePath1($categoria, $riferimento)
    {
        $query = "SELECT Nome, Prezzo, path_immagine, SKU FROM Prodotto WHERE categoria = '$categoria' AND riferimento = '$riferimento';";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            $rows = array();
            while ($row = $queryResult->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return null;
        }
    }

    public function insertNewPc($sku, $nome, $prezzo, $descrizione,  $quantita, $tipo,  $colore, $path_immagine)
    {
        $queryInsert = "INSERT INTO Prodotto (sku, nome, tipo, descrizione, prezzo, colore, disponibilita, path_immagine) VALUES (\"$sku\", \"$nome\", \"$tipo\", \"$descrizione\", $prezzo, \"$colore\", $quantita, \"$path_immagine\")";
        mysqli_query($this->connection, $queryInsert) or die("errore in DBaccess" . mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
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
        $queryInsert = "INSERT INTO Carrello (sku, nome, tipo, descrizione, prezzo, colore, quantitaScelta, path_immagine, categoria) VALUES (\"$sku\", \"$nome\", \"$tipo\", \"$descrizione\", $prezzo, \"$colore\", $quantita, \"$path_immagine\", \"$categoria\")";
        mysqli_query($this->connection, $queryInsert) or die("errore in DBaccess" . mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function deleteFromCart($sku)
    {
        $queryDelete = "DELETE FROM Carrello WHERE sku = '$sku'";
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

    public function closeDBConnection()
    {
        mysqli_close($this->connection);
    }
}

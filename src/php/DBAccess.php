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

    public function getPc($sku)
    {
        $query = "SELECT SKU, 
                         Nome, 
                         Tipo, 
                         Descrizione, 
                         Prezzo, 
                         Colore, 
                         Disponibilita,
                         path_immagine
                         FROM Prodotto 
                         WHERE SKU = '$sku';
                ";
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            // Modo 1 di fare:
            $row = mysqli_fetch_assoc($queryResult);
            return array($row["SKU"], $row["Nome"], $row["Tipo"], $row["Descrizione"], $row["Prezzo"], $row["Colore"], $row["Disponibilita"], $row["path_immagine"]);

            // Modo 2 di fare:
            // $pc = array();
            // while($row = mysqli_fetch_assoc($queryResult)){
            //     $pc[] = $row;
            // }
            // $queryResult -> free();
            // return $pc;

        } else {
            return null;
        }
    }

    public function getNamePricePath()
    {
        $query = "SELECT Nome, Prezzo, path_immagine FROM Prodotto;";

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

    public function getNamePricePathAcc()
    {
        $query = "SELECT Nome, Prezzo, path_immagine FROM Accessori;";

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

    public function insertNewPc($sku, $nome, $prezzo, $descrizione,  $disponibilita, $tipo,  $colore, $path_immagine)
    {
        $queryInsert = "INSERT INTO Prodotto (sku, nome, tipo, descrizione, prezzo, colore, disponibilita, path_immagine) VALUES (\"$sku\", \"$nome\", \"$tipo\", \"$descrizione\", $prezzo, \"$colore\", $disponibilita, \"$path_immagine\")";
        mysqli_query($this->connection, $queryInsert) or die("errore in DBaccess" . mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function closeDBConnection()
    {
        mysqli_close($this->connection);
    }
}

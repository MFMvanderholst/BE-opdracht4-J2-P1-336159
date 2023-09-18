<?php

class instructeurModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getInstructeur()
    {
        $sql = 'SELECT  *
                FROM    instructeur
                ORDER BY AantalSterren DESC';

        $this->db->query($sql);

        return $this->db->resultSet();        
    }

    public function countInstructeur()
    {
        $sql = 'SELECT count(id)
                FROM instructeur';
        
        $this->db->query($sql);

        return $this->db->single();
    }

    public function getToegewezenVoertuigen($id)
    {
        $sql ="SELECT tyvo.TypeVoertuig, voer.Type, voer.Kenteken, voer.Bouwjaar, voer.Brandstof, tyvo.Rijbewijscategorie 
               FROM voertuiginstructeur vtin
               INNER JOIN voertuig voer ON vtin.VoertuigId = voer.id
               INNER JOIN TypeVoertuig tyvo ON voer.TypeVoertuigId = tyvo.id
               WHERE InstructeurId = $id
               ORDER BY tyvo.Rijbewijscategorie DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
        

    }

    public function getInstructeurById($id) 
    {
        $sql = "SELECT Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,DatumInDienst
                      ,Aantalsterren
                FROM  instructeur
                WHERE id = $id";

        $this->db->query($sql);

        return $this->db->single();
    }

    public function getWijzigen($id)
    {
        $sql ="UPDATE typevoertuig
                SET TypeVoertuig = ''
                WHERE id
                
                UPDATE voertuig
                SET Type = '', Bouwjaar = '', Brandstof = '', Kenteken = ''
                WHERE id";

        $this->db->query($sql);
        
        $this->db->bind(':typevoertuig', $_POST['typevoertuig'], PDO::PARAM_STR);
        $this->db->bind(':type', $_POST['type'], PDO::PARAM_STR);
        $this->db->bind(':bouwjaar', $_POST['bouwjaar'], PDO::PARAM_STR);
        $this->db->bind(':brandstof', $_POST['brandstof'], PDO::PARAM_STR);
        $this->db->bind(':kenteken', $_POST['kenteken'], PDO::PARAM_STR);

        return $this->db->single();
    }
}
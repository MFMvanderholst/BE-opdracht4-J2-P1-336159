<?php

class Instructeur extends BaseController
{
    private $instructeurModel;

    public function __construct()
    {
        $this->instructeurModel = $this->model('InstructeurModel');
    }

    public function overzichtInstructeur() 
    {
        $result = $this->instructeurModel->getInstructeur();
        //  var_dump($result);

        // var_dump($rows);

        $rows = "";
        foreach ($result as $instructeur) {
            $date = date_create($instructeur->DatumInDienst);
            $formatted_date = date_format($date, 'd/m/Y');

            $rows .= "<tr>
                        <td>$instructeur->Voornaam</td>
                        <td>$instructeur->Tussenvoegsel</td>
                        <td>$instructeur->Achternaam</td>
                        <td>$instructeur->Mobiel</td>
                        <td>$formatted_date</td>
                        <td>$instructeur->AantalSterren</td>
                        <td>
                            <a href='" . URLROOT . "/instructeur/overzichtvoertuigen/$instructeur->id'><img src='" . URLROOT . "img/autoicon.png'></a>
                        </td>
                      </tr>";                    
        }

        $resultCount = $this->instructeurModel->countInstructeur();

        $count = "";
        foreach ($resultCount as $instructeur) {
            $count .= "$instructeur";
        }
        // var_dump($count);
        

        $data = [
            'title' => 'Instructeur in dienst',
            'rows' => $rows,
            'count' => $count
        ];

        // var_dump($rows);
        // var_dump($instructeur->id);

        $this->view('instructeur/overzichtinstructeur', $data);
    }

    public function overzichtVoertuigen($id)
    {
        $instructeurInfo = $this->instructeurModel->getInstructeurById($id);

        $date = date_create($instructeurInfo->DatumInDienst);
        $formatted_date = date_format($date, 'd/m/Y');

        // var_dump($instructeurInfo);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $datumInDienst = $formatted_date;
        $aantalSterren = $instructeurInfo->Aantalsterren;

        $result = $this->instructeurModel->getToegewezenVoertuigen($id);

        // var_dump($result);

        $tableRows = "";

        if (empty($result)) {
            $tableRows = "<tr>
                                <td colspan='6'>
                                    Er zijn op dit moment nog geenvoertuigen toegewezen aan deze instructeur
                                </td>
                            </tr>";
        } else {
            

            foreach ($result as $voertuig) {
                $date_formatted = date_format(date_create($voertuig->Bouwjaar), 'd-m-y');
                // var_dump($voertuig);
                $tableRows .= "<tr>
                <td>$voertuig->TypeVoertuig</td>
                <td>$voertuig->Type</td>
                <td>$voertuig->Kenteken</td>
                <td>$date_formatted</td>
                <td>$voertuig->Brandstof</td>
                <td>$voertuig->Rijbewijscategorie</td>
                <td><a href='". URLROOT . "/instructeur/wijzigenovervoertuigen/'><img src='" . URLROOT . "img/wijzigenicon.png'></a></td>
                <td><a href='". URLROOT . "/instructeur/delete/" . $voertuig->id . "/" . $id . "'><img src='" . URLROOT . "img/delete.png'></a></td>
                </tr>";
            }
        }

        $data = [
            'title' => 'Door instructeur gebruikte voertuig',
            'tableRows' => $tableRows,
            'naam'      => $naam,
            'datumInDienst' => $datumInDienst,
            'aantalSterren' => $aantalSterren,
            'instructeurId' => $id,
            'voertuigId' => $id,
            'typevoertuig' => $id
        ];

        $this->view('instructeur/overzichtVoertuigen', $data);
        // var_dump($result);
    }

    public function toevoegen($id)
    {
        $instructeurInfo = $this->instructeurModel->getInstructeurById($id);

        $date = date_create($instructeurInfo->DatumInDienst);
        $formatted_date = date_format($date, 'd/m/Y');

        // var_dump($instructeurInfo);
        $naam = $instructeurInfo->Voornaam . " " . $instructeurInfo->Tussenvoegsel . " " . $instructeurInfo->Achternaam;
        $datumInDienst = $formatted_date;
        $aantalSterren = $instructeurInfo->Aantalsterren;

        $result = $this->instructeurModel->getToegewezenVoertuigen($id);

        $voegtoeRows = "";

        if (empty($result)) {
            $voegtoeRows = "<tr>
                                <td colspan='6'>
                                    Er zijn op dit moment nog geenvoertuigen toegewezen aan deze instructeur
                                </td>
                            </tr>";
        } else {
            

            foreach ($result as $voertuig) {
                $date_formatted = date_format(date_create($voertuig->Bouwjaar), 'd-m-y');

                $voegtoeRows .= "<tr>
                <td>$voertuig->TypeVoertuig</td>
                <td>$voertuig->Type</td>
                <td>$voertuig->Kenteken</td>
                <td>$date_formatted</td>
                <td>$voertuig->Brandstof</td>
                <td>$voertuig->Rijbewijscategorie</td>
                <td><a href=''>+</a></td>
                </tr>";
            }
        }
        
        $data = [
            'title' => 'Door instructeur gebruikte voertuig',
            'voegtoe' => $voegtoeRows,
            'naam'      => $naam,
            'datumInDienst' => $datumInDienst,
            'aantalSterren' => $aantalSterren
        ];

        $this->view('instructeur/toevoegen', $data);
    }

    public function wijzigenoverzichtvoertuigen($id)
    {
        $wijzigen = $this->instructeurModel->getWijzigen($id);

        $naam = $wijzigen->Voornaam . " " . $wijzigen->Tussenvoegsel . " " . $wijzigen->Achternaam;

        $result = $this->instructeurModel->getWijzigen($id);

        $voegtoeRows = "";
        if (empty($result)) {
            $voegtoeRows = "<tr>
                                <td colspan='6'>
                                    Er zijn op dit moment nog geenvoertuigen toegewezen aan deze instructeur
                                </td>
                            </tr>";
        } else {
            

            foreach ($result as $voertuig) {

                $voegtoeRows .= "<tr>
                <td>$voertuig->TypeVoertuig</td>
                <td>$voertuig->Type</td>
                <td>$voertuig->Kenteken</td>
                <td>$voertuig->Brandstof</td>
                <td>$voertuig->Rijbewijscategorie</td>
                </tr>";
            }
        }
        $data = [
            'title' => 'Door instructeur gebruikte voertuig',
            'voegtoe' => $voegtoeRows,
            'naam'      => $naam
        ];

        $this->view('instructeur/wijzigenoverzichtvoertuigen', $data);
    }

    public function delete($id, $instructeurId)
    {
        $delete = $this->instructeurModel->delete($id);

        if ($delete) {
            echo "Het record is verwijderd";
            header('Refresh:2.5; url=http://www.php-mvc-periode1.com/instructeur/overzichtVoertuigen/' . $instructeurId);
        } else {
            echo "Het record is niet verwijderd";
        }
    }
}
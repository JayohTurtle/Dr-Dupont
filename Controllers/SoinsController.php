<?php
class SoinsController{

    private $soinManager;

    public function __construct() {

        $this->soinManager = new SoinManager();

    }

    public function showSoins(){
        $view = new View();
        $view -> render("soins", []);

    }

    public function modifSoins(){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $soinAjout = $this->sanitizeInput($_POST['soinAjout'] ?? '');
            $soinModif = $this->sanitizeInput($_POST['soinModif'] ?? '');
            $soinSupprim = $this->sanitizeInput($_POST['soinSupprim'] ?? '');
            $idSoinModif = $_POST['idSoinModif'] ?? '';
            $idSoinSupprim = $_POST['idSoinSupprim'] ?? '';

            if (!empty(trim($soinAjout))) {
                $soin = new Soin(['soin' => $soinAjout]);
                $successAjoutSoin = $this->soinManager->insertSoin($soin);
            }

            if (!empty(trim($soinModif))) {
                $soin = new Soin([
                    'soin' => $soinModif,
                    'idSoin' => $idSoinModif
                ]);
                $successModifSoin = $this->soinManager->modifSoin($soin);
            }

            if (!empty(trim($soinSupprim))) {
                $successSupprimSoin = $this->soinManager->supprimSoin($idSoinSupprim);
            }

            $url = "index.php?action=admin&successAjoutSoin=" . urlencode($successAjoutSoin) . "&successModifSoin=" . urlencode($successModifSoin) . "&successSupprimSoin=" . urlencode($successSupprimSoin);

            header("Location: $url");
            exit();
        }
    }

    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }


}
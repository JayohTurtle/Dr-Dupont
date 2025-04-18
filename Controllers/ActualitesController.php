<?php

class ActualitesController{

    private $actualiteManager;

    public function __construct() {

        $this->actualiteManager = new ActualiteManager();
    }

    public function showActualites(){

        $actualites = $this-> actualiteManager -> getActualites();
        $view = new View();
        $view -> render("actualites", [
                'actualites' => $actualites
        ]);

    }

    public function modifActualites(){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $titreAjout = $this->sanitizeInput($_POST['titreAjout']) ?? '';
            $contenuAjout = $this->sanitizeInput($_POST['contenuAjout']) ?? '';
            $titreModif = $this->sanitizeInput($_POST['titreModif']) ?? '';
            $contenuModif = $this->sanitizeInput($_POST['contenuModif']) ?? '';
            $titreSupprim = $this->sanitizeInput($_POST['titreSupprim']) ?? '';
            $idActualiteModif = $_POST['idActualiteModif'] ?? '';
            $idActualiteSupprim = $_POST['idActualiteSupprim'] ?? '';

            if (!empty(trim($titreAjout))) {
                $actualite = new Actualite([
                    'titre' => $titreAjout,
                    'contenu' => $contenuAjout
                ]);

                $successAjoutActualite = $this->actualiteManager->insertActualite($actualite);
            }

            if (!empty(trim($titreModif))) {
                $actualite = new Actualite([
                    'titre' => $titreModif,
                    'contenu' => $contenuModif,
                    'idActualite' => $idActualiteModif
                ]);

                $successModifActualite = $this->actualiteManager->modifActualite($actualite);
            }

            if (!empty(trim($titreSupprim))) {
                $successSupprimActualite = $this->actualiteManager->supprimActualite($idActualiteSupprim);
            }

            $url = "index.php?action=admin&successAjoutActualite=" . urlencode($successAjoutActualite) . "&successModifActualite=" . urlencode($successModifActualite) . "&successSupprimActualite=" . urlencode($successSupprimActualite);

            header("Location: $url");
            exit();

            $successActualite = $this->actualiteManager->insertActualite($actualite);

            $view = new View();
            $view->render('admin', [
                'successActualite' => $successActualite,
            ]);
        }
    }

    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return trim(strip_tags($input)); // Supprime les balises HTML/PHP et les espaces
    }
    
}
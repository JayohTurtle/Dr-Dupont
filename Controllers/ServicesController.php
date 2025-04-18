<?php
class ServicesController{

    private $serviceManager;

    public function __construct() {

        $this->serviceManager = new ServiceManager();

    }

    public function showServices(){
        $view = new View();
        $view -> render("services", ['services' => $this->serviceManager->getServices()]);

    }

    public function modifServices(){

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $serviceAjout = $this->sanitizeInput($_POST['ServiceAjout'] ?? '');
            $descriptionAjout = $this->sanitizeInput($_POST['descriptionAjout'] ?? '');
            $serviceModif = $this->sanitizeInput($_POST['serviceModif'] ?? '');
            $descriptionModif = $this->sanitizeInput($_POST['descriptionModif'] ?? '');
            $serviceSupprim = $this->sanitizeInput($_POST['serviceSupprim'] ?? '');
            $idServiceModif = $_POST['idServiceModif'] ?? '';
            $idServiceSupprim = $_POST['idServiceSupprim'] ?? '';

            if (!empty(trim($serviceAjout))) {
                $service = new service([
                    'service' => $serviceAjout, 
                    'description' => $descriptionAjout
                ]);
                $successAjoutService = $this->serviceManager->insertService($service);
            }

            if (!empty(trim($serviceModif))) {
                $service = new service([
                    'service' => $serviceModif,
                    'description' => $descriptionModif,
                    'idService' => $idServiceModif
                ]);
                $successModifService = $this->serviceManager->modifService($service);
            }

            if (!empty(trim($serviceSupprim))) {
                $successSupprimService = $this->serviceManager->supprimService($idServiceSupprim);
            }

            $url = "index.php?action=admin&successAjoutService=" . urlencode($successAjoutService) . "&successModifService=" . urlencode($successModifService) . "&successSupprimService=" . urlencode($successSupprimService);

            header("Location: $url");
            exit();
        }
    }

    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return trim(strip_tags($input)); // Supprime les balises HTML/PHP et les espaces
    }
}
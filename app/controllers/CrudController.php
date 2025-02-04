<?php
namespace app\controllers;

use app\models\CrudModel;
use Flight;

class CrudController
{
    public function __construct()
    {

    }

    public function ListeAnimaux()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $crudModel = new CrudModel();
        $animaux = $crudModel->listerAnimaux();

        $data = [
            'page' => 'listeAnimaux',
            'animaux' => $animaux,
            'user' => $_SESSION['user']
        ];

        Flight::render('template', $data);
    }

    public function AjoutAnimal()
    {

        $crudModel = new CrudModel();


        // Vérifier si la requête est de type POST
        if (Flight::request()->method === 'POST') {
            $data = Flight::request()->data;

            // Vérification et récupération des fichiers uploadés
            $photosArray = [];
            if (!empty($_FILES['photos']['name'][0])) {
                // Appeler la fonction uploadPhotos pour gérer l'upload
                $uploadResult = $this->uploadPhotos($_FILES['photos']);
                if (isset($uploadResult['error'])) {
                    Flight::json(['status' => 'error', 'message' => $uploadResult['error']], 400);
                    return;
                }
                // Si l'upload a réussi, on récupère les chemins des fichiers
                $photosArray = $uploadResult['success'];
            }

            // Convertir le tableau en JSON valide
            $photoTab = json_encode($photosArray);

            // Récupérer les autres données du formulaire
            $espece = $data->espece;
            $poids_minimal_vente = $data->poids_minimal_vente;
            $prix_vente_kg = $data->prix_vente_kg;
            $poids_maximal = $data->poids_maximal;
            $nb_jour_sans_manger = $data->nb_jour_sans_manger;
            $pourcentage_perte_de_poids = $data->pourcentage_perte_de_poids;
            $poids_actuel = $data->poids_actuel;
            $date_achat = $data->date_achat;
            $quota = $data->quota;

            // Vérifier que toutes les valeurs requises sont présentes
            if (!$espece || !$poids_minimal_vente || !$prix_vente_kg || !$poids_maximal || !$nb_jour_sans_manger || !$pourcentage_perte_de_poids || !$poids_actuel || !$date_achat) {
                Flight::json(['status' => 'error', 'message' => 'Tous les champs sont requis'], 400);
                return;
            }

            // Appel au modèle pour ajouter un animal
            $result = $crudModel->AjouterAnimal($espece, $poids_minimal_vente, $prix_vente_kg, $poids_maximal, $nb_jour_sans_manger, $pourcentage_perte_de_poids, $poids_actuel, $date_achat, $quota, $photoTab);

            if ($result) {
                Flight::json(['status' => 'success', 'message' => 'Animal ajouté avec succès']);
                Flight::redirect('/liste');
            } else {
                Flight::json(['status' => 'error', 'message' => 'Erreur lors de l\'ajout'], 500);
            }
        } else {
            Flight::json(['status' => 'error', 'message' => 'Méthode non autorisée'], 405);
        }
    }

    public function uploadPhotos($files)
    {
        $base_url = Flight::get('flight.base_url') . '/public/assets/images/';
        $uploadedPaths = [];
        $uploadDir = 'public/assets/images/';

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'avif'];

        foreach ($files['tmp_name'] as $key => $tmpName) {
            $fileName = basename($files['name'][$key]);
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;

            if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                if (move_uploaded_file($tmpName, $filePath)) {
                    $uploadedPaths[] = $fileName;
                } else {
                    return ['error' => "Erreur lors de l'upload du fichier: " . $fileName];
                }
            } else {
                return ['error' => "Extension de fichier non autorisée: " . $fileExtension];
            }
        }

        if (count($uploadedPaths) > 0) {
            return ['success' => $uploadedPaths];
            Flight::redirect('/liste');
        }

        return ['error' => "Aucun fichier uploadé"];
    }


    public function form_AjoutAnimal()
    {
        $data = [
            'page' => 'ajoutAnimal'
        ];

        Flight::render('template', $data);
    }

    public function ModificationAnimal()
    {
        $id_animal = Flight::request()->data->id_animal;
        $espece = Flight::request()->data->espece;
        $poids_minimal_vente = Flight::request()->data->poids_minimal_vente;
        $prix_vente_kg = Flight::request()->data->prix_vente_kg;
        $poids_maximal = Flight::request()->data->poids_maximal;
        $nb_jour_sans_manger = Flight::request()->data->nb_jour_sans_manger;
        $pourcentage_perte_de_poids = Flight::request()->data->pourcentage_perte_de_poids;
        $poids_actuel = Flight::request()->data->poids_actuel;
        $date_achat = Flight::request()->data->date_achat;
        $quota = Flight::request()->data->quota;

        $db = Flight::db(); // Récupère la connexion à la base de données

        // Mise à jour des données de l'animal
        $sql = "UPDATE elevage_Animaux 
                SET espece = ?, poids_minimal_vente = ?, prix_vente_kg = ?, poids_maximal = ?, 
                    nb_jour_sans_manger = ?, pourcentage_perte_de_poids = ?, poids_actuel = ?, date_achat = ? , quota = ?
                WHERE id = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            $espece,
            $poids_minimal_vente,
            $prix_vente_kg,
            $poids_maximal,
            $nb_jour_sans_manger,
            $pourcentage_perte_de_poids,
            $poids_actuel,
            $date_achat,
            $quota,
            $id_animal
        ]);

        // Gestion des nouvelles photos
        if (!empty($_FILES['photos']['name'][0])) {
            $upload_dir = 'public/uploads/';
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                $filename = uniqid() . '_' . basename($_FILES['photos']['name'][$key]);
                $target_path = $upload_dir . $filename;

                if (move_uploaded_file($tmp_name, $target_path)) {
                    // Insérer la photo associée à l'animal dans la table des photos
                    $sql_photo = "INSERT INTO photos (id_animal, chemin) VALUES (?, ?)";
                    $stmt_photo = $db->prepare($sql_photo);
                    $stmt_photo->execute([$id_animal, $target_path]);
                }
            }
        }

        Flight::redirect('/liste'); // Redirige après modification
    }

    public function form_UpdateAnimal()
    {
        $crudModel = new CrudModel();

        // Récupérer l'ID de l'animal depuis l'URL (GET)
        $idAnimal = Flight::request()->query['idAnimal'] ?? null;

        if (!$idAnimal) {
            Flight::json(['status' => 'error', 'message' => 'ID de l\'animal manquant'], 400);
            return;
        }

        // Récupérer les informations de l'animal à modifier
        $animal = $crudModel->GetAnimalById($idAnimal);

        if (!$animal) {
            Flight::json(['status' => 'error', 'message' => 'Animal introuvable'], 404);
            return;
        }

        $data = [
            'page' => 'modificationAnimal',
            'animal' => $animal
        ];

        Flight::render('template', $data);
    }
    public function acheterAliment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            Flight::json(['success' => false, 'message' => 'Utilisateur non connecté.']);
            return;
        }

        $db = Flight::db();
        $userId = $_SESSION['user']['id'];
        $alimentId = Flight::request()->data->aliment_id;
        $quantite = Flight::request()->data->quantite ?? 1;

        // Utiliser le modèle pour récupérer le prix de l'alimentation
        $crudModel = new CrudModel();
        $alimentation = $crudModel->getAlimentationById($alimentId);

        if (!$alimentation) {
            Flight::json(['success' => false, 'message' => 'Alimentation non trouvée.']);
            return;
        }

        // Vérifiez si le prix est défini
        if (!isset($alimentation['prix'])) {
            Flight::json(['success' => false, 'message' => 'Prix non défini pour cette alimentation.']);
            return;
        }

        $prixAliment = $alimentation['prix'] * $quantite;

        // Vérifier si le capital est suffisant
        if ($_SESSION['user']['capital'] < $prixAliment) {
            Flight::json(['success' => false, 'message' => 'Capital insuffisant.']);
            return;
        }

        // Insérer l'achat dans la table 'elevage_StockAlimentation'
        $result = $crudModel->ajouterStockAlimentation($userId, $alimentId, $quantite);
        if ($result) {
            // Mettre à jour le capital de l'utilisateur
            $newCapital = $_SESSION['user']['capital'] - $prixAliment;
            $crudModel->mettreAJourCapital($userId, $newCapital);

            // Mettre à jour la session
            $_SESSION['user']['capital'] = $newCapital;

            Flight::json(['success' => true, 'message' => 'Achat réussi!']);
        } else {
            Flight::json(['success' => false, 'message' => 'Erreur lors de l\'achat.']);
        }
    }
    public function ListeAlimentations()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $crudModel = new CrudModel();
        $alimentations = $crudModel->listerAlimentations();

        $data = [
            'page' => 'listeAlimentations',
            'alimentations' => $alimentations,
            'user' => $_SESSION['user']
        ];

        Flight::render('template', $data);
    }

    public function suppressionAnimal()
    {
        $crudModel = new CrudModel();
        $idAnimal = $_GET['idAnimal'];
        if (!isset($idAnimal)) {
            echo "Id ne peut pas etre null";
        }
        $deleteAnimal = $crudModel->SupprimerAnimal($idAnimal);
        Flight::redirect('/liste');
    }

    public function aliment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $crudModel = new CrudModel();
        $alimentations = $crudModel->listerAlimentations();

        $data = [
            'page' => 'aliments',
            'alimentations' => $alimentations,
            'user' => $_SESSION['user']
        ];

        Flight::render('template', $data);
    }

    public function form_AjoutAlimentation()
    {
        $crudModel = new CrudModel();
        $animaux = $crudModel->listerAnimaux();
        $data = [
            'page' => 'ajoutAlimentation',
            'animaux' => $animaux
        ];

        Flight::render('template', $data);
    }

    public function AjoutAlimentation()
    {
        $crudModel = new CrudModel();

        // Vérifier si la requête est de type POST
        if (Flight::request()->method === 'POST') {
            $data = Flight::request()->data;

            // Vérification et récupération des fichiers uploadés
            $photosArray = [];
            if (!empty($_FILES['photos']['name'][0])) {
                // Appeler la fonction uploadPhotos pour gérer l'upload
                $uploadResult = $this->uploadPhotos($_FILES['photos']);
                if (isset($uploadResult['error'])) {
                    Flight::json(['status' => 'error', 'message' => $uploadResult['error']], 400);
                    return;
                }
                // Si l'upload a réussi, on récupère les chemins des fichiers
                $photosArray = $uploadResult['success'];
            }

            // Convertir le tableau en JSON valide
            $photoTab = json_encode($photosArray);

            // Récupérer les autres données du formulaire
            $nom = $data->nom;
            $pourcentage_gain = $data->pourcentage_gain;
            $espece = $data->espece;
            $prix = $data->prix;

            // Vérifier que toutes les valeurs requises sont présentes
            if (!$nom || !$pourcentage_gain || !$espece) {
                Flight::json(['status' => 'error', 'message' => 'Tous les champs sont requis'], 400);
                return;
            }

            // Appel au modèle pour ajouter une alimentation
            $result = $crudModel->AjouterAlimentation($nom, $pourcentage_gain, $espece, $prix, $photoTab);

            if ($result) {
                Flight::json(['status' => 'success', 'message' => 'Alimentation ajoutée avec succès']);
                Flight::redirect('/alimentation');
            } else {
                Flight::json(['status' => 'error', 'message' => 'Erreur lors de l\'ajout'], 500);
            }
        } else {
            Flight::json(['status' => 'error', 'message' => 'Méthode non autorisée'], 405);
        }
    }

    public function suppressionAlimentation()
    {
        $crudModel = new CrudModel();
        $idAlimentation = $_GET['idAlimentation'];

        // Vérification si l'idAlimentation est présent dans la requête GET
        if (!isset($idAlimentation)) {
            echo "L'ID de l'alimentation ne peut pas être nul.";
            return;
        }

        // Appel à la méthode pour supprimer l'alimentation
        $deleteAlimentation = $crudModel->SupprimerAlimentation($idAlimentation);

        // Rediriger vers la liste des alimentations après la suppression
        Flight::redirect('/alimentation');
    }

    public function form_UpdateAlimentation()
    {
        $crudModel = new CrudModel();

        // Récupérer l'ID de l'alimentation depuis l'URL (GET)
        $idAlimentation = Flight::request()->query['idAlimentation'] ?? null;

        if ($idAlimentation) {
            // Si l'ID de l'alimentation est présent, récupérer les détails de cette alimentation
            $alimentation = $crudModel->getAlimentationById($idAlimentation);

            if ($alimentation) {
                // Si l'alimentation existe, la passer au template
                $data = [
                    'page' => 'modificationAlimentation',
                    'alimentation' => $alimentation
                ];
            } else {
                // Si l'alimentation n'existe pas, afficher une erreur ou rediriger
                // On redirige ici, mais tu pourrais aussi afficher une page d'erreur
                Flight::redirect('/alimentation');  // Redirection vers une liste d'alimentations
                return;
            }
        } else {
            // Si l'ID de l'alimentation n'est pas passé dans l'URL
            // Tu pourrais rediriger ou afficher une page d'erreur personnalisée
            Flight::redirect('/modificationAlimentation');  // Redirection vers la liste
            return;
        }

        // Rendu du template avec les données récupérées
        Flight::render('template', $data);
    }

    public function acheterAnimal()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            Flight::json(['success' => false, 'message' => 'Utilisateur non connecté.']);
            return;
        }

        $db = Flight::db();
        $userId = $_SESSION['user']['id'];
        $animalId = Flight::request()->data->animal_id;
        $quantite = 1; // Vous pouvez ajuster cela selon votre logique

        // Utiliser le modèle pour récupérer le prix de l'animal
        $crudModel = new CrudModel();
        $animal = $crudModel->getAnimalById($animalId);

        if (!$animal) {
            Flight::json(['success' => false, 'message' => 'Animal non trouvé.']);
            return;
        }

        $prixAnimal = $animal['prix_vente_kg'] * $quantite; // Calculer le prix total

        // Vérifier si le capital est suffisant
        if ($_SESSION['user']['capital'] < $prixAnimal) {
            Flight::json(['success' => false, 'message' => 'Capital insuffisant.']);
            return;
        }

        // Insérer l'achat dans la table 'elevage_StockAnimal'
        $result = $crudModel->ajouterStockAnimal($userId, $animalId, $quantite);
        if ($result) {
            // Mettre à jour le capital de l'utilisateur
            $newCapital = $_SESSION['user']['capital'] - $prixAnimal;
            $crudModel->mettreAJourCapital($userId, $newCapital);

            // Mettre à jour la session
            $_SESSION['user']['capital'] = $newCapital;

            Flight::json(['success' => true, 'message' => 'Achat réussi ! Souhaitez-vous activer la vente automatique ?']);
        } else {
            Flight::json(['success' => false, 'message' => 'Erreur lors de l\'achat.']);
        }
    }
    public function ModificationAlimentation()
    {
        // Récupération des données envoyées dans la requête
        $id_alimentation = Flight::request()->data->id_alimentation;
        $nom = Flight::request()->data->nom;
        $pourcentage_gain = Flight::request()->data->pourcentage_gain;
        $espece = Flight::request()->data->espece;
        $photos = Flight::request()->data->photos;
        $prix = Flight::request()->data->prix;

        $db = Flight::db(); // Récupère la connexion à la base de données

        // Mise à jour des données de l'alimentation
        $sql = "UPDATE elevage_Alimentation 
            SET nom = ?, pourcentage_gain = ?, espece = ? , prix = ?
            WHERE id = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute([$nom, $pourcentage_gain, $espece, $prix, $id_alimentation]);

        // Gestion des nouvelles photos
        if (!empty($_FILES['photos']['name'][0])) {
            $upload_dir = 'public/uploads/';
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                $filename = uniqid() . '_' . basename($_FILES['photos']['name'][$key]);
                $target_path = $upload_dir . $filename;

                if (move_uploaded_file($tmp_name, $target_path)) {
                    // Insérer la photo associée à l'alimentation dans la table des photos
                    $sql_photo = "INSERT INTO photos (id_alimentation, chemin) VALUES (?, ?)";
                    $stmt_photo = $db->prepare($sql_photo);
                    $stmt_photo->execute([$id_alimentation, $target_path]);
                }
            }
        }

        // Redirige après modification
        Flight::redirect('/alimentation');
    }


}
?>
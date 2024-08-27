<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use App\Service\UploadService;

class AdminController extends AbstractController
{
    public function __construct()
    {
        /**
         * Si l'utilisateur n'est pas connecté, on le redirige
         * vers le formulaire de connexion
         */
        if (!$this->isUserLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }

    /**
     * Accueil de l'administration
     */
    public function index(): void
    {
        // Sélection de tous les articles
        $projetRepository = new ProjetRepository();

        $this->view('admin/index.php', [
            'projects' => $projetRepository->findAll()
        ]);
    }

    /**  Nouveau projet
    *public function add(): void {

       * $this->view('admin/project/add.php');
   * } */

    /**
     * Nouveau projet
     */
    public function add(): void
    {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage des données
            $title = htmlspecialchars(strip_tags($_POST['title']));
            $description = htmlspecialchars(strip_tags($_POST['description']));

            // Vérifie si tous est bien rempli
            if (
                !empty($title) &&
                !empty($description) &&
                $_FILES['preview']['error'] === UPLOAD_ERR_OK
            ) {
                // Upload de l'image de preview
                $uploadService = new UploadService();
                $preview = $uploadService->upload($_FILES['preview']);

                if ($preview) {
                    // Date du jour
                    $date = new \DateTime();

                    // Créer un objet avec l'entité "Projet"
                    $projet = new Projet();
                    $projet->setTitle($title);
                    $projet->setDescription($description);
                    $projet->setPreview($preview);
                    $projet->setCreatedAt($date->format('Y-m-d H:i:s'));
                    $projet->setUpdatedAt($date->format('Y-m-d H:i:s'));

                    $projetRepository = new ProjetRepository();
                    $projetRepository->add($projet);

                    $success = 'Votre nouveau projet est enregistré';
                } else {
                    $error = 'Le fichier est invalide';
                }
            } else {
                $error = 'Tous les champs sont obligatoires';
            }
        }

        $this->view('admin/project/add.php', [
            'error' => $error,
            'success' => $success
        ]);
    }

    /**
     * Edition d'un article
     */
    public function edit(): void
    {
        // Si l'ID n'existe pas ou est vide, redirection vers l'accueil de l'administration
        if (empty($_GET['id'])) {
            header('Location: /admin');
            exit;
        }

        $projetRepository = new ProjetRepository();
        $projet = $projetRepository->find($_GET['id']);

        // Si aucun projet avec cet ID
        if (!$projet) {
            header('Location: /admin');
            exit;
        }

        // Si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage des données
            $title = htmlspecialchars(strip_tags($_POST['title']));
            $description = htmlspecialchars(strip_tags($_POST['description']));

            // Vérifie si tous est bien rempli
            if (
                !empty($title) &&
                !empty($description)
            ) {
                // Sauvegarde le nom actuel de l'image de preview
                $preview = $projet->getPreview();

                // Si une image est fournie, on l'upload
                if ($_FILES['preview']['error'] === UPLOAD_ERR_OK) {
                    // Upload de l'image de preview
                    $uploadService = new UploadService();
                    $preview = $uploadService->upload($_FILES['preview'], $preview);
                }

                if ($preview) {
                    // Date du jour
                    $date = new \DateTime();

                    // Modifie l'entité Projet
                    $projet->setTitle($title);
                    $projet->setDescription($description);
                    $projet->setPreview($preview);
                    $projet->setUpdatedAt($date->format('d.m.Y'));

                    $projetRepository = new ProjetRepository();
                    $projetRepository->edit($projet);

                    $success = 'Votre nouveau projet est enregistré';
                } else {
                    $error = 'Le fichier est invalide';
                }
            } else {
                $error = 'Tous les champs sont obligatoires';
            }
        }

        $this->view('admin/project/edit.php', [
            'projet' => $projet,
            'error' => $error ?? null, // $error !== null ? $error : null
            'success' => $success ?? null // Coalescence des nuls (Nullish coalescing operator)
        ]);
    }

    /**
     * Suppression
     */
    public function delete(): void
    {
        // Si l'ID n'existe pas ou est vide, redirection vers l'accueil de l'administration
        if (empty($_GET['id'])) {
            header('Location: /admin');
            exit;
        }

        $projetRepository = new ProjetRepository();
        $projet = $projetRepository->find($_GET['id']);

        // Si aucun projet avec cet ID
        if (!$projet) {
            header('Location: /admin');
            exit;
        }

        // Suppression de l'ID en base de données
        $projetRepository = new ProjetRepository();
        $projetRepository->delete($projet);

        // Supprime l'image du projet
        unlink($projet->getFolderPreview());

        header('Location: /admin?success=Votre projet a bien été supprimé');
    }
}
<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use PHPMailer\PHPMailer\PHPMailer;

class HomeController extends AbstractController {

    // Page d'accueil
    public function index(): void {

        $projetRepository = new ProjetRepository();
        
        //require_once '../templates/home/index.php';
        $this->view('home/index.php', [
            'projects' => $projetRepository->findAll()
        ]);
    }

    // Page detail d'un projet
    public function details(): void {

        // Selectionne le projet
        $projetRepository = new ProjetRepository();
        $project = $projetRepository->find($_GET['id']);

        // Erreur 404
        if (!$project) {
            header('Location: /portfolio/404');
            exit;
        }

        $this->view('home/details.php', [
            'project' => $project
        ]);

    }

    // Page de test
    public function test(): void {

        // Si le formulaire est envoyé..
        if (!empty($_POST)) {
            // Verifie si les champs ne sont pas vides
            if (!empty($_POST['name']) && !empty($_POST['avis'])) {
                // Tout fonctionne
            } else {
                $error = 'Tous les champs sont obligatoires';
            }
        }

        // L'appel du template se situe toujours en derniere ligne de la methode
        require_once '../templates/home/test.php';
    }

    // Page de contact
    public function contact(): void {

        $error = null;
        $success = null;

        // Si une methode POST est recue
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage des donnees
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $email = htmlspecialchars(strip_tags($_POST['email']));
            $message = htmlspecialchars(strip_tags($_POST['message']));

            // Verifie si tous les champs sont remplis
            if (!empty($name) && !empty($email) && !empty($message)) {

                // Verifie si le mail est valide
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    // Envoi de l'email avec PHPMailer
                    // Connecter au SMTP de Mailtrap
                    $phpmailer = new PHPMailer();
                    $phpmailer->isSMTP();
                    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                    $phpmailer->SMTPAuth = true;
                    $phpmailer->Port = 2525;
                    $phpmailer->Username = '43663e62248f9b';
                    $phpmailer->Password = 'df737039c11a4a';

                    // Envoi du mail
                    $phpmailer->setFrom($email, $name);  // Expediteur
                    $phpmailer->addAddress('jerome@demo.com', 'Jerome');  // Destinataire
                    $phpmailer->Subject = 'Message du formulaire de contact';
                    $phpmailer->Body = $message;

                    // Envoyer le mail
                    if ($phpmailer->send()) {
                        $success = 'Votre message a bien été envoyé !';
                    } else {
                        // 
                        $error = $phpmailer->ErrorInfo;
                    } 
                } else {
                    $error = 'Votre adresse email est invalide';
                }
            }else {
                $error = 'Veuillez remplir tous les champs';
            }

        }
        // Affichage du template
        $this->view('home/contact.php', [
            'error' => $error,
            'success' => $success
        ]);
        //require_once '../templates/home/contact.php';
        
    }


}
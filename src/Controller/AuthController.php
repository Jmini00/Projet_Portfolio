<?php

namespace App\Controller;

use App\Repository\UserRepository;

/**
 * Gestion de l'authentification
 */
class AuthController extends AbstractController
{

    // Deconnexion de l'utilisateur
    public function logout(): void {
        unset($_SESSION['user']);
        header('Location: /portfolio');
    }
    /**
     * Connexion à l'administration
     */
    public function login()
    {
        $error = null;

        // Connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage
            $username = htmlspecialchars(strip_tags($_POST['username']));
            $password = htmlspecialchars(strip_tags($_POST['password']));

            // Vérifier si le formulaire est rempli, sinon erreur
            if (!empty($username) && !empty($password)) {
                // Vérifie si un utilisateur existe via l'adresse email en BDD, sinon erreur
                $userRepository = new UserRepository();
                $user = $userRepository->findByUsername($username);

                // Vérifie si l'utilisateur existe et si mot de passe est correct, sinon erreur
                if ($user && password_verify($password, $user->getPassword())) {
                    // Création de la session de connexion
                    $_SESSION['user'] = $user;

                    // Redirection vers l'administration
                    header('Location: /admin');
                    exit;
                } else {
                    $error = 'Identifiants invalides';
                }
            } else {
                $error = 'Identifiants invalides';
            }
        }

        $this->view('auth/login.php', [
            'error' => $error
        ]);
    }
}
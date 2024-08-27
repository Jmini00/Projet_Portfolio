<?php

namespace App\Controller;

use Faker;
use App\Entity\Projet;
use App\Entity\User;
use App\Repository\ProjetRepository;
use App\Repository\UserRepository;


// Genere des fausses donnees pour le developpement
class FixtureController extends AbstractController {

    public function index(): void {

        $faker = Faker\Factory::create();
        $projetRepository = new ProjetRepository();

        for ($i = 0; $i < 10; $i++) {
            // Creer un objet avec l'entité "Projet"
            $projet = new Projet();
            $projet->setTitle($faker->sentence);
            $projet->setDescription($faker->realText);
            $projet->setPreview('test.png');
            $projet->setCreatedAt($faker->dateTimeBetween('-2 years')->format('Y-m-d'));
            $projet->setUpdatedAt($faker->dateTimeBetween('-1 year')->format('Y-m-d'));

            // Inserer en base de donnees
            $projetRepository->add($projet);

        }

        // Insertion de faux utilisateurs
        $userRepository = new UserRepository();

        for ($i = 0; $i < 2; $i++) {
            // Creer un objet avec l'entite "User"
            $user = new User();
            $user->setUserName($faker->userName);
            $user->setPassword(password_hash('secret', PASSWORD_DEFAULT));

            // Inserer en base de donnees
            $userRepository->add($user);

        }

        // Afficher une vue
        $this->view('fixtures/index.php');

    }
}
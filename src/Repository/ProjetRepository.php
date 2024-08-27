<?php

namespace App\Repository;

use App\Entity\Projet;
use Core\Database;

// ProjetRepository.php

class ProjetRepository extends Database {

    private $instance;

    public function __construct() {
        $this->instance = self::getInstance();
    }

    // Insertion en base de donnees
    public function add(Projet $projet): Projet {

        $query = $this->instance->prepare("
            INSERT INTO projets (title, description, preview, created_at, updated_at)
            VALUES (:title, :description, :preview, :created_at, :updated_at)
            ");

            $query->bindValue(':title', $projet->getTitle());
            $query->bindValue(':description', $projet->getDescription());
            $query->bindValue(':preview', $projet->getPreview());
            $query->bindValue(':created_at', $projet->getCreatedAt());
            $query->bindValue(':updated_at', $projet->getUpdatedAt());
            $query->execute();

            // Recupere l'ID nouvellement créé
            $id = $this->instance->lastInsertId();

            // Ajoute l'ID à mon objet
            $projet->setId($id);

            // Retourne notre objet muni d'un ID
            return $projet;
    }

        // Selectionne tous les projets
        public function findAll(): array {
            $objectsProjects = [];
            $query = $this->instance->query("SELECT * FROM projets ORDER BY created_at DESC");
            $projects = $query->fetchAll();

            foreach ($projects as $project) {
                $item = new Projet();
                $item->setId($project->id);
                $item->setTitle($project->title);
                $item->setDescription($project->description);
                $item->setPreview($project->preview);
                $item->setCreatedAt($project->created_at);
                $item->setUpdatedAt($project->updated_at);

                $objectsProjects[] = $item;
            }

            return $objectsProjects;
        }

        // Selectionne un projet
        public function find(int $id): Projet|bool {

            $objectProject = false;

            $query = $this->instance->prepare("SELECT * FROM projets WHERE id = :id");
            $query->bindValue(':id', $id);
            $query->execute();

            $projet = $query->fetch();

            if ($projet) {
                $objectProject = new Projet();
                $objectProject->setId($projet->id);
                $objectProject->setTitle($projet->title);
                $objectProject->setDescription($projet->description);
                $objectProject->setPreview($projet->preview);
                $objectProject->setCreatedAt($projet->created_at);
                $objectProject->setUpdatedAt($projet->updated_at);

            }

            return $objectProject;
        }
}
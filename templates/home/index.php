<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <div class="container mx-auto p-5">
            <h1 class="pb-5">Mes beaux projets 🤩</h1>

<a href="/portfolio/contact">contact</a>

            <?php if($isLoggedIn): ?>
                <div class="alert alert-success">
                    Bonjour <?php echo $_SESSION['user']->getUsername(); ?> !
                </div>

            <?php endif; ?>

            <?php foreach($projects as $project): ?>
                <article class="pb-5">
                    <h1><?php echo $project->getTitle(); ?></h1>
                    <small class="d-block text-secondary pb-2">
                        Posté le <?php echo $project->getCreatedAt()->format('d.m.Y'); ?>
                    </small>
                    <img
                        src="imgs/<?php echo $project->getPreview(); ?>"
                        alt="<?php echo $project->getTitle(); ?>"
                        class="img-fluid rounded"
                    >
                    <p>
                    <?php
                        echo mb_strimwidth($project->getDescription(), 0, 75, '...');
                    ?>
                    </p>

                    <a href="/portfolio/projet/details?id=<?php echo $project->getId(); ?>" class="btn btn-sm btn-primary">
                        En savoir plus...
                    </a>
                </article>
            <?php endforeach; ?>

        </div>
    </body>
</html>
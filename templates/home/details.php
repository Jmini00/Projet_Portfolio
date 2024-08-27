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
            <h1 class="pb-5">Mon projet</h1>

            <article class="pb-5">
                <h1><?php echo $project->getTitle(); ?></h1>
                <small class="d-block text-secondary pb-2">
                    Posté le <?php echo $project->getCreatedAt()->format('d.m.Y'); ?>
                </small>
                <img
                    src="../<?php echo $project->getFolderPreview(); ?>"
                    alt="<?php echo $project->getTitle(); ?>"
                    class="img-fluid rounded"
                >
                <p>
                    <?php echo $project->getDescription(); ?>
                </p>
            </article>
        </div>
    </body>
</html>


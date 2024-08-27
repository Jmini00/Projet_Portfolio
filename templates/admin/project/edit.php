<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Portfolio</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <div class="container mx-auto p-5">
            <h1 class="pb-5">Administration</h1>

            <!-- Message d'erreur -->
            <?php if(isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Message de succès -->
            <?php if(isset($success)): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du projet</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $projet->getTitle(); ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" rows="3" name="description"><?php echo $projet->getDescription(); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="preview" class="form-label">Aperçu du projet</label>
                    <input class="form-control" type="file" id="preview" name="preview">
                    <img src="../../<?php echo $projet->getFolderPreview(); ?>" alt="Image" class="img-fluid">
                </div>
                <div class="mt-4">
                    <button class="btn btn-success">Modifier le projet</button>
                    <a href="/admin" class="btn btn-light ml-5">Annuler</a>
                </div>
            </form>
        </div>
    </body>
</html>


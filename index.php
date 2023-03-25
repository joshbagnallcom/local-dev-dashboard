<?php

$page_title = ucwords(preg_replace("/[^A-Za-z0-9]/", ' ', basename(dirname(__FILE__))));

require 'inc/scan-directories.php';
$scan = new ScanDirectories(__DIR__, 'dev');
$projects =  $scan->get_projects();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        table p,
        table a {
            margin: 0 3px;
        }

        .category-tool {
            background-color: orange;
            color: black;
        }
    </style>
</head>

<body class="bg-dark text-light">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1><?php echo $page_title ?></h1>
                <?php if (count($projects) > 0) : ?>
                    <p><?php echo count($projects) ?> Projects</p>
                <?php endif ?>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <table class="table table-dark table-sm table-striped table-hover table-borderless align-middle">
                    <thead>
                        <tr>
                            <th scope="col">Project</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($projects as $project) : ?>
                            <tr>
                                <th scope="row"><a href="<?php echo $project['url'] ?>" type="button" target="_blank" class="text-light"><?php echo $project['name'] ?></a></th>
                                <?php if ($project['is_dir'] == 1) : ?>
                                    <td>
                                        <?php if (array_key_exists('version', $project['info'])) : ?>
                                            <p><?php echo $project['info']['version'] ?></p>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (array_key_exists('category', $project['info'])) : ?>
                                            <span class="badge rounded-pill px-3 category-<?php echo strtolower(str_replace(' ', '-', $project['info']['category'])) ?>"><?php echo $project['info']['category'] ?></span>
                                        <?php endif ?>
                                    </td>
                                    <td colspan="2">
                                        <?php if (array_key_exists('overview', $project['info'])) : ?>
                                            <p class="mb-0"><strong>Overview: </strong><?php echo $project['info']['overview'] ?></p>
                                        <?php endif ?>

                                        <?php if (array_key_exists('scope', $project['info'])) : ?>
                                            <p class="mb-0"><strong>Scope: </strong><?php echo $project['info']['scope'] ?></p>
                                        <?php endif ?>
                                    </td>
                                <?php else : ?>
                                    <td colspan="4"><span class="badge bg-danger rounded-pill px-3">file</span></td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer <?= $nama ?></title>
    <style>
        h2 {
            color: #333;
        }

        .embed {
            width: 100%;
            height: 650px;
            border: 1px solid #ccc;
        }
 .modal {
        z-index: 2050;
    }
        p {
            color: #888;
        }
    </style>
</head>
<body>
    <h2>PDF Viewer <?= $nama ?></h2>
    <!-- <?php doi::dump($nama);?>
    <?php doi::dump($file);?> -->
    <object class="embed" data="<?= base_url('themes/file/regulasix/' . $file); ?>" type="application/pdf">
        <p>Unable to display PDF. Your browser may not support embedded PDFs or the file may be corrupted.</p>
        your file: <?= $file ?>
    </object>
</body>
</html>

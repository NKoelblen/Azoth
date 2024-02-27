<!DOCTYPE html PUBLIC "...">
<html xmlns="https://www.yourwebsite.com/1999/xhtml">

<head>
    <title>
        <?= $title ?>
    </title>
    <style></style>
</head>
<header>
    <a href="<?= get_site_url(); ?>">
        <img src="<?= get_site_url(null, '/wp-content/themes/azoth/assets/images/logo-full.webp'); ?>" height="256px">
    </a>
    <h1>
        <?= $title; ?>
    </h1>
</header>

<body>
<?php

    require_once 'lib.php';
    $context = new Context('data.db');
    $cat_name = $context->path_info();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Library</title>
</head>
<body>
<? if($cat_name) { ?>
    <h1>Items In Category <q><?= htmlspecialchars($cat_name) ?></q></h1>
    <ul>
        <? foreach(get_category_items($context, $cat_name) as $item) { ?>
            <li><a href="<?= $context->base() ?>/item/<?= urlencode($item['id']) ?>"><?= htmlspecialchars($item['title']) ?></a></li>
        <? } ?>
    </ul>
<? } else { ?>
    <h1>Categories</h1>
    <ul>
        <? foreach(get_categories($context) as $category) { ?>
            <li><a href="<?= $context->base() ?>/category/<?= urlencode($category) ?>"><?= htmlspecialchars($category) ?></a></li>
        <? } ?>
    </ul>
<? } ?>
</body>
</html>

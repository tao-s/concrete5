<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-block-share-this-page">
    <ul class="list-inline">
    <? foreach($selected as $service) { ?>
        <li><a href="<?= h($service->getServiceLink()) ?>"><?=$service->getServiceIconHTML()?></a></li>
    <? } ?>
    </ul>
</div>
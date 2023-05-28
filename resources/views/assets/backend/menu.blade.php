<?php
/**
 * @var array $menu
 * @var array $page
 */

?>
<ul class="nav treeview mb-4" data-accordion>
    <?php foreach($menu as $key => $item) { ?>
    <li class="nav-label"><?= $key ?></li>
        <?php foreach($item as $value){ ?>
    <li class="nav-item">
            <?php if(isset($value['children'])){ ?>
        <a class="nav-link has-icon treeview-toggle <?= isset($page[$value[0]]) ? $page[$value[0]].' show': '' ?>"
           href="#">
            <i class="material-icons">folder_open</i><?= $value[3] ?>
        </a>
        <ul class="nav">
                <?php foreach($value['children'] as $child) { ?>
            <li class="nav-item">
                <a href="<?= $child[2] ?>"
                   class="nav-link <?= $page[$child[0]] ?? '' ?>"><?= $child[1] ?><?= $child[3] ?></a>
            </li>
            <?php } ?>
        </ul>
        <?php }else{ ?>
        <a class="nav-link has-icon <?= $page[$value[0]] ?? '' ?>" href="<?= $value[2] ?>">
                <?= $value[1] ?><?= $value[3] ?>
        </a>
        <?php } ?>
    </li>
    <?php } ?>
    <?php } ?>
</ul>

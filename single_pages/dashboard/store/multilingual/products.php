<?php defined('C5_EXECUTE') or die("Access Denied.");

$action = $controller->getAction();
$csm = \Core::make('cshelper/multilingual');

if ($action == 'view') { ?>

     <div class="ccm-dashboard-content-full">
        <form role="form" class="form-inline ccm-search-fields">
            <div class="ccm-search-fields-row">
                <?php if($grouplist){
                    $currentFilter = '';
                    ?>
                    <ul id="group-filters" class="nav nav-pills">
                        <li <?= (!$gID ? 'class="active"' : '');?>><a href="<?= \URL::to('/dashboard/store/multilingual/products/')?>"><?= t('All Groups')?></a></li>

                        <li role="presentation" class="dropdown <?= ($gID ? 'active' : '');?>">
                            <?php
                            if ($gID) {
                                foreach($grouplist as $group) {
                                    if ($gID == $group->getGroupID()) {
                                        $currentFilter = $group->getGroupName();
                                    }
                                }
                            } ?>


                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <?= $currentFilter ? t('Filtering By: %s', $currentFilter) : t('Filter By Product Group'); ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <?php foreach($grouplist as $group){ ?>
                                    <li <?= ($gID == $group->getGroupID() ? 'class="active"' : '');?>><a href="<?= \URL::to('/dashboard/store/multilingual/products/', $group->getGroupID())?>"><?= $group->getGroupName()?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
            </div>
            <div class="ccm-search-fields-row ccm-search-fields-submit">
                <div class="form-group">
                    <div class="ccm-search-main-lookup-field">
                        <i class="fa fa-search"></i>
                        <?= $form->search('keywords', $searchRequest['keywords'], array('placeholder' => t('Search by Name or SKU')))?>
                    </div>

                </div>
                <button type="submit" class="btn btn-default"><?= t('Search')?></button>
            </div>

        </form>

        <table class="ccm-search-results-table">
            <thead>
                <tr>
                    <th><a><?= t('Product')?></a></th>
                    <th><a><?= $defaultLocale->getLanguageText($defaultLocale->getLocale()); ?> (<?= $defaultLocale->getLocale() ?>)</a></th>

                    <th><a href="<?=  $productList->getSortURL('active');?>"><?= t('Active')?></a></th>
                    <th><a><?= t('Groups')?></a></th>

                    <?php
                    foreach ($locales as $lp) { ?>
                    <th><a><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</a><th>
                    <?php } ?>


                    <th><a><?= t('Translate')?></a></th>
                </tr>
            </thead>
            <tbody>

            <?php if(count($products)>0) {
                foreach ($products as $product) {
                    ?>
                    <tr>
                        <td><?= $product->getImageThumb();?></td>
                        <td><strong><a href="<?= \URL::to('/dashboard/store/multilingual/products/product/', $product->getID())?>"><?=  $product->getName();
                                $sku = $product->getSKU();
                                if ($sku) {
                                    echo ' (' .$sku . ')';
                                }
                                ?>
                                </a></strong></td>
                        <td>
                            <?php
                            if ($product->isActive()) {
                                echo "<span class='label label-success'>" . t('Active') . "</span>";
                            } else {
                                echo "<span class='label label-default'>" . t('Inactive') . "</span>";
                            }
                            ?>
                        </td>

                        <td>
                            <?php $productgroups = $product->getGroups();
                            foreach($productgroups as $pg) { ?>
                                <span class="label label-primary"><?=  $pg->getGroup()->getGroupName(); ?></span>
                             <?php } ?>

                            <?php if (empty($productgroups)) { ?>
                                <em><?=  t('None');?></em>
                            <?php } ?>
                        </td>

                    <?php foreach ($locales as $lp) { ?>
                    <td>
                        <?= $csm->t(null, 'productName', $product->getID(), $lp->getLocale());?>
                        <td>
                    <?php } ?>

                        <td>
                            <a class="btn btn-default"
                               href="<?= \URL::to('/dashboard/store/multilingual/products/product', $product->getID())?>"><i
                                    class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                <?php }
            }?>
            </tbody>
        </table>

        <?php if ($paginator->getTotalPages() > 1) { ?>
            <div class="ccm-search-results-pagination">
                <?=  $pagination ?>
            </div>
        <?php } ?>

    </div>


<?php } ?>

<?php if ($action == 'product') {

    $localecount = count($locales);

    ?>
    <form method="post" action="<?= $view->action('save')?>">
        <?= $token->output('community_store'); ?>
        <input type="hidden" name="pID" value="<?= $product->getID()?>"/>
    <table class="table table-bordered">
        <tr>
            <th><?= t('Context'); ?></th>
            <th><?= t('Text'); ?> - <?= $defaultLocale->getLanguageText($defaultLocale->getLocale()); ?> (<?= $defaultLocale->getLocale() ?>)</th>
            <th><?= t('Locale') ?></th>
            <th style="width: 50%"><?= t('Translations'); ?></th>
        </tr>

        <?php

        $firstrow = true;
        foreach ($locales as $lp) { ?>
            <tr>
                <?php if ($firstrow) {
                    $firstrow = false;
                    ?>
                    <td rowspan="<?= $localecount; ?>"><span class="label label-primary"><?= t('Product Name') ?></span>
                    </td>
                    <td rowspan="<?= $localecount; ?>"><?= $product->getName() ?></td>
                <?php } ?>

                <td>
                    <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                </td>

                <td>
                    <input type="text" class="form-control" name="translation[<?= $lp->getLocale(); ?>][text][productName]" value="<?= $csm->t(null, 'productName', $product->getID(), $lp->getLocale());?>" />
                </td>

            </tr>
        <?php } ?>

        <?php

        $firstrow = true;
        foreach ($locales as $lp) { ?>
            <tr>
                <?php if ($firstrow) {
                    $firstrow = false;
                    ?>
                    <td rowspan="<?= $localecount; ?>"><span class="label label-primary"><?= t('Short Description') ?></span>
                    </td>
                    <td rowspan="<?= $localecount; ?>"><?= $product->getDescription() ?></td>
                <?php } ?>

                <td >
                    <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                </td>

                <td>

                    <?php
                    $editor = Core::make('editor');
                    echo $editor->outputStandardEditor('translation[' .$lp->getLocale() .'][longText][productDescription]', $csm->t(null, 'productDescription', $product->getID(), $lp->getLocale()));
                    ?>

                </td>

            </tr>
        <?php } ?>

        <?php

        $firstrow = true;
        foreach ($locales as $lp) { ?>
            <tr>
                <?php if ($firstrow) {
                    $firstrow = false;
                    ?>
                    <td rowspan="<?= $localecount; ?>"><span class="label label-primary"><?= t('Details') ?></span>
                    </td>
                    <td rowspan="<?= $localecount; ?>"><?= $product->getDetail() ?></td>
                <?php } ?>

                <td>
                    <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                </td>

                <td>
                    <?php
                    $editor = Core::make('editor');
                    echo $editor->outputStandardEditor('translation[' .$lp->getLocale() .'][longText][productDetails]', $csm->t(null, 'productDetails', $product->getID(), $lp->getLocale()));
                    ?>
                </td>

            </tr>
        <?php } ?>

        <?php

        $firstrow = true;
        foreach ($locales as $lp) { ?>
        <tr>
            <?php if ($firstrow) {
                $firstrow = false;
                ?>
                <td rowspan="<?= $localecount; ?>"><span class="label label-primary"><?= t('Quantity Label') ?></span>
                </td>
                <td rowspan="<?= $localecount; ?>"><?= $product->getQtyLabel() ?></td>
            <?php } ?>

            <td>
                <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
            </td>

            <td>
                <input type="text" class="form-control" name="translation[<?= $lp->getLocale(); ?>][text][productQuantityLabel]" value="<?= $csm->t(null, 'productQuantityLabel', $product->getID(), $lp->getLocale());?>" />
            </td>

        </tr>
        <?php } ?>


    </table>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?= \URL::to('/dashboard/store/multilingual/products/')?>" class="btn btn-default pull-left"><?= t("Cancel")?></a>
            <button class="pull-right btn btn-success"  type="submit" ><?= t('Save Product Translation')?></button>
        </div>
    </div>


<?php } ?>

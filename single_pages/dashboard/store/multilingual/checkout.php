<?php defined('C5_EXECUTE') or die("Access Denied.");


$csm = \Core::make('cshelper/multilingual');
$action = $controller->getAction();
$localecount = count($locales);


?>

<form method="post" action="<?= $view->action('save') ?>">
    <?= $token->output('community_store'); ?>
    <fieldset>
        <legend><?= t('Payment Methods'); ?></legend>

        <?php if (!empty($paymentMethods)) { ?>
         <table class="table table-bordered table-condensed">
            <tr>
                <th><?= t('Payment Method'); ?></th>
                <th><?= t('Context'); ?></th>
                <th><?= t('Text'); ?> - <?= $defaultLocale->getLanguageText($defaultLocale->getLocale()); ?>
                    (<?= $defaultLocale->getLocale() ?>)
                </th>
                <th><?= t('Locale') ?></th>
                <th style="width: 50%"><?= t('Translations'); ?></th>
            </tr>

            <?php

            foreach ($paymentMethods as $paymentMethod) {

                $firstrow = true;
                foreach ($locales as $lp) { ?>
                    <tr>
                        <?php if ($firstrow) {
                            $firstrow = false;
                            ?>
                            <td rowspan="<?= $localecount * 2; ?>"><?= h($paymentMethod->getName()); ?></td>
                            <td rowspan="<?= $localecount; ?>"><span
                                        class="label label-primary"><?= t('Payment Display Name'); ?></span>
                            </td>
                            <td rowspan="<?= $localecount; ?>"><?= h($paymentMethod->getDisplayName()); ?></td>
                        <?php } ?>

                        <td>
                            <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                        </td>

                        <td>
                            <input type="text" class="form-control"
                                   name="translation[paymentMethods][<?= $paymentMethod->getID(); ?>][<?= $lp->getLocale(); ?>][text][paymentDisplayName]"
                                   value="<?= $csm->t(null, 'paymentDisplayName', $paymentMethod->getID(), false, $lp->getLocale()); ?>"/>
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

                            <td rowspan="<?= $localecount; ?>"><span
                                        class="label label-primary"><?= t('Payment Button Label'); ?></span>
                            </td>
                            <td rowspan="<?= $localecount; ?>"><?= h($paymentMethod->getButtonLabel()); ?></td>
                        <?php } ?>

                        <td>
                            <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                        </td>

                        <td>
                            <input type="text" class="form-control"
                                   name="translation[paymentMethods][<?= $paymentMethod->getID(); ?>][<?= $lp->getLocale(); ?>][text][paymentButtonLabel]"
                                   value="<?= $csm->t(null, 'paymentButtonLabel', $paymentMethod->getID(), false, $lp->getLocale()); ?>"/>
                        </td>

                    </tr>
                <?php } ?>


            <?php } ?>
        </table>
        <?php } else { ?>
        <p class="alert alert-info"><?= t("No Payment Methods are installed"); ?></p>
        <?php } ?>

    </fieldset>


    <fieldset>
        <legend><?= t('Shipping Methods'); ?></legend>

        <table class="table table-bordered table-condensed">
            <tr>
                <th><?= t('Shipping Method'); ?></th>
                <th><?= t('Context'); ?></th>
                <th><?= t('Text'); ?> - <?= $defaultLocale->getLanguageText($defaultLocale->getLocale()); ?>
                    (<?= $defaultLocale->getLocale() ?>)
                </th>
                <th><?= t('Locale') ?></th>
                <th style="width: 50%"><?= t('Translations'); ?></th>
            </tr>

            <?php

            foreach ($shippingMethods as $shippingMethod) {

                $firstrow = true;
                foreach ($locales as $lp) { ?>
                    <tr>
                        <?php if ($firstrow) {
                            $firstrow = false;
                            ?>
                            <td rowspan="<?= $localecount * 2; ?>"><?= h($shippingMethod->getName()); ?></td>
                            <td rowspan="<?= $localecount; ?>"><span
                                        class="label label-primary"><?= t('Shipping Method Name'); ?></span>
                            </td>
                            <td rowspan="<?= $localecount; ?>"><?= h($shippingMethod->getName()); ?></td>
                        <?php } ?>

                        <td>
                            <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                        </td>

                        <td>
                            <input type="text" class="form-control"
                                   name="translation[shippingMethods][<?= $shippingMethod->getID(); ?>][<?= $lp->getLocale(); ?>][text][shippingName]"
                                   value="<?= $csm->t(null, 'shippingName',  $shippingMethod->getID(), false, $lp->getLocale()); ?>"/>
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

                            <td rowspan="<?= $localecount; ?>"><span
                                        class="label label-primary"><?= t('Details'); ?></span>
                            </td>
                            <td rowspan="<?= $localecount; ?>"><?= h($paymentMethod->getButtonLabel()); ?></td>
                        <?php } ?>

                        <td>
                            <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                        </td>

                        <td>
                            <input type="text" class="form-control"
                                   name="translation[shippingMethods][<?= $shippingMethod->getID(); ?>][<?= $lp->getLocale(); ?>][text][shippingDetails]"
                                   value="<?= $csm->t(null, 'shippingDetails', $shippingMethod->getID(), false, $lp->getLocale()); ?>"/>
                        </td>

                    </tr>
                <?php } ?>


            <?php } ?>
        </table>

    </fieldset>

    <fieldset>
        <legend><?= t('Tax Rates'); ?></legend>

        <?php if  (!empty($taxRates)) { ?>
            <table class="table table-bordered table-condensed">
            <tr>
                <th><?= t('Shipping Method'); ?></th>
                <th><?= t('Context'); ?></th>
                <th><?= t('Text'); ?> - <?= $defaultLocale->getLanguageText($defaultLocale->getLocale()); ?>
                    (<?= $defaultLocale->getLocale() ?>)
                </th>
                <th><?= t('Locale') ?></th>
                <th style="width: 50%"><?= t('Translations'); ?></th>
            </tr>

            <?php

            foreach ($taxRates as $taxRate) {

                $firstrow = true;
                foreach ($locales as $lp) { ?>
                    <tr>
                        <?php if ($firstrow) {
                            $firstrow = false;
                            ?>
                            <td rowspan="<?= $localecount * 2; ?>"><?= h($shippingMethod->getName()); ?></td>
                            <td rowspan="<?= $localecount; ?>"><span
                                        class="label label-primary"><?= t('Tax Rate Name'); ?></span>
                            </td>
                            <td rowspan="<?= $localecount; ?>"><?= h($taxRate->getTaxLabel()); ?></td>
                        <?php } ?>

                        <td>
                            <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                        </td>

                        <td>
                            <input type="text" class="form-control"
                                   name="translation[taxRates][<?= $taxRate->getID(); ?>][<?= $lp->getLocale(); ?>][text][taxRateName]"
                                   value="<?= $csm->t(null, 'taxRateName', $taxRate->getID(), false ,$lp->getLocale()); ?>"/>
                        </td>

                    </tr>
                <?php } ?>


            <?php } ?>
        </table>
        <?php } else { ?>
            <p class="alert alert-info"><?= t('No Tax Rates have been defined'); ?></p>
        <?php } ?>

    </fieldset>

    <fieldset>
        <legend><?= t('Discount Rules'); ?></legend>


        <?php if  (!empty($discountRules)) { ?>
            <table class="table table-bordered table-condensed">
                <tr>
                    <th><?= t('Discount Rule'); ?></th>
                    <th><?= t('Context'); ?></th>
                    <th><?= t('Text'); ?> - <?= $defaultLocale->getLanguageText($defaultLocale->getLocale()); ?>
                        (<?= $defaultLocale->getLocale() ?>)
                    </th>
                    <th><?= t('Locale') ?></th>
                    <th style="width: 50%"><?= t('Translations'); ?></th>
                </tr>

                <?php

                foreach ($discountRules as $discountRule) {

                    $firstrow = true;
                    foreach ($locales as $lp) { ?>
                        <tr>
                            <?php if ($firstrow) {
                                $firstrow = false;
                                ?>
                                <td rowspan="<?= $localecount * 2; ?>"><?= h($discountRule->getName()); ?></td>
                                <td rowspan="<?= $localecount; ?>"><span
                                            class="label label-primary"><?= t('Discount Display Name'); ?></span>
                                </td>
                                <td rowspan="<?= $localecount; ?>"><?= h($discountRule->getDisplay()); ?></td>
                            <?php } ?>

                            <td>
                                <span class="label label-default"><?= $lp->getLanguageText($lp->getLocale()); ?> (<?= $lp->getLocale() ?>)</span>
                            </td>

                            <td>
                                <input type="text" class="form-control"
                                       name="translation[discountRules][<?= $discountRule->getID(); ?>][<?= $lp->getLocale(); ?>][text][discountRuleDisplayName]"
                                       value="<?= $csm->t(null, 'discountRuleDisplayName', $discountRule->getID(), false, $lp->getLocale()); ?>"/>
                            </td>

                        </tr>
                    <?php } ?>


                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="alert alert-info"><?= t('No Discount Rules have been defined'); ?></p>
        <?php } ?>



    </fieldset>


    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">

            <button class="pull-right btn btn-success" type="submit"><?= t('Save Translations') ?></button>
        </div>
    </div>

</form>
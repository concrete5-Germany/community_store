<?php
namespace Concrete\Package\CommunityStore\Controller\SinglePage\Dashboard\Store;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

class Multilingual extends DashboardPageController
{
    public function view()
    {
        return Redirect::to('/dashboard/store/multilingual/products');
    }
}

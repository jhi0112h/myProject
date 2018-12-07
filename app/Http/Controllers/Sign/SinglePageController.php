<?php
/**
 * Created by PhpStorm.
 * User: darryldecode
 * Date: 4/2/2018
 * Time: 8:40 AM
 */

namespace App\Http\Controllers\Sign;


use App\Components\Core\Menu\MenuItem;
use App\Components\Core\Menu\MenuManager;
use App\Components\User\Models\User;

class SinglePageController extends SignController
{
    public function displaySPA()
    {
        /**
         * @var User $currentUser
         */
        $currentUser = \Auth::user();
        $menuManager = new MenuManager();
        $menuManager->setUser($currentUser);
        $menuManager->addMenus([
            new MenuItem([
                'group_requirements' => [],
                'permission_requirements' => ['user','superuser'],
                'label'=>'업체관리',
                'nav_type' => MenuItem::$NAV_TYPE_NAV,
                'icon'=>'assignment',
                'route_type'=>'vue',
                'route_name'=>'signs'
            ]),
            new MenuItem([
                'nav_type' => MenuItem::$NAV_TYPE_DIVIDER
            ])
        ]);

        $menus = $menuManager->getFiltered();

        view()->share('nav',$menus);

        return view('layouts.admin');
    }
}
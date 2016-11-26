<?php namespace Mesadev\Inventory;

use System\Classes\PluginBase;
use Backend\Facades\Backend;

/**
 * Inventory Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Inventory',
            'description' => 'MesaDev Inventory Management System',
            'author'      => 'Lester Ariel Mesa',
            'icon'        => 'icon-pencil'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        //return []; // Remove this line to activate

        return [
            'Mesadev\Inventory\Components\Listing' => 'listing',
            'Mesadev\Inventory\Components\Display' => 'display',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'mesadev.inventory.some_permission' => [
                'tab' => 'Inventory',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'inventory' => [
                'label'       => 'Inventory',
                'url'         => Backend::url('mesadev/inventory/items'),
                'icon'        => 'icon-pencil',
                'permissions' => ['mesadev.inventory.*'],
                'order'       => 500,

                'sideMenu' => [
                    'posts' => [
                        'label'       => 'Posts',
                        'icon'        => 'icon-copy',
                        'url'         => Backend::url('acme/blog/posts'),
                        'permissions' => ['acme.blog.access_posts']
                    ],
                    'categories' => [
                        'label'       => 'Categories',
                        'icon'        => 'icon-copy',
                        'url'         => Backend::url('acme/blog/categories'),
                        'permissions' => ['acme.blog.access_categories']
                    ]
                ]
            ]
        ];
    }

    public function registerReportWidgets(){
        return [
            'Mesadev\Inventory\ItemWidget' => [
                'label'     => 'Item CRUD Widget',
                'context'   => 'dashboard'
            ]
        ];
    }

}

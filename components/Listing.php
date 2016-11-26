<?php namespace Mesadev\Inventory\Components;

use Cache;
use Cms\Classes\ComponentBase;
use Request;
use System\Classes\ApplicationException;
use Mesadev\Inventory\Models\Item;



class Listing extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Listing Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'category' => [
                'title'             => 'Category',
                'type'              => 'dropdown',
                'default'           => 'Jets'
            ],
            'items' => [
                'title'             => 'Items',
                'type'              => 'dropdown',
                'default'           => '204',
                'depends'           => ['category'],
                'placeholder'       => 'Select an item'
            ]
        ];
    }

    protected function loadListingData()
    {
        return json_decode(file_get_contents(__DIR__.'/../data/items.json'), true);
    }

    public function getCategoryOptions()
    {
        $categories = $this->loadListingData();
        $result = [];

        foreach ($categories as $category => $data)
            $result[$category] = $data['name'];

        return $result;
    }

    public function getItemsOptions()
    {
        $categories = $this->loadListingData();
        $categoryCode = Request::input('category');
        $categoryCode = "jets";
        return isset($categories[$categoryCode]) ? $categories[$categoryCode]['items'] : [];
    }

    public function onRun()
    {
        $this->addCss('/plugins/mesadev/inventory/assets/css/listings.css');

        // TODO: return all items including categories
        $this->page['listingsInfo'] = Item::where('category', 'jets')->get();
    }

}
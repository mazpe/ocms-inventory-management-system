<?php namespace Mesadev\Inventory\Components;

use Cms\Classes\ComponentBase;
use Mesadev\Inventory\Models\Item;

class Display extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Display Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
                'title'             => 'Item ID',
                'description'       => 'The ID for the inventory item',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Item ID must of a numeric value'
            ]
        ];
    }

    public function onRun()
    {
        $itemId = $this->param('item_id');

        $this->page['itemInfo'] = Item::find($itemId);
    }
}
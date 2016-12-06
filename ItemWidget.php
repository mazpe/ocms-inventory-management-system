<?php namespace IIS\Inventory;

use Backend\Facades\BackendAuth;
use Backend\Classes\ReportWidgetBase;
use IIS\Inventory\Models\Item;

class ItemWidget extends ReportWidgetBase
{

    public function render()
    {
        $items = Item::all();

        return $this->makePartial('items', [ 'items' => $items ]);
    }

    public function defineProperties()
    {
        return [
            'serial'     => [
                'serial'     => 'Widget serial',
                'default'   => 'Serial Number'
            ],
            'showList'  => [
                'title'     => 'Show notes',
                'type'      => 'checkbox'
            ]
        ];
    }
}
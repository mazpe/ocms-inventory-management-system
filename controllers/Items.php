<?php namespace Mesadev\Inventory\Controllers;

use Backend\Facades\Backend;
use BackendMenu;
use Backend\Classes\Controller;
use \Mesadev\Inventory\Models\Item;
use Illuminate\Support\Facades\Input;
use \Mesadev\Inventory\Models;
use Mesadev\Inventory\Plugin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;

/**
 * Items Back-end Controller
 */
class Items extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'Manage Items';
    }

    public function store()
    {
        $item = new Models\Item;
        $item->photos()->create(['data' => Input::file('file_input')]);

        if( $item->save() ) {
            \Flash::success('Item added successfully.');
        }
        else{
            $messages = array_flatten( $item->errors()->getMessages() );
            $errors = implode( ' - ', $messages );

            \Flash::error('Validation error: ' . $errors );
        }

        return \Redirect::to( Backend::url() );
    }

    public function index()
    {
        $this->makeLists();
        $this->makeView('index');
    }

    public function listOverrideColumnValue($record, $columnName)
    {
        if( $columnName == "description" && empty($record->description) )
            return "[EMPTY]";
    }

    public function onDelete()
    {
        foreach(post("checked") as $id) {
            $item = Item::find($id);

            // Delete PDF Brochures
            $path = storage_path().'/app/uploads/public/brochures';
            $file = "$item->serial.pdf";
            $full_filename = "$path/$file";
            File::delete($full_filename);

            // Create Job to delete Facebook Post
            if ($item->facebook_post_id)
            {
                Queue::push('\Mesadev\Inventory\Jobs\FacebookJobs@pagePostDelete',
                    [ 'post_id' => $item->facebook_post_id]
                );
            }

            if ($item->twitter_post_id)
            {
                Queue::push('\Mesadev\Inventory\Jobs\TwitterJobs@tweetPostDelete',
                    [ 'post_id' => $item->twitter_post_id ]
                );
            }
        }

        // Delete from Database
        Item::whereIn('id', post("checked"))->delete();

        \Flash::success('Items Successfully deleted.');

        return $this->listRefresh();
    }

}
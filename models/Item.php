<?php namespace IIS\Inventory\Models;

use League\Flysystem\Exception;
use Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Queue;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Item Model
 */
class Item extends Model
{
    /**
     * used for automatic validation using the defined rules.
     */
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'iis_inventory_items';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    protected $rules = [
        'serial'         => 'required|numeric',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'avatar' => 'System\Models\File'
    ];
    public $attachMany = [
        'photos' => 'System\Models\File'
    ];

    public function afterSave()
    {
        // PDF GENERATION
        $snappy = App::make('snappy.pdf');

        $path = storage_path().'/app/uploads/public/brochures';
        $file = "$this->serial.pdf";
        $full_filename = "$path/$file";

        $url = 'http://'.env('APP_URL').'/aircraft/'.$this->id;

        $snappy->generate($url, $full_filename, [], $overwrite = true);

        // Submit Post to Facebook & Twitter
        try {
//            $this->postToFacebook();
            $this->postToTwitter();
        } catch(\Exception $e) {
            throw $e;
        }

    }

    private function postToFacebook()
    {
        if ($this->facebook_post_id)
        {
            $action = 'updating';
            $post_id = $this->facebook_post_id;
        }
        else
        {
            $action = 'creating';
            $post_id = '1758521517742826/feed';
        }

        // Create job to submit to Facebook
        Queue::push('\IIS\Inventory\Jobs\FacebookJobs@pagePostSubmit',
            [ 'action' => $action, 'item_id' => $this->id,'post_id' => "/$post_id"]
        );

        return true;
    }

    private function postToTwitter()
    {
        if ($this->twitter_post_id) {
            $post_id = $this->twitter_post_id;
            // Create job to delete previous twitter post
            Queue::push('\IIS\Inventory\Jobs\TwitterJobs@tweetPostDelete',
                ['post_id' => $post_id]
            );

            // Create job to create twitter post
            Queue::push('\IIS\Inventory\Jobs\TwitterJobs@tweetPostSubmit',
                ['item_id' => $this->id]
            );
        } else {
            // Create job to create twitter post
            Queue::push('\IIS\Inventory\Jobs\TwitterJobs@tweetPostSubmit',
                ['item_id' => $this->id]
            );
        }

        return true;
    }
}
<?php namespace Mesadev\Inventory\Models;

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
    public $table = 'mesadev_inventory_items';

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

    public function afterCreate()
    {
        // SOCIAL MEDIA
        // Submit Post to Twitter
        try {
            // Create job to submit to Facebook
            Queue::push('\Mesadev\Inventory\Jobs\TwitterJobs@tweetPostSubmit',
                [ 'item_id' => $this->id ]
            );
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function afterSave()
    {
        // PDF GENERATION
        $snappy = App::make('snappy.pdf');

        $path = storage_path().'/app/brochures';
        $file = "$this->serial.pdf";
        $full_filename = "$path/$file";

        $url = 'http://jetspeedaviation.app/portfolio/'.$this->id;

        $snappy->generate($url, $full_filename, [], $overwrite = true);



        // Submit Post to Facebook
        try {
            $this->postToFacebook();
        } catch(\Exception $e) {
            Throw $e;
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
        Queue::push('\Mesadev\Inventory\Jobs\FacebookJobs@pagePostSubmit',
            [ 'action' => $action, 'item_id' => $this->id,'post_id' => "/$post_id"]
        );

        return true;
    }


    private function submitTwitterPost() {
        $tweet_status = substr(strip_tags($this->description), 0, 110) . '... - http://ww2.jetspeedaviation.com/profile/'. $this->id;

        $twitter = App::make('Thujohn\Twitter\Twitter');
        $tweet = $twitter->postTweet(['status' => $tweet_status, 'format' => 'json']);
        $tweet = json_decode($tweet);

        dd($tweet);
        if ($tweet->id) {
            $this->updateSocialMediaId('twitter', $tweet->id);
        }

        return true;
    }

}
<?php namespace Mesadev\Inventory\Jobs;

use Illuminate\Support\Facades\App;
use Mesadev\Inventory\Models\Item;

class TwitterJobs
{
    public function tweetPostSubmit($job, $data)
    {
        $item_id = $data['item_id'];

        $item = Item::find($item_id);

        $tweet_status = substr(strip_tags($item->description), 0, 110) . '... - http://'.env('APP_URL').'/portfolio/'. $item_id;

        $twitter = App::make('Thujohn\Twitter\Twitter');
        $tweet = $twitter->postTweet(['status' => $tweet_status, 'format' => 'json']);
        $tweet = json_decode($tweet);

        // Update database with Post id
        // GOTCHA: Have to disable Model Events (afterSave() in particular), else it would cause a while loop:
        // Model creates Job on afterSave(), Job saves Model with Post Id, afterSave() creates Job again and so on.
        $dispatcher = Item::getEventDispatcher();
        Item::unsetEventDispatcher();
        $item->twitter_post_id = $tweet->id;
        $item->save();
        Item::setEventDispatcher($dispatcher);

        $job->delete();

        return true;
    }

    public function tweetPostDelete($job, $data)
    {
        $post_id = $data['post_id'];

        $twitter = App::make('Thujohn\Twitter\Twitter');
        $twitter->destroyTweet($post_id);

        $job->delete();

        return true;
    }

}


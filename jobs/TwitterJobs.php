<?php namespace IIS\Inventory\Jobs;

use Illuminate\Support\Facades\App;
use IIS\Inventory\Models\Item;
use Illuminate\Support\Facades\Storage;

class TwitterJobs
{
    public function tweetPostSubmit($job, $data)
    {
        $item_id = $data['item_id'];

        $item = Item::find($item_id);

        $tweet_status = substr(strip_tags($item->description), 0, 110) . '... - http://'.env('APP_URL').'/aircraft/'. $item_id;
        $photos = $item->photos;

        $twitter = App::make('Thujohn\Twitter\Twitter');

        if ($photos->count() > 0) {
            $photos->first( function ($key, $value) use ($item_id, $twitter, $tweet_status) {
                $disk_name = $value->disk_name;
                $path = "uploads/public/";
                $path = $path . substr($value->disk_name,0,3) . "/" . substr($disk_name,3,3) . "/" . substr($disk_name,6,3);
                $path = $path . "/" . $disk_name;

                $uploaded_media = $twitter->uploadMedia(['media' => Storage::get($path)]);
                $tweet = $twitter->postTweet(['status' => $tweet_status, 'media_ids' => $uploaded_media->media_id_string]);

                $this->updateItemWitehPostId($item_id, $tweet->id);
            });
        } else {
            $tweet = $twitter->postTweet(['status' => $tweet_status, 'format' => 'json']);
            $tweet = json_decode($tweet);

            $this->updateItemWitehPostId($item_id, $tweet->id);
        }

        $job->delete();

        return true;
    }

    private function updateItemWitehPostId($item_id, $post_id)
    {
        $item = Item::find($item_id);

        // Update database with Post id
        // GOTCHA: Have to disable Model Events (afterSave() in particular), else it would cause a while loop:
        // Model creates Job on afterSave(), Job saves Model with Post Id, afterSave() creates Job again and so on.
        $dispatcher = Item::getEventDispatcher();
        Item::unsetEventDispatcher();
        $item->twitter_post_id = $post_id;
        $item->save();
        Item::setEventDispatcher($dispatcher);

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


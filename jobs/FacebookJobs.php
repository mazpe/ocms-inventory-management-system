<?php namespace Mesadev\Inventory\Jobs;

use Illuminate\Support\Facades\App;
use Mesadev\Inventory\Models\Item;

class FacebookJobs
{
    public function pagePostSubmit($job, $data)
    {
        $action  = $data['action'];
        $item_id = $data['item_id'];
        $post_id = $data['post_id'];

        $fb = App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');
        $jsa_page_token = "EAAOhUHdPGPoBAAV8fpeZAJP6d1YdhwWSLJloOEoGcsBeXclB4wpQC3nQ69dTPQ8Dx7WiK7CXcKcdsk8MDFfIybKZC19abGlLE9RDquVjovJ85aZAceeAE1e0z4c8v8cwEM9iTGZAfBAn3ZCbbEiTcAXxoXZCLXdjwZD";

        $item = Item::find($item_id);

        $linkData = [
            'link' => 'http://'.env('APP_URL').'/portfolio/'.$item_id,
            'message' => strip_tags($item->description),
        ];

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post($post_id, $linkData, $jsa_page_token);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if ($action == 'creating') {
            // Get the Post id form response
            $post_id = json_decode($response->getGraphNode()->asJson())->id;

            // Update database with Post id
            // GOTCHA: Have to disable Model Events (afterSave() in particular), else it would cause a while loop:
            // Model creates Job on afterSave(), Job saves Model with Post Id, afterSave() creates Job again and so on.
            $dispatcher = Item::getEventDispatcher();
            Item::unsetEventDispatcher();
            $item->facebook_post_id = $post_id;
            $item->save();
            Item::setEventDispatcher($dispatcher);
        }

        $job->delete();

        return true;
    }

    public function pagePostDelete($job, $data)
    {
        $post_id = $data['post_id'];

        $fb = App::make('SammyK\LaravelFacebookSdk\LaravelFacebookSdk');
        $jsa_page_token = "EAAOhUHdPGPoBAAV8fpeZAJP6d1YdhwWSLJloOEoGcsBeXclB4wpQC3nQ69dTPQ8Dx7WiK7CXcKcdsk8MDFfIybKZC19abGlLE9RDquVjovJ85aZAceeAE1e0z4c8v8cwEM9iTGZAfBAn3ZCbbEiTcAXxoXZCLXdjwZD";

        $fb->setDefaultAccessToken($jsa_page_token);

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->delete($post_id);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        // Get the Post id form response
        $graphNode = $response->getGraphNode();

        $job->delete();

        return $graphNode['success'];
    }

}


<?php

namespace Acme;

use Facebook\Facebook;

final class FacebookConnector
{
    /**
     * @var Facebook
     */
    private $facebook;
    
    public function __construct()
    {
        $this->facebook = new Facebook(
            [
                'app_id' => $_ENV['FB_APP_ID'],
                'app_secret' => $_ENV['FB_APP_SECRET'],
                'default_graph_version' => 'v4.0',
            ]
        );
        $this->facebook->setDefaultAccessToken($_ENV['FB_ACCESS_TOKEN_OU']);
    }

    /**
     * @return Facebook
     */
    public function getFacebook(): Facebook
    {
        return $this->facebook;
    }
}

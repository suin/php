<?php

declare(strict_types=1);

namespace Suin\Jnb\GmailToSlack;

use Google_Client;
use Google_Service_Gmail;

final class DefaultGoogleClient
{
    public static function create(): Google_Client
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_Gmail::GMAIL_MODIFY);
        $client->setApplicationName('JapannetbankGmailToSlack');
        return $client;
    }
}

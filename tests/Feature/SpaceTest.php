<?php

declare(strict_types=1);

use Roberto\Storyblok\Mapi\MapiClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpClient\MockHttpClient;


test('Testing One space', function (): void {
    $responses = [
        new MockResponse(json_encode([
                "space" => [
                    "name" => "Example Space",
                    "domain" => "https://example.storyblok.com",
                    "uniq_domain" => null,
                    "plan" => "starter",
                    "plan_level" => 0,
                    "limits" => []
                ],
                "created_at" => "2018-11-10T15:33:18.402Z",
                "id" => 680,
                "role" => "admin",
                "owner_id" => 1114,
                "story_published_hook" => null,
            ])
            , []),
    ];

    $client = new MockHttpClient($responses);
    $mapiClient = MapiClient::initTest($client);
    $spaceApi = $mapiClient->spaceApi();


$storyblokResponse = $spaceApi->get("111");
/** @var \Roberto\Storyblok\Mapi\Data\SpaceData $storyblokData */
$storyblokData =  $storyblokResponse->data();
expect($storyblokData->get("name"))->toBe("Example Space");
expect($storyblokData->name())->toBe("Example Space");
expect($storyblokData->createdAt())->toBe("2024-12-31");


});
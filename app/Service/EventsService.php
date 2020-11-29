<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EventsService extends Base\BaseService
{
    /**
     * Получить список мероприятий
     * @return mixed
     * @throws GuzzleException
     */
    public function getShows()
    {
        $client = new Client();
        $response = $client->get('https://leadbook.ru/test-task-api/shows');

        $data = json_decode($response->getBody(), true);
        return $data['response'];
    }

    /**
     * Получить Список событий мероприятия
     * @param $showId
     * @return mixed
     * @throws GuzzleException
     */
    public function getEvents($showId)
    {
        $client = new Client();
        $response = $client->get('https://leadbook.ru/test-task-api/shows/' .$showId. '/events');

        $data = json_decode($response->getBody(), true);
        return $data['response'];
    }

    /**
     * Получить список мест
     * @param $eventId
     * @return mixed
     * @throws GuzzleException
     */
    public function getPlaces($eventId)
    {
        $client = new Client();
        $response = $client->get('https://leadbook.ru/test-task-api/events/' .$eventId. '/places');

        $data = json_decode($response->getBody(), true);
        return $data['response'];
    }


    public function booking($eventId, string $name, $places)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'https://leadbook.ru/test-task-api/events/' .$eventId. '/reserve',
            [
                'form_params' => [
                    'name' => $name,
                    'places' => $places,
                ]
            ]
        );
        $data = json_decode($response->getBody(), true);
        return $data['response'];
    }

}

<?php

namespace App\Service;

use App\Contracts\Service;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EventsService extends Base\BaseService implements Service
{
    /**
     * Путь отображения списка мероприятий
     * @return string
     */
    public function getShowsPath()
    {
        return $this->getBasePath() . '/shows';
    }

    /**
     * Путь отображения списка мероприятий
     * @param $showId
     * @return string
     */
    public function getEventsPath($showId)
    {
        return $this->getBasePath() . '/shows/' . $showId. '/events';
    }

    /**
     * Получить путь выбора мест
     * @param $eventId
     * @return string
     */
    public function getPlacesPath($eventId)
    {
        return $this->getBasePath() . '/events/' .$eventId. '/places';
    }

    /**
     * Получить путь для выполнения бронирования
     * @param $eventId
     * @return string
     */
    public function getBookingPath($eventId)
    {
        return $this->getBasePath() . '/events/' .$eventId. '/reserve';
    }

    /**
     * Получить базовый путь для API-запросов
     * @return mixed
     */
    public function getBasePath()
    {
        return env('BASE_API_PATH', 'https://leadbook.ru/test-task-api');
    }

    /**
     * Получить список мероприятий
     * @return mixed
     * @throws GuzzleException
     */
    public function getShows()
    {
        return $this->getRequest($this->getShowsPath());
    }

    /**
     * Получить Список событий мероприятия
     * @param $showId
     * @return mixed
     * @throws GuzzleException
     */
    public function getEvents($showId)
    {
        return $this->getRequest($this->getEventsPath($showId));
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
        $response = $client->get($this->getPlacesPath($eventId));

        $data = json_decode($response->getBody(), true);
        return $data['response'];
    }


    /**
     * @param $eventId
     * @param string $name
     * @param $places
     * @return mixed
     * @throws GuzzleException
     */
    public function booking($eventId, string $name, $places)
    {
        return $this->postRequest($this->getBookingPath($eventId), [
            'form_params' => [
                'name' => $name,
                'places' => $places,
            ],
            'headers' => $this->getHeaders(),
        ]);
    }


    /**
     * GET-запрос
     * @param string $url
     * @return mixed
     * @throws GuzzleException
     */
    public function getRequest(string $url)
    {
        $client = new Client();
        $response = $client->get($url, ['headers' => $this->getHeaders()]);

        $data = json_decode($response->getBody(), true);
        return $data['response'];
    }

    /**
     * POST-запрос
     * @param string $url
     * @param $params
     * @return mixed
     * @throws GuzzleException
     */
    public function postRequest(string $url, $params)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->post($url, $params);
        $data = json_decode($response->getBody(), true);
        return $data['response'];
    }

    /**
     * Установить токен для запросов
     * @return string[]
     */
    public function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . env('AUTH_TOKEN', 'f72e02929b79c96daf9e336e0a5cdb8059e60685'),
            'Accept'        => 'application/json',
        ];
    }
}

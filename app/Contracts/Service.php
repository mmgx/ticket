<?php
namespace App\Contracts;


interface Service
{
    public function getBasePath();

    public function getShowsPath();

    public function getEventsPath($showId);

    public function getPlacesPath($eventId);

    public function getBookingPath($eventId);

    public function getShows();

    public function getEvents($showId);

    public function getPlaces($eventId);

    public function booking($eventId, string $name, $places);

    public function getRequest(string $url);

    public function postRequest(string $url, $params);

    public function getHeaders(): array;
}

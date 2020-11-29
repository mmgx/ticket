<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;
use App\Service\EventsService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class EventController extends BaseController
{
    protected $eventsService;

    public function __construct(EventsService $eventsService)
    {
        $this->eventsService = $eventsService;
    }

    /**
     * вывод списка мероприятий
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function index()
    {
        $shows = $this->eventsService->getShows();
        return view('pages.events.index')->withShows($shows);
    }

    /**
     * детальная страница мероприятия со списком событий
     * @param $id
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function show($showId)
    {
        $events = $this->eventsService->getEvents($showId);
        return view('pages.events.show')->withEvents($events);
    }

    /**
     * Получить список мест
     * @param $eventId
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function places(Request $request, $eventId)
    {
        $places = $this->eventsService->getPlaces($eventId);

        foreach($places as $place){
            $schemeData[] = [
                'Angle' => "0.00",
                'BackColor' => "66CCCC",
                'CX' => $place['x'],
                'CX2' => $place['x'],
                'CY' => $place['y'],
                'CY2' => $place['y'],
                'FontColor' => "",
                'FontSize' => "0",
                'FreeOfferSeat' => "0",
                'Height' => "30",
                'ID' => $place['id'],
                'Label' => "0",
                'MaxX' => "13043",
                'MaxY' => "7563",
                'MinX' => "3529",
                'MinY' => "5105",
                'Name_sec' => "Название места",
                'NomBilKn' => "1460",
                'ObjectName' => "Place",
                'ObjectType' => "Place",
                'Price' => "1000",
                'PriceSell' => "1000.0000",
                'Row' => $place['id'],
                'Seat' => $place['id'],
                'Width' => "30",
                'avail' => $place['is_available'],
                'cod_sec' => "290",
                'name_sec' => "Название места"
            ];
        }
        return view('pages.events.event')->withPlaces($places)->withEventId($eventId)->withSchemeData(json_encode($schemeData));
    }


    public function booking(Request $request)
    {
        $reservation = $this->eventsService->booking($request['eventId'], $request['username'], $request['username']);
        return response()->json($reservation);
    }
}

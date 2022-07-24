<?php

namespace App\Services;

use App\Models\Flight;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class FlightApiService
{
    const BASE_URL =  "https://app.goflightlabs.com/flights";
    const ACCESS_KEY = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiOTNhZDY2MTE3ZGI1OWEwNjg2NzMzNTE0YTE4MDA2YWI4MWYyN2JiNzdkZWFmYTFlNjgzY2FjN2EyZGY3ZjFlNTM0OGEwNTljMTllNDg5MjkiLCJpYXQiOjE2NTg0NzMyNzEsIm5iZiI6MTY1ODQ3MzI3MSwiZXhwIjoxNjkwMDA5MjcxLCJzdWIiOiI5MDI0Iiwic2NvcGVzIjpbXX0.FZc2OriOgVxYJE4sXFhpd-bN2_gdNWt-Sk6t300aU5NraZ6v0y6O8uDDND4X3b69rYfePlfTIauCAAUsoHImMA";

    public static function getHttpResponse()
    {
        return Http::withOptions(['verify' => false])->get(self::BASE_URL, [
            'access_key' => self::ACCESS_KEY,
        ]);
    }

    public static function formatData(array $data): array
    {
        // aborting if api hits limit reached
        if (array_key_exists('message', $data))
            abort(500, $data['message']);

        $formattedData = array();

        foreach ($data as $key => $flight) {
            $departureTime = Carbon::parse($flight['departure']['scheduled']);
            $arrivalTime = Carbon::parse($flight['arrival']['scheduled']);

            $formattedData[] = [
                'departureTimeZone' => $flight['departure']['timezone'],
                'arrivalTimeZone' => $flight['arrival']['timezone'],
                'estimatedTime' => $arrivalTime->diff($departureTime)->format('%H:%I:%S'),
                'departureAirport' => $flight['departure']['airport'],
                'arrivalAirport' => $flight['arrival']['airport'],
                'flightDate' => $flight['flight_date'],
                'status' => $flight['flight_status'],
                'airline' => $flight['airline']['name'],
                'flightNo' => $flight['flight']['number'],
                'departureTime' => $flight['departure']['scheduled'],
                'arrivalTime' => $flight['arrival']['scheduled'],
            ];
        }

        // returning formatted array to save in database
        return $formattedData;
    }

    public static function store(array $data)
    {
        // here we store data in database
        foreach ($data as $key => $model) {
            Flight::firstOrCreate([
                'departureTimeZone' => $model['departureTimeZone'],
                'arrivalTimeZone' => $model['arrivalTimeZone'],
                'estimatedTime' => $model['estimatedTime'],
                'departureAirport' => $model['departureAirport'],
                'arrivalAirport' => $model['arrivalAirport'],
                'flightDate' => $model['flightDate'],
                'status' => $model['status'],
                'airline' => $model['airline'],
                'flightNo' => $model['flightNo'],
                'departureTime' => $model['departureTime'],
                'arrivalTime' => $model['arrivalTime'],
            ]);
        }
    }

    public static function execute()
    {
        // get http response
        $response = self::getHttpResponse();

        // early return if response failed or invalid access key
        if ($response->failed() || $response->serverError())
            abort(500, $response->json()['message']);

        // format data to store in database
        $data = self::formatData($response->json());

        // store in database
        self::store($data);
    }
}

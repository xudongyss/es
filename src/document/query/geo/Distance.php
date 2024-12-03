<?php

namespace xudongyss\es\document\query\geo;

use xudongyss\es\document\query\Query;

class Distance extends Query
{
    private $field;

    /**
     * 纬度
     */
    private $lat;

    /**
     * 经度
     */
    private $lon;

    private $distance;

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @param array|string $location [lon, lat] or 'lat,lon'
     * @return $this
     */
    public function setLocation(array|string $location)
    {
        if (is_string($location)) {
            list($this->lat, $this->lon) = explode(',', $location);

            return $this;
        }

        list($this->lon, $this->lat) = $location;

        return $this;
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    public function build()
    {
        return [
            'geo_distance' => [
                $this->field => [
                    'lat' => $this->lat,
                    'lon' => $this->lon,
                ],
                'distance' => $this->distance,
            ]
        ];
    }
}
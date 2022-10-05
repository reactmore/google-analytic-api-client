<?php

namespace Reactmore\GoogleAnalyticApi\Services;

use DateTimeInterface;
use Exception;
use Reactmore\GoogleAnalyticApi\Analytics;

/**
 * Class AbstractWpEndpoint
 * @package Reactmore\WordpressClient\Endpoint
 */
abstract class MakeQuery
{
    protected $service;

    public function __construct(Analytics $service)
    {
        $this->service = $service;
    }

    public function Query(string $viewId, DateTimeInterface $startDate, DateTimeInterface $endDate, string $metrics, array $others = [])
    {

        $result = $this->service->data_ga->get(
            "ga:{$viewId}",
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
            $metrics,
            $others,
        );

        while ($nextLink = $result->getNextLink()) {
            if (isset($others['max-results']) && count($result->rows) >= $others['max-results']) {
                break;
            }

            $options = [];

            parse_str(substr($nextLink, strpos($nextLink, '?') + 1), $options);

            $response = $this->service->data_ga->call('get', [$options], 'Google_Service_Analytics_GaData');

            if ($response->rows) {
                $result->rows = array_merge($result->rows, $response->rows);
            }

            $result->nextLink = $response->nextLink;
        }

        return $result;
    }
}

<?php

namespace Reactmore\GoogleAnalyticApi\Services;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Reactmore\GoogleAnalyticApi\Helpers\Period;
use Reactmore\GoogleAnalyticApi\Helpers\ResponseFormatter;

class Fetch extends MakeQuery
{

    public function __construct($credential, $view_id)
    {
        $this->service = $credential;
        $this->view_id = $view_id;

        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    public function fetchTotalVisitorsAndPageViews(Period $period)
    {
        try {
            $response = $this->performQuery(
                $period,
                'ga:users,ga:pageviews',
                ['dimensions' => 'ga:date'],
            );

            $data = array();
            foreach ($response->getRows() as $row) {

                $data[] = array(
                    'date'   => date("M-d", strtotime($row[0])),
                    'visitors'  => $row[1],
                    'pageViews'  => $row[2],
                );
            }

            return $data;
        } catch (Exception $e) {
            return ResponseFormatter::formatResponse([
                'error' => $e->getMessage()
            ], 400, 'failed');
        }
    }

    public function fetchMostVisitedPages(Period $period, int $maxResults = 20)
    {
        try {
            $response = $this->performQuery(
                $period,
                'ga:pageviews',
                [
                    'dimensions' => 'ga:pagePath,ga:pageTitle',
                    'sort' => '-ga:pageviews',
                    'max-results' => $maxResults,
                ]
            );

            $data = array();
            foreach ($response->getRows() as $row) {

                $data[] = array(
                    'url'   => $row[0],
                    'pageTitle'  => $row[1],
                    'pageViews'  => (int) $row[2],
                );
            }

            return $data;
        } catch (Exception $e) {
            return ResponseFormatter::formatResponse([
                'error' => $e->getMessage()
            ], 400, 'failed');
        }
    }

    public function fetchTopReferrers(Period $period, int $maxResults = 20)
    {
        try {
            $response = $this->performQuery(
                $period,
                'ga:pageviews',
                [
                    'dimensions' => 'ga:fullReferrer',
                    'sort' => '-ga:pageviews',
                    'max-results' => $maxResults,
                ]
            );

            $data = array();
            foreach ($response->getRows() as $row) {

                $data[] = array(
                    'url'   => $row[0],
                    'pageViews'  => (int) $row[1],
                );
            }

            return $data;
        } catch (Exception $e) {
            return ResponseFormatter::formatResponse([
                'error' => $e->getMessage()
            ], 400, 'failed');
        }
    }

    public function fetchUserTypes(Period $period)
    {
        try {
            $response = $this->performQuery(
                $period,
                'ga:sessions',
                [
                    'dimensions' => 'ga:userType'
                ]
            );

            $data = array();
            foreach ($response->getRows() as $row) {

                $data[] = array(
                    'type'   => $row[0],
                    'sessions'  => (int) $row[1],
                );
            }

            return $data;
        } catch (Exception $e) {
            return ResponseFormatter::formatResponse([
                'error' => $e->getMessage()
            ], 400, 'failed');
        }
    }

    public function fetchTopBrowsers(Period $period, int $maxResults = 10)
    {
        try {
            $response = $this->performQuery(
                $period,
                'ga:sessions',
                [
                    'dimensions' => 'ga:browser',
                    'sort' => '-ga:sessions',
                ]
            );

            $data = array();
            foreach ($response->getRows() as $row) {

                $data[] = array(
                    'browser'   => $row[0],
                    'sessions'  => (int) $row[1],
                );
            }


            return $data;

        } catch (Exception $e) {
            return ResponseFormatter::formatResponse([
                'error' => $e->getMessage()
            ], 400, 'failed');
        }
    }

    

    public function performQuery(Period $period, string $metrics, array $others = [])
    {
        return $this->Query(
            $this->view_id,
            $period->startDate,
            $period->endDate,
            $metrics,
            $others,
        );
    }
}

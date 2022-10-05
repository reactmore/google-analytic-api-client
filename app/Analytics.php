<?php

namespace Reactmore\GoogleAnalyticApi;

use Dotenv\Dotenv;
use Google\Client;
use Google\Service\Analytics as GA;
use Reactmore\GoogleAnalyticApi\Exceptions\InvalidConfiguration;
use Reactmore\GoogleAnalyticApi\Helpers\FileHelper;
use Reactmore\GoogleAnalyticApi\Helpers\Validations\ValidationHelper;
use Reactmore\GoogleAnalyticApi\Helpers\Validations\Validator;

class Analytics
{
    const DOT_ENV = '.env';
    protected $credential, $stage;

    public function __construct(array $data = [])
    {
        Validator::validateCredentialRequest($data);

        $this->setEnvironmentFile();
        $this->setCredential($data);
        $this->guardAgainstInvalidConfiguration($data);
    }

    private function setEnvironmentFile()
    {
        $envDirectory = FileHelper::getAbsolutePathOfAncestorFile(self::DOT_ENV);

        if (file_exists($envDirectory . '/' . self::DOT_ENV)) {
            $dotEnv = Dotenv::createMutable(FileHelper::getAbsolutePathOfAncestorFile(self::DOT_ENV));
            $dotEnv->load();
        }
    }

    private function setCredential($data)
    {
        if (empty($data['view_id'])) {
            $this->credential['view_id'] = isset($_ENV['VIEW_ID']) ? $_ENV['VIEW_ID'] : '';
        } else {
            $this->credential['view_id'] = $data['view_id'];
        }

        if (empty($data['service_credentials_json'])) {
            $this->credential['service_credentials_json'] = isset($_ENV['SERVICE_CREDENTIALS_JSON']) ? $_ENV['SERVICE_CREDENTIALS_JSON'] : '';
        } else {
            $this->credential['service_credentials_json'] = $data['service_credentials_json'];
        }
    }

    public function createAuthenticatedGoogleClient()
    {
        $client = new Client();
        $client->setScopes([
            GA::ANALYTICS_READONLY,
        ]);

        $client->setAuthConfig($this->credential['service_credentials_json']);
        $analytics = new GA($client);

        return $analytics;
    }

    public static function generateSign($username, $apikey, $sign)
    {
        return md5($username . $apikey . $sign);
    }

    public function Fetching()
    {
        return new \Reactmore\GoogleAnalyticApi\Services\Fetch($this->createAuthenticatedGoogleClient(), $this->credential['view_id']);
    }

    protected function guardAgainstInvalidConfiguration(): void
    {
        if (empty($this->credential['view_id'])) {
            throw InvalidConfiguration::viewIdNotSpecified();
        }

        if (is_array($this->credential['service_credentials_json'])) {
            return;
        }

        if (!file_exists($this->credential['service_credentials_json'])) {
            throw ValidationHelper::credentialsJsonDoesNotExist($this->credential['service_credentials_json']);
        }
    }
}

<?php

include('Config.php');

class GoogleAnalyticsRealTime extends Config
{
    public $client;
    public $service;
    public $params = [];
    const APPLICATION_NAME = 'RealTime - Tribuna Online';
    const SCOPES = [
        Google_Service_Analytics::ANALYTICS_READONLY,
        Google_Service_Analytics::ANALYTICS
    ];

    public function __construct () {
        parent::__construct();

        if(!$this->service instanceOf Google_Service_Analytics)
            $this->service = new Google_Service_Analytics($this->getClient());
    }

    public function getClient() {
        $this->client = new Google_Client();
        $this->client->useApplicationDefaultCredentials();
        $this->client->setApplicationName(self::APPLICATION_NAME);
        $this->client->setScopes(self::SCOPES);
        $this->client->setAccessType('offline');
        $this->client->setSubject('tribunaonline@tribuna-online.iam.gserviceaccount.com');

        return $this->client;
    }

    public function setParams($key, $value) {
        $this->params[$key] = $value;
    }

    public function getResults() {
        try {
            return $this->service->data_realtime->get(
                $this->ids,
                $this->metrics,
                $this->params
            );
        } catch (apiServiceException $e) {
            return $e->getMessage();
        }
    }

    public function getActiveUsers() {
        return $this->getResults()->totalsForAllResults['rt:activeUsers'];
    }

    public function clearParams($key = null) {
        if($key)
            unset($this->params[$key]);
        else
            $this->params = [];
    }

    public function getBatch() {
        $this->client->setUseBatch(true);
        $batch = new Google_Http_Batch($this->client);

        $urls = [
            '/ministerio-publico-pede-que-consumidores-denunciem-aumento-no-preco-dos-combustiveis',
            '/colisao-mata-motociclista-em-laranjeiras-na-serra',
            '/ressaca-do-mar-causa-destruicao-de-casas-na-ponta-da-fruta',
            '/juiz-barra-desfiliacao-e-psd-pede-mandato-de-presidente',
            'tribunaonline.com.br'
        ];

        foreach($urls as $url) {
            $batch->add($this->getResultsInBatch(['filters' => 'rt:pagePath=@' . $url]), $url);
        }

        return $batch->execute();
    }

    public function getResultsInBatch($params) {
        try {
            return $this->service->data_realtime->get(
                $this->ids,
                $this->metrics,
                $params
            );
        } catch (apiServiceException $e) {
            return $e->getMessage();
        }
    }
}
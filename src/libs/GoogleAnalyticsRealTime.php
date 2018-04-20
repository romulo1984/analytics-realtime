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

    public function getBatch($urls = []) {
        $this->client->setUseBatch(true);
        $batch = new Google_Http_Batch($this->client);

        $urls = [
            "22218" => "/wesley-safadao-diz-que-clipe-com-anitta-foi-trabalho-feito-com-atencao-e-swing",
            "22273" => "/nick-cave-and-the-bad-seeds-confirma-show-em-sao-paulo",
            "22274" => "/rapper-esta-escrevendo-livro-sobre-filosofia-e-se-comparou-a-hawking",
            "22275" => "/lady-gaga-vai-ajudar-criancas-a-terem-material-escolar-de-facil-acesso-nos-eua",
            "22387" => "/homem-joga-filha-de-seis-meses-de-telhado-em-protesto-contra-governo",
            "22393" => "/lula-estara-nas-eleicoes-preso-ou-solto-diz-dilma-nos-estados-unidos",
            "22395" => "/cresce-o-numero-de-partos-normais-realizados-no-espirito-santo",
            "22397" => "/estacao-de-bombeamento-falha-e-bairro-fica-alagado-em-vila-velha",
            "22402" => "/loja-e-roubada-pela-segunda-vez-em-menos-de-uma-semana-na-gloria",
            "22412" => "/janela-de-aviao-quebra-e-passageira-tem-parte-do-corpo-sugada",
            "22417" => "/objetos-de-lula-foram-furtados-do-carro-de-assessor",
            "22420" => "/sao-paulo-acerta-a-contratacao-do-meio-everton-ex-flamengo",
            "22422" => "/morre-a-ex-primeira-dama-dos-eua-barbara-bush-aos-92-anos",
            "22425" => "/leo-santana-reata-namoro-pela-2a-vez-com-lorena-improta",
            "22429" => "/policia-investiga-denuncia-de-abuso-sexual-nas-categorias-de-base-do-santos",
            "22432" => "/senado-aprova-projeto-que-obriga-escolas-a-combaterem-bullying",
            "22436" => "/tati-quebra-barraco-defende-tatuador-apos-erro",
            "22439" => "/susana-vieira-surpreende-e-fica-morena",
            "22441" => "/vagas-para-contratacao-imediata",
            "22443" => "/motoristas-ameacam-novos-protestos",
            "22447" => "/apos-quase-70-anos-familia-castro-vai-deixar-o-poder-em-cuba",
            "22448" => "/futebol-capixaba-pikachu-tem-o-poder-de-decidir-no-galo-da-vila",
            "22450" => "/revanche-dos-sonhos-no-caminho-do-capixaba-esquiva-falcao",
            "22453" => "/elas-dominam-o-juri-de-cannes",
            "22455" => "/viuva-diz-que-evita-ver-cenas-de-domingos-montagner",
            "22458" => "/campeoes-mundiais-as-selecoes-tem-medo-do-brasil-diz-coutinho",
            "22460" => "/campeoes-mundiais-precisamos-de-lideres-diz-ex-atacante-jairzinho",
            "22462" => "/motorista-de-aplicativo-tem-carro-recuperado-com-ajuda-de-taxista",
            "22467" => "/por-voces-valera-a-pena-morrer-diz-lula-a-militancia",
            "22468" => "/ivete-sangalo-faz-postagem-com-uma-das-filhas-no-colo-ta-puxado",
            "22470" => "/neymar-lamenta-volta-de-par-romantico-de-bruna-marquezine-em-novela",
            "22474" => "/vitimas-atropeladas-por-viatura-em-ponto-de-onibus-seguem-internadas",
            "22477" => "/balbuena-confirma-acerto-para-renovacao-de-contrato-com-o-corinthians",
            "22478" => "/jose-loreto-compartilha-foto-do-parto-de-debora-nascimento",
            "22479" => "/ex-professor-da-ufes-e-denunciado-por-falsificacao-de-documento",
            "22480" => "/palmeiras-contrata-empresa-de-investigacao-para-tentar-provar-interferencia-em-arbitragem",
            "22482" => "/entra-em-vigor-lei-que-aumenta-pena-para-quem-beber-e-dirigir",
            "22483" => "/david-copperfield-e-obrigado-a-revelar-segredo-de-magica-apos-acidente",
            "22484" => "/agentes-da-prf-salvam-vida-de-bebe-na-br-101",
            "22485" => "/placas-perdidas-na-enchente-devem-ser-registradas",
            "22486" => "/nem-quente-nem-frio",
            "22487" => "/justica-nega-liberdade-a-acusado-de-matar-medica",
            "22488" => "/futebol-capixaba-rio-branco-anuncia-zagueiro-revelado-no-vasco",
            "22489" => "/pescador-e-preso-suspeito-de-abusar-de-crianca-de-11-anos",
            "22491" => "/golpe-promete-recarga-de-graca-no-whatsapp",
            "22492" => "/cariacica-oferece-aulas-de-natacao-para-criancas-com-sindrome-de-down",
            "22493" => "/mais-de-5-900-vagas-para-ganhar-ate-12-mil-na-saude",
            "22494" => "/novo-porto-pode-gerar-mais-de-mil-empregos-em-aracruz",
            "22496" => "/ator-americano-descobre-musica-brasileira-com-seu-nome-e",
            "22497" => "/medico-e-preso-acusado-de-abusar-sexualmente-de-paciente-gravida",
            "22500" => "/gisele-buendchen-estrela-campanha-do-boticario",
            "22501" => "/vida-a-dois-numero-de-casamentos-no-estado-e-o-menor-em-6-anos",
            "22503" => "/ressaca-do-mar-causa-destruicao-de-casas-na-ponta-da-fruta",
            "22507" => "/ministerio-publico-pede-que-consumidores-denunciem-aumento-no-preco-dos-combustiveis",
            "22509" => "/torcida-do-flamengo-perde-a-paciencia-apos-novo-tropeco",
            "22511" => "/apos-tropeco-flamengo-segura-barbieri-mas-espera-opcao-certeira-para-tecnico",
            "22512" => "/colisao-mata-motociclista-em-laranjeiras-na-serra",
            "22513" => "/vila-velha-debaixo-d-agua",
            "22514" => "/nao-consegui-ainda-convencer-a-mim-mesmo-de-que-devo-ser-candidato-diz-barbosa",
            "22516" => "/motorista-tera-de-pagar-r-3-mil-a-motociclista-atingido-por-porta-de-carro",
            "22517" => "/stj-mantem-condenacao-de-jovem-que-matou-namorado-durante-ato-sexual",
            "22518" => "/assalto-em-onibus-termina-com-dois-mortos-e-cinco-feridos",
            "22521" => "/juiz-barra-desfiliacao-e-psd-pede-mandato-de-presidente",
            "22522" => "/vasco-e-goleado-pelo-racing-e-se-complica-na-libertadores",
            "22523" => "/naldo-celebra-nova-lua-de-mel-com-a-esposa",
            "22524" => "/brasileiro-e-deportado-dos-estados-unidos-apos-30-anos-vivendo-no-pais",
            "22525" => "/brasil-esta-a-um-empate-de-ganhar-a-copa-america-de-futebol-feminino",
            "22526" => "/justica-manda-ex-marido-pagar-pensao-a-animais-de-estimacao",
            "22527" => "/prefeito-demite-filho-que-cobrou-comissionados-em-eventos",
            "22528" => "/investigador-da-policia-civil-e-baleado-no-rosto",
        ];

        foreach($urls as $key => $url) {
            $batch->add($this->getResultsInBatch(['filters' => 'rt:pagePath=@' . $url]), $key);
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
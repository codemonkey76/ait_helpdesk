<?php

namespace App\Plivo;

use Plivo\RestClient as PlivoRestClient;

class Plivo extends PlivoRestClient
{
    protected string $auth_id;
    protected string $authToken;
    protected string $from;

    public function __construct(array $config)
    {
        $this->auth_id = $config['auth_id'];
        $this->authToken = $config['auth_token'];
        $this->from = $config['from_number'];

        parent::__construct($this->auth_id, $this->authToken);
    }

    public function from()
    {
        return $this->from;
    }

}

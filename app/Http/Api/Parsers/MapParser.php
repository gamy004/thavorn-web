<?php

namespace App\Http\Api\Parsers;

use App\Http\Api\Contracts\ParserInterface;

class MapParser extends BaseParser implements ParserInterface {

    protected $template = [
        self::PARAMS['MAP'] => []
    ];

    function __construct()
    {
        parent::__construct();
    }

    public function parse()
    {
        if (
            isset($this->options[self::PARAMS['MAP']])
        ) {
            $this->result[self::PARAMS['MAP']] = $this->options[self::PARAMS['MAP']];
        }

        return $this;
    }
}
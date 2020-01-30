<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Api\Parser;
use InvalidArgumentException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParserTest extends TestCase
{
    protected $parser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->parser = app(Parser::class);
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetResult()
    {
        $result = $this->parser->getTemplate();

        $this->assertArrayHasKey('filter_groups', $result);
        $this->assertArrayHasKey('includes', $result);
        $this->assertArrayHasKey('modes', $result);
        $this->assertArrayHasKey('sort', $result);
        $this->assertArrayHasKey('page', $result);
        $this->assertArrayHasKey('limit', $result);
        $this->assertArrayHasKey('map', $result);
    }

    /**
     * @test
     * Test parse the request form data
     *
     * @return void
     */
    public function canParseRequestFilterGroups()
    {
        $this->parser->parse([
            "filter_groups" => [
                [
                    "filters" => [
                        [
                            "key" => "isAgent",
                            "value" => 1,
                        ],
                        [
                            "key" => "class_id",
                            "value" => 51,
                            "operator" => "eq"
                        ]
                    ],
                ],
            ]
        ]);
        
        $result = $this->parser->result();

        $filter_group = $result['filter_groups'][0];

        $this->assertArrayHasKey('filters', $filter_group);
        
        $this->assertCount(2, $filter_group);

        $filter = $filter_group['filters'][0];

        $this->assertArrayHasKey('key', $filter);
        $this->assertArrayHasKey('value', $filter);

        $this->assertArrayHasKey('operator', $filter);
        $this->assertEquals('eq', $filter['operator']); // default to eq

        $this->assertArrayHasKey('not', $filter);
        $this->assertFalse($filter['not']); // default to false
    }

    /**
     * @test
     * Test parse the request form data
     *
     * @return void
     */
    public function canParseRequestIncludes()
    {
        $this->parser->parse([
            "includes" => ["roles", "jobs:id"]
        ]);

        $result = $this->parser->result();

        $includes = $result["includes"];
        $this->assertContains('roles', $includes);

        $this->assertContains('jobs', $includes);
        
        $this->assertArrayHasKey('modes', $result);
        
        $modes = $result['modes'];

        $this->assertCount(2, $modes);

        $this->assertStringContainsString('embbed', $modes['roles']);
        
        $this->assertStringContainsString('id', $modes['jobs']);
    }

    /**
     * @test
     * Test parse the request form data
     *
     * @return void
     */
    public function canSortIdAscByDefault()
    {
        $this->parser->parse([
            "filter_groups" => [
                [
                    "filters" => [
                        [
                            "key" => "isAgent",
                            "value" => 1,
                        ]
                    ],
                ],
            ],
            "includes" => ["roles"]
        ]);

        $result = $this->parser->result();

        $sort = $result["sort"];
        
        $this->assertCount(1, $sort);
        
        $sort_item = $sort[0];

        $this->assertArrayHasKey('key', $sort_item);
        $this->assertArrayHasKey('direction', $sort_item);
    }

    /**
     * @test
     * Test parse the request form data
     *
     * @return void
     */
    public function canSortByDesc()
    {
        $this->parser->parse([
            "filter_groups" => [
                [
                    "filters" => [
                        [
                            "key" => "isAgent",
                            "value" => 1,
                        ]
                    ],
                ],
            ],
            "includes" => ["roles"],
            "sort" => ["-name", "age-"]
        ]);

        $result = $this->parser->result();

        $sort = $result["sort"];
        
        $sort_name = $sort[0];
        $sort_age = $sort[1];

        $this->assertEquals('name', $sort_name["key"]);
        $this->assertEquals('desc', $sort_name["direction"]);

        $this->assertEquals('age', $sort_age["key"]);
        $this->assertEquals('desc', $sort_age["direction"]);
    }

    /**
     * @test
     * Test parse the request form data
     *
     * @return void
     */
    public function canGetPageAndLimit()
    {
        $page = 5;
        $limit = 20;

        $this->parser->parse(compact('page', 'limit'));

        $result = $this->parser->result();

        $this->assertEquals($page, $result["page"]);
        $this->assertEquals($limit, $result["limit"]);
    }

    /**
     * @test
     * Test parse the request form data
     *
     * @return void
     */
    public function cannotGetPageWithoutLimit()
    {
        $this->expectException(InvalidArgumentException::class);

        $page = 5;

        $this->parser->parse(compact('page'));
    }
}

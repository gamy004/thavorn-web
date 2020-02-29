<?php

namespace Tests\Unit;

use App\IOCs\DBCol;
use Tests\TestCase;
use App\Models\Pawn;
use App\Models\User;
use App\Http\Api\Parser;
use App\Models\PawnItem;
use App\Http\Api\Parsers\BaseParser;
use App\Http\Api\Providers\PawnUserItemApi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PawnUserItemApiTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->api = app(PawnUserItemApi::class);
        $this->parser = app(Parser::class);
    }

    /**
     * A test to get user.
     *
     * @return void
     */
    public function testGetPawnUser()
    {
        $count = 2;
        $key = 'pawn_items';
        $pawn = factory(Pawn::class)->create();
        factory(PawnItem::class, $count)->create([
            Pawn::FK => $pawn->id
        ]);
        
        $data = $this->api->index()->get($key);

        $this->assertCount($count, $data);
    }

    /**
     * A test to search items by id card of user.
     *
     * @return void
     */
    public function testSearchUserByIdCard()
    {
        $test_count = 2;
        $count = 1;
        $key = 'pawn_items';
        $pawn1 = factory(Pawn::class)->create();
        factory(PawnItem::class, $count)->create([
            Pawn::FK => $pawn1->id
        ]);
        

        $pawn2 = factory(Pawn::class)->create();
        $user2 = $pawn2->user;
        factory(PawnItem::class, $test_count)->create([
            Pawn::FK => $pawn2->id
        ]);
        
        $this->parser->parse([
            "search" => [
                "keyword" => $user2->{DBCol::IDENTITY_CARD_ID},
                "fields" => [
                    DBCol::IDENTITY_CARD_ID,
                    DBCol::PAWN_NO
                ] // If not specify, it wil not search search
            ],
        ]);
        
        $result = $this->api->index()->get($key);

        $this->assertCount($test_count, $result);
    }

    /**
     * A test to search items by pawn no of pawn.
     *
     * @return void
     */
    public function testSearchUserByPawnNo()
    {
        $test_count = 1;
        $count = 2;
        $key = 'pawn_items';
        $pawn1 = factory(Pawn::class)->create();
        factory(PawnItem::class, $test_count)->create([
            Pawn::FK => $pawn1->id
        ]);
        

        $pawn2 = factory(Pawn::class)->create();
        $user2 = $pawn2->user;
        factory(PawnItem::class, $count)->create([
            Pawn::FK => $pawn2->id
        ]);
        
        $this->parser->parse([
            "search" => [
                "keyword" => $pawn1->{DBCol::PAWN_NO},
                "fields" => [
                    DBCol::IDENTITY_CARD_ID,
                    DBCol::PAWN_NO
                ] // If not specify, it wil not search search
            ],
        ]);
        
        $result = $this->api->index()->get($key);

        $this->assertCount($test_count, $result);
    }
}

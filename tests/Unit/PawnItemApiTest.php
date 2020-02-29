<?php

namespace Tests\Unit;

use App\IOCs\DBCol;
use Tests\TestCase;
use App\Models\Pawn;
use App\Models\PawnItem;
use App\Models\User;
use App\Http\Api\Parser;
use App\Http\Api\Providers\PawnItemApi;
use App\Http\Api\Parsers\BaseParser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PawnItemApiTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->api = app(PawnItemApi::class);
        $this->parser = app(Parser::class);
    }

    /**
     * A test to get pawn item.
     *
     * @return void
     */
    public function testGetPawnItems()
    {
        $count = 5;
        $key = 'pawn_items';

        factory(PawnItem::class, $count)->create();
        
        $data = $this->api->get($key);

        $this->assertArrayHasKey($key, $data->toArray());
        $this->assertCount($count, $data->get($key));
    }
    
    /**
     * A test to create pawn item.
     *
     * @return void
     */
    public function testCreatePawnItem()
    {
        $data = factory(PawnItem::class)->raw();

        $pawn_item = $this->api->store($data)->first();

        $this->assertDatabaseHas(
            $pawn_item->getModel()->getTable(),
            $pawn_item->toArray()
        );
    }

    /**
     * A test to update pawn item.
     *
     * @return void
     */
    public function testUpdatePawnItem()
    {
        $pawn_item = factory(PawnItem::class)->create();

        $old_data = $pawn_item->toArray();
        $new_data = factory(PawnItem::class)->raw();

        $new_pawn_item = $this->api->update($pawn_item, $new_data)->first();

        $this->assertDatabaseMissing(
            $pawn_item->getModel()->getTable(),
            $old_data
        );

        $this->assertDatabaseHas(
            $new_pawn_item->getModel()->getTable(),
            $new_pawn_item->toArray()
        );
    }

    /**
     * A test to delete pawn item.
     *
     * @return void
     */
    public function testDestroyPawnItem()
    {
        $pawn_item = factory(PawnItem::class)->create();

        $message = $this->api->destroy($pawn_item);

        $pawn_items_count = PawnItem::where(DBCol::ID, $pawn_item->{DBCol::ID})->count();

        $this->assertEquals(0, $pawn_items_count);

        $this->assertSoftDeleted(
            $pawn_item->getModel()->getTable(),
            $pawn_item->toArray()
        );
    }
}

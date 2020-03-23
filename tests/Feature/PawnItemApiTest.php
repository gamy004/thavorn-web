<?php

namespace Tests\Feature;

use App\IOCs\DBCol;
use Tests\TestCase;
use App\Models\PawnItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PawnItemApiTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
    }
    
    protected function dumpPawnItem()
    {
        $dump = factory(PawnItem::class)->create();

        $data = factory(PawnItem::class)->raw();
        
        $data['pawn_id'] = $dump['pawn_id'];
        $data['item_category_id'] = $dump['item_category_id'];
        $data['item_damage_id'] = $dump['item_damage_id'];

        return $data;
    }
    /**
     * A test to create pawn item.
     *
     * @return void
     */
    public function testStorePawnItem()
    {
        $data = $this->dumpPawnItem();

        $response = $this->json('POST', '/api/pawn_items', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'pawn_items' => true
            ]);
    }

    /**
     * A fail test to create pawn item when no item_weight given.
     *
     * @return void
     */
    public function testStorePawnItemFailWhenNoItemWeight()
    {
        $data = $this->dumpPawnItem();

        unset($data['item_weight']);
        
        $response = $this->json('POST', '/api/pawn_items', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['item_weight']);
    }

    /**
     * A fail test to create pawn item when no item_value given.
     *
     * @return void
     */
    public function testStorePawnItemFailWhenNoItemValue()
    {
        $data = $this->dumpPawnItem();

        unset($data['item_value']);
        
        $response = $this->json('POST', '/api/pawn_items', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['item_value']);
    }

    /**
     * A fail test to create pawn item when no pawn_id given.
     *
     * @return void
     */
    public function testStorePawnItemFailWhenNoPawnId()
    {
        $data = $this->dumpPawnItem();

        unset($data['pawn_id']);
        
        $response = $this->json('POST', '/api/pawn_items', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['pawn_id']);
    }

    /**
     * A fail test to create pawn item when no item_category_id given.
     *
     * @return void
     */
    public function testStorePawnItemFailWhenGivenFakeItemCategoryId()
    {
        $data = $this->dumpPawnItem();

        $data['item_category_id'] = 99999; // fake
        
        $response = $this->json('POST', '/api/pawn_items', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['item_category_id']);
    }

    /**
     * A fail test to create pawn item when no item_damage_id given.
     *
     * @return void
     */
    public function testStorePawnItemFailWhenGivenFakeItemDamageId()
    {
        $data = $this->dumpPawnItem();

        $data['item_damage_id'] = 99999; // fake
        
        $response = $this->json('POST', '/api/pawn_items', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['item_damage_id']);
    }

    // /**
    //  * A test to update pawn item.
    //  *
    //  * @return void
    //  */
    // public function testUpdatePawnItem()
    // {
    //     $pawn_item = factory(PawnItem::class)->create();

    //     $old_data = $pawn_item->toArray();
    //     $new_data = factory(PawnItem::class)->raw();

    //     $new_pawn_item = $this->api->update($pawn_item, $new_data)->first();

    //     $this->assertDatabaseMissing(
    //         $pawn_item->getModel()->getTable(),
    //         $old_data
    //     );

    //     $this->assertDatabaseHas(
    //         $new_pawn_item->getModel()->getTable(),
    //         $new_pawn_item->toArray()
    //     );
    // }

    // /**
    //  * A test to delete pawn item.
    //  *
    //  * @return void
    //  */
    // public function testDestroyPawnItem()
    // {
    //     $pawn_item = factory(PawnItem::class)->create();

    //     $message = $this->api->destroy($pawn_item);

    //     $pawn_items_count = PawnItem::where(DBCol::ID, $pawn_item->{DBCol::ID})->count();

    //     $this->assertEquals(0, $pawn_items_count);

    //     $this->assertSoftDeleted(
    //         $pawn_item->getModel()->getTable(),
    //         $pawn_item->toArray()
    //     );
    // }
}

<?php

namespace Tests\Unit;

use App\IOCs\DBCol;
use Tests\TestCase;
use App\Models\Pawn;
use App\Models\Role;
use App\Models\User;
use App\Http\Api\Parser;
use App\Models\PawnItem;
use Illuminate\Support\Arr;
use App\Http\Api\Providers\PawnApi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PawnApiTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->api = app(PawnApi::class);
        $this->parser = app(Parser::class);
    }
    
    /**
     * A test to create pawn.
     *
     * @return void
     */
    public function testCreatePawn()
    {
        $user_data = factory(User::class)->raw();

        $pawn_data = factory(Pawn::class)->raw([
            "customer_id" => null
        ]);

        $pawn_items = factory(PawnItem::class, 2)->raw([
            Pawn::FK => null
        ]);

        $data = array_merge(
            ["user" => $user_data],
            [
                DBCol::PAWN_NO => $pawn_data[DBCol::PAWN_NO],
                DBCol::INTEREST_RATE => $pawn_data[DBCol::INTEREST_RATE]
            ],
            ["pawn_items" => $pawn_items]
        );

        $pawn = $this->api->store($data)->first();

        // check new pawn was in a database
        $this->assertDatabaseHas(
            $pawn->getModel()->getTable(),
            $pawn->toArray()
        );

        // check new pawn items equaled the number of pawn items in created from the factory
        $this->assertCount(2, $pawn->pawn_items);

        $customer_role = Role::customer();

        $pawn_customer = User::find($pawn->customer_id);

        // Check if pawn's user is customer
        $this->assertEquals(
            $pawn_customer->{Role::FK},
            $customer_role->{DBCol::ID}
        );
    }

    /**
     * A test to update pawn with new user.
     *
     * @return void
     */
    public function testUpdatePawnWithNewUser()
    {
        $pawn = factory(Pawn::class)->create();

        $pawn->load("user");

        $old_customer = $pawn->user->toArray();

        unset($pawn["user"]);

        $old_pawn_data = $pawn->toArray();

        $new_user_data = factory(User::class)->raw();
        $new_pawn_data = factory(Pawn::class)->raw([
            "customer_id" => null
        ]);

        $new_data = array_merge(
            ["user" => $new_user_data],
            [DBCol::INTEREST_RATE => $new_pawn_data[DBCol::INTEREST_RATE]]
        );

        $pawn = $this->api->update($pawn, $new_data)->first();

        $this->assertDatabaseMissing(
            $pawn->getModel()->getTable(),
            $old_pawn_data
        );

        $this->assertDatabaseHas(
            $pawn->getModel()->getTable(),
            $pawn->toArray()
        );

        $this->assertTrue(
            $pawn->{Pawn::USER_FK} != $old_customer[DBCol::ID]
        );
    }

    /**
     * A test to update pawn with the same user.
     *
     * @return void
     */
    public function testUpdatePawnWithSameUser()
    {
        $pawn = factory(Pawn::class)->create();

        $pawn->load("user");

        $old_customer = $pawn->user->toArray();

        unset($pawn["user"]);

        $old_pawn_data = $pawn->toArray();

        $new_pawn_data = factory(Pawn::class)->raw([
            "customer_id" => null
        ]);

        $new_data = array_merge(
            ["user" => $old_customer],
            [DBCol::INTEREST_RATE => $new_pawn_data[DBCol::INTEREST_RATE]]
        );

        $pawn = $this->api->update($pawn, $new_data)->first();

        $this->assertDatabaseMissing(
            $pawn->getModel()->getTable(),
            $old_pawn_data
        );

        $this->assertDatabaseHas(
            $pawn->getModel()->getTable(),
            $pawn->toArray()
        );

        $this->assertEquals(
            $pawn->{Pawn::USER_FK},
            $old_customer[DBCol::ID]
        );
    }

    /**
     * A test to update pawn with new item.
     *
     * @return void
     */
    public function testUpdatePawnWithNewItem()
    {
        $pawn = factory(Pawn::class)->create();


        $old_items_count = $pawn->pawn_items()->count();


        $old_pawn_data = $pawn->toArray();

        $new_pawn_items_data = factory(PawnItem::class, 2)->raw([
            Pawn::FK => null
        ]);

        $new_data = array_merge(
            ["pawn_items" => $new_pawn_items_data],
            $old_pawn_data
        );

        $pawn = $this->api->update($pawn, $new_data)->first();

        $new_items_count = $pawn->pawn_items()->count();

        // check new items count equal the number in the factory function
        $this->assertEquals(2, $new_items_count);

        // old and new count must be different
        $this->assertTrue(
            $old_items_count != $new_items_count
        );
    }

    /**
     * A test to update pawn with the same item.
     *
     * @return void
     */
    public function testUpdatePawnWithSameItem()
    {
        $pawn = factory(Pawn::class)->create();

        $new_pawn_items_data = factory(PawnItem::class, 2)->create([
            Pawn::FK => $pawn->{DBCol::ID}
        ]);

        $old_items_count = $pawn->pawn_items()->count();
        $old_items_ids = $pawn->pawn_items->pluck(DBCol::ID)->toArray();
        $old_pawn_data = $pawn->toArray();

        $new_data = array_merge(
            ["pawn_items" => $new_pawn_items_data->toArray()],
            $old_pawn_data
        );

        $pawn = $this->api->update($pawn, $new_data)->first();

        $new_items_count = $pawn->pawn_items()->count();
        $new_items_ids = $pawn->pawn_items->pluck(DBCol::ID)->toArray();

        // check new items count must equal the number in the factory function
        $this->assertEquals(2, $new_items_count);

        // check new and old ids must be the same
        $this->assertEquals($old_items_ids, $new_items_ids);

        // old and new count must be the same number
        $this->assertTrue(
            $old_items_count === $new_items_count
        );
    }

    /**
     * A test to create pawn items
     * 
     * @return void
     */
    public function testCreatePawnItems()
    {
        $pawn = factory(Pawn::class)->create();
        
        $pawn_items = factory(PawnItem::class, 2)->raw();
        
        $pawn = $this->api->updateItems($pawn, compact('pawn_items'));

        $pawn_items = $pawn->pawn_items;

        $this->assertCount(2, $pawn_items);
    }

    /**
     * A test to update pawn items
     * 
     * @return void
     */
    public function testUpdatePawnItems()
    {
        $pawn = factory(Pawn::class)->create();
        
        $old_pawn_items = factory(PawnItem::class, 2)->create([
            Pawn::FK => $pawn->{DBCol::ID}
        ]);

        $new_pawn_items = factory(PawnItem::class, 2)->raw([
            Pawn::FK => null
        ]);
        
        $all_pawn_items = array_merge(
            $old_pawn_items->toArray(),
            $new_pawn_items
        );
        
        $pawn = $this->api->updateItems($pawn, [
            "pawn_items" => $all_pawn_items
        ]);

        $pawn_items = $pawn->pawn_items;

        $all_pawn_item_ids = $pawn_items->pluck(DBCol::ID)->toArray();

        $this->assertCount(4, $pawn_items);

        // assert the old item id still in the loaded items
        $old_pawn_items->each(
            function($pawn_item) use ($all_pawn_item_ids) {
                $this->assertContains($pawn_item->{DBCol::ID}, $all_pawn_item_ids);
            }
        );

        // assert the pawn id is the same in the loaded items
        $pawn_items->each(
            function($pawn_item) use ($pawn) {
                $this->assertEquals($pawn->{DBCol::ID}, $pawn_item->{Pawn::FK});
            }
        );
    }

    /**
     * A test to delete pawn.
     *
     * @return void
     */
    public function testDestroyPawn()
    {
        $pawn = factory(Pawn::class)->create();

        $old_pawn_items = factory(PawnItem::class, 2)->create([
            Pawn::FK => $pawn->{DBCol::ID}
        ]);
            
        $message = $this->api->destroy($pawn);

        $pawn_items_count = PawnItem::where(Pawn::FK, $pawn->{DBCol::ID})->count();

        $this->assertEquals(0, $pawn_items_count);
        
        $this->assertSoftDeleted(
            $pawn->getModel()->getTable(),
            $pawn->toArray()
        );
    }
}

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

    // /**
    //  * A test to get user.
    //  *
    //  * @return void
    //  */
    // public function testGetUser()
    // {
    //     $count = 2;
    //     $key = 'users';

    //     $user_data = factory(User::class, $count)->create();
        
    //     $users = $this->api->get($key);

    //     $this->assertArrayHasKey($key, $users->toArray());
    //     $this->assertCount($count, $users->get($key));
    // }

    // /**
    //  * A test to get user by id.
    //  *
    //  * @return void
    //  */
    // public function testGetUserById()
    // {
    //     $count = 2;
    //     $key = 'users';

    //     $user_data = factory(User::class, $count)->create();

    //     $user_ids = $user_data->pluck(DBCol::ID)->toArray();

    //     factory(User::class)->create(); // another user who not has the matched

    //     $this->parser->parse([
    //         "filters" => [
    //             [
    //                 "key" => DBCol::ID,
    //                 "value" => $user_ids,
    //                 "operator" => "in"
    //             ]
    //         ],
    //     ]);
        
    //     $users = $this->api->get($key);
    //     $result = $users->get($key);

    //     $this->assertCount($count, $result);

    //     $result->each(
    //         function($user) use ($user_ids) {
    //             $this->assertContains(
    //                 $user->{DBCol::ID}, $user_ids
    //             );
    //         }
    //     );
    // }

    // /**
    //  * A test to search user by first_name.
    //  *
    //  * @return void
    //  */
    // public function testSearchUserByFirstName()
    // {
    //     $count = 2;
    //     $test_first_name = "TestFirstName";
    //     $key = 'users';

    //     factory(User::class, $count)->create();

    //     $searched_user = factory(User::class)->create([
    //         DBCol::FIRST_NAME => $test_first_name
    //     ]); // another user who not has the matched name

    //     $this->parser->parse([
    //         "search" => [
    //             "keyword" => $searched_user->{DBCol::FIRST_NAME},
    //             "fields" => [
    //                 DBCol::FIRST_NAME
    //             ] // If not specify, it wil not search search
    //         ],
    //     ]);
        
    //     $users = $this->api->get($key);
    //     $result = $users->get($key);
    //     $user = $result->first();

    //     $this->assertCount(1, $result);
    //     $this->assertEquals($user->{DBCol::FIRST_NAME}, $test_first_name);
    // }

    // /**
    //  * A test to create user.
    //  *
    //  * @return void
    //  */
    // public function testGetUserWithRole()
    // {
    //     $this->parser->parse([
    //         "includes" => ["role"],
    //     ]);

    //     $user_data = factory(User::class)->create();
        
    //     $usersWithRole = $this->api->get('users');
        
    //     $userWithRole = $usersWithRole->get('users')->first();

    //     $this->assertArrayHasKey('role', $userWithRole->getRelations());
    //     $this->assertInstanceOf(Role::class, $userWithRole->role);
    // }
    
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

        $data = array_merge(
            ["user" => $user_data],
            [DBCol::INTEREST_RATE => $pawn_data[DBCol::INTEREST_RATE]]
        );

        $pawn = $this->api->store($data)->first();

        $this->assertDatabaseHas(
            $pawn->getModel()->getTable(),
            $pawn->toArray()
        );

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

    // /**
    //  * A test to delete user.
    //  *
    //  * @return void
    //  */
    // public function testDestroyPawn()
    // {
    //     $user = factory(User::class)->create();

    //     $message = $this->api->destroy($user);

    //     $this->assertSoftDeleted(
    //         $user->getModel()->getTable(),
    //         $user->toArray()
    //     );
    // }
}

<?php

namespace Tests\Unit;

use App\IOCs\DBCol;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Http\Api\Parser;
use App\Http\Api\Providers\UserApi;
use App\Http\Api\Parsers\BaseParser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->api = app(UserApi::class);
        $this->parser = app(Parser::class);
    }

    /**
     * A test to get user.
     *
     * @return void
     */
    public function testGetUser()
    {
        $count = 2;
        $key = 'users';

        $user_data = factory(User::class, $count)->create();
        
        $users = $this->api->get($key);

        $this->assertArrayHasKey($key, $users->toArray());
        $this->assertCount($count, $users->get($key));
    }

    /**
     * A test to get user by id.
     *
     * @return void
     */
    public function testGetUserById()
    {
        $count = 2;
        $key = 'users';

        $user_data = factory(User::class, $count)->create();

        $user_ids = $user_data->pluck(DBCol::ID)->toArray();

        factory(User::class)->create(); // another user who not has the matched

        $this->parser->parse([
            "filters" => [
                [
                    "key" => DBCol::ID,
                    "value" => $user_ids,
                    "operator" => "in"
                ]
            ],
        ]);
        
        $users = $this->api->get($key);
        $result = $users->get($key);

        $this->assertCount($count, $result);

        $result->each(
            function($user) use ($user_ids) {
                $this->assertContains(
                    $user->{DBCol::ID}, $user_ids
                );
            }
        );
    }

    /**
     * A test to search user by first_name.
     *
     * @return void
     */
    public function testSearchUserByFirstName()
    {
        $count = 2;
        $test_first_name = "TestFirstName";
        $key = 'users';

        factory(User::class, $count)->create();

        $searched_user = factory(User::class)->create([
            DBCol::FIRST_NAME => $test_first_name
        ]); // another user who not has the matched name

        $this->parser->parse([
            "search" => [
                "keyword" => $searched_user->{DBCol::FIRST_NAME},
                "fields" => [
                    DBCol::FIRST_NAME
                ] // If not specify, it wil not search search
            ],
        ]);
        
        $users = $this->api->get($key);
        $result = $users->get($key);
        $user = $result->first();

        $this->assertCount(1, $result);
        $this->assertEquals($user->{DBCol::FIRST_NAME}, $test_first_name);
    }

    /**
     * A test to create user.
     *
     * @return void
     */
    public function testGetUserWithRole()
    {
        $this->parser->parse([
            "includes" => ["role"],
        ]);

        $user_data = factory(User::class)->create();
        
        $usersWithRole = $this->api->get('users');
        
        $userWithRole = $usersWithRole->get('users')->first();

        $this->assertArrayHasKey('role', $userWithRole->getRelations());
        $this->assertInstanceOf(Role::class, $userWithRole->role);
    }
    
    /**
     * A test to create user.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $user_data = factory(User::class)->raw();

        $user = $this->api->store($user_data)->first();

        $this->assertDatabaseHas(
            $user->getModel()->getTable(),
            $user->toArray()
        );
    }

    /**
     * A test to update user.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = factory(User::class)->create();

        $old_data = $user->toArray();
        $new_data = factory(User::class)->raw();

        $user = $this->api->update($user, $new_data)->first();

        $this->assertDatabaseMissing(
            $user->getModel()->getTable(),
            $old_data
        );

        $this->assertDatabaseHas(
            $user->getModel()->getTable(),
            $user->toArray()
        );
    }

    /**
     * A test to delete user.
     *
     * @return void
     */
    public function testDestroyUser()
    {
        $user = factory(User::class)->create();

        $message = $this->api->destroy($user);

        $this->assertSoftDeleted(
            $user->getModel()->getTable(),
            $user->toArray()
        );
    }
}

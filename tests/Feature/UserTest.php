<?php



use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);



// Этот трейт очищает базу перед каждым тестом
uses(RefreshDatabase::class);

it('создает пользователя в базе данных', function () {
    $user = User::create([
        'name' => 'Ivan',
        'email' => 'ivan@example.com',
        'password' => bcrypt('password'),
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'ivan@example.com',
    ]);
});


});

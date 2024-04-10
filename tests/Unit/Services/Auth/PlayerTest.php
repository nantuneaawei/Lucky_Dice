<?php

namespace Tests\Unit\Services\Auth;

use App\Repositories\Mydb\Player as PlayerReositories;
use App\Repositories\RedisRepository as RedisRepositories;
use App\Services\Auth\Player as PlayerServices;
use App\Services\SessionService;
use Mockery;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    private $oPlayerService;
    private $oRedisRepository;
    private $oPlayerRepository;
    private $oSessionService;

    public function setUp(): void
    {
        parent::setUp();

        $this->oRedisRepository = Mockery::mock(RedisRepositories::class);
        $this->oPlayerRepository = Mockery::mock(PlayerReositories::class);
        $this->oSessionService = Mockery::mock(SessionService::class);

        $this->oPlayerService = new PlayerServices($this->oPlayerRepository, $this->oRedisRepository, $this->oSessionService);
    }

    /**
     * testLoginPlayerSuccess
     *
     * @group player1
     * @return void
     */
    public function testLoginPlayerSuccess()
    {
        $aPlayerData = [
            'id' => 1,
            'username' => 'test',
            'email' => 'test@example.com',
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
        ];

        $this->oSessionService->shouldReceive('put')->with('user_id', $aPlayerData['id']);

        $this->oSessionService->shouldReceive('put')->with('user_name', $aPlayerData['username']);

        $this->oPlayerRepository->shouldReceive('findMemberByEmail')->with('test@example.com')->andReturn($aPlayerData);

        $this->oRedisRepository->shouldReceive('storeUIDs')->once()->with($aPlayerData['id'], Mockery::type('array'));

        $aResult = $this->oPlayerService->loginPlayer([
            'email' => $aPlayerData['email'],
            'password' => '12345678',
        ]);

        $this->assertTrue($aResult['state']);
        $this->assertEquals('登入成功!', $aResult['message']);
    }

    /**
     * testLoginPlayerWithWrongPassword
     *
     * @group player
     * @return void
     */
    public function testLoginPlayerWithWrongPassword()
    {
        $aPlayerData = [
            'id' => 1,
            'email' => 'test@example.com',
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
        ];

        $this->oPlayerRepository->shouldReceive('findMemberByEmail')->with('test@example.com')->andReturn($aPlayerData);

        $aResult = $this->oPlayerService->loginPlayer([
            'email' => $aPlayerData['email'],
            'password' => '98765432',
        ]);

        $this->assertFalse($aResult['state']);
        $this->assertEquals('密碼錯誤!', $aResult['message']);
    }

    /**
     * testLoginPlayerWithNonExistentEmail
     *
     * @group player
     * @return void
     */
    public function testLoginPlayerWithNonExistentEmail()
    {
        $this->oPlayerRepository->shouldReceive('findMemberByEmail')->with('nonexistent@example.com')->andReturn(null);

        $aResult = $this->oPlayerService->loginPlayer([
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        $this->assertFalse($aResult['state']);
        $this->assertEquals('帳號不存在!', $aResult['message']);
    }
}

<?php

namespace Tests\Unit\Services\Auth;

use App\Repositories\Mydb\Player as PlayerReositories;
use App\Repositories\RedisRepository as RedisRepositories;
use App\Services\Auth\Player as PlayerServices;
use App\Services\CookieService;
use App\Services\SessionService;
use App\Services\UIDService;
use Mockery;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    private $oPlayerService;
    private $oRedisRepository;
    private $oPlayerRepository;
    private $oSessionService;
    private $oCookieService;
    private $oUIDService;

    public function setUp(): void
    {
        parent::setUp();

        $this->oRedisRepository = Mockery::mock(RedisRepositories::class);
        $this->oPlayerRepository = Mockery::mock(PlayerReositories::class);
        $this->oSessionService = Mockery::mock(SessionService::class);
        $this->oCookieService = Mockery::mock(CookieService::class);
        $this->oUIDService = Mockery::mock(UidService::class);

        $this->oPlayerService = new PlayerServices($this->oPlayerRepository, $this->oRedisRepository, $this->oSessionService, $this->oCookieService, $this->oUIDService);
    }
    
    /**
     * testRegisterResult
     *
     * @group player
     * @return void
     */
    public function testRegisterResult()
    {
        $aResultTrue = $this->oPlayerService->registerResult(true);

        $this->assertEquals('註冊成功', $aResultTrue['message']);

        $aResultFalse = $this->oPlayerService->registerResult(false);

        $this->assertEquals('註冊失敗', $aResultFalse['message']);
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
            'balance' => 100,
        ];

        $aUID = [
            '1234567890',
            'abcdefghijklm',
        ];

        $this->oUIDService->shouldReceive('generateUID')
            ->andReturn($aUID);

        $this->oSessionService->shouldReceive('put')
            ->with('user_id', $aPlayerData['id'])
            ->once();
        $this->oSessionService->shouldReceive('put')
            ->with('user_name', $aPlayerData['username'])
            ->once();

        $this->oCookieService->shouldReceive('put')
            ->with('uid1', $aUID[0], Mockery::type('int'))
            ->once();
        $this->oCookieService->shouldReceive('put')
            ->with('uid2', $aUID[1], Mockery::type('int'))
            ->once();

        $this->oPlayerRepository->shouldReceive('findMemberByEmail')
            ->with('test@example.com')
            ->andReturn($aPlayerData);
        $this->oRedisRepository->shouldReceive('storeUIDs')
            ->once()
            ->with($aPlayerData['id'], Mockery::type('array'));

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

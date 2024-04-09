<?php

namespace Tests\Unit\Services\Auth;

use App\Repositories\Mydb\Player as PlayerReositories;
use App\Repositories\RedisRepository as RedisRepositories;
use App\Services\Auth\Player as PlayerServices;
use Mockery;
use Tests\TestCase;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Session;

class PlayerTest extends TestCase
{
    private $oPlayerService;
    private $oRedisRepository;
    private $oPlayerRepository;

    public function setUp(): void
    {
        parent::setUp();

        Facade::setFacadeApplication([
            'session' => Session::getFacadeRoot(),
        ]);

        $this->oRedisRepository = Mockery::mock(RedisRepositories::class);

        $this->oPlayerRepository = Mockery::mock(PlayerReositories::class);

        $this->oPlayerService = new PlayerServices($this->oPlayerRepository, $this->oRedisRepository);
    }

    /**
     * testLoginPlayerSuccess
     *
     * @group player1
     * @return void
     */
    public function testLoginPlayerSuccess()
    {
        Session::put('user_logged_in', true);
        
        $aPlayerData = [
            'id' => 1,
            'email' => 'test@example.com',
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
        ];

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

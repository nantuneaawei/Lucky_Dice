<?php

namespace Tests\Unit\Repositories\Mydb;

use App\Models\Mydb\Player;
use App\Repositories\Mydb\Player as PlayerRepositories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    protected $oPlayerRepositories;

    protected function setUp(): void
    {
        parent::setUp();

        $this->oPlayerRepositories = new PlayerRepositories(new Player());
    }

    /**
     * 測試當玩家 ID 存在 Player
     *
     * @group player
     * @return void
     */
    public function testHasPlayerReturnsTrueWhenPlayerExists()
    {
        $oPlayer = Player::factory()->create();

        $bResult = $this->oPlayerRepositories->hasPlayer($oPlayer->id);

        $bExpected = true;

        $this->assertEquals($bExpected, $bResult);
    }

    /**
     * 測試當玩家 ID 不存在 Player
     *
     * @group player
     * @return void
     */
    public function testHasPlayerReturnsFalseWhenPlayerNotExists()
    {
        $iId = 999;

        $bResult = $this->oPlayerRepositories->hasPlayer($iId);

        $bExpected = false;

        $this->assertEquals($bExpected, $bResult);
    }
    
    /**
     * 測試根據 ID 取得玩家餘額
     *
     * @group player
     * @return void
     */
    public function testGetPlayerBalanceById()
    {
        $oPlayer = Player::factory()->create(['balance' => 1000]);

        $iPlayerId = $oPlayer->id;

        $iPlayerBalance = $this->oPlayerRepositories->getPlayerBalance($iPlayerId);

        $this->assertEquals(1000, $iPlayerBalance);
    }
    
    /**
     * testCreateMember
     * 
     * @group member
     * @return void
     */
    public function testCreateMember()
    {
        $aMemberData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'testpassword',
        ];

        $oCreatedMember = $this->oPlayerRepositories->createMember($aMemberData);

        $this->assertNotNull($oCreatedMember);
        $this->assertEquals($aMemberData['username'], $oCreatedMember->username);
        $this->assertEquals($aMemberData['email'], $oCreatedMember->email);
        $this->assertTrue(password_verify($aMemberData['password'], $oCreatedMember->password));
    }
    
    
    /**
     * testFindMemberByEmail
     *
     * @group member
     * @return void
     */
    public function testFindMemberByEmail()
    {
        $oPlayer = Player::factory()->create();

        $aFoundMember = $this->oPlayerRepositories->findMemberByEmail($oPlayer->email);

        $this->assertNotNull($aFoundMember);
        $this->assertEquals($oPlayer->username, $aFoundMember['username']);
        $this->assertEquals($oPlayer->email, $aFoundMember['email']);
        $this->assertEquals($oPlayer->password, $aFoundMember['password']);
    }
}

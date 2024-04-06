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
            'Username' => 'testuser',
            'Email' => 'test@example.com',
            'Password' => 'testpassword',
        ];

        $oCreatedMember = $this->oPlayerRepositories->createMember($aMemberData);

        $this->assertNotNull($oCreatedMember);
        $this->assertEquals($aMemberData['Username'], $oCreatedMember->username);
        $this->assertEquals($aMemberData['Email'], $oCreatedMember->email);
        $this->assertTrue(password_verify($aMemberData['Password'], $oCreatedMember->password));
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

        $oFoundMember = $this->oPlayerRepositories->findMemberByEmail($oPlayer->email);

        $this->assertNotNull($oFoundMember);
        $this->assertEquals($oPlayer->username, $oFoundMember->username);
        $this->assertEquals($oPlayer->email, $oFoundMember->email);
        $this->assertEquals($oPlayer->password, $oFoundMember->password);
    }
}

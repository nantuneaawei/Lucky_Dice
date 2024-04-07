<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\Player as PlayerServices;
use App\Repositories\mydb\Player as PlayerRepositories;

class AuthController extends Controller
{
    protected $oPlayerService;
    protected $oPlayerRepositories;

    public function __construct(PlayerServices $_oPlayerService, PlayerRepositories $_oPlayerRepositories)
    {
        $this->oPlayerService = $_oPlayerService;
        $this->oPlayerRepositories = $_oPlayerRepositories;
    }

    public function CreateMember(RegisterRequest $oRequest)
    {
        $aValidatedData = $oRequest->validated();

        $bCreate = $this->oPlayerRepositories->createMember($aValidatedData);

        $aCreateArray = $this->oPlayerService->registerResult($bCreate);
        
        return $aCreateArray;
    }
}

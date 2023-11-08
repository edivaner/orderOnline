<?php

namespace App\Http\Controllers;

use App\DTO\affiliate\CreateAffiliateDTO;
use App\Models\Address;
use App\Models\Affiliate;
use App\Services\AffiliateService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AffiliateController extends Controller
{
    //
    public function __construct(
        protected AffiliateService $affiliateService
    ) {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request = (object) $request->toArray();

            $affiliate = $this->affiliateService->store(CreateAffiliateDTO::makeFromRequest($request));

            DB::commit();
            return response()->json(['message' => 'Filial cadastrado com sucesso', 'customer' => $affiliate], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar a filial', 'error' => $e->getMessage()], 500);
        }
    }
}

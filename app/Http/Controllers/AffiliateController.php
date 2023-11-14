<?php

namespace App\Http\Controllers;

use App\DTO\affiliate\CreateAffiliateDTO;
use App\DTO\affiliate\UpdateAffiliateDTO;
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


    public function update(Request $request, string $id)
    {
        try {
            $request = (object) $request->toArray();

            $affiliate = $this->affiliateService->findOne($id);
            if (!$affiliate) return response()->json(['message' => 'Filial não encontrada.']);

            $affiliate = $this->affiliateService->update(UpdateAffiliateDTO::makeFromRequest($request, $id));

            return response()->json(['message' => 'Filial cadastrado com sucesso', 'affiliate' => $affiliate], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar a filial', 'error' => $e->getMessage()], 500);
        }
    }
}

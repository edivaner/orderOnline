<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Affiliate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AffiliateController extends Controller
{
    //

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'telephone' => 'required',
            'head_office' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $address = Address::create([
                'street'        => $validated['address']['street'],
                'neighborhood'  => $validated['address']['neighborhood'],
                'number'        => $validated['address']['number'],
                'city'          => $validated['address']['city'],
                'reference'     => $validated['address']['reference'],
            ]);

            $affiliate = Affiliate::create([
                'name' => $validated['name'],
                'address' => $address->id,
                'telephone' => $validated['telephone'],
                'head_office' => $validated['head_office']
            ]);

            DB::commit();
            return response()->json(['message' => 'Filial cadastrado com sucesso', 'customer' => $affiliate, 'address' => $address], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar a filial', 'error' => $e->getMessage()], 500);
        }
    }
}

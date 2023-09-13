<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\User;

class CustomerController extends Controller
{
    //

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required',
            'address' => 'required',
            'telephone' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name'      => $validated['user']['name'],
                'email'     => $validated['user']['email'],
                'password'  => $validated['user']['password'],
            ]);

            $address = Address::create([
                'street'        => $validated['address']['street'],
                'neighborhood'  => $validated['address']['neighborhood'],
                'number'        => $validated['address']['number'],
                'city'          => $validated['address']['city'],
                'reference'     => $validated['address']['reference'],
            ]);

            $customer = Customer::create([
                'user_id'       => $user->id,
                'address_id'    => $address->id,
                'telephone'     => $validated['telephone']
            ]);

            DB::commit();

            return response()->json(['message' => 'Cliente cadastrado com sucesso', 'customer' => $customer, 'address' => $address, 'user' => $user], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar o cliente', 'error' => $e->getMessage()], 500);
        }
    }
}

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

    function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $customer = Customer::find($id);
            if (!$customer) return response()->json(['message' => 'Cliente não encontrado.'], 404);

            $validated = $request->validate([
                'user' => 'required',
                'address' => 'required',
                'telephone' => 'required'
            ]);

            $customer->update([
                'telephone'     => $validated['telephone']
            ]);

            $customer->address->update([
                'street'        => $validated['address']['street'],
                'neighborhood'  => $validated['address']['neighborhood'],
                'number'        => $validated['address']['number'],
                'city'          => $validated['address']['city'],
                'reference'     => $validated['address']['reference'],
            ]);

            $customer->user->update([
                'name'      => $validated['user']['name'],
                'email'     => $validated['user']['email'],
                'password'  => $validated['user']['password'],
            ]);

            DB::commit();

            return response()->json(['message' => 'Cliente atualizado com sucesso'], 201);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao atualizar o cliente', 'error' => $th->getMessage()], 500);
        }
    }

    public function index()
    {
        try {

            $customer = Customer::with(['user', 'address'])->get();

            return response()->json([$customer]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os cliente', 'error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $customer = Customer::find($id);
            if (!$customer) return response()->json(['message' => 'Não foi possível encontrar esse cliente'], 404);

            if (!$customer->address) $customer->address->delete();
            if (!$customer->user) $customer->user->delete();

            $customer->delete();

            DB::commit();
            return response()->json(['message' => 'Cliente deletado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível deletar esse cliente', 'error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\DTO\customer\CreateCustomerDTO;
use App\DTO\customer\UpdateCustomerDTO;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\User;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    //

    public function __construct(
        protected CustomerService $customerService
    ) {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request = (object) $request->toArray();

            $customerCreated = $this->customerService->create(CreateCustomerDTO::makeFromRequest($request));

            DB::commit();

            return response()->json(['message' => 'Cliente cadastrado com sucesso', 'customer' => $customerCreated], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar o cliente', 'error' => $e->getMessage()], 500);
        }
    }

    function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $customer = $this->customerService->update(UpdateCustomerDTO::makeFromRequest($request));

            if (!$customer) return response()->json(['message' => 'Cliente não encontrado.'], 404);


            // $validated = $request->validate([
            //     'user' => 'required',
            //     'address' => 'required',
            //     'telephone' => 'required'
            // ]);


            // $this->customerService->update(
            //     $id,
            //     $validated['address'],
            //     $validated['user'],
            //     $validated['telephone']
            // );

            // $customer->address->update([
            //     'street'        => $validated['address']['street'],
            //     'neighborhood'  => $validated['address']['neighborhood'],
            //     'number'        => $validated['address']['number'],
            //     'city'          => $validated['address']['city'],
            //     'reference'     => $validated['address']['reference'],
            // ]);

            // $customer->user->update([
            //     'name'      => $validated['user']['name'],
            //     'email'     => $validated['user']['email'],
            //     'password'  => $validated['user']['password'],
            // ]);

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
            $customer = $this->customerService->getAll();

            return response()->json([$customer]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Não foi possível listar os cliente', 'error' => $e->getMessage()], 500);
        }
    }

    public function delete(string $id)
    {
        try {
            DB::beginTransaction();

            // $customer = $this->customerService->findOne($id);

            // if (!$customer) return response()->json(['message' => 'Não foi possível encontrar esse cliente'], 404);

            // if (!$customer->address) $customer->address->delete();
            // if (!$customer->user) $customer->user->delete();

            $this->customerService->delete($id);

            DB::commit();
            return response()->json(['message' => 'Cliente deletado com sucesso'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível deletar esse cliente', 'error' => $e->getMessage()], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $customer = $this->customerService->findOne($id);
            if (!$customer) return response()->json(['message' => 'Não foi possível encontrar esse cliente'], 404);

            return response()->json([$customer]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Não foi possível encontrar esse cliente', 'error' => $e->getMessage()], 500);
        }
    }
}

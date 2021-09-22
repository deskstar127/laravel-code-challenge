<?php

namespace App\Http\Controllers;

use App\Address;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Return a list of all addresses.
     *
     * @return array
     */
    public function index(): array
    {
        return Address::with('owner', 'cars')->get()->toArray();
    }

    /**
     * Return a single address.
     *
     * @param Address $address
     * @return array
     */
    public function show(Address $address): array
    {
        return ['address' => $address, 'owner' => $address->owner];
    }

    /**
     * Store an address.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $address = Address::create($request->all());

        return response()->json($address, 201);
    }

    /**
     * Update an address.
     *
     * @param Request $request
     * @param Address $address
     * @return JsonResponse
     */
    public function update(Request $request, Address $address): JsonResponse
    {
        $address->update($request->all());

        return response()->json($address, 200);
    }

    /**
     * Delete an address.
     *
     * @param Address $address
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Address $address): JsonResponse
    {
        $address->delete();

        return response()->json(null, 204);
    }

    /**
     * Stats address
     * @param Request $request
     * @return array
     */

    public function stats(Request $request): array
    {
        $addressCars = DB::table('cars')->select('address_id', DB::raw('count(*) as count'))->groupBy('address_id');
        $stats = DB::table('addresses')
            ->joinSub($addressCars, 't', function ($join) {
                $join->on('addresses.id', '=', 't.address_id');
            })
            ->select(DB::raw('avg(t.count) as avg_cars'))
            ->get();

        return $stats->toArray();
    }
}

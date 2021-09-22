<?php

namespace App\Http\Controllers;

use App\Owner;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    /**
     * Return a list of all owners.
     *
     * @return array
     */
    public function index(): array
    {
        return Owner::with('addresses', 'cars')->get()->toArray();
    }

    /**
     * Return a single owner.
     *
     * @param Owner $owner
     * @return array
     */
    public function show(Owner $owner): array
    {
        return ['owner' => $owner, 'addresses' => $owner->addresses, 'cars' => $owner->cars];
    }

    /**
     * Store an owner.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $owner = Owner::create($request->all());

        return response()->json($owner, 201);
    }

    /**
     * Update an owner.
     *
     * @param Request $request
     * @param Owner $owner
     * @return JsonResponse
     */
    public function update(Request $request, Owner $owner): JsonResponse
    {
        $owner->update($request->all());

        return response()->json($owner, 200);
    }

    /**
     * Delete an owner.
     *
     * @param Owner $owner
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Owner $owner): JsonResponse
    {
        $owner->delete();

        return response()->json(null, 204);
    }

    /**
     * Stats owner
     * @param Request $request
     * @return array
    */

    public function stats(Request $request): array
    {
        $ownerAddresses = DB::table('addresses')->select('owner_id', DB::raw('count(*) as count'))->groupBy('owner_id');
        $ownerCars = DB::table('cars')->select('owner_id', DB::raw('count(*) as count'))->groupBy('owner_id');
        $stats = DB::table('owners')
            ->joinSub($ownerAddresses, 'oa', function ($join) {
                $join->on('owners.id', '=', 'oa.owner_id');
            })
            ->joinSub($ownerCars, 'oc', function ($join) {
                $join->on('owners.id', '=', 'oc.owner_id');
            })
            ->select(DB::raw('avg(oa.count) as avg_addresses'), DB::raw('avg(oc.count) as avg_cars'))
            ->get();

        return $stats->toArray();
    }
}

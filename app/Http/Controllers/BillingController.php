<?php
// app/Http/Controllers/BillingController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratory;
use App\Models\StudyType;
use App\Models\StudyCenterPrice;
use App\Models\StudyPriceGroup;
use Illuminate\Support\Facades\Gate;

class BillingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->roles[0]->name, ['Admin', 'Manager'])) {
                abort(403);
            }
            return $next($request);
        });
    }

    // Show the price management page
    public function index()
    {
        $centers = Laboratory::orderBy('lab_name', 'asc')->get();
        return view('admin.billing.center_prices', compact('centers'));
    }

    // AJAX: Get prices for a center
    public function getCenterPrices(Request $request)
    {
        $centerId = $request->input('center_id');
        $studyTypes = StudyType::with('priceGroup')->orderBy('name', 'asc')->get();
        $prices = StudyCenterPrice::where('center_id', $centerId)->get()->keyBy('study_type_id');
        $result = [];
        foreach ($studyTypes as $type) {
            if (isset($prices[$type->id]) && $prices[$type->id]->price_group_id) {
                $priceRow = $prices[$type->id];
                $group = StudyPriceGroup::find($priceRow->price_group_id);
                $result[] = [
                    'study_type_id' => $type->id,
                    'study_type_name' => $type->name,
                    'default_price' => $group->default_price ?? 0,
                    'price' => $priceRow->price,
                    'price_group_id' => $group->id ?? $type->price_group_id,
                    'price_group_name' => $group->name ?? '',
                ];
            } else {
                $result[] = [
                    'study_type_id' => $type->id,
                    'study_type_name' => $type->name,
                    'default_price' => $type->priceGroup->default_price ?? 0,
                    'price' => $type->priceGroup->default_price ?? 0,
                    'price_group_id' => $type->price_group_id,
                    'price_group_name' => $type->priceGroup->name ?? '',
                ];
            }
        }
        return response()->json($result);
    }

    // AJAX: Update prices for a center
    public function updateCenterPrices(Request $request)
    {
        $centerId = $request->input('center_id');
        $prices = $request->input('prices', []);
        foreach ($prices as $item) {
            if (!isset($item['study_type_id']) || !isset($item['price']) || !isset($item['price_group_id'])) continue;
            StudyCenterPrice::updateOrCreate(
                [
                    'center_id' => $centerId,
                    'study_type_id' => $item['study_type_id'],
                ],
                [
                    'price' => $item['price'],
                    'price_group_id' => $item['price_group_id']
                ]
            );
        }
        return response()->json(['success' => true]);
    }
}

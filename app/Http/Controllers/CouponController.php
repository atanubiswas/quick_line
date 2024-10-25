<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Carbon\Carbon;
use DB;

use Codeboxr\CouponDiscount\Facades\Coupon;
use App\Traits\GeneralFunctionTrait;

class CouponController extends Controller
{
    use GeneralFunctionTrait;
    
    private $pageName = "Coupon";
    
    /**
     * 
     * @param type $code
     * @return type
     */
    private function isCouponCodeExists($code){
        return \DB::table('coupons')->where('code', $code)->exists();
    }
    
    /**
     * 
     * @return type
     */
    public function generateCouponCode(){
        $couponCode = Str::random(16, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');

        // Insert a dash after every 4 characters
        $formattedCouponCode = substr_replace($couponCode, '-', 4, 0);
        $formattedCouponCode = substr_replace($formattedCouponCode, '-', 9, 0);
        $formattedCouponCode = substr_replace($formattedCouponCode, '-', 14, 0);

        // Check if the formatted code already exists in the database
        while ($this->isCouponCodeExists($formattedCouponCode)) {
            $couponCode = Str::random(16, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
            $formattedCouponCode = substr_replace($couponCode, '-', 4, 0);
            $formattedCouponCode = substr_replace($formattedCouponCode, '-', 9, 0);
            $formattedCouponCode = substr_replace($formattedCouponCode, '-', 14, 0);
        }

        return response()->json(['code'=>strtoupper($formattedCouponCode)]);
    }
    
    /**
     * 
     * @return type
     */
    public function addCoupon(){
        return view("admin.addCoupon", ["pageName" => $this->pageName]);
    }
    /**
     * 
     * @param Request $request
     * @return type
     */
    public function insertCoupon(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'coupon_code'           => 'required|unique:coupons,code',
                'coupon_percentage'     => 'required|numeric',
                'coupon_start_date'     => 'required|date_format:d/m/Y',
                'coupon_end_date'       => 'required|date_format:d/m/Y|after:start_date',
                'minimum_spend_amount'  => 'required|numeric',
                'no_of_coupon'          => 'required|numeric'
            ]);

            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()]);
            }

            $minimum_spend = $request->minimum_spend_amount == 0?"0.0":$request->minimum_spend_amount;
            $use_limit = $request->no_of_coupon == 0?"0":$request->no_of_coupon;
            $st_dt = Carbon::createFromFormat('d/m/Y', $request->coupon_start_date)->format("Y-m-d");
            $en_dt = Carbon::createFromFormat('d/m/Y', $request->coupon_end_date)->format("Y-m-d");

            Coupon::add([
                'coupon_code'       => $request->coupon_code, // (required) Coupon code
                'discount_type'     => 'percentage', // (required) coupon discount type. two type are accepted (1. percentage and 2. fixed)
                'discount_amount'   => $request->coupon_percentage, // (required) discount amount or percentage value
                'start_date'        => $st_dt, // (required) coupon start date
                'end_date'          => $en_dt, // (required) coupon end date
                'status'            => 1, // (required) two status are accepted. (for active 1 and for inactive 0)
                'minimum_spend'     => $minimum_spend, // (optional) for apply this coupon minimum spend amount. if set empty then it's take unlimited
                'maximum_spend'     => "50000000.00", // (optional) for apply this coupon maximum spend amount. if set empty then it's take unlimited
                'use_limit'         => (int)$use_limit, // (optional) how many times are use this coupon. if set empty then it's take unlimited
                //'use_same_ip_limit' => "", // (optional) how many times are use this coupon in same ip address. if set empty then it's take unlimited
                //'user_limit'        => "", // (optional) how many times are use this coupon a user. if set empty then it's take unlimited
                //'use_device'        => "", // (optional) This coupon can be used on any device
                //'multiple_use'      => "", // (optional) you can check manually by this multiple coupon code use or not
                //'vendor_id'         => ""  // (optional) if coupon code use specific shop or vendor
            ]);
            return response()->json(['success' => [$this->getMessages('_SVSUMSG')]]);
        }
        catch(\Exception $ex) {
            return response()->json(['error'=>[$this->getMessages('_GNERROR')]]);
        } catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['error'=>[$this->getMessages('_DBERROR')]]);
        }
    }
    
    /**
     * 
     * @return type
     */
    public function viewCoupon(){
        $coupons = Coupon::list()->get();
        return view("admin.viewCoupon", ["coupons" => $coupons, "pageName" => $this->pageName]);
    }
    
    public function changeCouponStatus(Request $request){
        $validator = Validator::make($request->all(), [
            'coupon_id' => 'required|numeric|exists:coupons,id',
            'is_checked' => 'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        $coupon = DB::table("coupons")
            ->find($request->coupon_id);
        
        Coupon::update([
                'coupon_code'       => $coupon->code, // (required) Coupon code
                'discount_type'     => 'percentage', // (required) coupon discount type. two type are accepted (1. percentage and 2. fixed)
                'discount_amount'   => $coupon->amount, // (required) discount amount or percentage value
                'start_date'        => $coupon->start_date, // (required) coupon start date
                'end_date'          => $coupon->end_date, // (required) coupon end date
                'status'            => ($request->is_checked == 'true')?1:0 // (required) two status are accepted. (for active 1 and for inactive 0)
            ], $coupon->id);
        return response()->json(['success' => [$this->getMessages('_STUPMSG')]]);
    }
}

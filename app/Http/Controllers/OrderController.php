<?php

namespace App\Http\Controllers;

use App\Traits\GeneralFunctionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Carbon\Carbon;
use Validator;
use Auth;

use App\Models\User;
use App\Models\order;
use App\Models\Collector;
use App\Models\patient;

class OrderController extends Controller
{
    use GeneralFunctionTrait;
    public function getActiveOrders(Request $request){
        $validator = Validator::make($request->all(), [
            'order_id'=>'sometimes|nullable|numeric|exists:orders,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        $auth = Auth::user();
        if(!$auth){
            return $this->returnAPIResponse('error', '403', 'User Not Found');
        }
        
        $userData = User::where("id", $auth['id'])
            ->with('roles')
            ->first();
        if($userData['roles'][0]['name'] !== 'collector'){
            return $this->returnAPIResponse('error', '403', 'User Not Found');
        }
        $collectorData = Collector::where("user_id", $userData['id'])
            ->first();
        $orderId = isset($request->order_id)?$request->order_id:0;
        $orders = order::select('orders.id', 'orders.order_number', 'orders.description as order_descriptions', 'orders.total_amount', 'orders.discounted_amount', 'orders.payable_amount', 'orders.status', 'orders.ordered_at', 'laboratories.lab_name', 'laboratories.lab_primary_location', 'patients.full_name', 'patients.email', 'patients.mobile_number', 'patients.date_of_birth', 'patients.gender', 'patients.address', 'patients.city', 'patients.state', 'patients.country', 'patients.postal_code', 'patients.notes', 'patients.lat', 'patients.long')
            ->when($orderId !== 0, function($query) use($orderId){
                $query->where("orders.id", $orderId);
            })
            ->leftJoin("laboratories", "laboratories.id", "orders.laboratorie_id")
            ->leftJoin("patients", "patients.id", "=", "orders.patient_id")
            ->leftJoin("collector_lab_associations", "laboratories.id", "=", "collector_lab_associations.laboratories_id")
            ->leftJoin("collectors", "collectors.id", "=", "collector_lab_associations.collector_id")
            ->with('order_tests.pathology_tests.pathlogyTestCategory')
            ->where("collector_lab_associations.status", "approved")
            ->where("collectors.id", $collectorData['id'])
            ->where("orders.status", 'processing')
            ->get();
        
        return $this->returnAPIResponse('Success', 200, $orders);
    }
    
    public function updateOrderToPickup(Request $request){
        $validator = Validator::make($request->all(), [
            'order_id'=>'required|numeric|exists:orders,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        $order = order::where("id", $request->order_id)
            ->where("status", "processing")
            ->first();
        
        if($order){
            $authUser = Auth::user();
            $collector = Collector::select("id")->where('user_id', $authUser->id)->first();
            $order->status = 'pickup';
            $order->collector_id = $collector->id;
            $order->save();
            return $this->returnAPIResponse('success', 200, 'Order Status Updated');
        }
        return $this->returnAPIResponse('error', '200', 'Order Status Already Updated');
    }
    
    public function orderOverView(){
        $authUser = Auth::user();
        $collector = Collector::where('user_id', $authUser->id)->first();
        $overView = order::selectRaw("count(1) as Total_Orders, count(case when status='completed' then 1 end) as completed, count(case when status='pickup' or status='submitted_to_lab' or status='testing' then 1 end) as Processing, count(case when status='cancelled' then 1 end) as Cancled")
            ->where("collector_id", $collector->id)
            ->get();
        return $this->returnAPIResponse('success', '200', $overView);
    }
    
    public function createOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'laboratorie_id'=>'required|numeric|exists:laboratories,id',
            'appointment_time'=>'required|date_format:Y-m-d H:i:s',
            'collection_charge'=>'required|numeric',
            'prescription_1'=>'required',
            'prescription_2'=>'required',
            'doctor_name'=>'required',
            'total_amount'=>'required',
            'discounted_amount'=>'required',
            'payable_amount'=>'required',
            'description' => 'nullable|sometimes'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        try{
            $auth = Auth::user();
            
            $description = isset($request->description)?$request->description:"";
            $patient = patient::where("user_id", $auth->id)->first();
            $collection_address = $patient->address;
            if($collection_address === 'New Address'){
                return $this->returnAPIResponse('error', '200', 'Update your Address.');
            }
            $orderId = Str::uuid();
            
            $order = new order;
            $order->laboratorie_id = $request->laboratorie_id;
            $order->patient_id = $patient->id;
            $order->appointment_time = $request->appointment_time;
            $order->collection_address = $collection_address;
            $order->collection_charge = $request->collection_charge;
            $order->prescription_1 = $request->prescription_1;
            $order->prescription_2 = $request->prescription_2;
            $order->doctor_name = $request->doctor_name;
            $order->order_number = $orderId;
            $order->description = $description;
            $order->total_amount = $request->total_amount;
            $order->discounted_amount = $request->discounted_amount;
            $order->payable_amount = $request->payable_amount;
            $order->status = 'pending';
            $order->ordered_at = Carbon::now()->toDateTimeString();
            $order->save();
            
            $returnArray = array("order_id"=>$orderId);
            return $this->returnAPIResponse('success', '200', $returnArray, "Order Saved, Waiting for payment.");
        } catch (Exception $ex) {
            return $this->returnAPIResponse('Error', 500, $e->getMessage());
        }
    }
        
    public function validateOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'order_id'=>'required|exists:orders,order_number',
            'payment_id'=>'required',
            'payment_amount'=>'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        
        $order = order::where("order_number", $request->order_id)
            ->where("status", "pending")
            ->first();
        
        if(!$order){
            return $this->returnAPIResponse('Error', 200, "This Order is Cancled.");
        }
        
        $order->status = 'processing';
        $order->save();
        return $this->returnAPIResponse('Success', 200, "Order Placed.");
    }

    public function verifyPayment(Request $request){
        $validator = Validator::make($request->all(), [
            'order_id'=>'required|exists:orders,order_number',
            'razorpay_signature'=>'required',
            'razorpay_payment_id'=>'required'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        $signature = $request->input('razorpay_signature');
        $orderId = $request->input('razorpay_order_id');
        $paymentId = $request->input('razorpay_payment_id');

        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

        try {
            $attributes = [
                'razorpay_signature' => $signature,
                'razorpay_payment_id' => $paymentId,
                'razorpay_order_id' => $orderId,
            ];

            // Validate the payment signature
            $api->utility->verifyPaymentSignature($attributes);

            // If the signature is valid, proceed with further processing
            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully.',
                'payment_id' => $paymentId
            ], 200);

        } catch (\Exception $e) {
            // Log error and return a failure response
            //Log::error('Razorpay payment verification failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}

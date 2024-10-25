<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Auth;

use App\Models\Collector;
use App\Models\WalletUser;
use App\Models\Transaction;

use App\Traits\GeneralFunctionTrait;

class WalletController extends Controller {

    use GeneralFunctionTrait;
    
    private $pageName = 'Wallet';
    private $razorpay_key = 'rzp_test_L5kmwr9mHijMK9';
    private $razorpay_secret = 'yubiReZ5bA7OdIai0hgLXPjg';
    /*============== PRIVATE FUNCTION STARTED ================*/
    /**
     * 
     * @param type $user_id
     * @param type $transaction_type
     * @param type $start_date
     * @param type $end_date
     * @return type Object
     */
    private function fetchedTransactions($user_id, $transaction_type, $start_date='', $end_date=''){
        $transaction_query = Transaction::where("user_id", $user_id);
        switch ($transaction_type) {
            case 'last_10':
                $transaction_query->latest()->take(10);
                break;
            case 'current_week':
                $transaction_query->where('transaction_date', '>=', Carbon::now()->startOfWeek());
                break;
            case 'last_week':
                $startOfLastWeek = Carbon::now()->subDays(7)->startOfWeek();
                $endOfLastWeek = Carbon::now()->subDays(7)->endOfWeek();
                $transaction_query->whereBetween('transaction_date', [$startOfLastWeek, $endOfLastWeek]);
                break;
            case 'current_month':
                $transaction_query->where('transaction_date', '>=', Carbon::now()->startOfMonth());
                break;
            case 'last_month':
                $startOfLastMonth = Carbon::now()->startOfMonth()->subMonth();
                $endOfLastMonth = Carbon::now()->endOfMonth()->subMonth();
                $transaction_query->whereBetween('transaction_date', [$startOfLastMonth, $endOfLastMonth]);
                break;
            case 'custom':
                $start_date = Carbon::parse($start_date)->startOfDay();
                $end_date = Carbon::parse($end_date)->endOfDay();
                $transaction_query->whereBetween('transaction_date', [$start_date, $end_date]);
                break;
        }

        $transactions = $transaction_query->orderBy("id", "DESC")->get();
        return $transactions;
    }
    /*============== PUBLIC FUNCTION STARTED ================*/
    public function getWalletModalData(Request $request) {
        $validator = Validator::make($request->all(), [
                    'collector_id' => 'required|numeric|exists:collectors,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $collector = Collector::find($request->collector_id);
        return view("admin.walletModalData", ["collector" => $collector]);
    }

    public function addWalletBalance(Request $request) {
        $validator = Validator::make($request->all(), [
            'collector_id' => 'required|numeric|exists:collectors,id',
            'amount' => 'required|numeric',
            'notes' => 'nullable'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $collector = Collector::find($request->collector_id);
        if ($collector->status != 1) {
            return response()->json(['error' => ["Collector's status is Inactive, Active him first."]]);
        }
        $WalletUser = $this->incrementWallet($collector->user_id, $request->amount);
        $this->addWalletTransaction($collector->user_id, $WalletUser['wallet_user_id'], $WalletUser['previous_amount'], $request->amount, $WalletUser['after_amount'], 'Credit', "Added Balance to the Wallet.", $request->notes, 'admin', 'done');
    }

    public function getTransactionModalData(Request $request) {
        $validator = Validator::make($request->all(), [
                    'collector_id' => 'required|numeric|exists:collectors,id'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $collector = Collector::find($request->collector_id);
        $transactions = Transaction::where("user_id", $collector->user_id)
                ->with("transaction_by_data")
                ->orderBy("id", "DESC")
                ->take(10)
                ->get();
        
        return view("admin.transactionModalData", ["collector" => $collector, "transactions" => $transactions]);
    }

    public function getTransactionData(Request $request) {
        $validator = Validator::make($request->all(), [
            'collector_id' => 'required|numeric|exists:collectors,id',
            'transaction_type' => 'required',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()]);
        }
        
        $collector = Collector::find($request->collector_id);
        $start_date = !empty($request->start_date)?$request->start_date:"";
        $end_date = !empty($request->end_date)?$request->end_date:"";
        $transactions = $this->fetchedTransactions($collector->user_id, $request->transaction_type, $start_date, $end_date);
        return view('admin.transactionData', ["collector" => $collector, "transactions" => $transactions]);
    }
    
    public function viewWallet() {
        $authUser = Auth::user();
        $collector = Collector::where('user_id', $authUser->id)->first();
        $transactions = Transaction::where("user_id", $authUser->id)
                ->with("transaction_by_data")
                ->orderBy("id", "DESC")
                ->take(10)
                ->get();
        
        $totalBalance = WalletUser::select('balance')->where("user_id", $authUser->id)->first();
        $thisMonthBalanceAdd = Transaction::selectRaw("sum(amount) as total_amount")
            ->where("direction", "Credit")
            ->where("user_id", $authUser->id)
            ->where('transaction_date', '>=', Carbon::now()->startOfMonth())
            ->first();
        $thisMonthBalanceSub = Transaction::selectRaw("sum(amount) as total_amount")
            ->where("direction", "Debit")
            ->where("user_id", $authUser->id)
            ->where('transaction_date', '>=', Carbon::now()->startOfMonth())
            ->first();
        $lastTransaction = isset($transactions[0])?$transactions[0]:'0.00';
        $pageName = $this->pageName;
        return view("admin.viewWallet", compact('collector', 'transactions', 'totalBalance', 'thisMonthBalanceAdd', 'thisMonthBalanceSub', 'lastTransaction', 'pageName'));
    }
    
    public function getTransactions(){
        $authUser = Auth::user();
        $transactions = Transaction::where("user_id", $authUser->id)
                ->with("transaction_by_data")
                ->orderBy("id", "DESC")
                ->take(10)
                ->get();
        
        $totalBalance = WalletUser::select('balance')->where("user_id", $authUser->id)->first();
        $data['total_balance'] = $totalBalance;
        $data['transactions'] = $transactions;
        return $this->returnAPIResponse('success', '200', $data);
    }
    
    public function verifyPayment(Request $request){
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $paymentId = $request->input('razorpay_payment_id');
        $orderId = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');

        $api = new Api($this->razorpay_key, $this->razorpay_secret);

        try {
            $attributes = [
                'razorpay_payment_id' => $paymentId,
                'razorpay_order_id' => $orderId,
                'razorpay_signature' => $signature,
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Payment is valid, you can handle the success logic here
            return response()->json(['success' => true, 'message' => 'Payment verified successfully.']);
        } catch (\Exception $e) {
            // Payment verification failed
            Log::error('Razorpay payment verification failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Payment verification failed.'], 400);
        }
    }
    
    public function addWalletBalanceCollectorApi(Request $request){
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'notes' => 'nullable'
        ]);
        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }
        $authUser = Auth::user();
        $collector = Collector::where('user_id', $authUser->id)
            ->first();
        
        $WalletUser = $this->getWallet($collector->user_id);
        $transaction = $this->addWalletTransaction($collector->user_id, $WalletUser['wallet_user_id'], $WalletUser['previous_amount'], $request->amount, $WalletUser['after_amount'], 'Credit', "Added Balance to the Wallet.", $request->notes, 'self', 'pending');
        return response()->json(['success' => true, 'data' => $transaction], 400);
    }
}

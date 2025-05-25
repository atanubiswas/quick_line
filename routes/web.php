<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TimeLineController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CollectorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\StudyLayoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LoginSecurityController;
use App\Http\Controllers\PathologyTestController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/file/{filename}', function ($filename) {
    return response()->file(storage_path('app/public/' . $filename));
});
Route::get('/case-study/pdf/{case_study_id}', [CaseStudyController::class, 'generatePdf'])->name('case-study.pdf');
Route::group(['prefix' => 'admin'], function () {
    /*============= GOOGLE 2FA ROUTES ================*/
    Route::group(['prefix'=>'2fa'], function(){
        Route::get('/', [LoginSecurityController::class, 'show2faForm'])->name('2fa');
        Route::post('/generateSecret', [LoginSecurityController::class, 'generate2faSecret'])->name('generate2faSecret');
        Route::post('/enable2fa', [LoginSecurityController::class, 'enable2fa'])->name('enable2fa');
        Route::post('/disable2fa', [LoginSecurityController::class, 'disable2fa'])->name('disable2fa');

        // 2fa middleware
        Route::post('/2faVerify', function () {
            return redirect(URL()->previous());
        })->name('2faVerify')->middleware('2fa');
        Route::get('2faVerify', function(){
            return redirect("admin/dashboard");
        });
    });
    /*============= AUTH CONTROLLER ==================*/
    Route::middleware(['guest'])->group(function(){
        Route::get('', [AuthController::class, 'adminLoginView']);
        Route::get('login', [AuthController::class, 'adminLoginView'])->name('admin.login.view');
        Route::get('forgot-password', function(){
            return view('admin/forgot_password');
        })->name("forgot_password");
    });
    
    Route::post('login', [AuthController::class, 'adminLogin'])->name('admin.login');
    Route::post('frgot-password', [AuthController::class, 'adminLogin'])->name('admin.forgot_password');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    /*============= DASHBOARD CONTROLLER ==================*/
    Route::middleware(['role:Admin,Centre,Quality Controller,Doctor,Manager,Assigner', '2fa'])->group(function () {
       Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    });
   
   /*================= USER CONTROLLER ===================*/
    Route::middleware(['role:Admin,Manager', '2fa'])->group(function(){
        Route::get('/add-user', [UserController::class, 'addUser'])->name('admin.addUser');
        Route::post('/insert-user', [UserController::class,'insertUser']);
        Route::get('/view-user', [UserController::class, 'viewUser'])->name('admin.viewUser');
        Route::post('/change-user-status', [UserController::class,'changeStatus']);
        Route::post('/reset-password', [UserController::class,'resetPassword'])->name('admin.resetPassword');
    });
    Route::middleware(['role:Admin,Centre,Quality Controller,Doctor,Manager,Assigner', '2fa'])->group(function () {
        Route::get('/change-password', [UserController::class, 'changePassword'])->name('admin.changePassword');
        Route::post('/update-password', [UserController::class, 'updatePassword'])->name('admin.updatePassword');
    });

   /*================= ROLE CONTROLLER ===================*/
   Route::middleware(['role:Admin', '2fa'])->group(function () {
       Route::post('/get-user-by-role', [RoleController::class, 'getUserByRole']);
   });
   
   /*============== LABORATORY CONTROLLER =================*/
   Route::middleware(['role:Admin,Manager', '2fa'])->group(function () {
       Route::get('/add-laboratory', [LaboratoryController::class, 'addLab'])->name('admin.addLab');
       Route::post('/insert-laboratory', [LaboratoryController::class, 'insertLab']);
       Route::post('/change-laboratory-status', [LaboratoryController::class, 'changeLabStatus']);
       Route::post('/get-edit-laboratory-data', [LaboratoryController::class, 'getEditLabData']);
       Route::post('/update-laboratory', [LaboratoryController::class, 'updateLab']);
       Route::post('/get-assigned-collectors', [LaboratoryController::class, 'getAssignedCollectors']);
       Route::get('/view-laboratory', [LaboratoryController::class, 'viewLab'])->name('admin.viewLab');
       Route::post('/get-preferred-doc', [LaboratoryController::class, 'getPreferredDoctors']);
       Route::post('/update-preferred-doctors', [LaboratoryController::class, 'updatePreferredDoctors']);
       Route::post('/update-black-listed-doctors', [LaboratoryController::class, 'updateBlackListedDoctors']);
   });

   Route::post('/get-modality', [LaboratoryController::class, 'getModality'])->name('get-modality');
   Route::get('/lab-page-setup', [LaboratoryController::class, 'labPageSetup'])->name('admin.labPageSetup');

      /*================ DOCTOR CONTROLLER ====================*/
      Route::middleware(['role:Admin,Manager', '2fa'])->group(function () {
        Route::get('/add-doctor', [DoctorController::class, 'addDoctor'])->name('admin.addDoctor');
        Route::post('/insert-doctor', [DoctorController::class, 'insertDoctor']);
        Route::get('/view-doctor', [DoctorController::class, 'viewDoctor'])->name('admin.viewDoctor');
        Route::post('/change-doctor-status', [DoctorController::class, 'changeDocStatus']);
        Route::post('/get-edit-doctor-data', [DoctorController::class, 'getEditDocData']);
        Route::post('/update-doctor', [DoctorController::class, 'updateDoc']);
    });

       /*================ CASE STUDY CONTROLLER ===================*/
        Route::middleware(['role:Admin,Manager,Centre,Assigner', '2fa'])->group(function () {
            Route::post('/insert-case-study', [CaseStudyController::class, 'insertCaseStudy'])->name('admin.insertCaseStudy');
            Route::post('/case-study-report', [CaseStudyController::class, 'caseStudyReport']);
            Route::post('/delete-case-study', [CaseStudyController::class, 'deleteCaseStudy']);
            Route::post('/add-more-study', [CaseStudyController::class, 'addMoreStudy'])->name('admin.addMoreStudy');
            Route::post('/update-existing-study', [CaseStudyController::class, 'updateExistingStudy'])->name('admin.updateExistingStudy');
            Route::post('/delete-existing-study', [CaseStudyController::class, 'deleteExistingStudy'])->name('admin.deleteExistingStudy');
            Route::post('/update-case-study', [CaseStudyController::class, 'updateCaseStudy'])->name('admin.updateCaseStudy');
            Route::post('/update-case-study-image', [CaseStudyController::class, 'updateCaseStudyImage'])->name('admin.updateCaseStudyImage');
            Route::get('/download-images-zip/{id}', [CaseStudyController::class, 'downloadImagesZip'])->name('admin.downloadImagesZip');
            Route::post('/insert-attachments', [CaseStudyController::class, 'insertAttachments'])->name('admin.insertAttachments');
            Route::get('/download-word/{id}', [CaseStudyController::class, 'downloadWord'])->name('admin.downloadWord');
        });

        Route::middleware(['role:Admin,Manager,Assigner', '2fa'])->group(function () {
            Route::post('/update-study-status', [CaseStudyController::class, 'updateStudyStatus'])->name('admin.updateStudyStatus');
        });

        Route::middleware(['role:Admin,Manager,Assigner,Quality Controller', '2fa'])->group(function () {
            Route::post('/reset-assigner-id', [CaseStudyController::class, 'resetAssignerId'])->name('admin.reset-assigner-id');
            Route::post('/assign-doctor', [CaseStudyController::class, 'assignDoctor'])->name('admin.assign-doctor');
        });

        Route::middleware(['role:Admin,Manager,Assigner,Doctor,Quality Controller,Centre', '2fa'])->group(function () {
            Route::get('/view-case-study', [CaseStudyController::class, 'viewCaseStudy'])->name('admin.viewCaseStudy');
            Route::post('/get-study-type', [CaseStudyController::class, 'getStudyType'])->name('get-study-type');
            Route::post('/get-patient-details', [CaseStudyController::class, 'getPatientDetails']);
            Route::post('/get-all-studies', [CaseStudyController::class, 'getAllStudies'])->name('admin.get-all-studies');
            Route::post('/get-case-study-search-result', [CaseStudyController::class, 'getCaseStudySearchResult']);
            Route::post('/get-case-study-images', [CaseStudyController::class, 'getCaseStudyImages']);
        });
        Route::post('/get-case-study-attachments', [CaseStudyController::class, 'getCaseStudyAttachments'])->name('admin.get-case-study-details');
        Route::post('/get-case-comments', [CaseStudyController::class, 'getCaseComments'])->name('admin.getCaseComments');
        Route::post('/save-case-comment', [CaseStudyController::class, 'saveCaseComment'])->name('admin.saveCaseComment');
        Route::post('/get-case-study-data-dashboard', [caseStudyController::class, 'getCaseStudyDataDashboard'])->name('admin.getCaseStudyDataDashboard');

   /*============== TIMELINE CONTROLLER =================*/
   Route::middleware(['role:Admin,Manager,Assigner', '2fa'])->group(function () {
        Route::post('/get-lab-timeline', [TimeLineController::class,'getLabTimeline']);
        Route::post('/get-doc-timeline', [TimeLineController::class,'getDocTimeline']);
        Route::post('/case-study-timeline', [TimeLineController::class, 'caseStudyTimeline']);
    });

   /*============== STUDYLAYOUT CONTROLLER ==============*/
   Route::middleware(['role:Admin,Manager,Assigner,Doctor', '2fa'])->group(function () {
        Route::get('/add-study-layout', [StudyLayoutController::class,'addStudyLayout'])->name('admin.addStudyLayout');
        Route::post('/insert-study-layout', [StudyLayoutController::class,'insertStudyLayout']);
        Route::get('/view-study-layout', [StudyLayoutController::class,'viewStudyLayout'])->name('admin.viewStudyLayout');
        Route::post('/get-study-layout', [StudyLayoutController::class,'getStudyLayout']);
        Route::post('/get-study-layout-table', [StudyLayoutController::class,'getStudyLayoutTable']);

        Route::get('/view-studies', [StudyLayoutController::class,'viewStudies'])->name('admin.viewStudies');
        Route::post('/get-study-details', [StudyLayoutController::class,'getStudyDetails']);
        Route::post('/insert-new-case-study', [StudyLayoutController::class,'insertNewCaseStudy']);
   });
        Route::post('/get-layout', [StudyLayoutController::class,'getLayouts'])->name('admin.getLayout');
        Route::post('/save-case-single-study', [StudyLayoutController::class,'saveCaseSingleStudy'])->name('admin.saveCaseSingleStudy');
   /*============== DOCUMENT CONTROLLER =================*/
    Route::middleware(['role:Admin,Manager', '2fa'])->group(function () {
       Route::post('/get-documents', [DocumentController::class, 'getDocuments']);
       Route::post('/update-document-status', [DocumentController::class, 'updateDocumentStatus']);
       Route::post('/add-document-ajax', [DocumentController::class, 'addDocumentAjax']);
    });
    Route::middleware(['role:Admin', '2fa'])->group(function () {
       Route::get('/add-document', [DocumentController::class, 'addDocument'])->name('admin.addDocument');
       Route::post('/upload-document', [DocumentController::class, 'uploadDocument']);
       Route::get('/view-document', [DocumentController::class, 'viewDocument'])->name('admin.viewDocument');
   });
   /*============== NOTIFICATION CONTROLLER =================*/
   Route::middleware(['role:supar_admin', '2fa'])->group(function () {
       Route::get('/add-notification', [NotificationController::class, 'addNotification'])->name('admin.addNotification');
       Route::post('/insert-notification', [NotificationController::class, 'insertNotification']);
   });
   
   /*================ COLLECTOR CONTROLLER ====================*/
   Route::middleware(['role:supar_admin', '2fa'])->group(function () {
       Route::get('/add-collector', [CollectorController::class, 'addCollector'])->name('admin.addCollector');
       Route::post('/insert-collector', [CollectorController::class, 'insertCollector']);
       Route::get('/view-collector', [CollectorController::class, 'viewCollector'])->name('admin.viewCollector');
       Route::post('/change-collector-status', [CollectorController::class, 'changeCollectorStatus']);
       Route::post('/get-edit-collector-data', [CollectorController::class, 'getEditCollectorData']);
       Route::post('/update-collector', [CollectorController::class, 'updateCollector']);
   });
   
    /*================ COUPON CONTROLLER ====================*/
   Route::middleware(['role:supar_admin', '2fa'])->group(function () {
       Route::get('/add-coupon', [CouponController::class, 'addCoupon'])->name('admin.addCoupon');
       Route::post('/generate-coupon-code', [CouponController::class, 'generateCouponCode']);
       Route::post('/insert-coupon', [CouponController::class, 'insertCoupon']);
       Route::get('/view-coupon', [CouponController::class, 'viewCoupon'])->name('admin.viewCoupon');;
       Route::post('/change-coupon-status', [CouponController::class, 'changeCouponStatus']);
   });
   
   /*================ WALLET CONTROLLER ====================*/
   Route::middleware(['role:supar_admin', '2fa'])->group(function () {
        Route::post('/get-wallet-balance-modal-data', [WalletController::class, 'getWalletModalData']);
        Route::post('/add-wallet-balance', [WalletController::class, 'addWalletBalance']);
        Route::post('/get-transactions-modal-data', [WalletController::class, 'getTransactionModalData']);
   });
   Route::middleware(['role:supar_admin,collector'])->group(function () {
       Route::post('/get-transaction-data', [WalletController::class, 'getTransactionData']);
   });
   Route::middleware(['role:collector'])->group(function () {
       Route::get('/view-wallet', [WalletController::class, 'viewWallet'])->name('admin.viewWallet');
   });
   
   /*============== PATHOLOGY TEST CONTROLLER ===============*/
   Route::middleware(['role:supar_admin', '2fa'])->group(function () {
       Route::get('/add-pathology-test', [PathologyTestController::class, 'addPathologyTest'])->name('admin.addPathologyTest');
       Route::post('/insert-pathology-test', [PathologyTestController::class, 'insertPathologyTest']);
       Route::post('/get-edit-pathology-test', [PathologyTestController::class, 'editPathologyTest']);
       Route::post('/update-pathology-test', [PathologyTestController::class, 'updatePathologyTest']);
   });
   Route::middleware(['role:supar_admin,laboratory,collector', '2fa'])->group(function () {
       Route::get('/view-pathology-test', [PathologyTestController::class, 'viewPathologyTest'])->name('admin.viewPathologyTest');
       Route::get('/admin/add-pathology-test-package', [PathologyTestController::class, 'addPathologyTestPackage'])->name('admin.addPathologyTestPackage');
   });
});
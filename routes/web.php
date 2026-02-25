<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CustodianController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ReportController;

use App\Models\Asset;
use App\Models\Custodian;
use App\Models\Brand;
use App\Models\AuditLog;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard (con contadores para panel.blade.php)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('panel', [
            'countAssets' => Asset::count(),
            'countCustodians' => Custodian::count(),
            'countBrands' => Brand::count(),
            'countAuditLogs' => AuditLog::count(),
        ]);
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Assets
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:assets.view')
        ->get('/assets', [AssetController::class, 'index'])
        ->name('assets.index');

    Route::middleware('permission:assets.create')
        ->get('/assets/create', [AssetController::class, 'create'])
        ->name('assets.create');

    Route::middleware('permission:assets.create')
        ->post('/assets', [AssetController::class, 'store'])
        ->name('assets.store');

    Route::middleware('permission:assets.view')
        ->get('/assets/{asset}', [AssetController::class, 'show'])
        ->name('assets.show');

    Route::middleware('permission:assets.edit')
        ->get('/assets/{asset}/edit', [AssetController::class, 'edit'])
        ->name('assets.edit');

    Route::middleware('permission:assets.edit')
        ->put('/assets/{asset}', [AssetController::class, 'update'])
        ->name('assets.update');

    Route::middleware('permission:assets.delete')
        ->delete('/assets/{asset}', [AssetController::class, 'destroy'])
        ->name('assets.destroy');

    /*
    |--------------------------------------------------------------------------
    | Custodians
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:custodians.view')
        ->get('/custodians', [CustodianController::class, 'index'])
        ->name('custodians.index');

    Route::middleware('permission:custodians.create')
        ->get('/custodians/create', [CustodianController::class, 'create'])
        ->name('custodians.create');

    Route::middleware('permission:custodians.create')
        ->post('/custodians', [CustodianController::class, 'store'])
        ->name('custodians.store');

    Route::middleware('permission:custodians.view')
        ->get('/custodians/{custodian}', [CustodianController::class, 'show'])
        ->name('custodians.show');

    Route::middleware('permission:custodians.edit')
        ->get('/custodians/{custodian}/edit', [CustodianController::class, 'edit'])
        ->name('custodians.edit');

    Route::middleware('permission:custodians.edit')
        ->put('/custodians/{custodian}', [CustodianController::class, 'update'])
        ->name('custodians.update');

    Route::middleware('permission:custodians.delete')
        ->delete('/custodians/{custodian}', [CustodianController::class, 'destroy'])
        ->name('custodians.destroy');

    /*
    |--------------------------------------------------------------------------
    | Assignments
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:assignments.create')
        ->get('/assignments/create', [AssignmentController::class, 'create'])
        ->name('assignments.create');

    Route::middleware('permission:assignments.create')
        ->post('/assignments', [AssignmentController::class, 'store'])
        ->name('assignments.store');

    /*
    |--------------------------------------------------------------------------
    | Maintenances
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:maintenances.create')
        ->get('/maintenances/create', [MaintenanceController::class, 'create'])
        ->name('maintenances.create');

    Route::middleware('permission:maintenances.create')
        ->post('/maintenances', [MaintenanceController::class, 'store'])
        ->name('maintenances.store');

    /*
    |--------------------------------------------------------------------------
    | Audit Logs
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:auditlogs.view')
        ->get('/audit-logs', [AuditLogController::class, 'index'])
        ->name('audit-logs.index');

    /*
    |--------------------------------------------------------------------------
    | Reports (PDF)
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:reports.export')
        ->get('/reports/assets/pdf', [ReportController::class, 'assetsPdf'])
        ->name('reports.assets.pdf');

    Route::middleware('permission:reports.export')
        ->get('/reports/custodians/pdf', [ReportController::class, 'custodiansPdf'])
        ->name('reports.custodians.pdf');

    Route::middleware('permission:reports.export')
        ->get('/reports/audit-logs/pdf', [ReportController::class, 'auditLogsPdf'])
        ->name('reports.auditlogs.pdf');

    /*
    |--------------------------------------------------------------------------
    | Brands
    |--------------------------------------------------------------------------
    */
    Route::middleware('permission:brands.view')
        ->get('/brands', [BrandController::class, 'index'])
        ->name('brands.index');

    Route::middleware('permission:brands.create')
        ->get('/brands/create', [BrandController::class, 'create'])
        ->name('brands.create');

    Route::middleware('permission:brands.create')
        ->post('/brands', [BrandController::class, 'store'])
        ->name('brands.store');

    Route::middleware('permission:brands.edit')
        ->get('/brands/{brand}/edit', [BrandController::class, 'edit'])
        ->name('brands.edit');

    Route::middleware('permission:brands.edit')
        ->put('/brands/{brand}', [BrandController::class, 'update'])
        ->name('brands.update');

    Route::middleware('permission:brands.delete')
        ->delete('/brands/{brand}', [BrandController::class, 'destroy'])
        ->name('brands.destroy');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
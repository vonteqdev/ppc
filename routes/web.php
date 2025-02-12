<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController, QuickInsightsController, BudgetMonitoringController, PerformanceController,
    FeedManagementController, FeedAnalyticsController, ProfitabilityController,
    LabelingRuleController, FeedLabelingController, PpcInsightsController, ReportController,
    UsersController, RoleController, PermissionController, ImpersonateController, SetupController,
    ImportController, ProductsController, ProfileController
};

/**
|--------------------------------------------------------------------------
| 📌 AUTH & USER MANAGEMENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /** ✅ User Management */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UsersController::class, 'index'])->name('users.index')->middleware('checkPermissions:read_users');
        Route::get('/create', [UsersController::class, 'create'])->name('users.create')->middleware('checkPermissions:write_users');
        Route::post('/create', [UsersController::class, 'store'])->name('users.store')->middleware('checkPermissions:write_users');
        Route::get('/{user}', [UsersController::class, 'show'])->name('users.show')->middleware('checkPermissions:read_users');
        Route::put('/{user}', [UsersController::class, 'update'])->name('users.update')->middleware('checkPermissions:edit_users');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->name('users.destroy')->middleware('checkPermissions:delete_users');
    });

    /** ✅ Role Management */
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index')->middleware('checkPermissions:read_roles');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create')->middleware('checkPermissions:write_roles');
        Route::post('/create', [RoleController::class, 'store'])->name('roles.store')->middleware('checkPermissions:write_roles');
        Route::get('/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('checkPermissions:read_roles');
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('checkPermissions:edit_roles');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('checkPermissions:delete_roles');
    });

    /** ✅ Permissions */
    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index')->middleware('checkPermissions:read_permissions');
        Route::get('/{permission}', [PermissionController::class, 'show'])->name('permissions.show')->middleware('checkPermissions:read_permissions');
    });
});

/**
|--------------------------------------------------------------------------
| 📌 DASHBOARD & REPORTING
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/quick-insights', [QuickInsightsController::class, 'index'])->name('quick-insights.index');
Route::post('/quick-insights/{id}/mark-as-read', [QuickInsightsController::class, 'markAsRead']);

Route::get('/budget-monitoring', [BudgetMonitoringController::class, 'index'])->name('budget-monitoring');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/store', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/label-performance', [LabelingReportController::class, 'index'])->name('reports.label-performance');

/**
|--------------------------------------------------------------------------
| 📌 PERFORMANCE TRACKING (Google Ads, Meta Ads, TikTok Ads, GA4, GSC)
|--------------------------------------------------------------------------
*/
Route::prefix('performance')->group(function () {
    Route::get('/google-ads', [PerformanceController::class, 'googleAds'])->name('performance.google-ads');
    Route::get('/meta-ads', [PerformanceController::class, 'metaAds'])->name('performance.meta-ads');
    Route::get('/tiktok-ads', [PerformanceController::class, 'tiktokAds'])->name('performance.tiktok-ads');
    Route::get('/ga4', [PerformanceController::class, 'ga4'])->name('performance.ga4');
    Route::get('/gsc', [PerformanceController::class, 'gsc'])->name('performance.gsc');
});

/** ✅ Product Management */
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductsController::class, 'index'])->name('products.index')->middleware('checkPermissions:read_products');
    Route::get('/create', [ProductsController::class, 'create'])->name('products.create')->middleware('checkPermissions:write_products');
    Route::post('/create', [ProductsController::class, 'store'])->name('products.store')->middleware('checkPermissions:write_products');
    Route::get('/{product}', [ProductsController::class, 'show'])->name('products.show')->middleware('checkPermissions:read_products');
    Route::put('/{product}', [ProductsController::class, 'update'])->name('products.update')->middleware('checkPermissions:edit_products');
    Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('products.destroy')->middleware('checkPermissions:delete_products');
});


/**
|--------------------------------------------------------------------------
| 📌 FEED MANAGEMENT (Import, Export, Labeling)
|--------------------------------------------------------------------------
*/
Route::prefix('feed-management')->group(function () {
    Route::get('/', [FeedManagementController::class, 'index'])->name('feed-management.index');
    Route::post('/import', [FeedManagementController::class, 'importFeed'])->name('feed-management.import');
    Route::get('/fetch', [FeedManagementController::class, 'fetchFeeds'])->name('feed-management.fetch');
    Route::post('/export', [FeedManagementController::class, 'createExport'])->name('feed-management.export');
    Route::get('/export-options', [FeedManagementController::class, 'exportOptions'])->name('feed-management.export-options');
    Route::post('/update-export-options', [FeedManagementController::class, 'updateExportOptions'])->name('feed-management.update-export-options');
    Route::post('/analyze-labels', [FeedLabelingController::class, 'analyze'])->name('feed-management.analyze-labels');
    Route::get('/labeling-dashboard', [FeedManagementController::class, 'showLabels'])->name('feed-management.labeling-dashboard');

});

Route::get('/product-labels', [ProductLabelingController::class, 'index'])->name('product-labels.index');
Route::post('/generate-labels', [ProductLabelingController::class, 'generateLabels'])->name('product-labels.generate');


/**
|--------------------------------------------------------------------------
| 📌 LABELING & PROFITABILITY TRACKING
|--------------------------------------------------------------------------
*/
Route::get('/profitability', [ProfitabilityController::class, 'index'])->name('profitability.index');
Route::post('/profitability/analyze', [ProfitabilityController::class, 'analyze'])->name('profitability.analyze');

Route::get('/labeling-rules', [LabelingRuleController::class, 'index'])->name('labeling-rules.index');
Route::post('/labeling-rules', [LabelingRuleController::class, 'store'])->name('labeling-rules.store');
Route::delete('/labeling-rules/{id}', [LabelingRuleController::class, 'destroy'])->name('labeling-rules.destroy');

/**
|--------------------------------------------------------------------------
| 📌 PPC INSIGHTS & ATTRIBUTION
|--------------------------------------------------------------------------
*/
Route::get('/ppc-insights', [PpcInsightsController::class, 'index'])->name('ppc-insights.index');
Route::post('/ppc-insights/fetch', [PpcInsightsController::class, 'fetch'])->name('ppc-insights.fetch');

/**
|--------------------------------------------------------------------------
| 📌 SYSTEM SETUP (API Connections, Accounts, Websites)
|--------------------------------------------------------------------------
*/
Route::prefix('setup')->group(function () {
    Route::get('/', [SetupController::class, 'index'])->name('setup.index');
    Route::get('/init-auth/{type}', [SetupController::class, 'initAuth'])->name('setup.init-auth');
    Route::get('/auth-callback', [SetupController::class, 'authCallback'])->name('setup.auth-callback');
    Route::delete('/remove-account', [SetupController::class, 'removeAccount'])->name('setup.remove-account');
    Route::post('/import-xml', [ImportController::class, 'importXML'])->name('setup.import-xml');
    Route::post('/add-website', [SetupController::class, 'addWebsite'])->name('setup.add-website');
    Route::delete('/remove-website/{website}', [SetupController::class, 'removeWebsite'])->name('setup.remove-website');
});

require __DIR__.'/auth.php';

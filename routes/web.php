<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\reports\InvoiceController;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\Register;
use App\Livewire\Dashboard;
use App\Livewire\MasterData\Category;
use App\Livewire\MasterData\CreateCategory;
use App\Livewire\MasterData\CreateGroup;
use App\Livewire\MasterData\CreateMenu;
use App\Livewire\MasterData\CreateShift;
use App\Livewire\MasterData\EditCategory;
use App\Livewire\MasterData\EditGroup;
use App\Livewire\MasterData\EditMenu;
use App\Livewire\MasterData\EditShift;
use App\Livewire\MasterData\Group;
use App\Livewire\MasterData\Menu;
use App\Livewire\MasterData\Shift;
use App\Livewire\MasterData\ViewCategory;
use App\Livewire\MasterData\ViewGroup;
use App\Livewire\MasterData\ViewMenu;
use App\Livewire\Pages\CreateOperationCost;
use App\Livewire\Pages\CreateOrder;
use App\Livewire\Pages\CreatePurchaseReport;
use App\Livewire\Pages\EditOperationCost;
use App\Livewire\Pages\EditPurchaseReport;
use App\Livewire\Pages\OpenBill;
use App\Livewire\Pages\OperationCost;
use App\Livewire\Pages\Order;
use App\Livewire\Pages\PurchaseReport;
use App\Livewire\Pages\ViewOperationCost;
use App\Livewire\Pages\ViewOrder;
use App\Livewire\Pages\ViewPurchaseReport;
use App\Livewire\Setting;

// Main Page Route
// Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');

// auth routes
Route::prefix('auth')->group(function () {
    Route::get('register', Register::class)->name('auth.register');
    Route::get('login', Login::class)->name('auth.login');
});

// main routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/setting', Setting::class)->name('setting');

    // Menu
    Route::get('master-data/menu', Menu::class)->name('master-data.menu');
    Route::get('master-data/menu/create', CreateMenu::class)->name('master-data.menu.create');
    Route::get('master-data/menu/view/{product}', ViewMenu::class)->name('master-data.menu.view');
    Route::get('master-data/menu/edit/{product}', EditMenu::class)->name('master-data.menu.edit');
    // Kategori
    Route::get('master-data/kategori', Category::class)->name('master-data.category');
    Route::get('master-data/kategori/create', CreateCategory::class)->name('master-data.category.create');
    Route::get('master-data/kategori/view/{category}', ViewCategory::class)->name('master-data.category.view');
    Route::get('master-data/kategori/edit/{category}', EditCategory::class)->name('master-data.category.edit');
    // Pesanan
    Route::get('orders', Order::class)->name('order');
    Route::get('order/create', CreateOrder::class)->name('order.create');
    Route::get('order/view/{order}', ViewOrder::class)->name('order.view');
    // Open Bill
    Route::get('open-bills', OpenBill::class)->name('open-bill');
    // Purchase
    Route::get('purchases', PurchaseReport::class)->name('purchase');
    Route::get('purchases/create', CreatePurchaseReport::class)->name('purchase.create');
    Route::get('purchases/view/{purchase}', ViewPurchaseReport::class)->name('purchase.view');
    Route::get('purchases/edit/{purchase}', EditPurchaseReport::class)->name('purchase.edit');
    // Biaya Operasional
    Route::get('operation-costs', OperationCost::class)->name('operation-cost');
    Route::get('operation-costs/create', CreateOperationCost::class)->name('operation-cost.create');
    Route::get('operation-costs/view/{cost}', ViewOperationCost::class)->name('operation-cost.view');
    Route::get('operation-costs/edit/{cost}', EditOperationCost::class)->name('operation-cost.edit');
    // Grup Produk
    Route::get('master-data/grup-produk', Group::class)->name('master-data.group-product');
    Route::get('master-data/grup-produk/create', CreateGroup::class)->name('master-data.group-product.create');
    Route::get('master-data/grup-produk/view/{group}', ViewGroup::class)->name('master-data.group-product.view');
    Route::get('master-data/grup-produk/edit/{group}', EditGroup::class)->name('master-data.group-product.edit');
    // Shift
    Route::get('master-data/shift', Shift::class)->name('master-data.shift');
    Route::get('master-data/shift/create', CreateShift::class)->name('master-data.shift.create');
    Route::get('master-data/shift/edit/{shift}', EditShift::class)->name('master-data.shift.edit');
});

// Route::view('/reports/invoice', 'reports.invoice');

// Route::get('/reports/invoice/print', [InvoiceController::class, 'print_invoice']);

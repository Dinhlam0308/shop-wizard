<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\WorkshopRegistrationController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Booking;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\News;
use App\Models\User;
use App\Models\Menu;
use App\Models\MetricsTarget;
use App\Models\Workshop;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        $modules = [
            [
                'name' => 'Product Management',
                'desc' => 'Manage your product catalog, inventory, and pricing',
                'route' => 'admin.product.index',
                'icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0H4m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5',
                'color' => 'sky',
                'progress' => Product::query()->count() / (MetricsTarget::where('metric_name', 'products')->value('monthly_goal') ?: 1),
                'stats' => Product::query()->count(),
            ],
            [
                'name' => 'Category Management',
                'desc' => 'Manage product categories and subcategories',
                'route' => 'admin.category.index',
                'icon' => 'M4 6h16M4 12h16M4 18h16',
                'color' => 'indigo',
                'progress' => Category::query()->count() / (MetricsTarget::where('metric_name', 'categories')->value('monthly_goal') ?: 1),
                'stats' => Category::query()->count(),
            ],
            [
                'name' => 'Contact Management',
                'desc' => 'Manage and respond to customer inquiries',
                'route' => 'admin.contact.index',
                'icon' => 'M21 12.79A9 9 0 1112.79 3 9 9 0 0121 12.79zM9 12h6m-3-3v6',
                'color' => 'rose',
                'progress' => Contact::query()->count() / (MetricsTarget::where('metric_name', 'contacts')->value('monthly_goal') ?: 1),
                'stats' => Contact::query()->count(),
            ],
            [
                'name' => 'Booking Management',
                'desc' => 'Manage and edit customer bookings',
                'route' => 'admin.booking.index',
                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'color' => 'teal',
                'progress' => Booking::query()->count() / (MetricsTarget::where('metric_name', 'bookings')->value('monthly_goal') ?: 1),
                'stats' => Booking::query()->count(),
            ],
            [
                'name' => 'Order Management',
                'desc' => 'Track orders, manage fulfillment, and customer service',
                'route' => 'admin.order.index',
                'icon' => 'M3 3h18v4H3V3zm0 4l9 6 9-6M3 7v14h18V7l-9 6-9-6z',
                'color' => 'green',
                'progress' => Order::query()->count() / (MetricsTarget::where('metric_name', 'orders')->value('monthly_goal') ?: 1),
                'stats' => Order::query()->count(),
            ],
            [
                'name' => 'News Management',
                'desc' => 'Manage and edit news articles',
                'route' => 'admin.news.index',
                'icon' => 'M4 4h16v16H4V4zm4 4h8v8H8V8z',
                'color' => 'amber',
                'progress' => News::query()->count() / (MetricsTarget::where('metric_name', 'news')->value('monthly_goal') ?: 1),
                'stats' => News::query()->count(),
            ],
            [
                'name' => 'User Management',
                'desc' => 'Manage customer accounts, permissions, and user data',
                'route' => 'admin.user.index',
                'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20h6M4 20h5v-2a4 4 0 00-3-3.87M16 8a4 4 0 11-8 0 4 4 0 018 0z',
                'color' => 'violet',
                'progress' => User::query()->count() / (MetricsTarget::where('metric_name', 'users')->value('monthly_goal') ?: 1),
                'stats' => User::query()->count(),
            ],
            [
                'name' => 'Menu Management',
                'desc' => 'Manage menu items, descriptions, and pricing',
                'route' => 'admin.menu.index',
                'icon' => 'M3 7h18M3 12h18M3 17h18',
                'color' => 'orange',
                'progress' => Menu::query()->count() / (MetricsTarget::where('metric_name', 'menus')->value('monthly_goal') ?: 1),
                'stats' => Menu::query()->count(),
            ],
            [
                'name' => 'Workshop Management',
                'desc' => 'Manage workshops, schedules, and registrations',
                'route' => 'admin.workshop.index',
                'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0l-3 3m3-3l3 3',
                'color' => 'cyan',
                'progress' => Workshop::query()->count() / (MetricsTarget::where('metric_name', 'workshops')->value('monthly_goal') ?: 1),
                'stats' => Workshop::query()->count(),
            ],
            [
                'name' => 'Metrics Target Management',
                'desc' => 'Define and monitor key performance goals effectively',
                'route' => 'admin.metrics_targets.index',
                'icon' => 'M12 20.5c4.694 0 8.5-3.806 8.5-8.5S16.694 3.5 12 3.5 3.5 7.306 3.5 12 7.306 20.5 12 20.5zm0-4.5a4 4 0 100-8 4 4 0 000 8z',
                'color' => 'yellow',
                'progress' => 100,
                'stats' => MetricsTarget::query()->count(),
            ],
            [
                'name' => 'Workshop Registrations',
                'desc' => 'Manage and track workshop registrations',
                'route' => 'admin.workshop_registrations.index',
                'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                'color' => 'pink',
                'progress' => 100,
                'stats' => Workshop::query()->count()
            ],
            [
                'name' => 'Feedback Management',
                'desc' => 'Manage and respond to user feedback',
                'route' => 'admin.feedback.index',
                'icon' => 'M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z',
                'color' => 'fuchsia',
                'progress' => 100,
                'stats' => Feedback::query()->count()
            ]
        ];
        return view('admin.dashboard', compact('modules'));
    }
    return view('dashboard');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && $user->role === 'admin') {
        $modules = [
            [
                'name' => 'Product Management',
                'desc' => 'Manage your product catalog, inventory, and pricing',
                'route' => 'admin.product.index',
                'icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0H4m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5',
                'color' => 'sky',
                'progress' => Product::query()->count() / (MetricsTarget::where('metric_name', 'products')->value('monthly_goal') ?: 1),
                'stats' => Product::query()->count(),
            ],
            [
                'name' => 'Category Management',
                'desc' => 'Manage product categories and subcategories',
                'route' => 'admin.category.index',
                'icon' => 'M4 6h16M4 12h16M4 18h16',
                'color' => 'indigo',
                'progress' => Category::query()->count() / (MetricsTarget::where('metric_name', 'categories')->value('monthly_goal') ?: 1),
                'stats' => Category::query()->count(),
            ],
            [
                'name' => 'Contact Management',
                'desc' => 'Manage and respond to customer inquiries',
                'route' => 'admin.contact.index',
                'icon' => 'M21 12.79A9 9 0 1112.79 3 9 9 0 0121 12.79zM9 12h6m-3-3v6',
                'color' => 'rose',
                'progress' => Contact::query()->count() / (MetricsTarget::where('metric_name', 'contacts')->value('monthly_goal') ?: 1),
                'stats' => Contact::query()->count(),
            ],
            [
                'name' => 'Booking Management',
                'desc' => 'Manage and edit customer bookings',
                'route' => 'admin.booking.index',
                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'color' => 'teal',
                'progress' => Booking::query()->count() / (MetricsTarget::where('metric_name', 'bookings')->value('monthly_goal') ?: 1),
                'stats' => Booking::query()->count(),
            ],
            [
                'name' => 'Order Management',
                'desc' => 'Track orders, manage fulfillment, and customer service',
                'route' => 'admin.order.index',
                'icon' => 'M3 3h18v4H3V3zm0 4l9 6 9-6M3 7v14h18V7l-9 6-9-6z',
                'color' => 'green',
                'progress' => Order::query()->count() / (MetricsTarget::where('metric_name', 'orders')->value('monthly_goal') ?: 1),
                'stats' => Order::query()->count(),
            ],
            [
                'name' => 'News Management',
                'desc' => 'Manage and edit news articles',
                'route' => 'admin.news.index',
                'icon' => 'M4 4h16v16H4V4zm4 4h8v8H8V8z',
                'color' => 'amber',
                'progress' => News::query()->count() / (MetricsTarget::where('metric_name', 'news')->value('monthly_goal') ?: 1),
                'stats' => News::query()->count(),
            ],
            [
                'name' => 'User Management',
                'desc' => 'Manage customer accounts, permissions, and user data',
                'route' => 'admin.user.index',
                'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20h6M4 20h5v-2a4 4 0 00-3-3.87M16 8a4 4 0 11-8 0 4 4 0 018 0z',
                'color' => 'violet',
                'progress' => User::query()->count() / (MetricsTarget::where('metric_name', 'users')->value('monthly_goal') ?: 1),
                'stats' => User::query()->count(),
            ],
            [
                'name' => 'Menu Management',
                'desc' => 'Manage menu items, descriptions, and pricing',
                'route' => 'admin.menu.index',
                'icon' => 'M3 7h18M3 12h18M3 17h18',
                'color' => 'orange',
                'progress' => Menu::query()->count() / (MetricsTarget::where('metric_name', 'menus')->value('monthly_goal') ?: 1),
                'stats' => Menu::query()->count(),
            ],
            [
                'name' => 'Workshop Management',
                'desc' => 'Manage workshops, schedules, and registrations',
                'route' => 'admin.workshop.index',
                'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0l-3 3m3-3l3 3',
                'color' => 'cyan',
                'progress' => Workshop::query()->count() / (MetricsTarget::where('metric_name', 'workshops')->value('monthly_goal') ?: 1),
                'stats' => Workshop::query()->count(),
            ],
            [
                'name' => 'Metrics Target Management',
                'desc' => 'Define and monitor key performance goals effectively',
                'route' => 'admin.metrics_targets.index',
                'icon' => 'M12 20.5c4.694 0 8.5-3.806 8.5-8.5S16.694 3.5 12 3.5 3.5 7.306 3.5 12 7.306 20.5 12 20.5zm0-4.5a4 4 0 100-8 4 4 0 000 8z',
                'color' => 'yellow',
                'progress' => 100,
                'stats' => MetricsTarget::query()->count(),
            ],
            [
                'name' => 'Workshop Registrations',
                'desc' => 'Manage and track workshop registrations',
                'route' => 'admin.workshop_registrations.index',
                'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                'color' => 'pink',
                'progress' => 100,
                'stats' => Workshop::query()->count()
            ],
            [
                'name' => 'Feedback Management',
                'desc' => 'Manage and respond to user feedback',
                'route' => 'admin.feedback.index',
                'icon' => 'M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z',
                'color' => 'fuchsia',
                'progress' => 100,
                'stats' => Feedback::query()->count()
            ]
        ];
        return view('admin.dashboard', compact('modules'));
    }

    return view('dashboard');
})->name('dashboard');

// Menu index
Route::get('/user/menu', [\App\Http\Controllers\MenuController::class, 'index'])->name('user.menu.index');
// News index
Route::get('/user/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('user.news.index');
// News detail
Route::get('/user/news/{id}', [\App\Http\Controllers\NewsController::class, 'show'])->name('user.news.show');
// About us
Route::view('/about', 'about')->name('about');
// Workshops index
Route::get('/user/workshops', [WorkshopController::class, 'index'])->name('user.workshops.index');
// Workshop detail
Route::get('/user/workshop/{id}', [WorkshopController::class, 'show'])->name('user.workshop.show');
// Shop accessories
Route::get('/user/shop/accessories', [ProductController::class, 'shopAccessories'])->name('user.shop.accessories');
// Rental
Route::get('/user/rental', [ProductController::class, 'rental'])->name('user.shop.rental');
// Product detail
Route::get('/user/product/{id}', [ProductController::class, 'show'])->name('user.product.show');
// Booking tarot
Route::get('/user/booking/tarot', [\App\Http\Controllers\BookingController::class, 'createTarot'])->name('user.booking.tarot');
// Booking table && position_class
Route::get('/user/booking', [\App\Http\Controllers\BookingController::class, 'booking'])->name('user.booking');
// Booking store
Route::post('/user/booking/store', [\App\Http\Controllers\BookingController::class, 'store'])->name('user.booking.store');
// Contact form
Route::get('/user/contact', [\App\Http\Controllers\ContactController::class, 'contact'])->name('user.contact.create');
Route::post('/user/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('user.contact.store');
// Booking workshop
Route::get('/user/workshop_registrations/workshop/{id}', [WorkshopRegistrationController::class, 'create'])->name('user.workshop_registrations.create');
// Store workshop registration
Route::post('/user/workshop_registrations/store', [WorkshopRegistrationController::class, 'store'])->name('user.workshop_registrations.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cancel order
    Route::delete('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('user.orders.cancel');

    // Add to cart
    Route::post('/cart/add/{product_id}', [CartController::class, 'addToCart'])->name('cart.add');
    // Cart detail
    Route::get('/cart/show', [CartController::class, 'show'])->name('cart.show');
    // Workshop detail
    Route::get('/workshop/show', [WorkshopController::class, 'show'])->name('user.workshop.show');
    // Order store
    Route::post('/cart/checkout/store', [OrderController::class, 'store'])->name('user.order.store');
    // Feedback store
    Route::post('/user/feedback/store', [FeedbackController::class, 'store'])->name('user.feedback.store');
});

Route::middleware(['auth'])
    ->prefix('user/cart')
    ->name('user.cart.')
    ->group(function () {
        Route::get('/state', [CartController::class, 'state'])->name('state');
        Route::patch('/items/{cartItem}', [CartController::class, 'updateItem'])->name('items.update');
        Route::delete('/items/{cartItem}', [CartController::class, 'removeItem'])->name('items.remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    });

Route::middleware(['auth', 'admin'])->group(function () {
    //user management
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('/user/{id}/edit/', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/user/{id}/update/', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/user/{id}/destroy/', [UserController::class, 'destroy'])->name('admin.user.destroy');

    //product management
    Route::get('/product', [ProductController::class, 'adminIndex'])->name('admin.product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/product/{id}/edit/', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('/product/{id}/update/', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');

    //news management
    Route::get('/news', [\App\Http\Controllers\NewsController::class, 'adminIndex'])->name('admin.news.index');
    Route::get('/news/create', [\App\Http\Controllers\NewsController::class, 'create'])->name('admin.news.create');
    Route::post('/news/store', [\App\Http\Controllers\NewsController::class, 'store'])->name('admin.news.store');
    Route::get('/news/{id}/edit/', [\App\Http\Controllers\NewsController::class, 'edit'])->name('admin.news.edit');
    Route::put('/news/{id}/update/', [\App\Http\Controllers\NewsController::class, 'update'])->name('admin.news.update');
    Route::delete('/news/{id}', [\App\Http\Controllers\NewsController::class, 'destroy'])->name('admin.news.destroy');

    //contact management
    Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('admin.contact.index');
    Route::get('/contact/create', [\App\Http\Controllers\ContactController::class, 'create'])->name('admin.contact.create');
    Route::post('/contact/store', [\App\Http\Controllers\ContactController::class, 'store'])->name('admin.contact.store');
    Route::get('/contact/{id}/edit/', [\App\Http\Controllers\ContactController::class, 'edit'])->name('admin.contact.edit');
    Route::put('/contact/{id}/update/', [\App\Http\Controllers\ContactController::class, 'update'])->name('admin.contact.update');
    Route::delete('/contact/{id}', [\App\Http\Controllers\ContactController::class, 'destroy'])->name('admin.contact.destroy');

    //booking management
    Route::get('/booking', [\App\Http\Controllers\BookingController::class, 'index'])->name('admin.booking.index');
    Route::get('/booking/create', [\App\Http\Controllers\BookingController::class, 'create'])->name('admin.booking.create');
    Route::get('/booking/{id}', [\App\Http\Controllers\BookingController::class, 'show'])->name('admin.booking.show');
    Route::post('/booking/store', [\App\Http\Controllers\BookingController::class, 'store'])->name('admin.booking.store');
    Route::get('/booking/{id}/edit/', [\App\Http\Controllers\BookingController::class, 'edit'])->name('admin.booking.edit');
    Route::put('/booking/{id}/update/', [\App\Http\Controllers\BookingController::class, 'update'])->name('admin.booking.update');
    Route::delete('/booking/{id}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('admin.booking.destroy');

    //category management
    Route::get('/category', [\App\Http\Controllers\CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/category/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/category/store', [\App\Http\Controllers\CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/category/{id}/edit/', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/category/{id}/update/', [\App\Http\Controllers\CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/category/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.category.destroy');

    //order management
    Route::get('/order', [OrderController::class, 'index'])->name('admin.order.index');
    Route::get('/order/create', [OrderController::class, 'create'])->name('admin.order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('admin.order.store');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('admin.order.show');
    Route::get('/order/{id}/edit/', [OrderController::class, 'edit'])->name('admin.order.edit');
    Route::put('/order/{id}/update/', [OrderController::class, 'update'])->name('admin.order.update');
    Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('admin.order.destroy');

    //menu management
    Route::get('/menu', [\App\Http\Controllers\MenuController::class, 'indexAdmin'])->name('admin.menu.index');
    Route::get('/menu/create', [\App\Http\Controllers\MenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/menu/store', [\App\Http\Controllers\MenuController::class, 'store'])->name('admin.menu.store');
    Route::get('/menu/{id}/edit/', [\App\Http\Controllers\MenuController::class, 'edit'])->name('admin.menu.edit');
    Route::put('/menu/{id}/update/', [\App\Http\Controllers\MenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/menu/{id}', [\App\Http\Controllers\MenuController::class, 'destroy'])->name('admin.menu.destroy');

    //workshop management
    Route::get('/workshop', [WorkshopController::class, 'indexAdmin'])->name('admin.workshop.index');
    Route::get('/workshop/create', [WorkshopController::class, 'create'])->name('admin.workshop.create');
    Route::post('/workshop/store', [WorkshopController::class, 'store'])->name('admin.workshop.store');
    Route::get('/workshop/{id}/edit/', [WorkshopController::class, 'edit'])->name('admin.workshop.edit');
    Route::put('/workshop/{id}/update/', [WorkshopController::class, 'update'])->name('admin.workshop.update');
    Route::delete('/workshop/{id}', [WorkshopController::class, 'destroy'])->name('admin.workshop.destroy');

    //workshop registration management
    Route::get('/workshop_registrations', [WorkshopRegistrationController::class, 'adminIndex'])->name('admin.workshop_registrations.index');
    Route::get('/workshop_registrations/create', [WorkshopRegistrationController::class, 'createAdmin'])->name('admin.workshop_registrations.create');
    Route::post('/workshop_registrations/store', [WorkshopRegistrationController::class, 'store'])->name('admin.workshop_registrations.store');
    Route::get('/workshop_registrations/{id}/edit/', [WorkshopRegistrationController::class, 'edit'])->name('admin.workshop_registrations.edit');
    Route::put('/workshop_registrations/{id}/update/', [WorkshopRegistrationController::class, 'update'])->name('admin.workshop_registrations.update');
    Route::delete('/workshop_registrations/{id}', [WorkshopRegistrationController::class, 'destroy'])->name('admin.workshop_registrations.destroy');

    //metrics target management
    Route::get('/metrics_targets', [\App\Http\Controllers\MetricsTargetController::class, 'index'])->name('admin.metrics_targets.index');
    Route::get('/metrics_targets/create', [\App\Http\Controllers\MetricsTargetController::class, 'create'])->name('admin.metrics_targets.create');
    Route::post('/metrics_targets/store', [\App\Http\Controllers\MetricsTargetController::class, 'store'])->name('admin.metrics_targets.store');
    Route::get('/metrics_targets/{metricsTarget}/edit/', [\App\Http\Controllers\MetricsTargetController::class, 'edit'])->name('admin.metrics_targets.edit');
    Route::put('/metrics_targets/{metricsTarget}/update/', [\App\Http\Controllers\MetricsTargetController::class, 'update'])->name('admin.metrics_targets.update');
    Route::delete('/metrics_targets/{metricsTarget}', [\App\Http\Controllers\MetricsTargetController::class, 'destroy'])->name('admin.metrics_targets.destroy');

    //feedback management
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('admin.feedback.create');
    Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('admin.feedback.store');
    Route::get('/feedback/{id}/edit/', [FeedbackController::class, 'edit'])->name('admin.feedback.edit');
    Route::put('/feedback/{id}/update/', [FeedbackController::class, 'update'])->name('admin.feedback.update');
    Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('admin.feedback.destroy');
});

require __DIR__ . '/auth.php';

// Include test routes
if (file_exists(__DIR__ . '/test.php')) {
    include __DIR__ . '/test.php';
}

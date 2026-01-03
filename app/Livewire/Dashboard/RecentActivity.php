<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\Contact;
use App\Models\Booking;

class RecentActivity extends Component
{
    public $activities = [];

    public function mount()
    {
        $this->loadActivities();
    }

    public function loadActivities()
    {
        $orders = Order::query()->latest()->take(5)->get()->map(fn($o) => [
            'id' => "order-{$o->id}",
            'title' => 'New order',
            'description' => "Order #{$o->id} from {$o->customer_name} - \${$o->total}",
            'time' => $o->created_at->diffForHumans(),
            'status' => $o->status,
            'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
            'iconBg' => 'bg-blue-100 dark:bg-blue-900',
            'iconColor' => 'text-blue-600 dark:text-blue-400',
            'statusBg' => 'bg-blue-100 dark:bg-blue-900',
            'statusText' => 'text-blue-700 dark:text-blue-300',
            'created_at' => $o->created_at,
        ]);

        $users = User::query()->latest()->take(5)->get()->map(fn($u) => [
            'id' => "user-{$u->id}",
            'title' => 'New user registered',
            'description' => "{$u->name} just joined the system",
            'time' => $u->created_at->diffForHumans(),
            'status' => 'Successful',
            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20a3 3 0 01-3-3v-2a3 3 0 013-3h10a3 3 0 013 3v2a3 3 0 01-3 3m-8-5a3 3 0 116 0 3 3 0 01-6 0z',
            'iconBg' => 'bg-green-100 dark:bg-green-900',
            'iconColor' => 'text-green-600 dark:text-green-400',
            'statusBg' => 'bg-green-100 dark:bg-green-900',
            'statusText' => 'text-green-700 dark:text-green-300',
            'created_at' => $u->created_at,
        ]);

        $contacts = Contact::query()->latest()->take(5)->get()->map(fn($c) => [
            'id' => "contact-{$c->id}",
            'title' => 'New contact message',
            'description' => "{$c->name} sent a message: “" . substr($c->message, 0, 50) . "...”",
            'time' => $c->created_at->diffForHumans(),
            'status' => 'The lastest contact',
            'icon' => 'M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.48 9.48 0 01-4-.9L3 20l1.9-3.8A8.96 8.96 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
            'iconBg' => 'bg-red-100 dark:bg-red-900',
            'iconColor' => 'text-red-600 dark:text-red-400',
            'statusBg' => 'bg-red-100 dark:bg-red-900',
            'statusText' => 'text-red-700 dark:text-red-300',
            'created_at' => $c->created_at,
        ]);

        $bookings = Booking::query()->latest()->take(5)->get()->map(fn($b) => [
            'id' => "booking-{$b->id}",
            'title' => 'New booking',
            'description' => "{$b->customer_name} booked {$b->workshop_name}",
            'time' => $b->created_at->diffForHumans(),
            'status' => $b->status,
            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
            'iconBg' => 'bg-amber-100 dark:bg-amber-900',
            'iconColor' => 'text-amber-600 dark:text-amber-400',
            'statusBg' => 'bg-amber-100 dark:bg-amber-900',
            'statusText' => 'text-amber-700 dark:text-amber-300',
            'created_at' => $b->created_at,
        ]);

        $all = collect()->merge($orders)->merge($users)->merge($contacts)->merge($bookings);
        $this->activities = $all->sortByDesc('created_at')->take(6)->values()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.recent-activity');
    }
}

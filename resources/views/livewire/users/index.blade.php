<?php

use App\Models\User;
use App\Models\Office;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public User $user;

    public $users;
    public $admins;
    public $heads;
    public $staffs;
    public $students;
    public $alumni;

    public function mount(): void
    {
        $this->users = User::orderBy('last_name')->get();
        $this->admins = User::where('role', 'admin')->get()->sortBy('last_name');
        $this->heads = User::where('role', 'head')->get()->sortBy('last_name');
        $this->staffs = User::where('role', 'staff')->get()->sortBy('last_name');
        $this->students = User::where('role', 'student')->get()->sortBy('last_name');
        $this->alumni = User::where('role', 'alumni')->get()->sortBy('last_name');
    }
};
?>

<div class="flex sm:w-full md:w-3/4 lg:w-200 flex-1 flex-col m-auto md:rounded-lg overflow-x-hidden"  x-data="{ activeTab: 'all' }">
    <!-- Tabs Navigation -->
    <div class="sticky top-0 bg-white dark:bg-zinc-900 z-10 border-b border-zinc-200 dark:border-zinc-800">
        <div class="flex items-center overflow-x-auto scrollbar-hide">
            <button @click="activeTab = 'all'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'all' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-users text-lg"></i>
                <span class="text-sm font-medium hidden md:block">All ({{$users->count()}})</span>
            </button>

            <button @click="activeTab = 'admin'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'admin' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-shield-halved text-lg"></i>
                <span class="text-sm font-medium hidden md:block">Admin ({{$admins->count()}})</span>
            </button>
            
            <button @click="activeTab = 'heads'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'heads' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-person-dots-from-line text-lg"></i>
                <span class="text-sm font-medium hidden md:block">Heads ({{$heads->count()}})</span>
            </button>

            <button @click="activeTab = 'staff'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'staff' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-users-line text-lg"></i>
                <span class="text-sm font-medium hidden md:block">Staff ({{$staffs->count()}})</span>
            </button>

            <button @click="activeTab = 'students'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'students' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-image-portrait text-lg"></i>
                <span class="text-sm font-medium hidden md:block">Students ({{$students->count()}})</span>
            </button>

            <button @click="activeTab = 'alumni'" 
                class="flex-1 min-w-fit flex items-center justify-center gap-2 py-3 px-4 transition-all"
                :class="activeTab === 'alumni' ? 'text-blue-700 dark:text-blue-500 border-b-2 border-blue-700 dark:border-blue-500' : 'text-zinc-400 dark:text-zinc-500 hover:text-gray-700 dark:hover:text-gray-300'">
                <i class="fa-solid fa-graduation-cap text-lg"></i>
                <span class="text-sm font-medium hidden md:block">Alumni ({{$alumni->count()}})</span>
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="pb-8 p-2">
        <!-- All Tab -->
        <div x-show="activeTab === 'all'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold md:hidden">
                All Users ({{$users->count()}})
            </div>
            <div class="gap-2">
                @forelse ($users as $user)
                    <livewire:users.item :user="$user"/>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-users text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No users yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">All users will appear here once added.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Admin Tab -->
        <div x-show="activeTab === 'admin'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold md:hidden">
                Administrator ({{$admins->count()}})
            </div>
            <div class="gap-2">
                @forelse ($admins as $admin)
                    <livewire:users.item :user="$admin"/>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-user-shield text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No Administrators yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Administrators will appear here once added.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Heads Tab -->
        <div x-show="activeTab === 'heads'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold md:hidden">
                Office Heads ({{$heads->count()}})
            </div>
            <div class="gap-2">
                @forelse ($heads as $head)
                    <livewire:users.item :user="$head"/>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-person-dots-from-line text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No Office Heads yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Office Heads will appear here once added.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Staff Tab -->
        <div x-show="activeTab === 'staff'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold md:hidden">
                Staffs ({{$staffs->count()}})
            </div>
            <div class="gap-2">
                @forelse ($staffs as $staff)
                    <livewire:users.item :user="$staff"/>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-users-line text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No staffs yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Staffs will appear here once added.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Students Tab -->
        <div x-show="activeTab === 'students'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold md:hidden">
                Students ({{$students->count()}})
            </div>
            <div class="gap-2">
                @forelse ($students as $student)
                    <livewire:users.item :user="$student"/>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-image-portrait text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No students yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Students will appear here once added.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Alumni Tab -->
        <div x-show="activeTab === 'alumni'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="grid auto-rows-min gap-3">
            <div class="px-4 py-2 -mb-3 text-md font-bold md:hidden">
                Alumni ({{$alumni->count()}})
            </div>
            <div class="gap-2">
                @forelse ($alumni as $alumnus)
                    <livewire:users.item :user="$alumnus"/>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center">
                            <i class="fas fa-person-dots-from-line text-3xl text-gray-400 dark:text-gray-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">No alumni yet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Alumni will appear here once added.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
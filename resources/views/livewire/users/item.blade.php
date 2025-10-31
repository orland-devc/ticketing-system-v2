<?php

use App\Models\User;
use App\Models\Office;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public User $user;
};
?>

<div x-data="{ editModal: false, editBgModal: false, deleteModal: false, deleteBgModal: false }" class="max-w-screen">
    <div @click="editModal = true; editBgModal = true;" class="group relative bg-white dark:bg-zinc-800/50 rounded-l-2xl border-l-8 border-t 
        @if ($user->role == 'admin') border-blue-500
        @elseif ($user->role == 'head') border-red-400
        @elseif ($user->role == 'staff') border-amber-500
        @elseif ($user->role == 'student') border-green-500
        @elseif ($user->role == 'alumni') border-purple-500
        @endif
        hover:bg-indigo-500/10 transition-all duration-200 cursor-pointer shadow-sm mb-2">
        <div class="flex items-center gap-4 p-3">
            <!-- Avatar -->
            <div class="relative flex-shrink-0">
                @if($user->profile_photo_path)
                    <img src="{{ asset($user->profile_photo_path) }}" 
                        alt="{{ $user->last_name }}" 
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-zinc-100 dark:ring-zinc-700">
                @else
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center ring-2 ring-zinc-100 dark:ring-zinc-700">
                        <span class="text-white font-semibold text-lg">
                            {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- User Info -->
            <div class="flex-1 min-w-0 truncate">
                <h3 class="font-semibold text-gray-900 dark:text-white text-base truncate">
                    {{ $user->last_name }}, {{ $user->first_name }} 
                    @if($user->middle_name)
                        {{ substr($user->middle_name, 0, 1) }}.
                    @endif
                    @if($user->name_suffix)
                        {{ $user->name_suffix }}
                    @endif
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1.5 mt-0.5">
                    <i class="fas fa-envelope text-xs"></i>
                    <span class="truncate">{{ $user->email }}</span>
                </p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2 mt-1.5">
                    @if ($user->role == 'admin')
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                            <i class="fas fa-shield-halved text-sm"></i>
                            Administrator
                        </span>
                    @elseif ($user->role == 'head')
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">
                            <i class="fa-solid fa-person-dots-from-line text-sm"></i>
                            Office Head
                        </span>

                    @elseif ($user->role == 'staff')
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300">
                            <i class="fas fa-users-line text-sm"></i>
                            Staff
                        </span>
                    @elseif ($user->role == 'student')
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                            <i class="fas fa-image-portrait text-sm"></i>
                            Student
                        </span>
                    @elseif ($user->role == 'alumni')
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                            <i class="fas fa-graduation-cap text-sm"></i>
                            Alumni
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <livewire:users.edit :user="$user" />
</div>
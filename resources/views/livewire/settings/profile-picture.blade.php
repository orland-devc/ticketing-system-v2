<?php

use App\Models\BotSetting;
use Livewire\Volt\Component;

new class extends Component {
    public $botSettings;
    public $name;

    public function mount(): void
    {
        $this->botSettings = BotSetting::first();
        $this->name = $this->botSettings->name;
    }

    public function save()
    {
        $this->validate([
            'photo' => 'required|image|max:2048'
        ]);

        try {
            $photo = request()->file('photo');
            
            if (!$photo) {
                $this->dispatch('toast', 
                    message: 'Please select an image first.',
                    type: 'warning',
                    duration: 3000
                );
                return;
            }

            // Delete old photo if it exists and isn't the default
            $oldPath = public_path($this->botSettings->profile_picture);
            if ($this->botSettings->profile_picture && 
                $this->botSettings->profile_picture !== 'images/assets/bot.jpg' &&
                file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Store new photo in public/images/assets
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('images/assets'), $filename);
            $path = 'images/assets/' . $filename;

            // Update database
            $this->botSettings->update([
                'profile_picture' => $path
            ]);
            
            $this->dispatch('profile-updated');
            $this->dispatch('close-modal');
            
            $this->dispatch('toast', 
                message: 'Profile picture updated successfully!',
                type: 'success',
                duration: 3000
            );

        } catch (\Exception $e) {
            $this->dispatch('toast', 
                message: 'Failed to update profile picture. Please try again.',
                type: 'danger',
                duration: 5000
            );
        }
    }

    public function updateName()
    {
        $this->validate([
            'name' => 'required|string|max:255|min:2'
        ]);

        try {
            $this->botSettings->update([
                'name' => $this->name
            ]);

            $this->dispatch('closeName-modal');
            
            $this->dispatch('toast', 
                message: 'Bot name updated successfully!',
                type: 'success',
                duration: 3000
            );

        } catch (\Exception $e) {
            $this->dispatch('toast', 
                message: 'Failed to update bot name. Please try again.',
                type: 'danger',
                duration: 5000
            );
        }
    }

    public function restoreDefault()
    {
        try {
            // Delete current photo if it's not the default
            $oldPath = public_path($this->botSettings->profile_picture);
            if ($this->botSettings->profile_picture && 
                $this->botSettings->profile_picture !== 'images/assets/bot.jpg' &&
                file_exists($oldPath)) {
                unlink($oldPath);
            }

            $this->botSettings->update([
                'profile_picture' => 'images/assets/bot.jpg'
            ]);

            $this->dispatch('profile-updated');
            $this->dispatch('close-modal');
            
            $this->dispatch('toast', 
                message: 'Restored to default profile picture.',
                type: 'success',
                duration: 3000
            );

        } catch (\Exception $e) {
            $this->dispatch('toast', 
                message: 'Failed to restore default picture.',
                type: 'danger',
                duration: 3000
            );
        }
    }

    public function restoreDefaultName()
    {
        try {
            $defaultName = 'PSU SmartBot'; 

            $this->botSettings->update([
                'name' => $defaultName
            ]);

            $this->name = $defaultName;

            $this->dispatch('closeName-modal');
            
            $this->dispatch('toast', 
                message: 'Restored to default bot name.',
                type: 'success',
                duration: 3000
            );

        } catch (\Exception $e) {
            $this->dispatch('toast', 
                message: 'Failed to restore default name.',
                type: 'danger',
                duration: 3000
            );
        }
    }
};

?>

<div class="flex flex-col items-center gap-6 p-6 rounded-xl bg-gradient-to-br from-blue-700/10 to-blue-900/10 border border-zinc-200 dark:border-zinc-700">
    <!-- Profile Picture Display with Hover Effect -->
    <div 
        @click="$dispatch('open-modal', { component: 'profile-modal' })"
        class="relative group cursor-pointer"
        x-data="{ showEdit: false }"
        @mouseenter="showEdit = true"
        @mouseleave="showEdit = false"
    >
        <div class="relative w-32 h-32 rounded-full ring-4 ring-white dark:ring-zinc-800 shadow-xl transition-transform duration-300 group-hover:scale-105">
            <img 
                src="{{ asset($botSettings->profile_picture) }}"
                class="w-full h-full rounded-full object-cover"
                alt="Bot Profile"
                wire:key="profile-{{ $botSettings->id }}"
            >
            
            <!-- Overlay on Hover -->
            <div 
                x-show="showEdit"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="absolute inset-0 bg-black/60 rounded-full flex items-center justify-center"
            >
                <div class="text-center text-white">
                    <i class="fas fa-camera text-2xl mb-1"></i>
                    <p class="text-xs font-medium">Change</p>
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="absolute -bottom-1 -right-1 bg-blue-500 w-10 h-10 rounded-full border-4 border-white dark:border-zinc-800 flex items-center justify-center">
            <i class="fas fa-camera text-white text-md"></i>
        </div>
    </div>

    <!-- Bot Name Section -->
    <div class="text-center" x-data="{ openName: false }">
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">Bot Profile Picture</p>

        <div class="flex flex-col items-center gap-3">
            <h3 class="text-lg font-bold text-zinc-900 dark:text-white">
                {{ $botSettings->name }}
            </h3>
            <flux:button 
                variant="filled"
                @click="$dispatch('openName-modal', { component: 'profile-modal' })"
                @click="openName = true"
            >
                <i class="fas fa-pen-to-square"></i>
                Edit Bot Name
            </flux:button>
        </div>

        <!-- Bot Name Modal -->
        <div 
            x-on:openName-modal.window="openName = true"
            x-on:closeName-modal.window="openName = false"
            @keydown.escape.window="openName = false"
            x-show="openName"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-effect="document.body.classList.toggle('overflow-hidden', openName)"
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;"
        >
            <!-- Backdrop -->
            <div 
                class="fixed inset-0 bg-black/60 backdrop-blur-sm"
                @click="openName = false"
            ></div>

            <!-- Modal Content -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div 
                    @click.away="openName = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 w-full max-w-md overflow-hidden"
                >
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-zinc-800 dark:to-zinc-800">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                                Update Bot Name
                            </h2>
                            <button 
                                @click="openName = false"
                                class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors"
                            >
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-6">
                        <!-- Name Input -->
                        <div class="w-full">
                            <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Bot Name
                            </label>
                            <input 
                                type="text" 
                                id="name"
                                wire:model="name"
                                class="w-full px-4 py-3 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Enter bot name"
                            >
                            @error('name')
                                <div class="flex items-center gap-2 text-red-500 text-sm mt-2 bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <flux:button
                                wire:click="updateName"
                                variant="primary"
                                class="w-full"
                            >
                                <i class="fas fa-check mr-2"></i>Save
                            </flux:button>

                            <flux:button 
                                type="button"
                                variant="filled"
                                wire:click="restoreDefaultName"
                                wire:confirm="Are you sure you want to restore the default bot name?"
                                class="w-full"
                            >
                                <i class="fas fa-undo mr-2"></i>Reset
                            </flux:button>
                        </div>

                        <flux:button 
                            type="button"
                            variant="ghost"
                            @click="openName = false"
                            class="w-full"
                        >
                            Cancel
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Picture Modal -->
    <div 
        x-data="{ open: false }"
        x-on:open-modal.window="open = true"
        x-on:close-modal.window="open = false"
        @keydown.escape.window="open = false"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-effect="document.body.classList.toggle('overflow-hidden', open)"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <!-- Backdrop -->
        <div 
            class="fixed inset-0 bg-black/60 backdrop-blur-sm"
            @click="open = false"
        ></div>

        <!-- Modal Content -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div 
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 w-full max-w-md overflow-hidden"
            >
                <!-- Header -->
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-zinc-800 dark:to-zinc-800">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-zinc-900 dark:text-white">
                            Update Profile Picture
                        </h2>
                        <button 
                            @click="open = false"
                            class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors"
                        >
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <form action="{{route('bot.profile.update')}}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Image Preview Area -->
                        <div 
                            class="flex flex-col items-center gap-4"
                            x-data="{
                                preview: null,
                                fileChosen(event) {
                                    const file = event.target.files[0];
                                    if (!file) return;
                                    this.preview = URL.createObjectURL(file);
                                }
                            }"
                        >
                            <div class="relative w-48 h-48 rounded-2xl overflow-hidden bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 border-2 border-dashed border-zinc-300 dark:border-zinc-600 transition-all hover:border-blue-400 dark:hover:border-blue-500">
                                <template x-if="preview">
                                    <div class="relative w-full h-full">
                                        <img 
                                            :src="preview" 
                                            class="w-full h-full object-cover"
                                            alt="Preview"
                                        >
                                        <button 
                                            type="button"
                                            @click="preview = null; $refs.photoInput.value = ''"
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg transition-colors"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </template>

                                <template x-if="!preview">
                                    <label 
                                        for="photo"
                                        class="absolute inset-0 flex flex-col items-center justify-center cursor-pointer group"
                                    >
                                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                            <i class="fas fa-cloud-upload-alt text-white text-2xl"></i>
                                        </div>
                                        <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Click to upload</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">PNG, JPG up to 2MB</p>
                                    </label>
                                </template>
                                
                                <input 
                                    type="file" 
                                    id="photo"
                                    name="photo"
                                    accept="image/*"
                                    @change="fileChosen"
                                    x-ref="photoInput"
                                    class="hidden"
                                >
                            </div>

                            @error('photo')
                                <div class="flex items-center gap-2 text-red-500 text-sm bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-lg">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <flux:button 
                                type="submit"
                                variant="primary"
                                class="w-full"
                            >
                                <i class="fas fa-check mr-2"></i>Save
                            </flux:button>

                            <flux:button 
                                type="button"
                                variant="filled"
                                wire:click="restoreDefault"
                                wire:confirm="Are you sure you want to restore the default profile picture?"
                                class="w-full"
                            >
                                <i class="fas fa-undo mr-2"></i>Reset
                            </flux:button>
                        </div>

                        <flux:button 
                            type="button"
                            variant="ghost"
                            @click="open = false"
                            class="w-full"
                        >
                            Cancel
                        </flux:button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Float Animation Style -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .group:hover .group-hover\:scale-110 {
            animation: float 2s ease-in-out infinite;
        }
    </style>
</div>
<div 
    x-data="{
        toasts: [],
        add(type, message, duration = 3000) {
            const id = Date.now();
            this.toasts.push({ id, type, message });
            setTimeout(() => this.remove(id), duration);
        },
        remove(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index > -1) this.toasts.splice(index, 1);
        }
    }"
    @toast.window="add($event.detail.type, $event.detail.message, $event.detail.duration || 3000)"
    class="fixed top-2 md:top-6 lg:top-8 right-2 md:right-6 lg:right-8 z-50 flex flex-col gap-3"
    style="max-width: 400px;"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="flex items-center justify-between gap-4 rounded-xl shadow-lg p-4 text-white"
            :class="{
                'bg-green-400': toast.type === 'success',
                'bg-red-400': toast.type === 'error',
                'bg-yellow-400': toast.type === 'warning',
                'bg-blue-400': toast.type === 'info',
            }"
        >
            <div class="flex items-center gap-2">
                <template x-if="toast.type === 'success'">
                    <i class="far fa-circle-check text-lg"></i>
                </template>
                <template x-if="toast.type === 'error'">
                    <i class="far fa-circle-xmark text-lg"></i>
                </template>
                <template x-if="toast.type === 'warning'">
                    <i class="fas fa-triangle-exclamation text-lg"></i>
                </template>
                <template x-if="toast.type === 'info'">
                    <i class="far fa-circle-info text-lg"></i>
                </template>
                <span x-text="toast.message"></span>
            </div>
            <button 
                @click="remove(toast.id)"
                class="flex items-center justify-center p-1.5 rounded-lg cursor-pointer transition-all"
                :class="{
                    'hover:bg-green-300/50': toast.type === 'success',
                    'hover:bg-red-300/50': toast.type === 'error',
                    'hover:bg-yellow-300/50': toast.type === 'warning',
                    'hover:bg-blue-300/50': toast.type === 'info',
                }"
            >
                <i class="fa fa-xmark text-lg"></i>
            </button>
        </div>
    </template>
</div>
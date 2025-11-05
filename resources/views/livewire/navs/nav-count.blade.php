<?php

use Livewire\Volt\Component;
use App\Models\UserRequest;
use App\Models\User;
use App\Models\Office;

new class extends Component {
    public string $type;
    public int $count = 0;

    public function mount(): void
    {
        $this->loadCount();
    }

    private function loadCount(): void
    {
        switch ($this->type) {
            case 'requests':
                $this->count = UserRequest::where('approved', false)
                    ->where('rejected', false)
                    ->count();
                break;

            case 'users':
                $this->count = UserRequest::where('approved', false)
                    ->where('rejected', false)
                    ->count();
                break;

            case 'offices':
                $this->count = Office::count();
                break;

            default:
                $this->count = 0;
        }
    }

    public function refreshCount(): void
    {
        $this->loadCount();
    }
};
?>

<div wire:poll.10s="refreshCount">
    @if ($count > 0)
        <div class="relative flex-shrink-0">
            <div class="flex h-6 min-w-6 items-center justify-center rounded-lg bg-red-600 px-2 duration-200 group-hover/navitem:scale-105">
                <span class="text-[11px] font-bold text-white tabular-nums">
                    {{ $count > 99 ? '99+' : $count }}
                </span>
            </div>
        </div>
    @endif
</div>
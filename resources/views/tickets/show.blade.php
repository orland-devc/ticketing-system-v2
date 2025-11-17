<x-layouts.app :title="$ticket->subject . ' - ' . $ticket->user->name">
    <div class="relative flex flex-col gap-3">
        <section class="w-full">
            @include('partials.tickets-show-heading')

            <livewire:tickets.show />
        </section>
    </div>
</x-layouts.app>

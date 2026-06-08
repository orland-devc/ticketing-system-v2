<x-layouts.app :title="$ticket->user->name . ' - ' . $ticket->subject">
    <div class="relative flex flex-col gap-3">
        <section class="w-full">
            @include('partials.tickets-show-heading')

            <livewire:tickets.show />
        </section>
    </div>
</x-layouts.app>

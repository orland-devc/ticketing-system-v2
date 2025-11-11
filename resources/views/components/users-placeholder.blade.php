<x-layouts.app :title="__('Users Placeholder')">
    <div class="w-full flex items-center justify-center h-full">
        <div class="h-full w-full flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <div class="flex flex-col gap-4 mb-4">
                    <div class="rounded-xl h-7 w-90 bg-zinc-100 dark:bg-zinc-800"></div>
                    <div class="rounded-xl h-5 w-80 bg-zinc-100 dark:bg-zinc-800"></div>
                </div>
                <div class="rounded-xl bg-zinc-100 dark:bg-zinc-800 h-8 w-30"></div>
            </div>

            <flux:separator variant="subtle" class="hidden md:block" />

            <div class="flex h-full gap-10 py-4">
                <div class="flex flex-col min-w-55 h-full gap-2">
                    <div class="w-full rounded-xl h-9.5 bg-zinc-100 dark:bg-zinc-800"></div>
                    <div class="w-full rounded-xl h-9.5 bg-zinc-100 dark:bg-zinc-800"></div>
                </div>
                <div class="flex flex-col gap-2 w-full h-full">
                    @foreach ([1,1,1,1,1,1,1] as $nums)
                        <div class="flex rounded-2xl w-full max-w-250 mx-auto items-center justify-between px-3 py-4 bg-zinc-50 dark:bg-zinc-500/10">
                            <div class="flex w-70 items-center gap-4 ml-3">
                                <div class="min-h-12 min-w-12 rounded-full bg-zinc-100 dark:bg-zinc-800"></div>
                                <div class="flex flex-col w-full max-w-50 gap-3">
                                    <div class="w-full rounded-xl h-5 bg-zinc-100 dark:bg-zinc-800"></div>
                                    <div class="w-full rounded-xl h-5 bg-zinc-100 dark:bg-zinc-800"></div>
                                </div>
                            </div>
                            <div class="w-35 rounded-lg h-6 bg-zinc-100 dark:bg-zinc-800"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
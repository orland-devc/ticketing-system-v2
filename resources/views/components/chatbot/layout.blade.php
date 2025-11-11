<div class="flex items-start max-md:flex-col my-4 md:my-0">
    <div class="me-10 w-full pb-2 md:w-[220px]">
        <flux:navlist class="hidden md:block mb-6 ">
            <flux:navlist.settings-item icon="sliders-horizontal" :href="route('chatbot.settings')" :current="request()->routeIs('chatbot.settings')" wire:navigate>{{ __('Settings') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item icon="message-square-heart" :href="route('chatbot.faqs')" :current="request()->routeIs('chatbot.faqs')">{{ __('FAQs') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item icon="settings-2" :href="route('chatbot.testing')" :current="request()->routeIs('chatbot.testing')" >{{ __('Testing') }}</flux:navlist.settings-item>
        </flux:navlist>

        <div class="flex items-center gap-4 md:hidden -mt-2 mx-2">
            <flux:navlist.settings-item icon="sliders-horizontal" :href="route('chatbot.settings')" :current="request()->routeIs('chatbot.settings')" wire:navigate>{{ __('Settings') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item icon="message-square-heart" :href="route('chatbot.faqs')" :current="request()->routeIs('chatbot.faqs')">{{ __('FAQs') }}</flux:navlist.settings-item>
            <flux:navlist.settings-item icon="settings-2" :href="route('chatbot.testing')" :current="request()->routeIs('chatbot.testing')" >{{ __('Testing') }}</flux:navlist.settings-item>
        </div>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch">
        <div class="w-full">
            {{ $slot }}
        </div>
    </div>
</div>

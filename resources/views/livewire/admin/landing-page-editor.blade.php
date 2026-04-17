<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">Landing Page Editor</h1>
            <p class="mt-2 text-sm text-gray-700">Update the content of your welcome page sections.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button wire:click="save" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto transition">
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </div>

    <div class="mt-8 space-y-8">
        <!-- Hero Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Hero Section</h3>
                <p class="mt-1 text-sm text-gray-500">The first thing users see when they land on your site.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Title Part 1</label>
                        <input type="text" wire:model="state.hero_title_1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Title Part 2 (Highlighted)</label>
                        <input type="text" wire:model="state.hero_title_2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Title Part 3</label>
                        <input type="text" wire:model="state.hero_title_3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <textarea wire:model="state.hero_subtitle" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                        <input type="text" wire:model="state.hero_cta_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">CTA Link</label>
                        <input type="text" wire:model="state.hero_cta_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Promo Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Promo Section</h3>
                <p class="mt-1 text-sm text-gray-500">Special offers to attract more customers.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Promo Title</label>
                        <input type="text" wire:model="state.promo_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Promo Code</label>
                        <input type="text" wire:model="state.promo_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">Promo Description (HTML supported)</label>
                        <textarea wire:model="state.promo_text" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">Promo Note</label>
                        <input type="text" wire:model="state.promo_note" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">CTA Button Text</label>
                        <input type="text" wire:model="state.promo_cta_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">CTA Link</label>
                        <input type="text" wire:model="state.promo_cta_link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- About Us Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-medium leading-6 text-gray-900">About Us Section</h3>
                <p class="mt-1 text-sm text-gray-500">Information about your business and achievements.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Section Title</label>
                        <input type="text" wire:model="state.about_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <input type="text" wire:model="state.about_subtitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">Content Paragraph 1</label>
                        <textarea wire:model="state.about_content_1" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">Content Paragraph 2</label>
                        <textarea wire:model="state.about_content_2" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"></textarea>
                    </div>
                    
                    <!-- Stats -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Experience Years</label>
                        <input type="text" wire:model="state.about_exp_years" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Devices Count</label>
                        <input type="text" wire:model="state.about_devices_count" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Satisfaction %</label>
                        <input type="text" wire:model="state.about_satisfaction_percent" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Bottom CTA Section</h3>
                <p class="mt-1 text-sm text-gray-500">The final call to action at the bottom of the page.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">CTA Title</label>
                        <input type="text" wire:model="state.cta_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <textarea wire:model="state.cta_subtitle" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Button Text</label>
                        <input type="text" wire:model="state.cta_button_text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="bg-white shadow sm:rounded-lg overflow-hidden border border-gray-100">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Footer Section</h3>
                <p class="mt-1 text-sm text-gray-500">Company information displayed at the bottom of every page.</p>
            </div>
            <div class="px-4 py-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">Footer Description</label>
                        <textarea wire:model="state.footer_description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea wire:model="state.footer_address" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Telephone</label>
                        <input type="text" wire:model="state.footer_telephone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Instagram URL</label>
                        <input type="text" wire:model="state.footer_instagram" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Facebook URL</label>
                        <input type="text" wire:model="state.footer_facebook" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-8 flex justify-end">
        <button wire:click="save" wire:loading.attr="disabled" class="inline-flex items-center justify-center rounded-md border border-transparent bg-primary px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 sm:w-auto transition">
            <span wire:loading.remove wire:target="save">Save Changes</span>
            <span wire:loading wire:target="save">Saving...</span>
        </button>
    </div>
</div>

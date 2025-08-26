<flux:modal name="delete-project" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete project?</flux:heading>

            <flux:text class="mt-2">
                <p>You're about to delete this project.</p>
                <p>This action cannot be reversed.</p>
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button wire:click="hideConfirmationDialog" variant="ghost">Cancel</flux:button>
            </flux:modal.close>

            <flux:button type="submit" variant="danger">Delete project</flux:button>
        </div>
    </div>
</flux:modal>

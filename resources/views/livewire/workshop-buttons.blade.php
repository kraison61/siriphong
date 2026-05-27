<?php
use function Livewire\Volt\layout;
use function Livewire\Volt\title;

title('Workshop: Button Components');
layout('components.layouts.app');
?>

<div class="min-h-screen bg-white p-8">
    <div class="max-w-5xl mx-auto">
        <h1>🧪 ทดสอบ flux:button</h1>

        <div class="mt-6 flex gap-4">
            <flux:button>Default</flux:button>
            <flux:button variant="primary">Primary</flux:button>
        </div>
    </div>
</div>
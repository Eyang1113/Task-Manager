<div>
    <p>{{ $count }}</p>
    <input type="number" wire:model.blur='number' />
    <button wire:click="changeCount({{ $number }})">Change count</button>
</div>

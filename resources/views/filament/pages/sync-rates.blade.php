<x-filament-panels::page>
    <div class="flex  gap-4">

    <div class="flex flex-col gap-2">
        <p class="font-bold text-xl">Select period:</p>
        <div>
            <p>From</p>
            <input type="date" wire:model="from" style="background-color: black; color: white;" class="border rounded px-3 py-2 w-full">
        </div>
   
        <div>
            <p>To</p>
            <input type="date" wire:model="to" style="background-color: black; color: white;" class="border rounded px-3 py-2 w-full">
        </div>
    </div>
     </div>
    <p  class="mt-4 bg-black text-white px-3 py-2" style="background-color: black; padding: 10px; border-radius: 15px;" >Виберіть від і до якого періоду вам потрібно включити синхронізацію <br><br>
    Якщо обрали дату, натисніть Install Rates
</p>
</x-filament-panels::page>
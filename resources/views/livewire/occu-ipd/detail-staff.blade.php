<div>
    hello staff{{ $occu_ipd_id }}
    <table class="min-w-full text-left text-sm font-light dark:text-gray-50">
        <thead class="border-b bg-white font-medium dark:border-gray-500 dark:bg-gray-600">
            <tr>
                <th scope="col" class="px-6 py-4">ลำดับ</th>
                <th scope="col" class="px-6 py-4">ตำแหน่ง</th>
                <th scope="col" class="px-6 py-4">จำนวน</th>
                <!-- <th scope="col" class="px-6 py-4 text-center">คำสั่ง</th> -->
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $key => $row)
            <tr class="border-b {{ $key % 2 == 0 ? 'bg-gray-100 dark:border-gray-500 dark:bg-gray-700' : 'bg-white dark:border-gray-500 dark:bg-gray-600' }}">
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $row->staff_name }}</td>
                <td class="whitespace-nowrap px-6 py-4">
                @if ($cursor == $row->id)    
                <input type="number" maxlength="5" autofocus wire:model.lazy="editing.qty" /></td>
                @else
                <button type="button" wire:click="setCursor({{ $row->id }})">{{ $row->qty }}</button>                
                @endif
                <td class="whitespace-nowrap px-6 py-4">
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="whitespace-nowrap px-6 py-4 text-center font-medium">
                    -- Empty --
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
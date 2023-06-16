<div
    x-data = "{
        wardSelect: @entangle('ward_id'),
        wards: {{ json_encode($wards) }},
        room_id: @entangle('room_id'),
        an: @entangle('an'),
        ipd: @entangle('ipd'),
        rooms: [],
        beds: [],
        errors: [],
        editing: $wire.editing,
        modalShow: (row) => {
            clearError()
            $wire.new(JSON.parse(row));
            setIpd(row);
            modal.show();
        }
    }"
    x-init = "
        modal = new Modal($refs.modal);
        pname = 'Rachet';
        setIpd = (row) => {
            ipd = JSON.parse(row)
            return ipd
        }
        clearError = () => {
            errors = [];
        }
    "
    @toast-event.window = "async (event) => {
        await modal.hide()
        $dispatch('toastify', { text: event.detail.text });
    }"

    @err-message.window = "(event) => {
        errors = JSON.parse(event.detail.errors);
        console.log(errors)
    }"
>
    <!--Verically centered scrollable modal-->
    <div class="mb-4">
        <nav class="bg-grey-light w-full rounded-md mb-4">
            <ol class="list-reset flex">
              <li>
                <a
                  href="{{ route('nurse.ipdlist') }}"
                  class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600"
                  >หน้าแรก</a
                >
              </li>
              <li>
                <span class="mx-2 text-neutral-500 dark:text-neutral-400">></span>
              </li>
              <li class="text-neutral-500 dark:text-neutral-400">รอรับ</li>
            </ol>
        </nav>
        <div class="lg:max-w-xs flex gap-2 lg:flex-row flex-col" wire:ignore>
            <!--Select default-->
            <div class="lg:min-w-[350px] w-full">
                <x-input.select wire:model="filter_ward_id" :label="__('หอผู้ป่วย')">
                    <option value="0">-- ทั้งหมด --</option>
                    @foreach ($wards as $ward)
                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                    @endforeach
                </x-input.select>
            </div>
            <div class="flex gap-2 justify-between lg:min-w-[400px]">
                <div class="relative w-1/2" data-te-input-wrapper-init>
                    <x-input.tw-text
                        wire:model.debounce.600ms="filters.an"
                        type="text"
                        id="searchAnInput"
                        aria-describedby="searchAnHelp"
                        placeholder="ค้นหา AN"
                    />
                    <x-input.tw-label for="searchAnHelp" label="AN" />
                </div>
                <div class="relative w-1/2" data-te-input-wrapper-init>
                    <x-input.tw-text
                        wire:model.debounce.600ms="filters.hn"
                        type="text"
                        id="searchHnInput"
                        aria-describedby="searchHnHelp"
                        placeholder="ค้นหา HN"
                    />
                    <x-input.tw-label for="searchHnHelp" label="HN" />
                </div>
            </div>
        </div>
    </div>
    <table class="min-w-full text-left text-sm font-light dark:text-gray-50">
        <thead class="border-b bg-white font-medium dark:border-gray-500 dark:bg-gray-600">
            <tr>
                <th scope="col" class="px-6 py-4">#</th>
                <th scope="col" class="px-6 py-4">Admit Date</th>
                <th scope="col" class="px-6 py-4">Time</th>
                <th scope="col" class="px-6 py-4">AN</th>
                <th scope="col" class="px-6 py-4">HN</th>
                <th scope="col" class="px-6 py-4">Patient name</th>
                <th scope="col" class="px-6 py-4">Age</th>
                <th scope="col" class="px-6 py-4">Ward</th>
                <th scope="col" class="px-6 py-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $key => $row)
                <tr
                    class="border-b {{ $key % 2 == 0 ? 'bg-gray-100 dark:border-gray-500 dark:bg-gray-700' : 'bg-white dark:border-gray-500 dark:bg-gray-600' }}">
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->reg_date_thai }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->regtime }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->an }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->hn }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->fullname }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->ay > 0 ? $row->ay . ' ปี' : $row->am . ' เดือน' }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->ward_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <x-button.primary x-on:click="modalShow('{{ $row }}')">รับใหม่</x-button.primary>
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
    @if ($rows)
        <div class="py-4">
            {{ $rows->links() }}
        </div>
    @endif

    <!-- Edit Modal -->
    <x-nurse.ipd-newcase-modal />
    <!-- End Modal -->
</div>

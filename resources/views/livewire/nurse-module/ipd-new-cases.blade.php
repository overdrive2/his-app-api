<div>
    <table class="min-w-full text-left text-sm font-light">
        <thead
          class="border-b bg-white font-medium dark:border-neutral-500 dark:bg-neutral-600">
          <tr>
            <th scope="col" class="px-6 py-4">#</th>
            <th scope="col" class="px-6 py-4">Admit Date/Time</th>
            <th scope="col" class="px-6 py-4">Patient name</th>
            <th scope="col" class="px-6 py-4">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($rows as $key => $row)
          <tr
            class="border-b {{ ($key % 2 == 0) ? 'bg-neutral-100 dark:border-neutral-500 dark:bg-neutral-700' : 'bg-white dark:border-neutral-500 dark:bg-neutral-600' }}">
            <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
            <td class="whitespace-nowrap px-6 py-4">{{ $row->reg_date_thai }}</td>
            <td class="whitespace-nowrap px-6 py-4">{{ $row->fullname }}</td>
            <td class="whitespace-nowrap px-6 py-4">@mdo</td>
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

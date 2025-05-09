<x-layouts.app :title="__('Tasks')">
    <div class="flex justify-between items-center m-2">
        <flux:heading size="xl">Tasks List</flux:heading>
        <flux:button variant="primary" class="my-3 cursor-pointer" href="{{route('tasks.create')}}">Create</flux:button>
    </div>

    <form method="GET" action="{{ route('tasks.index') }}" class="flex gap-4 items-end mb-4">
        <!-- Búsqueda por Título -->
        <flux:input name="title" value="{{ request('title') }}" label="Title" placeholder="Filter by title..."/>

        <flux:select class="" label="Category" name="category_id" placeholder="Choose category...">
            @foreach($categories as $category)
                <flux:select.option :selected="request('category_id') == $category->id"  value="{{$category->id}}" >{{$category->name}}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:select class="" label="Priority" name="priority" placeholder="Choose priority...">
            <flux:select.option :selected="request('priority') === 'Low'" value="Low" >Low</flux:select.option>
            <flux:select.option :selected="request('priority') === 'Medium'"  value="Medium"  >Medium</flux:select.option>
            <flux:select.option :selected="request('priority') === 'High'"  value="High"  >High</flux:select.option>
            <flux:select.option :selected="request('priority') === 'Urgent'"  value="Urgent"  >Urgent</flux:select.option>
        </flux:select>

        <flux:select class="" label="Status" name="status" placeholder="Choose status...">
            <flux:select.option :selected="request('status') === '0'"  value="0" >Incomplete</flux:select.option>
            <flux:select.option :selected="request('status') === '1'"  value="1"  >Complete</flux:select.option>
        </flux:select>

{{--        <!-- Filtro por Estado -->--}}
{{--        <select name="status" class="border p-2 rounded-md">--}}
{{--            <option value="">Todos los estados</option>--}}
{{--            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pendiente</option>--}}
{{--            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Completado</option>--}}
{{--        </select>--}}

        <flux:button class="cursor-pointer" variant="primary" type="submit">Filter</flux:button>
        <flux:button class="cursor-pointer"  href="{{ route('tasks.index') }}">Restore</flux:button>
    </form>

    <div class="relative overflow-hidden rounded-t-lg">
    <table class="w-full text-sm text-left rtl:text-right text-zinc-500 dark:text-zinc-400">
        <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-200">
        <tr>
            <th class="px-6 py-3">Title</th>
            <th class="px-6 py-3">
                <a href="{{route('tasks.index',array_merge(request()->all(),['sort'=>'due_date','direction'=>($column == 'due_date' && $direction == 'asc') ? 'desc' : 'asc']))}}">
                    <p class="flex items-center">
                        Due date
                        @if(request('sort') == 'due_date')
                            @if(request('direction') == 'asc')
                                <flux:icon.arrow-down variant="micro" class="ps-2"/>
                            @else
                                <flux:icon.arrow-up variant="micro" class="ps-2"/>
                            @endif
                        @endif
                    </p>
                </a>
            </th>
            <th class="px-6 py-3">
                <a href="{{route('tasks.index',array_merge(request()->all(),['sort'=>'created_at','direction'=>($column == 'created_at' && $direction == 'asc') ? 'desc' : 'asc']))}}">
                    <p class="flex items-center">
                        Creation date
                        @if(request('sort') == 'created_at')
                            @if(request('direction') == 'asc')
                                <flux:icon.arrow-down variant="micro" class="ps-2"/>
                            @else
                                <flux:icon.arrow-up variant="micro" class="ps-2"/>
                            @endif
                        @endif
                    </p>
                </a>
            </th>
            <th class="px-6 py-3">
                <a href="{{route('tasks.index',array_merge(request()->all(),['sort'=>'priority','direction'=>($column == 'priority' && $direction == 'asc') ? 'desc' : 'asc']))}}">
                    <p class="flex items-center">
                        Priority
                        @if(request('sort') == 'priority')
                            @if(request('direction') == 'asc')
                                <flux:icon.arrow-down variant="micro" class="ps-2"/>
                            @else
                                <flux:icon.arrow-up variant="micro" class="ps-2"/>
                            @endif
                        @endif
                    </p>
                </a>
            </th>
            <th class="px-6 py-3">Category</th>
            <th class="px-6 py-3">Status</th>
        </tr>
        </thead>

        @forelse($tasks as $task)
            <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 border-zinc-200">
                <td class="px-6 py-4 font-medium text-zinc-900 whitespace-nowrap dark:text-white">
                    <a class="font-bold" href="{{route('tasks.show',$task->id)}}">
                        {{ $task->title }}
                    </a>

                </td>
                <td class="px-6 py-4">{{ $task->due_date->format('d/m/Y') }}</td>
                <td class="px-6 py-4">{{ $task->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4">
                    @if($task->priority == "Low")
                        <p class="text-green-500" >{{ $task->priority }}</p>
                    @elseif($task->priority == "Medium")
                        <p class="text-yellow-500" >{{ $task->priority }}</p>
                    @elseif($task->priority == "High")
                        <p class="text-orange-500" >{{ $task->priority }}</p>
                    @else
                        <p class="text-red-500" >{{ $task->priority }}</p>
                    @endif

                </td>
                <td class="px-6 py-4">
                    <flux:badge size="sm" class="mx-2" color="{{$task->category->color_code}}">{{$task->category->name}}</flux:badge>
                </td>
                <td class="px-6 py-4 flex">
                    @if($task->status)
                        <p class="text-green-500">Completed</p>
                    @else
                        <p class="text-red-500">Incompleted</p>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-2 text-2xl">
                    No results,
                    <a class="text-blue-400" href="{{route('tasks.index')}}">clean filters</a>
                </td></tr>
        @endforelse
        <tr>
            <td class="px-6 py-4 bg-zinc-800" colspan="6">{{$tasks->appends(request()->query())->links()}}</td>
        </tr>
    </table>
</div>
</x-layouts.app>



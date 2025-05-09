<x-layouts.app :title="__('Deleted Tasks')">
    <div class="flex justify-between items-center m-2">
        <flux:heading size="xl">Deleted tasks List</flux:heading>
        <flux:button variant="primary" class="my-3 cursor-pointer" href="{{route('tasks.create')}}">Create</flux:button>
    </div>

    <form method="GET" action="{{ route('tasks.deletedTasks') }}" class="flex gap-4 items-end mb-4">
        <!-- Búsqueda por Título -->
        <flux:input name="title" value="{{ request('title') }}" label="Title" placeholder="Filter by title..."/>

        <flux:select class="" label="Category" name="category_id" placeholder="Choose category...">
            @foreach($categories as $category)
                <flux:select.option :selected="request('category_id') == $category->id"  value="{{$category->id}}" >{{$category->name}}</flux:select.option>
            @endforeach
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
        <flux:button class="cursor-pointer"  href="{{ route('tasks.deletedTasks') }}">Restore</flux:button>
    </form>

    <div class="relative overflow-hidden rounded-t-lg">
        <table class="w-full text-sm text-left rtl:text-right text-zinc-500 dark:text-zinc-400">
            <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-200">
            <tr>
                <th class="px-6 py-3">Title</th>
                <th class="px-6 py-3">
                    <a href="{{route('tasks.deletedTasks',array_merge(request()->all(),['sort'=>'due_date','direction'=>($column == 'due_date' && $direction == 'asc') ? 'desc' : 'asc']))}}">
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
                    <a href="{{route('tasks.deletedTasks',array_merge(request()->all(),['sort'=>'created_at','direction'=>($column == 'created_at' && $direction == 'asc') ? 'desc' : 'asc']))}}">
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
                <th class="px-6 py-3">Category</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
            </thead>

            @forelse($tasks as $task)
                <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 border-zinc-200">
                    <td class="px-6 py-4">{{ $task->title }}</td>
                    <td class="px-6 py-4">{{ $task->due_date->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $task->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <flux:badge size="sm" class="mx-2" color="{{$task->category->color_code}}">{{$task->category->name}}</flux:badge>
                    </td>
                    <td class="px-6 py-4">
                        @if($task->status)
                            <p class="text-green-500">Completed</p>
                        @else
                            <p class="text-red-500">Incompleted</p>
                        @endif
                    </td>
                    <td class="px-6 py-3 flex gap-4">
                        <flux:modal.trigger name="restore-task{{$task->id}}">
                            <flux:icon.arrow-uturn-left variant="solid" class="ms-2 text-blue-500 cursor-pointer"/>
                        </flux:modal.trigger>
                        <flux:modal name="restore-task{{$task->id}}" class="cursor-default min-w-[22rem] flux-modal">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Restore task?</flux:heading>
                                    <flux:text class="mt-2">
                                        <p>You're about to restore this task.</p>
                                    </flux:text>
                                </div>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button class="cursor-pointer" variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <form method="post" action="{{route('tasks.restore',$task->id)}}">
                                        @csrf
                                        <flux:button type="submit" class="cursor-pointer" variant="primary">
                                            Restore task
                                        </flux:button>
                                    </form>
                                </div>
                            </div>
                        </flux:modal>
                        <flux:modal.trigger name="delete-task{{$task->id}}">
                            <flux:icon.trash  variant="solid" class="ms-2 text-red-500 cursor-pointer"/>
                        </flux:modal.trigger>
                        <flux:modal name="delete-task{{$task->id}}" class="cursor-default min-w-[22rem] flux-modal">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Delete task?</flux:heading>
                                    <flux:text class="mt-2">
                                        <p>You're about to delete this task.</p>
                                        <p>This action cannot be reversed.</p>
                                    </flux:text>
                                </div>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button class="cursor-pointer" variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <form method="post" action="{{route('tasks.forceDelete',$task->id)}}">
                                        @method('delete')
                                        @csrf
                                        <flux:button type="submit" class="cursor-pointer" variant="danger">
                                            Delete task
                                        </flux:button>
                                    </form>
                                </div>
                            </div>
                        </flux:modal>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="p-2 text-2xl">
                        No results,
                        <a class="text-blue-400" href="{{route('tasks.deletedTasks')}}">clean filters</a>
                    </td></tr>
            @endforelse
            <tr>
                <td class="px-6 py-4 bg-zinc-800" colspan="6">{{$tasks->appends(request()->query())->links()}}</td>
            </tr>
        </table>
    </div>
</x-layouts.app>



<x-layouts.app :title="__($task->title)">

    <div class="flex justify-between items-center">
        <div class="flex">
            <flux:heading size="xl">{{$task->title}}</flux:heading>
            <flux:badge size="sm" class="mx-2" color="{{$task->category->color_code}}">{{$task->category->name}}</flux:badge>
        </div>
        <div class="flex items-center">
            @if($task->status)
                <flux:heading class="text-green-500" size="lg">Completed</flux:heading>
            @else
                <flux:heading class="text-red-500" size="lg">Incomplete</flux:heading>
            @endif

            @if($task->status)
                <form class="flex items-center" method="post" action="{{route('tasks.updateStatus',$task->id)}}">
                    @csrf
                    <flux:input name="status" type="hidden" value="0"></flux:input>
                    <flux:button class="ms-3 cursor-pointer" type="submit" variant="primary">Mark as incomplete</flux:button>
                </form>
            @else
                <form class="flex items-center" method="post" action="{{route('tasks.updateStatus',$task->id)}}">
                    @csrf
                    <flux:input name="status" type="hidden" value="1"></flux:input>
                    <flux:button class="ms-3 cursor-pointer" type="submit" variant="primary">Mark as complete</flux:button>
                </form>
            @endif
        </div>
    </div>
    <flux:separator class="my-3"/>
    <flux:heading size="lg">Description</flux:heading>
    <flux:text class="mt-2">{{$task->description}}</flux:text>
    <div class="relative overflow-hidden rounded-t-lg my-6">
        <table class=" w-full text-sm text-center rtl:text-right text-zinc-500 dark:text-zinc-400">
            <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-200">
            <tr>
                <th class="px-6 py-3">Creation date</th>
                <th class="px-6 py-3">Priority</th>
                <th class="px-6 py-3">Due date</th>
                <th class="px-6 py-3">update date</th>
                <th class="px-6 py-3"></th>
            </tr>
            </thead>

            <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 border-zinc-200">
                <td class="px-6 py-4">{{$task->created_at->format('d/m/Y')}}</td>
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
                <td class="px-6 py-4">{{$task->due_date->format('d/m/Y')}}</td>
                <td class="px-6 py-4">{{$task->updated_at->format('d/m/Y')}}</td>
                <td class="py-4 pe-2 flex items-center">
                    @if($task->status)
                        <flux:tooltip content="Mark as incomplete to edit">
                            <flux:button size="sm" variant="subtle">Edit</flux:button>
                        </flux:tooltip>
                    @else
                        <flux:button size="sm" href="{{route('tasks.edit',$task->id)}}" variant="primary">Edit</flux:button>
                    @endif
                        <flux:modal.trigger name="delete-task{{$task->id}}">
                            <flux:icon.trash  variant="solid" class="ms-2 text-red-500 cursor-pointer"/>
                        </flux:modal.trigger>
                        <flux:modal name="delete-task{{$task->id}}" class="cursor-default min-w-[22rem] flux-modal">
                            <div class="space-y-6 text-start">
                                <div>
                                    <flux:heading size="lg">Delete task?</flux:heading>
                                    <flux:text class="mt-2">
                                        <p>You're about to delete this task.</p>
                                    </flux:text>
                                </div>
                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button class="cursor-pointer" variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <form method="post" action="{{route('tasks.destroy',$task->id)}}">
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
        </table>
    </div>

    <div class="my-6">
        <flux:heading class="my-4" size="lg">Files attached</flux:heading>
        @forelse($task->tasks_attachment as $attachment)
            <a class="block text-sky-400" target="_blank" href="{{Storage::url($attachment->file_path)}}">{{$attachment->file_name}}</a>
        @empty
            <p class=" text-zinc-600">No files attached to this task</p>
        @endforelse

        <form class="my-6" method="POST" action="{{ route('attachments.store', $task->id) }}" enctype="multipart/form-data">
            @csrf
            <flux:input class="" multiple type="file" name="attachment[]"/>
            <flux:button variant="primary" class="cursor-pointer mt-3" type="submit">Upload attachments</flux:button>
        </form>
        <flux:separator class="my-4"/>
    </div>
    <div>
        <flux:heading size="xl">Task History</flux:heading>
        <table class=" w-full mt-4 text-sm text-center rtl:text-right text-zinc-500 dark:text-zinc-400">
            <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-200">
            <tr>
                <th class="px-6 py-3">User</th>
                <th class="px-6 py-3">Action</th>
                <th class="px-6 py-3">Old value</th>
                <th class="px-6 py-3">New value</th>
                <th class="px-6 py-3">Date & Hour</th>
            </tr>
            </thead>
            @forelse($task->tasks_history as $change)
                <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 border-zinc-200">
                    <td class="px-6 py-4">
                        <flux:profile
                            name="{{$change->user->name}}"
                            avatar="{{Storage::url('img/profilePictures/'. ($change->user->profile_photo ?? 'default.png'))}}"
                            :chevron="false"
                            class="my-2 shrink-0  m-auto"
                        />
                    </td>
                    <td class="px-6 py-4">{{$change->action}}</td>
                    @if($change->action == "status changed")
                        <td class="px-6 py-4">
                            @if($change->old_value)
                                <flux:heading class="text-green-500" size="lg">Completed</flux:heading>
                            @else
                                <flux:heading class="text-red-500" size="lg">Incomplete</flux:heading>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($change->new_value)
                                <flux:heading class="text-green-500" size="lg">Completed</flux:heading>
                            @else
                                <flux:heading class="text-red-500" size="lg">Incomplete</flux:heading>
                            @endif
                        </td>
                    @elseif($change->action == "due date changed")
                        <td class="px-6 py-4">{{\Carbon\Carbon::parse($change->old_value)->format('d/m/Y')}}</td>
                        <td class="px-6 py-4">{{\Carbon\Carbon::parse($change->new_value)->format('d/m/Y')}}</td>
                    @elseif($change->action == "description changed")
                        <td class="px-6 py-4">
                            <flux:modal.trigger class="cursor-pointer" name="show-old-description{{$change->id}}">
                                <flux:heading class="" size="lg">Old description</flux:heading>
                            </flux:modal.trigger>
                            <flux:modal name="show-old-description{{$change->id}}" class="cursor-default md:w-96  flux-modal">
                                <div class="space-y-6">
                                    <flux:heading size="lg">Old description</flux:heading>
                                    <flux:text class="mt-2">{{$change->old_value}}</flux:text>
                                </div>
                            </flux:modal>
                        </td>
                        <td class="px-6 py-4">
                            <flux:modal.trigger class="cursor-pointer" name="show-new-description{{$change->id}}">
                                <flux:heading class="" size="lg">New description</flux:heading>
                            </flux:modal.trigger>
                            <flux:modal name="show-new-description{{$change->id}}" class="cursor-default md:w-96  flux-modal">
                                <div class="space-y-6">
                                    <flux:heading size="lg">New description</flux:heading>
                                    <flux:text class="mt-2">{{$change->new_value}}</flux:text>
                                </div>
                            </flux:modal>
                        </td>
                    @elseif($change->action == "priority changed")
                        <td class="px-6 py-4">
                            @if($change->old_value == "Low")
                                <p class="text-green-500" >{{ $change->old_value }}</p>
                            @elseif($change->old_value == "Medium")
                                <p class="text-yellow-500" >{{ $change->old_value }}</p>
                            @elseif($change->old_value == "High")
                                <p class="text-orange-500" >{{ $change->old_value }}</p>
                            @else
                                <p class="text-red-500" >{{ $change->old_value }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($change->new_value == "Low")
                                <p class="text-green-500" >{{ $change->new_value }}</p>
                            @elseif($change->new_value == "Medium")
                                <p class="text-yellow-500" >{{ $change->new_value }}</p>
                            @elseif($change->new_value == "High")
                                <p class="text-orange-500" >{{ $change->new_value }}</p>
                            @else
                                <p class="text-red-500" >{{ $change->new_value }}</p>
                            @endif
                        </td>
                    @elseif($change->action == 'category changed')
                        <td class="px-6 py-4">
                            <flux:badge size="sm" class="mx-2" color="{{ $categories->firstWhere('id', $change->old_value)?->color_code}}">{{ $categories->firstWhere('id', $change->old_value)?->name }}</flux:badge>
                        </td>
                        <td class="px-6 py-4">
                            <flux:badge size="sm" class="mx-2" color="{{ $categories->firstWhere('id', $change->new_value)?->color_code}}">{{ $categories->firstWhere('id', $change->new_value)?->name }}</flux:badge>
                        </td>
                    @else
                        <td class="px-6 py-4">{{$change->old_value}}</td>
                        <td class="px-6 py-4">{{$change->new_value}}</td>
                    @endif
                    <td class="px-6 py-4">
                        {{$change->created_at->format('d/m/Y')}}
                        <br>
                        {{$change->created_at->format('H:i:s')}}
                    </td>
            @empty
                    <td class="px-6 py-4" colspan="6">No changes were made to this task</td>

                </tr>
            @endforelse
        </table>



        <flux:separator class="my-4"/>
    </div>

    <div>
        <flux:heading size="xl">Comments</flux:heading>
        <form class="my-2" method="POST" action="{{ route('comments.store', $task->id) }}">
            @csrf
            <flux:textarea name="comment" placeholder="Write your comment..." required/>
            <flux:button variant="primary" class="my-3 cursor-pointer" type="submit">Send</flux:button>
        </form>
    @foreach($task->tasks_comments as $comment)
            <div class="my-4">
                <div class="flex">
                    <flux:profile
                        name="{{$comment->user->name}}"
                        avatar="{{Storage::url('img/profilePictures/'. ($comment->user->profile_photo ?? 'default.png'))}}"
                        :chevron="false"
                        class="my-2 shrink-0"
                    />
                    <flux:badge class="my-2" size="sm" variant="">{{$comment->created_at->format('d/m/Y H:i:s')}}</flux:badge>
                </div>

                <flux:text class="">{{$comment->comment}}</flux:text>
            </div>
        @endforeach
        <flux:separator class="my-3"/>
    </div>
{{--    <flux:select wire:model="category" placeholder="Choose industry...">--}}
{{--        <flux:select.option id="awdawd">Photography</flux:select.option>--}}
{{--        <flux:select.option>Design services</flux:select.option>--}}
{{--        <flux:select.option>Web development</flux:select.option>--}}
{{--        <flux:select.option>Accounting</flux:select.option>--}}
{{--        <flux:select.option>Legal services</flux:select.option>--}}
{{--        <flux:select.option>Consulting</flux:select.option>--}}
{{--        <flux:select.option>Other</flux:select.option>--}}
{{--    </flux:select>--}}
</x-layouts.app>

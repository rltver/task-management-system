<x-layouts.app :title="__('Update Task')">
    <flux:heading size="xl">Update Task</flux:heading>
    <flux:separator  class="mb-6 mt-3"></flux:separator>




    <flux:fieldset>
        <form class="my-2" method="POST" action="{{ route('tasks.update',$task->id) }}" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="space-y-6">
                <flux:input value="{{$task->title}}" class="" name="title" label="Title" required/>
                <flux:textarea badge="Optional" class="" label="Description" name="description" placeholder="Write your comment...">
                    {{$task->description}}
                </flux:textarea>
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                    <flux:input class="" value="{{$task->due_date->toDateString()}}" type="date" name="due_date" max="2999-12-31" label="Due date" required />
                    <flux:select class="" label="Category"  name="category_id" placeholder="Choose category..." required>
                        @foreach($categories as $category)
                            <flux:select.option :selected="$task->category_id == $category->id" value="{{$category->id}}">{{$category->name}}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select class="" label="Priority" name="priority" placeholder="Choose priority..." required>
                        <flux:select.option :selected="$task->priority === 'Low'" value="Low" >Low</flux:select.option>
                        <flux:select.option :selected="$task->priority === 'Medium'"  value="Medium"  >Medium</flux:select.option>
                        <flux:select.option :selected="$task->priority === 'High'"  value="High"  >High</flux:select.option>
                        <flux:select.option :selected="$task->priority === 'Urgent'"  value="Urgent"  >Urgent</flux:select.option>
                    </flux:select>
{{--                    <flux:input class="" multiple type="file"  badge="Optional" name="attachment[]" label="Attachment/s"/>--}}
                </div>
                <flux:button variant="primary" class="cursor-pointer" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:fieldset>
</x-layouts.app>

{{--@php--}}
{{--var_dump($task->due_date);--}}
{{--echo "<br>";--}}
{{--echo "<br>";--}}
{{--echo $task->due_date;--}}
{{--echo "<br>";--}}
{{--echo "<br>";--}}
{{--echo $task->due_date->toDateString();--}}
{{-- @endphp--}}


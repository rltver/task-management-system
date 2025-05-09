<x-layouts.app :title="__('Create task')">
    <flux:heading size="xl">Task creation</flux:heading>
    <flux:separator  class="mb-6 mt-3"></flux:separator>




    <flux:fieldset>
        <form class="my-2" method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <flux:input class="" name="title" label="Title" required/>
                <flux:textarea badge="Optional" class="" label="Description" name="description" placeholder="Write your comment..."/>
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                    <flux:input class="" type="date" name="due_date" min="{{ now()->toDateString() }}" max="2999-12-31" label="Due date" required />
                    <flux:select class="" label="Category"  name="category_id" placeholder="Choose category..." required>
                        @foreach($categories as $category)
                            <flux:select.option value="{{$category->id}}">{{$category->name}}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:select class="" label="Priority" name="priority" placeholder="Choose priority..." required>
                        <flux:select.option value="Low">Low</flux:select.option>
                        <flux:select.option value="Medium">Medium</flux:select.option>
                        <flux:select.option value="High">High</flux:select.option>
                        <flux:select.option value="Urgent">Urgent</flux:select.option>
                    </flux:select>
                    <flux:input class="" multiple type="file"  badge="Optional" name="attachment[]" label="Attachment/s"/>
                </div>
                <flux:button variant="primary" class="cursor-pointer" type="submit">Send</flux:button>
            </div>
        </form>
    </flux:fieldset>
</x-layouts.app>

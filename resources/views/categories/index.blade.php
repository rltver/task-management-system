<x-layouts.app :title="__('Categories')">
    <div class="flex justify-between items-center m-2 mb-10">
        <flux:heading size="xl">Categories List</flux:heading>
        <div>
            <flux:modal.trigger name="create-category">
                <flux:button variant="primary" class="cursor-pointer">Create</flux:button>
            </flux:modal.trigger>
            <flux:modal name="create-category" class="md:w-96 modal">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Create category</flux:heading>
                        <flux:text class="mt-2">Make changes to your personal details.</flux:text>
                    </div>

                    <form class="my-2 space-y-6" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                        @csrf

                        <flux:input label="Name" name="name" placeholder="Category name" required/>
                        <flux:input label="Description" name="description" placeholder="Category description" required/>
                        <flux:select label="Parent category" badge="optional" name="parent_id" placeholder="Choose parent category...">
                            <flux:select.option value="">None</flux:select.option>
                        @foreach($parentCategories as $category)
                                <flux:select.option value="{{$category->id}}">{{$category->name}}</flux:select.option>
                        @endforeach
                        </flux:select>

                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a color</label>
                        <div class="grid p-2 grid-cols-2 gap-2">
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 checked:border-b-zinc-500 border-zinc-500 dark:checked:border-white checked:border-4" type="radio" name="color_code" value="zinc" checked>
                                <flux:badge size="sm" color="zinc">Zinc</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="red">
                                <flux:badge size="sm" color="red">Red</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="orange">
                                <flux:badge size="sm" color="orange">Orange</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="amber">
                                <flux:badge size="sm" color="amber">Amber</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="yellow">
                                <flux:badge size="sm" color="yellow">Yellow</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="lime">
                                <flux:badge size="sm" color="lime">Lime</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="green">
                                <flux:badge size="sm" color="green">Green</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="emerald">
                                <flux:badge size="sm" color="emerald">Emerald</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="teal">
                                <flux:badge size="sm" color="teal">Teal</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="cyan">
                                <flux:badge size="sm" color="cyan">Cyan</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="sky">
                                <flux:badge size="sm" color="sky">Sky</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="blue">
                                <flux:badge size="sm" color="blue">Blue</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="indigo">
                                <flux:badge size="sm" color="indigo">Indigo</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="violet">
                                <flux:badge size="sm" color="violet">Violet</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="purple">
                                <flux:badge size="sm" color="purple">Purple</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="fuchsia">
                                <flux:badge size="sm" color="fuchsia">Fuchsia</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="pink">
                                <flux:badge size="sm" color="pink">Pink</flux:badge>
                            </label>
                            <label class="flex items-center mb-2">
                                <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="rose">
                                <flux:badge size="sm" color="rose">Rose</flux:badge>
                            </label>
                        </div>


                        <div class="flex">
                            <flux:spacer />

                            <flux:button type="submit" variant="primary">Save</flux:button>
                        </div>

                    </form>
                </div>
            </flux:modal>
        </div>
    </div>

    <div class="relative overflow-hidden rounded-t-lg">
        <table class="text-sm text-left rtl:text-right text-zinc-500 dark:text-zinc-400 w-full">
            <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-200">
            <tr>
                <th class="px-6 py-3 w-24">Category</th>
                <th class="px-6 py-3 text-center w-16">Sub Categories</th>
                <th class="px-6 py-3"></th>
            </tr>
            </thead>
            <tbody id="sortable">
                @forelse($parentCategories as $category)
                    <tr data-id="{{$category->id}}" class="cursor-move bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 border-zinc-200">
                        <td class="px-6 py-4  w-24">
                            <flux:modal.trigger class="cursor-pointer" name="show-description{{$category->id}}">
                                <flux:badge size="" class="mx-2" color="{{$category->color_code}}">{{$category->name}}</flux:badge>
                            </flux:modal.trigger>
                            <flux:modal name="show-description{{$category->id}}" class="cursor-default md:w-96  flux-modal">
                                <div class="space-y-6">
                                    <flux:heading size="lg">Description</flux:heading>
                                    <flux:text class="mt-2">{{$category->description}}</flux:text>
                                </div>
                            </flux:modal>
                        </td>
                        <td class="px-6 py-4 w-16 text-center">
                            <flux:modal.trigger  name="show-children{{$category->id}}">
                                <flux:button class="cursor-pointer">{{$category->children_count}}</flux:button>
                            </flux:modal.trigger>
                            <flux:modal name="show-children{{$category->id}}" class="cursor-default md:w-96  flux-modal">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">{{$category->name}} related categories</flux:heading>
                                    </div>
                                    @forelse($category->children as $subCategory)
                                        <div class="flex">
                                            <flux:badge size="" class="mx-2" color="{{$subCategory->color_code}}">{{$subCategory->name}}</flux:badge>
                                            <form method="post" action="{{route('categories.destroy',$subCategory->id)}}">
                                                @method('delete')
                                                @csrf
                                                <flux:button type="submit" variant="danger">
                                                    <flux:icon.trash/>
                                                </flux:button>
                                            </form>
                                        </div>
                                        <flux:text class="mt-2 text-left">{{$subCategory->description}}</flux:text>
                                        <flux:separator></flux:separator>
                                    @empty
                                        <flux:text class="mt-2">This category doesn't have subcategories</flux:text>

                                    @endforelse
                                </div>
                            </flux:modal>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end">
                                <flux:modal.trigger name="update-category{{$category->id}}">
                                    <flux:icon.arrow-path variant="solid" class="text-blue-500 dark:text-blue-300 cursor-pointer" />                        </flux:modal.trigger>
                                <flux:modal name="update-category{{$category->id}}" class="cursor-default md:w-96  flux-modal">
                                    <div class="space-y-6">
                                        <div>
                                            <flux:heading size="lg">Update category</flux:heading>
                                            <flux:text class="mt-2">Make changes to your personal details.</flux:text>
                                        </div>

                                        <form class="my-2 space-y-6" method="POST" action="{{ route('categories.update',$category->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <flux:input label="Name" name="name" value="{{$category->name}}" placeholder="Category name" required/>
                                            <flux:input label="Description" value="{{$category->description}}" name="description" placeholder="Category description" required/>
                                            {{--                                    <flux:select label="Parent category" badge="optional" name="parent_id" placeholder="Choose parent category...">--}}
                                            {{--                                        <flux:select.option value="">None</flux:select.option>--}}
                                            {{--                                        @foreach($parentCategories as $parentCategory)--}}
                                            {{--                                            <flux:select.option value="{{$parentCategory->id}}">{{$parentCategory->name}}</flux:select.option>--}}
                                            {{--                                        @endforeach--}}
                                            {{--                                    </flux:select>--}}

                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a color</label>
                                            <div class="grid p-2 grid-cols-2 gap-2">
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="zinc"  @if("zinc"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="zinc">Zinc</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="red" @if("red"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="red">Red</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="orange" @if("orange"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="orange">Orange</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="amber" @if("amber"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="amber">Amber</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="yellow" @if("yellow"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="yellow">Yellow</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="lime" @if("lime"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="lime">Lime</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="green" @if("green"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="green">Green</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="emerald" @if("emerald"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="emerald">Emerald</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="teal" @if("teal"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="teal">Teal</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="cyan" @if("cyan"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="cyan">Cyan</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="sky" @if("sky"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="sky">Sky</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="blue" @if("blue"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="blue">Blue</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="indigo" @if("indigo"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="indigo">Indigo</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="violet" @if("violet"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="violet">Violet</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="purple" @if("purple"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="purple">Purple</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="fuchsia" @if("fuchsia"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="fuchsia">Fuchsia</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="pink" @if("pink"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="pink">Pink</flux:badge>
                                                </label>
                                                <label class="flex cursor-pointer items-center mb-2">
                                                    <input class="me-3 appearance-none w-4 h-4 rounded-full border-2 border-zinc-500 checked:border-b-zinc-500  dark:checked:border-white checked:border-4" type="radio" name="color_code" value="rose" @if("rose"==$category->color_code)checked @endif>
                                                    <flux:badge size="sm" color="rose">Rose</flux:badge>
                                                </label>
                                            </div>


                                            <div class="flex">
                                                <flux:spacer />

                                                <flux:button type="submit" variant="primary">Save</flux:button>
                                            </div>

                                        </form>
                                    </div>
                                </flux:modal>


                                <flux:modal.trigger name="delete-category{{$category->id}}">
                                    <flux:icon.trash  variant="solid" class="ms-2 text-red-500 cursor-pointer"/>
                                </flux:modal.trigger>
                                <flux:modal name="delete-category{{$category->id}}" class="cursor-default min-w-[22rem] flux-modal">
                                    <div class="space-y-6">
                                        <div>
                                            <flux:heading size="lg">Delete category?</flux:heading>
                                            <flux:text class="mt-2">
                                                <p>You're about to delete this category.</p>
                                                <p>This action cannot be reversed.</p>
                                            </flux:text>
                                        </div>
                                        <div class="flex gap-2">
                                            <flux:spacer />
                                            <flux:modal.close>
                                                <flux:button class="cursor-pointer" variant="ghost">Cancel</flux:button>
                                            </flux:modal.close>
                                            <form method="post" action="{{route('categories.destroy',$category->id)}}">
                                                @method('delete')
                                                @csrf
                                                <flux:button type="submit" class="cursor-pointer" variant="danger">
                                                    Delete category
                                                </flux:button>
                                            </form>
                                        </div>
                                    </div>
                                </flux:modal>
                            </div>



                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-2 text-2xl">
                            No results
                        </td></tr>
                @endforelse
            </tbody>
            <tr>
                <td class="px-6 py-4 bg-zinc-800" colspan="6">{{$categories->links()}}</td>
            </tr>
        </table>
    </div>
    <script>
        $(function () {
            const $sortable = $("#sortable");

            $sortable.sortable({
                update: function (event, ui) {
                    let order = [];

                    $('#sortable tr').each(function (index, element) {
                        order.push({
                            id: $(element).data('id'),
                            order: index + 1
                        });
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ route('categories.reorder') }}",
                        data: {
                            order: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            console.log('Orden actualizado');
                        },
                        error: function (err) {
                            console.error(err);
                        }
                    });
                }
            });

            function checkModals() {
                const openModal = document.querySelector('flux\\:modal[open], .flux-modal[open]');
                if (openModal) {
                    $sortable.sortable("disable");
                } else {
                    $sortable.sortable("enable");
                }
            }

            // cheking for changes in "open" attributes in modals
            const observer = new MutationObserver(checkModals);

            document.querySelectorAll('flux\\:modal.flux-modal').forEach(modal => {
                observer.observe(modal, { attributes: true, attributeFilter: ['open'] });
            });

            // Por si el atributo tarda en aplicarse
            document.addEventListener('click', () => {
                setTimeout(checkModals, 100);
            });

            // También al cargar
            checkModals();
        });


    </script>
    </x-layouts.app>


    <?php
//var_dump($tasks[0]->due_date);
    ?>



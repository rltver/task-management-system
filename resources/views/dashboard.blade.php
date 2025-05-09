<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid gap-4">

{{--       General statistics     --}}
            <div class="overflow-hidden h-full rounded-xl border border-neutral-200 dark:border-neutral-700 ">
                <div class="grid gap-4 grid-cols-3 p-4">
                    <p class="bg-zinc-800 text-white dark:text-zinc-800 dark:bg-white text-[clamp(0.5rem,1.75vw,1rem)] py-2 px-3 rounded-xl font-bold">Tasks:<br> <span class="text-[clamp(1rem,2.5vw,2rem)]">{{$totalTasks}}</span></p>
                    <p class="bg-zinc-800 text-white dark:text-zinc-800 dark:bg-white text-[clamp(0.5rem,1.75vw,1rem)] py-2 px-3 rounded-xl font-bold">Tasks completed:<br> <span class="text-[clamp(1rem,2.5vw,2rem)]">{{$completedTasks}}%</span></p>
                    <p class="bg-zinc-800 text-white dark:text-zinc-800 dark:bg-white text-[clamp(0.5rem,1.75vw,1rem)] py-2 px-3 rounded-xl font-bold">Overdue tasks:<br> <span class="text-[clamp(1rem,2.5vw,2rem)]">{{$overdueTasks}}</span></p>
                </div>
                <div class="flex justify-end p-4">
                    <flux:button href="{{ route('generalStatisticsPdf') }}" variant="primary">Export to PDF</flux:button>
                </div>
                {{--tasks by category graph--}}
                    <canvas id="taskPerCategoryChart" class="w-full h-full p-4"></canvas>

            </div>

            {{--Tasks completion rate graph--}}
            <div class="overflow-hidden h-full rounded-xl border border-neutral-200 dark:border-neutral-700 ">
                <div class="p-4 flex justify-between items-center">
                    <flux:heading size="xl">Tasks completion rate</flux:heading>
{{--                    this form is for chossing the range of time--}}
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-4">
                        <flux:select  name="range"  onchange="this.form.submit()">
                            <flux:select.option :selected="$range == 'daily'" value="daily">Daily</flux:select.option>
                            <flux:select.option :selected="$range == 'weekly'" value="weekly">Weekly</flux:select.option>
                            <flux:select.option :selected="$range == 'monthly'" value="monthly">Monthly</flux:select.option>
                        </flux:select>
                    </form>
                </div>

                <canvas id="completionChart" class="w-full p-4 "></canvas>
            </div>
{{--            user performance table--}}
            <div class="overflow-hidden h-full rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="p-4 flex justify-between items-center">
                    <flux:heading size="xl">User performance</flux:heading>
                    <div>
                        <flux:button href="{{ route('userPerformanceCsv') }}" variant="primary">Export to CSV</flux:button>
                        <flux:button href="{{ route('userPerformancePdf') }}" variant="primary">Export to PDF</flux:button>
                    </div>
                </div>

                <table class="w-full text-sm text-left rtl:text-right text-zinc-500 dark:text-zinc-400">
                    <thead class="text-xs text-zinc-700 uppercase bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-200">
                    <tr>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Completed tasks</th>
                        <th class="px-6 py-3">Tasks completed on time</th>
                    </tr>
                    </thead>
                    @foreach($users as $user)
                        <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700 border-zinc-200">
                            <td class="px-6 py-4">
                                <flux:profile
                                    name="{{$user->name}}"
                                    avatar="{{Storage::url('img/profilePictures/'. ($user->profile_photo ?? 'default.png'))}}"
                                    :chevron="false"
                                />
                            </td>
                            <td class="px-6 py-4">{{$user->tasks->where('status',1)->count()}}</td>
                            <td class="px-6 py-4">
                                @if($user->tasks->where('status',1)->count())
{{--                                    {{$user->tasks->where('status',1)->where('updated_at','<=','due_date')->count() *100/$user->tasks->where('status',1)->count()}}%--}}
                                    {{round($user->tasks->where('status', 1)->filter(function ($task){return $task->updated_at <= $task->due_date;})->count()*100/$user->tasks->where('status',1)->count(),'2')}}%
                                @else
                                    No tasks
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded',()=>{
            taskPerCategory()
            completionChart()
        })
        const taskPerCategory =()=>{
            const ctx = document.getElementById('taskPerCategoryChart').getContext('2d');

            // Datos pasados desde el controlador
            const categories = @json($categories);

            const labels = categories.map(item => item.name);
            const values = categories.map(item => item.tasks_count);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label:'Tasks with this category',
                        data: values,
                        backgroundColor: categories.map(item => item.color_code),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins:{
                        title: {
                            display: false
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        const completionChart = ()=>{
            const ctx = document.getElementById('completionChart');
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Tasks completed',
                        data: {!! json_encode($values) !!},
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>
    @endpush
</x-layouts.app>

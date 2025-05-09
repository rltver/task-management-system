<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('tasks')->get();

        $range = $request->get('range','daily');

        switch ($range) {
            case 'weekly':
                $group = DB::raw('YEARWEEK(updated_at) as period');
                break;
            case 'monthly':
                $group = DB::raw('DATE_FORMAT(updated_at, "%Y-%m") as period');
                break;
            default:
                $group = DB::raw('DATE(updated_at) as period');
        }

        $tasks  = DB::table('tasks')
            ->select($group,DB::raw('count(*) as total'))
            ->where('status',1)
            ->where('updated_at','>=',Carbon::now()->subDays(90))
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $labels = $tasks->pluck('period')->map(function ($p) use ($range) {
            return match($range) {
                'monthly' => Carbon::createFromFormat('Y-m', $p)->format('F Y'),
                'weekly' => 'Semana ' . substr($p, 4) . ' - ' . substr($p, 0, 4),
                default => Carbon::parse($p)->format('d M'),
            };
        });
        $values = $tasks->pluck('total');

        $users = User::with('tasks')->get();



        $totalTasks  = Task::all()->count();
        $completedTasks  = round(Task::where('status',1)->count() / $totalTasks * 100,2);
        $overdueTasks  = Task::whereDate('due_date','<',now())->count();
        return view('dashboard',
            compact(
                'totalTasks',
                'completedTasks',
                'overdueTasks',
                'categories',
                'range',
                'values',
                'labels',
                'users'
            ));
    }

    public function userPerformanceCsv()
    {
        $users = User::with('tasks')->get();

        $csvData = [];

        $csvData[] = ['User', 'Completed Tasks', 'Tasks Completed On Time'];

        foreach ($users as $user) {
            $completed = $user->tasks->where('status', 1);
            $onTime = $completed->filter(fn($t) => $t->updated_at <= $t->due_date);

            $csvData[] = [
                $user->email,
                $completed->count(),
                $onTime->count()
            ];
        }

        $filename = 'users_performance_report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://temp', 'r+');

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
        ]);
    }


    public function generalStatisticsPdf()
    {
        $categories = Category::with('tasks')->get();
        $totalTasks  = Task::all()->count();
        $completedTasks  = round(Task::where('status',1)->count() / $totalTasks * 100,2);
        $overdueTasks  = Task::whereDate('due_date','<',now())->count();


        $pdf = PDF::loadView('export.generalStatistics', compact('categories', 'totalTasks', 'completedTasks', 'overdueTasks'));

        return $pdf->download('users_report.pdf');
    }
    public function userPerformancePdf()
    {
        $users = User::with('tasks')->get();


        $pdf = PDF::loadView('export.userPerformance', compact('users'));

        return $pdf->download('users_performance_report.pdf');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

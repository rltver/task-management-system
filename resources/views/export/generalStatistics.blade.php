<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: ghostwhite;
        }
        b{
            color: red;
        }
    </style>
</head>
<body>
    <h2>General Statistics</h2>

    <ul>
        <li><p>Tasks: <b class="">{{$totalTasks}}</b></p></li>
        <li><p>Tasks completed: <b class="">{{$completedTasks}}%</b></p></li>
        <li><p>Overdue tasks: <b class="">{{$overdueTasks}}</b></p></li>
    </ul>

    <table>
        <tr><th>Category</th><th>Nº of tasks</th></tr>
        @foreach($categories as $categorie)
            <tr>
                <td>{{$categorie->name}}</td>
                <td>{{$categorie->tasks->count()}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>

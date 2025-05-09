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
        .user{
            display: flex;
            align-items: center;
        }
        img{
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <h2>User performance</h2>

    <table>
        <tr>
            <th class="">User</th>
            <th class="">Completed tasks</th>
            <th class="">Tasks completed on time</th>
        </tr>
        @foreach($users as $user)
            <tr class="">
                <td class="">
                    <b>{{$user->name}}</b>
                </td>
                <td class="">{{$user->tasks->where('status',1)->count()}}</td>
                <td class="">
                    @if($user->tasks->where('status',1)->count())
                        {{$user->tasks->where('status',1)->where('updated_at','<=','due_date')->count() *100/$user->tasks->where('status',1)->count()}}%
                    @else
                        No tasks
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>

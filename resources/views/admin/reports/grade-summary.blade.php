<!DOCTYPE html>
<html>
<head>
    <title>Grade Summary</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Grade Summary</h1>

    @foreach($grades as $subject => $gradesBySubject)
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Subject</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gradesBySubject as $grade)
                    <tr>
                        <td>{{ $grade->student->full_name }}</td>
                        <td>{{ $grade->student->student_id }}</td>
                        <td>{{ $grade->subject }}</td>
                        <td>{{ $grade->grade }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>

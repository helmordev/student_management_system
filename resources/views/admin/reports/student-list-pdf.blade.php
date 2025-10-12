<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
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
    <h1>Student List</h1>

    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->student_id }}</td>
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->course }}</td>
                    <td>{{ $student->year_level }}</td>
                    <td>{{ $student->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

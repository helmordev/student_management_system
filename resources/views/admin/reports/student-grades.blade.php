<!DOCTYPE html>
<html>
<head>
    <title>Student Grades</title>
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
    <h1>{{ $student->full_name }} - Grades</h1>
    <p>Student ID: {{ $student->student_id }}</p>

    @foreach($grades->groupBy('academic_year') as $year => $gradesByYear)
        <h2>Academic Year: {{ $year }}</h2>
        @foreach($gradesByYear->groupBy('semester') as $semester => $gradesBySemester)
            <h3>Semester: {{ $semester }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gradesBySemester as $grade)
                        <tr>
                            <td>{{ $grade->subject }}</td>
                            <td>{{ $grade->grade }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach

</body>
</html>

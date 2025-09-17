<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    public function index()
    {
        // Mock data for students - replace with actual model
        $students = collect([
            (object)[
                'id' => 1,
                'nis' => '2023001',
                'name' => 'Ahmad Rizki Pratama',
                'class' => 'VIII A',
                'gender' => 'L',
                'birth_date' => '2008-05-15',
                'birth_place' => 'Jakarta',
                'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'phone' => '081234567890',
                'email' => 'ahmad.rizki@student.school.id',
                'parent_name' => 'Budi Pratama',
                'parent_phone' => '081234567891',
                'enrollment_date' => '2023-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Islam',
                'blood_type' => 'A',
                'height' => 165,
                'weight' => 55
            ],
            (object)[
                'id' => 2,
                'nis' => '2023002',
                'name' => 'Siti Nurhaliza',
                'class' => 'VIII A',
                'gender' => 'P',
                'birth_date' => '2008-03-22',
                'birth_place' => 'Bandung',
                'address' => 'Jl. Sudirman No. 456, Bandung',
                'phone' => '081234567892',
                'email' => 'siti.nurhaliza@student.school.id',
                'parent_name' => 'Sari Nurhaliza',
                'parent_phone' => '081234567893',
                'enrollment_date' => '2023-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Islam',
                'blood_type' => 'B',
                'height' => 158,
                'weight' => 48
            ],
            (object)[
                'id' => 3,
                'nis' => '2023003',
                'name' => 'Budi Santoso',
                'class' => 'VIII B',
                'gender' => 'L',
                'birth_date' => '2008-08-10',
                'birth_place' => 'Surabaya',
                'address' => 'Jl. Pahlawan No. 789, Surabaya',
                'phone' => '081234567894',
                'email' => 'budi.santoso@student.school.id',
                'parent_name' => 'Agus Santoso',
                'parent_phone' => '081234567895',
                'enrollment_date' => '2023-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Kristen',
                'blood_type' => 'O',
                'height' => 170,
                'weight' => 60
            ],
            (object)[
                'id' => 4,
                'nis' => '2023004',
                'name' => 'Dewi Lestari',
                'class' => 'VII A',
                'gender' => 'P',
                'birth_date' => '2009-01-18',
                'birth_place' => 'Yogyakarta',
                'address' => 'Jl. Malioboro No. 321, Yogyakarta',
                'phone' => '081234567896',
                'email' => 'dewi.lestari@student.school.id',
                'parent_name' => 'Indra Lestari',
                'parent_phone' => '081234567897',
                'enrollment_date' => '2023-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Hindu',
                'blood_type' => 'AB',
                'height' => 155,
                'weight' => 45
            ],
            (object)[
                'id' => 5,
                'nis' => '2023005',
                'name' => 'Andi Wijaya',
                'class' => 'IX A',
                'gender' => 'L',
                'birth_date' => '2007-11-05',
                'birth_place' => 'Medan',
                'address' => 'Jl. Gatot Subroto No. 654, Medan',
                'phone' => '081234567898',
                'email' => 'andi.wijaya@student.school.id',
                'parent_name' => 'Rudi Wijaya',
                'parent_phone' => '081234567899',
                'enrollment_date' => '2022-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Islam',
                'blood_type' => 'A',
                'height' => 172,
                'weight' => 65
            ],
            (object)[
                'id' => 6,
                'nis' => '2023006',
                'name' => 'Maya Sari',
                'class' => 'IX B',
                'gender' => 'P',
                'birth_date' => '2007-09-12',
                'birth_place' => 'Makassar',
                'address' => 'Jl. Hasanuddin No. 987, Makassar',
                'phone' => '081234567900',
                'email' => 'maya.sari@student.school.id',
                'parent_name' => 'Hasan Sari',
                'parent_phone' => '081234567901',
                'enrollment_date' => '2022-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Islam',
                'blood_type' => 'B',
                'height' => 160,
                'weight' => 50
            ],
            (object)[
                'id' => 7,
                'nis' => '2023007',
                'name' => 'Rudi Hermawan',
                'class' => 'VII B',
                'gender' => 'L',
                'birth_date' => '2009-04-28',
                'birth_place' => 'Palembang',
                'address' => 'Jl. Ampera No. 147, Palembang',
                'phone' => '081234567902',
                'email' => 'rudi.hermawan@student.school.id',
                'parent_name' => 'Dedi Hermawan',
                'parent_phone' => '081234567903',
                'enrollment_date' => '2023-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Islam',
                'blood_type' => 'O',
                'height' => 162,
                'weight' => 52
            ],
            (object)[
                'id' => 8,
                'nis' => '2023008',
                'name' => 'Lina Marlina',
                'class' => 'VIII A',
                'gender' => 'P',
                'birth_date' => '2008-07-03',
                'birth_place' => 'Semarang',
                'address' => 'Jl. Pandanaran No. 258, Semarang',
                'phone' => '081234567904',
                'email' => 'lina.marlina@student.school.id',
                'parent_name' => 'Tono Marlina',
                'parent_phone' => '081234567905',
                'enrollment_date' => '2023-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Kristen',
                'blood_type' => 'A',
                'height' => 157,
                'weight' => 47
            ],
            (object)[
                'id' => 9,
                'nis' => '2022001',
                'name' => 'Fajar Nugroho',
                'class' => 'IX A',
                'gender' => 'L',
                'birth_date' => '2007-12-20',
                'birth_place' => 'Solo',
                'address' => 'Jl. Slamet Riyadi No. 369, Solo',
                'phone' => '081234567906',
                'email' => 'fajar.nugroho@student.school.id',
                'parent_name' => 'Bambang Nugroho',
                'parent_phone' => '081234567907',
                'enrollment_date' => '2022-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Islam',
                'blood_type' => 'AB',
                'height' => 175,
                'weight' => 68
            ],
            (object)[
                'id' => 10,
                'nis' => '2022002',
                'name' => 'Rina Kusuma',
                'class' => 'IX B',
                'gender' => 'P',
                'birth_date' => '2007-06-14',
                'birth_place' => 'Denpasar',
                'address' => 'Jl. Gajah Mada No. 741, Denpasar',
                'phone' => '081234567908',
                'email' => 'rina.kusuma@student.school.id',
                'parent_name' => 'Wayan Kusuma',
                'parent_phone' => '081234567909',
                'enrollment_date' => '2022-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Hindu',
                'blood_type' => 'B',
                'height' => 159,
                'weight' => 49
            ],
            (object)[
                'id' => 11,
                'nis' => '2023009',
                'name' => 'Doni Prasetyo',
                'class' => 'VII A',
                'gender' => 'L',
                'birth_date' => '2009-02-08',
                'birth_place' => 'Balikpapan',
                'address' => 'Jl. Jenderal Sudirman No. 852, Balikpapan',
                'phone' => '081234567910',
                'email' => 'doni.prasetyo@student.school.id',
                'parent_name' => 'Eko Prasetyo',
                'parent_phone' => '081234567911',
                'enrollment_date' => '2023-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Islam',
                'blood_type' => 'O',
                'height' => 160,
                'weight' => 50
            ],
            (object)[
                'id' => 12,
                'nis' => '2023010',
                'name' => 'Sari Indah',
                'class' => 'VII B',
                'gender' => 'P',
                'birth_date' => '2009-10-25',
                'birth_place' => 'Pontianak',
                'address' => 'Jl. Tanjungpura No. 963, Pontianak',
                'phone' => '081234567912',
                'email' => 'sari.indah@student.school.id',
                'parent_name' => 'Joko Indah',
                'parent_phone' => '081234567913',
                'enrollment_date' => '2023-07-15',
                'status' => 'active',
                'photo' => null,
                'religion' => 'Kristen',
                'blood_type' => 'A',
                'height' => 154,
                'weight' => 44
            ]
        ]);

        // Apply filters
        if (request('search')) {
            $students = $students->filter(function ($student) {
                return stripos($student->name, request('search')) !== false ||
                       stripos($student->nis, request('search')) !== false ||
                       stripos($student->email, request('search')) !== false;
            });
        }

        if (request('class')) {
            $students = $students->filter(function ($student) {
                return $student->class === request('class');
            });
        }

        if (request('gender')) {
            $students = $students->filter(function ($student) {
                return $student->gender === request('gender');
            });
        }

        if (request('status')) {
            $students = $students->filter(function ($student) {
                return $student->status === request('status');
            });
        }

        // Apply sorting
        $sortBy = request('sort', 'name');
        switch ($sortBy) {
            case 'name':
                $students = $students->sortBy('name');
                break;
            case 'nis':
                $students = $students->sortBy('nis');
                break;
            case 'class':
                $students = $students->sortBy('class');
                break;
            case 'enrollment_date':
                $students = $students->sortByDesc('enrollment_date');
                break;
            default:
                $students = $students->sortBy('name');
        }

        // Paginate manually
        $perPage = 12;
        $currentPage = request('page', 1);
        $total = $students->count();
        $students = $students->slice(($currentPage - 1) * $perPage, $perPage);

        $students = new \Illuminate\Pagination\LengthAwarePaginator(
            $students,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );

        return view('teacher.students.index', compact('students'));
    }

    public function show($id)
    {
        // Mock data for single student
        $student = (object)[
            'id' => $id,
            'nis' => '2023001',
            'name' => 'Ahmad Rizki Pratama',
            'class' => 'VIII A',
            'gender' => 'L',
            'birth_date' => '2008-05-15',
            'birth_place' => 'Jakarta',
            'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
            'phone' => '081234567890',
            'email' => 'ahmad.rizki@student.school.id',
            'parent_name' => 'Budi Pratama',
            'parent_phone' => '081234567891',
            'parent_email' => 'budi.pratama@gmail.com',
            'enrollment_date' => '2023-07-15',
            'status' => 'active',
            'photo' => null,
            'religion' => 'Islam',
            'blood_type' => 'A',
            'height' => 165,
            'weight' => 55,
            'emergency_contact' => 'Siti Pratama (Ibu)',
            'emergency_phone' => '081234567892',
            'previous_school' => 'SD Negeri 01 Jakarta',
            'hobbies' => 'Membaca, Bermain Sepak Bola',
            'achievements' => 'Juara 1 Olimpiade Matematika Tingkat Kota',
            'medical_notes' => 'Tidak ada riwayat penyakit khusus'
        ];

        // Mock academic data
        $academicData = [
            'current_semester' => 'Ganjil 2023/2024',
            'total_subjects' => 12,
            'average_score' => 85.5,
            'rank_in_class' => 3,
            'total_students_in_class' => 25,
            'attendance_percentage' => 96.5,
            'total_absences' => 2,
            'recent_grades' => [
                ['subject' => 'Matematika', 'score' => 88, 'grade' => 'A-'],
                ['subject' => 'Bahasa Indonesia', 'score' => 85, 'grade' => 'B+'],
                ['subject' => 'IPA', 'score' => 90, 'grade' => 'A'],
                ['subject' => 'IPS', 'score' => 82, 'grade' => 'B+'],
                ['subject' => 'Bahasa Inggris', 'score' => 87, 'grade' => 'A-']
            ]
        ];

        return view('teacher.students.show', compact('student', 'academicData'));
    }

    public function create()
    {
        return view('teacher.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:students,nis',
            'name' => 'required|string|max:255',
            'class' => 'required|string',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:students,email',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'enrollment_date' => 'required|date',
            'religion' => 'required|string',
            'blood_type' => 'required|in:A,B,AB,O',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('students/photos', $filename, 'public');
        }

        // Here you would save to database
        // Student::create([...]);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Student data has been added successfully!');
    }

    public function edit($id)
    {
        // Mock data for editing
        $student = (object)[
            'id' => $id,
            'nis' => '2023001',
            'name' => 'Ahmad Rizki Pratama',
            'class' => 'VIII A',
            'gender' => 'L',
            'birth_date' => '2008-05-15',
            'birth_place' => 'Jakarta',
            'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
            'phone' => '081234567890',
            'email' => 'ahmad.rizki@student.school.id',
            'parent_name' => 'Budi Pratama',
            'parent_phone' => '081234567891',
            'parent_email' => 'budi.pratama@gmail.com',
            'enrollment_date' => '2023-07-15',
            'status' => 'active',
            'religion' => 'Islam',
            'blood_type' => 'A',
            'height' => 165,
            'weight' => 55
        ];

        return view('teacher.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|string',
            'name' => 'required|string|max:255',
            'class' => 'required|string',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'enrollment_date' => 'required|date',
            'religion' => 'required|string',
            'blood_type' => 'required|in:A,B,AB,O',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload if new photo provided
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('students/photos', $filename, 'public');
        }

        // Here you would update in database
        // Student::find($id)->update([...]);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Student data has been updated successfully!');
    }

    public function destroy($id)
    {
        // Here you would delete from database
        // Student::find($id)->delete();

        return redirect()->route('teacher.students.index')
            ->with('success', 'Student data has been deleted successfully!');
    }

    public function export()
    {
        // Export functionality would be implemented here
        return response()->json(['message' => 'Export functionality would be implemented here']);
    }
}
<?php

namespace App\Helpers;

class ClassHelper
{
    /**
     * Daftar semua jurusan yang tersedia
     */
    public static function getMajors(): array
    {
        $majors = [];
        $config = config('school.classes.majors', []);
        
        foreach ($config as $code => $data) {
            $majors[$code] = $data['name'];
        }
        
        return $majors;
    }

    /**
     * Daftar semua tingkat kelas
     */
    public static function getGrades(): array
    {
        return config('school.classes.grades', [10, 11, 12]);
    }

    /**
     * Daftar nomor kelas untuk setiap jurusan
     */
    public static function getClassNumbers(string $major = null): array
    {
        if ($major) {
            return config("school.classes.majors.{$major}.classes", [1]);
        }
        
        // Return all possible class numbers
        $numbers = [];
        $majors = config('school.classes.majors', []);
        
        foreach ($majors as $majorData) {
            $numbers = array_merge($numbers, $majorData['classes']);
        }
        
        return array_unique($numbers);
    }

    /**
     * Generate semua kelas yang tersedia (15 kelas)
     */
    public static function getAllClasses(): array
    {
        $classes = [];
        $grades = self::getGrades();
        $majors = config('school.classes.majors', []);
        
        foreach ($grades as $grade) {
            foreach ($majors as $majorCode => $majorData) {
                foreach ($majorData['classes'] as $classNumber) {
                    $classes[] = "{$grade} {$majorCode} {$classNumber}";
                }
            }
        }
        
        sort($classes);
        return $classes;
    }

    /**
     * Generate kelas untuk pendaftaran siswa baru (hanya kelas 10)
     */
    public static function getNewStudentClasses(): array
    {
        $classes = [];
        $newStudentGrade = config('school.classes.new_student_grade', 10);
        $majors = config('school.classes.majors', []);
        
        foreach ($majors as $majorCode => $majorData) {
            foreach ($majorData['classes'] as $classNumber) {
                $classes[] = "{$newStudentGrade} {$majorCode} {$classNumber}";
            }
        }
        
        sort($classes);
        return $classes;
    }

    /**
     * Validasi apakah kelas valid
     */
    public static function isValidClass(string $class): bool
    {
        return in_array($class, self::getAllClasses());
    }

    /**
     * Validasi apakah kelas valid untuk siswa baru
     */
    public static function isValidNewStudentClass(string $class): bool
    {
        return in_array($class, self::getNewStudentClasses());
    }

    /**
     * Get kelas berdasarkan tingkat
     */
    public static function getClassesByGrade(int $grade): array
    {
        $allClasses = self::getAllClasses();
        return array_filter($allClasses, function($class) use ($grade) {
            return strpos($class, (string)$grade) === 0;
        });
    }

    /**
     * Get kelas berdasarkan jurusan
     */
    public static function getClassesByMajor(string $major): array
    {
        $allClasses = self::getAllClasses();
        return array_filter($allClasses, function($class) use ($major) {
            return strpos($class, $major) !== false;
        });
    }

    /**
     * Parse informasi kelas
     */
    public static function parseClass(string $class): array
    {
        $parts = explode(' ', $class);
        
        if (count($parts) >= 3) {
            return [
                'grade' => (int)$parts[0],
                'major' => $parts[1],
                'number' => (int)$parts[2],
                'full_name' => $class
            ];
        }
        
        return [
            'grade' => null,
            'major' => null,
            'number' => null,
            'full_name' => $class
        ];
    }

    /**
     * Get daftar kelas untuk dropdown dengan format yang rapi
     */
    public static function getClassesForDropdown(bool $newStudentOnly = false): array
    {
        $classes = $newStudentOnly ? self::getNewStudentClasses() : self::getAllClasses();
        $options = [];
        
        foreach ($classes as $class) {
            $parsed = self::parseClass($class);
            $majorName = self::getMajors()[$parsed['major']] ?? $parsed['major'];
            $options[$class] = "Kelas {$class} - {$majorName}";
        }
        
        return $options;
    }

    /**
     * Get statistik kelas
     */
    public static function getClassStatistics(): array
    {
        return [
            'total_classes' => count(self::getAllClasses()),
            'new_student_classes' => count(self::getNewStudentClasses()),
            'majors' => count(self::getMajors()),
            'grades' => count(self::getGrades()),
            'classes_per_grade' => count(self::getNewStudentClasses()),
        ];
    }
}
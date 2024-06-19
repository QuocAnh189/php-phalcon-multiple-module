<?php

declare(strict_types=1);

namespace MyApp\Student\Services;

use MyApp\Common\ErrorException;
use MyApp\Student\Models\Students;
use MyApp\Student\Repositories\StudentsRepository;
use Phalcon\Encryption\Security\Random;

/**
 * Class StudentsService
 *
 * This service class handles business logic for student operations.
 *
 * @package MyApp\Student\Services
 */
class StudentsService
{
    private StudentsRepository $studentsRepository;

    /**
     * StudentsService constructor.
     *
     * Initializes the StudentsRepository.
     */
    public function __construct()
    {
        $this->studentsRepository = new StudentsRepository();
    }

    /**
     * Retrieves all students based on given parameters.
     *
     * @param array $parameters An associative array of query parameters.
     *                          Example: ['department' => 'Khoa hoc may tinh']
     *
     * @return Students[]|false The result set of students or false if no results found.
     */
    public function getAllStudents(array $parameters = [])
    {
        return $this->studentsRepository->getAll($parameters);
    }

    /**
     * Retrieves a student by their unique code.
     *
     * @param string $code The unique code of the student.
     *
     * @return Students|false|null The student record, false if not found, or null if no result.
     */
    public function getStudentByCode(string $code): ?Students
    {
        return $this->studentsRepository->getByCode($code);
    }

     /**
     * Creates a new student record.
     *
     * @param array $data An associative array of student data.
     *                    Example: ['name' => 'Anh Quoc', 'department' => 'Khoa hoc may tinh']
     *
     * @throws ErrorException If a server error occurs during creation.
     */
    public function createStudent(array $data)
    {
        try {
            $random = new Random();
            $data['id'] = $random->uuid();
            $data['code'] = 'SV2152' . str_pad(strval($random->number(9999)) , 4, '0', STR_PAD_LEFT);
            $this->studentsRepository->create($data); 
        }
        catch (\ErrorException $e) {
            throw new ErrorException(500, 'Server Error');
        }
    }

    /**
     * Updates an existing student record.
     *
     * @param Students $student The student model to update.
     * @param array    $data    An associative array of updated student data.
     *                          Example: ['name' => 'Anh Quoc', 'department' => 'Khoa hoc may tinh']
     *
     * @throws ErrorException If the student is not found or if a server error occurs.
     */
    public function updateStudent(Students $student, array $data): void
    {
        try {
            $student = $this->studentsRepository->getByCode($student->code);
            if (!$student) {
                throw new ErrorException(404, 'Student not found');
            }
            $this->studentsRepository->update($student, $data); 
        }
        catch (\ErrorException $e) {
            if ($e->getCode() === 404) {
                throw $e;
            } else {
                throw new ErrorException('Server Error', 500);
            }
        }
    }

     /**
     * Deletes a student record.
     *
     * @param string $code The unique code of the student.
     *
     * @throws ErrorException If the student is not found or if a server error occurs.
     */
    public function deleteStudent(string $code): void
    {
        try {
            $student = $this->studentsRepository->getByCode($code);
            if (!$student) {
                throw new ErrorException(404, 'Student not found');
            }

            $this->studentsRepository->delete($student);
        }
        catch (\ErrorException $e) {
            if ($e->getCode() === 404) {
                throw $e;
            } else {
                throw new ErrorException('Server Error', 500);
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace MyApp\Student\Repositories;

use MyApp\Student\Models\Students;

/**
 * Class StudentsRepository
 *
 * This repository handles data operations for the Students model.
 *
 * @package MyApp\Student\Repositories
 */
class StudentsRepository
{
    /**
     * Retrieves all students based on given parameters.
     *
     * @param array $parameters An associative array of query parameters.
     *                          Example: ['department' => 'Computer Science']
     */
    public function getAll(array $parameters = [])
    {
        $conditions = [];
        $bind = [];

        // Example: building conditions based on parameters
        if (isset($parameters['department'])) {
            $conditions[] = 'department = :department:';
            $bind['department'] = $parameters['department'];
        }

        // Build your query based on conditions and bind parameters
        return Students::find([
            implode(' AND ', $conditions),
            'bind' => $bind,
        ]);
    }

    /**
     * Retrieves a student by their unique code.
     *
     * @param string $code The unique code of the student.
     */
    public function getByCode(string $code): ?Students
    {
        return Students::findFirstByCode($code);
    }

     /**
     * Creates a new student record.
     *
     * @param array $data An associative array of student data.
     */
    public function create(array $data)
    {
        $student = new Students();
        $student->assign($data);
        $student->save();
    }

    /**
     * Updates an existing student record.
     *
     * @param Students $student The student model to update.
     * @param array    $data    An associative array of updated student data.
     *                          Example: ['name' => 'Anh Quoc', 'department' => 'Khoa hoc may tinh']
     */
    public function update(Students $student, array $data)
    {
        $student->assign($data);
        $student->save();
    }

     /**
     * Deletes a student record.
     *
     * @param Students $student The student model to delete.
     */
    public function delete(Students $student)
    {
        $student->delete();
    }
}

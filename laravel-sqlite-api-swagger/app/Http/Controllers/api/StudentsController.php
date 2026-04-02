<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Students', description: 'Student management endpoints')]
#[OA\Schema(
    schema: 'Student',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'FirstName', type: 'string', example: 'John'),
        new OA\Property(property: 'LastName', type: 'string', example: 'Doe'),
        new OA\Property(property: 'School', type: 'string', example: 'CIT'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
#[OA\Schema(
    schema: 'StudentRequest',
    required: ['FirstName', 'LastName', 'School'],
    properties: [
        new OA\Property(property: 'FirstName', type: 'string', example: 'John'),
        new OA\Property(property: 'LastName', type: 'string', example: 'Doe'),
        new OA\Property(property: 'School', type: 'string', example: 'CST'),
    ]
)]
class StudentsController extends Controller
{
    #[OA\Get(
        path: '/api/students',
        tags: ['Students'],
        summary: 'Get all students',
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of all students',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/Student')
                )
            ),
        ]
    )]
    public function index()
    {
        return Student::all();
    }

    #[OA\Post(
        path: '/api/students',
        tags: ['Students'],
        summary: 'Create a new student',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/StudentRequest')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Student created successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/Student')
            ),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store(Request $request)
    {
        // validate input
        request()->validate([
            'FirstName' => 'required',
            'LastName' => 'required',
            'School' => 'required',
        ]);

        return Student::create([
            'FirstName' => request('FirstName'),
            'LastName' => request('LastName'),
            'School' => request('School'),
        ]);

    }

    #[OA\Get(
        path: '/api/students/{id}',
        tags: ['Students'],
        summary: 'Get a student by ID',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'Student ID', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Student details',
                content: new OA\JsonContent(ref: '#/components/schemas/Student')
            ),
            new OA\Response(response: 404, description: 'Student not found'),
        ]
    )]
    public function show(Student $student)
    {
        return $student;
    }

    #[OA\Put(
        path: '/api/students/{id}',
        tags: ['Students'],
        summary: 'Update a student',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'Student ID', schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/StudentRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Update result',
                content: new OA\JsonContent(
                    properties: [new OA\Property(property: 'success', type: 'boolean')]
                )
            ),
            new OA\Response(response: 404, description: 'Student not found'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function update(Request $request, Student $student)
    {
        request()->validate([
            'FirstName' => 'required',
            'LastName' => 'required',
            'School' => 'required',
        ]);

        $isSuccess = $student->update([
            'FirstName' => request('FirstName'),
            'LastName' => request('LastName'),
            'School' => request('School'),
        ]);

        return [
            'success' => $isSuccess,
        ];

    }

    #[OA\Delete(
        path: '/api/students/{id}',
        tags: ['Students'],
        summary: 'Delete a student',
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'Student ID', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Delete result',
                content: new OA\JsonContent(
                    properties: [new OA\Property(property: 'success', type: 'boolean')]
                )
            ),
            new OA\Response(response: 404, description: 'Student not found'),
        ]
    )]
    public function destroy(Student $student)
    {
        $isSuccess = $student->delete([
            'FirstName' => request('FirstName'),
            'LastName' => request('LastName'),
            'School' => request('School'),
        ]);

        return [
            'success' => $isSuccess,
        ];

    }
}

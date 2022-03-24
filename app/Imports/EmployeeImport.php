<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;


    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.email' => 'required|unique:employee,email',
            '*.name' => 'required',
            '*.company_id' => 'required'
        ]);
        foreach ($rows as $row) {
            Employee::create([
                'company_id' => $row['company'],
                'name' => $row['name'],
                'email' => $row['email'],
            ]);
        }
    }
    public function chunkSize(): int
    {
        return 10;
    }
    // /**
    //  * @param array $row
    //  *
    //  * @return \Illuminate\Database\Eloquent\Model|null
    //  */
    // public function model(array $row)
    // {
    //     return new Employee([
    //         "company_id" => $row[0],
    //         "name" => $row[1],
    //         "email" => $row[2],
    //     ]);
    // }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;


class DataSetController extends Controller
{
    public function index(Request $request)
    {
        // Read csv file
        $this->isCsvImported();

        $data = DB::table('dataset')->get();

        // Filter by category
        if ($request->category) {
            $data = $data->where('category', $request->category);
        }

        // Filter by gender
        if ($request->gender) {
            $data = $data->where('gender', $request->gender);
        }

        // Filter by date of birth
        if ($request->dob) {
            $data = $data->where('birthDate', $request->dob);
        }

        // Filter by age range
        if ($request->age_from && $request->age_to) {
            $from = now()->subYears($request->age_from);
            $to = now()->subYears($request->age_to + 1)->addDay();
            $data = $data->whereBetween('birthDate', [$to, $from]);
        }

        // Filter by age
        if ($request->age) {
            $from = now()->subYears($request->age);
            $to = now()->subYears($request->age + 1)->addDay();
            $data = $data->whereBetween('birthDate', [$to, $from]);
        }

        // Paginate data
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $pagedData = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $data = new LengthAwarePaginator($pagedData, count($data), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('dataset.index', [
            'data' => $data,
            'category' => $request->category,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'age' => $request->age,
            'age_from' => $request->age_from,
            'age_to' => $request->age_to,
        ]);
    }


    /**
     * Check if CSV file is imported into MySQL database.
     *
     * @param  string  $table
     * @param  string  $filePath
     * @param  string  $delimiter
     * @param  int  $limit
     * @return bool
     */
    function isCsvImported()
    {
        $headers = null;
        $data = array();
        $filePath = public_path('1dataset.csv');
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (!$headers) {
                    $headers = $row;
                } else {
                    $data[] = array_combine($headers, $row);
                }
            }
            fclose($handle);
        }
        $importedRows = DB::table('dataset')->count();
        if ($importedRows < 1000) {
            echo "<h1>CSV file is not fully imported or missing</h1></p>
                    <a href='/import' style='button'>start import</a>";
        }
    }


    public function import()
    {
        $file = '1dataset.csv';
        $handle = fopen($file, 'r');

        if ($handle !== false) {
            $headers = fgetcsv($handle); // Read the header row
            $rows = [];

            $count = 0; // Keep track of how many rows we've processed
            while (($data = fgetcsv($handle)) !== false) {
                // Combine the header row with the current row
                $row = array_combine($headers, $data);

                // Add the row to the array of rows
                $rows[] = $row;

                $count++;

                // If we've processed 3000 rows, insert them into the database and clear the array
                if ($count % 3000 == 0) {
                    DB::table('dataset')->insert($rows);
                    $rows = [];
                }
            }

            // Insert any remaining rows
            if (!empty($rows)) {
                DB::table('dataset')->insert($rows);
            }

            fclose($handle);
            return redirect('/')->with([
                'success' => 'import started Successfully.',
            ]);
        } else {

           echo "<h1>ERROR</h1>";
        }
    }


    public function success()
    {
        return view('dataset.index')->with('success', 'CSV file is  imported !');

    }


    public function error()
    {
        echo "<h1>CSV file is not imported or missing</h1>";

        return view('dataset.index')->with('error', 'CSV file is not imported or missing');
    }

    public function export(Request $request)
    {
        $data = DB::table('dataset')->get();

        // Filter by category
        if ($request->category) {
            $data = $data->where('category', $request->category);
        }

        // Filter by gender
        if ($request->gender) {
            $data = $data->where('gender', $request->gender);
        }

        // Filter by date of birth
        if ($request->dob) {
            $data = $data->where('birthDate', $request->dob);
        }

        // Filter by age range
        if ($request->age_from && $request->age_to) {
            $from = now()->subYears($request->age_from);
            $to = now()->subYears($request->age_to + 1)->addDay();
            $data = $data->whereBetween('birthDate', [$to, $from]);
        }

        // Filter by age
        if ($request->age) {
            $from = now()->subYears($request->age);
            $to = now()->subYears($request->age + 1)->addDay();
            $data = $data->whereBetween('birthDate', [$to, $from]);
        }
    }

}


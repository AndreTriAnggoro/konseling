<?php

namespace App\Http\Controllers;

use App\Models\DosenWali;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
// use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;
// use Illuminate\Validation\ValidationException;
// use Illuminate\Support\Facades\Validator;
use App\Models\Mahasiswa;
use App\Models\Pembayaran;
use App\Models\Nilai;
use App\Models\User;

class ImportController extends Controller
{

    public function importdosen(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx|max:2048',
            ]);

            $file = $request->file('excel_file');

            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = [];

            foreach ($worksheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            // Mulai dari indeks 1 untuk melewati header
            for ($i = 1; $i < count($data); $i++) {
                DosenWali::create([
                    'nip_dosenwali' => $data[$i][1],
                    'id_programstudi' => $data[$i][2],
                    'nama' => $data[$i][3],
                    'email' => $data[$i][4],
                    'no_hp' => $data[$i][5],
                    'alamat' => $data[$i][6],
                ]);
                // Create User
                $user = new User();
                $user->name = $data[$i][3]; // Gunakan nama mahasiswa sebagai nama pengguna
                $user->username = $data[$i][1]; // Gunakan nim sebagai nama pengguna
                $user->password = bcrypt('12345678'); // Tentukan kata sandi default atau sesuaikan sesuai kebutuhan
                $user->save();

                // Atur peran pengguna
                $user->assignRole('dosenwali');
            }

            return redirect()->back()->with('success', 'Data berhasil diimpor');
        } catch (\Exception $e) {
            return redirect()->back()->with('importError', 'Data gagal diimpor');
        }
    }

    public function importNilai(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx|max:2048',
            ]);

            $file = $request->file('excel_file');

            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = [];

            foreach ($worksheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            // Mulai dari indeks 1 untuk melewati header
            for ($i = 1; $i < count($data); $i++) {
                Nilai::create([
                    'nim' => $data[$i][1],
                    'semester1' => $data[$i][2],
                    'semester2' => $data[$i][3],
                    'semester3' => $data[$i][4],
                    'semester4' => $data[$i][5],
                    'semester5' => $data[$i][6],
                    'semester6' => $data[$i][7],
                    'semester7' => $data[$i][8],
                    'semester8' => $data[$i][9],
                    'ipk' => $data[$i][10],
                ]);
            }

            return redirect()->back()->with('success', 'Data berhasil diimpor');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('importError', 'Data gagal diimpor');
        }
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'excel_file' => 'required|mimes:xlsx|max:2048',
            ]);

            $file = $request->file('excel_file');

            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = [];

            foreach ($worksheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            // Mulai dari indeks 1 untuk melewati header
            for ($i = 1; $i < count($data); $i++) {
                Mahasiswa::create([
                    'nim' => $data[$i][1],
                    'id_programstudi' => $data[$i][2],
                    'nama' => $data[$i][3],
                    'alamat' => $data[$i][4],
                    'jenis_kelamin' => $data[$i][5],
                    'email' => $data[$i][6],
                    'no_hp' => $data[$i][7],
                ]);
                // Create User
                $user = new User();
                $user->name = $data[$i][3]; // Gunakan nama mahasiswa sebagai nama pengguna
                $user->username = $data[$i][1]; // Gunakan nim sebagai nama pengguna
                $user->password = bcrypt('12345678'); // Tentukan kata sandi default atau sesuaikan sesuai kebutuhan
                $user->save();

                $pembayaran = new Pembayaran();
                $pembayaran->nim = $data[$i][1];
                $pembayaran->save();

                // Atur peran pengguna
                $user->assignRole('mahasiswa');
            }

            return redirect()->back()->with('success', 'Data berhasil diimpor');
        } catch (\Exception $e) {
            return redirect()->back()->with('importError', 'Data gagal diimpor');
        }
    }
}

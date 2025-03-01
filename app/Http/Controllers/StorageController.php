<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use function number_format; // Include number_format function

class StorageController extends Controller
{
    public function index()
    {
        $totalSpaceBytes1 = disk_total_space('/');
        $freeSpaceBytes1 = disk_free_space('/');
        $usedSpaceBytes1 = $totalSpaceBytes1 - $freeSpaceBytes1;

        $totalSpaceBytes2 = disk_total_space('/');
        $freeSpaceBytes2 = disk_free_space('/');
        $usedSpaceBytes2 = $totalSpaceBytes2 - $freeSpaceBytes2;
        
        $targetFolder1 = 'C:\laragon\www\smartcampus'; // Replace with actual folder path
        $targetFolder2 = 'C:\laragon\www\smartcampus-master'; // Replace with actual folder path

        $files1 = scandir($targetFolder1);
        $filteredFiles1 = array_diff($files1, array('.', '..')); // Remove '.' and '..'

        $files2 = scandir($targetFolder2);
        $filteredFiles2 = array_diff($files2, array('.', '..')); // Remove '.' and '..'

        $folderSizeBytes1 = 0;
        foreach ($filteredFiles1 as $filename1) {
            $filePath1 = $targetFolder1 . '/' . $filename1;
            if (is_file($filePath1)) {
                $folderSizeBytes1 += filesize($filePath1);
            }
        }
        $folderSizeBytes2 = 0;
        foreach ($filteredFiles2 as $filename2) {
            $filePath2 = $targetFolder2 . '/' . $filename2;
            if (is_file($filePath2)) {
                $folderSizeBytes2 += filesize($filePath2);
            }
        }

        // Calculate size in appropriate unit
        if ($folderSizeBytes1 >= 1073741824) {
            $folderSize1 = number_format($folderSizeBytes1 / 1073741824, 2) . ' GB';
        } elseif ($folderSizeBytes1 >= 1048576) {
            $folderSize1 = number_format($folderSizeBytes1 / 1048576, 0) . ' MB';
        } elseif ($folderSizeBytes1 >= 1024) {
            $folderSize1 = number_format($folderSizeBytes1 / 1024, 0) . ' KB';
        } else {
            $folderSize1 = number_format($folderSizeBytes1, 0) . ' Byte';
        }
                // Calculate size in appropriate unit
        if ($folderSizeBytes2 >= 1073741824) {
            $folderSize2 = number_format($folderSizeBytes2 / 1073741824, 2) . ' GB';
        } elseif ($folderSizeBytes2 >= 1048576) {
            $folderSize2 = number_format($folderSizeBytes2 / 1048576, 0) . ' MB';
        } elseif ($folderSizeBytes2 >= 1024) {
            $folderSize2 = number_format($folderSizeBytes2 / 1024, 0) . ' KB';
        } else {
            $folderSize2 = number_format($folderSizeBytes2, 0) . ' Byte';
        }

        $totalSpaceGB1 = number_format($totalSpaceBytes1 / 1073741824, 2); // Limit to 2 decimal places
        $freeSpaceGB1 = number_format($freeSpaceBytes1 / 1073741824, 2);
        $usedSpaceGB1 = number_format($usedSpaceBytes1 / 1073741824, 2);

        $totalSpaceGB2 = number_format($totalSpaceBytes2 / 1073741824, 2); // Limit to 2 decimal places
        $freeSpaceGB2 = number_format($freeSpaceBytes2 / 1073741824, 2);
        $usedSpaceGB2 = number_format($usedSpaceBytes2 / 1073741824, 2);

        $percentageUsed1 = ($folderSizeBytes1 / $totalSpaceBytes1) * 100;
        $percentageUsed1 = number_format($percentageUsed1, 2); // Limit to 2 decimal places for percentage

        $percentageUsed2 = ($folderSizeBytes2 / $totalSpaceBytes2) * 100;
        $percentageUsed2 = number_format($percentageUsed2, 2); // Limit to 2 decimal places for percentage

        return view('storage.index', [
            'totalSpaceGB1' => $totalSpaceGB1,
            'freeSpaceGB1' => $freeSpaceGB1,
            'usedSpaceGB1' => $usedSpaceGB1,
            'percentageUsed1' => $percentageUsed1,
            'targetFolderSize1' => $folderSize1, // Use $folderSize instead of KB/MB specific variable
            'totalSpaceGB2' => $totalSpaceGB2,
            'freeSpaceGB2' => $freeSpaceGB2,
            'usedSpaceGB2' => $usedSpaceGB2,
            'percentageUsed2' => $percentageUsed2,
            'targetFolderSize2' => $folderSize2, // Use $folderSize instead of KB/MB specific variable
        ]);
    }
}

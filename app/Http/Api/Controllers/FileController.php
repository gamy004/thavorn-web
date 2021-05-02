<?php

namespace App\Http\Api\Controllers;

use DB;
use Exception;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Api\Requests\FileRequests\UploadEvidenceRequest;

class FileController extends BaseApiController
{
    public function uploadEvidence(UploadEvidenceRequest $request, User $user)
    {
        DB::beginTransaction();
        
        try {
            $file = $this->api->upload($request->file('file'), 'evidences', $user);

            if (is_null($file)) {
                return unacceptable(['message' => 'หลักฐานที่ต้องการ ไม่สามารถอัพโหลดได้']);
            }

            DB::commit();

            return $this->show($file);
        } catch (Exception $exception) {
            DB::rollback();
            dd($exception);
            return badImplementation(['message' => 'ไม่สามารถอัพโหลดหลักฐานได้ พบข้อผิดพลาด']);
        }
    }

    public function downloadEvidence(Request $request, File $file)
    {
        try {
            return $this->api->download($file);
        } catch (Exception $exception) {
            return badImplementation(['message' => 'ไม่สามารถดาวน์โหลดหลักฐานที่ต้องการได้ พบข้อผิดพลาด']);
        }
    }

    // public function deleteEvidence(Request $request, File $file)
    // {
    //     DB::beginTransaction();
        
    //     try {
    //         $file = $this->api->delete($file);

    //         DB::commit();

    //         return succuess(['message' => 'ลบหลักฐานที่ต้องการเรียบร้อย']);
    //     } catch (Exception $exception) {
    //         DB::rollback();
            
    //         return badImplementation(['message' => 'ไม่สามารถลบหลักฐานที่ต้องการได้ พบข้อผิดพลาด']);
    //     }
    // }
}

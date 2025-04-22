<?php

namespace App\Services;

use App\Models\EnterpriseType;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\UploadedFile;


class EnterpriseTypeService{
    public function create(array $data): EnterpriseType
    {
        $enterpriseType = new EnterpriseType($data);
        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            $path = Storage::putFile('icons', $data['icon']);
            $enterpriseType->icon = $path;
        }
        $enterpriseType->save();
        return $enterpriseType;
    }

    public function update(EnterpriseType $enterpriseType, array $data): EnterpriseType
    {
        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            Storage::delete($enterpriseType->icon);
            $path = Storage::putFile('icons', $data['icon']);
            $enterpriseType->icon = $path;
        }
        $enterpriseType->update($data);
        return $enterpriseType;
    }


    public function delete(EnterpriseType $enterpriseType): bool
    {
        if ($enterpriseType->icon) {
            Storage::delete($enterpriseType->icon);
        }
        return $enterpriseType->delete();
    }
}
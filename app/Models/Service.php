<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'sub_title',
        'detail',
        'point',
    ];

    public function edit($id)
    {
        $edit = Service::where(['id' => $id])->find($id);
        return $edit;
    }

    public function fetchList($request)
    {
        $sFilter = ['title', 'status'];
        $query = Service::query();
        $query->select('services.*');
        foreach ($sFilter as $filter) {
            if (!empty($request['form'][$filter]) || $request['form'][$filter] == '0') {
                $query->where($filter, 'like', "%{$request['form'][$filter]}%");
            }
        }

        return $query->get();
    }

    public function service_detail($serviceSlug)
    {
        $query = Service::query();
        $result = $query->select('*')->where('slug', $serviceSlug)->first()->toArray();
        return $result;
    }
}

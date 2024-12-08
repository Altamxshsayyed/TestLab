<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            "active" => 'service',
            "subActive" => 'service_list'
        ];

        return view('admin.service.service_list', $data);
    }

    public function fetchService(Request $request)
    {
        $serviceObject = new Service();
        $collection = $serviceObject->fetchList($request);
        $count = $collection->count();
        $idisplayLength = intval($_REQUEST['length']);
        $idisplayStart = intval($_REQUEST['start']);

        $output = array();
        $output['data'] = array();

        $num_rows = $count;
        $iTotalRecords = (int)$num_rows;
        $idisplayLength = intval($_REQUEST['length']);
        $idisplayLength = $idisplayLength < 0 ? $iTotalRecords : $idisplayLength;
        $idisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
        $end = $idisplayStart + $idisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $srno = $idisplayStart;
        $records = $collection->splice($idisplayStart, $idisplayLength);

        foreach ($records as $sRow) {
            $status = '';
            if ($sRow['status'] == 1) {
                $status .= '<span class="badge bg-label-success me-1">Active</span>';
            } else {
                $status .= '<span class="badge bg-label-danger me-1">Active</span>';
            }

            $action = '';
            $image = '';
            $drag = '';

            $drag .= '<i class="ti ti-drag-drop" drag-id=' . $sRow['id'] . '></i>';
            $action .= '<a href="update_service/' . base64_encode($sRow['id']) . '" class="edit" id="' . base64_encode($sRow['id']) . '"title="Edit" route="service_form"> <i class="fa fa-edit" style="color:blue; font-size:20px;"></i> </a> ';
            $action .= ' <a href="javascript:void(0)" class="delete_record" id="' . base64_encode($sRow['id']) . '"title="Delete" table_id="service_table" route="delete_service"> <i class="fa fa-trash" style="color:red; font-size:20px;"></i> </a>';

            $output['data'][] = array(
                $sRow['id'],
                $drag,
                $sRow['title'],
                $status,
                $action
            );
            if ($srno < $end) $srno++;
        }

        $output['draw'] = $sEcho;
        $output["recordsTotal"] = $iTotalRecords;
        $output["recordsFiltered"] = $iTotalRecords;
        echo json_encode($output);
    }

    public function manageService(Request $request)
    {
        $serviceObject = new Service();
        $id = base64_decode($request->id);
        if ($id == -1) {
            $data = [
                'id' => $id,
                'pageTitle' => 'Add Service',
                'subActive' => 'add_service',
                'active' => 'service'
            ];
        } else {
            $edit = $serviceObject->edit($id);
            $data = [
                'id' => $id,
                'edit' => $edit,
                'pageTitle' => 'Add Service',
                'subActive' => 'add_service',
                'active' => 'service'
            ];
        }

        return view('admin.service.service_form', $data);
    }

    public function addUpdate(Request $request)
    {
        $serviceObject = new Service();
        $validator = $this->validateServiceData($request);

        if ($validator->passes()) {

            if ($request->id != -1) {
                $id = $request->id;
            } else {
                $id = null;
            }

            $serviceObject->title = $request->title;
            $serviceObject->slug = Str::slug($request->title);
            $serviceObject->sub_title = $request->sub_title;
            $serviceObject->status = isset($request->status) && $request->status == true ? 1 : 0;

            $serviceVals = [
                'title' => $serviceObject->title,
                'slug' => $serviceObject->slug,
                'status' => $serviceObject->status,
            ];

            DB::transaction(function () use ($serviceVals, $id, $request, $serviceObject) {

                $detailArray = [];

                foreach ($request->sub_title as $key => $val) {
                    $detailArray[$key]['sub_title'] = $val;
                    $detailArray[$key]['description'] = $request->description[$key];
                    $detailArray[$key]['point'] = $request->point[$key];
                }

                $serviceVals['detail'] = json_encode($detailArray);

                // for service image
                $image = $request->image;
                if ($image) {
                    if (Storage::exists('uploads/temp/' . $image)) {
                        Storage::move('uploads/temp/' . $image, 'uploads/Service/' . $image);
                    }
                    $serviceVals['image'] = $image;
                }

                $serviceObject->updateOrInsert(['id' => $id], $serviceVals);
            });

            if ($request->id == -1) {
                $response['msg'] = 'Service Created Successfully';
            } else {
                $response['msg'] = 'Service Updated Successfully';
            }

            $response['success'] = 1;
            $response['redirect_url'] = url('admin/service');
            return response()->json($response);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function organizeService(Request $request)
    {
        $sequenceData = $request->input('order');
        foreach ($sequenceData as $sequence => $itemData) {
            $itemArray = explode('/', $itemData);
            $newSequence = $sequence + 1;
            $id = $itemArray[0];
            $table = DB::table('services');
            $table->where('id', $id)->update(['sequence' => $newSequence + ($itemArray[2] * ($itemArray[1] - 1))]);
        }
        return response()->json(['message' => 'Sequence reordered successfully']);
    }

    public function deleteService($id)
    {
        $id = base64_decode($id);
        $res = Service::destroy($id);
        return $res;
    }

    protected function validateServiceData($request)
    {
        return validator($request->all(), [
            'title' => 'required',
        ]);
    }
}

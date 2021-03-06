<?php

namespace App\Http\Controllers;


use App\Constant\Navigation;
use App\Models\Cooperation;
use App\Models\FootPicture;
use App\Models\HeadPicture;
use App\Models\HomeBespockContent;
use Illuminate\Http\Request;

class CooperationController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data['head_pic'] = HeadPicture::query()
            ->where('navigation_id', Navigation::COOPERATION)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();
        $data['home_bespock'] = HomeBespockContent::query()
            ->where('navigation_id', Navigation::COOPERATION)
            ->orderByDesc('id')->first();

        $data['data'] = Cooperation::query()
            ->select(['id', 'name', 'summary', 'img_url'])
            ->orderByDesc('id')
            ->paginate($request->get('per_page'));

        $data['foot_pic'] = FootPicture::query()
            ->select(['img_url', 'remark'])
            ->orderBy('id')
            ->where('navigation_id', Navigation::COOPERATION)
            ->get();
        return $this->successData($data);
    }

}
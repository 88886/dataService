<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'mysql';
    protected $table = 'course';
    protected $guarded = ['id'];

    /**
     * 数据变更时，自动触发回调
     */
    public static function boot()
    {
        parent::boot();

        self::created(function ($model)
        {
            if ($model->is_show_homepage == 1) {
                $navigationId = \App\Constant\Navigation::COURSE;
                if ($model->is_history == 1) {
                    $navigationId = \App\Constant\Navigation::OLD_COURSE;
                }
                NavigationChild::firstOrCreate([
                    'child_table' => 'course',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => $navigationId,
                    'title' => $model->title,
                ]);
            }
        });

        //当更新时触发
        self::updated(function ($model)
        {

            if ($model->is_history == 0) {
                NavigationChild::query()
                    ->where('child_table', 'course')
                    ->where('child_id', $model->id)
                    ->update([
                        'navigation_id' => \App\Constant\Navigation::COURSE
                    ]);
            }
            if ($model->is_history == 1) {
                NavigationChild::query()
                    ->where('child_table', 'course')
                    ->where('child_id', $model->id)
                    ->update([
                        'navigation_id' => \App\Constant\Navigation::OLD_COURSE
                    ]);
            }

            //关闭
            if ($model->is_show_homepage == 0) {
                NavigationChild::query()
                    ->where('child_table', 'course')
                    ->where('child_id', $model->id)
                    ->delete();
            }
            //开启
            if ($model->is_show_homepage == 1) {
                $navigationId = \App\Constant\Navigation::COURSE;
                if ($model->is_history == 1) {
                    $navigationId = \App\Constant\Navigation::OLD_COURSE;
                }
                NavigationChild::firstOrCreate([
                    'child_table' => 'course',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => $navigationId,
                    'title' => $model->title,
                ]);
            }

        });

        self::deleted(function ($model)
        {
            NavigationChild::query()
                ->where('child_table', 'course')
                ->where('child_id', $model->id)
                ->delete();
        });
    }
}

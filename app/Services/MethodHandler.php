<?php

namespace App\Services;

use App\Models\Statistic;
use App\Services\JsonRpc\JsonRpcError;
use Illuminate\Support\Facades\DB;

class MethodHandler
{

    public function addStatistic($params, $id)
    {
        if (validator($params, [
            'url' => 'required|url',
        ])->fails()) {
            return JsonRpcError::create(JsonRpcError::INVALID_PARAMS);
        }

        $model = Statistic::create([
            'url' => $params['url'],
        ]);

        return $model->getKey();
    }

    public function getStatistic($params, $id)
    {
        $page = $params['page'] ?? 1;
        $take = $params['take'] ?? 25;

        if ($take > 1000) {
            $take = 1000;
        }

        $table = Statistic::getModel()->getTable();

        $count = DB::table($table)->count();;

        $pages = (integer)ceil(($count / $take));

        if ($pages > $page) {
            $page = $pages;
        }

        $skip = ($page - 1) * $take;

        $rows = DB::select("select `url`, count(uuid) as count, max(created_at) as created_at from `{$table}` group by `url` order by `created_at` asc limit ? offset ?", [$take, $skip]);

        return compact('rows', 'count', 'take', 'page');
    }

}

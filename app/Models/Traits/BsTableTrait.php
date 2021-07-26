<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * BsTable 查询
 *
 * User: haoliang
 * Date: 2018/8/12
 * Time: 下午12:39
 */
trait BsTableTrait
{

    private $_where = [];

    /**
     * BsTable 数据
     */
    public function bsTable()
    {
        // 处理 Where 条件
        $this->normalizeWhere();

        $data['total'] = $this->getBsTableTotal();
        $data['rows'] = $this->getBsTableRows();

        response()->json($data)->send();
    }

    /**
     * 规范化 Where 条件
     *
     */
    public function normalizeWhere()
    {
        $request = request();
        if (! $request->has('query')) {
            return ;
        }

        $this->_where = $request->input('query');

        $where = [];

        foreach ($this->_where as $key => $value) {
            // 检索值为空时 不添加检索
            if ($value == '') {
                unset($this->_where[$key]);
                continue;
            }

            $this->normalizeWhereDate($key, $value);

            if (is_numeric($value) || $this->isDate($value)) {
                $where[] = [$key, '=', $value];
            } else {
                $where[] = [$key, 'like', '%'.$value.'%'];
            }
        }

        $this->_where = $where;
    }

    /**
     * 处理日期检索
     *
     * @param $key
     * @param $value
     */
    private function normalizeWhereDate($key, $value)
    {
        // 检索条件中包含创建日期 更新日期时 精确到天 排除 时分秒
        if ($this->isDate($key)) {
            $this->_where["DATE_FORMAT($key, '%Y/%m/%d')"] = $value;
            unset($this->_where[$key]);
        }
    }

    /**
     * 判定给定的值是否为日期
     *
     * @param string $val
     * @return bool
     */
    private function isDate(string $val) : bool
    {
        $val = strtolower($val);
        return Str::contains($val, ['created_at', 'updated_at']) || Str::is(['date*', '*date'], $val);
    }

    /**
     * 获取BsTable分页、排序参数
     *
     * @return array
     */
    public function getBsTableParam() : array
    {
        $request = request();

        return [
            'offset' => $request->query('offset'),
            'limit' => $request->query('limit'),
            'sort' => $request->query('sort'),
            'order' => $request->query('order'),
        ];
    }

    /**
     * 获取数据总数量
     *
     * @return int
     */
    public function getBsTableTotal() : int
    {
        return $this->getBsBuilder()->count();
    }

    /**
     * 获取分页数据
     *
     * @return mixed
     */
    public function getBsTableRows()
    {
        $param = $this->getBsTableParam();

        return $this->getBsBuilder()
            ->orderBy($param['sort'], $param['order'])
            ->offset($param['offset'])
            ->limit($param['limit'])
            ->get();
    }

    /**
     * 获取检索条件
     *
     * @return Builder
     */
    private function getBsBuilder() : Builder
    {
        $builder = $this->where($this->_where);

        // 不为空的字段
        if (method_exists($this, 'bsWhereNotNull')) {
            foreach ($this->bsWhereNotNull() as $column) {
                $builder->whereNotNull($column);
            }
        }

        return $builder;
    }
}
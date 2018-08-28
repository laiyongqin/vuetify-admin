<?php

namespace app\admin\controller;

class Position extends Comm
{
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Position');
    }

    public function index()
    {
        if (!$this->checkRule()) {
            return msg(401, null, '您没有权限操作');
        }
        $status = isset($this->param['status']) ? $this->param['status'] : null;
        $data = [];
        if ($status) {
            $data['status'] = $status;
        }
        $ret = $this->model->getPositions($data);
        if ($ret) {
            return msg(200, $ret);
        } else {
            return msg(204, null, $this->model->getError());
        }
    }

    public function read()
    {
        $id = $this->param['id'];
        $ret = $this->model->getPositionById($id);
        if ($ret) {
            return msg(200, $ret);
        } else {
            return msg(100, null, $this->model->getError());
        }
    }

    public function save()
    {
        if (!$this->checkRule()) {
            return msg(401, null, '您没有权限操作');
        }
        if ($this->param['status'] == 'true') {
            $this->param['status'] = 1;
        } else {
            $this->param['status'] = 0;
        }
        $ret = $this->model->savePosition($this->param);
        if ($ret) {
            return msg(200, null, '添加成功');
        } else {
            return msg(100, null, $this->model->getError());
        }
    }

    public function update()
    {
        if (!$this->checkRule()) {
            return msg(401, null, '您没有权限操作');
        }
        if ($this->param['id']) {
            $id = $this->param['id'];
            unset($this->param['id']);
        } else {
            return msg(100, null, '参数错误');
        }
        if ($this->param['status'] == 'true') {
            $this->param['status'] = 1;
        } else {
            $this->param['status'] = 0;
        }
        $ret = $this->model->updatePosition($id, $this->param);
        if ($ret) {
            return msg(200, null, '更新成功');
        } else {
            return msg(100, null, $this->model->getError());
        }
    }

    public function delete()
    {
        return msg(100, null, '暂无删除功能');
    }

    public function enable()
    {
        if (isset($this->param['id'])) {
            $id = $this->param['id'];
            unset($this->param['id']);
        } else {
            return msg(100, null, '参数错误');
        }
        $ret = $this->model->updatePosition($id, $this->param, false);
        if ($ret) {
            return msg(200, null, '操作成功');
        } else {
            return msg(100, null, $this->model->getError());
        }
    }
}

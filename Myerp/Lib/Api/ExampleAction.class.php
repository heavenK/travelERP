<?php


class ExampleAction extends Action {
    /**
     * 构造方法，实例化操作模型
     */
    protected function _init(){
        //$this->model = new ExampleModel();
    }

    public function test(){
		dump('this message from Commom/Api/Example');
		return 'this data from Commom/Api/Example';
    }

}

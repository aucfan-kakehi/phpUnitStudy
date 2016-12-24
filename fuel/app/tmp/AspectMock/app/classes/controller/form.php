<?php

class Controller_Form extends Controller_Template
{
    public function action_index()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        $this->template->title = 'コンタクトフォーム';
        $this->template->content = View::forge('form/index');
    }

    public function forge_validiation()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        $val = \Fuel\Core\Validation::forge();

        $val->add('name', '名前')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length',50);

        $val->add('email', 'メールアドレス')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('max_length', 100)
            ->add_rule('valid_email');

        $val->add('comment','コメント')
            ->add_rule('required')
            ->add_rule('max_length', 400);

        return $val;
    }

    public function action_confirm()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        $val = $this->forge_validiation();

        if($val->run()){
            $data['input'] = $val->validated();
            $this->template->title = 'コンタクトフォーム : 確認';
            $this->template->content = View::forge('form/confirm', $data);
        }
        else{
            $this->template->title = 'コンタクトフォーム : エラー';
            $this->template->content = View::forge('form/index');
            $this->template->content ->set_safe('html_error', $val->show_errors());
        }
    }
}
<?php

namespace app\common\validate;


use think\Validate;

class Predeposit extends Validate
{
    protected $rule = [
        ['member_id', 'require|number', '用户名必须存在|用户名错误'],
        ['amount', 'require', '金额为必填'],
        ['operatetype', 'require', '增减类型为必填'],
        ['pdc_amount','require|min:0.01','提现金额为大于或者等于0.01的数字'],
        ['pdc_bank_name','require','请填写收款银行'],
        ['pdc_bank_no','require','请填写收款账号'],
        ['pdc_bank_user','require','请填写收款人姓名'],
        ['password','require', '请输入支付密码']
    ];

    protected $scene = [
        'pd_add' => ['member_id', 'amount', 'operatetype'],
        'pd_cash_add' => ['pdc_amount', 'pdc_bank_name', 'pdc_bank_no', 'pdc_bank_user', 'password'],
    ];
}
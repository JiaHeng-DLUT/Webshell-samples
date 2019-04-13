<?php

namespace app\common\validate;

use think\Validate;

class Recharge extends Validate
{
    protected $rule = [
        ['pdc_amount', 'require|min:0.01', '提现金额不正确|提现金额不正确'],
        ['pdc_bank_name', 'require', '请输入收款银行'],
        ['pdc_bank_no', 'require', '请输入收款账号'],
        ['pdc_bank_user', 'require', '请输入开户人姓名'],
        ['password', 'require', '请输入支付密码'],
        ['mobilenum', 'require', '请输入手机号码'],
    ];
    protected $scene = [
        'pd_cash_add' => ['pdc_amount', 'pdc_bank_name', 'pdc_bank_no', 'pdc_bank_user', 'password', 'mobilenum'],
    ];

}
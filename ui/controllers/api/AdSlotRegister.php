<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 接口 广告位注册
 */

class AdSlotRegister extends MY_Controller {

    const VALID_ADSLOT_KEY = [
        'slot_name',
        'app_id',
        'media_name',
        'slot_type',
        'slot_style',
        'slot_size',
        'slot_style_id',
    ];

    public function __construct() {
        parent::__construct();
    }

	/**
     *
	 */
	public function index() {
        if (empty($this->arrUser)) {
            return $this->outJson('', ErrCode::ERR_NOT_LOGIN);
        }
        $arrPostParams = $this->input->post();
        if (empty($arrPostParams)
            || count($arrPostParams) !== count(self::VALID_ADSLOT_KEY)) {
            return $this->outJson('', ErrCode::ERR_INVALID_PARAMS); 
        }
        // TODO 各种号码格式校验
        foreach ($arrPostParams as $key => &$val) {
            if(!in_array($key, self::VALID_ADSLOT_KEY)) {
                return $this->outJson('', ErrCode::ERR_INVALID_PARAMS); 
            }
            $val = $this->security->xss_clean($val);
        }

        $arrPostParams['account_id'] = $this->arrUser['account_id'];

        $this->load->model('AdSlot');
        $bolRes = $this->AdSlot->insertAdSlotInfo($arrPostParams);
        if ($bolRes) {
            return $this->outJson('', ErrCode::OK, '注册成功');
        }
        return $this->outJson('', ErrCode::ERR_SYSTEM);
	}
}

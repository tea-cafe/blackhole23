<?php
class ApiSdkCfg extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('ApiSdkModel');
    }

    /**
     * @param void
     * @return void
     */
    public function getSdkCfg() {
        $arrParams = $this->input->get(NULL, true);
        if(count($arrParams) != 2 
            || !isset($arrParams['app_id'])
            || !isset($arrParams['slot_id'])) {
            return $this->outJson([], ErrCode::ERR_INVALID_PARAMS);
        }
        $arrRet = $this->ApiSdkModel->getSdkCfgByAppId($arrParams);
        return $arrRet?$this->outJson($arrRet, ErrCode::OK) : $this->outJson([], ErrCode::ERR_SYSTEM);
    }
}

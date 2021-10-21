<?php
namespace app\common\service\qrcode;

use app\common\controller\BaseService;
require_once 'phpqrcode.php';
class QrcodeService extends BaseService
{
    protected $url = "/miniqrcode/";

    protected $errorCorrectionLevel = "L";

    protected $matrixPointSize = 5;
    /**
     * 单例对象
     */
    protected static $instance = null;

    private function __construct()
    {
    }
    /**
     * 初始化
     * @return static
     */
    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }



    /**
     * 这个私有方法用于防止实例被克隆
     */
    private function __clone()
    {
    }

    /**
     * 这个私有方法用于防止实例被反系列化
     */
    private function __wakeup()
    {
    }

    public function create($content = ""){
        ob_start();
        $QR = \QRcode::png($content,false,$this->errorCorrectionLevel,$this->matrixPointSize,2);
        $imageUrl = base64_encode(ob_get_contents());
        ob_end_clean();
        return "data:image/png;base64,$imageUrl";
    }
    public function createImage($content = "",$number = ""){
        $path = APP_PATH . '/../public'.$this->url;
        $fileName = $number.time().".png";
        $filePath = $path.$fileName;
        $QR = \QRcode::png($content,$filePath,$this->errorCorrectionLevel,$this->matrixPointSize,2);
        return $this->url.$fileName;
    }
}

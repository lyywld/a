<?php 
/**
* CI框架实现上传图片，生成大，小缩略图
*
* @author:yanglijun
* @date:2016-06-16
*/
class Test extends CI_Controller
{
	/**
	* 初始化默认页面
	*/
	public function index()
	{
        $this->load->view('sale/test.html');	
	}
	/**
	* 上传图片，生成大，小缩略图
	* 错误调试： echo $this->upload->display_errors();
	*/
	public function code()
	{
		$dir = dirname(dirname(dirname(dirname(__File__))));
		//上传图片到某路径下
		$config['upload_path'] = $dir.'/uploade';//上传图片地址
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		$this->load->library('upload', $config);//初始化文件上传类
		$res = $this->upload->do_upload('userfile');
		if($res == TRUE)
		{
			//在该目录下生成一张大缩略图
			$data=$this->upload->data();//返回上传图片的信息  
            $this->load->library("image_lib");//载入图像处理类库 
            $config_big_thumb = array(
            	'image_library' =>'gd2',
            	'source_image' => $data['full_path'],//原图  
                'new_image' => $dir.'/uploade/big'.$data['file_name'],//大缩略图  
                'create_thumb' => true,//是否创建缩略图  
                'maintain_ratio' => true,  
                'width' => 200,//缩略图宽度  
                'height' => 200,//缩略图的高度  
                'thumb_marker'=>"_200_200"//缩略图名字后加上 "_200_200",可以代表是一个200*200的缩略图  
            	);
			$this->image_lib->initialize($config_big_thumb);  
            $result = $this->image_lib->resize();//生成big缩略图  
       		if($result == true)
       		{
       			//在该目录下成成一下行小缩略图
				$config_small_thumb = array(  
                    'image_library' => 'gd2',//gd2图库  
                    'source_image' => $data['full_path'],//原图  
                    'new_image' => $dir.'/uploade/small'.$data['file_name'],//大缩略图  
                    'create_thumb' => true,//是否创建缩略图  
                    'maintain_ratio' => true,  
                    'width' => 150,//缩略图宽度  
                    'height' => 40,//缩略图的高度  
                    'thumb_marker'=>"_100_100"//缩略图名字后加上 "_300_300",可以代表是一个300*300的缩略图  
                );  
	            $this->image_lib->initialize($config_small_thumb);  
	            $small = $this->image_lib->resize();//生成small缩略图  
	            var_dump($small);
       		}
		}else
		{
			echo 'unsuccess';
		}	
	}
}

?>


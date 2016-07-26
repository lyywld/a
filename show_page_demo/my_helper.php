<?php
//系统跳转页
header("Content-type: text/html; charset=utf-8");
function jump($message, $url, $second = 3)
{
	$CI =&get_instance();
	$data = array();
	$data['state'] = $message['state'];//显示"ok"
	$data['content'] = $message['content'];// 显示提示消息
	$data['url'] = $url; // 跳转路径
	$data['second'] = $second; // 倒计时时间
	$CI->load->view('jump.html', $data);
}
/**
*  封装的 分页
* @author zoulipeng
*/
function show_page($url ='', $count = 0,$limit = 10,$offset =0, $pagination = 5)
{
	//处理limit 默认为10
	if (empty($limit) ||!is_numeric($limit))
	{
		$limit = 10;
	}
	//处理offset 默认为0
	if (empty($offset) ||!is_numeric($offset))
	{
		$offset = 0;
	}
	//处理pagination默认为0
	if (empty($pagination) ||!is_numeric($pagination))
	{
		$pagination = 5;
	}
	//判断参数 的合法性
	if (empty($url) || $count == 0)
	{
		return '';
	}
	//获取总页数
	$pageCount = ceil($count/$limit);
	//总页数为一页，不显示分页
	if ($pageCount == 1 )
	{
		return '';
	}
	//获取当前页数
	$num = ($offset +$limit)/$limit;
	//开始页
	$startPage = $num-($pagination-1)/2;
	//结束页
	$endPage = $startPage+$pagination-1;
	//处理前面不够
	if ($startPage <= 1)
	{
		$startPage = 1;
		$endPage = $pagination;
	}
	//处理后面不够
	if ($endPage >$pageCount)
	{
		$startPage = $pageCount-$pagination+1;
		$endPage  = $pageCount;
	}
	$links = "<span class='page-style'><span><a href='".$url."&limit=".$limit."&offset=0 '>首页</a></span>";
	if ($limit*($num-2) <= 0)
	{
		$links .= "<span><a href='".$url."&limit=".$limit."&offset= 0 '>上一页</a></span>";
	} else {
		$links .= "<span><a href='".$url."&limit=".$limit."&offset=".($limit*($num-2))." '>上一页</a></span>";
	}
	for ($i = $startPage; $i <= $endPage; $i++)
	{ 
		if ($i >=1 && ($i<=$pageCount))
		{
			if ($i == $num)
			{
				$links .="<span class='now-style'><a href='".$url."&limit=".$limit."&offset=".($limit*($i-1))." ' class='current-style'>".$i."</a></span>";
			}else
			{
				$links .="<span><a href='".$url."&limit=".$limit."&offset=".($limit*($i-1))." '>".$i."</a></span>";
			}
		}
	}
	if ($num>=$pageCount)
	{
		$links .=  "<span><a href='".$url."&limit=".$limit."&offset=".($limit*($pageCount-1))." '>下一页</a></span>";
	}else
	{
		$links .=  "<span><a href='".$url."&limit=".$limit."&offset=".($limit*$num)." '>下一页</a></span>";
	}
	$links .= "<span><a href='".$url."&limit=".$limit."&offset=".($pageCount-1)*$limit." '>末页</a></span>
	<span>共<i style='color:#4E4040;font-size:20px;margin:0 3px;'>".$pageCount."</i>页</span></span>";
	return $links;
}
?>
<?php
/**
 * WebHook
 *
 * 调用方法 webhook.php?path=目录&password=验证密码
 * 
 * @author    Longjianghu <215241062@qq.com>
 * @copyright Copyright © 2014 - 2018 sohocn.net All rights reserved
 * @created   2018-07-12
 * @updated   2018-07-12
 * @version   1.0.0
 */

$str = '';

try {
	$branch   = (isset($_GET['branch'])) ? $_GET['branch'] : 'master'; // 分支
	$path     = (isset($_GET['path'])) ? $_GET['path'] : ''; // 存储路径
	$password = (isset($_GET['password'])) ? $_GET['password'] : ''; // 验证密码

	if (empty($path)) {
		throw new \Exception('存码存放目录不能为空！');
	}

	$path = sprintf('%s/%s', getcwd(), ltrim($path));

	if ( ! is_dir($path)) {
		throw new \Exception('指定的目录不存在！');
	}

	if (empty($password)) {
		throw new \Exception('验证密码不能为空！');
	}

	$body = file_get_contents('php://input');

	if (empty($body)) {
		throw new \Exception('POST数据不能为空！');
	}

	$content = json_decode($body, true);

	if (json_last_error() != JSON_ERROR_NONE) {
		throw new \Exception('数据格式解析失败！');
	}

	if ($content['password'] != $password) {
		throw new \Exception(' 密码不正确！');
	}

	if ($content['ref'] != sprintf('refs/heads/%s', $branch)) {
		throw new \Exception(sprintf(' 忽略 %s 分支的更新！', $content['ref']));
	}

	shell_exec(sprintf('sudo cd %s && git pull origin %s 2>&1', $path, $branch));
	$str = sprintf('%s 于 %s 向 %s 项目的 %s 分支推送了代码'.PHP_EOL, $content['user_name'], date('Y-m-d H:i:s'), $content['repository']['name'], $content['ref']);
} catch (\Exception $e) {
	$str = $e->getMessage();
}

echo $str;
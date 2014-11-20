# MVC思想WEB框架

## About

框架主要目录:

config,controller,help,public,view,system,model,cache,log,cache,language.

主要模块:

Mysql模块，cache缓存，系统logger，base64模块，Mail模块，Language模块.

一个轻量级MVC小型web框架。


<hr>

## Config

### Nginx 

nginx下推荐lnmp一键安装。安装后需要添加nginx路由重写规则。

> /root/vhost.sh

添加域名，添加后，添加下重写规则,命名为jue.conf。


	location / {
		index index.html index.php;
        	if (-f $request_filename/index.html){
            	rewrite (.*) $1/index.html break;
        	}
        	if (-f $request_filename/index.php){
            	rewrite (.*) $1/index.php;
        	}
        	if (!-f $request_filename){
            	rewrite (.*) /index.php;
        	}
	}

	location ~ \/public\/(css|js|img)\/.*\.(js|css|gif|jpg|jpeg|png|bmp|swf) {
		valid_referers none blocked *.homeway.me;
  		if ($invalid_referer) {
  			rewrite ^/  http://xiaocao.u.qiniudn.com/blog%2Fpiratesp.png;
		}
	}

	location /system/ {
		return 403;
	}

<hr>
	
### Apache

Apache需要添加路由重写.htaccess功能，在http.d中配置。

添加功能后，在根目录添加重定向规则。

> vim .htaccess

内容如下：

	Options +FollowSymLinks
	RewriteEngine On
	RewriteRule ^(.*)$ index.php [NC,L]
	Allow from all


<hr>

## Usage

详细见事例。

<hr>

## Version

14.11.20 

<hr>

## Release

14.10.19 修改几个小型bug，优化性能。

14.10.29 添加language模块。

14.11.20 添加系统logger模块。

<hr>

## License

(The MIT License)

Copyright (c) 2014 Homeway.yao

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the 'Software'), to deal in
the Software without restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the
Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
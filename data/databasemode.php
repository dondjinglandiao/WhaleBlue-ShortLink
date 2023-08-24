<?php
$mode = 'file';//数据存储模式

//file  将数据文件存储至本地TXT文件

//api  调用API将数据存储至本地MongoDB数据库

//File模式在数据过多的情况下可能会出现查询时间过长的情况，若您的数据量十分庞大时可使用MongoDB模式

//API模式需要您已安装MongoDB服务及其相关PHP拓展，并在"/api"目录下执行"composer require mongodb/mongodb"命令

//若MongoDB服务使用非标准端口请修改"/api/index.php"文件第5行为正确的连接地址

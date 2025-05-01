# VMWare虚拟机搭建数据库并让**外网**可连接，并提供WEB GUI操作数据库

## 快速开始(Windows)

下面我的外网IP地址端口为800是因为我设置的端口转发是 800->80 因为本人的80端口已被占用(顺带一提，是OpenWRT的Luci)

1. 克隆仓库到本地

2. 在项目根目录使用cd命令切换到php-8.4.6-Win32-vs17-x64文件夹下

3. 使用命令php-cgi -b 127.0.0.1:9000 -c php.ini 开启php-cgi (开启后不要关闭cmd窗口，否则会失效)

4. 切换回根目录，打开nginx-1.26.2目录

5. 用文本编辑器打开html/index.php文件，修改`<a href="xxx">`超链接标签下的IP地址，更改为你的外网IP地址

   ![index.php](/pictures/INDEXPHP.jpg)

6. 关闭编辑器，依次打开phpMyAdmin/libraries/config.default.php

7. 修改configdefault.php文件的配置

   ```php
   $cfg['PmaAbsoluteUri'] = 'http://172.23.40.32:800/phpmyadmin/'; # 修改为你的外网IP地址
   
   $cfg['blowfish_secret'] = 'XyZ@1aBcD#9EfGhI%7JkLmN0OpQrStUvWxYz!'; # 可不动 或按注释修改
   
   $cfg['Servers'][$i]['host'] = '192.168.137.128'; # 修改为你的数据库IP
   
   $cfg['Servers'][$i]['port'] = ''; # 修改为你的数据库端口，如果为3306可留空
   
   $cfg['Servers'][$i]['user'] = 'criminal'; # 修改为用这个界面连接数据库的数据库用户名
   
   $cfg['Servers'][$i]['password'] = 'crazy4thdayv50'; # 上面用户名对应的密码
   ```

8. 退回nginx目录，双击nginx运行

9. 访问 http://你的IP地址:端口/ 即可看到主页，如果在内网没有开启NAT环回请用内网IP访问

10. 大功告成！现在你的VMWare可以对外提供网络服务，并且你跑在虚拟机上的MYSQL数据库也有了web页面可以轻松访问，通过主机的nginx转发请求，让你的主机有了一个相对安全的环境(即使虚拟机崩溃也对宿主机没什么影响)

    成果图：

    ![欢迎页](/pictures/INDEX.jpg)

    ![Adminer页面](/pictures/ADMINER.jpg)

    ![phpMyAdmin界面](/pictures/PHPMA.jpg)

    ![phpMyAdmin登录后](/pictures/PMA.jpg)

## 概述

这里记录了我这边在自己电脑的VMWare Ubuntu22.04系统上开启数据库并提供给外网连接的历程，

你将收获：

- VMWare虚拟机在NAT模式下的网络拓扑结构
- 如何在虚拟机开启一些网络服务(例如数据库服务和web服务)并让**外网**可访问(这里的外网指的是连接WAN口的路由器的WAN口IP地址)
- 如何让数据库能够对外提供基于Adminer/phpMyAdmin的web服务以随时随地轻松访问数据库

### 一、VMWare在NAT模式下的网络拓扑图

![VMWareNAT网络拓扑结构](pictures/VMNAT.JPG)

*如上图所示，转自知乎*

#### 1.请求路径

请求到达主机网关->通过主机网关端口映射(端口转发)把请求路由到主机->主机通过一些工具转发请求到虚拟机(中间经过了虚拟网卡和虚拟交换机，可以不太深究)

#### 2.虚拟机上网流程

虚拟机发起网络请求->到达交换机->到达虚拟网卡->虚拟网卡通过网络共享，使用主机的物理网卡和主机的IP发送数据

这也就是为什么有时候NAT模式不能上网，通过修改这里的设置可以让虚拟机联网

![Windows设置物理网卡与NAT虚拟网卡网络共享](/pictures/SETTING.png)

### 二、如何在虚拟机开启网络服务并供外网访问

#### 1.不要使用VMWare自带的端口映射功能

本人历经千辛万苦，看网上的教程使用了虚拟机自带的端口映射功能，无法到达预期的结果，**只能在局域网内访问**到VMWare映射后的虚拟机，功能如下图所示

![VMWare自带的端口映射(转发)功能](/pictures/VMPORT.jpg)

#### 2.使用VMWare自带的端口映射功能出现的问题

路由器开启了NAT环回，NAT环回简单理解就是能够在内网（局域网）使用外网IP来正常访问设备，这种情况下在内网是可以正常使用外网IP访问主机，然后主机会把请求转发到虚拟机

但是当把网络环境切换到外网后，访问就会失效，请求能正常到达主机，但是主机不会把外网的请求转发给虚拟机！所以后面使用其他方法进行转发时一定要关闭VMWare的端口转发（即4框出的范围里没有任何记录）

#### 3.解决方案

使用nginx的stream来转发所有的连接。

在nginx中配置stream来监听主机的端口并转发请求到虚拟机，这样的话外网的请求是能够顺利到达的，nginx配置文件仅供参考，替换为自己想要的端口即可，注意这里的stream块是与http块同级别

再次提醒：使用NGINX转发也一定要关闭VMWare的端口转发功能，否则外网的请求一样无法到达虚拟机

![NGINX转发配置](/pictures/NGINXCONF.jpg)

### 三、提供WEB GUI以操作运行在虚拟机上的数据库

这里给出了两个解决方案，一个是Adminer(轻量级单php文件实现，推荐)，一个是phpMyAdmin(这个页面有点太华丽了，不知道什么原因访问很慢，不太推荐)，这里都在nginx中有配置，遵循下面的”快速开始“以配置你的数据库可通过web页面访问

### 四、后续提升性能

可以使用Adminer，响应速度已经还是算不错了，如果还想提升性能可以考虑更换php，这里用了个线程安全版本的，可能是因为这个原因导致速度会慢了不少



最后，ENJOY!
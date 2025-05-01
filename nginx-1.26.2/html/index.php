<?php
echo '<!DOCTYPE html>
<html>
<head>
    <title>数据库WEBUI-欢迎页</title>
    <style>
        /* 基础样式 */
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }
        
        /* 卡片容器 */
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 30px;
            width: 80%;
            max-width: 600px;
        }
        
        /* 标题样式 */
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        /* 链接卡片 */
        .link-card {
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .link-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        /* 链接样式 */
        a {
            color: #2980b9;
            text-decoration: none;
            font-weight: 500;
        }
        
        a:hover {
            color: #3498db;
            text-decoration: underline;
        }
        
        /* 响应式设计 */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>数据库管理工具</h1>

        <div class="link-card">
            <p>访问 <a href="http://172.23.40.32:800/dbadmin.php" target="_blank" rel="noopener noreferrer">Adminer GUI</a> 来连接并操作数据库（推荐 快速，主打够用）</p>
        </div>

        <div class="link-card">
            <p>访问 <a href="http://172.23.40.32:800/phpmyadmin/index.php" target="_blank" rel="noopener noreferrer">phpMyAdmin GUI</a> 来连接并操作数据库（功能全面但速度很慢）</p>
        </div>
        
        <div class="link-card">
            <p>下载 <a href="https://www.navicat.com.cn/download/navicat-premium-lite" target="_blank" rel="noopener noreferrer">Navicat</a> 连接数据库</p>
        </div>
    </div>
</body>
</html>';
?>
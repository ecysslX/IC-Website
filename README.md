# IC-Website

IWBTC（I Wanna Be The Creator）相关社区站点，基于 **PHP + MySQL** 实现，提供首页展示、账号系统、社区群组导航、下载入口与工具页。

## 功能特性

- 首页轮播展示
- 用户注册 / 登录 / 个人资料页
- 社区群组信息聚合（支持头像直达入群）
- 游戏下载入口（多平台）
- 工具页面（碰撞点编辑器入口）
- 响应式适配（移动端菜单与页面布局优化）

## 技术栈

- 后端：PHP（PDO）
- 数据库：MySQL
- 前端：HTML + CSS + 原生 JavaScript

## 项目结构

```text
.
├─ IWBTCweb_php/
│  ├─ index.php             # 首页（轮播）
│  ├─ home.php              # 首页路由入口
│  ├─ login.php             # 登录页
│  ├─ register.php          # 注册页
│  ├─ profile.php           # 个人资料页
│  ├─ community.php         # 社区页
│  ├─ download.php          # 下载页
│  ├─ tools.php             # 工具入口页
│  ├─ tools.html            # 工具实现页
│  ├─ wiki.php              # 百科页
│  ├─ sidebar.php           # 顶部导航
│  ├─ footer.php            # 页脚
│  ├─ style.css             # 全站样式
│  ├─ config.php            # 数据库配置
│  ├─ database.sql          # 数据库初始化脚本
│  └─ pic/                  # 静态图片资源
└─ README.md
```

## 环境要求

- PHP 8.0+（需启用 `pdo_mysql`）
- MySQL 8.0+（5.7 也可运行，但建议 8.0）
- Windows / macOS / Linux

## 快速开始

### 1) 克隆仓库

```bash
git clone https://github.com/ecysslX/IC-Website.git
cd IC-Website
```

### 2) 初始化数据库

在 MySQL 中执行：

```sql
CREATE DATABASE IF NOT EXISTS `iwbtc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

导入初始化脚本：

```sql
-- 在仓库根目录执行 mysql 客户端后运行
SOURCE IWBTCweb_php/database.sql;
```

### 3) 配置数据库连接

编辑 `IWBTCweb_php/config.php`：

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`

请改为你本机实际配置。

### 4) 启动开发服务器

```bash
cd IWBTCweb_php
php -S 127.0.0.1:8080
```

访问：

```text
http://127.0.0.1:8080/home.php
```

> 如果需要局域网访问，可改为：`php -S 0.0.0.0:8080`

## 默认账号说明

`database.sql` 会写入示例账号（如未删改初始化数据）：

- `admin`
- `user`

密码请以你当前数据库中的哈希或重置结果为准（仓库不保证固定明文密码）。

## 常见问题

### 数据库连接失败

- 检查 MySQL 服务是否启动
- 检查 `config.php` 端口/用户名/密码是否正确
- 确认数据库 `iwbtc` 已创建并导入 `database.sql`

### `could not find driver`

PHP 未启用 `pdo_mysql` 扩展，请在 `php.ini` 开启并重启服务。

## 开发与贡献

欢迎提交 Issue / PR。

推荐流程：

1. Fork 仓库并创建功能分支
2. 提交改动并自测主要页面
3. 发起 Pull Request，说明改动范围与影响

## 安全建议

- 不要在仓库中提交生产环境数据库密码
- 建议后续改造为环境变量配置（如 `.env`）
- 线上部署建议启用 HTTPS 与最小权限数据库账号

## 路线图（建议）

- 配置与密钥环境变量化
- 页面文案与历史文件编码统一（UTF-8）
- 增加后台管理与内容维护能力
- 增加基础自动化测试

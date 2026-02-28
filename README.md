# IC-Website

IWBTC 相关网站项目（PHP + MySQL）。

## 项目结构

```text
.
├─ IWBTCweb_php/        # Web 根目录（主要代码）
│  ├─ index.php         # 首页入口
│  ├─ config.php        # 数据库配置
│  └─ database.sql      # 数据库初始化脚本
└─ README.md
```

## 环境要求

- PHP 8.0+（需启用 `pdo_mysql` 扩展）
- MySQL 8.0+（或兼容版本）
- Windows / macOS / Linux 均可

## 本地启动（推荐：PHP 内置服务器）

1. 进入项目目录：

```powershell
cd IWBTCweb_php
```

2. 建议先创建项目专用数据库账号（避免使用 root）：

```sql
CREATE DATABASE IF NOT EXISTS `iwbtc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'iwbtc_app'@'localhost' IDENTIFIED BY 'iwbtc_app_2026';
GRANT ALL PRIVILEGES ON `iwbtc`.* TO 'iwbtc_app'@'localhost';
FLUSH PRIVILEGES;
```

3. 导入表结构：

```sql
-- 在 MySQL 中执行
source database.sql;
```

4. 检查数据库配置是否与本机一致（文件：`IWBTCweb_php/config.php`）：

- `DB_HOST`：`localhost`
- `DB_PORT`：`3316`
- `DB_NAME`：`iwbtc`
- `DB_USER`：`iwbtc_app`
- `DB_PASS`：`iwbtc_app_2026`

如果你的 MySQL 端口或密码不同，请先修改这些值。

5. 启动 PHP 开发服务器：

```powershell
php -S 127.0.0.1:8080
```

6. 浏览器访问：

```text
http://127.0.0.1:8080/index.php
```

## 本地启动（可选：XAMPP/WAMP）

1. 将 `IWBTCweb_php` 放到站点目录（如 `htdocs`）。
2. 启动 Apache 与 MySQL。
3. 在 phpMyAdmin 导入 `database.sql`。
4. 保持 `config.php` 与实际 MySQL 配置一致。
5. 访问 `http://localhost/IWBTCweb_php/index.php`。

## 默认测试账号

`database.sql` 中包含示例账号（如未删除初始化数据）：

- 管理员：`admin`
- 普通用户：`user`

## 常见问题

- 页面出现数据库连接失败：
  - 检查 MySQL 是否启动。
  - 检查 `config.php` 中端口、账号、密码是否正确。
- 报错 `could not find driver`：
  - PHP 未启用 `pdo_mysql` 扩展，请在 `php.ini` 中开启后重启服务。
- 中文显示异常/注释乱码：
  - 这是历史文件编码问题，建议统一转换为 UTF-8（无 BOM）。

## 开发建议

- 不要在仓库中提交真实生产数据库密码。
- 可以后续将 `config.php` 改为读取环境变量（`.env`）以提高安全性。

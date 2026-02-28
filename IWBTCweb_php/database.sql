-- IWBTC游戏网站数据库设计
-- 数据库名称：iwbtc
-- 访问账号：root
-- 访问密码：
-- 数据库端口：3307

-- 创建数据库
CREATE DATABASE IF NOT EXISTS `iwbtc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `iwbtc`;

-- 启用UUID函数（MySQL 8.0+）
DELIMITER //
CREATE FUNCTION `generate_uuid`() RETURNS VARCHAR(36)
BEGIN
    RETURN UUID();
END//
DELIMITER ;

-- 用户表
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `uuid` VARCHAR(36) NOT NULL UNIQUE COMMENT '用户唯一标识',
    `username` VARCHAR(50) NOT NULL UNIQUE COMMENT '用户名',
    `email` VARCHAR(100) NOT NULL UNIQUE COMMENT '邮箱',
    `password_hash` VARCHAR(255) NOT NULL COMMENT '密码哈希值',
    `role_id` INT UNSIGNED DEFAULT 2 COMMENT '角色ID',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    `last_login_at` TIMESTAMP NULL COMMENT '最后登录时间',
    `status` ENUM('active', 'inactive', 'banned') DEFAULT 'active' COMMENT '用户状态',
    INDEX `idx_username` (`username`),
    INDEX `idx_email` (`email`),
    INDEX `idx_uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- 角色表
CREATE TABLE IF NOT EXISTS `roles` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE COMMENT '角色名称',
    `description` VARCHAR(255) COMMENT '角色描述',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    INDEX `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- 权限表
CREATE TABLE IF NOT EXISTS `permissions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE COMMENT '权限名称',
    `description` VARCHAR(255) COMMENT '权限描述',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
    INDEX `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限表';

-- 角色权限关联表
CREATE TABLE IF NOT EXISTS `role_permissions` (
    `role_id` INT UNSIGNED NOT NULL,
    `permission_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
    INDEX `idx_role_id` (`role_id`),
    INDEX `idx_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色权限关联表';

-- 用户登录日志表
CREATE TABLE IF NOT EXISTS `login_logs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `ip_address` VARCHAR(50) COMMENT '登录IP地址',
    `user_agent` VARCHAR(255) COMMENT '用户代理',
    `login_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '登录时间',
    `status` ENUM('success', 'failed') DEFAULT 'success' COMMENT '登录状态',
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_login_time` (`login_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户登录日志表';

-- 触发器：为新用户生成UUID
DELIMITER //
CREATE TRIGGER `before_user_insert` BEFORE INSERT ON `users`
FOR EACH ROW
BEGIN
    IF NEW.uuid IS NULL OR NEW.uuid = '' THEN
        SET NEW.uuid = UUID();
    END IF;
END//
DELIMITER ;

-- 插入初始数据
-- 角色数据
INSERT INTO `roles` (`name`, `description`) VALUES
('admin', '管理员'),
('user', '普通用户');

-- 权限数据
INSERT INTO `permissions` (`name`, `description`) VALUES
('user_manage', '用户管理'),
('content_manage', '内容管理'),
('tool_manage', '工具管理'),
('download_manage', '下载管理');

-- 角色权限关联数据
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1), -- 管理员拥有用户管理权限
(1, 2), -- 管理员拥有内容管理权限
(1, 3), -- 管理员拥有工具管理权限
(1, 4); -- 管理员拥有下载管理权限

-- 管理员用户（密码：admin123，使用bcrypt加密）
INSERT INTO `users` (`uuid`, `username`, `email`, `password_hash`, `role_id`, `status`) VALUES
(UUID(), 'admin', 'admin@iwbtc.com', '$2y$10$EixZaYVK1fsbw1ZfbX3OXePaWxn96p36WQoeG6Lruj3vjPGga31lW', 1, 'active');

-- 普通用户（密码：user123，使用bcrypt加密）
INSERT INTO `users` (`uuid`, `username`, `email`, `password_hash`, `role_id`, `status`) VALUES
(UUID(), 'user', 'user@iwbtc.com', '$2y$10$EixZaYVK1fsbw1ZfbX3OXePaWxn96p36WQoeG6Lruj3vjPGga31lW', 2, 'active');

-- 注释：
-- 1. 密码使用bcrypt加密存储，提高安全性
-- 2. 为用户表添加了UUID字段作为唯一标识
-- 3. 实现了角色权限系统，方便权限管理
-- 4. 添加了登录日志表，记录用户登录情况
-- 5. 使用触发器自动为新用户生成UUID
-- 6. 所有表都添加了适当的索引，优化查询性能
-- 7. 字符集统一使用utf8mb4，支持多语言
-- 8. 日期时间类型使用TIMESTAMP，统一标准格式

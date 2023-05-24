#DDL
CREATE DATABASE IF NOT EXISTS db_warehousems CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `ci_sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `ci_sessions` ADD KEY `ci_sessions_timestamp` (`timestamp`);

CREATE TABLE roles (
    id VARCHAR(36),
    
    code VARCHAR (10) NOT NULL,
    name VARCHAR(20) NOT NULL,

    created_by VARCHAR(36) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_by VARCHAR(36),
    updated_at TIMESTAMP,
    ver INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    UNIQUE KEY roles_bk1 (code),
    UNIQUE KEY roles_bk2 (code, name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
    id VARCHAR(36),
    
    email VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL,
    password TEXT NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    role_id VARCHAR(36) NOT NULL,
    
    created_by VARCHAR(36) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_by VARCHAR(36),
    updated_at TIMESTAMP,
    ver INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    UNIQUE KEY users_bk1 (email),
    UNIQUE KEY users_bk2 (username),
    CONSTRAINT roles_users_fk FOREIGN KEY (role_id) REFERENCES roles (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE goods_categories (
    id VARCHAR(36),
    
    code VARCHAR (10) NOT NULL,
    name VARCHAR(20) NOT NULL,

    created_by VARCHAR(36) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_by VARCHAR(36),
    updated_at TIMESTAMP,
    ver INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    UNIQUE KEY good_categories_bk1 (code),
    UNIQUE KEY good_categories_bk2 (code, name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE goods (
    id VARCHAR(36),
    
    item TEXT NOT NULL,
    qty INT NOT NULL DEFAULT 0,
    goods_category_id VARCHAR(36) NOT NULL,

    created_by VARCHAR(36) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_by VARCHAR(36),
    updated_at TIMESTAMP,
    ver INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    CONSTRAINT goods_categories_goods_fk FOREIGN KEY (goods_category_id) REFERENCES goods_categories (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE request_types (
    id VARCHAR(36),
    
    code VARCHAR (10) NOT NULL,
    name VARCHAR(20) NOT NULL,

    created_by VARCHAR(36) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_by VARCHAR(36),
    updated_at TIMESTAMP,
    ver INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    UNIQUE KEY request_types_bk1 (code),
    UNIQUE KEY request_types_bk2 (code, name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE request_hdr (
    id VARCHAR(36),

    trx_code VARCHAR(36) NOT NULL,
    request_type_id VARCHAR(36) NOT NULL,
    requested_by VARCHAR(36) NOT NULL,
    approved_by VARCHAR(36),
    approval BOOLEAN NOT NULL DEFAULT FALSE,

    created_by VARCHAR(36) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_by VARCHAR(36),
    updated_at TIMESTAMP,
    ver INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    UNIQUE KEY request_hdr_bk (trx_code),
    CONSTRAINT users_request_hdr_fk1 FOREIGN KEY (requested_by) REFERENCES users (id),
    CONSTRAINT users_request_hdr_fk2 FOREIGN KEY (approved_by) REFERENCES users (id),
    CONSTRAINT request_types_request_hdr_fk FOREIGN KEY (request_type_id) REFERENCES request_types (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE request_dtl (
    id VARCHAR(36),

    goods_id VARCHAR(36) NOT NULL,
    request_hdr_id VARCHAR(36) NOT NULL,
    qty INT NOT NULL DEFAULT 0,

    created_by VARCHAR(36) NOT NULL,
    created_at TIMESTAMP NOT NULL,
    updated_by VARCHAR(36),
    updated_at TIMESTAMP,
    ver INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    CONSTRAINT goods_request_dtl_fk FOREIGN KEY (goods_id) REFERENCES goods (id),
    CONSTRAINT request_hdr_request_dtl_fk FOREIGN KEY (request_hdr_id) REFERENCES request_hdr (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#DML

INSERT INTO roles (id, code, name, created_by, created_at) VALUES
('c8ed0b5a-9866-4f77-8c0c-6e315212e554', 'SYS', 'User System', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('bd8986f6-8556-4b47-8a20-d5ae4b257929', 'ADM', 'User Admin', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('4c5656d4-2ee0-4c8e-b5e5-57688152dd14', 'USR', 'User', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW());

INSERT INTO users (id, email, username, password, fullname, role_id, created_by, created_at) VALUES
('e508f500-b73d-44b2-a012-06153cd71f16', 'system@gmail.com', 'system', '21232f297a57a5a743894a0e4a801fc3', 'Maulana Rezi', 'c8ed0b5a-9866-4f77-8c0c-6e315212e554', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('dccc2b51-cfb7-4a65-ae1f-870a096941ff', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Anasda', 'bd8986f6-8556-4b47-8a20-d5ae4b257929', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('c480eaed-8783-4152-8ebe-0cebe3fbe3ef', 'user@gmail.com', 'user', '21232f297a57a5a743894a0e4a801fc3', 'Rian', '4c5656d4-2ee0-4c8e-b5e5-57688152dd14', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW());

INSERT INTO goods_categories (id, code, name, created_by, created_at) VALUES
('6a5721fa-9f68-4e49-9b46-9e777005d5c5', 'ATK', 'Alat Tulis Kantor', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('158325d0-3b65-4c2e-b3e1-c71384f98e55', 'PIT', 'Perangkat IT', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('6be9d5af-d57a-4e77-a726-661f89de5eb4', 'DLL', 'Lain-lain', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW());

INSERT INTO goods (id, item, qty, goods_category_id, created_by, created_at) VALUES
('5ee6cc82-c306-4bba-b73a-f4104152cf58', 'Pencil', 0, '6a5721fa-9f68-4e49-9b46-9e777005d5c5', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('bee2f359-a400-4b9b-9164-de610c8088e3', 'Router', 8,'158325d0-3b65-4c2e-b3e1-c71384f98e55', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('5d4d88a3-5352-483d-aa90-1aeafba245af', 'Hammer', 7,'6be9d5af-d57a-4e77-a726-661f89de5eb4', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW());

INSERT INTO request_types (id, code, name, created_by, created_at) VALUES
('3bac0dd4-c326-4ec4-a99e-dc64db3eefef', 'RCI', 'Request Check-In', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW()),
('61e197fa-22ce-4db6-9e0b-31aed6b6d613', 'RCO', 'Request Check-Out', 'e508f500-b73d-44b2-a012-06153cd71f16', NOW());

INSERT INTO `request_hdr` (`id`, `trx_code`, `request_type_id`, `requested_by`, `approved_by`, `approval`, `created_by`, `created_at`, `updated_by`, `updated_at`, `ver`, `is_active`) VALUES
('3f422d9a-fa0b-11ed-8e54-489ebddaa98a', 'TRX-1684916172-USYDB-HR7WB', '3bac0dd4-c326-4ec4-a99e-dc64db3eefef', 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', NULL, 0, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:16:12', NULL, '0000-00-00 00:00:00', 0, 1),
('49e0ef48-fa0b-11ed-8e54-489ebddaa98a', 'TRX-1684916190-E99ZX-ZMNPK', '61e197fa-22ce-4db6-9e0b-31aed6b6d613', 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', NULL, 0, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:16:30', NULL, '0000-00-00 00:00:00', 0, 1),
('75d75062-fa09-11ed-8e54-489ebddaa98a', 'TRX-1684915405-67421-EU65N', '3bac0dd4-c326-4ec4-a99e-dc64db3eefef', 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', 1, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:05:25', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', '2023-05-24 08:05:25', 1, 1),
('8863ab1b-fa09-11ed-8e54-489ebddaa98a', 'TRX-1684915436-1HGVT-4TSK2', '3bac0dd4-c326-4ec4-a99e-dc64db3eefef', 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', 0, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:05:56', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', '2023-05-24 08:05:56', 1, 1),
('bfb445f2-fa08-11ed-8e54-489ebddaa98a', 'TRX-1684915099-1RAKM-H70HI', '61e197fa-22ce-4db6-9e0b-31aed6b6d613', 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', 0, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 07:59:30', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', '2023-05-24 07:59:30', 1, 1),
('f45af6f9-fa09-11ed-8e54-489ebddaa98a', 'TRX-1684915617-APJ5Z-KUKYZ', '61e197fa-22ce-4db6-9e0b-31aed6b6d613', 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', 1, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:08:50', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', '2023-05-24 08:08:50', 1, 1);

INSERT INTO `request_dtl` (`id`, `goods_id`, `request_hdr_id`, `qty`, `created_by`, `created_at`, `updated_by`, `updated_at`, `ver`, `is_active`) VALUES
('3f42c5fb-fa0b-11ed-8e54-489ebddaa98a', '5d4d88a3-5352-483d-aa90-1aeafba245af', '3f422d9a-fa0b-11ed-8e54-489ebddaa98a', 1, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:16:12', NULL, '0000-00-00 00:00:00', 0, 1),
('3f42e6d6-fa0b-11ed-8e54-489ebddaa98a', 'bee2f359-a400-4b9b-9164-de610c8088e3', '3f422d9a-fa0b-11ed-8e54-489ebddaa98a', 3, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:16:12', NULL, '0000-00-00 00:00:00', 0, 1),
('49e12c04-fa0b-11ed-8e54-489ebddaa98a', '5d4d88a3-5352-483d-aa90-1aeafba245af', '49e0ef48-fa0b-11ed-8e54-489ebddaa98a', 2, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:16:30', NULL, '0000-00-00 00:00:00', 0, 1),
('49e13ae0-fa0b-11ed-8e54-489ebddaa98a', 'bee2f359-a400-4b9b-9164-de610c8088e3', '49e0ef48-fa0b-11ed-8e54-489ebddaa98a', 2, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:16:30', NULL, '0000-00-00 00:00:00', 0, 1),
('75d7d8ed-fa09-11ed-8e54-489ebddaa98a', '5d4d88a3-5352-483d-aa90-1aeafba245af', '75d75062-fa09-11ed-8e54-489ebddaa98a', 10, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:05:25', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', '2023-05-24 08:05:25', 1, 1),
('75d7e2b0-fa09-11ed-8e54-489ebddaa98a', 'bee2f359-a400-4b9b-9164-de610c8088e3', '75d75062-fa09-11ed-8e54-489ebddaa98a', 12, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:05:25', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', '2023-05-24 08:05:25', 1, 1),
('886413ee-fa09-11ed-8e54-489ebddaa98a', '5ee6cc82-c306-4bba-b73a-f4104152cf58', '8863ab1b-fa09-11ed-8e54-489ebddaa98a', 12, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:03:56', NULL, '0000-00-00 00:00:00', 0, 1),
('bfb528c7-fa08-11ed-8e54-489ebddaa98a', '5d4d88a3-5352-483d-aa90-1aeafba245af', 'bfb445f2-fa08-11ed-8e54-489ebddaa98a', 111, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 07:58:19', NULL, '0000-00-00 00:00:00', 0, 1),
('bfb532fb-fa08-11ed-8e54-489ebddaa98a', '5ee6cc82-c306-4bba-b73a-f4104152cf58', 'bfb445f2-fa08-11ed-8e54-489ebddaa98a', 222, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 07:58:19', NULL, '0000-00-00 00:00:00', 0, 1),
('f45b3d04-fa09-11ed-8e54-489ebddaa98a', '5d4d88a3-5352-483d-aa90-1aeafba245af', 'f45af6f9-fa09-11ed-8e54-489ebddaa98a', 3, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:08:50', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', '2023-05-24 08:08:50', 1, 1),
('f45b49b6-fa09-11ed-8e54-489ebddaa98a', 'bee2f359-a400-4b9b-9164-de610c8088e3', 'f45af6f9-fa09-11ed-8e54-489ebddaa98a', 4, 'c480eaed-8783-4152-8ebe-0cebe3fbe3ef', '2023-05-24 08:08:50', 'dccc2b51-cfb7-4a65-ae1f-870a096941ff', '2023-05-24 08:08:50', 1, 1);
-- ============================================================
-- RMS - Rental Management System
-- Role-Based Multi-Company Database
-- Final Version
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- DROP ALL TABLES (reverse dependency order)
-- This ensures no duplicate FK constraint errors on re-import
-- ============================================================
DROP TABLE IF EXISTS `rms_notifications`;
DROP TABLE IF EXISTS `rms_maintenance`;
DROP TABLE IF EXISTS `rms_moneyreceipt_details`;
DROP TABLE IF EXISTS `rms_moneyreceipts`;
DROP TABLE IF EXISTS `rms_invoice_details`;
DROP TABLE IF EXISTS `rms_invoices`;
DROP TABLE IF EXISTS `rms_leases`;
DROP TABLE IF EXISTS `rms_apartments`;
DROP TABLE IF EXISTS `rms_buildings`;
DROP TABLE IF EXISTS `rms_tenants`;
DROP TABLE IF EXISTS `rms_user_permissions`;
DROP TABLE IF EXISTS `rms_role_permissions`;
DROP TABLE IF EXISTS `rms_users`;
DROP TABLE IF EXISTS `rms_apartment_types`;
DROP TABLE IF EXISTS `rms_cities`;
DROP TABLE IF EXISTS `rms_countries`;
DROP TABLE IF EXISTS `rms_permissions`;
DROP TABLE IF EXISTS `rms_roles`;
DROP TABLE IF EXISTS `rms_companies`;

-- ============================================================
-- 1. COMPANIES
-- ============================================================
DROP TABLE IF EXISTS `rms_companies`;
CREATE TABLE `rms_companies` (
  `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name`           varchar(100)     NOT NULL,
  `contact`        varchar(45)      DEFAULT NULL,
  `bin`            varchar(45)      DEFAULT NULL,
  `email`          varchar(100)     DEFAULT NULL,
  `website`        varchar(100)     DEFAULT NULL,
  `city`           varchar(45)      DEFAULT NULL,
  `area`           varchar(45)      DEFAULT NULL,
  `street_address` varchar(100)     DEFAULT NULL,
  `post_code`      varchar(20)      DEFAULT NULL,
  `logo`           varchar(100)     DEFAULT NULL,
  `trade_license`  varchar(100)     DEFAULT NULL,
  `tagline`        varchar(150)     DEFAULT NULL,
  `is_active`      tinyint(1)       DEFAULT 1,
  `deleted_at`     timestamp        NULL DEFAULT NULL,
  `created_at`     timestamp        NULL DEFAULT current_timestamp(),
  `updated_at`     timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_companies` (`id`, `name`, `contact`, `email`, `city`, `area`, `street_address`, `is_active`) VALUES
(1, 'Demo Property Co.', '01700000000', 'demo@rms.com', 'Dhaka', 'Uttara', 'Road 12, Sector 7', 1);


-- ============================================================
-- 2. ROLES
-- ============================================================
DROP TABLE IF EXISTS `rms_roles`;
CREATE TABLE `rms_roles` (
  `id`          int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name`        varchar(50)      NOT NULL,
  `label`       varchar(100)     DEFAULT NULL,
  `description` text             DEFAULT NULL,
  `is_active`   tinyint(1)       DEFAULT 1,
  `created_at`  timestamp        NOT NULL DEFAULT current_timestamp(),
  `updated_at`  timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_roles` (`id`, `name`, `label`, `description`, `is_active`) VALUES
(1, 'super_admin', 'Super Administrator',    'Has full access to all companies and settings', 1),
(2, 'admin',       'Company Administrator',  'Has full access to their own company',          1);


-- ============================================================
-- 3. PERMISSIONS
-- ============================================================
DROP TABLE IF EXISTS `rms_permissions`;
CREATE TABLE `rms_permissions` (
  `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name`       varchar(100)     NOT NULL,
  `label`      varchar(100)     NOT NULL,
  `group`      varchar(50)      NOT NULL,
  `created_at` timestamp        NULL DEFAULT current_timestamp(),
  `updated_at` timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_permissions` (`name`, `label`, `group`) VALUES
('tenant.view',        'View Tenants',       'Tenants'),
('tenant.create',      'Create Tenants',     'Tenants'),
('tenant.edit',        'Edit Tenants',       'Tenants'),
('tenant.delete',      'Delete Tenants',     'Tenants'),
('building.view',      'View Buildings',     'Buildings'),
('building.create',    'Create Buildings',   'Buildings'),
('building.edit',      'Edit Buildings',     'Buildings'),
('building.delete',    'Delete Buildings',   'Buildings'),
('apartment.view',     'View Apartments',    'Apartments'),
('apartment.create',   'Create Apartments',  'Apartments'),
('apartment.edit',     'Edit Apartments',    'Apartments'),
('apartment.delete',   'Delete Apartments',  'Apartments'),
('lease.view',         'View Leases',        'Leases'),
('lease.create',       'Create Leases',      'Leases'),
('lease.edit',         'Edit Leases',        'Leases'),
('lease.delete',       'Delete Leases',      'Leases'),
('invoice.view',       'View Invoices',      'Invoices'),
('invoice.create',     'Create Invoices',    'Invoices'),
('invoice.edit',       'Edit Invoices',      'Invoices'),
('invoice.delete',     'Delete Invoices',    'Invoices'),
('receipt.view',       'View Receipts',      'Receipts'),
('receipt.create',     'Create Receipts',    'Receipts'),
('receipt.edit',       'Edit Receipts',      'Receipts'),
('receipt.delete',     'Delete Receipts',    'Receipts'),
('maintenance.view',   'View Maintenance',   'Maintenance'),
('maintenance.create', 'Create Maintenance', 'Maintenance'),
('maintenance.edit',   'Edit Maintenance',   'Maintenance'),
('maintenance.delete', 'Delete Maintenance', 'Maintenance'),
('maintenance.assign', 'Assign Maintenance', 'Maintenance'),
('report.view',        'View Reports',       'Reports'),
('user.view',          'View Users',         'Users'),
('user.create',        'Create Users',       'Users'),
('user.edit',          'Edit Users',         'Users'),
('user.delete',        'Delete Users',       'Users');


-- ============================================================
-- 4. COUNTRIES
-- ============================================================
DROP TABLE IF EXISTS `rms_countries`;
CREATE TABLE `rms_countries` (
  `id`              int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name`            varchar(45)      NOT NULL,
  `code`            varchar(45)      NOT NULL,
  `currency`        varchar(45)      NOT NULL,
  `currency_symbol` varchar(10)      DEFAULT NULL,
  `is_active`       tinyint(1)       DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_countries` (`id`, `name`, `code`, `currency`, `currency_symbol`, `is_active`) VALUES
(1, 'Bangladesh', 'bd', 'Taka', '৳', 1);


-- ============================================================
-- 5. CITIES
-- ============================================================
DROP TABLE IF EXISTS `rms_cities`;
CREATE TABLE `rms_cities` (
  `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(10) unsigned NOT NULL,
  `name`       varchar(45)      NOT NULL,
  `is_active`  tinyint(1)       DEFAULT 1,
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_cities_fk_country` FOREIGN KEY (`country_id`) REFERENCES `rms_countries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_cities` (`id`, `country_id`, `name`, `is_active`) VALUES
(1, 1, 'Dhaka',   1),
(2, 1, 'Rangpur', 1);


-- ============================================================
-- 6. APARTMENT TYPES
-- ============================================================
DROP TABLE IF EXISTS `rms_apartment_types`;
CREATE TABLE `rms_apartment_types` (
  `id`          int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name`        varchar(45)      NOT NULL,
  `description` text             DEFAULT NULL,
  `is_active`   tinyint(1)       DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_apartment_types` (`id`, `name`, `is_active`) VALUES
(1, 'Studio',    1),
(2, '2-Bedroom', 1),
(3, '3-Bedroom', 1),
(4, 'Penthouse', 1);


-- ============================================================
-- 7. USERS
-- ============================================================
DROP TABLE IF EXISTS `rms_users`;
CREATE TABLE `rms_users` (
  `id`                int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`        int(10) unsigned DEFAULT NULL,
  `role_id`           int(10) unsigned NOT NULL DEFAULT 2,
  `tenant_id`         int(10) unsigned DEFAULT NULL,
  `name`              varchar(100)     NOT NULL,
  `email`             varchar(150)     NOT NULL,
  `password`          varchar(255)     NOT NULL,
  `contact`           varchar(45)      DEFAULT NULL,
  `photo`             varchar(100)     DEFAULT NULL,
  `is_active`         tinyint(1)       DEFAULT 1,
  `email_verified_at` timestamp        NULL DEFAULT NULL,
  `remember_token`    varchar(100)     DEFAULT NULL,
  `last_login_at`     timestamp        NULL DEFAULT NULL,
  `deleted_at`        timestamp        NULL DEFAULT NULL,
  `created_by`        int(10) unsigned DEFAULT NULL,
  `updated_by`        int(10) unsigned DEFAULT NULL,
  `created_at`        timestamp        NULL DEFAULT current_timestamp(),
  `updated_at`        timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  CONSTRAINT `rms_users_fk_company`    FOREIGN KEY (`company_id`) REFERENCES `rms_companies` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rms_users_fk_role`       FOREIGN KEY (`role_id`)    REFERENCES `rms_roles`     (`id`),
  CONSTRAINT `rms_users_fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `rms_users`    (`id`) ON DELETE SET NULL,
  CONSTRAINT `rms_users_fk_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `rms_users`    (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_users` (`id`, `company_id`, `role_id`, `name`, `email`, `password`, `is_active`) VALUES
(1, NULL, 1, 'Sharafat',   'sharafatshams.j@gmail.com', '$2y$12$SAd7tb8LvnIygZdH8IOWc.Dhs6W/pnv75uZTlDbJ6Bb8LcL.G6iBq', 1),
(2, 1,    2, 'Demo Admin', 'admin@demo.com',             '$2y$12$SAd7tb8LvnIygZdH8IOWc.Dhs6W/pnv75uZTlDbJ6Bb8LcL.G6iBq', 1);


-- ============================================================
-- 8. ROLE PERMISSIONS
-- ============================================================
DROP TABLE IF EXISTS `rms_role_permissions`;
CREATE TABLE `rms_role_permissions` (
  `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id`       int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `created_by`    int(10) unsigned DEFAULT NULL,
  `created_at`    timestamp        NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_permission_unique` (`role_id`, `permission_id`),
  CONSTRAINT `rms_role_permissions_fk_role`       FOREIGN KEY (`role_id`)       REFERENCES `rms_roles`       (`id`) ON DELETE CASCADE,
  CONSTRAINT `rms_role_permissions_fk_permission` FOREIGN KEY (`permission_id`) REFERENCES `rms_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rms_role_permissions_fk_created_by` FOREIGN KEY (`created_by`)    REFERENCES `rms_users`       (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- super_admin gets all permissions
INSERT INTO `rms_role_permissions` (`role_id`, `permission_id`)
SELECT 1, `id` FROM `rms_permissions`;

-- admin gets all permissions except user management
INSERT INTO `rms_role_permissions` (`role_id`, `permission_id`)
SELECT 2, `id` FROM `rms_permissions` WHERE `group` != 'Users';


-- ============================================================
-- 9. USER PERMISSIONS
-- ============================================================
DROP TABLE IF EXISTS `rms_user_permissions`;
CREATE TABLE `rms_user_permissions` (
  `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`       int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  `is_granted`    tinyint(1)       NOT NULL DEFAULT 1,
  `created_by`    int(10) unsigned DEFAULT NULL,
  `created_at`    timestamp        NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_permission_unique` (`user_id`, `permission_id`),
  CONSTRAINT `rms_user_permissions_fk_user`       FOREIGN KEY (`user_id`)       REFERENCES `rms_users`       (`id`) ON DELETE CASCADE,
  CONSTRAINT `rms_user_permissions_fk_permission` FOREIGN KEY (`permission_id`) REFERENCES `rms_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rms_user_permissions_fk_created_by` FOREIGN KEY (`created_by`)    REFERENCES `rms_users`       (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- 10. TENANTS
-- ============================================================
DROP TABLE IF EXISTS `rms_tenants`;
CREATE TABLE `rms_tenants` (
  `id`                         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`                 int(10) unsigned NOT NULL,
  `name`                       varchar(100)     NOT NULL,
  `nid`                        varchar(45)      NOT NULL,
  `contact`                    varchar(45)      NOT NULL,
  `email`                      varchar(100)     NOT NULL,
  `gender`                     enum('Male','Female','Other') DEFAULT NULL,
  `date_of_birth`              date             DEFAULT NULL,
  `profession`                 varchar(100)     DEFAULT NULL,
  `address`                    text             DEFAULT NULL,
  `photo`                      varchar(100)     DEFAULT NULL,
  `nid_front`                  varchar(100)     DEFAULT NULL,
  `nid_back`                   varchar(100)     DEFAULT NULL,
  `postcode`                   varchar(45)      DEFAULT NULL,
  `city`                       varchar(45)      DEFAULT NULL,
  `country_id`                 int(10) unsigned DEFAULT NULL,
  `emergency_contact_name`     varchar(100)     DEFAULT NULL,
  `emergency_contact_mobile`   varchar(45)      DEFAULT NULL,
  `emergency_contact_relation` varchar(50)      DEFAULT NULL,
  `remarks`                    text             DEFAULT NULL,
  `is_active`                  tinyint(1)       DEFAULT 1,
  `deleted_at`                 timestamp        NULL DEFAULT NULL,
  `created_by`                 int(10) unsigned NOT NULL,
  `updated_by`                 int(10) unsigned DEFAULT NULL,
  `created_at`                 timestamp        NULL DEFAULT current_timestamp(),
  `updated_at`                 timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_tenants_fk_company`    FOREIGN KEY (`company_id`) REFERENCES `rms_companies` (`id`),
  CONSTRAINT `rms_tenants_fk_country`    FOREIGN KEY (`country_id`) REFERENCES `rms_countries` (`id`) ON DELETE SET NULL,
  CONSTRAINT `rms_tenants_fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `rms_users`     (`id`),
  CONSTRAINT `rms_tenants_fk_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `rms_users`     (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_tenants` (`id`, `company_id`, `name`, `nid`, `contact`, `email`, `address`, `country_id`, `created_by`) VALUES
(1, 1, 'Rafia',    '155515151', '5466511',     'rafia@gmail.com',    'Na', 1, 2),
(2, 1, 'Sharafat', '15451',     '01774379688', 'sharafat@gmail.com', 'Na', 1, 2),
(3, 1, 'Pritom',   '654651',    '651651',      'pritom@gmail.com',   'Na', 1, 2),
(4, 1, 'Monir',    '651661',    '145151',      'monir@gmail.com',    'Na', 1, 2),
(5, 1, 'Nahid',    '951216',    '51645',       'nahid@gmail.com',    'Na', 1, 2),
(6, 1, 'Ratul',    '651116',    '515165',      'ratul@gmail.com',    'Na', 1, 2),
(7, 1, 'Hasan',    '6541651',   '516115',      'hasan@gmail.com',    'Na', 1, 2),
(8, 1, 'Rifa',     '651515',    '4584696',     'rifa@gmail.com',     'Na', 1, 2);


-- ============================================================
-- 11. BUILDINGS
-- ============================================================
DROP TABLE IF EXISTS `rms_buildings`;
CREATE TABLE `rms_buildings` (
  `id`           int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`   int(10) unsigned NOT NULL,
  `name`         varchar(100)     NOT NULL,
  `contact`      varchar(45)      DEFAULT NULL,
  `email`        varchar(100)     DEFAULT NULL,
  `address`      text             DEFAULT NULL,
  `city_id`      int(10) unsigned NOT NULL,
  `country_id`   int(10) unsigned NOT NULL,
  `total_floors` int(10)          DEFAULT NULL,
  `total_units`  int(10)          DEFAULT NULL,
  `photo`        varchar(100)     DEFAULT NULL,
  `description`  text             DEFAULT NULL,
  `is_active`    tinyint(1)       DEFAULT 1,
  `deleted_at`   timestamp        NULL DEFAULT NULL,
  `created_by`   int(10) unsigned NOT NULL,
  `updated_by`   int(10) unsigned DEFAULT NULL,
  `created_at`   timestamp        NULL DEFAULT current_timestamp(),
  `updated_at`   timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_buildings_fk_company`    FOREIGN KEY (`company_id`) REFERENCES `rms_companies` (`id`),
  CONSTRAINT `rms_buildings_fk_city`       FOREIGN KEY (`city_id`)    REFERENCES `rms_cities`    (`id`),
  CONSTRAINT `rms_buildings_fk_country`    FOREIGN KEY (`country_id`) REFERENCES `rms_countries` (`id`),
  CONSTRAINT `rms_buildings_fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `rms_users`     (`id`),
  CONSTRAINT `rms_buildings_fk_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `rms_users`     (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_buildings` (`id`, `company_id`, `name`, `address`, `city_id`, `country_id`, `created_by`) VALUES
(1, 1, 'Rose Valley Tower', 'Plot 45, Sector 7, Uttara', 1, 1, 2),
(2, 1, 'Skyline Heights',   'Modern Road, Rangpur',      2, 1, 2);


-- ============================================================
-- 12. APARTMENTS
-- ============================================================
DROP TABLE IF EXISTS `rms_apartments`;
CREATE TABLE `rms_apartments` (
  `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`    int(10) unsigned NOT NULL,
  `building_id`   int(10) unsigned NOT NULL,
  `type_id`       int(10) unsigned NOT NULL,
  `apartment_no`  varchar(20)      NOT NULL,
  `floor`         varchar(20)      NOT NULL,
  `rent`          decimal(10,2)    NOT NULL,
  `size_sqft`     int(10)          DEFAULT NULL,
  `num_bedrooms`  int(5)           DEFAULT NULL,
  `num_bathrooms` int(5)           DEFAULT NULL,
  `has_parking`   tinyint(1)       DEFAULT 0,
  `is_furnished`  tinyint(1)       DEFAULT 0,
  `facing`        enum('North','South','East','West') DEFAULT NULL,
  `photo`         varchar(100)     DEFAULT NULL,
  `description`   text             DEFAULT NULL,
  `status`        enum('Available','Occupied','Maintenance') DEFAULT 'Available',
  `deleted_at`    timestamp        NULL DEFAULT NULL,
  `created_by`    int(10) unsigned NOT NULL,
  `updated_by`    int(10) unsigned DEFAULT NULL,
  `created_at`    timestamp        NULL DEFAULT current_timestamp(),
  `updated_at`    timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_apartments_fk_company`    FOREIGN KEY (`company_id`)  REFERENCES `rms_companies`       (`id`),
  CONSTRAINT `rms_apartments_fk_building`   FOREIGN KEY (`building_id`) REFERENCES `rms_buildings`       (`id`),
  CONSTRAINT `rms_apartments_fk_type`       FOREIGN KEY (`type_id`)     REFERENCES `rms_apartment_types` (`id`),
  CONSTRAINT `rms_apartments_fk_created_by` FOREIGN KEY (`created_by`)  REFERENCES `rms_users`           (`id`),
  CONSTRAINT `rms_apartments_fk_updated_by` FOREIGN KEY (`updated_by`)  REFERENCES `rms_users`           (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_apartments` (`id`, `company_id`, `building_id`, `type_id`, `apartment_no`, `floor`, `rent`, `size_sqft`, `status`, `created_by`) VALUES
(1, 1, 1, 2, 'A-101', '1', 15000.00, 1200, 'Available', 2),
(5, 1, 1, 3, 'B-502', '5', 25000.00, 1800, 'Available', 2);


-- ============================================================
-- 13. LEASES
-- ============================================================
DROP TABLE IF EXISTS `rms_leases`;
CREATE TABLE `rms_leases` (
  `id`                    int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`            int(10) unsigned NOT NULL,
  `tenant_id`             int(10) unsigned NOT NULL,
  `apartment_id`          int(10) unsigned NOT NULL,
  `start_date`            date             NOT NULL,
  `end_date`              date             DEFAULT NULL,
  `monthly_rent`          decimal(10,2)    NOT NULL,
  `security_deposit`      decimal(10,2)    DEFAULT NULL,
  `total_paid`            decimal(10,2)    NOT NULL DEFAULT 0.00,
  `rent_due_day`          tinyint(2)       NOT NULL DEFAULT 1,
  `grace_period_days`     tinyint(2)       NOT NULL DEFAULT 5,
  `late_fee_amount`       decimal(10,2)    DEFAULT 0.00,
  `late_fee_percent`      decimal(5,2)     DEFAULT 0.00,
  `notice_period_days`    int(10)          DEFAULT 30,
  `agreement_document`    varchar(100)     DEFAULT NULL,
  `status`                enum('Active','Terminated','Expired') DEFAULT 'Active',
  `renewed_from_lease_id` int(10) unsigned DEFAULT NULL,
  `terminated_at`         datetime         DEFAULT NULL,
  `termination_reason`    text             DEFAULT NULL,
  `deleted_at`            timestamp        NULL DEFAULT NULL,
  `created_by`            int(10) unsigned NOT NULL,
  `updated_by`            int(10) unsigned DEFAULT NULL,
  `created_at`            timestamp        NULL DEFAULT current_timestamp(),
  `updated_at`            timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_leases_fk_company`    FOREIGN KEY (`company_id`)            REFERENCES `rms_companies`  (`id`),
  CONSTRAINT `rms_leases_fk_tenant`     FOREIGN KEY (`tenant_id`)             REFERENCES `rms_tenants`    (`id`),
  CONSTRAINT `rms_leases_fk_apartment`  FOREIGN KEY (`apartment_id`)          REFERENCES `rms_apartments` (`id`),
  CONSTRAINT `rms_leases_fk_renewed`    FOREIGN KEY (`renewed_from_lease_id`) REFERENCES `rms_leases`     (`id`) ON DELETE SET NULL,
  CONSTRAINT `rms_leases_fk_created_by` FOREIGN KEY (`created_by`)            REFERENCES `rms_users`      (`id`),
  CONSTRAINT `rms_leases_fk_updated_by` FOREIGN KEY (`updated_by`)            REFERENCES `rms_users`      (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_leases` (`id`, `company_id`, `tenant_id`, `apartment_id`, `start_date`, `end_date`, `monthly_rent`, `security_deposit`, `total_paid`, `status`, `created_by`) VALUES
(1, 1, 2, 1, '2026-03-01', '2027-02-28', 25000.00, 50000.00, 1200.00, 'Active', 2);


-- ============================================================
-- 14. INVOICES
-- ============================================================
DROP TABLE IF EXISTS `rms_invoices`;
CREATE TABLE `rms_invoices` (
  `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`    int(10) unsigned NOT NULL,
  `lease_id`      int(10) unsigned NOT NULL,
  `tenant_id`     int(10) unsigned NOT NULL,
  `amount`        decimal(10,2)    NOT NULL,
  `invoice_date`  date             NOT NULL,
  `due_date`      date             NOT NULL,
  `period`        varchar(255)     NOT NULL,
  `late_fee`      decimal(10,2)    DEFAULT 0.00,
  `late_fee_date` date             DEFAULT NULL,
  `status`        enum('Pending','Paid','Overdue','Cancelled') DEFAULT 'Pending',
  `notes`         text             DEFAULT NULL,
  `paid_at`       timestamp        NULL DEFAULT NULL,
  `deleted_at`    timestamp        NULL DEFAULT NULL,
  `created_by`    int(10) unsigned NOT NULL,
  `updated_by`    int(10) unsigned DEFAULT NULL,
  `created_at`    timestamp        NULL DEFAULT current_timestamp(),
  `updated_at`    timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_invoices_fk_company`    FOREIGN KEY (`company_id`) REFERENCES `rms_companies` (`id`),
  CONSTRAINT `rms_invoices_fk_lease`      FOREIGN KEY (`lease_id`)   REFERENCES `rms_leases`    (`id`),
  CONSTRAINT `rms_invoices_fk_tenant`     FOREIGN KEY (`tenant_id`)  REFERENCES `rms_tenants`   (`id`),
  CONSTRAINT `rms_invoices_fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `rms_users`     (`id`),
  CONSTRAINT `rms_invoices_fk_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `rms_users`     (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_invoices` (`id`, `company_id`, `lease_id`, `tenant_id`, `amount`, `invoice_date`, `due_date`, `period`, `status`, `created_by`) VALUES
(1, 1, 1, 2, 1200.00, '2026-03-01', '2026-03-05', 'March 2026', 'Paid', 2);


-- ============================================================
-- 15. INVOICE DETAILS
-- ============================================================
DROP TABLE IF EXISTS `rms_invoice_details`;
CREATE TABLE `rms_invoice_details` (
  `id`          int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`  int(10) unsigned NOT NULL,
  `invoice_id`  int(10) unsigned NOT NULL,
  `description` varchar(255)     NOT NULL,
  `price`       decimal(10,2)    NOT NULL,
  `qty`         decimal(10,2)    NOT NULL DEFAULT 1.00,
  `vat`         decimal(10,2)    NOT NULL DEFAULT 0.00,
  `discount`    decimal(10,2)    NOT NULL DEFAULT 0.00,
  `sort_order`  int(10)          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_invoice_details_fk_company` FOREIGN KEY (`company_id`) REFERENCES `rms_companies` (`id`),
  CONSTRAINT `rms_invoice_details_fk_invoice` FOREIGN KEY (`invoice_id`) REFERENCES `rms_invoices`  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_invoice_details` (`company_id`, `invoice_id`, `description`, `price`, `qty`, `vat`, `discount`, `sort_order`) VALUES
(1, 1, 'Monthly Apartment Rent', 1200.00, 1.00, 0.00, 0.00, 1);


-- ============================================================
-- 16. MONEY RECEIPTS
-- ============================================================
DROP TABLE IF EXISTS `rms_moneyreceipts`;
CREATE TABLE `rms_moneyreceipts` (
  `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`     int(10) unsigned NOT NULL,
  `invoice_id`     int(10) unsigned NOT NULL,
  `tenant_id`      int(10) unsigned NOT NULL,
  `lease_id`       int(10) unsigned NOT NULL,
  `payment_method` varchar(50)      DEFAULT 'Cash',
  `transaction_no` varchar(100)     DEFAULT NULL,
  `reference_no`   varchar(255)     DEFAULT NULL,
  `remark`         text             DEFAULT NULL,
  `receipt_total`  decimal(10,2)    DEFAULT 0.00,
  `discount`       decimal(10,2)    DEFAULT 0.00,
  `vat`            decimal(10,2)    DEFAULT 0.00,
  `received_by`    int(10) unsigned DEFAULT NULL,
  `deleted_at`     timestamp        NULL DEFAULT NULL,
  `created_by`     int(10) unsigned NOT NULL,
  `updated_by`     int(10) unsigned DEFAULT NULL,
  `created_at`     datetime         NOT NULL DEFAULT current_timestamp(),
  `updated_at`     datetime         NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_moneyreceipts_fk_company`     FOREIGN KEY (`company_id`)  REFERENCES `rms_companies`  (`id`),
  CONSTRAINT `rms_moneyreceipts_fk_invoice`     FOREIGN KEY (`invoice_id`)  REFERENCES `rms_invoices`   (`id`),
  CONSTRAINT `rms_moneyreceipts_fk_tenant`      FOREIGN KEY (`tenant_id`)   REFERENCES `rms_tenants`    (`id`),
  CONSTRAINT `rms_moneyreceipts_fk_lease`       FOREIGN KEY (`lease_id`)    REFERENCES `rms_leases`     (`id`),
  CONSTRAINT `rms_moneyreceipts_fk_received_by` FOREIGN KEY (`received_by`) REFERENCES `rms_users`      (`id`) ON DELETE SET NULL,
  CONSTRAINT `rms_moneyreceipts_fk_created_by`  FOREIGN KEY (`created_by`)  REFERENCES `rms_users`      (`id`),
  CONSTRAINT `rms_moneyreceipts_fk_updated_by`  FOREIGN KEY (`updated_by`)  REFERENCES `rms_users`      (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_moneyreceipts` (`id`, `company_id`, `invoice_id`, `tenant_id`, `lease_id`, `payment_method`, `remark`, `receipt_total`, `created_by`) VALUES
(1, 1, 1, 2, 1, 'Cash', 'Rent for March 2026', 1200.00, 2);


-- ============================================================
-- 17. MONEY RECEIPT DETAILS
-- ============================================================
DROP TABLE IF EXISTS `rms_moneyreceipt_details`;
CREATE TABLE `rms_moneyreceipt_details` (
  `id`               int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`       int(10) unsigned NOT NULL,
  `money_receipt_id` int(10) unsigned NOT NULL,
  `description`      varchar(255)     NOT NULL,
  `price`            decimal(10,2)    NOT NULL,
  `qty`              decimal(10,2)    NOT NULL DEFAULT 1.00,
  `vat`              decimal(10,2)    NOT NULL DEFAULT 0.00,
  `discount`         decimal(10,2)    NOT NULL DEFAULT 0.00,
  `sort_order`       int(10)          NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_moneyreceipt_details_fk_company` FOREIGN KEY (`company_id`)       REFERENCES `rms_companies`     (`id`),
  CONSTRAINT `rms_moneyreceipt_details_fk_receipt` FOREIGN KEY (`money_receipt_id`) REFERENCES `rms_moneyreceipts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rms_moneyreceipt_details` (`company_id`, `money_receipt_id`, `description`, `price`, `qty`, `vat`, `discount`, `sort_order`) VALUES
(1, 1, 'Monthly Apartment Rent', 1200.00, 1.00, 0.00, 0.00, 1);


-- ============================================================
-- 18. MAINTENANCE
-- ============================================================
DROP TABLE IF EXISTS `rms_maintenance`;
CREATE TABLE `rms_maintenance` (
  `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id`    int(10) unsigned NOT NULL,
  `apartment_id`  int(10) unsigned NOT NULL,
  `title`         varchar(100)     NOT NULL,
  `description`   text             DEFAULT NULL,
  `priority`      enum('Low','Medium','High','Urgent')                   DEFAULT 'Medium',
  `status`        enum('Open','In Progress','Resolved','Cancelled')      DEFAULT 'Open',
  `cost`          decimal(10,2)    DEFAULT 0.00,
  `cost_bearer`   enum('company','tenant')                               DEFAULT 'company',
  `charge_method` enum('next_invoice','separate_invoice')                DEFAULT 'next_invoice',
  `is_billed`     tinyint(1)       DEFAULT 0,
  `invoice_id`    int(10) unsigned DEFAULT NULL,
  `photo_before`  varchar(100)     DEFAULT NULL,
  `photo_after`   varchar(100)     DEFAULT NULL,
  `vendor_name`   varchar(100)     DEFAULT NULL,
  `vendor_mobile` varchar(45)      DEFAULT NULL,
  `scheduled_at`  datetime         DEFAULT NULL,
  `resolved_at`   datetime         DEFAULT NULL,
  `reported_by`   int(10) unsigned NOT NULL,
  `assigned_to`   int(10) unsigned DEFAULT NULL,
  `resolved_by`   int(10) unsigned DEFAULT NULL,
  `deleted_at`    timestamp        NULL DEFAULT NULL,
  `created_by`    int(10) unsigned NOT NULL,
  `updated_by`    int(10) unsigned DEFAULT NULL,
  `created_at`    timestamp        NULL DEFAULT current_timestamp(),
  `updated_at`    timestamp        NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_maintenance_fk_company`     FOREIGN KEY (`company_id`)   REFERENCES `rms_companies`  (`id`),
  CONSTRAINT `rms_maintenance_fk_apartment`   FOREIGN KEY (`apartment_id`) REFERENCES `rms_apartments` (`id`),
  CONSTRAINT `rms_maintenance_fk_invoice`     FOREIGN KEY (`invoice_id`)   REFERENCES `rms_invoices`   (`id`) ON DELETE SET NULL,
  CONSTRAINT `rms_maintenance_fk_reported_by` FOREIGN KEY (`reported_by`)  REFERENCES `rms_users`      (`id`),
  CONSTRAINT `rms_maintenance_fk_assigned_to` FOREIGN KEY (`assigned_to`)  REFERENCES `rms_users`      (`id`) ON DELETE SET NULL,
  CONSTRAINT `rms_maintenance_fk_resolved_by` FOREIGN KEY (`resolved_by`)  REFERENCES `rms_users`      (`id`) ON DELETE SET NULL,
  CONSTRAINT `rms_maintenance_fk_created_by`  FOREIGN KEY (`created_by`)   REFERENCES `rms_users`      (`id`),
  CONSTRAINT `rms_maintenance_fk_updated_by`  FOREIGN KEY (`updated_by`)   REFERENCES `rms_users`      (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- 19. NOTIFICATIONS
-- ============================================================
DROP TABLE IF EXISTS `rms_notifications`;
CREATE TABLE `rms_notifications` (
  `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `user_id`    int(10) unsigned NOT NULL,
  `type`       varchar(50)      NOT NULL,
  `message`    text             NOT NULL,
  `url`        varchar(255)     DEFAULT NULL,
  `is_read`    tinyint(1)       DEFAULT 0,
  `read_at`    timestamp        NULL DEFAULT NULL,
  `created_at` timestamp        NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `rms_notifications_fk_company` FOREIGN KEY (`company_id`) REFERENCES `rms_companies` (`id`),
  CONSTRAINT `rms_notifications_fk_user`    FOREIGN KEY (`user_id`)    REFERENCES `rms_users`     (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- INDEXES
-- ============================================================
ALTER TABLE `rms_leases`       ADD INDEX `idx_lease_status`     (`status`);
ALTER TABLE `rms_leases`       ADD INDEX `idx_lease_apartment`  (`apartment_id`, `status`);
ALTER TABLE `rms_invoices`     ADD INDEX `idx_invoice_due`      (`due_date`);
ALTER TABLE `rms_invoices`     ADD INDEX `idx_invoice_status`   (`status`);
ALTER TABLE `rms_invoices`     ADD INDEX `idx_invoice_tenant`   (`tenant_id`);
ALTER TABLE `rms_apartments`   ADD INDEX `idx_apt_status`       (`building_id`, `status`);
ALTER TABLE `rms_tenants`      ADD INDEX `idx_tenant_company`   (`company_id`, `is_active`);
ALTER TABLE `rms_maintenance`  ADD INDEX `idx_maint_status`     (`status`);
ALTER TABLE `rms_notifications` ADD INDEX `idx_notif_user`      (`user_id`, `is_read`);


SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- SUMMARY
-- ============================================================
-- Tables (19 total):
--   1.  rms_companies              — multi-company root
--   2.  rms_roles                  — super_admin, admin etc
--   3.  rms_permissions            — master permission list
--   4.  rms_countries              — global
--   5.  rms_cities                 — global
--   6.  rms_apartment_types        — global
--   7.  rms_users                  — users with role + company
--   8.  rms_role_permissions       — permissions per role
--   9.  rms_user_permissions       — per-user permission overrides
--   10. rms_tenants                — company-scoped
--   11. rms_buildings              — company-scoped
--   12. rms_apartments             — company-scoped
--   13. rms_leases                 — company-scoped
--   14. rms_invoices               — company-scoped
--   15. rms_invoice_details        — company-scoped
--   16. rms_moneyreceipts          — company-scoped (merged with payments)
--   17. rms_moneyreceipt_details   — company-scoped
--   18. rms_maintenance            — company-scoped
--   19. rms_notifications          — company-scoped
-- ============================================================
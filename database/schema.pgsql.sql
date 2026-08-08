-- Bright Today Foundation — LOCAL DEV ONLY schema (PostgreSQL)
-- Production uses schema.sql (MySQL/MariaDB on cPanel). This file is a straight
-- structural translation so the app can be developed/tested locally against
-- PostgreSQL. Keep both files in sync when columns change.
-- Booleans use SMALLINT (0/1) instead of native BOOLEAN so PHP code that reads
-- is_active/is_public/etc. behaves identically against either driver.

CREATE TABLE IF NOT EXISTS admins (
    id SERIAL PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    username VARCHAR(60) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'editor' CHECK (role IN ('super_admin','editor')),
    is_active SMALLINT NOT NULL DEFAULT 1,
    failed_login_attempts SMALLINT NOT NULL DEFAULT 0,
    locked_until TIMESTAMP NULL DEFAULT NULL,
    last_login_at TIMESTAMP NULL DEFAULT NULL,
    last_login_ip VARCHAR(45) NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin_password_resets (
    id SERIAL PRIMARY KEY,
    admin_id INT NOT NULL REFERENCES admins(id) ON DELETE CASCADE,
    token_hash VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    used_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS login_attempts (
    id SERIAL PRIMARY KEY,
    identifier VARCHAR(190) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent VARCHAR(255) NULL DEFAULT NULL,
    success SMALLINT NOT NULL DEFAULT 0,
    attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_login_attempts_identifier ON login_attempts (identifier, attempted_at);
CREATE INDEX IF NOT EXISTS idx_login_attempts_ip ON login_attempts (ip_address, attempted_at);

CREATE TABLE IF NOT EXISTS activity_log (
    id SERIAL PRIMARY KEY,
    admin_id INT NULL REFERENCES admins(id) ON DELETE SET NULL,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(60) NULL DEFAULT NULL,
    entity_id INT NULL DEFAULT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_activity_created ON activity_log (created_at);

CREATE TABLE IF NOT EXISTS site_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS seo_meta (
    id SERIAL PRIMARY KEY,
    page_key VARCHAR(100) NOT NULL UNIQUE,
    meta_title VARCHAR(200) NULL DEFAULT NULL,
    meta_description VARCHAR(500) NULL DEFAULT NULL,
    og_image VARCHAR(255) NULL DEFAULT NULL,
    canonical_url VARCHAR(255) NULL DEFAULT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS content_blocks (
    id SERIAL PRIMARY KEY,
    page_key VARCHAR(60) NOT NULL,
    block_key VARCHAR(100) NOT NULL,
    block_type VARCHAR(20) NOT NULL DEFAULT 'text' CHECK (block_type IN ('text','richtext','image','url')),
    label VARCHAR(150) NOT NULL,
    content_text TEXT NULL,
    image_path VARCHAR(255) NULL DEFAULT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    updated_by INT NULL REFERENCES admins(id) ON DELETE SET NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (page_key, block_key)
);

CREATE TABLE IF NOT EXISTS focus_areas (
    id SERIAL PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(160) NOT NULL UNIQUE,
    goal_text TEXT NULL,
    action_text TEXT NULL,
    long_description TEXT NULL,
    icon_path VARCHAR(255) NULL DEFAULT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active SMALLINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS team_members (
    id SERIAL PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    role_title VARCHAR(120) NULL DEFAULT NULL,
    bio TEXT NULL,
    quote TEXT NULL,
    photo_path VARCHAR(255) NULL DEFAULT NULL,
    social_links TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active SMALLINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS faqs (
    id SERIAL PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active SMALLINT NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS stats_counters (
    id SERIAL PRIMARY KEY,
    label VARCHAR(120) NOT NULL,
    number_value INT NOT NULL DEFAULT 0,
    suffix VARCHAR(10) NULL DEFAULT NULL,
    icon_path VARCHAR(255) NULL DEFAULT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active SMALLINT NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS testimonials (
    id SERIAL PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    role_or_location VARCHAR(150) NULL DEFAULT NULL,
    photo_path VARCHAR(255) NULL DEFAULT NULL,
    quote TEXT NOT NULL,
    is_featured SMALLINT NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    is_active SMALLINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS blog_categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS blog_posts (
    id SERIAL PRIMARY KEY,
    category_id INT NULL REFERENCES blog_categories(id) ON DELETE SET NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    excerpt VARCHAR(500) NULL DEFAULT NULL,
    body TEXT NOT NULL,
    featured_image VARCHAR(255) NULL DEFAULT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'draft' CHECK (status IN ('draft','published')),
    published_at TIMESTAMP NULL DEFAULT NULL,
    author_admin_id INT NULL REFERENCES admins(id) ON DELETE SET NULL,
    meta_title VARCHAR(200) NULL DEFAULT NULL,
    meta_description VARCHAR(500) NULL DEFAULT NULL,
    views_count INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_posts_status_published ON blog_posts (status, published_at);

CREATE TABLE IF NOT EXISTS gallery_albums (
    id SERIAL PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(160) NOT NULL UNIQUE,
    cover_image VARCHAR(255) NULL DEFAULT NULL,
    description TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active SMALLINT NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS gallery_images (
    id SERIAL PRIMARY KEY,
    album_id INT NULL REFERENCES gallery_albums(id) ON DELETE SET NULL,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255) NULL DEFAULT NULL,
    alt_text VARCHAR(255) NULL DEFAULT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active SMALLINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contact_submissions (
    id SERIAL PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(20) NULL DEFAULT NULL,
    subject VARCHAR(200) NULL DEFAULT NULL,
    message TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'new' CHECK (status IN ('new','read','responded','archived')),
    ip_address VARCHAR(45) NULL DEFAULT NULL,
    user_agent VARCHAR(255) NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_contact_status ON contact_submissions (status);

CREATE TABLE IF NOT EXISTS volunteer_partner_submissions (
    id SERIAL PRIMARY KEY,
    submission_type VARCHAR(20) NOT NULL CHECK (submission_type IN ('volunteer','partner')),
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(20) NULL DEFAULT NULL,
    organization_name VARCHAR(150) NULL DEFAULT NULL,
    area_of_interest VARCHAR(150) NULL DEFAULT NULL,
    message TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'new' CHECK (status IN ('new','contacted','onboarded','archived')),
    admin_notes TEXT NULL,
    ip_address VARCHAR(45) NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_vp_type_status ON volunteer_partner_submissions (submission_type, status);

CREATE TABLE IF NOT EXISTS donation_pledges (
    id SERIAL PRIMARY KEY,
    donor_name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NULL DEFAULT NULL,
    phone VARCHAR(20) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency CHAR(3) NOT NULL DEFAULT 'INR',
    mode VARCHAR(20) NOT NULL DEFAULT 'upi' CHECK (mode IN ('bank_transfer','upi','cash','other')),
    reference_utr VARCHAR(100) NULL DEFAULT NULL,
    message TEXT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'new' CHECK (status IN ('new','contacted','confirmed','closed')),
    admin_notes TEXT NULL,
    is_gateway_payment SMALLINT NOT NULL DEFAULT 0,
    payment_gateway VARCHAR(30) NULL DEFAULT NULL,
    gateway_order_id VARCHAR(100) NULL DEFAULT NULL,
    gateway_payment_id VARCHAR(100) NULL DEFAULT NULL,
    gateway_signature VARCHAR(255) NULL DEFAULT NULL,
    gateway_status VARCHAR(30) NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_pledges_status ON donation_pledges (status);

CREATE TABLE IF NOT EXISTS legal_documents (
    id SERIAL PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    doc_type VARCHAR(30) NOT NULL DEFAULT 'Other' CHECK (doc_type IN ('12A','80G','PAN','Trust Deed','Registration Certificate','Other')),
    file_path VARCHAR(255) NOT NULL,
    description TEXT NULL,
    is_public SMALLINT NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    uploaded_by INT NULL REFERENCES admins(id) ON DELETE SET NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

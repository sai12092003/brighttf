-- Bright Today Foundation — Seed Data (PostgreSQL / LOCAL DEV ONLY)
-- Run AFTER schema.sql. Contains real org content extracted from the
-- foundation's source documents, plus one default super_admin account.
--
-- *** SECURITY: change the seeded admin password immediately after first
-- login. Default login is username "admin" / password "BrightToday@2026". ***

-- (PostgreSQL uses UTF8 by default; no SET NAMES needed)

-- ---------------------------------------------------------------------
-- Default admin
-- ---------------------------------------------------------------------
INSERT INTO admins (name, email, username, password_hash, role, is_active)
VALUES (
    'Bright Today Admin',
    'brighttfhead@gmail.com',
    'admin',
    '$argon2id$v=19$m=65536,t=4,p=1$bXJpY3VRVVhPQWI1SWNvZA$vpK9o5hXeM8KFXiggkzdukgtXoNkM4jz3Dp3qtx+LIs',
    'super_admin',
    1
);

-- ---------------------------------------------------------------------
-- Site settings
-- ---------------------------------------------------------------------
INSERT INTO site_settings (setting_key, setting_value) VALUES
('org_name', 'Bright Today Foundation'),
('org_tagline', 'Building a brighter, self-sufficient tomorrow'),
('contact_email', 'brighttfhead@gmail.com'),
('contact_phone_1', '+91 84288 28898'),
('contact_phone_2', '+91 97878 88851'),
('office_address_public', 'No. 36, Gandhi Street, Kannan Bajanai Kovil Near, Mudichur, Mannivakkam B.O, Mudichur, Kanchipuram, Tamil Nadu, India - 600048'),
('registered_address_trust_deed', '380/6, Seenivasa Nagar, 6th Street, Inam Maniyachi, Thoothukudi, Tamil Nadu - 628502'),
('pan_number', 'AAGTB1235J'),
('reg_12a_number', 'AAGTB1235JE20251'),
('reg_12a_validity', 'AY 2026-27 to AY 2028-29 (provisional, granted 27-11-2025)'),
('reg_80g_number', 'AAGTB1235JF20251'),
('reg_80g_validity', 'AY 2026-27 to AY 2028-29 (provisional, granted 27-11-2025)'),
('social_facebook', ''),
('social_instagram', ''),
('social_twitter', ''),
('social_youtube', ''),
('social_linkedin', ''),
('donation_bank_account_name', 'Bright Today Foundation'),
('donation_bank_account_number', ''),
('donation_bank_ifsc', ''),
('donation_bank_name', ''),
('donation_upi_id', ''),
('donation_upi_qr_image', ''),
('google_maps_embed_url', ''),
('google_analytics_id', ''),
('default_meta_title', 'Bright Today Foundation | Education, Environment & Women & Child Welfare'),
('default_meta_description', 'Bright Today Foundation is a registered Indian trust (12A & 80G approved) empowering underprivileged communities through education, environmental sustainability, and women & child welfare programs.'),
('default_og_image', 'assets/img/og-default.jpg'),
('footer_about_text', 'Bright Today Foundation was founded in 2025 by a passionate group of friends who believed that every underprivileged individual deserves a chance at a better life. We bridge the gap between passion and purpose by empowering youth to drive sustainable, ground-level change.'),
('footer_copyright_text', '© 2026 Bright Today Foundation. All rights reserved.'),
('maintenance_mode', '0');

-- ---------------------------------------------------------------------
-- Focus areas (3 core pillars)
-- ---------------------------------------------------------------------
INSERT INTO focus_areas (title, slug, goal_text, action_text, long_description, sort_order, is_active) VALUES
('Quality Education', 'quality-education',
 'Breaking the cycle of poverty through learning.',
 'Providing tutoring, resources, and educational mentorship to underprivileged children to ensure they stay in school and thrive.',
 'We believe education is the single most powerful lever against generational poverty. Our education programs pair underprivileged children with mentors, provide learning resources and school supplies, and work directly with families to keep children enrolled and thriving in school rather than dropping out to work.',
 1, 1),
('Environmental Sustainability', 'environmental-sustainability',
 'Protecting our planet for future generations.',
 'Leading community-driven green initiatives, tree plantation drives, and waste management awareness campaigns.',
 'A brighter tomorrow needs a livable planet. We organize community-driven tree plantation drives and run waste-management awareness campaigns that get local residents, schools, and volunteers directly involved in protecting the environment they live in.',
 2, 1),
('Women & Child Welfare', 'women-child-welfare',
 'Ensuring safety, health, and independence.',
 'Implementing skill-development programs for women''s financial independence, alongside health and nutrition camps for vulnerable children.',
 'True empowerment means dignity and independence. We run skill-development programs that help women build financial independence, and organize health and nutrition camps to support the wellbeing of vulnerable children in the communities we serve.',
 3, 1);

-- ---------------------------------------------------------------------
-- Team members (Founder & Co-Founder)
-- ---------------------------------------------------------------------
INSERT INTO team_members (name, role_title, bio, quote, sort_order, is_active) VALUES
('Jothilakshmi', 'Founder',
 'Before starting Bright Today Foundation, Jothilakshmi spent years in grassroots social work and saw how programs often fail when they are not built with the community they serve. What changed everything was meeting a bright young girl who had to leave school at twelve because her family could not afford supplies and uniforms. That moment pushed her to gather a small group of volunteers and experts and build the support system that has since grown into Bright Today Foundation.',
 'Our work is far from finished. We are not building quick fixes. We are investing in real, lasting growth, one child, one family, and one community at a time.',
 1, 1),
('Yasotha', 'Co-Founder',
 'Yasotha brings a strong background in organizational management to Bright Today Foundation. She leads our partnerships, guides our volunteer network, and keeps our programs accountable, so every rupee and every hour reaches the people who need it most.',
 'Building this foundation with Jothilakshmi was an easy decision. We both believe real change takes practical, patient work, and every day we try to build something that lasts.',
 2, 1);

-- ---------------------------------------------------------------------
-- Stats counters (kept to verifiable facts — no fabricated impact numbers)
-- ---------------------------------------------------------------------
INSERT INTO stats_counters (label, number_value, suffix, sort_order, is_active) VALUES
('Founded', 2025, '', 1, 1),
('Core Focus Areas', 3, '', 2, 1),
('Tax Registrations (12A & 80G)', 2, '', 3, 1);

-- ---------------------------------------------------------------------
-- FAQs
-- ---------------------------------------------------------------------
INSERT INTO faqs (question, answer, sort_order, is_active) VALUES
('Is Bright Today Foundation a registered organization?', 'Yes. Bright Today Foundation is a registered charitable trust in India (PAN: AAGTB1235J) with provisional 12A registration and 80G approval from the Income Tax Department. See our Transparency & Legal page for registration numbers and downloadable certificates.', 1, 1),
('Is my donation eligible for a tax deduction?', 'Yes. Bright Today Foundation holds provisional 80G approval (Unique Registration Number AAGTB1235JF20251), which means eligible donations can qualify for a tax deduction under Section 80G of the Income Tax Act, 1961.', 2, 1),
('How can I volunteer with the foundation?', 'Visit our Get Involved page and submit the volunteer form with your area of interest. Our team will reach out to discuss current opportunities across our education, environment, and women & child welfare programs.', 3, 1),
('How can my organization partner with Bright Today Foundation?', 'We welcome corporate and organizational partnerships. Submit the partner form on our Get Involved page, or write to us directly at brighttfhead@gmail.com, and our team will follow up.', 4, 1),
('How do I make a donation?', 'Visit our Donate page for bank transfer and UPI details. After donating, you can fill in the short confirmation form so our team can follow up and issue an acknowledgement.', 5, 1);

-- ---------------------------------------------------------------------
-- Content blocks (full CMS copy — admin-editable afterwards)
-- ---------------------------------------------------------------------
INSERT INTO content_blocks (page_key, block_key, block_type, label, content_text, sort_order) VALUES
-- Home
('home', 'hero_title', 'text', 'Hero Title', 'Every Child Deserves a Brighter Today', 1),
('home', 'hero_subtitle', 'text', 'Hero Subtitle', 'We walk alongside communities across India, nurturing education, protecting our environment, and standing beside women and children so every family can build a future full of hope. This is not charity that fades. It is change that lasts.', 2),
('home', 'hero_cta_text', 'text', 'Hero CTA Button Text', 'Donate Now', 3),
('home', 'hero_cta_link', 'url', 'Hero CTA Button Link', '/donate', 4),
('home', 'hero_secondary_cta_text', 'text', 'Hero Secondary Button Text', 'Get Involved', 5),
('home', 'hero_secondary_cta_link', 'url', 'Hero Secondary Button Link', '/get-involved', 6),
('home', 'intro_heading', 'text', 'Intro Section Heading', 'A Movement Built on Purpose', 7),
('home', 'intro_text', 'richtext', 'Intro Section Text', 'Bright Today Foundation was founded in 2025 by a passionate group of friends who believed that every underprivileged individual deserves a chance at a better life. What began as a shared conviction has quickly transformed into a powerful volunteering movement for India''s younger generation. We bridge the gap between passion and purpose by empowering youth to drive sustainable, ground-level change.', 8),
('home', 'focus_areas_heading', 'text', 'Focus Areas Section Heading', 'Our Core Focus Areas', 9),
('home', 'get_involved_cta_heading', 'text', 'Get Involved CTA Heading', 'Your Involvement Matters', 10),
('home', 'get_involved_cta_text', 'richtext', 'Get Involved CTA Text', 'Join hands with us to volunteer, partner, or support our upcoming initiatives.', 11),

-- About
('about', 'about_heading', 'text', 'About Heading', 'About Bright Today Foundation', 1),
('about', 'about_body', 'richtext', 'About Body', 'Bright Today Foundation was founded in 2025 by a passionate group of friends who believed that every underprivileged individual deserves a chance at a better life. What began as a shared conviction has quickly transformed into a powerful volunteering movement for India''s younger generation. We bridge the gap between passion and purpose by empowering youth to drive sustainable, ground-level change.', 2),
('about', 'vision_heading', 'text', 'Vision Heading', 'Our Vision', 3),
('about', 'vision_text', 'richtext', 'Vision Text', 'To build an inclusive society where education is accessible, the environment is preserved, and women and children live with dignity and equal opportunity.', 4),
('about', 'origin_heading', 'text', 'Origin Story Heading', 'Our Origin Story: Built on Purpose', 5),
('about', 'origin_intro', 'richtext', 'Origin Story Intro', 'Every organization starts with a spark. For Bright Today Foundation, that spark was ignited by our founder, Jothilakshmi.', 6),
('about', 'registered_office_note', 'text', 'Registered Office Note', 'Registered office: No. 36, Gandhi Street, Mudichur, Kanchipuram, Tamil Nadu - 600048.', 7),

-- Get Involved
('get_involved', 'heading', 'text', 'Page Heading', 'Get Involved', 1),
('get_involved', 'intro_text', 'richtext', 'Intro Text', 'Your involvement matters. Join hands with us to volunteer, partner, or support our upcoming initiatives.', 2),
('get_involved', 'volunteer_heading', 'text', 'Volunteer Section Heading', 'Volunteer With Us', 3),
('get_involved', 'volunteer_intro', 'richtext', 'Volunteer Section Intro', 'Lend your time and skills to our education, environment, or women & child welfare programs. Tell us your area of interest and we''ll get in touch.', 4),
('get_involved', 'partner_heading', 'text', 'Partner Section Heading', 'Partner With Us', 5),
('get_involved', 'partner_intro', 'richtext', 'Partner Section Intro', 'We welcome corporate and organizational partners who share our commitment to sustainable, ground-level change.', 6),

-- Donate
('donate', 'heading', 'text', 'Page Heading', 'Support Our Work', 1),
('donate', 'intro_text', 'richtext', 'Intro Text', 'Every contribution helps us break the cycle of poverty through education, protect the environment, and support women & children in need.', 2),
('donate', 'tax_benefit_note', 'richtext', 'Tax Benefit Note', 'Bright Today Foundation holds provisional 80G approval (Reg. No. AAGTB1235JF20251), so eligible donations may qualify for a tax deduction under Section 80G of the Income Tax Act, 1961.', 3),
('donate', 'bank_details_note', 'richtext', 'Bank/UPI Details Note', 'Bank transfer and UPI details are available below. Online card/UPI checkout is coming soon.', 4),
('donate', 'pledge_form_heading', 'text', 'Pledge Form Heading', 'Already Donated? Let Us Know', 5),

-- Global / footer
('global', 'site_tagline', 'text', 'Site Tagline', 'Education. Environment. Empowerment.', 1),
('global', 'announcement_bar_text', 'text', 'Announcement Bar Text (leave blank to hide)', '', 2),

-- Privacy Policy (boilerplate — recommend legal review before publishing)
('privacy_policy', 'body', 'richtext', 'Privacy Policy Body', '<h2>Privacy Policy</h2><p>Bright Today Foundation ("we", "us", "our") respects your privacy. This policy explains what information we collect through this website and how we use it.</p><h3>Information We Collect</h3><p>We collect information you voluntarily provide through our Contact, Volunteer, Partner, and Donation forms, such as your name, email address, phone number, and message content.</p><h3>How We Use Information</h3><p>We use this information solely to respond to your inquiry, process volunteer/partner applications, and follow up on donation pledges. We do not sell or rent your personal information to third parties.</p><h3>Data Security</h3><p>We take reasonable technical and organizational measures to protect the information you share with us.</p><h3>Contact Us</h3><p>For any privacy-related questions, contact us at brighttfhead@gmail.com.</p>', 1),

-- Terms of Use (boilerplate — recommend legal review before publishing)
('terms', 'body', 'richtext', 'Terms of Use Body', '<h2>Terms of Use</h2><p>By using this website, you agree to the following terms.</p><h3>Use of Content</h3><p>All content on this website, including text, images, and the Bright Today Foundation logo, is the property of Bright Today Foundation unless otherwise stated, and may not be reproduced without permission.</p><h3>Donations</h3><p>Donations made to Bright Today Foundation are voluntary contributions to support our charitable activities. Please retain your donation reference/receipt for tax purposes.</p><h3>No Warranty</h3><p>This website is provided "as is" without warranties of any kind.</p><h3>Contact</h3><p>Questions about these terms can be sent to brighttfhead@gmail.com.</p>', 1),

-- 404
('error_404', 'heading', 'text', '404 Heading', 'Page Not Found', 1),
('error_404', 'message', 'text', '404 Message', 'The page you''re looking for doesn''t exist or may have moved.', 2),
('error_404', 'cta_text', 'text', '404 CTA Text', 'Back to Home', 3),
('error_404', 'cta_link', 'url', '404 CTA Link', '/', 4);

-- ---------------------------------------------------------------------
-- Legal documents (Transparency page). NOTE: the Trust Deed scan is
-- intentionally NOT seeded here because it contains the founder's Aadhaar
-- number in full — it must stay private unless redacted first.
-- ---------------------------------------------------------------------
INSERT INTO legal_documents (title, doc_type, file_path, description, is_public, sort_order, uploaded_by) VALUES
('12A Registration Certificate', '12A', 'legal/12a-registration-certificate.pdf', 'Provisional registration under Section 12A, Unique Registration Number AAGTB1235JE20251, valid AY 2026-27 to AY 2028-29.', 1, 1, 1),
('12A Registration Certificate (Digitally Signed Copy)', '12A', 'legal/12a-registration-certificate-signed.pdf', 'Digitally signed archival copy of the 12A registration certificate.', 1, 2, 1),
('80G Registration Certificate', '80G', 'legal/80g-registration-certificate.pdf', 'Provisional approval under Section 80G, Unique Registration Number AAGTB1235JF20251, valid AY 2026-27 to AY 2028-29. Donations may be eligible for tax deduction.', 1, 3, 1);

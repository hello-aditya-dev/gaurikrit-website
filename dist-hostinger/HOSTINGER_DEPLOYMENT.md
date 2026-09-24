# Gaurikrit Bio Products — Hostinger Deployment Guide

This guide assumes you have purchased a Hostinger Starter/shared-hosting plan and connected your domain (gaurikrit.com).

## Quick deploy (15 minutes)

### 1. Open the File Manager
- Log in to Hostinger hPanel.
- Go to **Files → File Manager**.
- Open the **`public_html`** folder (create it if missing).

### 2. Upload the deployment package
- Upload the contents of the `gaurikrit-hostinger-deploy.zip` into `public_html`.
- **Extract** the zip inside `public_html`.
- After extraction, `public_html` should directly contain:
  ```
  public_html/
    index.php
    .htaccess
    404.php
    sitemap.xml
    robots.txt
    config.example.php
    includes/
    assets/
    products/
    why-prakritik/
    about/
    for-business/
    contact/
    downloads/
    api/
  ```
- **Delete the zip** after extraction.

### 3. Select PHP version
- In hPanel go to **Advanced → PHP Configuration**.
- Set PHP version to **8.2 or higher** (8.3 recommended).

### 4. Configure SMTP credentials
- In `public_html`, **copy** `config.example.php` to `config.php`.
- **Edit** `config.php` and fill in:
  ```php
  'smtp_host'     => 'smtp.gmail.com',         // or your Hostinger mail server
  'smtp_port'     => 587,
  'smtp_username' => 'your-email@gmail.com',
  'smtp_password' => 'your-app-password',
  'smtp_encryption' => 'tls',
  'mail_from'     => 'your-email@gmail.com',
  'mail_from_name'=> 'Gaurikrit Bio Products',
  'mail_to'       => 'seva@gaurikrit.com',
  'site_url'      => 'https://gaurikrit.com',
  'debug'         => false,
  ```

### 5. Enable SSL
- In hPanel go to **Security → SSL**.
- Enable free SSL for your domain.

### 6. Test the contact form
- Visit `https://gaurikrit.com/contact/`.
- Fill and submit the form.
- Confirm you receive the email at your configured `mail_to` address.
- If no email arrives, check `config.php` SMTP settings and Hostinger's email logs.

### 7. Test the business form
- Visit `https://gaurikrit.com/for-business/`.
- Fill and submit.
- Confirm email delivery.

### 8. Test every page
- `/` (homepage)
- `/products/` → `/products/prakritik-distemper/` → `/products/prakritik-emulsion/`
- `/why-prakritik/`
- `/about/`
- `/for-business/`
- `/contact/`
- `/downloads/`
- Visit a non-existent URL → should show branded 404.

### 9. Check mobile
- Open the site on a phone. Verify the mobile menu opens, forms are usable, layout is responsive.

### 10. Submit sitemap to Search Console
- Submit `https://gaurikrit.com/sitemap.xml` to Google Search Console.

## Optional: MySQL database (enquiry storage)

If you want to store enquiries in a database (email still works without this):

### 1. Create the database
- In hPanel go to **Databases → MySQL Databases**.
- Create a new database and user. Grant the user full access to the database.

### 2. Create tables
- Open phpMyAdmin.
- Run this SQL:
  ```sql
  CREATE TABLE contact_enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    email VARCHAR(254) NOT NULL,
    phone VARCHAR(20),
    interest VARCHAR(30),
    message TEXT,
    ip VARCHAR(45),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
  );

  CREATE TABLE business_enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    organisation VARCHAR(120) NOT NULL,
    role VARCHAR(80),
    phone VARCHAR(20),
    email VARCHAR(254) NOT NULL,
    city VARCHAR(80),
    project_type VARCHAR(50),
    approximate_requirement VARCHAR(100),
    message TEXT,
    ip VARCHAR(45),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
  );
  ```

### 3. Add DB credentials to config.php
  ```php
  'db_host' => 'localhost',
  'db_name' => 'your_db_name',
  'db_user' => 'your_db_user',
  'db_pass' => 'your_db_password',
  ```

The forms will now store enquiries in the database **in addition to** sending emails. If DB credentials are absent, forms still send emails.

## Adding real product images later

The site uses coded SVG illustrations as fallbacks. When real photography is ready:

1. Upload images to:
   - `/assets/products/prakritik-distemper.png`
   - `/assets/products/prakritik-emulsion.png`
   - `/assets/brand/gaurikrit-logo-full.png`
   - `/assets/brand/gaurikrit-logo-mark.png`
2. The JavaScript automatically detects loaded images and shows them instead of the SVG fallback. No code change needed.

## Troubleshooting

**Contact form says success but no email arrives:**
- Check `config.php` SMTP credentials.
- Hostinger may require you to use their mail server (`smtp.hostinger.com`) for outbound.
- Check `debug => true` in config to log SMTP errors.

**500 error on a page:**
- Ensure PHP 8.2+ is selected.
- Check that `config.php` exists (copy from `config.example.php`).
- Check file permissions: folders 755, files 644.

**404 on clean URLs:**
- Ensure `.htaccess` is uploaded (hidden file — enable "show hidden files" in File Manager).
- Ensure `mod_rewrite` is enabled (it is by default on Hostinger).

**Images not showing:**
- Real images go in `/assets/products/` and `/assets/brand/` — the SVG fallback shows until they're uploaded.
